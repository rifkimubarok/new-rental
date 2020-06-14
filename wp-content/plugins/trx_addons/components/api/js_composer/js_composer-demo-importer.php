<?php
/**
 * Plugin support: WPBakery PageBuilder (Importer support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_vc_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_vc_importer_required_plugins', 10, 2 );
	function trx_addons_vc_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'js_composer')!==false && !trx_addons_exists_vc())
			$not_installed .= '<br>' . esc_html__('WPBakery PageBuilder', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_vc_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'trx_addons_vc_importer_set_options' );
	function trx_addons_vc_importer_set_options($options=array()) {
		if ( trx_addons_exists_vc() && in_array('js_composer', $options['required_plugins']) ) {
			$options['additional_options'][] = 'wpb_js_templates';		// Add slugs to export options for this plugin
		}
		return $options;
	}
}

// Prevent import plugin's specific options if plugin is not installed
if ( !function_exists( 'trx_addons_vc_importer_check_options' ) ) {
	add_filter( 'trx_addons_filter_import_theme_options', 'trx_addons_vc_importer_check_options', 10, 4 );
	function trx_addons_vc_importer_check_options($allow, $k, $v, $options) {
		if ($allow && $k=='wpb_js_templates') {
			$allow = trx_addons_exists_vc() && in_array('js_composer', $options['required_plugins']);
		}
		return $allow;
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_vc_importer_check_row' ) ) {
	add_filter('trx_addons_filter_importer_import_row', 'trx_addons_vc_importer_check_row', 9, 4);
	function trx_addons_vc_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'js_composer')===false) return $flag;
		if ( trx_addons_exists_vc() ) {
			if ($table == 'posts')
				$flag = $row['post_type']=='vc_grid_item';
		}
		return $flag;
	}
}
