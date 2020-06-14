<?php
/**
 * Plugin support: Gutenberg
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0.49
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if plugin 'Gutenberg' is installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_addons_exists_gutenberg' ) ) {
	function trx_addons_exists_gutenberg() {
		return function_exists( 'register_block_type' );
	}
}
*/

// Return true if Gutenberg exists and current mode is preview
if ( !function_exists( 'trx_addons_gutenberg_is_preview' ) ) {
	function trx_addons_gutenberg_is_preview() {
		return trx_addons_exists_gutenberg() 
				&& (
					trx_addons_gutenberg_is_block_render_action()
					||
					trx_addons_is_post_edit()
					);
	}
}

// Return true if current mode is "Block render"
if ( !function_exists( 'trx_addons_gutenberg_is_block_render_action' ) ) {
	function trx_addons_gutenberg_is_block_render_action() {
		return trx_addons_exists_gutenberg() 
				&& trx_addons_check_url('block-renderer') && !empty($_GET['context']) && $_GET['context']=='edit';
	}
}

// Return true if content built with "Gutenberg"
if ( !function_exists( 'trx_addons_gutenberg_is_content_built' ) ) {
	function trx_addons_gutenberg_is_content_built($content) {
		return trx_addons_exists_gutenberg() 
				&& has_blocks( $content );	//strpos($content, '<!-- wp:') !== false;
	}
}

// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_gutenberg_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_gutenberg_load_scripts_front', 11);
	function trx_addons_gutenberg_load_scripts_front() {
		if ( trx_addons_exists_gutenberg() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-gutenberg', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'gutenberg/gutenberg.css'), array(), null );
		}
	}
}

	
// Merge specific styles into single stylesheet
if ( !function_exists( 'trx_addons_gutenberg_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_gutenberg_merge_styles');
	function trx_addons_gutenberg_merge_styles($list) {
		if (trx_addons_exists_gutenberg()) {
			$list[] = TRX_ADDONS_PLUGIN_API . 'gutenberg/gutenberg.css';
		}
		return $list;
	}
}

// Add editor styles
if ( ! function_exists( 'trx_addons_gutenberg_theme_setup8' ) ) {
	add_action( 'after_setup_theme', 'trx_addons_gutenberg_theme_setup8', 8 );
	function trx_addons_gutenberg_theme_setup8() {
		if ( trx_addons_exists_gutenberg() ) {
			if ( ! trx_addons_get_setting( 'gutenberg_add_context' ) ) {
				$styles = array(
					trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'gutenberg/gutenberg-preview.css')
				);
				add_editor_style( apply_filters( 'trx_addons_filter_add_editor_style', $styles ) );
			}
		}
	}
}


// Load required styles and scripts for Backend Editor mode
if ( !function_exists( 'trx_addons_gutenberg_editor_load_scripts' ) ) {
	add_action("enqueue_block_editor_assets", 'trx_addons_gutenberg_editor_load_scripts');
	function trx_addons_gutenberg_editor_load_scripts() {
		trx_addons_load_scripts_admin(true);
		trx_addons_localize_scripts_admin();
		if ( trx_addons_get_setting( 'gutenberg_add_context' ) ) {
			wp_enqueue_style( 'trx_addons', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'gutenberg/gutenberg-preview.css'), array(), null );
		}
		if (trx_addons_get_setting('allow_gutenberg_blocks')) {
			wp_enqueue_script( 'trx_addons-gutenberg-blocks', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'gutenberg/blocks/dist/blocks.build.js'), array('jquery'), null, true );

			// Load Swiper slider script and styles
			trx_addons_enqueue_slider();

			// Load Popup script and styles
			trx_addons_enqueue_popup();

			// Load merged scripts
			wp_enqueue_script( 'trx_addons', trx_addons_get_file_url( 'js/__scripts.js' ), array( 'jquery' ), null, true );
		}
		do_action('trx_addons_action_pagebuilder_admin_scripts');
	}
}

// Load required scripts for both: Backend + Frontend mode
if ( !function_exists( 'trx_addons_gutenberg_preview_load_scripts' ) ) {
	add_action("enqueue_block_assets", 'trx_addons_gutenberg_preview_load_scripts');
	function trx_addons_gutenberg_preview_load_scripts() {
		if ( trx_addons_gutenberg_is_preview() ) {
			do_action('trx_addons_action_pagebuilder_preview_scripts', 'gutenberg');
		}
	}
}

