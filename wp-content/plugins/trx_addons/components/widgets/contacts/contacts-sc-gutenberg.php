<?php
/**
 * Widget: Display Contacts info (Gutenberg support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}



// Gutenberg Block
//------------------------------------------------------

// Add scripts and styles for the editor
if ( ! function_exists( 'trx_addons_gutenberg_sc_contacts_editor_assets' ) ) {
	add_action( 'enqueue_block_editor_assets', 'trx_addons_gutenberg_sc_contacts_editor_assets' );
	function trx_addons_gutenberg_sc_contacts_editor_assets() {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			// Scripts
			wp_enqueue_script(
				'trx-addons-gutenberg-editor-block-contacts',
				trx_addons_get_file_url( TRX_ADDONS_PLUGIN_WIDGETS . 'contacts/gutenberg/contacts.gutenberg-editor.js' ),
				array( 'wp-blocks', 'wp-editor', 'wp-i18n', 'wp-element', 'trx_addons-admin', 'trx_addons-utils', 'trx_addons-gutenberg-blocks' ),
				filemtime( trx_addons_get_file_dir( TRX_ADDONS_PLUGIN_WIDGETS . 'contacts/gutenberg/contacts.gutenberg-editor.js' ) ),
				true
			);
		}
	}
}

// Block register
if ( ! function_exists( 'trx_addons_sc_contacts_add_in_gutenberg' ) ) {
	add_action( 'init', 'trx_addons_sc_contacts_add_in_gutenberg' );
	function trx_addons_sc_contacts_add_in_gutenberg() {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			register_block_type(
				'trx-addons/contacts', array(
					'attributes'      => array_merge(
						array(
							'title'              => array(
								'type'    => 'string',
								'default' => esc_html__( 'Contacts', 'trx_addons' ),
							),
							'logo'               => array(
								'type'    => 'number',
								'default' => 0,
							),
							'logo_url'           => array(
								'type'    => 'string',
								'default' => '',
							),
							'logo_retina'        => array(
								'type'    => 'number',
								'default' => 0,
							),
							'logo_retina_url'    => array(
								'type'    => 'string',
								'default' => '',
							),
							'description'        => array(
								'type'    => 'string',
								'default' => '',
							),
							'googlemap'          => array(
								'type'    => 'boolean',
								'default' => false,
							),
							'googlemap_height'   => array(
								'type'    => 'number',
								'default' => 140,
							),
							'googlemap_position' => array(
								'type'    => 'string',
								'default' => 'top',
							),
							'address'            => array(
								'type'    => 'string',
								'default' => '',
							),
							'phone'              => array(
								'type'    => 'string',
								'default' => '',
							),
							'email'              => array(
								'type'    => 'string',
								'default' => '',
							),
							'columns'            => array(
								'type'    => 'boolean',
								'default' => false,
							),
							'socials'            => array(
								'type'    => 'boolean',
								'default' => false,
							),
						),
						trx_addons_gutenberg_get_param_id()
					),
					'render_callback' => 'trx_addons_gutenberg_sc_contacts_render_block',
				)
			);
		}
	}
}

// Block render
if ( ! function_exists( 'trx_addons_gutenberg_sc_contacts_render_block' ) ) {
	function trx_addons_gutenberg_sc_contacts_render_block( $attributes = array() ) {
		return trx_addons_sc_widget_contacts( $attributes );
	}
}
