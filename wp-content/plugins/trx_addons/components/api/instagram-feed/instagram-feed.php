<?php
/**
 * Plugin support: Instagram Feed
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'trx_addons_exists_instagram_feed' ) ) {
	function trx_addons_exists_instagram_feed() {
		return defined('SBIVER');
	}
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'instagram-feed/instagram-feed-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_instagram_feed() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'instagram-feed/instagram-feed-demo-ocdi.php';
}
