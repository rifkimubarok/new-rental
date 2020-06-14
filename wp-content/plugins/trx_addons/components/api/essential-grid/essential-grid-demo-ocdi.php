<?php
/**
 * Plugin support: Essential Grid (OCDI support)
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
if ( !function_exists( 'trx_addons_ocdi_essential_grid_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_ocdi_options', 'trx_addons_ocdi_essential_grid_set_options' );
	function trx_addons_ocdi_essential_grid_set_options($ocdi_options){
		$ocdi_options['import_essential_grid_file_url'] = 'ess_grid.json';
		return $ocdi_options;		
	}
}

// Add plugin to import list
if ( !function_exists( 'trx_addons_ocdi_essential_grid_import_field' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_ocdi_import_fields', 'trx_addons_ocdi_essential_grid_import_field' );
	function trx_addons_ocdi_essential_grid_import_field($output){
		$list = array();
		if (trx_addons_exists_essential_grid() && in_array('essential-grid', trx_addons_ocdi_options('required_plugins'))) {
			$output .= '<label><input type="checkbox" name="essential-grid" value="essential-grid">'. esc_html__( 'Essential Grid', 'trx_addons' ).'</label><br/>';
		}
		return $output;
	}
}

// Import Essential Grid
if ( !function_exists( 'trx_addons_ocdi_essential_grid_import' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_ocdi_import_plugins', 'trx_addons_ocdi_essential_grid_import', 10, 1 );
	function trx_addons_ocdi_essential_grid_import($import_plugins){
		if (trx_addons_exists_essential_grid() && in_array('essential-grid', $import_plugins)) {
			// Delete all data from tables
			trx_addons_essential_grid_clear_tables();
			
			// Get Essential Grid export file
			$json = trx_addons_ocdi_options('import_essential_grid_file_url');
			
			// Read JSON file
			$txt = trx_addons_fgc($json);			
			trx_addons_essential_grid_import($txt);
		}
	}
}
