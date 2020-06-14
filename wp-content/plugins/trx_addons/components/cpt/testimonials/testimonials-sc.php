<?php
/**
 * ThemeREX Addons Custom post type: Testimonials (Shortcodes)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// trx_sc_testimonials
//-------------------------------------------------------------
/*
[trx_sc_testimonials id="unique_id" type="default" cat="category_slug or id" count="3" columns="3" slider="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_testimonials' ) ) {
	function trx_addons_sc_testimonials($atts, $content=null) {	

		// Exit to prevent recursion
		if (trx_addons_sc_stack_check('trx_sc_testimonials')) return '';

		$atts = trx_addons_sc_prepare_atts('trx_sc_testimonials', $atts, trx_addons_sc_common_atts('id,title,slider,query', array(
			// Individual params
			"type" => "default",
			"use_initials" => false,
			))
		);

		if (!empty($atts['ids'])) {
			$atts['ids'] = str_replace(array(';', ' '), array(',', ''), $atts['ids']);
			$atts['count'] = count(explode(',', $atts['ids']));
		}
		$atts['count'] = max(1, (int) $atts['count']);
		$atts['offset'] = max(0, (int) $atts['offset']);
		if (empty($atts['orderby'])) $atts['orderby'] = 'date';
		if (empty($atts['order'])) $atts['order'] = 'desc';
		$atts['slider'] = max(0, (int) $atts['slider']);
		if ($atts['slider'] > 0 && (int) $atts['slider_pagination'] > 0) $atts['slider_pagination'] = 'bottom';

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT . 'testimonials/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT . 'testimonials/tpl.default.php'
										),
										'trx_addons_args_sc_testimonials',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_testimonials', $atts, $content);
	}
}


// Add shortcode [trx_sc_testimonials]
if (!function_exists('trx_addons_sc_testimonials_add_shortcode')) {
	function trx_addons_sc_testimonials_add_shortcode() {
		add_shortcode("trx_sc_testimonials", "trx_addons_sc_testimonials");
	}
	add_action('init', 'trx_addons_sc_testimonials_add_shortcode', 20);
}
