<?php
/**
 * Plugin support: Easy Digital Downloads (Shortcodes)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.29
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// trx_sc_edd_details
//-------------------------------------------------------------
/*
[trx_sc_edd_details id="unique_id" type="default"]
*/
if ( !function_exists( 'trx_addons_sc_edd_details' ) ) {
	function trx_addons_sc_edd_details($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_edd_details', $atts, trx_addons_sc_common_atts('id', array(
			// Individual params
			"type" => "default",
			))
		);

		$atts['class'] .= ($atts['class'] ? ' ' : '') . 'sc_edd_details';

		$output = '';
		if (is_single() && get_post_type()==TRX_ADDONS_EDD_PT) {
			ob_start();
			trx_addons_get_template_part(TRX_ADDONS_PLUGIN_API . 'easy-digital-downloads/tpl.edd-details.'.trx_addons_esc($atts['type']).'.php',
										'trx_addons_args_sc_edd_details',
										$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_edd_details', $atts, $content);
	}
}


// Add shortcode [trx_sc_edd_details]
if (!function_exists('trx_addons_sc_edd_details_add_shortcode')) {
	add_action('init', 'trx_addons_sc_edd_details_add_shortcode', 20);
	function trx_addons_sc_edd_details_add_shortcode() {
		add_shortcode("trx_sc_edd_details", "trx_addons_sc_edd_details");
	}
}


// trx_sc_edd_add_to_cart
//-------------------------------------------------------------
/*
[trx_sc_edd_add_to_cart id="unique_id" type="default|promo"]
*/
if ( !function_exists( 'trx_addons_sc_edd_add_to_cart' ) ) {
	function trx_addons_sc_edd_add_to_cart($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_edd_add_to_cart', $atts, trx_addons_sc_common_atts('id,title', array(
			// Individual params
			"type" => "default",
			"download" => 0,
			"content" => "",
			))
		);
		$output = '';
		if ($atts['download'] > 0 || is_single() && get_post_type()==TRX_ADDONS_EDD_PT) {

			if (empty($atts['content']) && !empty($content)) $atts['content'] = do_shortcode($content);
			$atts['class'] .= ($atts['class'] ? ' ' : '') . 'sc_edd_add_to_cart sc_edd_add_to_cart_'.esc_attr($atts['type']);

			ob_start();
			trx_addons_get_template_part(TRX_ADDONS_PLUGIN_API . 'easy-digital-downloads/tpl.edd-add-to-cart.'.trx_addons_esc($atts['type']).'.php',
										'trx_addons_args_sc_edd_add_to_cart',
										$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_edd_add_to_cart', $atts, $content);
	}
}


// Add shortcode [trx_sc_edd_add_to_cart]
if (!function_exists('trx_addons_sc_edd_add_to_cart_add_shortcode')) {
	add_action('init', 'trx_addons_sc_edd_add_to_cart_add_shortcode', 20);
	function trx_addons_sc_edd_add_to_cart_add_shortcode() {
		add_shortcode("trx_sc_edd_add_to_cart", "trx_addons_sc_edd_add_to_cart");
	}
}