// Add shortcode's specific vars to the JS storage
if ( !function_exists( 'trx_addons_gutenberg_localize_script' ) ) {
	add_filter("trx_addons_filter_localize_script", 'trx_addons_gutenberg_localize_script');
	function trx_addons_gutenberg_localize_script($vars) {
		$vars['pagebuilder_preview_mode'] = ! empty( $vars['pagebuilder_preview_mode'] ) || trx_addons_gutenberg_is_preview();
		return $vars;
	}
}

// Add shortcode's specific vars to the JS storage (admin area)
if ( ! function_exists( 'trx_addons_gutenberg_localize_scripts_admin' ) ) {
	add_filter( 'trx_addons_filter_localize_script_admin', 'trx_addons_gutenberg_localize_scripts_admin' );
	function trx_addons_gutenberg_localize_scripts_admin( $vars = array() ) {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			$vars['gutenberg_allowed_blocks'] = trx_addons_gutenberg_get_list_allowed_blocks();
			$vars['gutenberg_sc_params']      = apply_filters(
													'trx_addons_filter_gutenberg_sc_params',
													array(
														'list_spacer_heights' => trx_addons_get_list_sc_empty_space_heights(),
														'theme_colors' => current( (array) get_theme_support( 'editor-color-palette' ) )
													)
												);
		}
		return $vars;
	}
}

// Save CSS with custom colors and fonts to the gutenberg-editor-style.css
if ( ! function_exists( 'trx_addons_gutenberg_save_css' ) ) {
	add_action( 'trx_addons_action_save_options', 'trx_addons_gutenberg_save_css', 30 );
	add_action( 'trx_addons_action_save_options_theme', 'trx_addons_gutenberg_save_css', 30 );
	function trx_addons_gutenberg_save_css() {

		$msg = '/* ' . esc_html__( "ATTENTION! This file was generated automatically! Don't change it!!!", 'trx_addons' )
				. "\n----------------------------------------------------------------------- */\n";

		// Get main styles
		$css = trx_addons_fgc( trx_addons_get_file_dir( 'css/__styles.css' ) );

		// Add responsive styles
		$css .= trx_addons_fgc( trx_addons_get_file_dir( 'css/__responsive.css' ) );

		// Add context class to each selector
		if ( trx_addons_get_setting( 'gutenberg_add_context' ) ) {
			$css = trx_addons_css_add_context(
						$css,
						array(
							'context' => '.edit-post-visual-editor ',
							'context_self' => array( 'html', 'body', '.edit-post-visual-editor' )
							)
					);
		} else {
			$css = trx_addons_minify_css( $css );
		}

		// Save styles to the file
		trx_addons_fpc( trx_addons_get_file_dir( TRX_ADDONS_PLUGIN_API . 'gutenberg/gutenberg-preview.css' ), $msg . $css );
	}
}


// Add compatibility with Gutenberg to our post types
if ( ! function_exists( 'trx_addons_gutenberg_enable_cpt' ) ) {
	add_filter( 'trx_addons_filter_register_post_type', 'trx_addons_gutenberg_enable_cpt', 10, 2 );
	function trx_addons_gutenberg_enable_cpt($args, $post_type) {
		if ( trx_addons_exists_gutenberg() && apply_filters( 'trx_addons_filter_add_pt_to_gutenberg', false, $post_type ) ) {
			$args['show_in_rest'] = true;
		}
		return $args;
	}
}


// Add compatibility with Gutenberg to our taxonomies
if ( ! function_exists( 'trx_addons_gutenberg_enable_taxonomies' ) ) {
	add_filter( 'trx_addons_filter_register_taxonomy', 'trx_addons_gutenberg_enable_taxonomies', 10, 3 );
	function trx_addons_gutenberg_enable_taxonomies($args, $post_type, $taxonomy) {
		if ( trx_addons_exists_gutenberg() && ( ! isset( $args['meta_box_cb'] ) || $args['meta_box_cb'] !== false ) && apply_filters( 'trx_addons_filter_add_taxonomy_to_gutenberg', false, $post_type ) ) {
			$args['show_in_rest'] = true;
		}
		return $args;
	}
}


