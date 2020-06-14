<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.10
 */


// Socials
if ( piqes_is_on( piqes_get_theme_option( 'socials_in_footer' ) ) ) {
	$piqes_output = piqes_get_socials_links();
	if ( '' != $piqes_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php piqes_show_layout( $piqes_output ); ?>
			</div>
		</div>
		<?php
	}
}
