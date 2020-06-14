<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

if ( piqes_sidebar_present() ) {
	ob_start();
	$piqes_sidebar_name = piqes_get_theme_option( 'sidebar_widgets' );
	piqes_storage_set( 'current_sidebar', 'sidebar' );
	if ( is_active_sidebar( $piqes_sidebar_name ) ) {
		dynamic_sidebar( $piqes_sidebar_name );
	}
	$piqes_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $piqes_out ) ) {
		$piqes_sidebar_position    = piqes_get_theme_option( 'sidebar_position' );
		$piqes_sidebar_position_ss = piqes_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $piqes_sidebar_position );
			echo ' sidebar_' . esc_attr( $piqes_sidebar_position_ss );

			if ( 'float' == $piqes_sidebar_position_ss ) {
				echo ' sidebar_float';
			}
			$piqes_sidebar_scheme = piqes_get_theme_option( 'sidebar_scheme' );
			if ( ! empty( $piqes_sidebar_scheme ) && ! piqes_is_inherit( $piqes_sidebar_scheme ) ) {
				echo ' scheme_' . esc_attr( $piqes_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php
			// Single posts banner before sidebar
			piqes_show_post_banner( 'sidebar' );
			// Button to show/hide sidebar on mobile
			if ( in_array( $piqes_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$piqes_title = apply_filters( 'piqes_filter_sidebar_control_title', 'float' == $piqes_sidebar_position_ss ? __( 'Show Sidebar', 'piqes' ) : '' );
				$piqes_text  = apply_filters( 'piqes_filter_sidebar_control_text', 'above' == $piqes_sidebar_position_ss ? __( 'Show Sidebar', 'piqes' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_html( $piqes_title ); ?>"><?php echo esc_html( $piqes_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'piqes_action_before_sidebar' );
				piqes_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $piqes_out ) );
				do_action( 'piqes_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<div class="clearfix"></div>
		<?php
	}
}
