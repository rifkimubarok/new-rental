<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

// Page (category, tag, archive, author) title

if ( piqes_need_page_title() ) {
	piqes_sc_layouts_showed( 'title', true );
	piqes_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								piqes_show_post_meta(
									apply_filters(
										'piqes_filter_post_meta_args', array(
											'components' => piqes_array_get_keys_by_value( piqes_get_theme_option( 'meta_parts' ) ),
											'counters'   => piqes_array_get_keys_by_value( piqes_get_theme_option( 'counters' ) ),
											'seo'        => piqes_is_on( piqes_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$piqes_blog_title           = piqes_get_blog_title();
							$piqes_blog_title_text      = '';
							$piqes_blog_title_class     = '';
							$piqes_blog_title_link      = '';
							$piqes_blog_title_link_text = '';
							if ( is_array( $piqes_blog_title ) ) {
								$piqes_blog_title_text      = $piqes_blog_title['text'];
								$piqes_blog_title_class     = ! empty( $piqes_blog_title['class'] ) ? ' ' . $piqes_blog_title['class'] : '';
								$piqes_blog_title_link      = ! empty( $piqes_blog_title['link'] ) ? $piqes_blog_title['link'] : '';
								$piqes_blog_title_link_text = ! empty( $piqes_blog_title['link_text'] ) ? $piqes_blog_title['link_text'] : '';
							} else {
								$piqes_blog_title_text = $piqes_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $piqes_blog_title_class ); ?>">
								<?php
								$piqes_top_icon = piqes_get_term_image_small();
								if ( ! empty( $piqes_top_icon ) ) {
									$piqes_attr = piqes_getimagesize( $piqes_top_icon );
									?>
									<img src="<?php echo esc_url( $piqes_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'piqes' ); ?>"
										<?php
										if ( ! empty( $piqes_attr[3] ) ) {
											piqes_show_layout( $piqes_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $piqes_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $piqes_blog_title_link ) && ! empty( $piqes_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $piqes_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $piqes_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						?>
						<div class="sc_layouts_title_breadcrumbs">
							<?php
							do_action( 'piqes_action_breadcrumbs' );
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
