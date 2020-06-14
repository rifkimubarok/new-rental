<?php
/**
 * Plugin support: Calculated Fields Form (OCDI support)
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
if ( !function_exists( 'trx_addons_ocdi_calculated_fields_form_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'trx_addons_ocdi_calculated_fields_form_set_options' );
	function trx_addons_ocdi_calculated_fields_form_set_options($ocdi_options){
		$ocdi_options['import_calculated_fields_form_file_url'] = 'calculated_fields_form.txt';
		return $ocdi_options;		
	}
}

// Export Calculated Fields Form
if ( !function_exists( 'trx_addons_ocdi_calculated_fields_form_export' ) ) {
	add_filter( 'trx_addons_filter_ocdi_export_files', 'trx_addons_ocdi_calculated_fields_form_export' );
	function trx_addons_ocdi_calculated_fields_form_export($output){
		$list = array();
		if (trx_addons_exists_calculated_fields_form() && in_array('calculated-fields-form', trx_addons_ocdi_options('required_plugins'))) {
			// Get plugin data from database			
			$tables = array('cp_calculated_fields_form_settings');
			$list = trx_addons_ocdi_export_tables($tables, $list);

			$options = array('CP_CFF_LOAD_SCRIPTS', 'CP_CALCULATEDFIELDSF_USE_CACHE', 'CP_CALCULATEDFIELDSF_EXCLUDE_CRAWLERS');
			$list = trx_addons_ocdi_export_options($options, $list);
			
			// Save as file
			$file_path = TRX_ADDONS_PLUGIN_OCDI . "export/calculated_fields_form.txt";
			trx_addons_fpc(trx_addons_get_file_dir($file_path), serialize($list));
			
			// Return file path
			$output .= '<h4><a href="'. trx_addons_get_file_url($file_path).'" download>'.esc_html__('Calculated Fields Form', 'trx_addons').'</a></h4>';
		}
		return $output;
	}
}

// Add plugin to import list
if ( !function_exists( 'trx_addons_ocdi_calculated_fields_form_import_field' ) ) {
	add_filter( 'trx_addons_filter_ocdi_import_fields', 'trx_addons_ocdi_calculated_fields_form_import_field' );
	function trx_addons_ocdi_calculated_fields_form_import_field($output){
		$list = array();
		if (trx_addons_exists_calculated_fields_form() && in_array('calculated-fields-form', trx_addons_ocdi_options('required_plugins'))) {
			$output .= '<label><input type="checkbox" name="calculated_fields_form" value="calculated_fields_form">'. esc_html__( 'Calculated Fields Form', 'trx_addons' ).'</label><br/>';
		}
		return $output;
	}
}

// Import Calculated Fields Form
if ( !function_exists( 'trx_addons_ocdi_calculated_fields_form_import' ) ) {
	add_action( 'trx_addons_action_ocdi_import_plugins', 'trx_addons_ocdi_calculated_fields_form_import', 10, 1 );
	function trx_addons_ocdi_calculated_fields_form_import($import_plugins){
		if (trx_addons_exists_calculated_fields_form() && in_array('calculated_fields_form', $import_plugins)) {
			trx_addons_ocdi_import_dump('calculated_fields_form');
			echo esc_html__('Calculated Fields Form import complete.', 'trx_addons') . "\r\n";
		}
	}
}
