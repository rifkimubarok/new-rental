<?php
/**
 * ThemeREX Addons Layouts: Gutenberg utilities
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.51
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Add shortcode's specific lists to the JS storage
if ( ! function_exists( 'trx_addons_cpt_layouts_gutenberg_sc_params' ) ) {
	add_filter( 'trx_addons_filter_gutenberg_sc_params', 'trx_addons_cpt_layouts_gutenberg_sc_params' );
	function trx_addons_cpt_layouts_gutenberg_sc_params( $vars = array() ) {

		// If editor is active now
		$is_edit_mode = trx_addons_is_post_edit();

		// Return list of allowed layouts
		$vars['sc_layouts'] = !$is_edit_mode ? array() : apply_filters( 'trx_addons_filter_gutenberg_sc_layouts', array() );

		// Prepare list of layouts
		$vars['list_layouts'] = !$is_edit_mode ? array() : trx_addons_get_list_posts( false, array(
				'post_type'    => TRX_ADDONS_CPT_LAYOUTS_PT,
				'meta_key'     => 'trx_addons_layout_type',
				'meta_value'   => 'custom',
				'not_selected' => false,
			)
		);

		return $vars;
	}
}


// Generate content to show layout
//------------------------------------------------------------------------
if ( !function_exists( 'trx_addons_cpt_layouts_gutenberg_layout_content' ) ) {
	add_filter( 'trx_addons_filter_sc_layout_content', 'trx_addons_cpt_layouts_gutenberg_layout_content', 11, 2 );
	function trx_addons_cpt_layouts_gutenberg_layout_content($content, $post_id = 0) {
		// Check if this post built with Gutenberg
		if ( trx_addons_gutenberg_is_content_built($content) ) {
			trx_addons_sc_stack_push('show_layout_gutenberg');
			$content = do_blocks( $content );
			trx_addons_sc_stack_pop();
		}
		return $content;
	}
}
