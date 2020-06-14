<?php
/**
 * Shortcode: Yandex Map
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.51
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_yandexmap_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_yandexmap_load_scripts_front');
	function trx_addons_sc_yandexmap_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-sc_yandexmap', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_sc_yandexmap_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_yandexmap_load_responsive_styles', 2000);
	function trx_addons_sc_yandexmap_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_yandexmap-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap.responsive.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_yandexmap_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_yandexmap_merge_styles');
	function trx_addons_sc_yandexmap_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap.css';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_yandexmap_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_yandexmap_merge_styles_responsive');
	function trx_addons_sc_yandexmap_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap.responsive.css';
		return $list;
	}
}


// Merge yandexmap specific scripts to the single file
if ( !function_exists( 'trx_addons_sc_yandexmap_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_yandexmap_merge_scripts');
	function trx_addons_sc_yandexmap_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap.js';
		return $list;
	}
}


// Load shortcode's specific scripts if current mode is Preview in the PageBuilder
if ( !function_exists( 'trx_addons_sc_yandexmap_load_scripts' ) ) {
	add_action("trx_addons_action_pagebuilder_preview_scripts", 'trx_addons_sc_yandexmap_load_scripts', 10, 1);
	function trx_addons_sc_yandexmap_load_scripts($editor='') {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-sc_yandexmap', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap.css'), array(), null );
		}
		trx_addons_enqueue_yandexmap();
		if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && $editor!='gutenberg' && (!function_exists('trx_addons_gutenberg_is_preview') || !trx_addons_gutenberg_is_preview())) {
			wp_enqueue_script( 'trx_addons-sc_yandexmap', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap.js'), array('jquery'), null, true );
		}
	}
}

	
// Add messages for JS
if ( !function_exists( 'trx_addons_sc_yandexmap_localize_script' ) ) {
	add_filter("trx_addons_filter_localize_script", 'trx_addons_sc_yandexmap_localize_script');
	function trx_addons_sc_yandexmap_localize_script($storage) {
		$storage['msg_sc_yandexmap_not_avail'] = esc_html__('Yandex map service is not available', 'trx_addons');
		$storage['msg_sc_yandexmap_geocoder_error'] = esc_html__('Error while geocode address', 'trx_addons');
		return $storage;
	}
}


// trx_sc_yandexmap
//-------------------------------------------------------------
/*
[trx_sc_yandexmap id="unique_id" style="grey" zoom="16" markers="encoded json data"]
*/
if ( !function_exists( 'trx_addons_sc_yandexmap' ) ) {
	function trx_addons_sc_yandexmap($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_yandexmap', $atts, trx_addons_sc_common_atts('id,title', array(
			// Individual params
			"type" => "default",
			"zoom" => 16,
			"center" => '',
			"style" => 'default',
			"address" => '',
			"markers" => '',
			"cluster" => '',
			"width" => "100%",
			"height" => "400",
			"prevent_scroll" => 0,
			// Content from non-containers PageBuilder
			"content" => ""
			))
		);
		
		if (!is_array($atts['markers']) && function_exists('vc_param_group_parse_atts'))
			$atts['markers'] = (array) vc_param_group_parse_atts( $atts['markers'] );

		$output = '';
		if ((is_array($atts['markers']) && count($atts['markers']) > 0) || !empty($atts['address'])) {
			if (!empty($atts['address'])) {
				$atts['markers'] = array(
										array(
											'title' => '',
											'description' => '',
											'address' => $atts['address'],
											'latlng' => '',
											'icon' => trx_addons_remove_protocol(trx_addons_get_option('api_yandex_marker')),
											'icon_width' => '',
											'icon_height' => ''
										)
									);
			} else {
				foreach ($atts['markers'] as $k=>$v) {
					if (!empty($v['description']) && function_exists('vc_value_from_safe'))
						$atts['markers'][$k]['description'] = trim( vc_value_from_safe( $v['description'] ) );
					if (!empty($v['icon'])) {
						$atts['markers'][$k]['icon'] = trx_addons_get_attachment_url($v['icon'], 'full');
						if (empty($v['icon_width']) || empty($v['icon_height'])) {
							$attr = trx_addons_getimagesize($atts['markers'][$k]['icon']);
							$atts['markers'][$k]['icon_width'] = $attr[0];
							$atts['markers'][$k]['icon_height'] = $attr[1];
						}
					} else
						$v['icon'] = trx_addons_remove_protocol(trx_addons_get_option('api_yandex_marker'));
					if (!empty($v['icon_retina']) && trx_addons_get_retina_multiplier() > 1)
						$atts['markers'][$k]['icon'] = trx_addons_get_attachment_url($v['icon_retina'], 'full');
				}
			}

			$atts['zoom'] = max(0, min(21, $atts['zoom']));
			$atts['center'] = trim($atts['center']);
	
			if (count($atts['markers']) > 1) {
				if (empty($atts['cluster'])) 
					$atts['cluster'] = trx_addons_remove_protocol(trx_addons_get_option('api_yandex_cluster'));
				if (empty($atts['cluster']))
					$atts['cluster'] = trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/cluster/cluster-icon.png');
				else if ((int) $atts['cluster'] > 0)
					$atts['cluster'] = trx_addons_get_attachment_url($atts['cluster'], apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('masonry'), 'yandexmap-cluster'));
			} else if ($atts['zoom'] == 0)
				$atts['zoom'] = 16;
	
			$atts['class'] .= (!empty($atts['class']) ? ' ' : '') 
							. trx_addons_add_inline_css_class(trx_addons_get_css_dimensions_from_values($atts['width'], $atts['height']));
	
			if (empty($atts['style'])) $atts['style'] = 'default';
	
			$atts['content'] = do_shortcode(empty($atts['content']) ? $content : $atts['content']);
			
			if (!function_exists('trx_addons_gutenberg_is_preview') || !trx_addons_gutenberg_is_preview()) {
				trx_addons_enqueue_yandexmap();
				if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
					wp_enqueue_script( 'trx_addons-sc_yandexmap', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap.js'), array('jquery'), null, true );
				}
			}

			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/tpl.default.php'
											),
											'trx_addons_args_sc_yandexmap', 
											$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_yandexmap', $atts, $content);
	}
}


// Add shortcode [trx_sc_yandexmap]
if (!function_exists('trx_addons_sc_yandexmap_add_shortcode')) {
	function trx_addons_sc_yandexmap_add_shortcode() {
		add_shortcode("trx_sc_yandexmap", "trx_addons_sc_yandexmap");
	}
	add_action('init', 'trx_addons_sc_yandexmap_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap-sc-vc.php';
}

// Create our widget
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'yandexmap/yandexmap-widget.php';
