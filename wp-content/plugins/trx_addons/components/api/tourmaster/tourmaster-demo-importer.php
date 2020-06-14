<?php
/**
 * Plugin support: Tour Master (Importer support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_tourmaster_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_tourmaster_importer_required_plugins', 10, 2 );
	function trx_addons_tourmaster_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'tourmaster')!==false && !trx_addons_exists_tourmaster() )
			$not_installed .= '<br>' . esc_html__('Tour Master', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_tourmaster_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'trx_addons_tourmaster_importer_set_options' );
	function trx_addons_tourmaster_importer_set_options($options=array()) {
		if ( trx_addons_exists_tourmaster() && in_array('tourmaster', $options['required_plugins']) ) {
			$options['additional_options'][] = 'tourmaster_general';					// Add slugs to export options for this plugin
			$options['additional_options'][] = 'tourmaster_color';
			$options['additional_options'][] = 'tourmaster_plugin';
			// Do not export this option, because it contain secret keys
			//$options['additional_options'][] = 'tourmaster_payment';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_tourmaster'] = str_replace('name.ext', 'tourmaster.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Prevent import plugin's specific options if plugin is not installed
if ( !function_exists( 'trx_addons_tourmaster_importer_check_options' ) ) {
	add_filter( 'trx_addons_filter_import_theme_options', 'trx_addons_tourmaster_importer_check_options', 10, 4 );
	function trx_addons_tourmaster_importer_check_options($allow, $k, $v, $options) {
		if ($allow && strpos($k, 'tourmaster_')===0) {
			$allow = trx_addons_exists_tourmaster() && in_array('tourmaster', $options['required_plugins']);
		}
		return $allow;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_tourmaster_importer_show_params' ) ) {
	add_action( 'trx_addons_action_importer_params',	'trx_addons_tourmaster_importer_show_params', 10, 1 );
	function trx_addons_tourmaster_importer_show_params($importer) {
		if ( trx_addons_exists_tourmaster() && in_array('tourmaster', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'tourmaster',
				'title' => esc_html__('Import Tour Master', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_tourmaster_importer_import' ) ) {
	add_action( 'trx_addons_action_importer_import',	'trx_addons_tourmaster_importer_import', 10, 2 );
	function trx_addons_tourmaster_importer_import($importer, $action) {
		if ( trx_addons_exists_tourmaster() && in_array('tourmaster', $importer->options['required_plugins']) ) {
			if ( $action == 'import_tourmaster' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('tourmaster', esc_html__('Tour Master data', 'trx_addons'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_tourmaster_importer_check_row' ) ) {
	add_filter('trx_addons_filter_importer_import_row', 'trx_addons_tourmaster_importer_check_row', 9, 4);
	function trx_addons_tourmaster_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'tourmaster')===false) return $flag;
		if ( trx_addons_exists_tourmaster() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array(TRX_ADDONS_TOURMASTER_CPT_TOUR, TRX_ADDONS_TOURMASTER_CPT_TOUR_COUPON, TRX_ADDONS_TOURMASTER_CPT_TOUR_SERVICE));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_tourmaster_importer_import_fields' ) ) {
	add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_tourmaster_importer_import_fields', 10, 1 );
	function trx_addons_tourmaster_importer_import_fields($importer) {
		if ( trx_addons_exists_tourmaster() && in_array('tourmaster', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'tourmaster', 
				'title' => esc_html__('Tour Master', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_tourmaster_importer_export' ) ) {
	add_action( 'trx_addons_action_importer_export',	'trx_addons_tourmaster_importer_export', 10, 1 );
	function trx_addons_tourmaster_importer_export($importer) {
		if ( trx_addons_exists_tourmaster() && in_array('tourmaster', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('tourmaster.txt'), serialize( array(
				"tourmaster_order"	=> $importer->export_dump("tourmaster_order"),
				"tourmaster_review"	=> $importer->export_dump("tourmaster_review")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_tourmaster_importer_export_fields' ) ) {
	add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_tourmaster_importer_export_fields', 10, 1 );
	function trx_addons_tourmaster_importer_export_fields($importer) {
		if ( trx_addons_exists_tourmaster() && in_array('tourmaster', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'tourmaster',
				'title' => esc_html__('Tour Master', 'trx_addons')
				)
			);
		}
	}
}
