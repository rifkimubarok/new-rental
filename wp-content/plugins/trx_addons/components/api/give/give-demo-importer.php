<?php
/**
 * Plugin support: Give (Importer support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.50
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_give_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_give_importer_required_plugins', 10, 2 );
	function trx_addons_give_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'give')!==false && !trx_addons_exists_give() )
			$not_installed .= '<br>' . esc_html__('Give (Donation Form)', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_give_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'trx_addons_give_importer_set_options', 10, 1 );
	function trx_addons_give_importer_set_options($options=array()) {
		if ( trx_addons_exists_give() && in_array('give', $options['required_plugins']) ) {
			$options['additional_options'][] = 'give_settings';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_give'] = str_replace('name.ext', 'give.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Prevent import plugin's specific options if plugin is not installed
if ( !function_exists( 'trx_addons_give_importer_check_options' ) ) {
	add_filter( 'trx_addons_filter_import_theme_options', 'trx_addons_give_importer_check_options', 10, 4 );
	function trx_addons_give_importer_check_options($allow, $k, $v, $options) {
		if ($allow && $k == 'give_settings') {
			$allow = trx_addons_exists_give() && in_array('give', $options['required_plugins']);
		}
		return $allow;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_give_importer_show_params' ) ) {
	add_action( 'trx_addons_action_importer_params',	'trx_addons_give_importer_show_params', 10, 1 );
	function trx_addons_give_importer_show_params($importer) {
		if ( trx_addons_exists_give() && in_array('give', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'give',
				'title' => esc_html__('Import Give (Donation Form)', 'trx_addons'),
				'part' => 1
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_give_importer_import' ) ) {
	add_action( 'trx_addons_action_importer_import',	'trx_addons_give_importer_import', 10, 2 );
	function trx_addons_give_importer_import($importer, $action) {
		if ( trx_addons_exists_give() && in_array('give', $importer->options['required_plugins']) ) {
			if ( $action == 'import_give' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('give', esc_html__('Give (Donation Form)', 'trx_addons'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_give_importer_check_row' ) ) {
	add_filter('trx_addons_filter_importer_import_row', 'trx_addons_give_importer_check_row', 9, 4);
	function trx_addons_give_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'give')===false) return $flag;
		if ( trx_addons_exists_give() ) {
			if ($table == 'posts') {
				$flag = in_array($row['post_type'], array(TRX_ADDONS_GIVE_FORMS_PT_FORMS, TRX_ADDONS_GIVE_FORMS_PT_PAYMENT));
			}
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_give_importer_import_fields' ) ) {
	add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_give_importer_import_fields', 10, 1 );
	function trx_addons_give_importer_import_fields($importer) {
		if ( trx_addons_exists_give() && in_array('give', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'	=> 'give', 
				'title'	=> esc_html__('Give (Donation Form)', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_give_importer_export' ) ) {
	add_action( 'trx_addons_action_importer_export',	'trx_addons_give_importer_export', 10, 1 );
	function trx_addons_give_importer_export($importer) {
		if ( trx_addons_exists_give() && in_array('give', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('give.txt'), serialize( array(
				'give_donationmeta' => $importer->export_dump('give_donationmeta'),
				'give_donormeta' => $importer->export_dump('give_donormeta'),
				'give_donors' => $importer->export_dump('give_donors'),
				'give_formmeta' => $importer->export_dump('give_formmeta'),
				'give_logmeta' => $importer->export_dump('give_logmeta'),
				'give_logs' => $importer->export_dump('give_logs'),
				'give_sequental_ordering' => $importer->export_dump('give_sequental_ordering'),
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_give_importer_export_fields' ) ) {
	add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_give_importer_export_fields', 10, 1 );
	function trx_addons_give_importer_export_fields($importer) {
		if ( trx_addons_exists_give() && in_array('give', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'give',
				'title' => esc_html__('Give (Donation Form)', 'trx_addons')
				)
			);
		}
	}
}
