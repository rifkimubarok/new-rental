<?php
/**
 * Widget: Banner
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Load widget
if (!function_exists('trx_addons_widget_banner_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_banner_load' );
	function trx_addons_widget_banner_load() {
		register_widget( 'trx_addons_widget_banner' );
	}
}

// Widget Class
class trx_addons_widget_banner extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_banner', 'description' => esc_html__('Banner with image and/or any html and js code', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_banner', esc_html__('ThemeREX Banner', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$fullwidth = isset($instance['fullwidth']) ? $instance['fullwidth'] : '';
		$banner_link = isset($instance['banner_link']) ? $instance['banner_link'] : '';
		$banner_code = isset($instance['banner_code']) ? $instance['banner_code'] : '';
		$banner_image = isset($instance['banner_image']) ? $instance['banner_image'] : '';
		if (empty($banner_image)) {
			if (empty($banner_link) && empty($banner_code) && is_singular() && !trx_addons_sc_layouts_showed('featured')) {
				$banner_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), !empty($instance['from_shortcode']) ? 'full' : trx_addons_get_thumb_size('masonry') );
				$banner_image = $banner_image[0];
			}
		} else
			$banner_image = trx_addons_get_attachment_url($banner_image, !empty($instance['from_shortcode']) ? 'full' : trx_addons_get_thumb_size('masonry'));

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'banner/tpl.default.php',
									'trx_addons_args_widget_banner',
									apply_filters('trx_addons_filter_widget_args',
												array_merge($args, compact('title', 'fullwidth', 'banner_image', 'banner_link', 'banner_code')),
												$instance, 'trx_addons_widget_banner')
									);
	}

	// Update the widget settings.
	function update( $new_instance, $instance ) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['fullwidth'] = strip_tags( $new_instance['fullwidth'] );
		$instance['banner_image'] = strip_tags( $new_instance['banner_image'] );
		$instance['banner_link'] = strip_tags( $new_instance['banner_link'] );
		$instance['banner_code'] = $new_instance['banner_code'];
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_banner');
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'fullwidth' => '1',
			'banner_image' => '',
			'banner_link' => '',
			'banner_code' => ''
			), 'trx_addons_widget_banner')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_banner', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_banner', $this);
		
		$this->show_field(array('name' => 'fullwidth',
								'title' => __('Widget size:', 'trx_addons'),
								'value' => $instance['fullwidth'],
								'options' => array(
													'1' => __('Fullwidth', 'trx_addons'),
													'0' => __('Boxed', 'trx_addons')
													),
								'type' => 'switch'));
		
		$this->show_field(array('name' => 'banner_image',
								'title' => __('Image source URL:', 'trx_addons'),
								'value' => $instance['banner_image'],
								'type' => 'image'));
		
		$this->show_field(array('name' => 'banner_link',
								'title' => __('Image link URL:', 'trx_addons'),
								'value' => $instance['banner_link'],
								'type' => 'text'));

		$this->show_field(array('name' => 'banner_code',
								'title' => __('Paste HTML Code:', 'trx_addons'),
								'value' => $instance['banner_code'],
								'type' => 'textarea'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_banner', $this);
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_banner_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_banner_load_scripts_front');
	function trx_addons_widget_banner_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-widget_banner', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'banner/banner.css'), array(), null );
		}
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_banner_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_banner_merge_styles');
	function trx_addons_widget_banner_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'banner/banner.css';
		return $list;
	}
}



// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'banner/banner-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'banner/banner-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'banner/banner-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'banner/banner-sc-vc.php';
}
