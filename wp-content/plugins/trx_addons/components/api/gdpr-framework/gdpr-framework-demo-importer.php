<?php
/**
 * Plugin support: The GDPR Framework (Importer support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.49
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_gdpr_framework_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_gdpr_framework_importer_required_plugins', 10, 2 );
	function trx_addons_gdpr_framework_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'gdpr-framework')!==false && !trx_addons_exists_gdpr_framework() )
			$not_installed .= '<br>' . esc_html__('The GDPR Framework', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_gdpr_framework_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'trx_addons_gdpr_framework_importer_set_options' );
	function trx_addons_gdpr_framework_importer_set_options($options=array()) {
		if ( trx_addons_exists_gdpr_framework() && in_array('gdpr-framework', $options['required_plugins']) ) {
			if (is_array($options)) {
				$options['additional_options'][] = 'gdpr_%';
			}
		}
		return $options;
	}
}

// Prevent import plugin's specific options if plugin is not installed
if ( !function_exists( 'trx_addons_gdpr_framework_importer_check_options' ) ) {
	add_filter( 'trx_addons_filter_import_theme_options', 'trx_addons_gdpr_framework_importer_check_options', 10, 4 );
	function trx_addons_gdpr_framework_importer_check_options($allow, $k, $v, $options) {
		if ($allow && strpos($k, 'gdpr_')===0) {
			$allow = trx_addons_exists_gdpr_framework() && in_array('gdpr-framework', $options['required_plugins']);
		}
		return $allow;
	}
}
