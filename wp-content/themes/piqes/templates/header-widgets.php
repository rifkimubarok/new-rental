<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

// Header sidebar
$piqes_header_name    = piqes_get_theme_option( 'header_widgets' );
$piqes_header_present = ! piqes_is_off( $piqes_header_name ) && is_active_sidebar( $piqes_header_name );
if ( $piqes_header_present ) {
	piqes_storage_set( 'current_sidebar', 'header' );
	$piqes_header_wide = piqes_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $piqes_header_name ) ) {
		dynamic_sidebar( $piqes_header_name );
	}
	$piqes_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $piqes_widgets_output ) ) {
		$piqes_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $piqes_widgets_output );
		$piqes_need_columns   = strpos( $piqes_widgets_output, 'columns_wrap' ) === false;
		if ( $piqes_need_columns ) {
			$piqes_columns = max( 0, (int) piqes_get_theme_option( 'header_columns' ) );
			if ( 0 == $piqes_columns ) {
				$piqes_columns = min( 6, max( 1, piqes_tags_count( $piqes_widgets_output, 'aside' ) ) );
			}
			if ( $piqes_columns > 1 ) {
				$piqes_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $piqes_columns ) . ' widget', $piqes_widgets_output );
			} else {
				$piqes_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $piqes_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $piqes_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $piqes_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'piqes_action_before_sidebar' );
				piqes_show_layout( $piqes_widgets_output );
				do_action( 'piqes_action_after_sidebar' );
				if ( $piqes_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $piqes_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
