<?php
/**
 * Plugin support: BBPress and BuddyPress
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if BBPress and BuddyPress is installed and activated
if ( !function_exists( 'trx_addons_exists_bbpress' ) ) {
	function trx_addons_exists_bbpress() {
		return class_exists( 'BuddyPress' ) || class_exists( 'bbPress' );
	}
}

// Return true, if current page is any bbpress page
if ( !function_exists( 'trx_addons_is_bbpress_page' ) ) {
	function trx_addons_is_bbpress_page() {
		$rez = false;
		if (trx_addons_exists_bbpress()) {
			if (!is_search()) {
				$rez = (function_exists('is_buddypress') && is_buddypress()) 
					|| (function_exists('is_bbpress') && is_bbpress())
					|| (!is_user_logged_in() && in_array(get_query_var('post_type'), array('forum', 'topic', 'reply')));
			}
		}
		return $rez;
	}
}

// Return link to the main bbpress page for the breadcrumbs
if ( !function_exists( 'trx_addons_bbpress_get_blog_all_posts_link' ) ) {
	add_filter('trx_addons_filter_get_blog_all_posts_link', 'trx_addons_bbpress_get_blog_all_posts_link', 10, 2);
	function trx_addons_bbpress_get_blog_all_posts_link($link='', $args=array()) {
		if ($link=='' && trx_addons_is_bbpress_page() && function_exists('bbp_get_forum_post_type')) {
			// Page exists at root slug path, so use its permalink
			$page = bbp_get_page_by_path( bbp_get_root_slug() );
			$pt = bbp_get_forum_post_type();
			$obj = get_post_type_object($pt);
			if (($url = !empty( $page ) ? get_permalink( $page->ID ) : get_post_type_archive_link($pt)) !='')
				$link = '<a href="'.esc_url($url).'">' . esc_html($obj->labels->all_items) . '</a>';
		}
		return $link;
	}
}


// Remove taxonomy 'topic_tag' from breadcrumbs
if ( !function_exists( 'trx_addons_bbpress_post_type_taxonomy' ) ) {
	add_filter( 'trx_addons_filter_post_type_taxonomy',	'trx_addons_bbpress_post_type_taxonomy', 10, 2 );
	function trx_addons_bbpress_post_type_taxonomy($tax='', $post_type='') {
		if (trx_addons_exists_bbpress() 
			&& function_exists('bbp_get_topic_post_type')
			&& $post_type == bbp_get_topic_post_type()
			&& $tax == bbp_get_topic_tag_tax_id())
			$tax = '';
		return $tax;
	}
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'bbpress/bbpress-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_bbpress() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'bbpress/bbpress-demo-ocdi.php';
}
