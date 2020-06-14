<?php
/**
 * Shortcode: Display any previously created layout (Gutenberg support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.06
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}



// Gutenberg Block
//------------------------------------------------------

// Add scripts and styles for the editor
if ( ! function_exists( 'trx_addons_gutenberg_sc_layouts_editor_assets' ) ) {
	add_action( 'enqueue_block_editor_assets', 'trx_addons_gutenberg_sc_layouts_editor_assets' );
	function trx_addons_gutenberg_sc_layouts_editor_assets() {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
				wp_enqueue_script(
					'trx-addons-gutenberg-editor-block-layouts',
					trx_addons_get_file_url( TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'layouts/gutenberg/layouts.gutenberg-editor.js' ),
					array( 'wp-blocks', 'wp-editor', 'wp-i18n', 'wp-element', 'trx_addons-admin', 'trx_addons-utils', 'trx_addons-gutenberg-blocks' ),
					filemtime( trx_addons_get_file_dir( TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'layouts/gutenberg/layouts.gutenberg-editor.js' ) ),
					true
				);
		}
	}
}

// Block register
if ( ! function_exists( 'trx_addons_sc_layouts_add_in_gutenberg' ) ) {
	add_action( 'init', 'trx_addons_sc_layouts_add_in_gutenberg' );
	function trx_addons_sc_layouts_add_in_gutenberg() {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			register_block_type(
				'trx-addons/layouts', array(
					'attributes'      => array_merge(
						array(
							'type'         => array(
								'type'    => 'string',
								'default' => 'default',
							),
							'layout'       => array(
								'type'    => 'string',
								'default' => '',
							),
							'position'     => array(
								'type'    => 'string',
								'default' => 'right',
							),
							'size'         => array(
								'type'    => 'number',
								'default' => 300,
							),
							'modal'        => array(
								'type'    => 'boolean',
								'default' => false,
							),
							'show_on_load' => array(
								'type'    => 'string',
								'default' => 'none',
							),
							'content'      => array(
								'type'    => 'string',
								'default' => '',
							),
						),
						trx_addons_gutenberg_get_param_id()
					),
					'render_callback' => 'trx_addons_gutenberg_sc_layouts_render_block',
				)
			);
		}
	}
}

// Block render
if ( ! function_exists( 'trx_addons_gutenberg_sc_layouts_render_block' ) ) {
	function trx_addons_gutenberg_sc_layouts_render_block( $attributes = array() ) {
		if ( ! empty( $attributes['layout'] ) ) {		
			$output = trx_addons_sc_layouts( $attributes );
			if ( ! empty( $output ) ) {
				return $output;
			} else {
				return esc_html__( 'Block is cannot be rendered because has not content. Try to change attributes or add a content.', 'trx_addons' );
			}
		} else {
			return esc_html__( 'Select layout.', 'trx_addons' );
		}
	}
}

// Return list of allowed layouts
if ( ! function_exists( 'trx_addons_gutenberg_sc_layouts_get_layouts' ) ) {
	add_filter( 'trx_addons_filter_gutenberg_sc_layouts', 'trx_addons_gutenberg_sc_layouts_get_layouts', 10, 1 );
	function trx_addons_gutenberg_sc_layouts_get_layouts( $array = array() ) {
		$array['sc_layouts'] = apply_filters( 'trx_addons_sc_type', trx_addons_get_list_sc_layouts_type(), 'trx_sc_layouts' );
		return $array;
	}
}

// Add shortcode's specific vars to the JS storage
if ( ! function_exists( 'trx_addons_gutenberg_sc_layouts_params' ) ) {
	add_filter( 'trx_addons_filter_gutenberg_sc_params', 'trx_addons_gutenberg_sc_layouts_params' );
	function trx_addons_gutenberg_sc_layouts_params( $vars = array() ) {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {

			// If editor is active now
			$is_edit_mode = trx_addons_is_post_edit();

			$vars['sc_layouts_layouts'] = !$is_edit_mode ? array() : trx_addons_array_merge(
				array(
					0 => __( '- Use content -', 'trx_addons' ),
				),
				trx_addons_get_list_posts(
					false, array(
						'post_type'    => TRX_ADDONS_CPT_LAYOUTS_PT,
						'meta_key'     => 'trx_addons_layout_type',
						'meta_value'   => 'custom',
						'not_selected' => false,
					)
				)
			);
			$vars['sc_layouts_panel_positions'] = !$is_edit_mode ? array() : trx_addons_get_list_sc_layouts_panel_positions();
			$vars['sc_layouts_show_on_load']    = trx_addons_get_list_layouts_show_on_load();

			return $vars;
		}
	}
}
