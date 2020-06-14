<?php
/**
 * Plugin support: Content Timeline
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if plugin is installed and activated
if ( !function_exists( 'trx_addons_exists_content_timeline' ) ) {
	function trx_addons_exists_content_timeline() {
		return class_exists( 'ContentTimelineAdmin' );
	}
}

// Return Content Timelines list, prepended inherit (if need)
if ( !function_exists( 'trx_addons_get_list_content_timelines' ) ) {
	function trx_addons_get_list_content_timelines($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			if (trx_addons_exists_content_timeline()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT id, name FROM " . esc_sql($wpdb->prefix . 'ctimelines') );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->id] = $row->name;
					}
				}
			}
		}
		return $prepend_inherit ? array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) : $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_content_timeline() && trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'content_timeline/content_timeline-sc-elementor.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_content_timeline() && trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'content_timeline/content_timeline-sc-vc.php';
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'content_timeline/content_timeline-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_content_timeline() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'content_timeline/content_timeline-demo-ocdi.php';
}
