<?php
/**
 * Plugin support: MP Timetable
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.30
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


if (!defined('TRX_ADDONS_MPTT_PT_EVENT')) define('TRX_ADDONS_MPTT_PT_EVENT', 'mp-event');
if (!defined('TRX_ADDONS_MPTT_PT_COLUMN')) define('TRX_ADDONS_MPTT_PT_COLUMN', 'mp-column');
if (!defined('TRX_ADDONS_MPTT_TAXONOMY_CATEGORY')) define('TRX_ADDONS_MPTT_TAXONOMY_CATEGORY', 'mp-event_category');


// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_mptt' ) ) {
	function trx_addons_exists_mptt() {
		return class_exists('Mp_Time_Table');
	}
}

// Return true, if current page is any mp_timetable page
if ( !function_exists( 'trx_addons_is_mptt_page' ) ) {
	function trx_addons_is_mptt_page() {
		$rez = false;
		if (trx_addons_exists_mptt())
			return !is_search()
						&& (
							(is_single() && get_post_type()==TRX_ADDONS_MPTT_PT_EVENT)
							|| is_post_type_archive(TRX_ADDONS_MPTT_PT_EVENT)
							|| is_tax(TRX_ADDONS_MPTT_TAXONOMY_CATEGORY)
							);
		return $rez;
	}
}


// Return taxonomy for current post type
if ( !function_exists( 'trx_addons_mptt_post_type_taxonomy' ) ) {
	add_filter( 'trx_addons_filter_post_type_taxonomy',	'trx_addons_mptt_post_type_taxonomy', 10, 2 );
	function trx_addons_mptt_post_type_taxonomy($tax='', $post_type='') {
		if ($post_type == TRX_ADDONS_MPTT_PT_EVENT)
			$tax = TRX_ADDONS_MPTT_TAXONOMY_CATEGORY;
		return $tax;
	}
}



// Load required scripts and styles
//------------------------------------------------------------------------

// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_mptt_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_mptt_load_scripts_front', 11);
	function trx_addons_mptt_load_scripts_front() {
		if ( trx_addons_exists_mptt() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-mp-timetable', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'mp-timetable/mp-timetable.css'), array(), null );
		}
	}
}
	
// Merge specific styles into single stylesheet
if ( !function_exists( 'trx_addons_mptt_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_mptt_merge_styles');
	function trx_addons_mptt_merge_styles($list) {
		if (trx_addons_exists_mptt())
			$list[] = TRX_ADDONS_PLUGIN_API . 'mp-timetable/mp-timetable.css';
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_mptt() && trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'mp-timetable/mp-timetable-sc-elementor.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_mptt() && trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'mp-timetable/mp-timetable-sc-vc.php';
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'mp-timetable/mp-timetable-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_mptt() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'mp-timetable/mp-timetable-demo-ocdi.php';
}
