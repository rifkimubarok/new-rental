<?php
/**
 * The template to display single post
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

get_header();

while ( have_posts() ) {
	the_post();

	// Prepare theme-specific vars:

	// Full post loading
	$full_post_loading        = piqes_get_value_gp( 'action' ) == 'full_post_loading';

	// Prev post loading
	$prev_post_loading        = piqes_get_value_gp( 'action' ) == 'prev_post_loading';

	// Position of the related posts
	$piqes_related_position = piqes_get_theme_option( 'related_position' );

	// Type of the prev/next posts navigation
	$piqes_posts_navigation = piqes_get_theme_option( 'posts_navigation' );
	$piqes_prev_post        = false;

	if ( 'scroll' == $piqes_posts_navigation ) {
		$piqes_prev_post = get_previous_post( true );         // Get post from same category
		if ( ! $piqes_prev_post ) {
			$piqes_prev_post = get_previous_post( false );    // Get post from any category
			if ( ! $piqes_prev_post ) {
				$piqes_posts_navigation = 'links';
			}
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $piqes_prev_post ) ) {
		piqes_storage_set_array( 'options_meta', 'post_thumbnail_type', 'default' );
		if ( piqes_get_theme_option( 'post_header_position' ) != 'below' ) {
			piqes_storage_set_array( 'options_meta', 'post_header_position', 'above' );
		}
		piqes_sc_layouts_showed( 'featured', false );
		piqes_sc_layouts_showed( 'title', false );
		piqes_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $piqes_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'piqes_filter_get_template_part', 'content', get_post_format() ), get_post_format() );

	// If related posts should be inside the content
	if ( strpos( $piqes_related_position, 'inside' ) === 0 ) {
		$piqes_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'piqes_action_related_posts' );
		$piqes_related_content = ob_get_contents();
		ob_end_clean();

		$piqes_related_position_inside = max( 0, min( 9, piqes_get_theme_option( 'related_position_inside' ) ) );
		if ( 0 == $piqes_related_position_inside ) {
			$piqes_related_position_inside = mt_rand( 1, 9 );
		}
		
		$piqes_p_number = 0;
		$piqes_related_inserted = false;
		for ( $i = 0; $i < strlen( $piqes_content ) - 3; $i++ ) {
			if ( $piqes_content[ $i ] == '<' && $piqes_content[ $i + 1 ] == 'p' && in_array( $piqes_content[ $i + 2 ], array( '>', ' ' ) ) ) {
				$piqes_p_number++;
				if ( $piqes_related_position_inside == $piqes_p_number ) {
					$piqes_related_inserted = true;
					$piqes_content = ( $i > 0 ? substr( $piqes_content, 0, $i ) : '' )
										. $piqes_related_content
										. substr( $piqes_content, $i );
				}
			}
		}
		if ( ! $piqes_related_inserted ) {
			$piqes_content .= $piqes_related_content;
		}

		piqes_show_layout( $piqes_content );
	}

	// Author bio
	if ( piqes_get_theme_option( 'show_author_info' ) == 1
		&& ! is_attachment()
		&& get_the_author_meta( 'description' )
		&& ( 'scroll' != $piqes_posts_navigation || piqes_get_theme_option( 'posts_navigation_scroll_hide_author' ) == 0 )
		&& ( ! $full_post_loading || piqes_get_theme_option( 'open_full_post_hide_author' ) == 0 )
	) {
		do_action( 'piqes_action_before_post_author' );
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'templates/author-bio' ) );
		do_action( 'piqes_action_after_post_author' );
	}

	// Previous/next post navigation.
	if ( 'links' == $piqes_posts_navigation && ! $full_post_loading ) {
		do_action( 'piqes_action_before_post_navigation' );
		?>
		<div class="nav-links-single<?php
			if ( ! piqes_is_off( piqes_get_theme_option( 'posts_navigation_fixed' ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation(
				array(
					'next_text' => '<span class="nav-arrow"></span>'
						. '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'piqes' ) . '</span> '
						. '<h6 class="post-title">%title</h6>'
						. '<span class="post_date">%date</span>',
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'piqes' ) . '</span> '
						. '<h6 class="post-title">%title</h6>'
						. '<span class="post_date">%date</span>',
				)
			);
			?>
		</div>
		<?php
		do_action( 'piqes_action_after_post_navigation' );
	}

	// Related posts
	if ( 'below_content' == $piqes_related_position
		&& ( 'scroll' != $piqes_posts_navigation || piqes_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || piqes_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'piqes_action_related_posts' );
	}

	// If comments are open or we have at least one comment, load up the comment template.
	$piqes_comments_number = get_comments_number();
	if ( comments_open() || $piqes_comments_number > 0 ) {
		if ( piqes_get_value_gp( 'show_comments' ) == 1 || ( ! $full_post_loading && ( 'scroll' != $piqes_posts_navigation || piqes_get_theme_option( 'posts_navigation_scroll_hide_comments' ) == 0 || piqes_check_url( '#comment' ) ) ) ) {
			do_action( 'piqes_action_before_comments' );
			comments_template();
			do_action( 'piqes_action_after_comments' );
		} else {
			?>
			<div class="show_comments_single">
				<a href="<?php echo esc_url( add_query_arg( array( 'show_comments' => 1 ), get_comments_link() ) ); ?>" class="theme_button show_comments_button">
					<?php
					if ( $piqes_comments_number > 0 ) {
						echo esc_html( sprintf( _n( 'Show comment', 'Show comments ( %d )', $piqes_comments_number, 'piqes' ), $piqes_comments_number ) );
					} else {
						esc_html_e( 'Leave a comment', 'piqes' );
					}
					?>
				</a>
			</div>
			<?php
		}
	}

	if ( 'scroll' == $piqes_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $piqes_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $piqes_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $piqes_prev_post ) ); ?>">
		</div>
		<?php
	}
}

get_footer();
