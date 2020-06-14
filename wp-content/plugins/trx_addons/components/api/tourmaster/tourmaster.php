<?php
/**
 * Plugin support: Tour Master
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

if (!defined('TRX_ADDONS_TOURMASTER_CPT_TOUR'))			define('TRX_ADDONS_TOURMASTER_CPT_TOUR', 			'tour');
if (!defined('TRX_ADDONS_TOURMASTER_CPT_TOUR_COUPON'))	define('TRX_ADDONS_TOURMASTER_CPT_TOUR_COUPON',		'tour_coupon');
if (!defined('TRX_ADDONS_TOURMASTER_CPT_TOUR_SERVICE'))	define('TRX_ADDONS_TOURMASTER_CPT_TOUR_SERVICE',	'tour_service');
if (!defined('TRX_ADDONS_TOURMASTER_TAX_TOUR_CATEGORY'))define('TRX_ADDONS_TOURMASTER_TAX_TOUR_CATEGORY',	'tour_category');
if (!defined('TRX_ADDONS_TOURMASTER_TAX_TOUR_TAG'))		define('TRX_ADDONS_TOURMASTER_TAX_TOUR_TAG',		'tour_tag');

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_tourmaster' ) ) {
	function trx_addons_exists_tourmaster() {
		return defined( 'TOURMASTER_LOCAL' );
	}
}

// Return true, if current page is any tourmaster page
if ( !function_exists( 'trx_addons_is_tourmaster_page' ) ) {
	function trx_addons_is_tourmaster_page() {
		$rez = false;
		if (trx_addons_exists_tourmaster()) {
			$rez = (is_single() && in_array(get_query_var('post_type'),
												array(TRX_ADDONS_TOURMASTER_CPT_TOUR,
													TRX_ADDONS_TOURMASTER_CPT_TOUR_COUPON,
													TRX_ADDONS_TOURMASTER_CPT_TOUR_SERVICE)))
					|| (is_home() && isset($_GET['tour-search']))
					|| (is_home() && isset($_GET['tourmaster-payment']))
					|| is_post_type_archive(TRX_ADDONS_TOURMASTER_CPT_TOUR) 
					|| is_post_type_archive(TRX_ADDONS_TOURMASTER_CPT_TOUR_COUPON) 
					|| is_post_type_archive(TRX_ADDONS_TOURMASTER_CPT_TOUR_SERVICE) 
					|| is_tax(TRX_ADDONS_TOURMASTER_TAX_TOUR_CATEGORY)
					|| is_tax(TRX_ADDONS_TOURMASTER_TAX_TOUR_TAG);
		}
		return $rez;
	}
}


// Return taxonomy for current post type (this post_type have 2+ taxonomies)
if ( !function_exists( 'trx_addons_tourmaster_post_type_taxonomy' ) ) {
	add_filter( 'trx_addons_filter_post_type_taxonomy',	'trx_addons_tourmaster_post_type_taxonomy', 10, 2 );
	function trx_addons_tourmaster_post_type_taxonomy($tax='', $post_type='') {
		if ($post_type == TRX_ADDONS_TOURMASTER_CPT_TOUR)
			$tax = TRX_ADDONS_TOURMASTER_TAX_TOUR_CATEGORY;
		return $tax;
	}
}

// Return link to main hotels page for the breadcrumbs
if ( !function_exists( 'trx_addons_tourmaster_get_blog_all_posts_link' ) ) {
	add_filter('trx_addons_filter_get_blog_all_posts_link', 'trx_addons_tourmaster_get_blog_all_posts_link', 10, 2);
	function trx_addons_tourmaster_get_blog_all_posts_link($link='', $args=array()) {
		if (empty($link) && trx_addons_is_tourmaster_page()) {
			if (($url = trx_addons_tourmaster_get_tours_page_link()) != '') {
				$id = trx_addons_tourmaster_get_tours_page_id();
				$title = $id ? get_the_title($id) : __('Tours', 'trx_addons');
				$link = '<a href="'.esc_url($url).'">'. esc_html($title).'</a>';
			}
		}
		return $link;
	}
}

// Return tours page ID
if ( !function_exists( 'trx_addons_tourmaster_get_tours_page_id' ) ) {
	function trx_addons_tourmaster_get_tours_page_id() {
		return apply_filters('trx_addons_filter_get_all_posts_page_id', 0, 'tourmaster');
	}
}

// Return hotels page link
if ( !function_exists( 'trx_addons_tourmaster_get_tours_page_link' ) ) {
	function trx_addons_tourmaster_get_tours_page_link() {
		$id = trx_addons_tourmaster_get_tours_page_id();
		return $id > 0 ? get_permalink($id) : get_post_type_archive_link(TRX_ADDONS_TOURMASTER_CPT_TOUR);
	}
}

// Return current page title
if ( !function_exists( 'trx_addons_tourmaster_get_blog_title' ) ) {
	add_filter( 'trx_addons_filter_get_blog_title', 'trx_addons_tourmaster_get_blog_title');
	function trx_addons_tourmaster_get_blog_title($title='') {
		if (trx_addons_exists_tourmaster()) {
			if (is_post_type_archive(TRX_ADDONS_TOURMASTER_CPT_TOUR) || is_post_type_archive(TRX_ADDONS_TOURMASTER_CPT_TOUR_SERVICE)) {
				$id = trx_addons_tourmaster_get_tours_page_id();
				$title = $id ? get_the_title($id) : __('Tours', 'trx_addons');
			} else if (is_home() && isset($_GET['tour-search']))
				$title = __('Tour search', 'trx_addons');
			else if (is_home() && isset($_GET['tourmaster-payment']))
				$title = __('Tour payment', 'trx_addons');
		}
		return $title;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_tourmaster() && trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'tourmaster/tourmaster-sc-elementor.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_tourmaster() && trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'tourmaster/tourmaster-sc-vc.php';
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'tourmaster/tourmaster-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_tourmaster() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'tourmaster/tourmaster-demo-ocdi.php';
}
