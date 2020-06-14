<?php
/**
 * ThemeREX Addons Custom post type: Portfolio
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// -----------------------------------------------------------------
// -- Custom post type registration
// -----------------------------------------------------------------

// Define Custom post type and taxonomy constants
if ( ! defined('TRX_ADDONS_CPT_PORTFOLIO_PT') ) define('TRX_ADDONS_CPT_PORTFOLIO_PT', trx_addons_cpt_param('portfolio', 'post_type'));
if ( ! defined('TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY') ) define('TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY', trx_addons_cpt_param('portfolio', 'taxonomy'));

// Register post type and taxonomy
if (!function_exists('trx_addons_cpt_portfolio_init')) {
	add_action( 'init', 'trx_addons_cpt_portfolio_init' );
	function trx_addons_cpt_portfolio_init() {
		
		// Add Portfolio parameters to the Meta Box support
		trx_addons_meta_box_register(TRX_ADDONS_CPT_PORTFOLIO_PT, array(
			"general_section" => array(
				"title" => esc_html__('General', 'trx_addons'),
				"desc" => wp_kses_data( __('Basic information about this project', 'trx_addons') ),
				"type" => "section"
			),
			"subtitle" => array(
				"title" => esc_html__("Project's subtitle",  'trx_addons'),
				"desc" => wp_kses_data( __("Portfolio item subtitle, slogan, position or any other text", 'trx_addons') ),
				"std" => "",
				"type" => "text"
			),
			"link" => array(
				"title" => esc_html__("Project's link",  'trx_addons'),
				"desc" => wp_kses_data( __("Alternative link to the project's site. If empty - use this post's permalink", 'trx_addons') ),
				"std" => "",
				"type" => "text"
			),

			"details_section" => array(
				"title" => esc_html__('Project details', 'trx_addons'),
				"desc" => wp_kses_data( __('Additional details for this project', 'trx_addons') ),
				"type" => "section"
			),
			"details_position" => array(
				"title" => esc_html__("Details position", 'trx_addons'),
				"desc" => wp_kses_data( __("Select position of the block with project's details", 'trx_addons') ),
				"std" => 'top',
				"options" => array(
									'top' => __('Top', 'trx_addons'),
									'bottom' => __('Bottom', 'trx_addons'),
									'left' => __('Left', 'trx_addons'),
									'right' => __('Right', 'trx_addons')
									),
				"type" => "select"
			),
			"details" => array(
				"title" => esc_html__("Project details", 'trx_addons'),
				"desc" => wp_kses_data( __("Details of this project", 'trx_addons') ),
				"clone" => true,
				"std" => array(
								array(
										'title' => __('Client', 'trx_addons'),
										'value' => __('Client name', 'trx_addons'),
										'link'  => '',
										'icon'  => ''
										),
								array(
										'title' => __('Year', 'trx_addons'),
										'value' => '2018',
										'link'  => '',
										'icon'  => ''
										),
								array(
										'title' => __('Author', 'trx_addons'),
										'value' => __('Author name', 'trx_addons'),
										'link'  => '',
										'icon'  => ''
										),
								),
				"type" => "group",
				"fields" => array(
					"title" => array(
						"title" => esc_html__("Title", 'trx_addons'),
						"desc" => wp_kses_data( __('Current feature title', 'trx_addons') ),
						"class" => "trx_addons_column-1_4",
						"std" => "",
						"type" => "text"
					),
					"value" => array(
						"title" => esc_html__("Value", 'trx_addons'),
						"desc" => wp_kses_data( __('Current feature value', 'trx_addons') ),
						"class" => "trx_addons_column-1_4",
						"std" => "",
						"type" => "text"
					),
					"link" => array(
						"title" => esc_html__("Link", 'trx_addons'),
						"desc" => wp_kses_data( __('Current feature link', 'trx_addons') ),
						"class" => "trx_addons_column-1_4",
						"std" => "",
						"type" => "text"
					),
					"icon" => array(
						"title" => esc_html__("Icon", 'trx_addons'),
						"desc" => wp_kses_data( __('Current feature icon', 'trx_addons') ),
						"class" => "trx_addons_column-1_4",
						"std" => "",
						"options" => array(),
						"style" => trx_addons_get_setting('icons_type'),
						"type" => "icons"
					)
				)
			),

			"gallery_section" => array(
				"title" => esc_html__('Gallery', 'trx_addons'),
				"desc" => wp_kses_data( __('Images gallery for this project', 'trx_addons') ),
				"type" => "section"
			),
			"gallery" => array(
				"title" => esc_html__("Images gallery", 'trx_addons'),
				"desc" => wp_kses_data( __("Select images to create gallery on the single page of this project", 'trx_addons') ),
				"std" => "",
				"multiple" => true,
				"type" => "image"
			),
			"gallery_position" => array(
				"title" => esc_html__("Gallery position", 'trx_addons'),
				"desc" => wp_kses_data( __("Show gallery above or below the project's content", 'trx_addons') ),
				"dependency" => array(
					"gallery" => array("not_empty")
				),
				"std" => 'bottom',
				"options" => array(
									'none' => __('Hide gallery', 'trx_addons'),
									'top' => __('Above content', 'trx_addons'),
									'bottom' => __('Below content', 'trx_addons')
									),
				"type" => "select"
			),
			"gallery_layout" => array(
				"title" => esc_html__("Gallery layout", 'trx_addons'),
				"desc" => wp_kses_data( __("Select layout to display images on the project's page", 'trx_addons') ),
				"dependency" => array(
					"gallery" => array("not_empty"),
					"gallery_position" => array("^none"),
				),
				"std" => 'slider',
				"options" => array(
									'slider' => __('Slider', 'trx_addons'),
									'grid_2' => __('Grid /2 columns/', 'trx_addons'),
									'grid_3' => __('Grid /3 columns/', 'trx_addons'),
									'grid_4' => __('Grid /4 columns/', 'trx_addons'),
									'masonry_2' => __('Masonry /2 columns/', 'trx_addons'),
									'masonry_3' => __('Masonry /3 columns/', 'trx_addons'),
									'masonry_4' => __('Masonry /4 columns/', 'trx_addons'),
									'stream' => __('Stream', 'trx_addons'),
									),
				"type" => "select"
			),
			"gallery_description" => array(
				"title" => esc_html__("Description", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify short description to the gallery above', 'trx_addons') ),
				"dependency" => array(
					"gallery" => array("not_empty")
				),
				"std" => "",
				"type" => "textarea"
			),
			"video" => array(
				"title" => esc_html__("Video", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify URL with a video from popular video hosting (Youtube, Vimeo)', 'trx_addons') ),
				"std" => "",
				"type" => "text"
			),
			"video_description" => array(
				"title" => esc_html__("Description", 'trx_addons'),
				"desc" => wp_kses_data( __('Specify short description to the video above', 'trx_addons') ),
				"dependency" => array(
					"video" => array("not_empty")
				),
				"std" => "",
				"type" => "textarea"
			),
		));
		
		// Register post type and taxonomy
		register_post_type(
			TRX_ADDONS_CPT_PORTFOLIO_PT,
			apply_filters('trx_addons_filter_register_post_type',
				array(
					'label'               => esc_html__( 'Portfolio', 'trx_addons' ),
					'description'         => esc_html__( 'Portfolio Description', 'trx_addons' ),
					'labels'              => array(
						'name'                => esc_html__( 'Portfolio', 'trx_addons' ),
						'singular_name'       => esc_html__( 'Portfolio', 'trx_addons' ),
						'menu_name'           => esc_html__( 'Portfolio', 'trx_addons' ),
						'parent_item_colon'   => esc_html__( 'Parent Item:', 'trx_addons' ),
						'all_items'           => esc_html__( 'All Portfolio items', 'trx_addons' ),
						'view_item'           => esc_html__( 'View Portfolio item', 'trx_addons' ),
						'add_new_item'        => esc_html__( 'Add New Portfolio item', 'trx_addons' ),
						'add_new'             => esc_html__( 'Add New', 'trx_addons' ),
						'edit_item'           => esc_html__( 'Edit Portfolio item', 'trx_addons' ),
						'update_item'         => esc_html__( 'Update Portfolio item', 'trx_addons' ),
						'search_items'        => esc_html__( 'Search Portfolio items', 'trx_addons' ),
						'not_found'           => esc_html__( 'Not found', 'trx_addons' ),
						'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'trx_addons' ),
					),
					'taxonomies'          => array(TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY),
					'supports'            => trx_addons_cpt_param('portfolio', 'supports'),
					'public'              => true,
					'hierarchical'        => false,
					'has_archive'         => true,
					'can_export'          => true,
					'show_in_admin_bar'   => true,
					'show_in_menu'        => true,
					'menu_position'       => '53.2',
					'menu_icon'			  => 'dashicons-images-alt',
					'capability_type'     => 'post',
					'rewrite'             => array( 'slug' => trx_addons_cpt_param('portfolio', 'post_type_slug') )
				),
				TRX_ADDONS_CPT_PORTFOLIO_PT
			)
		);

		register_taxonomy(
			TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY,
			TRX_ADDONS_CPT_PORTFOLIO_PT,
			apply_filters('trx_addons_filter_register_taxonomy',
				array(
					'post_type' 		=> TRX_ADDONS_CPT_PORTFOLIO_PT,
					'hierarchical'      => true,
					'labels'            => array(
						'name'              => esc_html__( 'Portfolio Group', 'trx_addons' ),
						'singular_name'     => esc_html__( 'Group', 'trx_addons' ),
						'search_items'      => esc_html__( 'Search Groups', 'trx_addons' ),
						'all_items'         => esc_html__( 'All Groups', 'trx_addons' ),
						'parent_item'       => esc_html__( 'Parent Group', 'trx_addons' ),
						'parent_item_colon' => esc_html__( 'Parent Group:', 'trx_addons' ),
						'edit_item'         => esc_html__( 'Edit Group', 'trx_addons' ),
						'update_item'       => esc_html__( 'Update Group', 'trx_addons' ),
						'add_new_item'      => esc_html__( 'Add New Group', 'trx_addons' ),
						'new_item_name'     => esc_html__( 'New Group Name', 'trx_addons' ),
						'menu_name'         => esc_html__( 'Portfolio Groups', 'trx_addons' ),
					),
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => trx_addons_cpt_param('portfolio', 'taxonomy_slug') )
				),
				TRX_ADDONS_CPT_PORTFOLIO_PT,
				TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY
			)
		);
	}
}


// Allow Gutenberg as main editor for this post type
if ( ! function_exists( 'trx_addons_cpt_portfolio_add_pt_to_gutenberg' ) ) {
	add_filter( 'trx_addons_filter_add_pt_to_gutenberg', 'trx_addons_cpt_portfolio_add_pt_to_gutenberg', 10, 2 );
	function trx_addons_cpt_portfolio_add_pt_to_gutenberg( $allow, $post_type ) {
		return $allow || $post_type == TRX_ADDONS_CPT_PORTFOLIO_PT;
	}
}

// Allow Gutenberg as main editor for taxonomies
if ( ! function_exists( 'trx_addons_cpt_portfolio_add_taxonomy_to_gutenberg' ) ) {
	add_filter( 'trx_addons_filter_add_taxonomy_to_gutenberg', 'trx_addons_cpt_portfolio_add_taxonomy_to_gutenberg', 10, 2 );
	function trx_addons_cpt_portfolio_add_taxonomy_to_gutenberg( $allow, $tax ) {
		return $allow || in_array( $tax, array( TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY ) );
	}
}

/* ------------------- Old way - moved to the cpt.php now ---------------------
// Add 'Portfolio' parameters in the ThemeREX Addons Options
if (!function_exists('trx_addons_cpt_portfolio_options')) {
	add_filter( 'trx_addons_filter_options', 'trx_addons_cpt_portfolio_options');
	function trx_addons_cpt_portfolio_options($options) {
		trx_addons_array_insert_after($options, 'cpt_section', trx_addons_cpt_portfolio_get_list_options());
		return $options;
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_portfolio_get_list_options')) {
	function trx_addons_cpt_portfolio_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'portfolio_info' => array(
				"title" => esc_html__('Portfolio', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the portfolio archive', 'trx_addons') ),
				"type" => "info"
			),
			'portfolio_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the portfolio archive', 'trx_addons') ),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles',
											trx_addons_components_get_allowed_layouts('cpt', 'portfolio', 'arh'),
											TRX_ADDONS_CPT_PORTFOLIO_PT),
				"type" => "select"
			)
		), 'portfolio');
	}
}
------------------- /Old way --------------------- */


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_cpt_portfolio_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cpt_portfolio_load_scripts_front');
	function trx_addons_cpt_portfolio_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-cpt_portfolio', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'portfolio/portfolio.css'), array(), null );
		}
		if (is_single() && get_post_type() == TRX_ADDONS_CPT_PORTFOLIO_PT) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'masonry' );
			if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
				wp_enqueue_script('trx_addons-cpt_portfolio', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'portfolio/portfolio.js'), array('jquery'), null, true );
			}
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_cpt_portfolio_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cpt_portfolio_load_responsive_styles', 2000);
	function trx_addons_cpt_portfolio_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-cpt_portfolio-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'portfolio/portfolio.responsive.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_cpt_portfolio_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_cpt_portfolio_merge_styles');
	function trx_addons_cpt_portfolio_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'portfolio/portfolio.css';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_cpt_portfolio_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_cpt_portfolio_merge_styles_responsive');
	function trx_addons_cpt_portfolio_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'portfolio/portfolio.responsive.css';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_cpt_portfolio_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_cpt_portfolio_merge_scripts');
	function trx_addons_cpt_portfolio_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'portfolio/portfolio.js';
		return $list;
	}
}


