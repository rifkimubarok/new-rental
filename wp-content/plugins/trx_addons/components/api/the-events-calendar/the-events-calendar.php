<?php
/**
 * Plugin support: The Events Calendar
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if Tribe Events installed and activated
if (!function_exists('trx_addons_exists_tribe_events')) {
	function trx_addons_exists_tribe_events() {
		return class_exists( 'Tribe__Events__Main' );
	}
}


// Return true, if current page is any TE page
if ( !function_exists( 'trx_addons_is_tribe_events_page' ) ) {
	function trx_addons_is_tribe_events_page() {
		$is = false;
		if (trx_addons_exists_tribe_events() && !is_search()) 
			$is = tribe_is_event() || tribe_is_event_query() || tribe_is_event_category() || tribe_is_event_venue() || tribe_is_event_organizer();
		return $is;
	}
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_tribe_events_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_tribe_events_load_scripts_front', 11);
	function trx_addons_tribe_events_load_scripts_front() {
		if ( trx_addons_exists_tribe_events() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-tribe_events', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'the-events-calendar/the-events-calendar.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_tribe_events_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_tribe_events_load_responsive_styles', 2000);
	function trx_addons_tribe_events_load_responsive_styles() {
		if ( trx_addons_exists_tribe_events() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-tribe_events-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'the-events-calendar/the-events-calendar.responsive.css'), array(), null );
		}
	}
}


// Merge specific styles into single stylesheet
if ( !function_exists( 'trx_addons_events_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_events_merge_styles');
	function trx_addons_events_merge_styles($list) {
		if (trx_addons_exists_tribe_events())
			$list[] = TRX_ADDONS_PLUGIN_API . 'the-events-calendar/the-events-calendar.css';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_cpt_events_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_cpt_events_merge_styles_responsive');
	function trx_addons_cpt_events_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_API . 'the-events-calendar/the-events-calendar.responsive.css';
		return $list;
	}
}

	
// Add sort in the query for the events
if ( !function_exists( 'trx_addons_events_add_sort_order' ) ) {
	add_filter('trx_addons_filter_add_sort_order',	'trx_addons_events_add_sort_order', 10, 3);
	function trx_addons_events_add_sort_order($q, $orderby, $order='desc') {
		if ($orderby == 'event_date') {
			$q['order'] = $order;
			$q['orderby'] = 'meta_value';
			$q['meta_key'] = '_EventStartDate';
		}
		return $q;
	}
}

// Return taxonomy for current post type (this post_type has 2+ taxonomies)
if ( !function_exists( 'trx_addons_events_post_type_taxonomy' ) ) {
	add_filter( 'trx_addons_filter_post_type_taxonomy',	'trx_addons_events_post_type_taxonomy', 10, 2 );
	function trx_addons_events_post_type_taxonomy($tax='', $post_type='') {
		if (trx_addons_exists_tribe_events() && $post_type == Tribe__Events__Main::POSTTYPE)
			$tax = Tribe__Events__Main::TAXONOMY;
		return $tax;
	}
}

// Return current page title
if ( !function_exists( 'trx_addons_events_get_blog_title' ) ) {
	add_filter( 'trx_addons_filter_get_blog_title', 'trx_addons_events_get_blog_title');
	function trx_addons_events_get_blog_title($title='') {
		if (trx_addons_is_tribe_events_page() ) {
			if (is_archive())
				$title = apply_filters( 'tribe_events_title', tribe_get_events_title( false ) );
			else {
				global $wp_query;
				if (!empty($wp_query->post)) {
					$title = $wp_query->post->post_title;
				}
			}
		}
		return $title;
	}
}
	
// Add Google API key to the map's link
if ( !function_exists( 'trx_addons_events_google_maps_api' ) ) {
	add_filter('tribe_events_google_maps_api',	'trx_addons_events_google_maps_api');
	function trx_addons_events_google_maps_api($url) {
		$api_key = trx_addons_get_option('api_google');
		if ($api_key) {
			$url = trx_addons_add_to_url($url, array(
				'key' => $api_key
			));
		}
		return $url;
	}
}
	
// Repair current post after the Tribe Events spoofing it on priority 100!!!
if ( !function_exists( 'trx_addons_events_repair_spoofed_post' ) ) {
	add_action('wp_head',	'trx_addons_events_repair_spoofed_post', 101);
	function trx_addons_events_repair_spoofed_post() {

		if ( !trx_addons_exists_tribe_events() ) return;

		// hijack this method right up front if it's a password protected post and the password isn't entered
		if ( is_single() && post_password_required() || is_feed() ) {
			return;
		}

		global $wp_query;
		if ( $wp_query->is_main_query() && tribe_is_event_query() && tribe_get_option( 'tribeEventsTemplate', 'default' ) != '' ) {
			if (count($wp_query->posts) > 0) {
				$GLOBALS['post'] = $wp_query->posts[0];
			}
		}
	}
}

// Add hack on page 404 to prevent error message
if ( !function_exists( 'trx_addons_events_create_empty_post_on_404' ) ) {
	add_action( 'wp_head', 'trx_addons_events_create_empty_post_on_404', 1);
	function trx_addons_events_create_empty_post_on_404() {
		if ( trx_addons_exists_tribe_events() && is_404() && !isset($GLOBALS['post']) ) {
			$GLOBALS['post'] = new stdClass();
			$GLOBALS['post']->post_type = 'unknown';
			$GLOBALS['post']->post_content = '';
		}
	}
}

// Replace post date with event's date for RevSlider
if ( !function_exists( 'trx_addons_events_revslider_date' ) ) {
	add_filter('revslider_slide_setLayersByPostData_post', 'trx_addons_events_revslider_date', 10, 4);
	function trx_addons_events_revslider_date($attr, $postData, $sliderID, $sliderObj) {
		if ( trx_addons_exists_tribe_events() && !empty($postData['ID']) && !empty($postData['post_type']) && $postData['post_type'] == Tribe__Events__Main::POSTTYPE) {
	        $attr['date_start'] = tribe_get_start_date($postData['ID'], true, get_option('date_format'));
	        $attr['date_end'] = tribe_get_end_date($postData['ID'], true, get_option('date_format'));
	        $attr['date'] = $attr['postDate'] = $attr['date_start'] . ' - ' . $attr['date_end'];
	    }
	    return $attr;
	}
}


// Add shortcodes
//----------------------------------------------------------------------------

require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'the-events-calendar/the-events-calendar-sc.php';

// Add shortcodes to Elementor
if ( trx_addons_exists_tribe_events() && trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'the-events-calendar/the-events-calendar-sc-elementor.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_tribe_events() && trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'the-events-calendar/the-events-calendar-sc-vc.php';
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'the-events-calendar/the-events-calendar-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_tribe_events() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'the-events-calendar/the-events-calendar-demo-ocdi.php';
}
