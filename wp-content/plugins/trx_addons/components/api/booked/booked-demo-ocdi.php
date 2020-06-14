<?php
/**
 * Plugin support: Booked Appointments (OCDI support)
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
if ( !function_exists( 'trx_addons_ocdi_booked_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'trx_addons_ocdi_booked_set_options' );
	function trx_addons_ocdi_booked_set_options($ocdi_options){
		$ocdi_options['import_booked_file_url'] = 'booked.txt';
		return $ocdi_options;		
	}
}

// Export Booked Calendar
if ( !function_exists( 'trx_addons_ocdi_booked_export' ) ) {
	add_filter( 'trx_addons_filter_ocdi_export_files', 'trx_addons_ocdi_booked_export' );
	function trx_addons_ocdi_booked_export($output){
		$list = array();
		if (trx_addons_exists_booked() && in_array('booked', trx_addons_ocdi_options('required_plugins'))) {
			// Get plugin data from database
			$options = array('booked_%');
			$list = trx_addons_ocdi_export_options($options, $list);
			
			// Save as file
			$file_path = TRX_ADDONS_PLUGIN_OCDI . "export/booked.txt";
			trx_addons_fpc(trx_addons_get_file_dir($file_path), serialize($list));
			
			// Return file path
			$output .= '<h4><a href="'. trx_addons_get_file_url($file_path).'" download>'.esc_html__('Booked Calendar', 'trx_addons').'</a></h4>';
		}
		return $output;
	}
}

// Add plugin to import list
if ( !function_exists( 'trx_addons_ocdi_booked_import_field' ) ) {
	add_filter( 'trx_addons_filter_ocdi_import_fields', 'trx_addons_ocdi_booked_import_field' );
	function trx_addons_ocdi_booked_import_field($output){
		$list = array();
		if (trx_addons_exists_booked() && in_array('booked', trx_addons_ocdi_options('required_plugins'))) {
			$output .= '<label><input type="checkbox" name="booked" value="booked">'. esc_html__( 'Booked Calendar', 'trx_addons' ).'</label><br/>';
		}
		return $output;
	}
}

// Import Booked Calendar
if ( !function_exists( 'trx_addons_ocdi_booked_import' ) ) {
	add_action( 'trx_addons_action_ocdi_import_plugins', 'trx_addons_ocdi_booked_import', 10, 1 );
	function trx_addons_ocdi_booked_import( $import_plugins){
		if (trx_addons_exists_booked() && in_array('booked', $import_plugins)) {
			trx_addons_ocdi_import_dump('booked');
			echo esc_html__('Booked Calendar import complete.', 'trx_addons') . "\r\n";
		}
	}
}
