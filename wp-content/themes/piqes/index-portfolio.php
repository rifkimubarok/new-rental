<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

piqes_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	piqes_blog_archive_start();

	$piqes_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$piqes_sticky_out = piqes_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $piqes_stickies ) && count( $piqes_stickies ) > 0 && get_query_var( 'paged' ) < 1;

	// Show filters
	$piqes_cat          = piqes_get_theme_option( 'parent_cat' );
	$piqes_post_type    = piqes_get_theme_option( 'post_type' );
	$piqes_taxonomy     = piqes_get_post_type_taxonomy( $piqes_post_type );
	$piqes_show_filters = piqes_get_theme_option( 'show_filters' );
	$piqes_tabs         = array();
	if ( ! piqes_is_off( $piqes_show_filters ) ) {
		$piqes_args           = array(
			'type'         => $piqes_post_type,
			'child_of'     => $piqes_cat,
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'taxonomy'     => $piqes_taxonomy,
			'pad_counts'   => false,
		);
		$piqes_portfolio_list = get_terms( $piqes_args );
		if ( is_array( $piqes_portfolio_list ) && count( $piqes_portfolio_list ) > 0 ) {
			$piqes_tabs[ $piqes_cat ] = esc_html__( 'All', 'piqes' );
			foreach ( $piqes_portfolio_list as $piqes_term ) {
				if ( isset( $piqes_term->term_id ) ) {
					$piqes_tabs[ $piqes_term->term_id ] = $piqes_term->name;
				}
			}
		}
	}
	if ( count( $piqes_tabs ) > 0 ) {
		$piqes_portfolio_filters_ajax   = true;
		$piqes_portfolio_filters_active = $piqes_cat;
		$piqes_portfolio_filters_id     = 'portfolio_filters';
		?>
		<div class="portfolio_filters piqes_tabs piqes_tabs_ajax">
			<ul class="portfolio_titles piqes_tabs_titles">
				<?php
				foreach ( $piqes_tabs as $piqes_id => $piqes_title ) {
					?>
					<li><a href="<?php echo esc_url( piqes_get_hash_link( sprintf( '#%s_%s_content', $piqes_portfolio_filters_id, $piqes_id ) ) ); ?>" data-tab="<?php echo esc_attr( $piqes_id ); ?>"><?php echo esc_html( $piqes_title ); ?></a></li>
					<?php
				}
				?>
			</ul>
			<?php
			$piqes_ppp = piqes_get_theme_option( 'posts_per_page' );
			if ( piqes_is_inherit( $piqes_ppp ) ) {
				$piqes_ppp = '';
			}
			foreach ( $piqes_tabs as $piqes_id => $piqes_title ) {
				$piqes_portfolio_need_content = $piqes_id == $piqes_portfolio_filters_active || ! $piqes_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr( sprintf( '%s_%s_content', $piqes_portfolio_filters_id, $piqes_id ) ); ?>"
					class="portfolio_content piqes_tabs_content"
					data-blog-template="<?php echo esc_attr( piqes_storage_get( 'blog_template' ) ); ?>"
					data-blog-style="<?php echo esc_attr( piqes_get_theme_option( 'blog_style' ) ); ?>"
					data-posts-per-page="<?php echo esc_attr( $piqes_ppp ); ?>"
					data-post-type="<?php echo esc_attr( $piqes_post_type ); ?>"
					data-taxonomy="<?php echo esc_attr( $piqes_taxonomy ); ?>"
					data-cat="<?php echo esc_attr( $piqes_id ); ?>"
					data-parent-cat="<?php echo esc_attr( $piqes_cat ); ?>"
					data-need-content="<?php echo ( false === $piqes_portfolio_need_content ? 'true' : 'false' ); ?>"
				>
					<?php
					if ( $piqes_portfolio_need_content ) {
						piqes_show_portfolio_posts(
							array(
								'cat'        => $piqes_id,
								'parent_cat' => $piqes_cat,
								'taxonomy'   => $piqes_taxonomy,
								'post_type'  => $piqes_post_type,
								'page'       => 1,
								'sticky'     => $piqes_sticky_out,
							)
						);
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		piqes_show_portfolio_posts(
			array(
				'cat'        => $piqes_cat,
				'parent_cat' => $piqes_cat,
				'taxonomy'   => $piqes_taxonomy,
				'post_type'  => $piqes_post_type,
				'page'       => 1,
				'sticky'     => $piqes_sticky_out,
			)
		);
	}

	piqes_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'piqes_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
