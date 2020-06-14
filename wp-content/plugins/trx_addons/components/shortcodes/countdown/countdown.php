<?php
/**
 * Shortcode: Countdown
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4.3
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}



// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_countdown_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_countdown_load_scripts_front');
	function trx_addons_sc_countdown_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_countdown', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.css'), array(), null );
			wp_enqueue_script( 'jquery-plugin', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.plugin.js'), array('jquery'), null, true );
			wp_enqueue_script( 'jquery-countdown', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.countdown.js'), array('jquery'), null, true );
			wp_enqueue_script( 'trx_addons-sc_countdown', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.js'), array('jquery'), null, true );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_sc_countdown_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_countdown_load_responsive_styles', 2000);
	function trx_addons_sc_countdown_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_countdown-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.responsive.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_countdown_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_countdown_merge_styles');
	function trx_addons_sc_countdown_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.css';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_countdown_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_countdown_merge_styles_responsive');
	function trx_addons_sc_countdown_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.responsive.css';
		return $list;
	}
}

	
// Merge countdown specific scripts into single file
if ( !function_exists( 'trx_addons_sc_countdown_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_countdown_merge_scripts');
	function trx_addons_sc_countdown_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.plugin.js';
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/jquery.countdown.js';
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown.js';
		return $list;
	}
}



// trx_sc_countdown
//-------------------------------------------------------------
/*
[trx_sc_countdown id="unique_id" date="2017-12-31" time="23:59:59"]
*/
if ( !function_exists( 'trx_addons_sc_countdown' ) ) {
	function trx_addons_sc_countdown($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_countdown', $atts, trx_addons_sc_common_atts('id,title', array(
			// Individual params
			"type" => "default",
			"date" => "",
			"time" => "",
			"date_time" => "",
			"count_to" => 1,
			"align" => "center",
			))
		);

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/tpl.default.php'
										),
                                        'trx_addons_args_sc_countdown',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_countdown', $atts, $content);
	}
}


// Add shortcode [trx_sc_countdown]
if (!function_exists('trx_addons_sc_countdown_add_shortcode')) {
	function trx_addons_sc_countdown_add_shortcode() {
		add_shortcode("trx_sc_countdown", "trx_addons_sc_countdown");
	}
	add_action('init', 'trx_addons_sc_countdown_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'countdown/countdown-sc-vc.php';
}
