<?php
/**
 * Plugin support: The Events Calendar (Shortcodes)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// trx_sc_events
//-------------------------------------------------------------
/*
[trx_sc_events id="unique_id" type="default" cat="category_slug or id" count="3" columns="3" slider="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_events' ) ) {
	function trx_addons_sc_events($atts, $content=null) {	
		$atts = trx_addons_sc_prepare_atts('trx_sc_events', $atts, trx_addons_sc_common_atts('id,title,slider,query', array(
			// Individual params
			"type" => "default",
			"past" => "0",
			"more_text" => esc_html__('More info', 'trx_addons'),
			))
		);

		if (!empty($atts['ids'])) {
			$atts['ids'] = str_replace(array(';', ' '), array(',', ''), $atts['ids']);
			$atts['count'] = count(explode(',', $atts['ids']));
		}
		$atts['count'] = max(1, (int) $atts['count']);
		$atts['offset'] = max(0, (int) $atts['offset']);
		if (empty($atts['orderby'])) $atts['orderby'] = 'event_date';
		if (empty($atts['order'])) $atts['order'] = 'asc';
		$atts['slider'] = max(0, (int) $atts['slider']);
		if ($atts['slider'] > 0 && (int) $atts['slider_pagination'] > 0) $atts['slider_pagination'] = 'bottom';

		add_filter( "excerpt_length", "trx_addons_sc_events_excerpt_length", 99 );

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_API . 'the-events-calendar/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_API . 'the-events-calendar/tpl.default.php'
										),
									'trx_addons_args_sc_events',
									$atts
									);
		$output = ob_get_contents();
		ob_end_clean();

		remove_filter( "excerpt_length", "trx_addons_sc_events_excerpt_length", 99 );
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_events', $atts, $content);
	}
}


// Add shortcode [trx_sc_events]
if (!function_exists('trx_addons_sc_events_add_shortcode')) {
	function trx_addons_sc_events_add_shortcode() {

		if (!trx_addons_exists_tribe_events()) return;

		add_shortcode("trx_sc_events", "trx_addons_sc_events");
	}
	add_action('init', 'trx_addons_sc_events_add_shortcode', 20);
}

// Change excerpt length in the events
if (!function_exists('trx_addons_sc_events_excerpt_length')) {
	// Handler of the add_filter( "excerpt_length", "trx_addons_sc_events_excerpt_length", 99 );
	function trx_addons_sc_events_excerpt_length($length = 0) {
		return apply_filters( 'trx_addons_filter_sc_events_excerpt_length', 30);
	}
}
