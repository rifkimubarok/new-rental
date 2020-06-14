<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

$piqes_args = get_query_var( 'piqes_logo_args' );

// Site logo
$piqes_logo_type   = isset( $piqes_args['type'] ) ? $piqes_args['type'] : '';
$piqes_logo_image  = piqes_get_logo_image( $piqes_logo_type );
$piqes_logo_text   = piqes_is_on( piqes_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$piqes_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $piqes_logo_image['logo'] ) || ! empty( $piqes_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $piqes_logo_image['logo'] ) ) {
			if ( empty( $piqes_logo_type ) && function_exists( 'the_custom_logo' ) && (int) $piqes_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$piqes_attr = piqes_getimagesize( $piqes_logo_image['logo'] );
				echo '<img src="' . esc_url( $piqes_logo_image['logo'] ) . '"'
						. ( ! empty( $piqes_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $piqes_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $piqes_logo_text ) . '"'
						. ( ! empty( $piqes_attr[3] ) ? ' ' . wp_kses_data( $piqes_attr[3] ) : '' )
						. '>';
			}
		} else {
			piqes_show_layout( piqes_prepare_macros( $piqes_logo_text ), '<span class="logo_text">', '</span>' );
			piqes_show_layout( piqes_prepare_macros( $piqes_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
