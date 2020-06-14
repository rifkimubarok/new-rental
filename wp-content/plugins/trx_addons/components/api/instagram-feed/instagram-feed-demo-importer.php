<?php
/**
 * Plugin support: Instagram Feed (Importer supoort)
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
if ( !function_exists( 'trx_addons_instagram_feed_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_instagram_feed_importer_required_plugins', 10, 2 );
	function trx_addons_instagram_feed_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'instagram-feed')!==false && !trx_addons_exists_instagram_feed() )
			$not_installed .= '<br>' . esc_html__('Instagram Feed', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_instagram_feed_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'trx_addons_instagram_feed_importer_set_options' );
	function trx_addons_instagram_feed_importer_set_options($options=array()) {
		if (trx_addons_exists_instagram_feed() && in_array('instagram-feed', $options['required_plugins'])) {
			if (is_array($options)) {
				$options['additional_options'][] = 'sb_instagram_settings';		// Add slugs to export options for this plugin
			}
		}
		return $options;
	}
}

// Prevent import plugin's specific options if plugin is not installed
if ( !function_exists( 'trx_addons_instagram_feed_importer_check_options' ) ) {
	add_filter( 'trx_addons_filter_import_theme_options', 'trx_addons_instagram_feed_importer_check_options', 10, 4 );
	function trx_addons_instagram_feed_importer_check_options($allow, $k, $v, $options) {
		if ($allow && $k == 'sb_instagram_settings') {
			$allow = trx_addons_exists_instagram_feed() && in_array('instagram-feed', $options['required_plugins']);
		}
		return $allow;
	}
}
