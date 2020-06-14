(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Instagram feed
	blocks.registerBlockType(
		'trx-addons/instagram', {
			title: i18n.__( 'Widget: Instagram' ),
			description: i18n.__( "Display the latest photos from instagram account by hashtag" ),
			icon: 'images-alt2',
			category: 'trx-addons-widgets',
			attributes: trx_addons_object_merge(
				{				
					title: {
						type: 'string',
						default: i18n.__( 'Instagram feed' )
					},
					count: {
						type: 'number',
						default: 8
					},
					columns: {
						type: 'number',
						default: 4
					},
					columns_gap: {
						type: 'number',
						default: 0
					},
					hashtag: {
						type: 'string',
						default: ''
					},
					links: {
						type: 'string',
						default: 'instagram'
					},
					follow: {
						type: 'boolean',
						default: false
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
							// Widget title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Widget title' ),
									'descr': i18n.__( "Title of the widget" ),
									'type': 'text',
								}, props
							),
							// Hashtag
							trx_addons_gutenberg_add_param(
								{
									'name': 'hashtag',
									'title': i18n.__( 'Hashtag or Username' ),
									'descr': i18n.__( "Hashtag (start with #) or Username to filter your photos" ),
									'type': 'text',
								}, props
							),
							// Number of photos
							trx_addons_gutenberg_add_param(
								{
									'name': 'count',
									'title': i18n.__( 'Number of photos' ),
									'descr': i18n.__( "How many photos to be displayed?" ),
									'type': 'number',
									'min': 1
								}, props
							),
							// Columns
							trx_addons_gutenberg_add_param(
								{
									'name': 'columns',
									'title': i18n.__( 'Columns' ),
									'descr': i18n.__( "Columns number" ),
									'type': 'number',
									'min': 1
								}, props
							),
							// Columns gap
							trx_addons_gutenberg_add_param(
								{
									'name': 'columns_gap',
									'title': i18n.__( 'Columns gap' ),
									'descr': i18n.__( "Gap between images" ),
									'type': 'number',
									'min': 0
								}, props
							),
							// Link images to
							trx_addons_gutenberg_add_param(
								{
									'name': 'links',
									'title': i18n.__( 'Link images to' ),
									'descr': i18n.__( "Where to send a visitor after clicking on the picture" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_instagram_redirects'] )
								}, props
							),
							// Show button "Follow me"
							trx_addons_gutenberg_add_param(
								{
									'name': 'follow',
									'title': i18n.__( 'Show button "Follow me"' ),
									'descr': i18n.__( 'Add button "Follow me" after images' ),
									'type': 'boolean',
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
