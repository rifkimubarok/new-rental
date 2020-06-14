(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Title and Breadcrumbs
	blocks.registerBlockType(
		'trx-addons/layouts-title', {
			title: i18n.__( 'Title and Breadcrumbs' ),
			description: i18n.__( 'Insert post meta and/or title and/or breadcrumbs' ),
			icon: 'editor-textcolor',
			category: 'trx-addons-layouts',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					image: {
						type: 'number',
						default: 0
					},
					image_url: {
						type: 'string',
						default: ''
					},
					use_featured_image: {
						type: 'boolean',
						default: false
					},
					height: {
						type: 'string',
						default: ''
					},
					align: {
						type: 'string',
						default: ''
					},
					meta: {
						type: 'boolean',
						default: false
					},
					title: {
						type: 'boolean',
						default: false
					},
					breadcrumbs: {
						type: 'boolean',
						default: false
					},
				},
				trx_addons_gutenberg_get_param_hide(true),
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_layouts_title'] ),
								}, props
							),
							// Alignment
							trx_addons_gutenberg_add_param(
								{
									'name': 'align',
									'title': i18n.__( 'Alignment' ),
									'descr': i18n.__( "Select alignment of the inner content in this block" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] ),
								}, props
							),
							// Show post title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Show post title' ),
									'descr': i18n.__( "Show post/page title" ),
									'type': 'boolean',
								}, props
							),
							// Show post meta
							trx_addons_gutenberg_add_param(
								{
									'name': 'meta',
									'title': i18n.__( 'Show post meta' ),
									'descr': i18n.__( "Show post meta: date, author, categories list, etc." ),
									'type': 'boolean',
								}, props
							),
							// Show breadcrumbs
							trx_addons_gutenberg_add_param(
								{
									'name': 'breadcrumbs',
									'title': i18n.__( 'Show breadcrumbs' ),
									'descr': i18n.__( "Show breadcrumbs under the title" ),
									'type': 'boolean',
								}, props
							),
							// Background image
							trx_addons_gutenberg_add_param(
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Background image' ),
									'descr': i18n.__( "Background image of the block" ),
									'type': 'image',
								}, props
							),
							// Post featured image
							trx_addons_gutenberg_add_param(
								{
									'name': 'use_featured_image',
									'title': i18n.__( 'Post featured image' ),
									'descr': i18n.__( "Use post's featured image as background of the block instead image above (if present)" ),
									'type': 'boolean',
								}, props
							),
							// Height of the block
							trx_addons_gutenberg_add_param(
								{
									'name': 'height',
									'title': i18n.__( 'Height of the block' ),
									'descr': i18n.__( "Specify height of this block. If empty - use default height" ),
									'type': 'text',
								}, props
							),
						),
						'additional_params': el(
							'div', {},
							// Hide on devices params
							trx_addons_gutenberg_add_param_hide( props, true ),
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
