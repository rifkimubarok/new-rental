<?php
/**
 * Widget: Twitter
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
if (!function_exists('trx_addons_widget_twitter_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_twitter_load' );
	function trx_addons_widget_twitter_load() {
		register_widget('trx_addons_widget_twitter');
	}
}

// Widget Class
class trx_addons_widget_twitter extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_twitter', 'description' => esc_html__('Last Twitter Updates. Version for new Twitter API 1.1', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_twitter', esc_html__('ThemeREX Twitter', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {

		if (empty($instance['twitter_username']) || empty($instance['twitter_consumer_key']) || empty($instance['twitter_consumer_secret']) || empty($instance['twitter_token_key']) || empty($instance['twitter_token_secret'])) return;

		$data = trx_addons_get_twitter_data(array(
			'mode'            => 'user_timeline',
			'consumer_key'    => $instance['twitter_consumer_key'],
			'consumer_secret' => $instance['twitter_consumer_secret'],
			'token'           => $instance['twitter_token_key'],
			'secret'          => $instance['twitter_token_secret']
			)
		);
		
		if (!$data || !isset($data[0]['text'])) return;
		$instance['data'] = $data;

		extract( $args );

		/* Our variables from the widget settings. */
		$layout = $instance['type'] = isset($instance['type']) ? $instance['type'] : 'list';
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$bg_image = isset($instance['bg_image']) ? $instance['bg_image'] : '';
		
		// Before widget (defined by themes)
		if (!empty($bg_image)) {
			$bg_image = trx_addons_get_attachment_url($bg_image, trx_addons_get_thumb_size('avatar'));
			if (!empty($bg_image)) {
				$before_widget = str_replace(
					'class="widget ',
					'style="background-image:url('.esc_url($bg_image).');"'
						.' class="widget widget_bg_image ',
					$before_widget
				);
			}
		}

		// Before widget (defined by themes)
		trx_addons_show_layout($before_widget);
			
		// Display the widget title if one was input (before and after defined by themes)
		trx_addons_show_layout($title, $before_title, $after_title);

		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/tpl.'.trx_addons_esc($layout).'.php',
										TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/tpl.default.php'
										),
										'trx_addons_args_widget_twitter', 
										apply_filters('trx_addons_filter_widget_args',
											$instance,
											$instance, 'trx_addons_widget_twitter')
									);
			
		// After widget (defined by themes). */
		trx_addons_show_layout($after_widget);
	}

	// Update the widget settings.
	function update( $new_instance, $instance ) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['bg_image'] = strip_tags( $new_instance['bg_image'] );
		$instance['twitter_username'] = strip_tags( $new_instance['twitter_username'] );
		$instance['twitter_consumer_key'] = strip_tags( $new_instance['twitter_consumer_key'] );
		$instance['twitter_consumer_secret'] = strip_tags( $new_instance['twitter_consumer_secret'] );
		$instance['twitter_token_key'] = strip_tags( $new_instance['twitter_token_key'] );
		$instance['twitter_token_secret'] = strip_tags( $new_instance['twitter_token_secret'] );
		$instance['twitter_count'] = max( 1, (int) $new_instance['twitter_count'] );
		$instance['follow'] = isset( $new_instance['follow'] ) ? 1 : 0;
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_twitter');
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'bg_image' => '',
			'twitter_username' => '',
			'twitter_consumer_key' => '',
			'twitter_consumer_secret' => '',
			'twitter_token_key' => '',
			'twitter_token_secret' => '',
			'twitter_count' => 2,
			'follow' => 1
			), 'trx_addons_widget_twitter')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_twitter', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_twitter', $this);
		
		$this->show_field(array('name' => 'twitter_count',
								'title' => __('Tweets number:', 'trx_addons'),
								'value' => max(1, (int) $instance['twitter_count']),
								'type' => 'text'));
		
		$this->show_field(array('name' => 'twitter_username',
								'title' => __('Username in Twitter:', 'trx_addons'),
								'value' => $instance['twitter_username'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'twitter_consumer_key',
								'title' => __('Consumer Key:', 'trx_addons'),
								'value' => $instance['twitter_consumer_key'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'twitter_consumer_secret',
								'title' => __('Consumer Secret:', 'trx_addons'),
								'value' => $instance['twitter_consumer_secret'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'twitter_token_key',
								'title' => __('Token Key:', 'trx_addons'),
								'value' => $instance['twitter_token_key'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'twitter_token_secret',
								'title' => __('Token Secret:', 'trx_addons'),
								'value' => $instance['twitter_token_secret'],
								'type' => 'text'));

		$this->show_field(array('name' => 'follow',
								'title' => '',
								'label' => __('Show "Follow us"', 'trx_addons'),
								'value' => (int) $instance['follow'],
								'type' => 'checkbox'));

		$this->show_field(array('name' => 'bg_image',
								'title' => __('Background image:', 'trx_addons'),
								'value' => $instance['bg_image'],
								'type' => 'image'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_twitter', $this);
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_twitter_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_twitter_load_scripts_front');
	function trx_addons_widget_twitter_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-widget_twitter', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/twitter.css'), array(), null );
		}
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_twitter_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_twitter_merge_styles');
	function trx_addons_widget_twitter_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/twitter.css';
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/twitter-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/twitter-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/twitter-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'twitter/twitter-sc-vc.php';
}