// Return true if it's portfolio page
if ( !function_exists( 'trx_addons_is_portfolio_page' ) ) {
	function trx_addons_is_portfolio_page() {
		return defined('TRX_ADDONS_CPT_PORTFOLIO_PT') 
					&& !is_search()
					&& (
						(is_single() && get_post_type()==TRX_ADDONS_CPT_PORTFOLIO_PT)
						|| is_post_type_archive(TRX_ADDONS_CPT_PORTFOLIO_PT)
						|| is_tax(TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY)
						);
	}
}



// Replace standard theme templates
//-------------------------------------------------------------

// Change standard single template for services posts
if ( !function_exists( 'trx_addons_cpt_portfolio_single_template' ) ) {
	add_filter('single_template', 'trx_addons_cpt_portfolio_single_template');
	function trx_addons_cpt_portfolio_single_template($template) {
		global $post;
		if (is_single() && $post->post_type == TRX_ADDONS_CPT_PORTFOLIO_PT)
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.single.php');
		return $template;
	}
}

// Change standard archive template for services posts
if ( !function_exists( 'trx_addons_cpt_portfolio_archive_template' ) ) {
	add_filter('archive_template',	'trx_addons_cpt_portfolio_archive_template');
	function trx_addons_cpt_portfolio_archive_template( $template ) {
		if ( is_post_type_archive(TRX_ADDONS_CPT_PORTFOLIO_PT) )
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.archive.php');
		return $template;
	}	
}

