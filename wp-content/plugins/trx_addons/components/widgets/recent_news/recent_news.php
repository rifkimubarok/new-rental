<?php
/**
 * Widget: Recent News
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
if (!function_exists('trx_addons_widget_recent_news_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_recent_news_load' );
	function trx_addons_widget_recent_news_load() {
		register_widget('trx_addons_widget_recent_news');
	}
}


// Widget Class
//------------------------------------------------------
class trx_addons_widget_recent_news extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_news', 'description' => esc_html__('Show recent news in many styles', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_recent_news', esc_html__('ThemeREX Recent News', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		extract($args);

		$widget_title = apply_filters('widget_title', isset($instance['widget_title']) ? $instance['widget_title'] : '');

		$output = trx_addons_sc_recent_news( apply_filters('trx_addons_filter_widget_args',
							array(
								'title' 			=> isset($instance['title']) ? $instance['title'] : '',
								'subtitle'			=> isset($instance['subtitle']) ? $instance['subtitle'] : '',
								'style'				=> isset($instance['style']) ? $instance['style'] : 'news-magazine',
								'count'				=> isset($instance['count']) ? (int) $instance['count'] : 3,
								'featured'			=> isset($instance['featured']) ? (int) $instance['featured'] : 0,
								'columns'			=> isset($instance['columns']) ? (int) $instance['columns'] : 1,
								'category'			=> isset($instance['category']) ? (int) $instance['category'] : 0,
								'show_categories'	=> isset($instance['show_categories']) ? (int) $instance['show_categories'] : 0
								),
							$instance, 'trx_addons_widget_recent_news')
		);

		if (!empty($output)) {
	
			// Before widget (defined by themes)
			trx_addons_show_layout($before_widget);
			
			// Display the widget title if one was input (before and after defined by themes)
			if ($widget_title) trx_addons_show_layout($before_title . $widget_title . $after_title);
	
			// Display widget body
			trx_addons_show_layout($output);
			
			// After widget (defined by themes)
			trx_addons_show_layout($after_widget);
		}
	}

	// Update the widget settings
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['style']			= $new_instance['style'];
		$instance['count']			= max(1, (int) $new_instance['count']);
		$instance['featured']		= max(0, min($instance['count'], (int) $new_instance['featured']));
		$instance['columns']		= max(1, min($instance['featured']+1, (int) $new_instance['columns']));		//	Columns <= Featured+1
		$instance['category']		= max(0, (int) $new_instance['category']);
		$instance['show_categories']= (int) $new_instance['show_categories'] > 0 ? 1 : 0;
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_recent_news');
	}

	// Displays the widget settings controls on the widget panel
	function form($instance) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'widget_title' => '',
			'title' => '',
			'subtitle' => '',
			'style' => 'news-magazine',
			'count' => 3,
			'featured' => 3,
			'columns' => 1,
			'category' => 0,
			'show_categories' => 1
			), 'trx_addons_widget_recent_news')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_recent_news', $this);
		
		$this->show_field(array('name' => 'widget_title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['widget_title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_recent_news', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Block title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'subtitle',
								'title' => __('Block subtitle:', 'trx_addons'),
								'value' => $instance['subtitle'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'style',
								'title' => __('Style:', 'trx_addons'),
								'value' => $instance['style'],
								'options' => trx_addons_components_get_allowed_layouts('widgets', 'recent_news'),
								'type' => 'select'));
		
		$this->show_field(array('name' => 'count',
								'title' => __('Number of displayed posts:', 'trx_addons'),
								'value' => (int) $instance['count'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'featured',
								'title' => __('Number of featured posts:', 'trx_addons'),
								'value' => (int) $instance['featured'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'columns',
								'title' => __('Number of columns:', 'trx_addons'),
								'value' => (int) $instance['columns'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'category',
								'title' => __('Parent category:', 'trx_addons'),
								'value' => (int) $instance['category'],
								'options' => trx_addons_array_merge(array(__('- All categories -', 'trx_addons')), trx_addons_get_list_categories(false)),
								'type' => 'select'));

		$this->show_field(array('name' => 'show_categories',
								'title' => __("Show categories dropdown:", 'trx_addons'),
								'value' => (int) $instance['show_categories'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_recent_news', $this);
	}
}

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_recent_news_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_recent_news_load_scripts_front');
	function trx_addons_widget_recent_news_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-widget_recent_news', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'recent_news/recent_news.css'), array(), null );
			wp_enqueue_script( 'trx_addons-widget_recent_news', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'recent_news/recent_news.js'), array('jquery'), null, true );
		}
	}
}


// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_widget_recent_news_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_recent_news_load_responsive_styles', 2000);
	function trx_addons_widget_recent_news_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-widget_recent_news-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'recent_news/recent_news.responsive.css'), array(), null );
		}
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_recent_news_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_recent_news_merge_styles');
	function trx_addons_widget_recent_news_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'recent_news/recent_news.css';
		return $list;
	}
}


// Merge widget's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_widget_recent_news_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_widget_recent_news_merge_styles_responsive');
	function trx_addons_widget_recent_news_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'recent_news/recent_news.responsive.css';
		return $list;
	}
}

	
// Merge widget specific scripts into single file
if ( !function_exists( 'trx_addons_widget_recent_news_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_widget_recent_news_merge_scripts');
	function trx_addons_widget_recent_news_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'recent_news/recent_news.js';
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'recent_news/recent_news-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'recent_news/recent_news-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'recent_news/recent_news-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'recent_news/recent_news-sc-vc.php';
}
