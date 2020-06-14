<?php
/**
 * ThemeREX Shortcodes: Gutenberg support
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.52
 */


// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Gutenberg Support
//------------------------------------------------------

// Add common shortcode's specific lists to the JS storage
if ( ! function_exists( 'trx_addons_gutenberg_sc_params' ) ) {
	add_filter( 'trx_addons_filter_gutenberg_sc_params', 'trx_addons_gutenberg_sc_params' );
	function trx_addons_gutenberg_sc_params( $vars = array() ) {
		
		// If editor is active now
		$is_edit_mode = trx_addons_is_post_edit();
		
		// Return iconed classes list
		$vars['icons_classes'] = array();
		if ( $is_edit_mode ) {
			$list_icons = trx_addons_get_list_icons_classes();
			if ( ! empty( $list_icons ) ) {
				foreach ( $list_icons as $x => $y ) {
					$vars['icons_classes'][] = $y;
				}
			}
		}

		// Return list of the element positions
		$vars['sc_positions'] = !$is_edit_mode ? array() : trx_addons_get_list_sc_positions();

		// Return list of the floats
		$vars['sc_floats'] = !$is_edit_mode ? array() : trx_addons_get_list_sc_floats();

		// Return list of the title align
		$vars['sc_aligns'] = !$is_edit_mode ? array() : trx_addons_get_list_sc_aligns();

		// Return shortlist of the title align
		$vars['sc_aligns_short'] = !$is_edit_mode ? array() : trx_addons_get_list_sc_aligns(false, false);

		// Return list of the subtitle positions
		$vars['sc_subtitle_positions'] = !$is_edit_mode ? array() : trx_addons_get_list_sc_subtitle_positions();
		$vars['sc_subtitle_position']  = trx_addons_get_setting('subtitle_above_title') ? 'above' : 'below';

		// Return list of the orderby options for widgets
		$vars['widget_query_orderby'] = !$is_edit_mode ? array() : trx_addons_get_list_widget_query_orderby();

		// Return list of the orderby options for CPT shortcodes
		$vars['sc_query_orderby'] = !$is_edit_mode ? array() : trx_addons_get_list_sc_query_orderby();

		// Return list of the order options
		$vars['sc_query_orders'] = !$is_edit_mode ? array() : trx_addons_get_list_sc_query_orders();

		// Return list of the slider pagination positions
		$vars['sc_paginations'] = !$is_edit_mode ? array() : trx_addons_get_list_sc_paginations();

		// Return list of post's types
		$vars['posts_types'] = !$is_edit_mode ? array() : trx_addons_get_list_posts_types();

		// Return list of taxonomies
		$vars['taxonomies'] = array();
		if ( $is_edit_mode ) {
			foreach ( $vars['posts_types'] as $key => $value ) {
				$vars['taxonomies'][ $key ] = trx_addons_get_list_taxonomies( false, $key );
			}
		}

		// Return list of categories
		$vars['categories'] = array();
		if ( $is_edit_mode ) {
			foreach ( $vars['posts_types'] as $key => $value ) {
				$taxonomies = trx_addons_get_list_taxonomies( false, $key );
				foreach ( $taxonomies as $x => $y ) {
					//$vars['categories'][ $x ] = trx_addons_get_list_terms( false, $x );
					$tax_obj = get_taxonomy($x);
					$vars['categories'][ $x ] = trx_addons_array_merge(
													array( 0 => sprintf(__('- %s -', 'trx_addons'), $tax_obj->label)),
													$x == 'category' 
														? trx_addons_get_list_categories() 
														: trx_addons_get_list_terms(false, $x)
												);
				}
			}
		}

		// Return list of categories
		$vars['list_categories'] = !$is_edit_mode ? array() : trx_addons_array_merge( array( 0 => esc_html__( '- Select category -', 'trx_addons' ) ), trx_addons_get_list_categories() );

		// List of meta parts
		$vars['meta_parts'] = !$is_edit_mode ? array() : apply_filters('trx_addons_filter_get_list_meta_parts', array());

		// Return input hover effects
		$vars['input_hover'] = !$is_edit_mode ? array() : trx_addons_get_list_input_hover( true );

		// Return all thumbnails sizes
		$vars['thumbnail_sizes'] = !$is_edit_mode ? array() : trx_addons_get_list_thumbnail_sizes();

		// Return all meta parts
		$vars['meta_parts'] = !$is_edit_mode ? array() : apply_filters('trx_addons_filter_get_list_meta_parts', array());

		// Return list of the directions
		$vars['sc_directions'] = !$is_edit_mode ? array() : trx_addons_get_list_sc_directions();

		// Return list of the enter animations
		$vars['animations_in'] = !$is_edit_mode ? array() : trx_addons_get_list_animations_in();

		// Return list of the out animations
		$vars['animations_out'] = !$is_edit_mode ? array() : trx_addons_get_list_animations_out();

		return $vars;
	}
}
