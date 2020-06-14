<?php
/**
 * Plugin support: WPML
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if plugin installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_addons_exists_wpml' ) ) {
	function trx_addons_exists_wpml() {
		return defined('ICL_SITEPRESS_VERSION') && class_exists('sitepress');
	}
}
*/

// Return default language
if ( !function_exists( 'trx_addons_wpml_get_default_language' ) ) {
	function trx_addons_wpml_get_default_language() {
		return trx_addons_exists_wpml() ? apply_filters( 'wpml_default_language', null ) : '';
	}
}

// Return current language
if ( !function_exists( 'trx_addons_wpml_get_current_language' ) ) {
	function trx_addons_wpml_get_current_language() {
		return trx_addons_exists_wpml() ? apply_filters( 'wpml_current_language', null ) : '';
	}
}


// Create option with current language
if (!function_exists('trx_addons_wpml_add_current_language_option')) {
	add_filter('trx_addons_filter_options', 'trx_addons_wpml_add_current_language_option');
	function trx_addons_wpml_add_current_language_option($options) {
		if (trx_addons_exists_wpml()) {
			$options['wpml_current_language'] = array(
				"title" => '',
				"desc" => '',
				"std" => trx_addons_wpml_get_current_language(),
				"type" => "hidden"
			);
		}
		return $options;
	}
}

// Create translated option's values
if (!function_exists('trx_addons_wpml_replace_translated_options')) {
	add_filter('trx_addons_filter_load_options', 'trx_addons_wpml_replace_translated_options');
	function trx_addons_wpml_replace_translated_options($values) {
		if (trx_addons_exists_wpml()) {
			global $TRX_ADDONS_STORAGE;
			if (is_array($values) && isset($TRX_ADDONS_STORAGE['options']) && is_array($TRX_ADDONS_STORAGE['options'])) {
				$translated = apply_filters('trx_addons_filter_load_options_translated', get_option('trx_addons_options_translated'));
				if (empty($translated)) $translated = array();
				$lang = trx_addons_wpml_get_current_language();
				foreach ($TRX_ADDONS_STORAGE['options'] as $k=>$v) {
					if (empty($v['translate'])) continue;
					$param_name = sprintf('%1$s_lang_%2$s', $k, $lang);
					if (isset($translated[$param_name]))
						$values[$k] = $translated[$param_name];
				}
				// Disable menu cache if WPML is active
				if (!empty($values['menu_cache'])) $values['menu_cache'] = 0;
			}
		}
		return $values;
	}
}

// Disable menu cache if WPML is active
if (!function_exists('trx_addons_wpml_disable_menu_cache')) {
	add_filter('trx_addons_filter_options_save', 'trx_addons_wpml_disable_menu_cache');
	function trx_addons_wpml_disable_menu_cache($values) {
		if (trx_addons_exists_wpml()) {
			if (!empty($values['menu_cache'])) $values['menu_cache'] = 0;
		}
		return $values;
	}
}

// Disable menu cache if WPML is active
if (!function_exists('trx_addons_wpml_use_menu_cache')) {
	add_filter('trx_addons_add_menu_cache', 'trx_addons_wpml_use_menu_cache');
	add_filter('trx_addons_get_menu_cache', 'trx_addons_wpml_use_menu_cache');
	function trx_addons_wpml_use_menu_cache($use) {
		if (trx_addons_exists_wpml()) {
			$use = false;
		}
		return $use;
	}
}

// Duplicate translatable options for each language
if (!function_exists('trx_addons_wpml_duplicate_options')) {
	add_filter('trx_addons_filter_options_save', 'trx_addons_wpml_duplicate_options');
	function trx_addons_wpml_duplicate_options($values) {
		if (trx_addons_exists_wpml()) {
			// Detect current language
			if (isset($values['wpml_current_language'])) {
				$tmp = explode('!', $values['wpml_current_language']);
				$lang = $tmp[0];
				unset($values['wpml_current_language']);
			} else {
				$lang = trx_addons_wpml_get_current_language();
			}

			// Duplicate options to the language-specific options and remove original
			if (is_array($values)) {
				$translated = apply_filters('trx_addons_filter_load_options_translated', get_option('trx_addons_options_translated'));
				if (empty($translated)) $translated = array();
				global $TRX_ADDONS_STORAGE;
				if (is_array($values) && isset($TRX_ADDONS_STORAGE['options']) && is_array($TRX_ADDONS_STORAGE['options'])) {
					$changed = false;
					foreach ($TRX_ADDONS_STORAGE['options'] as $k => $v) {
						if (!empty($v['translate']) && isset($values[$k])) {
							$param_name = sprintf('%1$s_lang_%2$s', $k, $lang);
							$translated[$param_name] = $values[$k];
							$changed = true;
						}
					}
					if ($changed) {
						update_option('trx_addons_options_translated', $translated);
					}
				}
			}
		}
		return $values;
	}
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'sitepress-multilingual-cms/sitepress-multilingual-cms-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_wpml() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'sitepress-multilingual-cms/sitepress-multilingual-cms-demo-ocdi.php';
}
