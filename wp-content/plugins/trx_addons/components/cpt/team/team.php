<?php
/**
 * ThemeREX Addons Custom post type: Team
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
if ( ! defined('TRX_ADDONS_CPT_TEAM_PT') ) define('TRX_ADDONS_CPT_TEAM_PT', trx_addons_cpt_param('team', 'post_type'));
if ( ! defined('TRX_ADDONS_CPT_TEAM_TAXONOMY') ) define('TRX_ADDONS_CPT_TEAM_TAXONOMY', trx_addons_cpt_param('team', 'taxonomy'));


// Register post type and taxonomy
if (!function_exists('trx_addons_cpt_team_init')) {
	add_action( 'init', 'trx_addons_cpt_team_init' );
	function trx_addons_cpt_team_init() {

		// Add Team parameters to the Meta Box support
		trx_addons_meta_box_register(TRX_ADDONS_CPT_TEAM_PT, array(
			"subtitle" => array(
				"title" => esc_html__("Position",  'trx_addons'),
				"desc" => wp_kses_data( __("Team member's position or any other text", 'trx_addons') ),
				"std" => "",
				"type" => "text"
			),
			"brief_info" => array(
				"title" => esc_html__("Brief info",  'trx_addons'),
				"desc" => wp_kses_data( __("Brief info about this team member to display on the member's single page near the avatar", 'trx_addons') ),
				"std" => "",
				"type" => "textarea"
			),
			'email' => array(
				"title" => esc_html__("E-mail",  'trx_addons'),
				"desc" => wp_kses_data( __("Team member's email", 'trx_addons') ),
				"std" => "",
				"details" => true,	// Display this field in the 'Details' area on the single page
				"type" => "email"
			),
			'phone' => array(
				"title" => esc_html__("Phone",  'trx_addons'),
				"desc" => wp_kses_data( __("Team member's phone number", 'trx_addons') ),
				"std" => "",
				"details" => true,
				"type" => "phone"
			),
			'address' => array(
				"title" => esc_html__("Address",  'trx_addons'),
				"desc" => wp_kses_data( __("Team member's post address", 'trx_addons') ),
				"std" => "",
				"details" => true,
				"type" => "text"
			),
			'socials' => array(
				"title" => esc_html__("Socials", 'trx_addons'),
				"desc" => wp_kses_data( __("Clone fields group and select icon/image, specify social network's title and URL to team member's profile", 'trx_addons') ),
				"clone" => true,
				"std" => array(array()),
				"type" => "group",
				"fields" => array(
					'title' => array(
						"title" => esc_html__('Title', 'trx_addons'),
						"desc" => wp_kses_data( __("Social network's name. If empty - icon's name will be used", 'trx_addons') ),
						"class" => "trx_addons_column-1_3 trx_addons_new_row",
						"std" => "",
						"type" => "text"
					),
					'url' => array(
						"title" => esc_html__('URL to your profile', 'trx_addons'),
						"desc" => wp_kses_data( __("Specify URL of team member's profile in this network", 'trx_addons') ),
						"class" => "trx_addons_column-1_3",
						"std" => "",
						"type" => "text"
					),
					"name" => array(
						"title" => esc_html__("Icon", 'trx_addons'),
						"desc" => wp_kses_data( __('Select icon of this network', 'trx_addons') ),
						"class" => "trx_addons_column-1_3",
						"std" => "",
						"options" => array(),
						"style" => trx_addons_get_setting('socials_type'),
						"type" => "icons"
					)
				)
			)
		));

		// Register post type and taxonomy
		register_post_type(
			TRX_ADDONS_CPT_TEAM_PT,
			apply_filters('trx_addons_filter_register_post_type',
				array(
					'label'               => esc_html__( 'Team', 'trx_addons' ),
					'description'         => esc_html__( 'Team Description', 'trx_addons' ),
					'labels'              => array(
						'name'                => esc_html__( 'Team', 'trx_addons' ),
						'singular_name'       => esc_html__( 'Team member', 'trx_addons' ),
						'menu_name'           => esc_html__( 'Team', 'trx_addons' ),
						'parent_item_colon'   => esc_html__( 'Parent Item:', 'trx_addons' ),
						'all_items'           => esc_html__( 'All Team', 'trx_addons' ),
						'view_item'           => esc_html__( 'View Team member', 'trx_addons' ),
						'add_new_item'        => esc_html__( 'Add New Team member', 'trx_addons' ),
						'add_new'             => esc_html__( 'Add New', 'trx_addons' ),
						'edit_item'           => esc_html__( 'Edit Team member', 'trx_addons' ),
						'update_item'         => esc_html__( 'Update Team member', 'trx_addons' ),
						'search_items'        => esc_html__( 'Search Team member', 'trx_addons' ),
						'not_found'           => esc_html__( 'Not found', 'trx_addons' ),
						'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'trx_addons' ),
					),
					'taxonomies'          => array(TRX_ADDONS_CPT_TEAM_TAXONOMY),
					'supports'            => trx_addons_cpt_param('team', 'supports'),
					'public'              => true,
					'hierarchical'        => false,
					'has_archive'         => true,
					'can_export'          => true,
					'show_in_admin_bar'   => true,
					'show_in_menu'        => true,
					'menu_position'       => '53.8',
					'menu_icon'			  => 'dashicons-admin-users',
					'capability_type'     => 'post',
					'rewrite'             => array( 'slug' => trx_addons_cpt_param('team', 'post_type_slug') )
				),
				TRX_ADDONS_CPT_TEAM_PT
			)
		);
		register_taxonomy(
			TRX_ADDONS_CPT_TEAM_TAXONOMY,
			TRX_ADDONS_CPT_TEAM_PT,
			apply_filters('trx_addons_filter_register_taxonomy',
				array(
					'post_type' 		=> TRX_ADDONS_CPT_TEAM_PT,
					'hierarchical'      => true,
					'labels'            => array(
						'name'              => esc_html__( 'Team Group', 'trx_addons' ),
						'singular_name'     => esc_html__( 'Group', 'trx_addons' ),
						'search_items'      => esc_html__( 'Search Groups', 'trx_addons' ),
						'all_items'         => esc_html__( 'All Groups', 'trx_addons' ),
						'parent_item'       => esc_html__( 'Parent Group', 'trx_addons' ),
						'parent_item_colon' => esc_html__( 'Parent Group:', 'trx_addons' ),
						'edit_item'         => esc_html__( 'Edit Group', 'trx_addons' ),
						'update_item'       => esc_html__( 'Update Group', 'trx_addons' ),
						'add_new_item'      => esc_html__( 'Add New Group', 'trx_addons' ),
						'new_item_name'     => esc_html__( 'New Group Name', 'trx_addons' ),
						'menu_name'         => esc_html__( 'Team Groups', 'trx_addons' ),
					),
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => trx_addons_cpt_param('team', 'taxonomy_slug') )
				),
				TRX_ADDONS_CPT_TEAM_PT,
				TRX_ADDONS_CPT_TEAM_TAXONOMY
			)
		);
	}
}


// Allow Gutenberg as main editor for this post type
if ( ! function_exists( 'trx_addons_cpt_team_add_pt_to_gutenberg' ) ) {
	add_filter( 'trx_addons_filter_add_pt_to_gutenberg', 'trx_addons_cpt_team_add_pt_to_gutenberg', 10, 2 );
	function trx_addons_cpt_team_add_pt_to_gutenberg( $allow, $post_type ) {
		return $allow || $post_type == TRX_ADDONS_CPT_TEAM_PT;
	}
}

// Allow Gutenberg as main editor for taxonomies
if ( ! function_exists( 'trx_addons_cpt_team_add_taxonomy_to_gutenberg' ) ) {
	add_filter( 'trx_addons_filter_add_taxonomy_to_gutenberg', 'trx_addons_cpt_team_add_taxonomy_to_gutenberg', 10, 2 );
	function trx_addons_cpt_team_add_taxonomy_to_gutenberg( $allow, $tax ) {
		return $allow || in_array( $tax, array( TRX_ADDONS_CPT_TEAM_TAXONOMY ) );
	}
}

/* ------------------- Old way - moved to the cpt.php now ---------------------
// Add 'Team' parameters in the ThemeREX Addons Options
if (!function_exists('trx_addons_cpt_team_options')) {
	add_filter( 'trx_addons_filter_options', 'trx_addons_cpt_team_options');
	function trx_addons_cpt_team_options($options) {
		trx_addons_array_insert_after($options, 'cpt_section', trx_addons_cpt_team_get_list_options());
		return $options;
	}
}

// Return parameters list for plugin's options
if (!function_exists('trx_addons_cpt_team_get_list_options')) {
	function trx_addons_cpt_team_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'team_info' => array(
				"title" => esc_html__('Team', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the team members archive', 'trx_addons') ),
				"type" => "info"
			),
			'team_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the team archive', 'trx_addons') ),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles',
											trx_addons_components_get_allowed_layouts('cpt', 'team', 'arh'), 
											TRX_ADDONS_CPT_TEAM_PT),
				"type" => "select"
			)
		), 'team');
	}
}
------------------- /Old way --------------------- */

// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_cpt_team_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cpt_team_load_scripts_front');
	function trx_addons_cpt_team_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-cpt_team', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'team/team.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_cpt_team_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cpt_team_load_responsive_styles', 2000);
	function trx_addons_cpt_team_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-cpt_team-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'team/team.responsive.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_cpt_team_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_cpt_team_merge_styles');
	function trx_addons_cpt_team_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'team/team.css';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_cpt_team_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_cpt_team_merge_styles_responsive');
	function trx_addons_cpt_team_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'team/team.responsive.css';
		return $list;
	}
}


// Return true if it's team page
if ( !function_exists( 'trx_addons_is_team_page' ) ) {
	function trx_addons_is_team_page() {
		return defined('TRX_ADDONS_CPT_TEAM_PT') 
					&& !is_search()
					&& (
						(is_single() && get_post_type()==TRX_ADDONS_CPT_TEAM_PT)
						|| is_post_type_archive(TRX_ADDONS_CPT_TEAM_PT)
						|| is_tax(TRX_ADDONS_CPT_TEAM_TAXONOMY)
						);
	}
}



// Replace standard theme templates
//-------------------------------------------------------------

// Change standard single template for team posts
if ( !function_exists( 'trx_addons_cpt_team_single_template' ) ) {
	add_filter('single_template', 'trx_addons_cpt_team_single_template');
	function trx_addons_cpt_team_single_template($template) {
		global $post;
		if (is_single() && $post->post_type == TRX_ADDONS_CPT_TEAM_PT)
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'team/tpl.single.php');
		return $template;
	}
}

