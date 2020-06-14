<?php
/**
 * Shortcode: Super title
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.49
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_supertitle_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_supertitle_load_scripts_front');
	function trx_addons_sc_supertitle_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-sc_supertitle', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_sc_supertitle_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_supertitle_load_responsive_styles', 2000);
	function trx_addons_sc_supertitle_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_supertitle-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle.responsive.css'), array(), null );
		}
	}
}


// Merge shortcode's specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_sc_supertitle_merge_styles' ) ) {
	add_filter('trx_addons_filter_merge_styles', 'trx_addons_sc_supertitle_merge_styles');
	function trx_addons_sc_supertitle_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle.css';
		return $list;
	}
}

// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_supertitle_merge_styles_responsive' ) ) {
	add_filter('trx_addons_filter_merge_styles_responsive', 'trx_addons_sc_supertitle_merge_styles_responsive');
	function trx_addons_sc_supertitle_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle.responsive.css';
		return $list;
	}
}

// Check if there are side title
if ( !function_exists( 'trx_addons_sc_supertitle_has_side_title' ) ) {
	function trx_addons_sc_supertitle_has_side_title($sc_args) {
		$side = is_rtl() ? 'left' : 'right';
		if (!empty($sc_args['items']) && in_array( $side, array_column($sc_args['items'], 'align'))) {
			return true;
		}
		return false;
	}
}


// [trx_sc_supertitle]
//-------------------------------------------------------------
/*
[trx_sc_supertitle id="unique_id" "type" => "default"]
*/
if ( !function_exists( 'trx_addons_sc_supertitle' ) ) {
	function trx_addons_sc_supertitle($atts, $content=null) {
		$atts = trx_addons_sc_prepare_atts('trx_sc_supertitle', $atts, trx_addons_sc_common_atts('id', array(
				// Individual params
				'type' => 'default',
				'icon_column' => 8,
				'header_column' => 8,
				'items' => '',
				'icon' => '',
				'icon_color' => '',
				'icon_size' => '',
				'icon_bg_color' => '',
				'image' => '',
			))
		);
		$atts['header_column'] = max(0, min($atts['header_column'], 11));
		if (function_exists('vc_param_group_parse_atts') && !is_array($atts['items']))
			$atts['items'] = (array) vc_param_group_parse_atts( $atts['items'] );
		$output = '';
		if (is_array($atts['items']) && count($atts['items']) > 0) {
			$output = trx_addons_get_template_part_as_string(array(
				TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/tpl.'.trx_addons_esc($atts['type']).'.php',
				TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/tpl.default.php'
				),
				'trx_addons_args_sc_supertitle',
				$atts
			);
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_supertitle', $atts, $content);
	}
}


// Add shortcode [trx_sc_supertitle]
if (!function_exists('trx_addons_sc_supertitle_add_shortcode')) {
	function trx_addons_sc_supertitle_add_shortcode() {
		add_shortcode('trx_sc_supertitle', 'trx_addons_sc_supertitle');
	}
	add_action('init', 'trx_addons_sc_supertitle_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'supertitle/supertitle-sc-vc.php';
}
