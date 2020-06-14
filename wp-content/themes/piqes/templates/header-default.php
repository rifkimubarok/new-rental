<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

$piqes_header_css   = '';
$piqes_header_image = get_header_image();
$piqes_header_video = piqes_get_header_video();
if ( ! empty( $piqes_header_image ) && piqes_trx_addons_featured_image_override( is_singular() || piqes_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$piqes_header_image = piqes_get_current_mode_image( $piqes_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $piqes_header_image ) || ! empty( $piqes_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $piqes_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $piqes_header_image ) {
		echo ' ' . esc_attr( piqes_add_inline_css_class( 'background-image: url(' . esc_url( $piqes_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( piqes_is_on( piqes_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight piqes-full-height';
	}
	$piqes_header_scheme = piqes_get_theme_option( 'header_scheme' );
	if ( ! empty( $piqes_header_scheme ) && ! piqes_is_inherit( $piqes_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $piqes_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $piqes_header_video ) ) {
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	if ( piqes_get_theme_option( 'menu_style' ) == 'top' ) {
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/header-navi' ) );
	}

	// Mobile header
	if ( piqes_is_on( piqes_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/header-mobile' ) );
	}

	if ( !is_single() || ( piqes_get_theme_option( 'post_header_position' ) == 'default' && piqes_get_theme_option( 'post_thumbnail_type' ) == 'default' ) ) {
		// Page title and breadcrumbs area
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/header-title' ) );

		// Display featured image in the header on the single posts
		// Comment next line to prevent show featured image in the header area
		// and display it in the post's content
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/header-single' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
