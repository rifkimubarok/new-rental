<?php
/**
 * Shortcode: Action
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
if ( !function_exists( 'trx_addons_sc_action_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_action_load_scripts_front');
	function trx_addons_sc_action_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-sc_action', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'action/action.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_sc_action_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_action_load_responsive_styles', 2000);
	function trx_addons_sc_action_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_action-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'action/action.responsive.css'), array(), null );
		}
	}
}
	
	
// Merge shortcode's specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_sc_action_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_action_merge_styles');
	function trx_addons_sc_action_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'action/action.css';
		return $list;
	}
}

// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_action_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_action_merge_styles_responsive');
	function trx_addons_sc_action_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'action/action.responsive.css';
		return $list;
	}
}



// trx_sc_action
//-------------------------------------------------------------
/*
[trx_sc_action id="unique_id" columns="2" values="encoded_json_data"]
*/
if ( !function_exists( 'trx_addons_sc_action' ) ) {
	function trx_addons_sc_action($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_action', $atts, trx_addons_sc_common_atts('id,title,slider', array(
			// Individual params
			"type" => "default",
			"columns" => "",
			"actions" => "",
			"full_height" => 0,
			))
		);
		if (function_exists('vc_param_group_parse_atts') && !is_array($atts['actions'])) {
			$atts['actions'] = (array) vc_param_group_parse_atts( $atts['actions'] );
		}
		$output = '';
		if (is_array($atts['actions']) && count($atts['actions']) > 0) {
			if (empty($atts['columns'])) $atts['columns'] = count($atts['actions']);
			$atts['columns'] = max(1, min(count($atts['actions']), $atts['columns']));
			if (!empty($atts['columns_tablet'])) $atts['columns_tablet'] = max(1, min(count($atts['actions']), (int) $atts['columns_tablet']));
			if (!empty($atts['columns_mobile'])) $atts['columns_mobile'] = max(1, min(count($atts['actions']), (int) $atts['columns_mobile']));
			$atts['slider'] = $atts['slider'] > 0 && count($atts['actions']) > $atts['columns'];
			$atts['slides_space'] = max(0, (int) $atts['slides_space']);
			if ($atts['slider'] > 0 && (int) $atts['slider_pagination'] > 0) $atts['slider_pagination'] = 'bottom';
	
			foreach ($atts['actions'] as $k=>$v) {
				if (!empty($v['description']))
					$atts['actions'][$k]['description'] = preg_replace( '/\\[(.*)\\]/', '<b>$1</b>', function_exists('vc_value_from_safe') ? vc_value_from_safe( $v['description'] ) : $v['description'] );
			}
	
			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'action/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'action/tpl.default.php'
											),
											'trx_addons_args_sc_action',
											$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_action', $atts, $content);
	}
}


// Add shortcode [trx_sc_action]
if (!function_exists('trx_addons_sc_action_add_shortcode')) {
	function trx_addons_sc_action_add_shortcode() {
		add_shortcode("trx_sc_action", "trx_addons_sc_action");
	}
	add_action('init', 'trx_addons_sc_action_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'action/action-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'action/action-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'action/action-sc-vc.php';
}
