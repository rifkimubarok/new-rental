<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'piqes_wpml_get_css' ) ) {
	add_filter( 'piqes_filter_get_css', 'piqes_wpml_get_css', 10, 2 );
	function piqes_wpml_get_css( $css, $args ) {
		return $css;
	}
}

