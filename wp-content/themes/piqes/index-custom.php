<?php
/**
 * The template for homepage posts with custom style
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.50
 */

piqes_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	$piqes_blog_style = piqes_get_theme_option( 'blog_style' );
	$piqes_parts      = explode( '_', $piqes_blog_style );
	$piqes_columns    = ! empty( $piqes_parts[1] ) ? max( 1, min( 6, (int) $piqes_parts[1] ) ) : 1;
	$piqes_blog_id    = piqes_get_custom_blog_id( $piqes_blog_style );
	$piqes_blog_meta  = piqes_get_custom_layout_meta( $piqes_blog_id );
	if ( ! empty( $piqes_blog_meta['margin'] ) ) {
		piqes_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( piqes_prepare_css_value( $piqes_blog_meta['margin'] ) ) ) );
	}
	$piqes_custom_style = ! empty( $piqes_blog_meta['scripts_required'] ) ? $piqes_blog_meta['scripts_required'] : 'none';

	piqes_blog_archive_start();

	$piqes_classes    = 'posts_container blog_custom_wrap' 
							. ( ! piqes_is_off( $piqes_custom_style )
								? sprintf( ' %s_wrap', $piqes_custom_style )
								: ( $piqes_columns > 1 
									? ' columns_wrap columns_padding_bottom' 
									: ''
									)
								);
	$piqes_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$piqes_sticky_out = piqes_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $piqes_stickies ) && count( $piqes_stickies ) > 0 && get_query_var( 'paged' ) < 1;
	if ( $piqes_sticky_out ) {
		?>
		<div class="sticky_wrap columns_wrap">
		<?php
	}
	if ( ! $piqes_sticky_out ) {
		if ( piqes_get_theme_option( 'first_post_large' ) && ! is_paged() && ! in_array( piqes_get_theme_option( 'body_style' ), array( 'fullwide', 'fullscreen' ) ) ) {
			the_post();
			get_template_part( apply_filters( 'piqes_filter_get_template_part', 'content', 'excerpt' ), 'excerpt' );
		}
		?>
		<div class="<?php echo esc_attr( $piqes_classes ); ?>">
		<?php
	}
	while ( have_posts() ) {
		the_post();
		if ( $piqes_sticky_out && ! is_sticky() ) {
			$piqes_sticky_out = false;
			?>
			</div><div class="<?php echo esc_attr( $piqes_classes ); ?>">
			<?php
		}
		$piqes_part = $piqes_sticky_out && is_sticky() ? 'sticky' : 'custom';
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'content', $piqes_part ), $piqes_part );
	}
	?>
	</div>
	<?php

	piqes_show_pagination();

	piqes_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
