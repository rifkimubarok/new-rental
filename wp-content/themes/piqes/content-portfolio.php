<?php
/**
 * The Portfolio template to display the content
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
		. ( is_sticky() && ! is_paged() ? ' sticky' : '' )
	);
	piqes_add_blog_animation( $piqes_template_args );
	?>
>
<?php

// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"></span>
		<?php
}

	$piqes_image_hover = ! empty( $piqes_template_args['hover'] ) && ! piqes_is_inherit( $piqes_template_args['hover'] )
								? $piqes_template_args['hover']
								: piqes_get_theme_option( 'image_hover' );
	// Featured image
	piqes_show_post_featured(
		array(
			'hover'         => $piqes_image_hover,
			'no_links'      => ! empty( $piqes_template_args['no_links'] ),
			'thumb_size'    => piqes_get_thumb_size(
				strpos( piqes_get_theme_option( 'body_style' ), 'med-related' ) !== false || $piqes_columns < 3
								? 'med-related'
				: 'med-related'
			),
			'show_no_image' => true,
			'class'         => 'scale' == $piqes_image_hover ? 'hover_with_info' : '',
			'post_info'     => 'scale' == $piqes_image_hover ? '<div class="post_info">' . esc_html( get_the_title() ) . '</div>' : '',
		)
	);
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!