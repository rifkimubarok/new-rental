<?php
/**
 * Shortcode: Display post/page featured image (Gutenberg support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.13
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Gutenberg Block
//------------------------------------------------------

// Add scripts and styles for the editor
if ( ! function_exists( 'trx_addons_gutenberg_sc_featured_editor_assets' ) ) {
	add_action( 'enqueue_block_editor_assets', 'trx_addons_gutenberg_sc_featured_editor_assets' );
	function trx_addons_gutenberg_sc_featured_editor_assets() {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			wp_enqueue_script(
				'trx-addons-gutenberg-editor-block-featured',
				trx_addons_get_file_url( TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'featured/gutenberg/featured.gutenberg-editor.js' ),
				array( 'wp-blocks', 'wp-editor', 'wp-i18n', 'wp-element', 'trx_addons-admin', 'trx_addons-utils', 'trx_addons-gutenberg-blocks' ),
				filemtime( trx_addons_get_file_dir( TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'featured/gutenberg/featured.gutenberg-editor.js' ) ),
				true
			);
		}
	}
}

// Block register
if ( ! function_exists( 'trx_addons_sc_featured_add_in_gutenberg' ) ) {
	add_action( 'init', 'trx_addons_sc_featured_add_in_gutenberg' );
	function trx_addons_sc_featured_add_in_gutenberg() {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			register_block_type(
				'trx-addons/layouts-featured', array(
					'attributes'      => array_merge(
						array(
							'type'              => array(
								'type'    => 'string',
								'default' => 'default',
							),
							'height'            => array(
								'type'    => 'title',
								'default' => '',
							),
							'align'             => array(
								'type'    => 'string',
								'default' => '',
							),
							'content'           => array(
								'type'    => 'string',
								'default' => '',
							),
						),
						trx_addons_gutenberg_get_param_hide(true),
						trx_addons_gutenberg_get_param_id()
					),
					'render_callback' => 'trx_addons_gutenberg_sc_featured_render_block',
				)
			);
		}
	}
}

// Block render
if ( ! function_exists( 'trx_addons_gutenberg_sc_featured_render_block' ) ) {
	function trx_addons_gutenberg_sc_featured_render_block( $attributes = array(), $content = '' ) {
		return trx_addons_sc_layouts_featured( $attributes, trx_addons_gutenberg_is_content_built( $content ) ? do_blocks( $content ) : $content );
	}
}

// Return list of allowed layouts
if ( ! function_exists( 'trx_addons_gutenberg_sc_featured_get_layouts' ) ) {
	add_filter( 'trx_addons_filter_gutenberg_sc_layouts', 'trx_addons_gutenberg_sc_featured_get_layouts', 10, 1 );
	function trx_addons_gutenberg_sc_featured_get_layouts( $array = array() ) {
		$array['sc_featured'] = apply_filters(
			'trx_addons_sc_type', array(
				'default' => esc_html__( 'Default', 'trx_addons' ),
			), 'trx_sc_layouts_featured'
		);
		return $array;
	}
}