//------------------------------------------------------------
//-- Compatibility Gutenberg and other PageBuilders
//-------------------------------------------------------------

// Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)
if ( ! function_exists( 'trx_addons_gutenberg_disable_cpt' ) ) {
	add_filter( 'gutenberg_can_edit_post_type', 'trx_addons_gutenberg_disable_cpt', 999, 2 );
	function trx_addons_gutenberg_disable_cpt($can, $post_type) {
		$safe_pb = (array) trx_addons_get_setting( 'gutenberg_safe_mode' );
		if ( $can && !empty($safe_pb) ) {
			$disable = false;
			if ( !$disable && in_array('elementor', $safe_pb) && trx_addons_exists_elementor() ) {
				$post_types = get_post_types_by_support( 'elementor' );
				$disable = is_array($post_types) && in_array($post_type, $post_types);
			}
			if ( !$disable && in_array('vc', $safe_pb) && trx_addons_exists_vc() ) {
				$post_types = function_exists('vc_editor_post_types') ? vc_editor_post_types() : array();
				$disable = is_array($post_types) && in_array($post_type, $post_types);
			}
			$can = ! $disable;
		}
		return $can;
	}
}


//------------------------------------------------------------
//-- Shortcodes support
//-------------------------------------------------------------

// Add inline CSS to the shortcode's layout
// if called from AJAX with action 'block-render'
if ( ! function_exists( 'trx_addons_gutenberg_print_inline_css' ) ) {
	add_filter( 'trx_addons_sc_output', 'trx_addons_gutenberg_print_inline_css', 10, 4 );
	function trx_addons_gutenberg_print_inline_css( $output, $sc, $atts, $content ) {
		if (trx_addons_gutenberg_is_block_render_action()) {
			// Add inline styles
			$css = trx_addons_get_inline_css(true);
			if (!empty($css)) {
				$output .= sprintf('<style type="text/css">%s</style>', $css);
			}
		}
		return $output;
	}
}


// Get list of blocks, allowed inside block-container (i.e. "Content area")
if ( ! function_exists( 'trx_addons_gutenberg_get_list_allowed_blocks' ) ) {
	function trx_addons_gutenberg_get_list_allowed_blocks( $exclude = '' ) {
		if ( !is_array($exclude) ) {
			$exclude = !empty($exclude) ? explode(',', $exclude) : array();
		}
		// This way not include many 'core/xxx' blocks
		//$list = trx_addons_gutenberg_get_list_registered_blocks();
		// Manual way
		global $TRX_ADDONS_STORAGE;
		$list = array( 'core/archives',			'core/block',			'core/categories',
						'core/latest-comments',	'core/latest-posts',	'core/shortcode',
						'core/heading',			'core/subheading',		'core/paragraph',
						'core/quote',			'core/list',			'core/image',
						'core/gallery',			'core/audio',			'core/video',
						'core/code',			'core/classic',			'core/custom-html',
						'core/table',			'core/columns',			'core/spacer',
						'core/separator',		'core/button',			'core/more',
						'core/preformatted'
					);
		$registry = WP_Block_Type_Registry::get_instance();
		foreach ( $TRX_ADDONS_STORAGE['sc_list'] as $key => $value ) {
			$key = str_replace( '_', '-', $key );
			if ( $registry->is_registered( 'trx-addons/' . $key ) ) {
				$list[] = 'trx-addons/' . $key;
			}
		}
		foreach ( $TRX_ADDONS_STORAGE['widgets_list'] as $key => $value ) {
			$key = str_replace( '_', '-', $key );
			if ( $registry->is_registered( 'trx-addons/' . $key ) ) {
				$list[] = 'trx-addons/' . $key;
			}
		}
		foreach ( $TRX_ADDONS_STORAGE['cpt_list'] as $key => $value ) {
			$key = str_replace( '_', '-', $key );
			if ( $registry->is_registered( 'trx-addons/' . $key ) ) {
				$list[] = 'trx-addons/' . $key;
			}
		}
		foreach (trx_addons_components_get_allowed_layouts('cpt', 'layouts', 'sc') as $sc => $title) {
			$sc = str_replace( '_', '-', $sc );
			if ( $registry->is_registered( 'trx-addons/layouts-' . $sc ) ) {
				$list[] = 'trx-addons/layouts-' . $sc;
			}
		}
		return apply_filters('trx_addons_filter_gutenberg_allowed_blocks', $list);
	}
}


