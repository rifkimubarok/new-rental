<?php
/**
 * Plugin support: MP Timetable (Importer support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.30
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_mptt_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_mptt_importer_required_plugins', 10, 2 );
	function trx_addons_mptt_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'mp-timetable')!==false && !trx_addons_exists_mptt() )
			$not_installed .= '<br>' . esc_html__('MP TimeTable', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_mptt_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'trx_addons_mptt_importer_set_options' );
	function trx_addons_mptt_importer_set_options($options=array()) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $options['required_plugins']) ) {
			//$options['additional_options'][]	= 'mptt_%';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_mp-timetable'] = str_replace('name.ext', 'mp-timetable.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_mptt_importer_show_params' ) ) {
	add_action( 'trx_addons_action_importer_params',	'trx_addons_mptt_importer_show_params', 10, 1 );
	function trx_addons_mptt_importer_show_params($importer) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'mp-timetable',
				'title' => esc_html__('Import MP TimeTable', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_mptt_importer_import' ) ) {
	add_action( 'trx_addons_action_importer_import',	'trx_addons_mptt_importer_import', 10, 2 );
	function trx_addons_mptt_importer_import($importer, $action) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			if ( $action == 'import_mp-timetable' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('mp-timetable', esc_html__('MP TimeTable data', 'trx_addons'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_mptt_importer_check_row' ) ) {
	add_filter('trx_addons_filter_importer_import_row', 'trx_addons_mptt_importer_check_row', 9, 4);
	function trx_addons_mptt_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'mp-timetable')===false) return $flag;
		if ( trx_addons_exists_mptt() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array(TRX_ADDONS_MPTT_PT_EVENT, TRX_ADDONS_MPTT_PT_COLUMN));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_mptt_importer_import_fields' ) ) {
	add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_mptt_importer_import_fields', 10, 1 );
	function trx_addons_mptt_importer_import_fields($importer) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'mp-timetable', 
				'title' => esc_html__('MP TimeTable data', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_mptt_importer_export' ) ) {
	add_action( 'trx_addons_action_importer_export',	'trx_addons_mptt_importer_export', 10, 1 );
	function trx_addons_mptt_importer_export($importer) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('mp-timetable.txt'), serialize( array(
				"mp_timetable_data"	=> $importer->export_dump("mp_timetable_data")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_mptt_importer_export_fields' ) ) {
	add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_mptt_importer_export_fields', 10, 1 );
	function trx_addons_mptt_importer_export_fields($importer) {
		if ( trx_addons_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'mp-timetable',
				'title' => esc_html__('MP TimeTable', 'trx_addons')
				)
			);
		}
	}
}
