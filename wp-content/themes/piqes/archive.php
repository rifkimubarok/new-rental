<?php
/**
 * The template file to display taxonomies archive
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.57
 */

// Redirect to the template page (if exists) for output current taxonomy
if ( is_category() || is_tag() || is_tax() ) {
	$piqes_term = get_queried_object();
	global $wp_query;
	if ( ! empty( $piqes_term->taxonomy ) && ! empty( $wp_query->posts[0]->post_type ) ) {
		$piqes_taxonomy  = piqes_get_post_type_taxonomy( $wp_query->posts[0]->post_type );
		if ( $piqes_taxonomy == $piqes_term->taxonomy ) {
			$piqes_template_page_id = piqes_get_template_page_id( array(
				'post_type'  => $wp_query->posts[0]->post_type,
				'parent_cat' => $piqes_term->term_id
			) );
			if ( 0 < $piqes_template_page_id ) {
				wp_safe_redirect( get_permalink( $piqes_template_page_id ) );
				exit;
			}
		}
	}
}
// If template page is not exists - display default blog archive template
get_template_part( apply_filters( 'piqes_filter_get_template_part', piqes_blog_archive_get_template() ) );
