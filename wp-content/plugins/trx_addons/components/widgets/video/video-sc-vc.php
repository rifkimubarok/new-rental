<?php
/**
 * Widget: Video player for Youtube, Vimeo, etc. embeded video (WPBakery support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.1
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Add [trx_widget_video] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_video_add_in_vc')) {
	function trx_addons_sc_widget_video_add_in_vc() {
		
		if (!trx_addons_exists_vc()) return;
		
		vc_lean_map( "trx_widget_video", 'trx_addons_sc_widget_video_add_in_vc_params' );
		class WPBakeryShortCode_Trx_Widget_Video extends WPBakeryShortCode {}

	}
	add_action('init', 'trx_addons_sc_widget_video_add_in_vc', 20);
}


// Return params
if (!function_exists('trx_addons_sc_widget_video_add_in_vc_params')) {

	function trx_addons_sc_widget_video_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_video",
				"name" => esc_html__("Widget: Video", 'trx_addons'),
				"description" => wp_kses_data( __("Insert widget with embedded video from popular video hosting: Vimeo, Youtube, etc.", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_video',
				"class" => "trx_widget_video",
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
							"type" => "textfield"
						),
						array(
							"param_name" => "cover",
							"heading" => esc_html__("Cover image", 'trx_addons'),
							"description" => wp_kses_data( __("Select or upload cover image or write URL from other site", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							"type" => "attach_image"
						),
						array(
							"param_name" => "popup",
							"heading" => esc_html__("Open in the popup", 'trx_addons'),
							"description" => wp_kses_data( __("Open video in the popup", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-6',
							'dependency' => array(
								'element' => 'cover',
								'not_empty' => true
							),
							"admin_label" => true,
							"std" => 0,
							"type" => "checkbox"
						),
						array(
							"param_name" => "link",
							"heading" => esc_html__("Link to video", 'trx_addons'),
							"description" => wp_kses_data( __("Enter link to the video (Note: read more about available formats at WordPress Codex page)", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "embed",
							"heading" => esc_html__("or paste Embed code", 'trx_addons'),
							"description" => wp_kses_data( __("or paste the HTML code to embed video", 'trx_addons') ),
							"type" => "textarea_safe"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_video' );
	}
}