// Get list of registered blocks
// 'type' = 'all | dynamic | static'
if ( ! function_exists( 'trx_addons_gutenberg_get_list_registered_blocks' ) ) {
	function trx_addons_gutenberg_get_list_registered_blocks( $type='all' ) {
		$list = array();
		if ( trx_addons_exists_gutenberg() ) {
			$blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
			if (is_array($blocks)) {
				foreach($blocks as $block) {
					if ($type == 'all' || ($type=='dynamic' && $block->is_dynamic()) || ($type=='static' && !$block->is_dynamic()) ) {
						$list[] = $block->name;
					}
				}
			}
		}
		return apply_filters('trx_addons_filter_gutenberg_registered_blocks', $list);
	}
}


// Add new category to block categories
if ( ! function_exists( 'trx_addons_gutenberg_block_categories' ) ) {
	add_filter( 'block_categories', 'trx_addons_gutenberg_block_categories', 10, 2 );
	function trx_addons_gutenberg_block_categories( $default_categories = array(), $post ) {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			$default_categories[] = array(
				'slug'  => 'trx-addons-blocks',
				'title' => __( 'TRX Addons Blocks', 'trx-addons' ),
			);
			$default_categories[] = array(
				'slug'  => 'trx-addons-widgets',
				'title' => __( 'TRX Addons Widgets', 'trx-addons' ),
			);
			$default_categories[] = array(
				'slug'  => 'trx-addons-cpt',
				'title' => __( 'TRX Addons Custom Post Types', 'trx-addons' ),
			);
			$default_categories[] = array(
				'slug'  => 'trx-addons-layouts',
				'title' => __( 'TRX Addons Layouts', 'trx-addons' ),
			);
		}
		return $default_categories;
	}
}


// Return query params
//-------------------------------------------
if ( ! function_exists( 'trx_addons_gutenberg_get_param_query' ) ) {
	function trx_addons_gutenberg_get_param_query() {
		return array(
			// Query attributes
			'ids'           => array(
				'type'    => 'string',
				'default' => '',
			),
			'count'			=> array(
				'type'    => 'number',
				'default' => 2,
			),
			'columns'		=> array(
				'type'    => 'number',
				'default' => 2,
			),
			'offset'		=> array(
				'type'    => 'number',
				'default' => 0,
			),
			'orderby'				=> array(
				'type'    => 'string',
				'default' => 'none',
			),
			'order'				=> array(
				'type'    => 'string',
				'default' => 'asc',
			)
		);
	}
}


// Return filters params
//-------------------------------------------
if ( ! function_exists( 'trx_addons_gutenberg_get_param_filters' ) ) {
	function trx_addons_gutenberg_get_param_filters() {
		return array(
			// Filters attributes
			'show_filters'		=> array(
				'type'    => 'boolean',
				'default' => false,
			),
			'filters_title'		=> array(
				'type'    => 'string',
				'default' => '',
			),
			'filters_subtitle'	=> array(
				'type'    => 'string',
				'default' => '',
			),
			'filters_title_align'=> array(
				'type'    => 'string',
				'default' => 'left',
			),
			'filters_taxonomy'	=> array(
				'type'    => 'string',
				'default' => 'category',
			),
			'filters_ids'		=> array(
				'type'    => 'string',
				'default' => '',
			),
			'filters_all'		=> array(
				'type'    => 'boolean',
				'default' => true,
			),
			'filters_all_text'	=> array(
				'type'    => 'string',
				'default' => esc_html__('All','trx_addons')
			),
			'filters_more_text'	=> array(
				'type'    => 'string',
				'default' => esc_html__('More posts','trx_addons')
			)
		);
	}
}


// Return slider params
//-------------------------------------------
if ( ! function_exists( 'trx_addons_gutenberg_get_param_slider' ) ) {
	function trx_addons_gutenberg_get_param_slider() {
		return array(
			// Slider attributes
			'slider'             => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'slides_space'       => array(
				'type'    => 'number',
				'default' => 0,
			),
			'slides_centered'    => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'slides_overflow'    => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'slider_mouse_wheel' => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'slider_autoplay'    => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'slider_controls'    => array(
				'type'    => 'string',
				'default' => 'none',
			),
			'slider_pagination'  => array(
				'type'    => 'string',
				'default' => 'none',
			),
			'slider_pagination_type'  => array(
				'type'    => 'string',
				'default' => 'bullets',
			)
		);
	}
}



