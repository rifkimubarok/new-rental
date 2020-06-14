<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

$piqes_link        = get_permalink();
$piqes_post_format = get_post_format();
$piqes_post_format = empty( $piqes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $piqes_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $piqes_post_format ) ); ?>>
	<?php
	piqes_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'piqes_filter_related_thumb_size', piqes_get_thumb_size( (int) piqes_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
			'show_no_image' => piqes_get_no_image() != '',
			'post_info'     => '<div class="post_header entry-header">'
									. '<div class="post_categories">' . wp_kses_post( piqes_get_post_categories( '' ) ) . '</div>'
									. '<h6 class="post_title entry-title"><a href="' . esc_url( $piqes_link ) . '">' . wp_kses_data( get_the_title() ) . '</a></h6>'
									. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
											? '<div class="post_meta"><a href="' . esc_url( $piqes_link ) . '" class="post_meta_item post_date">' . wp_kses_data( piqes_get_date() ) . '</a></div>'
											: '' )
								. '</div>',
		)
	);
	?>
</div>