// Change standard category template for services categories (groups)
if ( !function_exists( 'trx_addons_cpt_portfolio_taxonomy_template' ) ) {
	add_filter('taxonomy_template',	'trx_addons_cpt_portfolio_taxonomy_template');
	function trx_addons_cpt_portfolio_taxonomy_template( $template ) {
		if ( is_tax(TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY) )
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.archive.php');
		return $template;
	}	
}

// Show related posts
if ( !function_exists( 'trx_addons_cpt_portfolio_related_posts_after_article' ) ) {
	add_action('trx_addons_action_after_article', 'trx_addons_cpt_portfolio_related_posts_after_article', 20, 1);
	function trx_addons_cpt_portfolio_related_posts_after_article( $mode ) {
		if ($mode == 'portfolio.single' && apply_filters('trx_addons_filter_show_related_posts_after_article', true)) {
			do_action('trx_addons_action_related_posts', $mode);
		}
	}
}

if ( !function_exists( 'trx_addons_cpt_portfolio_related_posts_show' ) ) {
	add_filter('trx_addons_filter_show_related_posts', 'trx_addons_cpt_portfolio_related_posts_show');
	function trx_addons_cpt_portfolio_related_posts_show( $show ) {
		if (!$show && is_single() && get_post_type() == TRX_ADDONS_CPT_PORTFOLIO_PT) {
			do_action('trx_addons_action_related_posts', 'portfolio.single');
			$show = true;
		}
		return $show;
	}
}

