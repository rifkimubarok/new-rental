<?php
/**
 * Plugin support: Give (OCDI support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.50
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_ocdi_give_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'trx_addons_ocdi_give_set_options' );
	function trx_addons_ocdi_give_set_options($ocdi_options){
		$ocdi_options['import_give_file_url'] = 'give.txt';
		return $ocdi_options;		
	}
}

// Export Calculated Fields Form
if ( !function_exists( 'trx_addons_ocdi_give_export' ) ) {
	add_filter( 'trx_addons_filter_ocdi_export_files', 'trx_addons_ocdi_give_export' );
	function trx_addons_ocdi_give_export($output){
		$list = array();
		if (trx_addons_exists_give() && in_array('give', trx_addons_ocdi_options('required_plugins'))) {
			// Get plugin data from database			
			$tables = array(
				'give_formmeta',
				'give_donors',
				'give_donormeta',
				'give_logs',
				'give_logmeta',
				'give_paymentmeta',
				'give_sequental_ordering'
			);
			$list = trx_addons_ocdi_export_tables($tables, $list);

			$options = array('give_settings');
			$list = trx_addons_ocdi_export_options($options, $list);
			
			// Save as file
			$file_path = TRX_ADDONS_PLUGIN_OCDI . "export/give.txt";
			trx_addons_fpc(trx_addons_get_file_dir($file_path), serialize($list));
			
			// Return file path
			$output .= '<h4><a href="'. trx_addons_get_file_url($file_path).'" download>'.esc_html__('Give (Donation Form)', 'trx_addons').'</a></h4>';
		}
		return $output;
	}
}

// Add plugin to import list
if ( !function_exists( 'trx_addons_ocdi_give_import_field' ) ) {
	add_filter( 'trx_addons_filter_ocdi_import_fields', 'trx_addons_ocdi_give_import_field' );
	function trx_addons_ocdi_give_import_field($output){
		$list = array();
		if (trx_addons_exists_give() && in_array('give', trx_addons_ocdi_options('required_plugins'))) {
			$output .= '<label><input type="checkbox" name="give" value="give">'. esc_html__( 'Give (Donation Form)', 'trx_addons' ).'</label><br/>';
		}
		return $output;
	}
}

// Import Calculated Fields Form
if ( !function_exists( 'trx_addons_ocdi_give_import' ) ) {
	add_action( 'trx_addons_action_ocdi_import_plugins', 'trx_addons_ocdi_give_import', 10, 1 );
	function trx_addons_ocdi_give_import($import_plugins){
		if (trx_addons_exists_give() && in_array('give', $import_plugins)) {
			trx_addons_ocdi_import_dump('give');
			echo esc_html__('Give (Donation Form) import complete.', 'trx_addons') . "\r\n";
		}
	}
}
