<?php
/**
 * Plugin support: Content Timeline (Importer support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_content_timeline_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_content_timeline_importer_required_plugins', 10, 2 );
	function trx_addons_content_timeline_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'content_timeline')!==false && !trx_addons_exists_content_timeline() )
			$not_installed .= '<br>' . esc_html__('Content Timeline', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_content_timeline_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'trx_addons_content_timeline_importer_set_options' );
	function trx_addons_content_timeline_importer_set_options($options=array()) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $options['required_plugins']) ) {
			//$options['additional_options'][] = 'content_timeline_calendar_options';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_content_timeline'] = str_replace('name.ext', 'content_timeline.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_content_timeline_importer_show_params' ) ) {
	add_action( 'trx_addons_action_importer_params',	'trx_addons_content_timeline_importer_show_params', 10, 1 );
	function trx_addons_content_timeline_importer_show_params($importer) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'content_timeline',
				'title' => esc_html__('Import Content Timeline', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_content_timeline_importer_import' ) ) {
	add_action( 'trx_addons_action_importer_import',	'trx_addons_content_timeline_importer_import', 10, 2 );
	function trx_addons_content_timeline_importer_import($importer, $action) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			if ( $action == 'import_content_timeline' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('content_timeline', esc_html__('Content Timeline', 'trx_addons'));
			}
		}
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_content_timeline_importer_import_fields' ) ) {
	add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_content_timeline_importer_import_fields', 10, 1 );
	function trx_addons_content_timeline_importer_import_fields($importer) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'	=> 'content_timeline', 
				'title'	=> esc_html__('Content Timeline', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_content_timeline_importer_export' ) ) {
	add_action( 'trx_addons_action_importer_export',	'trx_addons_content_timeline_importer_export', 10, 1 );
	function trx_addons_content_timeline_importer_export($importer) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('content_timeline.txt'), serialize( array(
				'ctimelines' => $importer->export_dump('ctimelines')
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_content_timeline_importer_export_fields' ) ) {
	add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_content_timeline_importer_export_fields', 10, 1 );
	function trx_addons_content_timeline_importer_export_fields($importer) {
		if ( trx_addons_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'content_timeline',
				'title' => esc_html__('Content Timeline', 'trx_addons')
				)
			);
		}
	}
}
