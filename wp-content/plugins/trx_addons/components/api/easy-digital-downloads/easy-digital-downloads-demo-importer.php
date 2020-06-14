<?php
/**
 * Plugin support: Easy Digital Downloads (Importer support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.29
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_edd_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_edd_importer_required_plugins', 10, 2 );
	function trx_addons_edd_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'easy-digital-downloads')!==false && !trx_addons_exists_edd() )
			$not_installed .= '<br>' . esc_html__('Easy Digital Downloads', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_edd_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'trx_addons_edd_importer_set_options' );
	function trx_addons_edd_importer_set_options($options=array()) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $options['required_plugins']) ) {
			$options['additional_options'][] = 'edd_settings';					// Add slugs to export options for this plugin
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_edd'] = str_replace('name.ext', 'easy-digital-downloads.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Prevent import plugin's specific options if plugin is not installed
if ( !function_exists( 'trx_addons_edd_importer_check_options' ) ) {
	add_filter( 'trx_addons_filter_import_theme_options', 'trx_addons_edd_importer_check_options', 10, 4 );
	function trx_addons_edd_importer_check_options($allow, $k, $v, $options) {
		if ($allow && $k == 'edd_settings') {
			$allow = trx_addons_exists_edd() && in_array('easy-digital-downloads', $options['required_plugins']);
		}
		return $allow;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_edd_importer_show_params' ) ) {
	add_action( 'trx_addons_action_importer_params',	'trx_addons_edd_importer_show_params', 10, 1 );
	function trx_addons_edd_importer_show_params($importer) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'edd',
				'title' => esc_html__('Import Easy Digital Downloads', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_edd_importer_import' ) ) {
	add_action( 'trx_addons_action_importer_import',	'trx_addons_edd_importer_import', 10, 2 );
	function trx_addons_edd_importer_import($importer, $action) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			if ( $action == 'import_edd' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('easy-digital-downloads', esc_html__('Easy Digital Downloads meta', 'trx_addons'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_edd_importer_check_row' ) ) {
	add_filter('trx_addons_filter_importer_import_row', 'trx_addons_edd_importer_check_row', 9, 4);
	function trx_addons_edd_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'easy-digital-downloads')===false) return $flag;
		if ( trx_addons_exists_edd() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array('download', 'edd_log', 'edd_discount', 'edd_payment'));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_edd_importer_import_fields' ) ) {
	add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_edd_importer_import_fields', 10, 1 );
	function trx_addons_edd_importer_import_fields($importer) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'edd', 
				'title' => esc_html__('Easy Digital Downloads meta', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_edd_importer_export' ) ) {
	add_action( 'trx_addons_action_importer_export',	'trx_addons_edd_importer_export', 10, 1 );
	function trx_addons_edd_importer_export($importer) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('easy-digital-downloads.txt'), serialize( array(
				"edd_customers"		=> $importer->export_dump("edd_customers"),
				"edd_customermeta"	=> $importer->export_dump("edd_customermeta"),
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_edd_importer_export_fields' ) ) {
	add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_edd_importer_export_fields', 10, 1 );
	function trx_addons_edd_importer_export_fields($importer) {
		if ( trx_addons_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'edd',
				'title' => esc_html__('Easy Digital Downloads', 'trx_addons')
				)
			);
		}
	}
}
