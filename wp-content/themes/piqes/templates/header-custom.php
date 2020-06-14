<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.06
 */

$piqes_header_css   = '';
$piqes_header_image = get_header_image();
$piqes_header_video = piqes_get_header_video();
if ( ! empty( $piqes_header_image ) && piqes_trx_addons_featured_image_override( is_singular() || piqes_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$piqes_header_image = piqes_get_current_mode_image( $piqes_header_image );
}

$piqes_header_id = piqes_get_custom_header_id();
$piqes_header_meta = get_post_meta( $piqes_header_id, 'trx_addons_options', true );
if ( ! empty( $piqes_header_meta['margin'] ) ) {
	piqes_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( piqes_prepare_css_value( $piqes_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $piqes_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $piqes_header_id ) ) ); ?>
				<?php
				echo ! empty( $piqes_header_image ) || ! empty( $piqes_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
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

	// Custom header's layout
	do_action( 'piqes_action_show_layout', $piqes_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
