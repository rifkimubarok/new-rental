<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.10
 */

$piqes_footer_id = piqes_get_custom_footer_id();
$piqes_footer_meta = get_post_meta( $piqes_footer_id, 'trx_addons_options', true );
if ( ! empty( $piqes_footer_meta['margin'] ) ) {
	piqes_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( piqes_prepare_css_value( $piqes_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $piqes_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $piqes_footer_id ) ) ); ?>
						<?php
						$piqes_footer_scheme = piqes_get_theme_option( 'footer_scheme' );
						if ( ! empty( $piqes_footer_scheme ) && ! piqes_is_inherit( $piqes_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $piqes_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'piqes_action_show_layout', $piqes_footer_id );
	?>
</footer><!-- /.footer_wrap -->
