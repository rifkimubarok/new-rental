<?php
/**
 * Plugin support: Contact Form 7
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_ocdi_cf7_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'trx_addons_ocdi_cf7_set_options' );
	function trx_addons_ocdi_cf7_set_options($ocdi_options){
		$ocdi_options['import_cf7_file_url'] = 'contact-form-7.txt';
		return $ocdi_options;		
	}
}

// Export Contact Form 7
if ( !function_exists( 'trx_addons_ocdi_cf7_export' ) ) {
	add_filter( 'trx_addons_filter_ocdi_export_files', 'trx_addons_ocdi_cf7_export' );
	function trx_addons_ocdi_cf7_export($output){
		$list = array();
		if (trx_addons_exists_cf7() && in_array('contact-form-7', trx_addons_ocdi_options('required_plugins'))) {
			// Get plugin data from database
			$options = array('wpcf7');
			$list = trx_addons_ocdi_export_options($options, $list);
			
			// Save as file
			$file_path = TRX_ADDONS_PLUGIN_OCDI . "export/contact-form-7.txt";
			trx_addons_fpc(trx_addons_get_file_dir($file_path), serialize($list));
			
			// Return file path
			$output .= '<h4><a href="'. trx_addons_get_file_url($file_path).'" download>'.esc_html__('Contact Form 7', 'trx_addons').'</a></h4>';
		}
		return $output;
	}
}

// Add plugin to import list
if ( !function_exists( 'trx_addons_ocdi_cf7_import_field' ) ) {
	add_filter( 'trx_addons_filter_ocdi_import_fields', 'trx_addons_ocdi_cf7_import_field' );
	function trx_addons_ocdi_cf7_import_field($output){
		$list = array();
		if (trx_addons_exists_cf7() && in_array('contact-form-7', trx_addons_ocdi_options('required_plugins'))) {
			$output .= '<label><input type="checkbox" name="contact-form-7" value="contact-form-7">'. esc_html__( 'Contact Form 7', 'trx_addons' ).'</label><br/>';
		}
		return $output;
	}
}

// Import Contact Form 7
if ( !function_exists( 'trx_addons_ocdi_cf7_import' ) ) {
	add_action( 'trx_addons_action_ocdi_import_plugins', 'trx_addons_ocdi_cf7_import', 10, 1 );
	function trx_addons_ocdi_cf7_import( $import_plugins){
		if (trx_addons_exists_cf7() && in_array('contact-form-7', $import_plugins)) {
			trx_addons_ocdi_import_dump('cf7');
			echo esc_html__('Contact Form 7 import complete.', 'trx_addons') . "\r\n";
		}
	}
}
