<?php
/**
 * Admin utilities
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.1
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) {
	exit; }


//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

// Theme init priorities:
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)

if ( ! function_exists( 'piqes_admin_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'piqes_admin_theme_setup' );
	function piqes_admin_theme_setup() {
		// Add theme icons
		add_action( 'admin_footer', 'piqes_admin_footer' );

		// Enqueue scripts and styles for admin
		add_action( 'admin_enqueue_scripts', 'piqes_admin_scripts' );
		add_action( 'admin_footer', 'piqes_admin_localize_scripts' );

		// Show admin notice with control panel
		add_action( 'admin_notices', 'piqes_admin_notice' );
		add_action( 'wp_ajax_piqes_hide_admin_notice', 'piqes_callback_hide_admin_notice' );

		// Show admin notice with "Rate Us" panel
		add_action( 'after_switch_theme', 'piqes_save_activation_date' );
		add_action( 'admin_notices', 'piqes_rate_notice' );
		add_action( 'wp_ajax_piqes_hide_rate_notice', 'piqes_callback_hide_rate_notice' );

		// TGM Activation plugin
		add_action( 'tgmpa_register', 'piqes_register_plugins' );

		// Init internal admin messages
		piqes_init_admin_messages();
	}
}


//-------------------------------------------------------
//-- Welcome notice
//-------------------------------------------------------

// Show admin notice
if ( ! function_exists( 'piqes_admin_notice' ) ) {
	//Handler of the add_action('admin_notices', 'piqes_admin_notice', 2);
	function piqes_admin_notice() {
		if ( piqes_exists_trx_addons()
			|| in_array( piqes_get_value_gp( 'action' ), array( 'vc_load_template_preview' ) )
			|| piqes_get_value_gp( 'page' ) == 'piqes_about'
			|| ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}
		$show = get_option( 'piqes_admin_notice' );
		if ( false !== $show && 0 == (int) $show ) {
			return;
		}
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/admin-notice' ) );
	}
}

// Hide admin notice
if ( ! function_exists( 'piqes_callback_hide_admin_notice' ) ) {
	//Handler of the add_action('wp_ajax_piqes_hide_admin_notice', 'piqes_callback_hide_admin_notice');
	function piqes_callback_hide_admin_notice() {
		if ( wp_verify_nonce( piqes_get_value_gp( 'nonce' ), admin_url( 'admin-ajax.php' ) ) ) {
			update_option( 'piqes_admin_notice', '0' );
		}
		die();
	}
}


//-------------------------------------------------------
//-- "Rate Us" notice
//-------------------------------------------------------

// Save activation date
if ( ! function_exists( 'piqes_save_activation_date' ) ) {
	//Handler of the add_action('after_switch_theme', 'piqes_save_activation_date');
	function piqes_save_activation_date() {
		$theme_time = (int) get_option( 'piqes_theme_activated' );
		if ( 0 == $theme_time ) {
			$theme_slug      = get_option( 'template' );
			$stylesheet_slug = get_option( 'stylesheet' );
			if ( $theme_slug == $stylesheet_slug ) {
				update_option( 'piqes_theme_activated', time() );
			}
		}
	}
}

// Show Rate Us notice
if ( ! function_exists( 'piqes_rate_notice' ) ) {
	//Handler of the add_action('admin_notices', 'piqes_rate_notice', 2);
	function piqes_rate_notice() {
		if ( in_array( piqes_get_value_gp( 'action' ), array( 'vc_load_template_preview' ) ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}
		// Display the message only on specified screens
		$allowed = array( 'dashboard', 'theme_options', 'trx_addons_options' );
		$screen  = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
		if ( ( is_object( $screen ) && ! empty( $screen->id ) && in_array( $screen->id, $allowed ) ) || in_array( piqes_get_value_gp( 'page' ), $allowed ) ) {
			$show  = get_option( 'piqes_rate_notice' );
			$start = get_option( 'piqes_theme_activated' );
			if ( ( false !== $show && 0 == (int) $show ) || ( $start > 0 && ( time() - $start ) / ( 24 * 3600 ) < 14 ) ) {
				return;
			}
			get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/admin-rate' ) );
		}
	}
}

// Hide rate notice
if ( ! function_exists( 'piqes_callback_hide_rate_notice' ) ) {
	//Handler of the add_action('wp_ajax_piqes_hide_rate_notice', 'piqes_callback_hide_rate_notice');
	function piqes_callback_hide_rate_notice() {
		if ( wp_verify_nonce( piqes_get_value_gp( 'nonce' ), admin_url( 'admin-ajax.php' ) ) ) {
			update_option( 'piqes_rate_notice', '0' );
		}
		die();
	}
}


//-------------------------------------------------------
//-- Internal messages
//-------------------------------------------------------

// Init internal admin messages
if ( ! function_exists( 'piqes_init_admin_messages' ) ) {
	function piqes_init_admin_messages() {
		$msg = get_option( 'piqes_admin_messages' );
		if ( is_array( $msg ) ) {
			update_option( 'piqes_admin_messages', '' );
		} else {
			$msg = array();
		}
		piqes_storage_set( 'admin_messages', $msg );
	}
}

// Add internal admin message
if ( ! function_exists( 'piqes_add_admin_message' ) ) {
	function piqes_add_admin_message( $text, $type = 'success', $cur_session = false ) {
		if ( ! empty( $text ) ) {
			$new_msg = array(
				'message' => $text,
				'type'    => $type,
			);
			if ( $cur_session ) {
				piqes_storage_push_array( 'admin_messages', '', $new_msg );
			} else {
				$msg = get_option( 'piqes_admin_messages' );
				if ( ! is_array( $msg ) ) {
					$msg = array();
				}
				$msg[] = $new_msg;
				update_option( 'piqes_admin_messages', $msg );
			}
		}
	}
}

// Show internal admin messages
if ( ! function_exists( 'piqes_show_admin_messages' ) ) {
	function piqes_show_admin_messages() {
		$msg = piqes_storage_get( 'admin_messages' );
		if ( ! is_array( $msg ) || count( $msg ) == 0 ) {
			return;
		}
		?>
		<div class="piqes_admin_messages">
			<?php
			foreach ( $msg as $m ) {
				?>
				<div class="piqes_admin_message_item <?php echo esc_attr( str_replace( 'success', 'updated', $m['type'] ) ); ?>">
					<p><?php echo wp_kses_data( $m['message'] ); ?></p>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
}


//-------------------------------------------------------
//-- Styles and scripts
//-------------------------------------------------------

// Load inline styles
if ( ! function_exists( 'piqes_admin_footer' ) ) {
	//Handler of the add_action('admin_footer', 'piqes_admin_footer');
	function piqes_admin_footer() {
		// Get current screen
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
		if ( is_object( $screen ) && 'nav-menus' == $screen->id ) {
			piqes_show_layout(
				piqes_show_custom_field(
					'piqes_icons_popup',
					array(
						'type'   => 'icons',
						'style'  => piqes_get_theme_setting( 'icons_type' ),
						'button' => false,
						'icons'  => true,
					),
					null
				)
			);
		}
	}
}

// Load required styles and scripts for admin mode
if ( ! function_exists( 'piqes_admin_scripts' ) ) {
	//Handler of the add_action("admin_enqueue_scripts", 'piqes_admin_scripts');
	function piqes_admin_scripts( $all = false ) {

		// Add theme styles
		wp_enqueue_style( 'piqes-admin', piqes_get_file_url( 'css/admin.css' ), array(), null );

		// Links to selected fonts
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
		if ( $all || is_object( $screen ) ) {
			if ( $all || piqes_options_allow_override( ! empty( $screen->post_type ) ? $screen->post_type : $screen->id ) ) {
				// Load font icons
				wp_enqueue_style( 'piqes-icons', piqes_get_file_url( 'css/font-icons/css/fontello.css' ), array(), null );
				wp_enqueue_style( 'piqes-icons-animation', piqes_get_file_url( 'css/font-icons/css/animation.css' ), array(), null );
				// Load theme fonts
				$links = piqes_theme_fonts_links();
				if ( count( $links ) > 0 ) {
					foreach ( $links as $slug => $link ) {
						wp_enqueue_style( sprintf( 'piqes-font-%s', $slug ), $link, array(), null );
					}
				}
			} elseif ( apply_filters( 'piqes_filter_allow_theme_icons', is_customize_preview() || 'nav-menus' == $screen->id, ! empty( $screen->post_type ) ? $screen->post_type : $screen->id ) ) {
				// Load font icons
				wp_enqueue_style( 'piqes-icons', piqes_get_file_url( 'css/font-icons/css/fontello.css' ), array(), null );
			}
		}

		// Add theme scripts
		wp_enqueue_script( 'piqes-utils', piqes_get_file_url( 'js/theme-utils.js' ), array( 'jquery' ), null, true );
		wp_enqueue_script( 'piqes-admin', piqes_get_file_url( 'js/theme-admin.js' ), array( 'jquery' ), null, true );
	}
}

// Add variables in the admin mode
if ( ! function_exists( 'piqes_admin_localize_scripts' ) ) {
	//Handler of the add_action("admin_footer", 'piqes_admin_localize_scripts');
	function piqes_admin_localize_scripts() {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
		wp_localize_script(
			'piqes-admin', 'PIQES_STORAGE', apply_filters(
				'piqes_filter_localize_script_admin', array(
					'admin_mode'                 => true,
					'screen_id'                  => is_object( $screen ) ? esc_attr( $screen->id ) : '',
					'user_logged_in'             => true,
					'ajax_url'                   => esc_url( admin_url( 'admin-ajax.php' ) ),
					'ajax_nonce'                 => esc_attr( wp_create_nonce( admin_url( 'admin-ajax.php' ) ) ),
					'msg_ajax_error'             => esc_html__( 'Server response error', 'piqes' ),
					'msg_icon_selector'          => esc_html__( 'Select the icon for this menu item', 'piqes' ),
					'msg_scheme_reset'           => esc_html__( 'Reset all changes of the current color scheme?', 'piqes' ),
					'msg_scheme_copy'            => esc_html__( 'Enter the name for a new color scheme', 'piqes' ),
					'msg_scheme_delete'          => esc_html__( 'Do you really want to delete the current color scheme?', 'piqes' ),
					'msg_scheme_delete_last'     => esc_html__( 'You cannot delete the last color scheme!', 'piqes' ),
					'msg_scheme_delete_internal' => esc_html__( 'You cannot delete the built-in color scheme!', 'piqes' ),
				)
			)
		);
	}
}



//-------------------------------------------------------
//-- Third party plugins
//-------------------------------------------------------

// Register optional plugins
if ( ! function_exists( 'piqes_register_plugins' ) ) {
	//Handler of the add_action('tgmpa_register', 'piqes_register_plugins');
	function piqes_register_plugins() {
		tgmpa(
			apply_filters(
				'piqes_filter_tgmpa_required_plugins', array(
				// Plugins to include in the autoinstall queue.
				)
			),
			array(
				'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'parent_slug'  => 'themes.php',            // Parent menu slug.
				'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.
			)
		);
	}
}


// Return path to the plugin source
if ( ! function_exists( 'piqes_get_plugin_source_path' ) ) {
	function piqes_get_plugin_source_path( $path ) {
		$local = piqes_get_file_dir( $path );
		$path  = empty( $local ) && ! piqes_get_theme_setting( 'tgmpa_upload' ) ? piqes_get_plugin_source_url( $path ) : $local;
		return $path;
	}
}


// Return URL to the plugin download
if ( ! function_exists( 'piqes_get_plugin_source_url' ) ) {
	function piqes_get_plugin_source_url( $path ) {
		$code = piqes_get_theme_activation_code();
		$url  = '';
		if ( ! empty( $code ) || piqes_is_theme_activated()) {
			$theme = wp_get_theme();
			$url   = sprintf(
				trailingslashit( piqes_storage_get( 'theme_upgrade_url' ) ) . 'upgrade.php?key=%1$s&src=%2$s&theme_slug=%3$s&theme_name=%4$s&action=install_plugin&plugin=%5$s&rnd=%6$s',
				urlencode( $code ),
				urlencode( piqes_storage_get( 'theme_pro_key' ) ),
				urlencode( get_option( 'template' ) ),
				urlencode( $theme->name ),
				urlencode( str_replace( 'plugins/', '', $path ) ),
				mt_rand()
			);
		}
		return substr( $url, 0, 2 ) == '//' ? piqes_get_protocol() . ":{$url}" : $url;
	}
}
