<?php
/**
 * Widget: About Me
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
if (!function_exists('trx_addons_widget_aboutme_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_aboutme_load' );
	function trx_addons_widget_aboutme_load() {
		register_widget('trx_addons_widget_aboutme');
	}
}

// Widget Class
class trx_addons_widget_aboutme extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_aboutme',
							'description' => esc_html__('About me - photo and short description about the blog author', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_aboutme', esc_html__('ThemeREX About Me', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		
		$username = isset($instance['username']) ? $instance['username'] : '';
		$description = isset($instance['description']) ? $instance['description'] : '';
		$avatar = isset($instance['avatar']) ? $instance['avatar'] : '';
		$gravatar = empty($avatar);

		$blogusers = get_users( 'role=administrator' );
		if (count($blogusers) > 0) {
			if (empty($username) && empty($description))
				$description = $blogusers[0]->description;
			if (empty($username))
				$username = $blogusers[0]->display_name;
			if (empty($avatar)) {
				$mult = trx_addons_get_retina_multiplier();
				$avatar = get_avatar( $blogusers[0]->user_email, 220*$mult );
			}
		}
		if (!$gravatar && !empty($avatar)) {
			$avatar = trx_addons_get_attachment_url($avatar, trx_addons_get_thumb_size('masonry'));
			if (!empty($avatar)) {
				$attr = trx_addons_getimagesize($avatar);
				$avatar = '<img src="'.esc_url($avatar).'" alt="'.esc_attr($username).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
			}
		}

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'aboutme/tpl.default.php',
									'trx_addons_args_widget_aboutme',
									apply_filters('trx_addons_filter_widget_args',
												array_merge($args, compact('title', 'avatar', 'username', 'description')),
												$instance, 'trx_addons_widget_aboutme')
									);
	}

	// Update the widget settings.
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['avatar'] = strip_tags($new_instance['avatar']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['description'] = strip_tags($new_instance['description']);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_aboutme');
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'avatar' => '',
			'username' => '',
			'description' => ''
			), 'trx_addons_widget_aboutme')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_aboutme', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_aboutme', $this);

		$this->show_field(array('name' => 'avatar',
								'title' => __('Avatar (if empty - get gravatar by admin email):', 'trx_addons'),
								'value' => $instance['avatar'],
								'type' => 'image'));

		$this->show_field(array('name' => 'username',
								'title' => __('User name (if equal to # - not show):', 'trx_addons'),
								'value' => $instance['username'],
								'type' => 'text'));

		$this->show_field(array('name' => 'description',
								'title' => __('Short description about user (if equal to # - not show):', 'trx_addons'),
								'value' => $instance['description'],
								'type' => 'textarea'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_aboutme', $this);
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_widget_aboutme_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_aboutme_load_scripts_front');
	function trx_addons_widget_aboutme_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-widget_aboutme', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'aboutme/aboutme.css'), array(), null );
		}
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_aboutme_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_aboutme_merge_styles');
	function trx_addons_widget_aboutme_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'aboutme/aboutme.css';
		return $list;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'aboutme/aboutme-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'aboutme/aboutme-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'aboutme/aboutme-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_WIDGETS . 'aboutme/aboutme-sc-vc.php';
}
