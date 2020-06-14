<?php
/**
 * Plugin support: Essential Grid
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
if ( !function_exists( 'trx_addons_exists_essential-grid' ) ) {
	function trx_addons_exists_essential_grid() {
		return defined('EG_PLUGIN_PATH');
	}
}
	
// Add plugin-specific slugs to the list of the scripts, that don't move to the footer and don't add 'defer' param
if ( !function_exists( 'trx_addons_essential_grid_not_defer_scripts' ) ) {
	add_filter("trx_addons_filter_skip_move_scripts_down", 'trx_addons_essential_grid_not_defer_scripts');
	add_filter("trx_addons_filter_skip_async_scripts_load", 'trx_addons_essential_grid_not_defer_scripts');
	function trx_addons_essential_grid_not_defer_scripts($list) {
		if ( trx_addons_exists_essential_grid() ) {
			$list[] = 'essential-grid';
		}
		return $list;
	}
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'essential-grid/essential-grid-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_essential_grid() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'essential-grid/essential-grid-demo-ocdi.php';
}
