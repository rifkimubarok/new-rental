<?php
/**
 * The Front Page template file.
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( piqes_is_on( piqes_get_theme_option( 'front_page_enabled' ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$piqes_sections = piqes_array_get_keys_by_value( piqes_get_theme_option( 'front_page_sections' ), 1, false );
		if ( is_array( $piqes_sections ) ) {
			foreach ( $piqes_sections as $piqes_section ) {
				get_template_part( apply_filters( 'piqes_filter_get_template_part', 'front-page/section', $piqes_section ), $piqes_section );
			}
		}

		// Else if this page is blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'blog' ) );

		// Else - display native page content
	} else {
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'page' ) );
	}

	// Else get index template to show posts
} else {
	get_template_part( apply_filters( 'piqes_filter_get_template_part', 'index' ) );
}

get_footer();
