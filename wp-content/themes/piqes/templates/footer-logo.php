<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.10
 */

// Logo
if ( piqes_is_on( piqes_get_theme_option( 'logo_in_footer' ) ) ) {
	$piqes_logo_image = piqes_get_logo_image( 'footer' );
	$piqes_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $piqes_logo_image['logo'] ) || ! empty( $piqes_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $piqes_logo_image['logo'] ) ) {
					$piqes_attr = piqes_getimagesize( $piqes_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $piqes_logo_image['logo'] ) . '"'
								. ( ! empty( $piqes_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $piqes_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'piqes' ) . '"'
								. ( ! empty( $piqes_attr[3] ) ? ' ' . wp_kses_data( $piqes_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $piqes_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $piqes_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
