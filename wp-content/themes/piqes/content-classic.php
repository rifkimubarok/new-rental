<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

$piqes_template_args = get_query_var( 'piqes_template_args' );
if ( is_array( $piqes_template_args ) ) {
	$piqes_columns    = empty( $piqes_template_args['columns'] ) ? 2 : max( 1, $piqes_template_args['columns'] );
	$piqes_blog_style = array( $piqes_template_args['type'], $piqes_columns );
} else {
	$piqes_blog_style = explode( '_', piqes_get_theme_option( 'blog_style' ) );
	$piqes_columns    = empty( $piqes_blog_style[1] ) ? 2 : max( 1, $piqes_blog_style[1] );
}
$piqes_expanded   = ! piqes_sidebar_present() && piqes_is_on( piqes_get_theme_option( 'expand_content' ) );
$piqes_components = piqes_array_get_keys_by_value( piqes_get_theme_option( 'meta_parts' ) );

$piqes_post_format = get_post_format();
$piqes_post_format = empty( $piqes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $piqes_post_format );

$share = '';
$share = 'share';
$share_in = strpos($piqes_components, $share);

$vowels_1 = array(",share", "share,", "share");
$piqes_components = str_replace($vowels_1, "", $piqes_components);



?><div class="
<?php
if ( ! empty( $piqes_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( 'classic' == $piqes_blog_style[0] ? 'column' : 'masonry_item masonry_item' ) . '-1_' . esc_attr( $piqes_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $piqes_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $piqes_columns )
				. ' post_layout_' . esc_attr( $piqes_blog_style[0] )
				. ' post_layout_' . esc_attr( $piqes_blog_style[0] ) . '_' . esc_attr( $piqes_columns )
	);
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

	// Featured image
	$piqes_hover = ! empty( $piqes_template_args['hover'] ) && ! piqes_is_inherit( $piqes_template_args['hover'] )
						? $piqes_template_args['hover']
						: piqes_get_theme_option( 'image_hover' );
	piqes_show_post_featured(
		array(
			'thumb_size' => piqes_get_thumb_size(
				'classic' == $piqes_blog_style[0]
						? ( strpos( piqes_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $piqes_columns > 2 ? 'big' : 'huge' )
								: ( $piqes_columns > 2
									? ( $piqes_expanded ? 'med' : 'small' )
									: ( $piqes_expanded ? 'big' : 'med' )
									)
							)
						: ( strpos( piqes_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $piqes_columns > 2 ? 'masonry-big' : 'full' )
								: ( $piqes_columns <= 2 && $piqes_expanded ? 'masonry-big' : 'masonry' )
							)
			),
			'hover'      => $piqes_hover,
			'thumb_ratio' => '20:14',
			'no_links'   => ! empty( $piqes_template_args['no_links'] ),
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

	if ( ! in_array( $piqes_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		?>
		<div class="post_header entry-header">
			<?php
			do_action( 'piqes_action_before_post_title' );

			// Post title
			if ( empty( $piqes_template_args['no_links'] ) ) {
				the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
			} else {
				the_title( '<h4 class="post_title entry-title">', '</h4>' );
			}

			do_action( 'piqes_action_before_post_meta' );

			// Post meta

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

			do_action( 'piqes_action_after_post_meta' );
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>

	<div class="post_content entry-content">
		<?php
        if ( empty( $piqes_template_args['hide_excerpt'] ) && piqes_get_theme_option( 'excerpt_length' ) > 0 ) {
			// Post content area
			piqes_show_post_content( $piqes_template_args, '<div class="post_content_inner">', '</div>' );
		}
        $vowels_1 = array(",share", "share,", "share", ",categories", "categories,", "categories");
        $piqes_components = str_replace($vowels_1, "", $piqes_components);
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
		// More button
		if ( empty( $piqes_template_args['no_links'] ) && ! empty( $piqes_template_args['more_text'] ) && ! in_array( $piqes_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
			piqes_show_post_more_link( $piqes_template_args, '<p>', '</p>' );
		}
		?>
	</div><!-- .entry-content -->

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
