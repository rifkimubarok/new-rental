<?php
/**
 * Widget: Instagram
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.47
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Load widget
if (!function_exists('trx_addons_widget_instagram_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_instagram_load' );
	function trx_addons_widget_instagram_load() {
		register_widget('trx_addons_widget_instagram');
	}
}

// Widget Class
class trx_addons_widget_instagram extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_instagram', 'description' => esc_html__('Last Instagram photos.', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_instagram', esc_html__('ThemeREX Instagram Feed', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$links = isset($instance['links']) ? $instance['links'] : 'instagram';
		$follow = isset($instance['follow']) ? $instance['follow'] : 0;
		$hashtag = isset($instance['hashtag']) ? $instance['hashtag'] : '';
		$count = isset($instance['count']) ? $instance['count'] : 1;
		$columns = isset($instance['columns']) ? min($count, (int) $instance['columns']) : 1;
		$columns_gap = isset($instance['columns_gap']) ? max(0, $instance['columns_gap']) : 0;

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/tpl.default.php',
									'trx_addons_args_widget_instagram', 
									apply_filters('trx_addons_filter_widget_args',
												array_merge($args, compact('title',
																			'links',
																			'follow',
																			'hashtag',
																			'count',
																			'columns',
																			'columns_gap')
															),
												$instance,
												'trx_addons_widget_instagram')
									);
	}

	// Update the widget settings.
	function update( $new_instance, $instance ) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['follow'] = !empty($new_instance['follow']) ? 1 : 0;
		$instance['links'] = strip_tags( $new_instance['links'] );
		$instance['hashtag'] = strip_tags( $new_instance['hashtag'] );
		$instance['count'] = (int) $new_instance['count'];
		$instance['columns'] = min($instance['count'], (int) $new_instance['columns']);
		$instance['columns_gap'] = max(0, $new_instance['columns_gap']);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_instagram');
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {
		
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '', 
			'follow' => 0,
			'links' => 'instagram',
			'hashtag' => '', 
			'count' => 8,
			'columns' => 4,
			'columns_gap' => 0
			), 'trx_addons_widget_instagram')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_instagram', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_instagram', $this);
		
		$this->show_field(array('name' => 'hashtag',
								'title' => __('Hash tag:', 'trx_addons'),
								'description' => __('Filter photos by hashtag. If empty - display all recent photos', 'trx_addons'),
								'value' => $instance['hashtag'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'count',
								'title' => __('Number of photos:', 'trx_addons'),
								'value' => max(1, min(30, (int) $instance['count'])),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'columns',
								'title' => __('Columns:', 'trx_addons'),
								'value' => max(1, min(12, (int) $instance['columns'])),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'columns_gap',
								'title' => __('Columns gap:', 'trx_addons'),
								'value' => max(0, (int) $instance['columns_gap']),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'links',
								'title' => __('Link images to:', 'trx_addons'),
								'description' => __('Where to send a visitor after clicking on the picture', 'trx_addons'),
								'value' => $instance['links'],
								'options' => trx_addons_get_list_sc_instagram_redirects(),
								'type' => 'select'));
		
		$this->show_field(array('name' => 'follow',
								'title' => __('Show button "Follow me"', 'trx_addons'),
								'description' => __('Add button "Follow me" after images', 'trx_addons'),
								'value' => (int) $instance['follow'],
								'type' => 'checkbox'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_instagram', $this);
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_instagram_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_instagram_load_scripts_front');
	function trx_addons_widget_instagram_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-widget_instagram', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/instagram.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_widget_instagram_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_instagram_load_responsive_styles', 2000);
	function trx_addons_widget_instagram_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-widget_instagram-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/instagram.responsive.css'), array(), null );
		}
	}
}


// Merge widget specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_widget_instagram_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_instagram_merge_styles');
	function trx_addons_widget_instagram_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/instagram.css';
		return $list;
	}
}


// Merge widget specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_widget_instagram_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_widget_instagram_merge_styles_responsive');
	function trx_addons_widget_instagram_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/instagram.responsive.css';
		return $list;
	}
}


// Load required styles and scripts for the admin
if ( !function_exists( 'trx_addons_widget_instagram_load_scripts_admin' ) ) {
	add_action("admin_enqueue_scripts", 'trx_addons_widget_instagram_load_scripts_admin');
	function trx_addons_widget_instagram_load_scripts_admin() {
		wp_enqueue_script( 'trx_addons-widget_instagram', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/instagram_admin.js'), array('jquery'), null, true );
	}
}

// Localize admin scripts
if ( !function_exists( 'trx_addons_widget_instagram_localize_script_admin' ) ) {
	add_action("trx_addons_filter_localize_script_admin", 'trx_addons_widget_instagram_localize_script_admin');
	function trx_addons_widget_instagram_localize_script_admin($vars) {
		$vars['api_instagram_get_code_uri'] = 'https://api.instagram.com/oauth/authorize/'
												. '?client_id='.urlencode(trx_addons_widget_instagram_get_client_id())
												. '&scope=public_content'
												. '&response_type=code'
												. '&redirect_uri='.urlencode(trx_addons_widget_instagram_rest_get_redirect_uri());
		return $vars;
	}
}

// Return Client ID from Instagram Application
if ( !function_exists( 'trx_addons_widget_instagram_get_client_id' ) ) {
	function trx_addons_widget_instagram_get_client_id() {
		$id = trx_addons_get_option('api_instagram_client_id');
		return !empty($id) ? $id : 'dacc2025c9084968b5c14aceea1404e1';
	}
}

// Return Client Secret from Instagram Application
if ( !function_exists( 'trx_addons_widget_instagram_get_client_secret' ) ) {
	function trx_addons_widget_instagram_get_client_secret() {
		return trx_addons_get_option('api_instagram_client_secret');
	}
}


require_once trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_WIDGETS . "instagram/instagram_rest_api.php");


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/instagram-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/instagram-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/instagram-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/instagram-sc-vc.php';
}
