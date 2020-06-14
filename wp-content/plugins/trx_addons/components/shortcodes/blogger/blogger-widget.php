<?php
/**
 * Shortcode: Blogger (Widget)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// TRX_Addons Widget
//------------------------------------------------------
if ( ! class_exists('TRX_Addons_SOW_Widget') ) {

	class TRX_Addons_SOW_Widget_Blogger extends TRX_Addons_Widget {
	
		function __construct() {
			$widget_ops = array('classname' => 'widget_blogger', 'description' => esc_html__('Show blog posts', 'trx_addons'));
			parent::__construct( 'trx_addons_sow_widget_blogger', esc_html__('ThemeREX Blogger', 'trx_addons'), $widget_ops );
		}
	
		// Show widget
		function widget($args, $instance) {
			extract($args);
	
			$widget_title = apply_filters('widget_title', isset($instance['widget_title']) ? $instance['widget_title'] : '');
	
			$output = trx_addons_sc_blogger(apply_filters('trx_addons_filter_widget_args',
															$instance,
															$instance, 'trx_addons_sow_widget_blogger')
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
			$instance['show_filters'] = isset( $new_instance['show_filters'] ) ? 1 : 0;
			$instance['filters_all'] = isset( $new_instance['filters_all'] ) ? 1 : 0;
			$instance['hide_excerpt'] = isset( $new_instance['hide_excerpt'] ) ? 1 : 0;
			$instance['on_plate'] = isset( $new_instance['on_plate'] ) ? 1 : 0;
			$instance['numbers'] = isset( $new_instance['numbers'] ) ? 1 : 0;
			$instance['no_links'] = isset( $new_instance['no_links'] ) ? 1 : 0;
			$instance['slider'] = isset( $new_instance['slider'] ) ? 1 : 0;
			$instance['slides_centered'] = isset( $new_instance['slides_centered'] ) ? 1 : 0;
			$instance['slides_overflow'] = isset( $new_instance['slides_overflow'] ) ? 1 : 0;
			$instance['slider_mouse_wheel'] = isset( $new_instance['slider_mouse_wheel'] ) ? 1 : 0;
			$instance['slider_autoplay'] = isset( $new_instance['slider_autoplay'] ) ? 1 : 0;
			return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_sow_widget_blogger');
		}
	
		// Displays the widget settings controls on the widget panel
		function form($instance) {
			// Set up some default widget settings
			$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
				'widget_title' => '',
				// Layout params
				"type" => "default",
				// Query params
				'post_type' => 'post',
				'taxonomy' => 'category',
				"cat" => '',
				"count" => 3,
				"columns" => '',
				"offset" => 0,
				"orderby" => 'date',
				"order" => 'desc',
				"ids" => '',
				//Filter
				"show_filters" => 0,
				"filters_title" => '',
				"filters_subtitle" => '',
				"filters_title_align" => 'none',
				"filters_taxonomy" => 'category',
				"filters_active" => '',
				"filters_ids" => '',
				"filters_all" => 1,
				"filters_all_text" => __('All', 'trx_addons'),
				"filters_more_text" => __('More posts', 'trx_addons'),
				// Post meta
				"meta_parts" => array('date', 'views', 'comments'),
				// Output options
				"on_plate" => 0,
				"numbers" => 0,
				"image_position" => 'top',
				"image_width" => '40',
				"image_ratio" => 'none',
				"date_format" => '',
				"excerpt_length" => '',
				"text_align" => 'left',
				"hide_excerpt" => 0,
				"no_links" => 0,
				"more_text" => __('Read more', 'trx_addons'),
				'pagination' => 'none',
				// Slider params
				"slider" => 0,
				"slider_pagination" => "none",
				"slider_controls" => "none",
				"slides_space" => 0,
				"slides_centered" => 0,
				"slides_overflow" => 0,
				"slider_mouse_wheel" => 0,
				"slider_autoplay" => 1,
				// Title params
				"title" => "",
				"subtitle" => "",
				"subtitle_align" => "none",
				"subtitle_position" => trx_addons_get_setting('subtitle_above_title') ? 'above' : 'below',
				"description" => "",
				"link" => '',
				"link_style" => 'default',
				"link_image" => '',
				"link_text" => __('Learn more', 'trx_addons'),
				"title_align" => "left",
				"title_style" => "default",
				"title_tag" => '',
				"title_color" => '',
				"title_color2" => '',
				"gradient_direction" => '',
				// Common params
				"id" => "",
				"class" => "",
				"css" => ""
				), 'trx_addons_sow_widget_blogger')
			);
		
			do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_sow_widget_blogger', $this);
			
			$this->show_field(array('name' => 'widget_title',
									'title' => __('Widget title', 'trx_addons'),
									'value' => $instance['widget_title'],
									'type' => 'text'));
		
			do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_sow_widget_blogger', $this);

			$this->show_field(array('title' => __('Layout parameters', 'trx_addons'),
									'type' => 'info'));

			$layouts = apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'blogger'), 'trx_sc_blogger');
			$this->show_field(array('name' => 'type',
									'title' => __('Layout', 'trx_addons'),
									'value' => $instance['type'],
									'options' => $layouts,
									'type' => 'select'));

			$this->show_field(array('title' => __('Query parameters', 'trx_addons'),
									'type' => 'info'));

			$this->show_field(array('name' => 'post_type',
									'title' => __('Post type', 'trx_addons'),
									'value' => $instance['post_type'],
									'options' => trx_addons_get_list_posts_types(),
									'class' => 'trx_addons_post_type_selector',
									'type' => 'select'));

			$this->show_field(array('name' => 'taxonomy',
									'title' => __('Taxonomy', 'trx_addons'),
									'value' => $instance['taxonomy'],
									'options' => trx_addons_get_list_taxonomies(false, $instance['post_type']),
									'class' => 'trx_addons_taxonomy_selector',
									'type' => 'select'));


			$tax_obj = get_taxonomy($instance['taxonomy']);

			$this->show_field(array('name' => 'cat',
									'title' => __('Category', 'trx_addons'),
									'value' => $instance['cat'],
									'options' => trx_addons_array_merge(
											array(0 => sprintf(__('- %s -', 'trx_addons'), $tax_obj->label)),
											trx_addons_get_list_terms(false, $instance['taxonomy'], array('pad_counts' => true))),
									'class' => 'trx_addons_terms_selector',
									'type' => 'select'));

			$this->show_fields_query_param($instance, '');

			$this->show_field(array('name' => 'pagination',
									'title' => __('Pagination', 'trx_addons'),
									'value' => $instance['pagination'],
									'options' => trx_addons_get_list_sc_paginations(),
									'type' => 'select'));

			$this->show_field(array('title' => __('Filters', 'trx_addons'),
									'type' => 'info'));

			$this->show_field(array('name' => 'filters_title',
				'title' => __("Filters area title", 'trx_addons'),
				'value' => $instance['filters_title'],
				'type' => 'text'));

			$this->show_field(array('name' => 'filters_subtitle',
				'title' => __("Filters area subtitle", 'trx_addons'),
				'value' => $instance['filters_title'],
				'type' => 'text'));

			$this->show_field(array('name' => 'filters_title_align',
				'title' => __('Filters titles position', 'trx_addons'),
				'value' => $instance['filters_title_align'],
				'options' => trx_addons_get_list_sc_aligns(false, false),
				'type' => 'select'));

			$this->show_field(array('name' => 'show_filters',
				'title' => '',
				'label' => __('Show filters tabs', 'trx_addons'),
				'value' => (int) $instance['show_filters'],
				'type' => 'checkbox'));

			$this->show_field(array('name' => 'filters_taxonomy',
				'title' => __('Filters taxonomy', 'trx_addons'),
				'value' => $instance['filters_taxonomy'],
				'options' => trx_addons_get_list_taxonomies(false, $instance['post_type']),
				'class' => 'trx_addons_taxonomy_selector',
				'dependency' => array(
					'show_filters' => array( 1 ),
				),
				'type' => 'select'));

			$this->show_field(array('name' => 'filters_ids',
				'title' => __('Filters terms', 'trx_addons'),
				'description' => __("Comma separated list with term IDs or term names to show as filters. If empty - show all terms from filters taxonomy above", 'trx_addons'),
				'value' => $instance['filters_ids'],
				'dependency' => array(
					'show_filters' => array( 1 ),
				),
				'type' => 'text'));

			$this->show_field(array('name' => 'filters_all',
				'title' => '',
				'label' => __('Display the "All" tab', 'trx_addons'),
				'value' => (int) $instance['filters_all'],
				'dependency' => array(
					'show_filters' => array( 1 ),
				),
				'type' => 'checkbox'));

			$this->show_field(array('name' => 'filters_all_text',
				'title' => __('"All" tab text', 'trx_addons'),
				'value' => $instance['filters_all_text'],
				'dependency' => array(
					'show_filters' => array( 1 ),
					'filters_all' => array( 1 ),
				),
				'type' => 'text'));

			$this->show_field(array('name' => 'filters_more_text',
									'title' => __("'More posts' text", 'trx_addons'),
									'value' => $instance['more_text'],
									'dependency' => array(
										'show_filters' => array( 0 ),
									),
									'type' => 'text'));

			$this->show_field(array('title' => __('Details', 'trx_addons'),
									'type' => 'info'));

			$templates = trx_addons_components_get_allowed_templates('sc', 'blogger', $layouts);

			if ( is_array($templates) ) {
				foreach ($templates as $k => $v) {
					$options = array();
					if (is_array($v)) {
						foreach($v as $k1 => $v1) {
							$options[$k1] = !empty($v1['title']) ? $v1['title'] : ucfirst( str_replace( array('_', '-'), ' ', $k1 ) );
						}
					}
					$this->show_field(array('name' => 'template_' . $k,
						'title' => sprintf( __('Template for %s', 'trx_addons'), $layouts[$k]),
						'dependency' => array(
							'type' => array( $k )
						),
						'value' => isset($instance['template_' . $k]) ? $instance['template_' . $k] : trx_addons_array_get_first($options),
						'options' => $options,
						'type' => 'select'));
				}
			}

			$this->show_field(array('name' => 'image_position',
				'title' => __('Image position', 'trx_addons'),
				'dependency' => array(
					'type' => array( 'default', 'wide', 'list', 'news' )
				),
				'value' => $instance['image_position'],
				'options' => trx_addons_get_list_sc_blogger_image_positions(),
				'type' => 'select'));

			$this->show_field(array('name' => 'image_width',
				'title' => __('Image width', 'trx_addons'),
				'description' => wp_kses_data( __("Specify image_width (in %)", 'trx_addons') ),
				'dependency' => array(
					'type' => array( 'default', 'wide', 'list', 'news' ),
					'image_position' => array( 'left', 'right', 'alter' ),
				),
				'value' => $instance['image_width'],
				'type' => 'text'));

			$this->show_field(array('name' => 'image_ratio',
				'title' => __('Image ratio', 'trx_addons'),
				'dependency' => array(
					'type' => array( 'default', 'wide', 'list', 'news' )
				),
				'value' => $instance['image_ratio'],
				'options' => trx_addons_get_list_sc_image_ratio(),
				'type' => 'select'));

			$meta_parts = apply_filters('trx_addons_filter_get_list_meta_parts', array());
			$this->show_field(array('name' => 'meta_parts',
				'title' => __('Choose meta parts', 'trx_addons'),
				'dependency' => array(
					'type' => array( 'default', 'wide', 'list', 'news' )
				),
				'value' => $instance['meta_parts'],
				'multiple' => true,
				'options' => $meta_parts,
				'type' => 'select'));

			$this->show_field(array('name' => 'date_format',
				'title' => __('Date format', 'trx_addons'),
				'dependency' => array(
					'type' => array( 'default', 'wide', 'list', 'news' ),
				),
				'value' => $instance['date_format'],
				'type' => 'text'));

			$this->show_field(array('name' => 'text_align',
				'title' => __('Text alignment', 'trx_addons'),
				'dependency' => array(
					'type' => array( 'default', 'wide', 'list', 'news' )
				),
				'value' => $instance['text_align'],
				'options' => trx_addons_get_list_sc_aligns(),
				'type' => 'select'));

			$this->show_field(array('name' => 'on_plate',
									'title' => '',
									'label' => __('On plate', 'trx_addons'),
									'value' => (int) $instance['on_plate'],
									'type' => 'checkbox'));

			$this->show_field(array('name' => 'numbers',
									'title' => '',
									'label' => __('Show numbers', 'trx_addons'),
									'value' => (int) $instance['on_plate'],
									'dependency' => array(
										'type' => array( 'list' )
									),
									'type' => 'checkbox'));

			$this->show_field(array('name' => 'hide_excerpt',
									'title' => '',
									'label' => __('Hide excerpt', 'trx_addons'),
									'value' => (int) $instance['hide_excerpt'],
									'dependency' => array(
										'type' => array( '^list' )
									),
									'type' => 'checkbox'));

			$this->show_field(array('name' => 'excerpt_length',
				'title' => __('Text length (in words)', 'trx_addons'),
				'dependency' => array(
					'hide_excerpt' => array( 0 ),
				),
				'value' => $instance['excerpt_length'],
				'type' => 'text'));

			$this->show_field(array('name' => 'no_links',
									'title' => '',
									'label' => __('Disable links', 'trx_addons'),
									'value' => (int) $instance['no_links'],
									'type' => 'checkbox'));

			$this->show_field(array('name' => 'more_text',
									'title' => __("'More' text", 'trx_addons'),
									'value' => $instance['more_text'],
									'dependency' => array(
										'no_links' => array( 0 ),
									),
									'type' => 'text'));

			$this->show_fields_slider_param($instance);

			$this->show_fields_title_param($instance);

			$this->show_fields_id_param($instance);
		
			do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_sow_widget_blogger', $this);
		}
	}

	// Load widget
	if (!function_exists('trx_addons_sow_widget_blogger_load')) {
		add_action( 'widgets_init', 'trx_addons_sow_widget_blogger_load' );
		function trx_addons_sow_widget_blogger_load() {
			register_widget('TRX_Addons_SOW_Widget_Blogger');
		}
	}
}
