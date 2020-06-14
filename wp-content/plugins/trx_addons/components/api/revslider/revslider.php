<?php
/**
 * Plugin support: Revolution Slider
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if RevSlider installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_addons_exists_revslider' ) ) {
	function trx_addons_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
*/

// Return RevSliders list, prepended inherit (if need)
if ( !function_exists( 'trx_addons_get_list_revsliders' ) ) {
	function trx_addons_get_list_revsliders($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			if (trx_addons_exists_revslider()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT alias, title FROM " . esc_sql($wpdb->prefix) . "revslider_sliders" );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->alias] = $row->title;
					}
				}
			}
		}
		return $prepend_inherit ? array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) : $list;
	}
}


// Add RevSlider to the slider engines
if ( !function_exists( 'trx_addons_add_revslider_to_engines' ) ) {
	add_filter('trx_addons_filter_get_list_sc_slider_engines', 'trx_addons_add_revslider_to_engines');
	function trx_addons_add_revslider_to_engines($list) {
		if (trx_addons_exists_revslider()) {
			$list["revo"] = esc_html__("Layer slider (Revolution)", 'trx_addons');
		}
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Gutenberg
if ( trx_addons_exists_revslider() && trx_addons_exists_gutenberg() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'revslider/revslider-sc-gutenberg.php';
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'revslider/revslider-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_revslider() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'revslider/revslider-demo-ocdi.php';
}
