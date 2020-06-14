<?php
/**
 * Plugin support: Uber Menu (Importer support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_ubermenu_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_ubermenu_importer_required_plugins', 10, 2 );
	function trx_addons_ubermenu_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'ubermenu')!==false && !trx_addons_exists_ubermenu() )
			$not_installed .= '<br>' . esc_html__('UberMenu', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_ubermenu_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'trx_addons_ubermenu_importer_set_options', 10, 1 );
	function trx_addons_ubermenu_importer_set_options($options=array()) {
		if ( trx_addons_exists_ubermenu() && in_array('ubermenu', $options['required_plugins']) ) {
			$options['additional_options'][]	= 'ubermenu_%';				// Add slugs to export options of this plugin
		}
		return $options;
	}
}

// Prevent import plugin's specific options if plugin is not installed
if ( !function_exists( 'trx_addons_ubermenu_importer_check_options' ) ) {
	add_filter( 'trx_addons_filter_import_theme_options', 'trx_addons_ubermenu_importer_check_options', 10, 4 );
	function trx_addons_ubermenu_importer_check_options($allow, $k, $v, $options) {
		if ($allow && strpos($k, 'ubermenu_')===0) {
			$allow = trx_addons_exists_ubermenu() && in_array('ubermenu', $options['required_plugins']);
		}
		return $allow;
	}
}
