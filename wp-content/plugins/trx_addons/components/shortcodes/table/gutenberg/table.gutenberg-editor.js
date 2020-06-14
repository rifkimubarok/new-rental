(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Table
	blocks.registerBlockType(
		'trx-addons/table', {
			title: i18n.__( 'Table' ),
			description: i18n.__( "Insert a table" ),
			icon: 'grid-view',
			category: 'trx-addons-blocks',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					align: {
						type: 'string',
						default: 'none'
					},
					width: {
						type: 'string',
						default: '100%'
					},
					content: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					},
				},
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
				trx_addons_gutenberg_get_param_id()
			),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {},
							// Layout
							trx_addons_gutenberg_add_param(
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_table'] )
								}, props
							),
							// Table alignment
							trx_addons_gutenberg_add_param(
								{
									'name': 'align',
									'title': i18n.__( 'Table alignment' ),
									'descr': i18n.__( "Select alignment of the table" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
								}, props
							),
							// Width
							trx_addons_gutenberg_add_param(
								{
									'name': 'width',
									'title': i18n.__( 'Width' ),
									'descr': i18n.__( "Width of the table" ),
									'type': 'text'
								}, props
							),
							// Content
							trx_addons_gutenberg_add_param(
								{
									'name': 'content',
									'title': i18n.__( 'Content' ),
									'descr': i18n.__( "Content, created with any table-generator, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/" ),
									'type': 'textarea'
								}, props
							),
						),
						'additional_params': el(
							'div', {},
							// Title params
							trx_addons_gutenberg_add_param_title( props, true ),
							// ID, Class, CSS params
							trx_addons_gutenberg_add_param_id( props )
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		}
	);
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element, );
