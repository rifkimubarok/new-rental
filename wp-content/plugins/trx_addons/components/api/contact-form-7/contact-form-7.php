<?php
/**
 * Plugin support: Contact Form 7
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Check if Contact Form 7 installed and activated
if ( !function_exists( 'trx_addons_exists_cf7' ) ) {
	function trx_addons_exists_cf7() {
		return class_exists('WPCF7') && class_exists('WPCF7_ContactForm');
	}
}

// Return forms list, prepended inherit (if need)
if ( !function_exists( 'trx_addons_get_list_cf7' ) ) {
	function trx_addons_get_list_cf7($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			if (trx_addons_exists_cf7()) {
				// Attention! Using WP_Query is damage 'post_type' in the main query
				global $wpdb;
				$rows = $wpdb->get_results( 'SELECT id, post_title'
												. ' FROM ' . esc_sql($wpdb->prefix . 'posts') 
												. ' WHERE post_type="' . esc_sql(WPCF7_ContactForm::post_type) . '"'
														. ' AND post_status' . (current_user_can('read_private_pages') && current_user_can('read_private_posts') ? ' IN ("publish", "private")' : '="publish"')
														. ' AND post_password=""'
												. ' ORDER BY post_title' );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->id] = $row->post_title;
					}
				}
			}
		}
		return $prepend_inherit ? trx_addons_array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) : $list;
	}
}



// Filter 'wpcf7_mail_components' before Contact Form 7 send mail
// to replace recipient for 'Cars' and 'Properties'
// Also customer can use the '{{ title }}' in the 'Subject' and 'Message'
// to replace it with the post title when send a mail
if ( !function_exists( 'trx_addons_cpt_properties_wpcf7_mail_components' ) ) {
	add_filter('wpcf7_mail_components',	'trx_addons_cpt_properties_wpcf7_mail_components', 10, 3);
	function trx_addons_cpt_properties_wpcf7_mail_components($components, $form, $mail_obj=null) {
		if (is_object($form) && method_exists($form, 'id') && (int)$form->id() > 0 ) {
			$data = get_transient(sprintf('trx_addons_cf7_%d_data', (int) $form->id()));
			if (!empty($data['agent'])) {
				$agent_id = (int) $data['agent'];
				$agent_email = '';
				if ($agent_id > 0) {			// Agent
					$meta = get_post_meta($agent_id, 'trx_addons_options', true);
					$agent_email = $meta['email'];
				} else if ($agent_id < 0) {		// Author
					$user_id = abs($agent_id);
					$user_data = get_userdata($user_id);
					$agent_email = $user_data->user_email;
				}
				if (!empty($agent_email)) $components['recipient'] = $agent_email;
			}
			if (!empty($data['item']) && (int) $data['item'] > 0) {
				$post = get_post($data['item']);
				foreach(array('subject', 'body') as $k) {
					$components[$k] = str_replace(
													array(
														'{{ title }}'
													),
													array(
														$post->post_title
													),
													$components[$k]
												);
				}
			}
		}
		return $components;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_cf7() && trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'contact-form-7/contact-form-7-sc-elementor.php';
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'contact-form-7/contact-form-7-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_cf7() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'contact-form-7/contact-form-7-demo-ocdi.php';
}
