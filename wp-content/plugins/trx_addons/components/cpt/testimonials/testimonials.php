<?php
/**
 * ThemeREX Addons Custom post type: Testimonials
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// -----------------------------------------------------------------
// -- Custom post type registration
// -----------------------------------------------------------------

// Define Custom post type and taxonomy constants
if ( ! defined('TRX_ADDONS_CPT_TESTIMONIALS_PT') ) define('TRX_ADDONS_CPT_TESTIMONIALS_PT', trx_addons_cpt_param('testimonials', 'post_type'));
if ( ! defined('TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY') ) define('TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY', trx_addons_cpt_param('testimonials', 'taxonomy'));


// Register post type and taxonomy
if (!function_exists('trx_addons_cpt_testimonials_init')) {
	add_action( 'init', 'trx_addons_cpt_testimonials_init' );
	function trx_addons_cpt_testimonials_init() {

		// Add Testimonials to the Meta Box support
		trx_addons_meta_box_register(TRX_ADDONS_CPT_TESTIMONIALS_PT, array(
			"subtitle" => array(
				"title" => esc_html__("Item's subtitle",  'trx_addons'),
				"desc" => wp_kses_data( __("Testimonial author's position or any other text", 'trx_addons') ),
				"std" => "",
				"type" => "text"
			)
		));

		// Register post type and taxonomy
		register_post_type(
			TRX_ADDONS_CPT_TESTIMONIALS_PT,
			apply_filters('trx_addons_filter_register_post_type',
				array(
					'label'               => esc_html__( 'Testimonial', 'trx_addons' ),
					'description'         => esc_html__( 'Testimonial Description', 'trx_addons' ),
					'labels'              => array(
						'name'                => esc_html__( 'Testimonials', 'trx_addons' ),
						'singular_name'       => esc_html__( 'Testimonial', 'trx_addons' ),
						'menu_name'           => esc_html__( 'Testimonials', 'trx_addons' ),
						'parent_item_colon'   => esc_html__( 'Parent Item:', 'trx_addons' ),
						'all_items'           => esc_html__( 'All Testimonials', 'trx_addons' ),
						'view_item'           => esc_html__( 'View Testimonial', 'trx_addons' ),
						'add_new_item'        => esc_html__( 'Add New Testimonial', 'trx_addons' ),
						'add_new'             => esc_html__( 'Add New', 'trx_addons' ),
						'edit_item'           => esc_html__( 'Edit Testimonial', 'trx_addons' ),
						'update_item'         => esc_html__( 'Update Testimonial', 'trx_addons' ),
						'search_items'        => esc_html__( 'Search Testimonial', 'trx_addons' ),
						'not_found'           => esc_html__( 'Not found', 'trx_addons' ),
						'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'trx_addons' ),
					),
					'taxonomies'          => array(TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY),
					'supports'            => trx_addons_cpt_param('testimonials', 'supports'),
					'public'              => true,
					'hierarchical'        => false,
					'has_archive'         => false,
					'can_export'          => true,
					'show_in_admin_bar'   => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'exclude_from_search' => true,
					'menu_position'       => '54.0',
					'menu_icon'			  => 'dashicons-format-status',
					'capability_type'     => 'post',
					'rewrite'             => array( 'slug' => trx_addons_cpt_param('testimonials', 'post_type_slug') )
				),
				TRX_ADDONS_CPT_TESTIMONIALS_PT
			)
		);

		register_taxonomy(
			TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY,
			TRX_ADDONS_CPT_TESTIMONIALS_PT,
			apply_filters('trx_addons_filter_register_taxonomy',
				array(
					'post_type' 		=> TRX_ADDONS_CPT_TESTIMONIALS_PT,
					'hierarchical'      => true,
					'labels'            => array(
						'name'              => esc_html__( 'Testimonials Group', 'trx_addons' ),
						'singular_name'     => esc_html__( 'Group', 'trx_addons' ),
						'search_items'      => esc_html__( 'Search Groups', 'trx_addons' ),
						'all_items'         => esc_html__( 'All Groups', 'trx_addons' ),
						'parent_item'       => esc_html__( 'Parent Group', 'trx_addons' ),
						'parent_item_colon' => esc_html__( 'Parent Group:', 'trx_addons' ),
						'edit_item'         => esc_html__( 'Edit Group', 'trx_addons' ),
						'update_item'       => esc_html__( 'Update Group', 'trx_addons' ),
						'add_new_item'      => esc_html__( 'Add New Group', 'trx_addons' ),
						'new_item_name'     => esc_html__( 'New Group Name', 'trx_addons' ),
						'menu_name'         => esc_html__( 'Testimonial Group', 'trx_addons' ),
					),
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => trx_addons_cpt_param('testimonials', 'taxonomy_slug') )
				),
				TRX_ADDONS_CPT_TESTIMONIALS_PT,
				TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY
			)
		);
	}
}


// Allow Gutenberg as main editor for this post type
if ( ! function_exists( 'trx_addons_cpt_testimonials_add_pt_to_gutenberg' ) ) {
	add_filter( 'trx_addons_filter_add_pt_to_gutenberg', 'trx_addons_cpt_testimonials_add_pt_to_gutenberg', 10, 2 );
	function trx_addons_cpt_testimonials_add_pt_to_gutenberg( $allow, $post_type ) {
		return $allow || $post_type == TRX_ADDONS_CPT_TESTIMONIALS_PT;
	}
}

// Allow Gutenberg as main editor for taxonomies
if ( ! function_exists( 'trx_addons_cpt_testimonials_add_taxonomy_to_gutenberg' ) ) {
	add_filter( 'trx_addons_filter_add_taxonomy_to_gutenberg', 'trx_addons_cpt_testimonials_add_taxonomy_to_gutenberg', 10, 2 );
	function trx_addons_cpt_testimonials_add_taxonomy_to_gutenberg( $allow, $tax ) {
		return $allow || in_array( $tax, array( TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY ) );
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_cpt_testimonials_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cpt_testimonials_load_scripts_front');
	function trx_addons_cpt_testimonials_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-cpt_testimonials', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'testimonials/testimonials.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_cpt_testimonials_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_cpt_testimonials_merge_styles');
	function trx_addons_cpt_testimonials_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'testimonials/testimonials.css';
		return $list;
	}
}



// Admin utils
// -----------------------------------------------------------------

// Show <select> with testimonials categories in the admin filters area
if (!function_exists('trx_addons_cpt_testimonials_admin_filters')) {
	add_action( 'restrict_manage_posts', 'trx_addons_cpt_testimonials_admin_filters' );
	function trx_addons_cpt_testimonials_admin_filters() {
		trx_addons_admin_filters(TRX_ADDONS_CPT_TESTIMONIALS_PT, TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY);
	}
}
  
// Clear terms cache on the taxonomy save
if (!function_exists('trx_addons_cpt_testimonials_admin_clear_cache')) {
	add_action( 'edited_'.TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY, 'trx_addons_cpt_testimonials_admin_clear_cache', 10, 1 );
	add_action( 'delete_'.TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY, 'trx_addons_cpt_testimonials_admin_clear_cache', 10, 1 );
	add_action( 'created_'.TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY, 'trx_addons_cpt_testimonials_admin_clear_cache', 10, 1 );
	function trx_addons_cpt_testimonials_admin_clear_cache( $term_id=0 ) {  
		trx_addons_admin_clear_cache_terms(TRX_ADDONS_CPT_TESTIMONIALS_TAXONOMY);
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'testimonials/testimonials-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'testimonials/testimonials-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'testimonials/testimonials-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'testimonials/testimonials-sc-vc.php';
}

// Create our widget
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'testimonials/testimonials-widget.php';
