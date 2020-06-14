<?php
/**
 * The template 'Style 3' to displaying related posts
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

$piqes_link        = get_permalink();
$piqes_post_format = get_post_format();
$piqes_post_format = empty( $piqes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $piqes_post_format );

?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $piqes_post_format ) ); ?>>
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $piqes_link ); ?>"><?php the_title(); ?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<div class="post_meta">
				<a href="<?php echo esc_url( $piqes_link ); ?>" class="post_meta_item post_date"><span class="icon-clock"></span><?php echo wp_kses_data( piqes_get_date() ); ?></a>
			</div>
			<?php
		}
		?>
	</div>
</div>
