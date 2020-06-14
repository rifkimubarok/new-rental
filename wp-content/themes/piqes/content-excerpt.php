<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

$piqes_template_args = get_query_var( 'piqes_template_args' );
if ( is_array( $piqes_template_args ) ) {
	$piqes_columns    = empty( $piqes_template_args['columns'] ) ? 1 : max( 1, $piqes_template_args['columns'] );
	$piqes_blog_style = array( $piqes_template_args['type'], $piqes_columns );
	if ( ! empty( $piqes_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $piqes_columns > 1 ) {
		?>
		<div class="column-1_<?php echo esc_attr( $piqes_columns ); ?>">
		<?php
	}
}
$piqes_expanded    = ! piqes_sidebar_present() && piqes_is_on( piqes_get_theme_option( 'expand_content' ) );
$piqes_post_format = get_post_format();
$piqes_post_format = empty( $piqes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $piqes_post_format );

$piqes_show_title = get_the_title() != '';

$piqes_components = piqes_array_get_keys_by_value( piqes_get_theme_option( 'meta_parts' ) );

$share = '';
$share = 'share';
$share_in = strpos($piqes_components, $share);

$vowels_1 = array(",share", "share,", "share");
$piqes_components = str_replace($vowels_1, "", $piqes_components);

?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_layout_excerpt post_format_' . esc_attr( $piqes_post_format ) );
	piqes_add_blog_animation( $piqes_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Post title
			if ( $piqes_show_title && in_array( $piqes_post_format, array( 'audio' ) ) ) {
				do_action( 'piqes_action_before_post_title' );
				if ( empty( $piqes_template_args['no_links'] ) ) {
					the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
				} else {
					the_title( '<h2 class="post_title entry-title">', '</h2>' );
				}
			}

	// Featured image
	$piqes_hover = ! empty( $piqes_template_args['hover'] ) && ! piqes_is_inherit( $piqes_template_args['hover'] )
						? $piqes_template_args['hover']
						: piqes_get_theme_option( 'image_hover' );
	piqes_show_post_featured(
		array(
			'no_links'   => ! empty( $piqes_template_args['no_links'] ),
			'hover'      => $piqes_hover,
			'thumb_size' => piqes_get_thumb_size( strpos( piqes_get_theme_option( 'body_style' ), 'full' ) !== false ? 'full' : ( $piqes_expanded ? 'huge' : 'big' ) ),
			'thumb_ratio'   => '20:12',
			'post_info'  => ((! empty( $piqes_components ) && $share_in !==false && has_post_thumbnail() && ! in_array( $piqes_post_format, array( 'link', 'audio', 'quote' ) ) )
                            ? piqes_show_post_meta(
                                array(
                                        'components' => 'share',
                                        'seo'        => false,
                                        'echo'       => false,
                                    )
                            )
                            : ''
                            )
		)
	);

	// Title and post meta
	$piqes_show_meta  = ! empty( $piqes_components ) && ! in_array( $piqes_hover, array( 'border', 'pull', 'slide', 'fade' ) );
	if ( $piqes_show_title || $piqes_show_meta ) {
		?>
		<div class="post_header entry-header">
			<?php

			if(! in_array( $piqes_post_format, array( 'audio' ) )) {
			    $categories = '';
                $categories = 'categories';
                $cat = strpos($piqes_components, $categories);

                if ( $cat !== false ) {
                    do_action( 'piqes_action_before_post_meta' );
                    piqes_show_post_meta(
                        array(
                                'components' => 'categories',
                                'seo'        => false,
                            )
                    );
                }
			}



			// Post title
			if ( $piqes_show_title && !in_array( $piqes_post_format, array( 'audio' ) ) ) {
				do_action( 'piqes_action_before_post_title' );
				if ( empty( $piqes_template_args['no_links'] ) ) {
					the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
				} else {
					the_title( '<h2 class="post_title entry-title">', '</h2>' );
				}
			}

			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( empty( $piqes_template_args['hide_excerpt'] ) && piqes_get_theme_option( 'excerpt_length' ) > 0 && !in_array( $piqes_post_format, array( 'audio' ) ) ) {
		?>
		<div class="post_content entry-content">
			<?php
			if ( piqes_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'piqes_action_before_full_post_content' );
					the_content( '' );
					do_action( 'piqes_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'piqes' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'piqes' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				piqes_show_post_content( $piqes_template_args, '<div class="post_content_inner">', '</div>' );
				// More button
				if ( empty( $piqes_template_args['no_links'] ) && ! in_array( $piqes_post_format, array( 'link', 'aside', 'status', 'quote' ) ) && false ) {
					piqes_show_post_more_link( $piqes_template_args, '<p>', '</p>' );
				}
			}
			?>
		</div><!-- .entry-content -->
		<?php
	}

			// Post meta
            if(!in_array( $piqes_post_format, array( 'audio' ) )) {
	            $vowels = array(
			        ",categories", "categories,", "categories",
                );
                $piqes_components2 = '';
                $piqes_components2 = str_replace($vowels, "", $piqes_components);
                // Post meta
                if ( ! empty( $piqes_components2 ) && ! in_array( $piqes_hover, array( 'border', 'pull', 'slide', 'fade' ) ) ) {
                    piqes_show_post_meta(
                        apply_filters(
                            'piqes_filter_post_meta_args', array(
                                'components' => $piqes_components2,
                                'seo'        => false,
                            ), 'excerpt', 1
                        )
                    );
                }
            } else {
	            if ( ! empty( $piqes_components ) && ! in_array( $piqes_hover, array( 'border', 'pull', 'slide', 'fade' ) ) ) {
                    piqes_show_post_meta(
                        apply_filters(
                            'piqes_filter_post_meta_args', array(
                                'components' => $piqes_components,
                                'seo'        => false,
                            ), 'excerpt', 1
                        )
                    );
                }
            }

	?>
</article>
<?php

if ( is_array( $piqes_template_args ) ) {
	if ( ! empty( $piqes_template_args['slider'] ) || $piqes_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
