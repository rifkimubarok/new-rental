<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

							// Widgets area inside page content
							piqes_create_widgets_area( 'widgets_below_content' );
							?>
						</div><!-- </.content> -->
					<?php

					// Show main sidebar
					get_sidebar();

					$piqes_body_style = piqes_get_theme_option( 'body_style' );
					?>
					</div><!-- </.content_wrap> -->
					<?php

					// Widgets area below page content and related posts below page content
					$piqes_widgets_name = piqes_get_theme_option( 'widgets_below_page' );
					$piqes_show_widgets = ! piqes_is_off( $piqes_widgets_name ) && is_active_sidebar( $piqes_widgets_name );
					$piqes_show_related = is_single() && piqes_get_theme_option( 'related_position' ) == 'below_page';
					if ( $piqes_show_widgets || $piqes_show_related ) {
						if ( 'fullscreen' != $piqes_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $piqes_show_related ) {
							do_action( 'piqes_action_related_posts' );
						}

						// Widgets area below page content
						if ( $piqes_show_widgets ) {
							piqes_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $piqes_body_style ) {
							?>
							</div><!-- </.content_wrap> -->
							<?php
						}
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Single posts banner before footer
			if ( is_singular( 'post' ) ) {
				piqes_show_post_banner('footer');
			}
			// Footer
			$piqes_footer_type = piqes_get_theme_option( 'footer_type' );
			if ( 'custom' == $piqes_footer_type && ! piqes_is_layouts_available() ) {
				$piqes_footer_type = 'default';
			}
			get_template_part( apply_filters( 'piqes_filter_get_template_part', "templates/footer-{$piqes_footer_type}" ) );
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php wp_footer(); ?>

</body>
</html>