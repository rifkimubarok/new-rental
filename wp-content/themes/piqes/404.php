<?php
/**
 * The template to display the 404 page
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

get_header();

get_template_part( apply_filters( 'piqes_filter_get_template_part', 'content', '404' ), '404' );

get_footer();