if ( !function_exists( 'trx_addons_cpt_portfolio_related_posts' ) ) {
	add_action('trx_addons_action_related_posts', 'trx_addons_cpt_portfolio_related_posts', 10, 1);
	function trx_addons_cpt_portfolio_related_posts( $mode ) {
		if ($mode == 'portfolio.single') {
			$trx_addons_related_style   = explode('_', trx_addons_get_option('portfolio_style'));
			$trx_addons_related_type    = $trx_addons_related_style[0];
			$trx_addons_related_columns = empty($trx_addons_related_style[1]) ? 1 : max(1, $trx_addons_related_style[1]);
			
			trx_addons_get_template_part('templates/tpl.posts-related.php',
												'trx_addons_args_related',
												apply_filters('trx_addons_filter_args_related', array(
																	'class' => 'portfolio_page_related sc_portfolio sc_portfolio_'.esc_attr($trx_addons_related_type),
																	'posts_per_page' => $trx_addons_related_columns,
																	'columns' => $trx_addons_related_columns,
																	'template' => TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.'.trim($trx_addons_related_type).'-item.php',
																	'template_args_name' => 'trx_addons_args_sc_portfolio',
																	'post_type' => TRX_ADDONS_CPT_PORTFOLIO_PT,
																	'taxonomies' => array(TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY)
																	)
															)
											);
		}
	}
}



