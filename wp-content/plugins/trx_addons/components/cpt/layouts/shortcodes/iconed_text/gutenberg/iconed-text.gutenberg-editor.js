(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Iconed text
	blocks.registerBlockType(
		'trx-addons/layouts-iconed-text', {
			title: i18n.__( 'Iconed text' ),
			description: i18n.__( 'Insert icon with two text lines to the custom layout' ),
			icon: 'phone',
			category: 'trx-addons-layouts',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					icon: {
						type: 'string',
						default: 'icon-phone'
					},
					text1: {
						type: 'title',
						default: i18n.__( 'Line 1' )
					},
					text2: {
						type: 'string',
						default: i18n.__( 'Line 2' )
					},
					link: {
						type: 'string',
						default: ''
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_iconed_text'] ),
								}, props
							),
							// Icon
							trx_addons_gutenberg_add_param(
								{
									'name': 'icon',
									'title': i18n.__( 'Icon' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes()
								}, props
							),
							// Text line 1
							trx_addons_gutenberg_add_param(
								{
									'name': 'text1',
									'title': i18n.__( 'Text line 1' ),
									'descr': i18n.__( "Text in the first line." ),
									'type': 'text',
								}, props
							),
							// Text line 2
							trx_addons_gutenberg_add_param(
								{
									'name': 'text2',
									'title': i18n.__( 'Text line 2' ),
									'descr': i18n.__( "Text in the second line." ),
									'type': 'text',
								}, props
							),
							// Link URL
							trx_addons_gutenberg_add_param(
								{
									'name': 'link',
									'title': i18n.__( 'Link URL' ),
									'descr': i18n.__( "Specify link URL. If empty - show plain text without link" ),
									'type': 'text',
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