// Return button params
//-------------------------------------------
if ( ! function_exists( 'trx_addons_gutenberg_get_param_button' ) ) {
	function trx_addons_gutenberg_get_param_button() {
		return array(
			// Button attributes
			'link'               => array(
				'type'    => 'string',
				'default' => '',
			),
			'link_text'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'link_style'         => array(
				'type'    => 'string',
				'default' => '',
			),
			'link_image'         => array(
				'type'    => 'number',
				'default' => 0,
			),
			'link_image_url'     => array(
				'type'    => 'string',
				'default' => '',
			)
		);
	}
}



// Return button 2 params
//-------------------------------------------
if ( ! function_exists( 'trx_addons_gutenberg_get_param_button2' ) ) {
	function trx_addons_gutenberg_get_param_button2() {
		return array(
			// Button 2 attributes
			'link2'              => array(
				'type'    => 'string',
				'default' => '',
			),
			'link2_text'         => array(
				'type'    => 'string',
				'default' => '',
			),
			'link2_style'        => array(
				'type'    => 'string',
				'default' => '',
			)
		);
	}
}


// Return title params
//-------------------------------------------
if ( ! function_exists( 'trx_addons_gutenberg_get_param_title' ) ) {
	function trx_addons_gutenberg_get_param_title() {
		return array(
			// Title attributes
			'title_style'        => array(
				'type'    => 'string',
				'default' => '',
			),
			'title_tag'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'title_align'        => array(
				'type'    => 'string',
				'default' => '',
			),
			'title_color'        => array(
				'type'    => 'string',
				'default' => '',
			),
			'title_color2'       => array(
				'type'    => 'string',
				'default' => '',
			),
			'gradient_direction' => array(
				'type'    => 'string',
				'default' => '0',
			),
			'title'              => array(
				'type'    => 'string',
				'default' => '',
			),
			'subtitle'           => array(
				'type'    => 'string',
				'default' => '',
			),
			'subtitle_align'     => array(
				'type'    => 'string',
				'default' => 'none',
			),
			'subtitle_position'  => array(
				'type'    => 'string',
				'default' => trx_addons_get_setting('subtitle_above_title') ? 'above' : 'below',
			),
			'description'        => array(
				'type'    => 'string',
				'default' => '',
			),
			'typed'              => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'typed_loop'         => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'typed_cursor'       => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'typed_strings'      => array(
				'type'    => 'string',
				'default' => '',
			),
			'typed_color'        => array(
				'type'    => 'string',
				'default' => '',
			),
			'typed_speed'        => array(
				'type'    => 'number',
				'default' => 6,
			),
			'typed_delay'        => array(
				'type'    => 'number',
				'default' => 1,
			)
		);
	}
}



// Hide on devices params
//-------------------------------------------
if ( ! function_exists( 'trx_addons_gutenberg_get_param_hide' ) ) {
	function trx_addons_gutenberg_get_param_hide($frontpage=false) {
		return array_merge(
			array(
				// Hide on devices attributes
				'hide_on_wide'     => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hide_on_desktop'     => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hide_on_notebook' => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hide_on_tablet'   => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hide_on_mobile'   => array(
					'type'    => 'boolean',
					'default' => false,
				)
			),
			! $frontpage ? array() : array(
				'hide_on_frontpage' => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hide_on_singular'  => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hide_on_other'     => array(
					'type'    => 'boolean',
					'default' => false,
				)
			)
		);
	}
}


// Return ID, Class, CSS params
//-------------------------------------------
if ( ! function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	function trx_addons_gutenberg_get_param_id() {
		return array(
			// ID, Class, CSS attributes
			'id'                => array(
				'type'    => 'string',
				'default' => '',
			),
			'class'             => array(
				'type'    => 'string',
				'default' => '',
			),
			'className'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'css'               => array(
				'type'    => 'string',
				'default' => '',
			)
		);
	}
}
