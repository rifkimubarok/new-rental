<?php
/**
 * Widget: Socials
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
if (!function_exists('trx_addons_widget_socials_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_socials_load' );
	function trx_addons_widget_socials_load() {
		register_widget('trx_addons_widget_socials');
	}
}

// Widget Class
class trx_addons_widget_socials extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_socials', 'description' => esc_html__('Socials - show links to the profiles in your favorites social networks', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_socials', esc_html__('ThemeREX Socials', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$description = isset($instance['description']) ? $instance['description'] : '';
		$align = isset($instance['align']) ? $instance['align'] : '';
		$type = isset($instance['type']) ? $instance['type'] : 'socials';

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'socials/tpl.default.php',
										'trx_addons_args_widget_socials', 
										apply_filters('trx_addons_filter_widget_args',
											array_merge($args, compact('title', 'align', 'description', 'type')),
											$instance, 'trx_addons_widget_socials')
									);
	}

	// Update the widget settings.
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['description'] = wp_kses_data($new_instance['description']);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_socials');
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'description' => '',
			'align' => 'none',
			'type' => 'socials'
			), 'trx_addons_widget_socials')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_socials', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));

		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_socials', $this);

		$this->show_field(array('name' => 'type',
								'title' => __('Icons type:', 'trx_addons'),
								'value' => $instance['type'],
								'options' => trx_addons_get_list_sc_socials_types(),
								'type' => 'select'));

		$this->show_field(array('name' => 'align',
								'title' => __('Icons align:', 'trx_addons'),
								'value' => $instance['align'],
								'options' => trx_addons_get_list_sc_aligns(),
								'type' => 'select'));

		$this->show_field(array('name' => 'description',
								'title' => __('Short description:', 'trx_addons'),
								'value' => $instance['description'],
								'type' => 'textarea'));

		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_socials', $this);
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_socials_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_socials_load_scripts_front');
	function trx_addons_widget_socials_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-widget_socials', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'socials/socials.css'), array(), null );
		}
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_socials_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_socials_merge_styles');
	function trx_addons_widget_socials_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'socials/socials.css';
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'socials/socials-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'socials/socials-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'socials/socials-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'socials/socials-sc-vc.php';
}
