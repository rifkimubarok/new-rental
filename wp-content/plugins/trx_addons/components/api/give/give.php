<?php
/**
 * Plugin support: Give
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.50
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

if ( ! defined( 'TRX_ADDONS_GIVE_FORMS_PT_FORMS' ) )			define( 'TRX_ADDONS_GIVE_FORMS_PT_FORMS', 'give_forms' );
if ( ! defined( 'TRX_ADDONS_GIVE_FORMS_PT_PAYMENT' ) )			define( 'TRX_ADDONS_GIVE_FORMS_PT_PAYMENT', 'give_payment' );
if ( ! defined( 'TRX_ADDONS_GIVE_FORMS_TAXONOMY_CATEGORY' ) )	define( 'TRX_ADDONS_GIVE_FORMS_TAXONOMY_CATEGORY', 'give_forms_category' );
if ( ! defined( 'TRX_ADDONS_GIVE_FORMS_TAXONOMY_TAG' ) )		define( 'TRX_ADDONS_GIVE_FORMS_TAXONOMY_TAG', 'give_forms_tag' );


// Check if plugin is installed and activated
if ( !function_exists( 'trx_addons_exists_give' ) ) {
	function trx_addons_exists_give() {
		return class_exists( 'Give' );
	}
}

// Return true, if current page is Give plugin's page
if ( !function_exists( 'trx_addons_is_give_page' ) ) {
	function trx_addons_is_give_page() {
		$rez = false;
		if (trx_addons_exists_give()) {
			$rez = (is_single() && in_array(get_query_var('post_type'), array(TRX_ADDONS_GIVE_FORMS_PT_FORMS, TRX_ADDONS_GIVE_FORMS_PT_PAYMENT))) 
					|| is_post_type_archive(TRX_ADDONS_GIVE_FORMS_PT_FORMS) 
					|| is_post_type_archive(TRX_ADDONS_GIVE_FORMS_PT_PAYMENT) 
					|| is_tax(TRX_ADDONS_GIVE_FORMS_TAXONOMY_CATEGORY)
					|| is_tax(TRX_ADDONS_GIVE_FORMS_TAXONOMY_TAG);
		}
		return $rez;
	}
}

// Return forms list, prepended inherit (if need)
if ( !function_exists( 'trx_addons_get_list_give_forms' ) ) {
	function trx_addons_get_list_give_forms($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			if (trx_addons_exists_give()) {
				$list = trx_addons_get_list_posts(false, array(
														'post_type' => TRX_ADDONS_GIVE_FORMS_PT_FORMS,
														'not_selected' => false
														));
			}
		}
		return $prepend_inherit ? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) : $list;
	}
}



// Load required scripts and styles
//------------------------------------------------------------------------

// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_give_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_give_load_scripts_front', 11);
	function trx_addons_give_load_scripts_front() {
		if ( trx_addons_exists_give() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-give', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'give/give.css'), array(), null );
		}
	}
}

// Merge specific styles into single stylesheet
if ( !function_exists( 'trx_addons_give_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_give_merge_styles');
	function trx_addons_give_merge_styles($list) {
		if (trx_addons_exists_give())
			$list[] = TRX_ADDONS_PLUGIN_API . 'give/give.css';
		return $list;
	}
}



// Support utils
//------------------------------------------------------------------------

// Plugin init
if ( !function_exists( 'trx_addons_give_init' ) ) {
	add_action("init", 'trx_addons_give_init');
	function trx_addons_give_init() {
		if (trx_addons_exists_give()) {
			remove_action( 'give_single_form_summary', 'give_template_single_title', 5 );
		}
	}
}

// Replace single title with h2 instead h1
if ( !function_exists( 'trx_addons_give_single_title' ) ) {
	add_action("give_single_form_summary", 'trx_addons_give_single_title', 5);
	function trx_addons_give_single_title() {
		?><h2 itemprop="name" class="give-form-title entry-title"><?php the_title(); ?></h2><?php
	}
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_give() && trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'give/give-sc-elementor.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_give() && trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'give/give-sc-vc.php';
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'give/give-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_give() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'give/give-demo-ocdi.php';
}
