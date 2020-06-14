<?php
/**
 * Shortcode: Display any previously created layout
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.06
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// trx_sc_layouts
//-------------------------------------------------------------
/*
[trx_sc_layouts layout="layout_id"]
*/
if ( !function_exists( 'trx_addons_sc_layouts' ) ) {
	function trx_addons_sc_layouts($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_layouts', $atts, trx_addons_sc_common_atts('id', array(
			// Individual params
			"type" => "default",
			"layout" => "",
			"content" => "",		// Alternative content
			// Panels parameters
			"position" => "right",
			"size" => 300,
			"modal" => 0,
			"show_on_load" => "none",
			"popup_id" => "",		// Alter name for id in Elementor ('id' is reserved by Elementor)
			))
		);

		$output = '';

		if (empty($atts['content']) && !empty($content))
			$atts['content'] = $content;
		
		if (!empty($atts['popup_id']))
			$atts['id'] = $atts['popup_id'];

		// If content specified and no layout selected
		if (!empty($atts['content']) && empty($atts['layout'])) {
			$atts['layout'] = '';
			// Remove tags p if content contain shortcodes
			if (strpos($atts['content'], '[') !== false)
				$atts['content'] = shortcode_unautop($atts['content']);
			// Do shortcodes inside content
			$atts['content'] = apply_filters('widget_text_content', $atts['content']);

		// Get translated version of specified layout
		} else if (!empty($atts['layout'])) {
			$atts['layout'] = apply_filters('trx_addons_filter_get_translated_layout', $atts['layout']);
		}
		
		// Add 'size' as class
		if ($atts['type'] == 'panel') {
			if (empty($atts['size'])) $atts['size'] = 'auto';
			$atts['class'] .= (!empty($atts['class']) ? ' ' : '') 
								. trx_addons_add_inline_css_class(
									trx_addons_get_css_dimensions_from_values(
										in_array($atts['position'], array('left', 'right')) ? $atts['size'] : '',
										in_array($atts['position'], array('top', 'bottom')) ? $atts['size'] : ''
									)
								);
		}
		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'layouts/tpl.'.trx_addons_esc($atts['type']).'.php',
                                        TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'layouts/tpl.default.php'
                                        ),
                                        'trx_addons_args_sc_layouts',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();

		// Remove init classes from the output in the popup
		if (in_array($atts['type'], array('popup', 'panel'))) {
			$output = str_replace(  'wp-audio-shortcode',
									'wp-audio-shortcode-noinit',
									$output
									);
			trx_addons_add_inline_html(apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts', $atts, $content));
			return '';
		} else {
			return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts', $atts, $content);
		}
	}
}


// Add shortcode [trx_sc_layouts]
if (!function_exists('trx_addons_sc_layouts_add_shortcode')) {
	function trx_addons_sc_layouts_add_shortcode() {
		add_shortcode("trx_sc_layouts", "trx_addons_sc_layouts");
	}
	add_action('init', 'trx_addons_sc_layouts_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'layouts/layouts-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'layouts/layouts-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'layouts/layouts-sc-vc.php';
}

// Create our widget
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'layouts/layouts-widget.php';
