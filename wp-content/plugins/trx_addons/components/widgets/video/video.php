<?php
/**
 * Widget: Video player for Youtube, Vimeo, etc. embeded video
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.1
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Load widget
if (!function_exists('trx_addons_widget_video_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_video_load' );
	function trx_addons_widget_video_load() {
		register_widget( 'trx_addons_widget_video' );
	}
}

// Widget Class
class trx_addons_widget_video extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_video', 'description' => esc_html__('Show video from Youtube, Vimeo, etc.', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_video', esc_html__('ThemeREX Video player', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$embed = isset($instance['embed']) ? $instance['embed'] : '';
		$link = isset($instance['link']) ? $instance['link'] : '';
		if (empty($embed) && empty($link)) return;
		$cover = isset($instance['cover']) ? $instance['cover'] : '';
		$popup = isset($instance['popup']) ? $instance['popup'] : 0;
		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'video/tpl.default.php',
										'trx_addons_args_widget_video',
										apply_filters('trx_addons_filter_widget_args',
											array_merge($args, compact('title', 'embed', 'link', 'cover', 'popup')),
											$instance, 'trx_addons_widget_video')
									);
	}

	// Update the widget settings.
	function update( $new_instance, $instance ) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['cover'] = strip_tags( $new_instance['cover'] );
		$instance['link']  = trim( $new_instance['link'] );
		$instance['embed'] = trim( $new_instance['embed'] );
		$instance['popup'] = intval( $new_instance['popup'] );
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_video');
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'cover' => '',
			'link' => '',
			'embed' => '',
			'popup' => 0
			), 'trx_addons_widget_video')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_video', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_video', $this);

		$this->show_field(array('name' => 'cover',
								'title' => __('Cover image URL:<br>(leave empty if you not need the cover)', 'trx_addons'),
								'value' => $instance['cover'],
								'type' => 'image'));
		
		$this->show_field(array('name' => 'link',
								'title' => __('Link to video:', 'trx_addons'),
								'value' => $instance['link'],
								'type' => 'text'));

		$this->show_field(array('name' => 'embed',
								'title' => __('or paste HTML code to embed video:', 'trx_addons'),
								'value' => $instance['embed'],
								'type' => 'textarea'));

		$this->show_field(array('name' => 'popup',
								'title' => '',
								'label' => __('Video in the popup', 'trx_addons'),
								'value' => (int) $instance['popup'],
								'dependency' => array(
									'cover' => array( 'not_empty' ),
								),
								'type' => 'checkbox'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_video', $this);
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_video_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_video_load_scripts_front');
	function trx_addons_widget_video_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-widget_video', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'video/video.css'), array(), null );
		}
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_video_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_video_merge_styles');
	function trx_addons_widget_video_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'video/video.css';
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'video/video-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'video/video-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'video/video-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'video/video-sc-vc.php';
}
