<?php
/**
 * Widget: Categories list
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
if (!function_exists('trx_addons_widget_categories_list_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_categories_list_load' );
	function trx_addons_widget_categories_list_load() {
		register_widget('trx_addons_widget_categories_list');
	}
}

// Widget Class
class trx_addons_widget_categories_list extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_categories_list', 'description' => esc_html__('Display categories list with icons or images', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_categories_list', esc_html__('ThemeREX Categories list', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$style = isset($instance['style']) ? max(1, (int) $instance['style']) : 1;
		$number = isset($instance['number']) ? (int) $instance['number'] : '';
		$columns = isset($instance['columns']) ? (int) $instance['columns'] : '';
		$columns_tablet = isset($instance['columns_tablet']) ? (int) $instance['columns_tablet'] : '';
		$columns_mobile = isset($instance['columns_mobile']) ? (int) $instance['columns_mobile'] : '';
		$show_thumbs = isset($instance['show_thumbs']) ? (int) $instance['show_thumbs'] : 0;
		$show_posts = isset($instance['show_posts']) ? (int) $instance['show_posts'] : 0;
		$show_children = isset($instance['show_children']) ? (int) $instance['show_children'] : 0;
		$post_type = isset($instance['post_type']) ? $instance['post_type'] : '';
		$taxonomy = isset($instance['taxonomy']) ? $instance['taxonomy'] : '';
		$cat_list = isset($instance['cat_list']) ? $instance['cat_list'] : '';

		if (!$show_thumbs && $style == 2) $style = 1;

		$q_obj = get_queried_object();

		$query_args = array(
			'type'                     => $post_type,
			'taxonomy'                 => $taxonomy,
			'include'                  => $cat_list,
			'number'                   => $number > 0 && empty($cat_list) ? $number : '',
			'parent'                   => $show_children
												? (is_category() 
													? (int) get_query_var('cat') 
													: (is_tax() && !empty($q_obj->term_id)
														? $q_obj->term_id
														: (empty($cat_list) ? 0 : '')
														)
													)
												: (empty($cat_list) ? 0 : ''),
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => true,
			'hierarchical'             => true,
			'pad_counts'               => $show_posts > 0
		);

		$categories = get_terms($query_args);

		// If result is empty - exit without output
		if (count($categories)==0) return;

		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/tpl.categories-list-'.trim($style).'.php',
										TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/tpl.categories-list-1.php'
										),
                                        'trx_addons_args_widget_categories_list',
										apply_filters('trx_addons_filter_widget_args',
												array_merge($args, compact('title', 'style', 'number',
																	'columns', 'columns_tablet', 'columns_mobile',
																	'show_posts', 'show_children', 'show_thumbs',
																	'categories', 'post_type', 'taxonomy')),
												$instance, 'trx_addons_widget_categories_list')
                                    );
	}

	// Update the widget settings
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['style'] = (int) $new_instance['style'];
		$instance['number'] = (int) $new_instance['number'];
		$instance['columns'] = (int) $new_instance['columns'];
		$instance['show_thumbs'] = !empty($new_instance['show_thumbs']) ? 1 : 0;
		$instance['show_posts'] = !empty($new_instance['show_posts']) ? 1 : 0;
		$instance['show_children'] = !empty($new_instance['show_children']) ? 1 : 0;
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$instance['taxonomy'] = strip_tags($new_instance['taxonomy']);
		$instance['cat_list'] = join(',', $new_instance['cat_list']);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_categories_list');
	}

	// Displays the widget settings controls on the widget panel
	function form($instance) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'style' => '1',
			'number' => '5',
			'columns' => '5',
			'show_thumbs' => '1',
			'show_posts' => '1',
			'show_children' => '0',
			'post_type' => 'post',
			'taxonomy' => 'category',
			'cat_list' => ''
			), 'trx_addons_widget_categories_list')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_categories_list', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_categories_list', $this);
		
		$this->show_field(array('name' => 'style',
								'title' => __('Output style:', 'trx_addons'),
								'value' => (int) $instance['style'],
								'options' => trx_addons_components_get_allowed_layouts('widgets', 'categories_list'),
								'type' => 'switch'));
		
		$this->show_field(array('name' => 'post_type',
								'title' => __('Post type:', 'trx_addons'),
								'value' => $instance['post_type'],
								'options' => trx_addons_get_list_posts_types(),
								'class' => 'trx_addons_post_type_selector',
								'type' => 'select'));
		
		$this->show_field(array('name' => 'taxonomy',
								'title' => __('Taxonomy:', 'trx_addons'),
								'value' => $instance['taxonomy'],
								'options' => trx_addons_get_list_taxonomies(false, $instance['post_type']),
								'class' => 'trx_addons_taxonomy_selector',
								'type' => 'select'));
		
		$this->show_field(array('name' => 'cat_list',
								'title' => __('Categories to show:', 'trx_addons'),
								'value' => $instance['cat_list'],
								'options' => trx_addons_get_list_terms(false, $instance['taxonomy']),
								'class' => 'trx_addons_terms_selector',
								'type' => 'checklist'));
		
		$this->show_field(array('name' => 'number',
								'title' => __('Number categories to show (if field above is empty):', 'trx_addons'),
								'value' => (int) $instance['number'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'columns',
								'title' => __('Columns number:', 'trx_addons'),
								'value' => (int) $instance['columns'],
								'type' => 'text'));

		$this->show_field(array('name' => 'show_thumbs',
								'title' => __('Show images:', 'trx_addons'),
								'value' => (int) $instance['show_thumbs'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'show_posts',
								'title' => __('Show posts count:', 'trx_addons'),
								'value' => (int) $instance['show_posts'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'type' => 'switch'));

		$this->show_field(array('name' => 'show_children',
								'title' => __('Only children of the current category:', 'trx_addons'),
								'value' => (int) $instance['show_children'],
								'options' => array(
													1 => __('Children', 'trx_addons'),
													0 => __('From root', 'trx_addons')
													),
								'type' => 'switch'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_categories_list', $this);
	}
}

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_categories_list_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_categories_list_load_scripts_front');
	function trx_addons_widget_categories_list_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-widget_categories_list', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_widget_categories_list_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_categories_list_load_responsive_styles', 2000);
	function trx_addons_widget_categories_list_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-widget_categories_list-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list.responsive.css'), array(), null );
		}
	}
}

// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_categories_list_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_categories_list_merge_styles');
	function trx_addons_widget_categories_list_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list.css';
		return $list;
	}
}


// Merge widget's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_widget_categories_list_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_widget_categories_list_merge_styles_responsive');
	function trx_addons_widget_categories_list_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list.responsive.css';
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'categories_list/categories_list-sc-vc.php';
}
