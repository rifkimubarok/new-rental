(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Layouts
	blocks.registerBlockType(
		'trx-addons/layouts', {
			title: i18n.__( 'Layouts' ),
			description: i18n.__( 'Display previously created custom layouts' ),
			icon: 'admin-plugins',
			category: 'trx-addons-layouts',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					layout: {
						type: 'string',
						default: ''
					},
					position: {
						type: 'string',
						default: 'right'
					},
					size: {
						type: 'number',
						default: 300
					},
					modal: {
						type: 'boolean',
						default: false
					},
					show_on_load: {
						type: 'string',
						default: 'none'
					},
					content: {
						type: 'string',
						default: ''
					},
				},
				trx_addons_gutenberg_get_param_id()
			),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {},
							// Type
							trx_addons_gutenberg_add_param(
								{
									'name': 'type',
									'title': i18n.__( 'Type' ),
									'descr': i18n.__( "Select shortcodes's type" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_layouts'] ),
								}, props
							),
							// Layout
							trx_addons_gutenberg_add_param(
								{
									'name': 'layout',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select any previously created layout to insert to this page" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_layouts'] ),
								}, props
							),
							// Panel position
							trx_addons_gutenberg_add_param(
								{
									'name': 'position',
									'title': i18n.__( 'Panel position' ),
									'descr': i18n.__( "Dock the panel to the specified side of the window" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_panel_positions'] ),
									'dependency': {
										'type': ['panel']
									}
								}, props
							),
							// Size of the panel
							trx_addons_gutenberg_add_param(
								{
									'name': 'size',
									'title': i18n.__( 'Size of the panel' ),
									'descr': i18n.__( 'Size (width or height) of the panel' ),
									'type': 'number',
									'min': 0,
									'dependency': {
										'type': ['panel']
									}
								}, props
							),
							// Modal
							trx_addons_gutenberg_add_param(
								{
									'name': 'modal',
									'title': i18n.__( 'Modal' ),
									'descr': i18n.__( 'Disable clicks on the rest window area' ),
									'type': 'boolean',
									'dependency': {
										'type': ['panel']
									}
								}, props
							),
							// Show on page load
							trx_addons_gutenberg_add_param(
								{
									'name': 'show_on_load',
									'title': i18n.__( 'Show on page load' ),
									'descr': i18n.__( "Display this popup (panel) when the page is loaded" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_show_on_load'] ),
								}, props
							),
							// Content
							trx_addons_gutenberg_add_param(
								{
									'name': 'content',
									'title': i18n.__( 'Content' ),
									'descr': i18n.__( "Alternative content to be used instead of the selected layout" ),
									'type': 'textarea',
								}, props
							),
						),
						'additional_params': el(
							'div', {},
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
