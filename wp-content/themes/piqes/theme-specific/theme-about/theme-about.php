<?php
/**
 * Information about this theme
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.30
 */


// Redirect to the 'About Theme' page after switch theme
if ( ! function_exists( 'piqes_about_after_switch_theme' ) ) {
	add_action( 'after_switch_theme', 'piqes_about_after_switch_theme', 1000 );
	function piqes_about_after_switch_theme() {
		update_option( 'piqes_about_page', 1 );
	}
}
if ( ! function_exists( 'piqes_about_after_setup_theme' ) ) {
	add_action( 'init', 'piqes_about_after_setup_theme', 1000 );
	function piqes_about_after_setup_theme() {
		if ( ! defined( 'WP_CLI' ) && get_option( 'piqes_about_page' ) == 1 ) {
			update_option( 'piqes_about_page', 0 );
			wp_safe_redirect( admin_url() . 'themes.php?page=piqes_about' );
			exit();
		} else {
			if ( piqes_get_value_gp( 'page' ) == 'piqes_about' && piqes_exists_trx_addons() ) {
				wp_safe_redirect( admin_url() . 'admin.php?page=trx_addons_theme_panel' );
				exit();
			}
		}
	}
}


// Add 'About Theme' item in the Appearance menu
if ( ! function_exists( 'piqes_about_add_menu_items' ) ) {
	add_action( 'admin_menu', 'piqes_about_add_menu_items' );
	function piqes_about_add_menu_items() {
		if ( ! piqes_exists_trx_addons() ) {
			$theme      = wp_get_theme();
			$theme_name = $theme->name . ( PIQES_THEME_FREE ? ' ' . esc_html__( 'Free', 'piqes' ) : '' );
			add_theme_page(
				// Translators: Add theme name to the page title
				sprintf( esc_html__( 'About %s', 'piqes' ), $theme_name ),    //page_title
				// Translators: Add theme name to the menu title
				sprintf( esc_html__( 'About %s', 'piqes' ), $theme_name ),    //menu_title
				'manage_options',                                               //capability
				'piqes_about',                                                //menu_slug
				'piqes_about_page_builder'                                  //callback
			);
		}
	}
}


// Load page-specific scripts and styles
if ( ! function_exists( 'piqes_about_enqueue_scripts' ) ) {
	add_action( 'admin_enqueue_scripts', 'piqes_about_enqueue_scripts' );
	function piqes_about_enqueue_scripts() {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
		if ( ! empty( $screen->id ) && false !== strpos( $screen->id, '_page_piqes_about' ) ) {
			// Scripts
			if ( ! piqes_exists_trx_addons() && function_exists( 'piqes_plugins_installer_enqueue_scripts' ) ) {
				piqes_plugins_installer_enqueue_scripts();
			}
			// Styles
			$fdir = piqes_get_file_url( 'theme-specific/theme-about/theme-about.css' );
			if ( '' != $fdir ) {
				wp_enqueue_style( 'piqes-about', $fdir, array(), null );
			}
		}
	}
}


// Build 'About Theme' page
if ( ! function_exists( 'piqes_about_page_builder' ) ) {
	function piqes_about_page_builder() {
		$theme = wp_get_theme();
		?>
		<div class="piqes_about">

			<?php do_action( 'piqes_action_theme_about_start', $theme ); ?>

			<?php do_action( 'piqes_action_theme_about_before_logo', $theme ); ?>

			<div class="piqes_about_logo">
				<?php
				$logo = piqes_get_file_url( 'theme-specific/theme-about/icon.jpg' );
				if ( empty( $logo ) ) {
					$logo = piqes_get_file_url( 'screenshot.jpg' );
				}
				if ( ! empty( $logo ) ) {
					?>
					<img src="<?php echo esc_url( $logo ); ?>">
					<?php
				}
				?>
			</div>

			<?php do_action( 'piqes_action_theme_about_before_title', $theme ); ?>

			<h1 class="piqes_about_title">
			<?php
				echo esc_html(
					sprintf(
						// Translators: Add theme name and version to the 'Welcome' message
						__( 'Welcome to %1$s %2$s v.%3$s', 'piqes' ),
						$theme->name,
						PIQES_THEME_FREE ? __( 'Free', 'piqes' ) : '',
						$theme->version
					)
				);
			?>
			</h1>

			<?php do_action( 'piqes_action_theme_about_before_description', $theme ); ?>

			<div class="piqes_about_description">
				<p>
					<?php
					echo wp_kses_data( __( 'In order to continue, please install and activate <b>ThemeREX Addons plugin</b>.', 'piqes' ) );
					?>
					<sup>*</sup>
				</p>
			</div>

			<?php do_action( 'piqes_action_theme_about_before_buttons', $theme ); ?>

			<div class="piqes_about_buttons">
				<?php piqes_plugins_installer_get_button_html( 'trx_addons' ); ?>
			</div>

			<?php do_action( 'piqes_action_theme_about_before_buttons', $theme ); ?>

			<div class="piqes_about_notes">
				<p>
					<sup>*</sup>
					<?php
					echo wp_kses_data( __( "<i>ThemeREX Addons plugin</i> will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options.", 'piqes' ) );
					?>
				</p>
			</div>

			<?php do_action( 'piqes_action_theme_about_end', $theme ); ?>

		</div>
		<?php
	}
}


// Hide TGMPA notice on the page 'About Theme'
if ( ! function_exists( 'piqes_about_page_disable_tgmpa_notice' ) ) {
	add_filter( 'tgmpa_show_admin_notice_capability', 'piqes_about_page_disable_tgmpa_notice' );
	function piqes_about_page_disable_tgmpa_notice($cap) {
		if ( piqes_get_value_gp( 'page' ) == 'piqes_about' ) {
			$cap = 'unfiltered_upload';
		}
		return $cap;
	}
}

require_once PIQES_THEME_DIR . 'includes/plugins-installer/plugins-installer.php';
