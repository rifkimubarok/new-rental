<?php
/**
 * The default template to displaying related posts
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.54
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
		)
	);
	?>
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $piqes_link ); ?>"><?php the_title(); ?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<span class="post_date"><a href="<?php echo esc_url( $piqes_link ); ?>"><?php echo wp_kses_data( piqes_get_date() ); ?></a></span>
			<?php
		}
		?>
	</div>
</div>
