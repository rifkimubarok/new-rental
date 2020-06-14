<?php
/**
 * Widget: Posts or Revolution slider
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
if (!function_exists('trx_addons_widget_slider_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_slider_load' );
	function trx_addons_widget_slider_load() {
		register_widget( 'trx_addons_widget_slider' );
	}
}

// Widget Class
class trx_addons_widget_slider extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_slider', 'description' => esc_html__('Display theme slider', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_slider', esc_html__('ThemeREX Slider', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$engine = isset($instance['engine']) ? $instance['engine'] : 'swiper';

		// Before widget (defined by themes)
		trx_addons_show_layout($before_widget);

		// Display the widget title if one was input (before and after defined by themes)
		if ($title)	trx_addons_show_layout($before_title . $title . $after_title);

		// Widget body
		$html = '';
		if (in_array($engine, array('swiper', 'elastistack'))) {
			$slider_id = isset($instance['slider_id']) && !empty($instance['slider_id'])
									? $instance['slider_id']
									: (isset($instance['id'])
										? $instance['id'] 
										: '');
			$slider_style = isset($instance['slider_style']) ? $instance['slider_style'] : 'default';
			$effect = isset($instance['effect']) ? $instance['effect'] : 'slide';
			$slides = isset($instance['slides']) ? $instance['slides'] : array();
			$slides_type = isset($instance['slides_type']) ? $instance['slides_type'] : 'bg';
			$slides_ratio = isset($instance['slides_ratio']) ? $instance['slides_ratio'] : '16:9';
			$slides_per_view = in_array($effect, array('slide', 'coverflow')) && isset($instance['slides_per_view'])
									? $instance['slides_per_view'] 
									: 1;
			$slides_space = isset($instance['slides_space']) ? $instance['slides_space'] : 1;
			$slides_ratio = isset($instance['slides_ratio']) ? $instance['slides_ratio'] : '16:9';
			$slides_centered = isset($instance['slides_centered']) && $instance['slides_centered'] > 0 ? 'yes' : 'no';
			$slides_overflow = isset($instance['slides_overflow']) && $instance['slides_overflow'] > 0 ? 'yes' : 'no';
			$mouse_wheel = isset($instance['mouse_wheel']) && $instance['mouse_wheel'] > 0 ? 'yes' : 'no';
			$autoplay = isset($instance['autoplay']) && $instance['autoplay'] > 0 ? 'yes' : 'no';
			$noresize = isset($instance['noresize']) && $instance['noresize'] > 0 ? 'yes' : 'no';
			$height = isset($instance['height']) ? $instance['height'] : 0;
			$post_type = isset($instance['post_type']) ? $instance['post_type'] : 'post';
			$taxonomy = isset($instance['taxonomy']) ? $instance['taxonomy'] : 'category';
			$category = isset($instance['category']) ? (int) $instance['category'] : 0;
			$posts = isset($instance['posts']) ? $instance['posts'] : 5;
			$interval = isset($instance['interval']) ? max(0, (int) $instance['interval']) : mt_rand(5000, 10000);
			$titles = isset($instance['titles']) ? $instance['titles'] : 'center';
			$large = isset($instance['large']) && $instance['large'] > 0 ? "on" : "off";
			$noswipe = isset($instance['noswipe']) && $instance['noswipe'] > 0 ? "on" : "off";
			$controls = isset($instance['controls']) && $instance['controls'] > 0 ? "on" : "off";
			$controls_pos = isset($instance['controls_pos']) ? $instance['controls_pos'] : "side";
			$label_prev = isset($instance['label_prev']) ? $instance['label_prev'] : '';
			$label_next = isset($instance['label_next']) ? $instance['label_next'] : '';
			$pagination = isset($instance['pagination']) && $instance['pagination'] > 0 ? "on" : "off";
			$pagination_type = isset($instance['pagination_type']) ? $instance['pagination_type'] : "bullets";
			$pagination_pos = isset($instance['pagination_pos']) ? $instance['pagination_pos'] : "bottom";
			$direction = isset($instance['direction']) && $instance['direction'] == 'vertical' ? "vertical" : "horizontal";
			$count = $ids = $posts;
			if (strpos($ids, ',')!==false) {
				$count = 0;
			} else {
				$ids = '';
				if (empty($count)) $count = count($slides) > 1 ? count($slides) : 3;
			}
			if ($count > 0 || !empty($ids)) {
				$html = trx_addons_get_slider_layout(
							apply_filters('trx_addons_filter_widget_args',
								array(
									'mode' => empty($slides) ? 'posts' : 'custom',
									'engine' => $engine,
									'style' => $slider_style,
									'slides_type' => $slides_type,
									'slides_ratio' => $slides_ratio,
									'noresize' => $noresize,
									'effect' => $effect,
									'noswipe' => $noswipe,
									'controls' => $controls,
									'controls_pos' => $controls_pos,
									'label_prev' => $label_prev,
									'label_next' => $label_next,
									'pagination' => $pagination,
									'pagination_type' => $pagination_type,
									'pagination_pos' => $pagination_pos,
									'direction' => $direction,
									'titles' => $titles,
									'large' => $large,
									'interval' => $interval,
									'height' => $height,
									'per_view' => $slides_per_view,
									'slides_space' => $slides_space,
									'slides_ratio' => $slides_ratio,
									'slides_centered' => $slides_centered,
									'slides_overflow' => $slides_overflow,
									'mouse_wheel' => $mouse_wheel,
									'autoplay' => $autoplay,
									'post_type' => $post_type,
									'taxonomy' => $taxonomy,
									'cat' => $category,
									'ids' => $ids,
									'count' => $count,
									'orderby' => "date",
									'order' => "desc",
									'class' => "",	// "slider_height_fixed"
									'id' => $slider_id
									),
								$instance, 'trx_addons_widget_slider'),
							$slides);
			}

		} else if ($engine=='revo') {
			$alias = isset($instance['alias']) ? $instance['alias'] : '';
			if (!empty($alias)) {
				$html = do_shortcode('[rev_slider alias="'.esc_attr($alias).'"]');
				if (empty($html)) $html = do_shortcode('[rev_slider '.esc_attr($alias).']');
			}
		}
		if (!empty($html)) {
			?>
			<div class="slider_wrap slider_engine_<?php echo esc_attr($engine); ?><?php if ($engine=='revo') echo ' slider_alias_'.esc_attr($alias); ?>">
				<?php trx_addons_show_layout($html); ?>
			</div>
			<?php 
		}

		// After widget (defined by themes)
		trx_addons_show_layout($after_widget);
	}

	// Update the widget settings.
	function update( $new_instance, $instance ) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['engine'] = strip_tags( $new_instance['engine'] );
		$instance['slider_style'] = strip_tags( $new_instance['slider_style'] );
		$instance['slides_per_view'] = intval( $new_instance['slides_per_view'] );
		$instance['slides_space'] = intval( $new_instance['slides_space'] );
		$instance['slides_ratio'] = str_replace( array('-', '/', ' '), array( ':', ':', ''), $new_instance['slides_ratio'] );
		$instance['slides_centered'] = intval( $new_instance['slides_centered'] );
		$instance['slides_overflow'] = intval( $new_instance['slides_overflow'] );
		$instance['noresize'] = intval( $new_instance['noresize'] );
		$instance['mouse_wheel'] = intval( $new_instance['mouse_wheel'] );
		$instance['noswipe'] = intval( $new_instance['noswipe'] );
		$instance['autoplay'] = intval( $new_instance['autoplay'] );
		$instance['effect'] = strip_tags( $new_instance['effect'] );
		$instance['height'] = intval( $new_instance['height'] );
		$instance['post_type'] = strip_tags( $new_instance['post_type'] );
		$instance['taxonomy'] = strip_tags( $new_instance['taxonomy'] );
		$instance['category'] = intval( $new_instance['category'] );
		$instance['posts'] = strip_tags( $new_instance['posts'] );
		$instance['interval'] = intval( $new_instance['interval'] );
		$instance['titles'] = strip_tags( $new_instance['titles'] );
		$instance['large'] = max(0, min(1, intval( $new_instance['large'] )));
		$instance['controls'] = max(0, min(1, intval( $new_instance['controls'] )));
		$instance['controls_pos'] = strip_tags( $new_instance['controls_pos'] );
		$instance['label_prev'] = strip_tags( $new_instance['label_prev'] );
		$instance['label_next'] = strip_tags( $new_instance['label_next'] );
		$instance['pagination'] = max(0, min(1, intval( $new_instance['pagination'] )));
		$instance['pagination_type'] = strip_tags( $new_instance['pagination_type'] );
		$instance['pagination_pos'] = strip_tags( $new_instance['pagination_pos'] );
		$instance['direction'] = strip_tags( $new_instance['direction'] );
		if (isset($new_instance['alias']))
			$instance['alias'] = strip_tags( $new_instance['alias'] );
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_slider');
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'engine' => 'swiper',
			'slider_style' => 'default',
			'slides_per_view' => '1',
			'slides_space' => '0',
			'slides_ratio' => '16:9',
			'slides_centered' => '0',
			'slides_overflow' => '0',
			'noresize' => '0',
			'mouse_wheel' => '0',
			'noswipe' => '0',
			'autoplay' => '1',
			'effect' => 'slide',
			'height' => '345',
			'alias' => '',
			'titles' => 'center',
			'large' => 0,
			'controls' => 0,
			'controls_pos' => 'side',
			'label_prev' => '',
			'label_next' => '',
			'pagination' => 0,
			'pagination_type' => 'bullets',
			'pagination_pos' => 'bottom',
			'direction' => 'horizontal',
			'post_type' => 'post',
			'taxonomy' => 'category',
			'category' => '0',
			'posts' => '5',
			'interval' => '7000'
			), 'trx_addons_widget_slider')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_slider', $this);

		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_slider', $this);
		
		$this->show_field(array('name' => 'engine',
								'title' => __('Slider engine:', 'trx_addons'),
								'value' => $instance['engine'],
								'options' => trx_addons_get_list_sc_slider_engines(),
								'type' => 'select'));

		if (trx_addons_exists_revslider()) {
			$this->show_field(array('name' => 'alias',
									'title' => __('Revolution Slider alias:', 'trx_addons'),
									'value' => $instance['alias'],
									'options' => trx_addons_get_list_revsliders(),
									'dependency' => array(
										'engine' => array( 'revo' )
									),
									'type' => 'select'));
		}

		$this->show_field(array('name' => 'slider_style',
								'title' => __('Swiper style:', 'trx_addons'),
								'value' => $instance['slider_style'],
								'options' => trx_addons_components_get_allowed_layouts('widgets', 'slider'),
								'dependency' => array(
									'engine' => array( 'swiper' )
								),
								'type' => 'select'));

		$this->show_field(array('name' => 'effect',
								'title' => __('Swiper effect:', 'trx_addons'),
								'value' => $instance['effect'],
								'options' => array(
													'slide' => __('Slide', 'trx_addons'),
													'fade' => __('Fade', 'trx_addons'),
													'cube' => __('Cube', 'trx_addons'),
													'flip' => __('Flip', 'trx_addons'),
													'coverflow' => __('Coverflow', 'trx_addons')
													),
								'dependency' => array(
									'engine' => array( 'swiper' )
								),
								'type' => 'select'));

		$this->show_field(array('name' => 'direction',
								'title' => __('Direction:', 'trx_addons'),
								'value' => $instance['direction'],
								'options' => trx_addons_get_list_sc_directions(),
								'dependency' => array(
									'engine' => array( 'swiper' )
								),
								'type' => 'switch'));

		$this->show_field(array('name' => 'slides_per_view',
								'title' => __('Slides per view in the Swiper:', 'trx_addons'),
								'value' => (int) $instance['slides_per_view'],
								'dependency' => array(
									'engine' => array( 'swiper' )
								),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'slides_space',
								'title' => __('Space between slides in the Swiper:', 'trx_addons'),
								'value' => (int) $instance['slides_space'],
								'dependency' => array(
									'engine' => array( 'swiper' )
								),
								'type' => 'text'));

		// Query parameters
		$this->show_field(array('name' => 'slider_query_info',
								'title' => __('Query params', 'trx_addons'),
								'type' => 'info'));

		$this->show_field(array('name' => 'post_type',
								'title' => __('Post type:', 'trx_addons'),
								'value' => $instance['post_type'],
								'options' => trx_addons_get_list_posts_types(),
								'class' => 'trx_addons_post_type_selector',
								'dependency' => array(
									'engine' => array( 'swiper', 'elastistack' )
								),
								'type' => 'select'));
		
		$this->show_field(array('name' => 'taxonomy',
								'title' => __('Taxonomy:', 'trx_addons'),
								'value' => $instance['taxonomy'],
								'options' => trx_addons_get_list_taxonomies(false, $instance['post_type']),
								'class' => 'trx_addons_taxonomy_selector',
								'type' => 'select'));
		
		$tax_obj = get_taxonomy($instance['taxonomy']);
		$this->show_field(array('name' => 'category',
								'title' => __('Category:', 'trx_addons'),
								'value' => $instance['category'],
								'options' => trx_addons_array_merge(
													array(0=>sprintf(__('- %s -', 'trx_addons'), $tax_obj->label)),
													trx_addons_get_list_terms(false, $instance['taxonomy'], array('pad_counts' => true))
											),
								'class' => 'trx_addons_terms_selector',
								'dependency' => array(
									'engine' => array( 'swiper', 'elastistack' )
								),
								'type' => 'select'));
		
		$this->show_field(array('name' => 'posts',
								'title' => __('Number of posts to show in Swiper:', 'trx_addons'),
								'value' => (int) $instance['posts'],
								'dependency' => array(
									'engine' => array( 'swiper', 'elastistack' )
								),
								'type' => 'text'));

		// Controls
		$this->show_field(array('name' => 'slider_controls_info',
								'title' => __('Controls', 'trx_addons'),
								'type' => 'info'));

		$this->show_field(array('name' => 'controls',
								'title' => __('Show arrows:', 'trx_addons'),
								'value' => (int) $instance['controls'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'dependency' => array(
									'engine' => array( 'swiper', 'elastistack' )
								),
								'type' => 'switch'));

		$this->show_field(array('name' => 'controls_pos',
								'title' => __('Controls position:', 'trx_addons'),
								'value' => $instance['controls_pos'],
								'options' => trx_addons_get_list_sc_slider_controls(''),
								'dependency' => array(
									'engine' => array( 'swiper' ),
									'controls' => array( 1 )
								),
								'type' => 'select'));

		$this->show_field(array('name' => 'label_prev',
								'title' => __('Prev Slide:', 'trx_addons'),
								'description' => wp_kses_data( __("Label of the 'Prev Slide' button in the Swiper (Modern style). Use '|' to break line", 'trx_addons') ),
								'value' => $instance['label_prev'],
								'dependency' => array(
									'slider_style' => array( 'modern' ),
									'controls' => array( 1 )
								),
								'type' => 'text'));

		$this->show_field(array('name' => 'label_next',
								'title' => __('Next Slide:', 'trx_addons'),
								'description' => wp_kses_data( __("Label of the 'Next Slide' button in the Swiper (Modern style). Use '|' to break line", 'trx_addons') ),
								'value' => $instance['label_next'],
								'dependency' => array(
									'slider_style' => array( 'modern' ),
									'controls' => array( 1 )
								),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'pagination',
								'title' => __('Show pagination:', 'trx_addons'),
								'value' => (int) $instance['pagination'],
								'options' => trx_addons_get_list_show_hide(false, true),
								'dependency' => array(
									'engine' => array( 'swiper' ),
								),
								'type' => 'switch'));

		$this->show_field(array('name' => 'pagination_type',
								'title' => __('Pagination type:', 'trx_addons'),
								'value' => $instance['pagination_type'],
								'options' => trx_addons_get_list_sc_slider_paginations_types(),
								'dependency' => array(
									'engine' => array( 'swiper' ),
									'pagination' => array( 1 )
								),
								'type' => 'select'));

		$this->show_field(array('name' => 'pagination_pos',
								'title' => __('Pagination position:', 'trx_addons'),
								'value' => $instance['pagination_pos'],
								'options' => trx_addons_get_list_sc_slider_paginations(''),
								'dependency' => array(
									'engine' => array( 'swiper' ),
									'pagination' => array( 1 )
								),
								'type' => 'select'));

		$this->show_field(array('name' => 'mouse_wheel',
								'title' => '',
								'label' => __('Enable mouse wheel', 'trx_addons'),
								'value' => (int) $instance['mouse_wheel'],
								'dependency' => array(
									'engine' => array( 'swiper' ),
								),
								'type' => 'checkbox'));

		$this->show_field(array('name' => 'noswipe',
								'title' => '',
								'label' => __('Disable swipe', 'trx_addons'),
								'value' => (int) $instance['noswipe'],
								'dependency' => array(
									'engine' => array( 'swiper' ),
								),
								'type' => 'checkbox'));

		$this->show_field(array('name' => 'autoplay',
								'title' => '',
								'label' => __('Enable autoplay', 'trx_addons'),
								'value' => (int) $instance['autoplay'],
								'dependency' => array(
									'engine' => array( 'swiper' ),
								),
								'type' => 'checkbox'));
		
		$this->show_field(array('name' => 'interval',
								'title' => __('Swiper interval (in msec., 1000=1sec.)', 'trx_addons'),
								'value' => (int) $instance['interval'],
								'dependency' => array(
									'engine' => array( 'swiper' ),
								),
								'type' => 'text'));

		// Layout
		$this->show_field(array('name' => 'slider_layout_info',
								'title' => __('Layout', 'trx_addons'),
								'type' => 'info'));

		$this->show_field(array('name' => 'noresize',
								'title' => '',
								'label' => __("No resize slide's content", 'trx_addons'),
								'value' => (int) $instance['noresize'],
								'dependency' => array(
									'engine' => array( 'swiper', 'elastistack' )
								),
								'type' => 'checkbox'));

		$this->show_field(array('name' => 'height',
								'title' => __('Slider height:', 'trx_addons'),
								'value' => $instance['height'],
								'dependency' => array(
									'noresize' => array( 1 )
								),
								'type' => 'text'));

		$this->show_field(array('name' => 'slides_ratio',
								'title' => __('Slides ratio:', 'trx_addons'),
								'value' => $instance['slides_ratio'],
								'dependency' => array(
									'noresize' => array( 0 )
								),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'slides_centered',
								'title' => '',
								'label' => __('Center active slide', 'trx_addons'),
								'value' => (int) $instance['slides_centered'],
								'dependency' => array(
									'engine' => array( 'swiper' )
								),
								'type' => 'checkbox'));
		
		$this->show_field(array('name' => 'slides_overflow',
								'title' => '',
								'label' => __('Slides oveflow visible', 'trx_addons'),
								'value' => (int) $instance['slides_overflow'],
								'dependency' => array(
									'engine' => array( 'swiper' )
								),
								'type' => 'checkbox'));
		
		$this->show_field(array('name' => 'titles',
								'title' => __('Show titles in the Swiper:', 'trx_addons'),
								'value' => $instance['titles'],
								'options' => array(
													'no' => esc_html__('No titles', 'trx_addons'),
													'center' => esc_html__('Center', 'trx_addons'),
													'bottom' => esc_html__('Bottom Center', 'trx_addons'),
													'lb' => esc_html__('Bottom Left', 'trx_addons'),
													'rb' => esc_html__('Bottom Right', 'trx_addons')
													),
								'dependency' => array(
									'engine' => array( 'swiper', 'elastistack' )
								),
								'type' => 'select'));

		$this->show_field(array('name' => 'large',
								'title' => __('Only children of the current category:', 'trx_addons'),
								'value' => (int) $instance['large'],
								'options' => array(
													1 => __('Large', 'trx_addons'),
													0 => __('Small', 'trx_addons')
													),
								'dependency' => array(
									'engine' => array( 'swiper', 'elastistack' )
								),
								'type' => 'switch'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_slider', $this);
	}
}

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_slider_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_slider_load_scripts_front');
	function trx_addons_widget_slider_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			// Attention! Slider's script and styles will be loaded always, because it used not only in this widget, but in the many CPT, SC, etc.
			wp_enqueue_style( 'trx_addons-widget_slider', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider.css'), array(), null );
			wp_enqueue_script( 'trx_addons-widget_slider', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider.js'), array('jquery'), null, true );
		}
	}
}


// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_widget_slider_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_slider_load_responsive_styles', 2000);
	function trx_addons_widget_slider_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-widget_slider-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider.responsive.css'), array(), null );
		}
	}
}

	
// Merge widget's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_slider_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_slider_merge_styles');
	function trx_addons_widget_slider_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider.css';
		return $list;
	}
}


// Merge widget's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_widget_slider_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_widget_slider_merge_styles_responsive');
	function trx_addons_widget_slider_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider.responsive.css';
		return $list;
	}
}

	
// Merge widget's specific scripts into single file
if ( !function_exists( 'trx_addons_widget_slider_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_widget_slider_merge_scripts');
	function trx_addons_widget_slider_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider.js';
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'slider/slider-sc-vc.php';
}
