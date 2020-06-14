<?php
/**
 * Plugin support: Revolution Slider (Gutenberg support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Add shortcode's specific lists to the JS storage
if ( ! function_exists( 'trx_addons_revslider_gutenberg_sc_params' ) ) {
	add_filter( 'trx_addons_filter_gutenberg_sc_params', 'trx_addons_revslider_gutenberg_sc_params' );
	function trx_addons_revslider_gutenberg_sc_params( $vars = array() ) {

		// If editor is active now
		$is_edit_mode = trx_addons_is_post_edit();

		$vars['list_revsliders'] = !$is_edit_mode ? array() : trx_addons_get_list_revsliders();

		return $vars;
	}
}
