<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0.10
 */

// Footer menu
$piqes_menu_footer = piqes_get_nav_menu( 'menu_footer' );
if ( ! empty( $piqes_menu_footer ) ) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php
			piqes_show_layout(
				$piqes_menu_footer,
				'<nav class="menu_footer_nav_area sc_layouts_menu sc_layouts_menu_default"'
					. ' itemscope itemtype="//schema.org/SiteNavigationElement"'
					. '>',
				'</nav>'
			);
			?>
		</div>
	</div>
	<?php
}
