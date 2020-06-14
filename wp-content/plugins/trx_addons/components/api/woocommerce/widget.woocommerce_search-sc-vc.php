<?php
/**
 * Widget: WooCommerce Search (Advanced search form) (WPBakery support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}



// Add [trx_widget_woocommerce_search] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_woocommerce_search_add_in_vc')) {
	function trx_addons_sc_widget_woocommerce_search_add_in_vc() {
		
		if (!trx_addons_exists_woocommerce()) return;
		
		if (!trx_addons_exists_vc()) return;
		
		vc_lean_map("trx_widget_woocommerce_search", 'trx_addons_sc_widget_woocommerce_search_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Woocommerce_Search extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_widget_woocommerce_search_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_woocommerce_search_add_in_vc_params')) {
	function trx_addons_sc_widget_woocommerce_search_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_woocommerce_search",
				"name" => esc_html__("WooCommerce Search", 'trx_addons'),
				"description" => wp_kses_data( __("Insert advanced form for search products", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_woocommerce_search',
				"class" => "trx_widget_woocommerce_search",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "title",
							"heading" => esc_html__("Widget title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the widget", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "type",
							"heading" => esc_html__("Type", 'trx_addons'),
							"description" => wp_kses_data( __("Type of the widget", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"std" => "inline",
							"value" => array_flip(trx_addons_get_list_woocommerce_search_types()),
							"type" => "dropdown"
						),
						array(
							'type' => 'param_group',
							'param_name' => 'fields',
							'heading' => esc_html__( 'Fields', 'trx_addons' ),
							"description" => wp_kses_data( __("Specify text and select filter for each item", 'trx_addons') ),
							'value' => urlencode( json_encode( apply_filters('trx_addons_sc_param_group_value', array(
											array(
												'text' => '',
												'filter' => ''
											),
										), 'trx_widget_woocommerce_search') ) ),
							'params' => apply_filters('trx_addons_sc_param_group_params', array(
								array(
									"param_name" => "text",
									"heading" => esc_html__("Field text", 'trx_addons'),
									"description" => '',
									"admin_label" => true,
									'edit_field_class' => 'vc_col-sm-6',
									"type" => "textfield"
								),
								array(
									"param_name" => "filter",
									"heading" => esc_html__("Field filter", 'trx_addons'),
									"description" => '',
									'edit_field_class' => 'vc_col-sm-6',
									"admin_label" => true,
									"std" => "none",
									"value" => array_flip(trx_addons_get_list_woocommerce_search_filters()),
									"type" => "dropdown"
								)
							), 'trx_widget_woocommerce_search')
						),
						array(
							"param_name" => "last_text",
							"heading" => esc_html__("Last text", 'trx_addons'),
							"description" => wp_kses_data( __("Text after the last filter", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
						array(
							"param_name" => "button_text",
							"heading" => esc_html__("Button text", 'trx_addons'),
							"description" => wp_kses_data( __("Text of the button after all filters", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "textfield"
						),
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_woocommerce_search' );
	}
}
