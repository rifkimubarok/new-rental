<?php
/**
 * Widget: Flickr
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
if (!function_exists('trx_addons_widget_flickr_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_flickr_load' );
	function trx_addons_widget_flickr_load() {
		register_widget('trx_addons_widget_flickr');
	}
}

// Widget Class
class trx_addons_widget_flickr extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_flickr', 'description' => esc_html__('Last flickr photos.', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_flickr', esc_html__('ThemeREX Flickr photos', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$flickr_api_key = isset($instance['flickr_api_key']) ? $instance['flickr_api_key'] : '';
		$flickr_username = isset($instance['flickr_username']) ? $instance['flickr_username'] : '';
		$flickr_count = isset($instance['flickr_count']) ? $instance['flickr_count'] : 1;
		$flickr_columns = isset($instance['flickr_columns']) ? min($flickr_count, (int) $instance['flickr_columns']) : 1;
		$flickr_columns_gap = isset($instance['flickr_columns_gap']) ? max(0, $instance['flickr_columns_gap']) : 0;

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'flickr/tpl.default.php',
									'trx_addons_args_widget_flickr', 
									apply_filters('trx_addons_filter_widget_args',
												array_merge($args, compact('title', 'flickr_api_key', 'flickr_username', 'flickr_count', 'flickr_columns', 'flickr_columns_gap')),
												$instance, 'trx_addons_widget_flickr')
									);
	}

	// Update the widget settings.
	function update( $new_instance, $instance ) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickr_api_key'] = strip_tags( $new_instance['flickr_api_key'] );
		$instance['flickr_username'] = strip_tags( $new_instance['flickr_username'] );
		$instance['flickr_count'] = (int) $new_instance['flickr_count'];
		$instance['flickr_columns'] = min($instance['flickr_count'], (int) $new_instance['flickr_columns']);
		$instance['flickr_columns_gap'] = max(0, $new_instance['flickr_columns_gap']);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_flickr');
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {
		
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '', 
			'flickr_api_key' => '', 
			'flickr_username' => '', 
			'flickr_count' => 8,
			'flickr_columns' => 4,
			'flickr_columns_gap' => 0
			), 'trx_addons_widget_flickr')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_flickr', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_flickr', $this);
		
		$this->show_field(array('name' => 'flickr_api_key',
								'title' => __('Flickr API key:', 'trx_addons'),
								'value' => $instance['flickr_api_key'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'flickr_username',
								'title' => __('Flickr ID:', 'trx_addons'),
								'value' => $instance['flickr_username'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'flickr_count',
								'title' => __('Number of photos:', 'trx_addons'),
								'value' => max(1, min(30, (int) $instance['flickr_count'])),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'flickr_columns',
								'title' => __('Columns:', 'trx_addons'),
								'value' => max(1, min(12, (int) $instance['flickr_columns'])),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'flickr_columns_gap',
								'title' => __('Columns gap:', 'trx_addons'),
								'value' => max(0, (int) $instance['flickr_columns_gap']),
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_flickr', $this);
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_flickr_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_flickr_load_scripts_front');
	function trx_addons_widget_flickr_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-widget_flickr', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'flickr/flickr.css'), array(), null );
		}
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_flickr_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_flickr_merge_styles');
	function trx_addons_widget_flickr_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'flickr/flickr.css';
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'flickr/flickr-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'flickr/flickr-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'flickr/flickr-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'flickr/flickr-sc-vc.php';
}
