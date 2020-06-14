<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$piqes_footer_scheme = piqes_get_theme_option( 'footer_scheme' );
if ( ! empty( $piqes_footer_scheme ) && ! piqes_is_inherit( $piqes_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $piqes_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/footer-socials' ) );

	// Menu
	get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/footer-menu' ) );

	// Copyright area
	get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