// Change standard archive template for team posts
if ( !function_exists( 'trx_addons_cpt_team_archive_template' ) ) {
	add_filter('archive_template',	'trx_addons_cpt_team_archive_template');
	function trx_addons_cpt_team_archive_template( $template ) {
		if ( is_post_type_archive(TRX_ADDONS_CPT_TEAM_PT) )
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'team/tpl.archive.php');
		return $template;
	}	
}

// Change standard category template for team categories (groups)
if ( !function_exists( 'trx_addons_cpt_team_taxonomy_template' ) ) {
	add_filter('taxonomy_template',	'trx_addons_cpt_team_taxonomy_template');
	function trx_addons_cpt_team_taxonomy_template( $template ) {
		if ( is_tax(TRX_ADDONS_CPT_TEAM_TAXONOMY) )
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'team/tpl.archive.php');
		return $template;
	}	
}



// Admin utils
// -----------------------------------------------------------------

// Show <select> with team categories in the admin filters area
if (!function_exists('trx_addons_cpt_team_admin_filters')) {
	add_action( 'restrict_manage_posts', 'trx_addons_cpt_team_admin_filters' );
	function trx_addons_cpt_team_admin_filters() {
		trx_addons_admin_filters(TRX_ADDONS_CPT_TEAM_PT, TRX_ADDONS_CPT_TEAM_TAXONOMY);
	}
}
  
// Clear terms cache on the taxonomy save
if (!function_exists('trx_addons_cpt_team_admin_clear_cache')) {
	add_action( 'edited_'.TRX_ADDONS_CPT_TEAM_TAXONOMY, 'trx_addons_cpt_team_admin_clear_cache', 10, 1 );
	add_action( 'delete_'.TRX_ADDONS_CPT_TEAM_TAXONOMY, 'trx_addons_cpt_team_admin_clear_cache', 10, 1 );
	add_action( 'created_'.TRX_ADDONS_CPT_TEAM_TAXONOMY, 'trx_addons_cpt_team_admin_clear_cache', 10, 1 );
	function trx_addons_cpt_team_admin_clear_cache( $term_id=0 ) {  
		trx_addons_admin_clear_cache_terms(TRX_ADDONS_CPT_TEAM_TAXONOMY);
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'team/team-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'team/team-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'team/team-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'team/team-sc-vc.php';
}

// Create our widget
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT . 'team/team-widget.php';
