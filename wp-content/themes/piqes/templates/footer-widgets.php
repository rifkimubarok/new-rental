<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.10
 */

// Footer sidebar
$piqes_footer_name    = piqes_get_theme_option( 'footer_widgets' );
$piqes_footer_present = ! piqes_is_off( $piqes_footer_name ) && is_active_sidebar( $piqes_footer_name );
if ( $piqes_footer_present ) {
	piqes_storage_set( 'current_sidebar', 'footer' );
	$piqes_footer_wide = piqes_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $piqes_footer_name ) ) {
		dynamic_sidebar( $piqes_footer_name );
	}
	$piqes_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $piqes_out ) ) {
		$piqes_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $piqes_out );
		$piqes_need_columns = true;   //or check: strpos($piqes_out, 'columns_wrap')===false;
		if ( $piqes_need_columns ) {
			$piqes_columns = max( 0, (int) piqes_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $piqes_columns ) {
				$piqes_columns = min( 4, max( 1, piqes_tags_count( $piqes_out, 'aside' ) ) );
			}
			if ( $piqes_columns > 1 ) {
				$piqes_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $piqes_columns ) . ' widget', $piqes_out );
			} else {
				$piqes_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $piqes_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $piqes_footer_wide ) {
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
				piqes_show_layout( $piqes_out );
				do_action( 'piqes_action_after_sidebar' );
				if ( $piqes_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $piqes_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
