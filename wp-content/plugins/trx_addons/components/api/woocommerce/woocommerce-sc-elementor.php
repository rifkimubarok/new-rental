<?php
/**
 * Plugin support: WooCommerce (Elementor support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.52.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Add class 'woocommerce' to the Elementor's output
//---------------------------------------------------------------------------------------
if (!function_exists('trx_addons_woocommerce_elm_widgets_class')) {
	add_filter( 'elementor/widget/render_content', 'trx_addons_woocommerce_elm_widgets_class', 10, 2 );
	function trx_addons_woocommerce_elm_widgets_class($content, $widget=null) {
		if (is_object($widget) && strpos($widget->get_name(), 'wp-widget-woocommerce') !== false) {
			$content = str_replace('class="widget wp-widget-woocommerce', 'class="widget woocommerce wp-widget-woocommerce', $content);
		}
		return $content;
	}
}
