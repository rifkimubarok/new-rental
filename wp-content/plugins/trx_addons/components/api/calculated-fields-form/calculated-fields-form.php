<?php
/**
 * Plugin support: Calculated Fields Form
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if plugin is installed and activated
if ( !function_exists( 'trx_addons_exists_calculated_fields_form' ) ) {
	function trx_addons_exists_calculated_fields_form() {
		return class_exists( 'CP_SESSION' ) || class_exists( 'CPCFF_MAIN' );
	}
}

// Return forms list, prepended inherit (if need)
if ( !function_exists( 'trx_addons_get_list_calculated_fields_form' ) ) {
	function trx_addons_get_list_calculated_fields_form($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			if (trx_addons_exists_calculated_fields_form()) {
				global $wpdb;
				$rows = $wpdb->get_results( 'SELECT id, form_name FROM ' . esc_sql($wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_TABLE) );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->id] = $row->form_name;
					}
				}
			}
		}
		return $prepend_inherit ? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) : $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_calculated_fields_form() && trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'calculated-fields-form/calculated-fields-form-sc-elementor.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_calculated_fields_form() && trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'calculated-fields-form/calculated-fields-form-sc-vc.php';
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'calculated-fields-form/calculated-fields-form-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_calculated_fields_form() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'calculated-fields-form/calculated-fields-form-demo-ocdi.php';
}
