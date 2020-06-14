<?php
/**
 * Widget: Instagram (Shortcodes)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.47
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// trx_widget_instagram
//-------------------------------------------------------------
/*
[trx_widget_instagram id="unique_id" title="Widget title" count="6" columns="3" hashtag="my_hash"]
*/
if ( !function_exists( 'trx_addons_sc_widget_instagram' ) ) {
	function trx_addons_sc_widget_instagram($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_instagram', $atts, trx_addons_sc_common_atts('id', array(
			// Individual params
			"title" => "",
			'count'	=> 8,
			'columns' => 4,
			'columns_gap' => 0,
			'hashtag' => '',
			'links' => 'instagram',
			'follow' => 0,
			))
		);
		extract($atts);
		$type = 'trx_addons_widget_instagram';
		$output = '';
		if ( (int) $atts['count'] > 0 ) {
			global $wp_widget_factory;
			if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
				$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
								. ' class="widget_area sc_widget_instagram' 
									. (trx_addons_exists_vc() ? ' vc_widget_instagram wpb_content_element' : '') 
									. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
				ob_start();
				the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_instagram', 'widget_instagram') );
				$output .= ob_get_contents();
				ob_end_clean();
				$output .= '</div>';
			}
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_instagram', $atts, $content);
	}
}


// Add shortcode [trx_widget_instagram]
if (!function_exists('trx_addons_widget_instagram_reg_shortcodes')) {
	function trx_addons_widget_instagram_reg_shortcodes() {
		add_shortcode("trx_widget_instagram", "trx_addons_sc_widget_instagram");
	}
	add_action('init', 'trx_addons_widget_instagram_reg_shortcodes', 20);
}
