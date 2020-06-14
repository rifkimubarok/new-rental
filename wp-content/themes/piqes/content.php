<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

$piqes_seo = piqes_is_on( piqes_get_theme_option( 'seo_snippets' ) );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class('post_item_single post_type_' . esc_attr( get_post_type() ) 
		. ' post_format_' . esc_attr( str_replace( 'post-format-', '', get_post_format() ) )
	);
	if ( $piqes_seo ) {
		?>
		itemscope="itemscope" 
		itemprop="articleBody" 
		itemtype="//schema.org/<?php echo esc_attr( piqes_get_markup_schema() ); ?>" 
		itemid="<?php echo esc_url( get_the_permalink() ); ?>"
		content="<?php the_title_attribute( '' ); ?>"
		<?php
	}
	?>
>
<?php

	do_action( 'piqes_action_before_post_data' );

	// Structured data snippets
	if ( $piqes_seo ) {
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/seo' ) );
	}

	if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {
		$piqes_post_thumbnail_type  = piqes_get_theme_option( 'post_thumbnail_type' );
		$piqes_post_header_position = piqes_get_theme_option( 'post_header_position' );
		$piqes_post_header_align    = piqes_get_theme_option( 'post_header_align' );
		if ( 'default' === $piqes_post_thumbnail_type && 'default' !== $piqes_post_header_position ) {
			?>
			<div class="header_content_wrap header_align_<?php echo esc_attr( $piqes_post_header_align ); ?>">
				<?php
				// Post title and meta
				if ( 'above' === $piqes_post_header_position ) {
					piqes_show_post_title_and_meta();
				}

				// Featured image
				piqes_show_post_featured_image();

				// Post title and meta
				if ( 'above' !== $piqes_post_header_position ) {
					piqes_show_post_title_and_meta();
				}
				?>
			</div>
			<?php
		} elseif ( 'default' !== $piqes_post_thumbnail_type && 'default' === $piqes_post_header_position ) {
			// Post title and meta
			piqes_show_post_title_and_meta();
		}
	}

	do_action( 'piqes_action_before_post_content' );

	// Post content
	?>
	<div class="post_content post_content_single entry-content" itemprop="mainEntityOfPage">
		<?php
		the_content();

		do_action( 'piqes_action_before_post_pagination' );

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

		// Taxonomies and share
		if ( is_single() && ! is_attachment() ) {

			ob_start();

			// Post taxonomies
			the_tags( '<span class="post_meta_item post_tags">', ' ', '</span>' );

			// Share
			if ( piqes_is_on( piqes_get_theme_option( 'show_share_links' ) ) ) {
				piqes_show_share_links(
					array(
						'type'    => 'block',
						'caption' => '',
						'before'  => '<span class="post_meta_item post_share">',
						'after'   => '</span>',
					)
				);
			}

			$piqes_tags_output = ob_get_contents();

			ob_end_clean();

			if ( ! empty( $piqes_tags_output ) ) {

				do_action( 'piqes_action_before_post_meta' );

				piqes_show_layout( $piqes_tags_output, '<div class="post_meta post_meta_single">', '</div>' );

				do_action( 'piqes_action_after_post_meta' );

			}
		}
		?>
	</div><!-- .entry-content -->


	<?php
	do_action( 'piqes_action_after_post_content' );

	do_action( 'piqes_action_after_post_data' );
	?>
</article>
