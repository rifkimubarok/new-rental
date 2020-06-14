<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.50
 */

$piqes_template_args = get_query_var( 'piqes_template_args' );
if ( is_array( $piqes_template_args ) ) {
	$piqes_columns    = empty( $piqes_template_args['columns'] ) ? 2 : max( 1, $piqes_template_args['columns'] );
	$piqes_blog_style = array( $piqes_template_args['type'], $piqes_columns );
} else {
	$piqes_blog_style = explode( '_', piqes_get_theme_option( 'blog_style' ) );
	$piqes_columns    = empty( $piqes_blog_style[1] ) ? 2 : max( 1, $piqes_blog_style[1] );
}
$piqes_blog_id       = piqes_get_custom_blog_id( join( '_', $piqes_blog_style ) );
$piqes_blog_style[0] = str_replace( 'blog-custom-', '', $piqes_blog_style[0] );
$piqes_expanded      = ! piqes_sidebar_present() && piqes_is_on( piqes_get_theme_option( 'expand_content' ) );
$piqes_components    = piqes_array_get_keys_by_value( piqes_get_theme_option( 'meta_parts' ) );

$piqes_post_format   = get_post_format();
$piqes_post_format   = empty( $piqes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $piqes_post_format );

$piqes_blog_meta     = piqes_get_custom_layout_meta( $piqes_blog_id );
$piqes_custom_style  = ! empty( $piqes_blog_meta['scripts_required'] ) ? $piqes_blog_meta['scripts_required'] : 'none';

if ( ! empty( $piqes_template_args['slider'] ) || $piqes_columns > 1 || ! piqes_is_off( $piqes_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $piqes_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo ( piqes_is_off( $piqes_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $piqes_custom_style ) ) . '-1_' . esc_attr( $piqes_columns );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_format_' . esc_attr( $piqes_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $piqes_columns )
					. ' post_layout_' . esc_attr( $piqes_blog_style[0] )
					. ' post_layout_' . esc_attr( $piqes_blog_style[0] ) . '_' . esc_attr( $piqes_columns )
					. ( ! piqes_is_off( $piqes_custom_style )
						? ' post_layout_' . esc_attr( $piqes_custom_style )
							. ' post_layout_' . esc_attr( $piqes_custom_style ) . '_' . esc_attr( $piqes_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'piqes_action_show_layout', $piqes_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $piqes_template_args['slider'] ) || $piqes_columns > 1 || ! piqes_is_off( $piqes_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