// Admin utils
// -----------------------------------------------------------------

// Show <select> with portfolio categories in the admin filters area
if (!function_exists('trx_addons_cpt_portfolio_admin_filters')) {
	add_action( 'restrict_manage_posts', 'trx_addons_cpt_portfolio_admin_filters' );
	function trx_addons_cpt_portfolio_admin_filters() {
		trx_addons_admin_filters(TRX_ADDONS_CPT_PORTFOLIO_PT, TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY);
	}
}
  
// Clear terms cache on the taxonomy save
if (!function_exists('trx_addons_cpt_portfolio_admin_clear_cache')) {
	add_action( 'edited_'.TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY, 'trx_addons_cpt_portfolio_admin_clear_cache', 10, 1 );
	add_action( 'delete_'.TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY, 'trx_addons_cpt_portfolio_admin_clear_cache', 10, 1 );
	add_action( 'created_'.TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY, 'trx_addons_cpt_portfolio_admin_clear_cache', 10, 1 );
	function trx_addons_cpt_portfolio_admin_clear_cache( $term_id=0 ) {  
		trx_addons_admin_clear_cache_terms(TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY);
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'portfolio/portfolio-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
    require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'portfolio/portfolio-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'portfolio/portfolio-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'portfolio/portfolio-sc-vc.php';
}
