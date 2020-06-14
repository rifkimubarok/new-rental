<?php
/**
 * Shortcode: Icons
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_icons_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_icons_load_scripts_front');
	function trx_addons_sc_icons_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-sc_icons', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_sc_icons_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_icons_load_responsive_styles', 2000);
	function trx_addons_sc_icons_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_icons-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons.responsive.css'), array(), null );
		}
	}
}

	
// Merge contact form specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_icons_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_icons_merge_styles');
	function trx_addons_sc_icons_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons.css';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_icons_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_icons_merge_styles_responsive');
	function trx_addons_sc_icons_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons.responsive.css';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_sc_icons_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_icons_merge_scripts');
	function trx_addons_sc_icons_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/vivus.js';
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons.js';
		return $list;
	}
}



// trx_sc_icons
//-------------------------------------------------------------
/*
[trx_sc_icons id="unique_id" columns="2" values="encoded_json_data"]
*/
if ( !function_exists( 'trx_addons_sc_icons' ) ) {
	function trx_addons_sc_icons($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_icons', $atts, trx_addons_sc_common_atts('id,title', array(
			// Individual params
			"type" => "default",
			"align" => "center",
			"size" => "medium",
			"color" => "",
			"columns" => "",
			"icons" => "",
			"icons_animation" => "0",
			))
		);

		if (function_exists('vc_param_group_parse_atts') && !is_array($atts['icons'])) {
			$atts['icons'] = (array) vc_param_group_parse_atts( $atts['icons'] );
		}

		$output = '';
		if (is_array($atts['icons']) && count($atts['icons']) > 0) {
			if (empty($atts['columns'])) $atts['columns'] = count($atts['icons']);
			$atts['columns'] = max(1, min(count($atts['icons']), $atts['columns']));
			if (!empty($atts['columns_tablet'])) $atts['columns_tablet'] = max(1, min(count($atts['icons']), (int) $atts['columns_tablet']));
			if (!empty($atts['columns_mobile'])) $atts['columns_mobile'] = max(1, min(count($atts['icons']), (int) $atts['columns_mobile']));
	
			foreach ($atts['icons'] as $k=>$v) {
				if (!empty($v['description']))
					$atts['icons'][$k]['description'] = preg_replace( '/\\[(.*)\\]/', '<b>$1</b>', function_exists('vc_value_from_safe') ? vc_value_from_safe( $v['description'] ) : $v['description'] );
			}
	
			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/tpl.default.php'
											),
											'trx_addons_args_sc_icons', 
											$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_icons', $atts, $content);
	}
}


// Add shortcode [trx_sc_icons]
if (!function_exists('trx_addons_sc_icons_add_shortcode')) {
	function trx_addons_sc_icons_add_shortcode() {
		add_shortcode("trx_sc_icons", "trx_addons_sc_icons");
	}
	add_action('init', 'trx_addons_sc_icons_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons-sc-vc.php';
}
