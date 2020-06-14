<?php
/**
 * Shortcode: Content container
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
if ( !function_exists( 'trx_addons_sc_content_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_content_load_scripts_front');
	function trx_addons_sc_content_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-sc_content', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'content/content.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_sc_content_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_content_load_responsive_styles', 2000);
	function trx_addons_sc_content_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_content-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'content/content.responsive.css'), array(), null );
		}
	}
}

// Merge shortcode's specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_sc_content_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_content_merge_styles');
	function trx_addons_sc_content_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'content/content.css';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_content_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_content_merge_styles_responsive');
	function trx_addons_sc_content_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'content/content.responsive.css';
		return $list;
	}
}


// trx_sc_content
//-------------------------------------------------------------
/*
[trx_sc_content id="unique_id" width="1/2"]
*/
if ( !function_exists( 'trx_addons_sc_content' ) ) {
	function trx_addons_sc_content($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_content', $atts, trx_addons_sc_common_atts('id,title', array(
			// Individual params
			'type' => 'default',
			"width" => "",
			"size" => "none",
			"float" => 'center',
			"align" => "",
			"paddings" => "",
			"margins" => "",
			"push" => "",
			"push_hide_on_tablet" => 0,
			"push_hide_on_mobile" => 0,
			"pull" => "",
			"pull_hide_on_tablet" => 0,
			"pull_hide_on_mobile" => 0,
			"extra_bg" => "none",
			"extra_bg_mask" => 0,
			"shift_x" => "none",
			"shift_y" => "none",
			"number" => "",
			"number_position" => "br",
			"number_color" => "",
			))
		);
		
		$output = '';

		if (empty($atts['width']) && !empty($atts['size'])) $atts['width'] = $atts['size'];
		if (empty($atts['width']) && !empty($atts['content_width'])) $atts['width'] = $atts['content_width'];
		
		$atts['content'] = do_shortcode($content);
		
		if (!empty($atts['content']) || !empty($atts['title']) || !empty($atts['subtitle']) || !empty($atts['description'])) {

			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'content/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'content/tpl.default.php'
											),
                                            'trx_addons_args_sc_content', 
                                            $atts
                                        );
			$output = ob_get_contents();
			ob_end_clean();

		}
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_content', $atts, $content);
	}
}


// Add shortcode [trx_sc_content] and [trx_sc_content_inner]
if (!function_exists('trx_addons_sc_content_add_shortcode')) {
	function trx_addons_sc_content_add_shortcode() {
		add_shortcode("trx_sc_content", "trx_addons_sc_content");
		add_shortcode("trx_sc_content_inner", "trx_addons_sc_content");
	}
	add_action('init', 'trx_addons_sc_content_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'content/content-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'content/content-sc-vc.php';
}
