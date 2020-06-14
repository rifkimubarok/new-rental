(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Widgets
	blocks.registerBlockType(
		'trx-addons/layouts-widgets', {
			title: i18n.__( 'Widgets' ),
			description: i18n.__( 'Insert selected widgets area' ),
			icon: 'lightbulb',
			category: 'trx-addons-layouts',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					widgets: {
						type: 'string',
						default: 'inherit'
					},
					columns: {
						type: 'number',
						default: 1
					},
				},
				trx_addons_gutenberg_get_param_hide(),
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
									'descr': i18n.__( "Select layout's type" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_logo'] ),
								}, props
							),
							// Widgets
							trx_addons_gutenberg_add_param(
								{
									'name': 'widgets',
									'title': i18n.__( 'Widgets' ),
									'descr': i18n.__( "Select previously filled widgets areae" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['widgets'] ),
								}, props
							),
							// Columns
							trx_addons_gutenberg_add_param(
								{
									'name': 'columns',
									'title': i18n.__( 'Columns' ),
									'descr': i18n.__( "Select the number of columns for widgets display. If the chosen value is 0, autodetect by the number of widgets." ),
									'type': 'nmber',
									'min': 1,
									'max': 6
								}, props
							),
						),
						'additional_params': el(
							'div', {},
							// Hide on devices params
							trx_addons_gutenberg_add_param_hide( props ),
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