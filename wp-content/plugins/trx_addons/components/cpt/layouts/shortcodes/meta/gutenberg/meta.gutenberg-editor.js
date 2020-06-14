(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Single Post Meta
	blocks.registerBlockType(
		'trx-addons/layouts-meta', {
			title: i18n.__( 'Single Post Meta' ),
			description: i18n.__( 'Add post meta' ),
			icon: 'info',
			category: 'trx-addons-layouts',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					components: {
						type: 'string',
						default: 'date,'
					},
					share_type: {
						type: 'string',
						default: ''
					}
				},
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_meta'] ),
								}, props
							),
							// Choose components
							trx_addons_gutenberg_add_param(
								{
									'name': 'components',
									'name_arr': 'components_arr',
									'title': i18n.__( 'Choose components' ),
									'descr': i18n.__( "Display specified post meta elements" ),
									'type': 'select',
									'multiple': true,
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_meta_components'] ),
								}, props
							),
							// Share type
							trx_addons_gutenberg_add_param(
								{
									'name': 'share_type',
									'title': i18n.__( 'Share_type' ),
									'descr': i18n.__( "Display share links" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_share_types'] ),
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