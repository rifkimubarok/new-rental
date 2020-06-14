<?php
/**
 * Widget: WooCommerce Search (Advanced search form)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

if (!defined('TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS')) define('TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS', 5);

// Load widget
if (!function_exists('trx_addons_widget_woocommerce_search_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_woocommerce_search_load' );
	function trx_addons_widget_woocommerce_search_load() {
		if (!trx_addons_exists_woocommerce()) return;
		register_widget('trx_addons_widget_woocommerce_search');
	}
}

// Widget Class
class trx_addons_widget_woocommerce_search extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_woocommerce_search', 'description' => esc_html__('Advanced search form for products', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_woocommerce_search', esc_html__('ThemeREX WooCommerce Search', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		$type = isset($instance['type']) ? $instance['type'] : 'inline';
		
		// Hide widget on the single product, cart, checkout and user's account pages
		if ( apply_filters( 'trx_addons_filter_woocommerce_search',
				(is_product() || is_cart() || is_checkout() || is_account_page()) 
				&& 
				$type=='inline'
				) ) return;

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		if (!isset($instance['fields'])) {
			$fields = array();
			for ($i=1; $i<=TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS; $i++) {
				$fields[] = array(
					'text' => isset($instance["field{$i}_text"]) ? $instance["field{$i}_text"] : '',
					'filter' => isset($instance["field{$i}_filter"]) ? $instance["field{$i}_filter"] : ''
				);
			}
		} else
			$fields = $instance['fields'];
		$last_text = isset($instance['last_text']) ? $instance['last_text'] : '';
		$button_text = !empty($instance['button_text']) ? $instance['button_text'] : __('Filter now', 'trx_addons');

		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_API . 'woocommerce/tpl.widget.woocommerce_search_type_'.trx_addons_esc($type).'.php',
										TRX_ADDONS_PLUGIN_API . 'woocommerce/tpl.widget.woocommerce_search_type_form.php'
										),
									'trx_addons_args_widget_woocommerce_search',
									apply_filters('trx_addons_filter_widget_args',
										array_merge($args, compact('title', 'type', 'fields', 'last_text', 'button_text')),
										$instance, 'trx_addons_widget_woocommerce_search'
										)
								);
	}

	// Update the widget settings.
	function update($new_instance, $instance) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['type'] = strip_tags($new_instance['type']);
		for ($i=1; $i<=TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS; $i++) {
			$instance["field{$i}_text"] = strip_tags($new_instance["field{$i}_text"]);
			$instance["field{$i}_filter"] = strip_tags($new_instance["field{$i}_filter"]);
		}
		$instance["last_text"] = strip_tags($new_instance["last_text"]);
		$instance["button_text"] = strip_tags($new_instance["button_text"]);
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_woocommerce_search');
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$default = array(
			'title' => '',
			'type' => 'inline',
			'last_text' => '',
			'button_text' => ''
		);
		for ($i=1; $i<=TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS; $i++) {
			$default["field{$i}_text"] = '';
			$default["field{$i}_filter"] = '';
		}
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', $default, 'trx_addons_widget_woocommerce_search')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_woocommerce_search', $this);
		
		$this->show_field(array('name' => 'title',
								'title' => __('Widget title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_woocommerce_search', $this);

		$this->show_field(array('name' => "type",
								'title' => __('Type:', 'trx_addons'),
								'value' => $instance["type"],
								'options' => trx_addons_get_list_woocommerce_search_types(),
								'type' => 'select'));

		for ($i=1; $i<=TRX_ADDONS_WOOCOMMERCE_SEARCH_FIELDS; $i++) {
			$this->show_field(array('name' => "field{$i}_text",
									'title' => sprintf(__('Field %d text:', 'trx_addons'), $i),
									'value' => $instance["field{$i}_text"],
									'type' => 'text'));
			$this->show_field(array('name' => "field{$i}_filter",
									'title' => sprintf(__('Field %d filter:', 'trx_addons'), $i),
									'value' => $instance["field{$i}_filter"],
									'options' => trx_addons_get_list_woocommerce_search_filters(),
									'type' => 'select'));
		}

		$this->show_field(array('name' => "last_text",
								'title' => __('Last text:', 'trx_addons'),
								'value' => $instance["last_text"],
								'type' => 'text'));

		$this->show_field(array('name' => "button_text",
								'title' => __('Button text:', 'trx_addons'),
								'value' => $instance["button_text"],
								'type' => 'text'));

		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_woocommerce_search', $this);
	}
}
	

// Load required styles and scripts in the frontend
if ( !function_exists( 'trx_addons_widget_woocommerce_search_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_widget_woocommerce_search_load_scripts_front');
	function trx_addons_widget_woocommerce_search_load_scripts_front() {
	}
}


// Parse query params from GET/POST and wp_query_parameters
if ( !function_exists( 'trx_addons_widget_woocommerce_search_query_params' ) ) {
	function trx_addons_widget_woocommerce_search_query_params($fields) {
		$params = array();
		$q_obj = get_queried_object();
		foreach ($fields as $fld) {
			if (trx_addons_is_off($fld['filter'])) continue;
			$tax_name = $fld['filter'];
			if ( is_tax($tax_name))
				$params[$tax_name] = $q_obj->slug;
			else if ( ($value = trx_addons_get_value_gp($tax_name)) != '')
				$params[$tax_name] = sanitize_text_field($value);
			else
				$params[$tax_name] = '';
		}
		return $params;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------

require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'woocommerce/widget.woocommerce_search-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_woocommerce() && trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'woocommerce/widget.woocommerce_search-sc-elementor.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_woocommerce() && trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'woocommerce/widget.woocommerce_search-sc-vc.php';
}
