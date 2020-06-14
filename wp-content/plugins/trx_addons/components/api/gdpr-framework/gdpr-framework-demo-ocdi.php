<?php
/**
 * Plugin support: The GDPR Framework (OCDI support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.49
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_ocdi_gdpr_framework_feed_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'trx_addons_ocdi_gdpr_framework_feed_set_options' );
	function trx_addons_ocdi_gdpr_framework_feed_set_options($ocdi_options){
		$ocdi_options['import_gdpr-framework_file_url'] = 'gdpr-framework.txt';
		return $ocdi_options;		
	}
}

// Export plugin's data
if ( !function_exists( 'trx_addons_ocdi_gdpr_framework_export' ) ) {
	add_filter( 'trx_addons_filter_ocdi_export_files', 'trx_addons_ocdi_gdpr_framework_export' );
	function trx_addons_ocdi_gdpr_framework_export($output){
		$list = array();
		if (trx_addons_exists_gdpr_framework() && in_array('gdpr-framework', trx_addons_ocdi_options('required_plugins'))) {
			// Get plugin data from database
			$options = array('gdpr_%');
			$list = trx_addons_ocdi_export_options($options, $list);
			
			// Save as file
			$file_path = TRX_ADDONS_PLUGIN_OCDI . "export/gdpr-framework.txt";
			trx_addons_fpc(trx_addons_get_file_dir($file_path), serialize($list));
			
			// Return file path
			$output .= '<h4><a href="'. trx_addons_get_file_url($file_path).'" download>'.esc_html__('The GDPR Framework', 'trx_addons').'</a></h4>';
		}
		return $output;
	}
}

// Add plugin to import list
if ( !function_exists( 'trx_addons_ocdi_gdpr_framework_import_field' ) ) {
	add_filter( 'trx_addons_filter_ocdi_import_fields', 'trx_addons_ocdi_gdpr_framework_import_field' );
	function trx_addons_ocdi_gdpr_framework_import_field($output){
		$list = array();
		if (trx_addons_exists_gdpr_framework() && in_array('gdpr-framework', trx_addons_ocdi_options('required_plugins'))) {
			$output .= '<label><input type="checkbox" name="gdpr-framework" value="gdpr-framework">'. esc_html__( 'The GDPR Framework', 'trx_addons' ).'</label><br/>';
		}
		return $output;
	}
}

// Import plugin's data
if ( !function_exists( 'trx_addons_ocdi_gdpr_framework_import' ) ) {
	add_action( 'trx_addons_action_ocdi_import_plugins', 'trx_addons_ocdi_gdpr_framework_import', 10, 1 );
	function trx_addons_ocdi_gdpr_framework_import( $import_plugins){
		if (trx_addons_exists_gdpr_framework() && in_array('gdpr-framework', $import_plugins)) {
			trx_addons_ocdi_import_dump('gdpr-framework');
			echo esc_html__('The GDPR Framework import complete.', 'trx_addons') . "\r\n";
		}
	}
}
