<?php
/**
 * Plugin support: MP Timetable (OCDI support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.30
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_ocdi_mp_timetable_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'trx_addons_ocdi_mp_timetable_set_options' );
	function trx_addons_ocdi_mp_timetable_set_options($ocdi_options){
		$ocdi_options['import_mp_timetable_file_url'] = 'mp-timetable.txt';
		return $ocdi_options;		
	}
}

// Export MP Timetable
if ( !function_exists( 'trx_addons_ocdi_mp_timetable_export' ) ) {
	add_filter( 'trx_addons_filter_ocdi_export_files', 'trx_addons_ocdi_mp_timetable_export' );
	function trx_addons_ocdi_mp_timetable_export($output){
		$list = array();
		if (trx_addons_exists_mptt() && in_array('mp-timetable', trx_addons_ocdi_options('required_plugins'))) {
			// Get plugin data from database
			$tables = array('mp_timetable_data');
			$list = trx_addons_ocdi_export_tables($tables, $list);
			
			// Save as file
			$file_path = TRX_ADDONS_PLUGIN_OCDI . "export/mp-timetable.txt";
			trx_addons_fpc(trx_addons_get_file_dir($file_path), serialize($list));
			
			// Return file path
			$output .= '<h4><a href="'. trx_addons_get_file_url($file_path).'" download>'.esc_html__('MP Timetable', 'trx_addons').'</a></h4>';
		}
		return $output;
	}
}

// Add plugin to import list
if ( !function_exists( 'trx_addons_ocdi_mp_timetable_import_field' ) ) {
	add_filter( 'trx_addons_filter_ocdi_import_fields', 'trx_addons_ocdi_mp_timetable_import_field' );
	function trx_addons_ocdi_mp_timetable_import_field($output){
		$list = array();
		if (trx_addons_exists_mptt() && in_array('mp-timetable', trx_addons_ocdi_options('required_plugins'))) {
			$output .= '<label><input type="checkbox" name="mp-timetable" value="mp-timetable">'. esc_html__( 'MP Timetable', 'trx_addons' ).'</label><br/>';
		}
		return $output;
	}
}

// Import MP Timetable
if ( !function_exists( 'trx_addons_ocdi_mp_timetable_import' ) ) {
	add_action( 'trx_addons_action_ocdi_import_plugins', 'trx_addons_ocdi_mp_timetable_import', 10, 1 );
	function trx_addons_ocdi_mp_timetable_import( $import_plugins){
		if (trx_addons_exists_mptt() && in_array('mp-timetable', $import_plugins)) {
			trx_addons_ocdi_import_dump('mp_timetable');
			echo esc_html__('MP Timetable import complete.', 'trx_addons') . "\r\n";	
		}
	}
}
