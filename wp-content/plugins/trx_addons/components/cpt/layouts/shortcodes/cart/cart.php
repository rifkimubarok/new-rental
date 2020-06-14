<?php
/**
 * Shortcode: Display WooCommerce cart with items number and totals
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_cpt_layouts_cart_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cpt_layouts_cart_load_scripts_front');
	function trx_addons_cpt_layouts_cart_load_scripts_front() {
		if (trx_addons_exists_page_builder() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_layouts-cart', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_cpt_layouts_cart_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_cpt_layouts_cart_load_responsive_styles', 2000);
	function trx_addons_cpt_layouts_cart_load_responsive_styles() {
		if (trx_addons_exists_page_builder() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_layouts-cart-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart.responsive.css'), array(), null );
		}
	}
}
	
// Merge shortcode specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_layouts_cart_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_layouts_cart_merge_styles');
	add_filter("trx_addons_filter_merge_styles_layouts", 'trx_addons_sc_layouts_cart_merge_styles');
	function trx_addons_sc_layouts_cart_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart.css';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_layouts_cart_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_layouts_cart_merge_styles_responsive');
	add_filter("trx_addons_filter_merge_styles_responsive_layouts", 'trx_addons_sc_layouts_cart_merge_styles_responsive');
	function trx_addons_sc_layouts_cart_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart.responsive.css';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_sc_layouts_cart_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_layouts_cart_merge_scripts');
	function trx_addons_sc_layouts_cart_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart.js';
		return $list;
	}
}


// Load shortcode's specific scripts if current mode is Preview in the PageBuilder
if ( !function_exists( 'trx_addons_sc_layouts_cart_load_scripts' ) ) {
	add_action("trx_addons_action_pagebuilder_preview_scripts", 'trx_addons_sc_layouts_cart_load_scripts', 10, 1);
	function trx_addons_sc_layouts_cart_load_scripts($editor='') {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && $editor!='gutenberg') {
			wp_enqueue_style( 'trx_addons-sc_layouts-cart', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart.css'), array(), null );
			wp_enqueue_script( 'trx_addons-sc_layouts_cart', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart.js'), array('jquery'), null, true );
		}
	}
}

// Add 'Cart' on action hook
if (!function_exists('trx_addons_add_cart')) {
	add_action('trx_addons_action_cart', 'trx_addons_add_cart');
	function trx_addons_add_cart($atts=array()) {
		trx_addons_show_layout(trx_addons_sc_layouts_cart($atts));
	}
}



// trx_sc_layouts_cart
//-------------------------------------------------------------
/*
[trx_sc_layouts_cart id="unique_id" text="Shopping cart"]
*/
if ( !function_exists( 'trx_addons_sc_layouts_cart' ) ) {
	function trx_addons_sc_layouts_cart($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_layouts_cart', $atts, trx_addons_sc_common_atts('id,hide', array(
			// Individual params
			"type" => "default",
			"market" => "woocommerce",
			"text" => "",
			))
		);

		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_script( 'trx_addons-sc_layouts_cart', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart.js'), array('jquery'), null, true );
		}

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/tpl.default.php'
										),
										'trx_addons_args_sc_layouts_cart',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();

		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts_cart', $atts, $content);
	}
}


// Add shortcode [trx_sc_layouts_cart]
if (!function_exists('trx_addons_sc_layouts_cart_add_shortcode')) {
	function trx_addons_sc_layouts_cart_add_shortcode() {
		
		if (!trx_addons_cpt_layouts_sc_required()) return;
		
		add_shortcode("trx_sc_layouts_cart", "trx_addons_sc_layouts_cart");

	}
	add_action('init', 'trx_addons_sc_layouts_cart_add_shortcode', 15);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'cart/cart-sc-vc.php';
}
