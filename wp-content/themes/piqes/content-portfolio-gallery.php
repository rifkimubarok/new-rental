<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

$piqes_template_args = get_query_var( 'piqes_template_args' );
if ( is_array( $piqes_template_args ) ) {
	$piqes_columns    = empty( $piqes_template_args['columns'] ) ? 2 : max( 1, $piqes_template_args['columns'] );
	$piqes_blog_style = array( $piqes_template_args['type'], $piqes_columns );
} else {
	$piqes_blog_style = explode( '_', piqes_get_theme_option( 'blog_style' ) );
	$piqes_columns    = empty( $piqes_blog_style[1] ) ? 2 : max( 1, $piqes_blog_style[1] );
}
$piqes_post_format = get_post_format();
$piqes_post_format = empty( $piqes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $piqes_post_format );
$piqes_image       = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

?><div class="
<?php
if ( ! empty( $piqes_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo 'masonry_item masonry_item-1_' . esc_attr( $piqes_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $piqes_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $piqes_columns )
		. ' post_layout_gallery'
		. ' post_layout_gallery_' . esc_attr( $piqes_columns )
	);
	piqes_add_blog_animation( $piqes_template_args );
	?>
	data-size="
		<?php
		if ( ! empty( $piqes_image[1] ) && ! empty( $piqes_image[2] ) ) {
			echo intval( $piqes_image[1] ) . 'x' . intval( $piqes_image[2] );}
		?>
	"
	data-src="
		<?php
		if ( ! empty( $piqes_image[0] ) ) {
			echo esc_url( $piqes_image[0] );}
		?>
	"
>
<?php

	// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"></span>
		<?php
}

	// Featured image
	$piqes_image_hover = 'icon';  // !empty($piqes_template_args['hover']) && !piqes_is_inherit($piqes_template_args['hover']) ? $piqes_template_args['hover'] : piqes_get_theme_option('image_hover');
if ( in_array( $piqes_image_hover, array( 'icons', 'zoom' ) ) ) {
	$piqes_image_hover = 'dots';
}
$piqes_components = piqes_array_get_keys_by_value( piqes_get_theme_option( 'meta_parts' ) );
piqes_show_post_featured(
	array(
		'hover'         => $piqes_image_hover,
		'no_links'      => ! empty( $piqes_template_args['no_links'] ),
		'thumb_size'    => piqes_get_thumb_size( strpos( piqes_get_theme_option( 'body_style' ), 'full' ) !== false || $piqes_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only'    => true,
		'show_no_image' => true,
		'post_info'     => '<div class="post_details">'
						. '<h2 class="post_title">'
							. ( empty( $piqes_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>'
								: esc_html( get_the_title() )
								)
						. '</h2>'
						. '<div class="post_description">'
							. ( ! empty( $piqes_components )
								? piqes_show_post_meta(
									apply_filters(
										'piqes_filter_post_meta_args', array(
											'components' => $piqes_components,
											'seo'      => false,
											'echo'     => false,
										), $piqes_blog_style[0], $piqes_columns
									)
								)
								: ''
								)
							. ( empty( $piqes_template_args['hide_excerpt'] )
								? '<div class="post_description_content">' . get_the_excerpt() . '</div>'
								: ''
								)
							. ( empty( $piqes_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__( 'Learn more', 'piqes' ) . '</span></a>'
								: ''
								)
						. '</div>'
					. '</div>',
	)
);
?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
