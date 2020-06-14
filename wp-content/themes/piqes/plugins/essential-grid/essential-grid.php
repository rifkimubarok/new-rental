<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'piqes_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'piqes_essential_grid_theme_setup9', 9 );
	function piqes_essential_grid_theme_setup9() {
		if ( piqes_exists_essential_grid() ) {
			add_action( 'wp_enqueue_scripts', 'piqes_essential_grid_frontend_scripts', 1100 );
			add_filter( 'piqes_filter_merge_styles', 'piqes_essential_grid_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'piqes_filter_tgmpa_required_plugins', 'piqes_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'piqes_essential_grid_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('piqes_filter_tgmpa_required_plugins',	'piqes_essential_grid_tgmpa_required_plugins');
	function piqes_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( piqes_storage_isset( 'required_plugins', 'essential-grid' ) && piqes_storage_get_array( 'required_plugins', 'essential-grid', 'install' ) !== false && piqes_is_theme_activated() ) {
			$path = piqes_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || piqes_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => piqes_storage_get_array( 'required_plugins', 'essential-grid', 'title' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'version'  => '2.2.4.2',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'piqes_exists_essential_grid' ) ) {
	function piqes_exists_essential_grid() {
		return defined( 'EG_PLUGIN_PATH' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'piqes_essential_grid_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'piqes_essential_grid_frontend_scripts', 1100 );
	function piqes_essential_grid_frontend_scripts() {
		if ( piqes_is_on( piqes_get_theme_option( 'debug_mode' ) ) ) {
			$piqes_url = piqes_get_file_url( 'plugins/essential-grid/essential-grid.css' );
			if ( '' != $piqes_url ) {
				wp_enqueue_style( 'piqes-essential-grid', $piqes_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'piqes_essential_grid_merge_styles' ) ) {
	//Handler of the add_filter('piqes_filter_merge_styles', 'piqes_essential_grid_merge_styles');
	function piqes_essential_grid_merge_styles( $list ) {
		$list[] = 'plugins/essential-grid/essential-grid.css';
		return $list;
	}
}

