<?php
/**
 * Plugin support: Uber Menu
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_ubermenu' ) ) {
	function trx_addons_exists_ubermenu() {
		return class_exists('UberMenu');
	}
}
	

// Return true if theme location is assigned to UberMenu
if ( !function_exists( 'trx_addons_ubermenu_check_location' ) ) {
	function trx_addons_ubermenu_check_location($loc) {
		$rez = false;
		if (trx_addons_exists_ubermenu()) {
			$theme_loc = ubermenu_op( 'auto_theme_location', 'main' );
			$rez = !empty($theme_loc[$loc]);
		}
		return $rez;
	}
}

// Return true if theme location is assigned to UberMenu
if ( !function_exists( 'trx_addons_ubermenu_is_complex_menu' ) ) {
	add_filter( 'trx_addons_filter_is_complex_menu', 'trx_addons_ubermenu_is_complex_menu', 10, 2 );
	function trx_addons_ubermenu_is_complex_menu($rez, $loc) {
		return $rez || trx_addons_ubermenu_check_location($loc);
	}
}

// Disable menu cache if UberMenu is active control current menu
if (!function_exists('trx_addons_ubermenu_use_menu_cache')) {
	add_filter('trx_addons_add_menu_cache', 'trx_addons_ubermenu_use_menu_cache');
	add_filter('trx_addons_get_menu_cache', 'trx_addons_ubermenu_use_menu_cache');
	function trx_addons_ubermenu_use_menu_cache($use, $args=array()) {
		if ( !empty($args['location']) && trx_addons_ubermenu_check_location($args['location'])) {
			$use = false;
		}
		return $use;
	}
}



// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'ubermenu/ubermenu-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_ubermenu() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'ubermenu/ubermenu-demo-ocdi.php';
}
