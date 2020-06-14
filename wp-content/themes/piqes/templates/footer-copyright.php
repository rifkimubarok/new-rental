<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$piqes_copyright_scheme = piqes_get_theme_option( 'copyright_scheme' );
if ( ! empty( $piqes_copyright_scheme ) && ! piqes_is_inherit( $piqes_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $piqes_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$piqes_copyright = piqes_get_theme_option( 'copyright' );
			if ( ! empty( $piqes_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$piqes_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $piqes_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$piqes_copyright = piqes_prepare_macros( $piqes_copyright );
				// Display copyright
				echo wp_kses_post( nl2br( $piqes_copyright ) );
			}
			?>
			</div>
		</div>
	</div>
</div>
