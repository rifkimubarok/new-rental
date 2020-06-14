<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

$piqes_template_args = get_query_var( 'piqes_template_args' );
if ( is_array( $piqes_template_args ) ) {
	$piqes_columns    = empty( $piqes_template_args['columns'] ) ? 1 : max( 1, min( 3, $piqes_template_args['columns'] ) );
	$piqes_blog_style = array( $piqes_template_args['type'], $piqes_columns );
} else {
	$piqes_blog_style = explode( '_', piqes_get_theme_option( 'blog_style' ) );
	$piqes_columns    = empty( $piqes_blog_style[1] ) ? 1 : max( 1, min( 3, $piqes_blog_style[1] ) );
}
$piqes_expanded    = ! piqes_sidebar_present() && piqes_is_on( piqes_get_theme_option( 'expand_content' ) );
$piqes_post_format = get_post_format();
$piqes_post_format = empty( $piqes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $piqes_post_format );

?><article id="post-<?php the_ID(); ?>"	data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item'
		. ' post_layout_chess'
		. ' post_layout_chess_' . esc_attr( $piqes_columns )
		. ' post_format_' . esc_attr( $piqes_post_format )
		. ( ! empty( $piqes_template_args['slider'] ) ? ' slider-slide swiper-slide' : '' )
	);
	piqes_add_blog_animation( $piqes_template_args );
	?>
>

	<?php
	// Add anchor
	if ( 1 == $piqes_columns && ! is_array( $piqes_template_args ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode( '[trx_sc_anchor id="post_' . esc_attr( get_the_ID() ) . '" title="' . esc_attr( get_the_title() ) . '" icon="' . esc_attr( piqes_get_post_icon() ) . '"]' );
	}

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$piqes_hover = ! empty( $piqes_template_args['hover'] ) && ! piqes_is_inherit( $piqes_template_args['hover'] )
						? $piqes_template_args['hover']
						: piqes_get_theme_option( 'image_hover' );
	piqes_show_post_featured(
		array(
			'class'         => 1 == $piqes_columns && ! is_array( $piqes_template_args ) ? 'piqes-full-height' : '',
			'hover'         => $piqes_hover,
			'no_links'      => ! empty( $piqes_template_args['no_links'] ),
			'show_no_image' => true,
			'thumb_ratio'   => '1:1',
			'thumb_bg'      => true,
			'thumb_size'    => piqes_get_thumb_size(
				strpos( piqes_get_theme_option( 'body_style' ), 'full' ) !== false
										? ( 1 < $piqes_columns ? 'huge' : 'original' )
										: ( 2 < $piqes_columns ? 'big' : 'huge' )
			),
		)
	);

	?>
	<div class="post_inner"><div class="post_inner_content"><div class="post_header entry-header">
		<?php
			do_action( 'piqes_action_before_post_title' );

			// Post title
			if ( empty( $piqes_template_args['no_links'] ) ) {
				the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			} else {
				the_title( '<h3 class="post_title entry-title">', '</h3>' );
			}

			do_action( 'piqes_action_before_post_meta' );

			// Post meta
			$piqes_components = piqes_array_get_keys_by_value( piqes_get_theme_option( 'meta_parts' ) );
			$piqes_post_meta  = empty( $piqes_components ) || in_array( $piqes_hover, array( 'border', 'pull', 'slide', 'fade' ) )
										? ''
										: piqes_show_post_meta(
											apply_filters(
												'piqes_filter_post_meta_args', array(
													'components' => $piqes_components,
													'seo'  => false,
													'echo' => false,
												), $piqes_blog_style[0], $piqes_columns
											)
										);
			piqes_show_layout( $piqes_post_meta );
			?>
		</div><!-- .entry-header -->

		<div class="post_content entry-content">
			<?php
			// Post content area
            if ( empty( $piqes_template_args['hide_excerpt'] ) && piqes_get_theme_option( 'excerpt_length' ) > 0 ) {
				piqes_show_post_content( $piqes_template_args, '<div class="post_content_inner">', '</div>' );
			}
			// Post meta
			if ( in_array( $piqes_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
				piqes_show_layout( $piqes_post_meta );
			}
			// More button
			if ( empty( $piqes_template_args['no_links'] ) && ! in_array( $piqes_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
				piqes_show_post_more_link( $piqes_template_args, '<p>', '</p>' );
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
