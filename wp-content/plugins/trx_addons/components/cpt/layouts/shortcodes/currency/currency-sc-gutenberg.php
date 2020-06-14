<?php
/**
 * Shortcode: Display WooCommerce Currency Switcher with items number and totals (Gutenberg support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.14
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Gutenberg Block
//------------------------------------------------------

// Add scripts and styles for the editor
if ( ! function_exists( 'trx_addons_gutenberg_sc_currency_editor_assets' ) ) {
	add_action( 'enqueue_block_editor_assets', 'trx_addons_gutenberg_sc_currency_editor_assets' );
	function trx_addons_gutenberg_sc_currency_editor_assets() {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			if ( function_exists( 'trx_addons_exists_woocommerce' ) && trx_addons_exists_woocommerce() && class_exists( 'WOOCS' ) ) {
				wp_enqueue_script(
					'trx-addons-gutenberg-editor-block-currency',
					trx_addons_get_file_url( TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'currency/gutenberg/currency.gutenberg-editor.js' ),
					array( 'wp-blocks', 'wp-editor', 'wp-i18n', 'wp-element', 'trx_addons-admin', 'trx_addons-utils', 'trx_addons-gutenberg-blocks' ),
					filemtime( trx_addons_get_file_dir( TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'currency/gutenberg/currency.gutenberg-editor.js' ) ),
					true
				);
			}
		}
	}
}

// Block register
if ( ! function_exists( 'trx_addons_sc_currency_add_in_gutenberg' ) ) {
	add_action( 'init', 'trx_addons_sc_currency_add_in_gutenberg' );
	function trx_addons_sc_currency_add_in_gutenberg() {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			if ( function_exists( 'trx_addons_exists_woocommerce' ) && trx_addons_exists_woocommerce() && class_exists( 'WOOCS' ) ) {
				register_block_type(
					'trx-addons/layouts-currency', array(
						'attributes'      => array_merge(
							array(
								'type'             => array(
									'type'    => 'string',
									'default' => 'default',
								)
							),
							trx_addons_gutenberg_get_param_hide(),
							trx_addons_gutenberg_get_param_id()
						),
						'render_callback' => 'trx_addons_gutenberg_sc_currency_render_block',
					)
				);
			}
		}
	}
}

// Block render
if ( ! function_exists( 'trx_addons_gutenberg_sc_currency_render_block' ) ) {
	function trx_addons_gutenberg_sc_currency_render_block( $attributes = array() ) {
		$output = trx_addons_sc_layouts_currency( $attributes );
		if ( ! empty( $output ) ) {
			return $output;
		} else {
			return esc_html__( 'Block is cannot be rendered because has not content. Try to change attributes or add a content.', 'trx_addons' );
		}
	}
}

// Return list of allowed layouts
if ( ! function_exists( 'trx_addons_gutenberg_sc_currency_get_layouts' ) ) {
	add_filter( 'trx_addons_filter_gutenberg_sc_layouts', 'trx_addons_gutenberg_sc_currency_get_layouts', 10, 1 );
	function trx_addons_gutenberg_sc_currency_get_layouts( $array = array() ) {
		$array['sc_currency'] = apply_filters(
			'trx_addons_sc_type', array(
				'default' => esc_html__( 'Default', 'trx_addons' ),
			), 'trx_sc_layouts_currency'
		);
		return $array;
	}
}
