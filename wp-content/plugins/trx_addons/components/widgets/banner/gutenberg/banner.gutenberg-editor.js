(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Banner
	blocks.registerBlockType(
		'trx-addons/banner', {
			title: i18n.__( 'Widget: Banner' ),
			description: i18n.__( "Banner with image and/or any html and js code" ),
			icon: 'format-image',
			category: 'trx-addons-widgets',
			attributes: trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: ''
					},
					fullwidth: {
						type: 'boolean',
						default: false
					},
					image: {
						type: 'number',
						default: 0
					},
					image_url: {
						type: 'string',
						default: ''
					},
					link: {
						type: 'string',
						default: ''
					},
					code: {
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
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'type': 'text',
								}, props
							),
							// Widget size
							trx_addons_gutenberg_add_param(
								{
									'name': 'fullwidth',
									'title': i18n.__( 'Widget size' ),
									'descr': i18n.__( "Stretch the width of the element to the full screen's width" ),
									'type': 'boolean'
								}, props
							),
							// Image source URL
							trx_addons_gutenberg_add_param(
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Image source URL' ),
									'type': 'image'
								}, props
							),
							// Image link URL
							trx_addons_gutenberg_add_param(
								{
									'name': 'link',
									'title': i18n.__( 'Image link URL' ),
									'type': 'text',
								}, props
							),
							// Paste HTML Code
							trx_addons_gutenberg_add_param(
								{
									'name': 'code',
									'title': i18n.__( 'Paste HTML Code' ),
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
