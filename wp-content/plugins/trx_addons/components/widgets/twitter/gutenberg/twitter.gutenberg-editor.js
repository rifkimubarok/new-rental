(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Twitter
	blocks.registerBlockType(
		'trx-addons/twitter', {
			title: i18n.__( 'Widget: Twitter' ),
			icon: 'twitter',
			category: 'trx-addons-widgets',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'list'
					},
					title: {
						type: 'string',
						default: ''
					},
					count: {
						type: 'number',
						default: 2
					},
					columns: {
						type: 'number',
						default: 1
					},
					follow: {
						type: 'boolean',
						default: true
					},
					back_image: {
						type: 'number',
						default: 0
					},
					back_image_url: {
						type: 'string',
						default: ''
					},
					username: {
						type: 'string',
						default: ''
					},
					consumer_key: {
						type: 'string',
						default: ''
					},
					consumer_secret: {
						type: 'string',
						default: ''
					},
					token_key: {
						type: 'string',
						default: ''
					},
					token_secret: {
						type: 'string',
						default: ''
					},
				},
				trx_addons_gutenberg_get_param_slider(),
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_twitter'] )
								}, props
							),
							// Widget title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Widget title' ),
									'descr': i18n.__( "Title of the widget" ),
									'type': 'text'
								}, props
							),
							// Tweets number
							trx_addons_gutenberg_add_param(
								{
									'name': 'count',
									'title': i18n.__( 'Tweets number' ),
									'descr': i18n.__( "Tweets number to show in the feed" ),
									'type': 'number',
									'min': 1,
									'max': 20
								}, props
							),
							// Columns
							trx_addons_gutenberg_add_param(
								{
									'name': 'columns',
									'title': i18n.__( 'Columns' ),
									'descr': i18n.__( "Specify the number of columns. If left empty or assigned the value '0' - auto detect by the number of items." ),
									'type': 'number',
									'min': 1,
									'max': 4,
									'dependency': {
										'type': [ 'default' ]
									}
								}, props
							),
							// Show Follow Us
							trx_addons_gutenberg_add_param(
								{
									'name': 'follow',
									'title': i18n.__( 'Show Follow Us' ),
									'descr': i18n.__( "Do you want display Follow Us link below the feed?" ),
									'type': 'boolean'
								}, props
							),
							// Widget background
							trx_addons_gutenberg_add_param(
								{
									'name': 'back_image',
									'name_url': 'back_image_url',
									'title': i18n.__( 'Widget background' ),
									'descr': i18n.__( "Select or upload image or write URL from other site for use it as widget background" ),
									'type': 'image'
								}, props
							),
							// Twitter Username
							trx_addons_gutenberg_add_param(
								{
									'name': 'username',
									'title': i18n.__( 'Twitter Username' ),
									'type': 'text'
								}, props
							),
							// Consumer Key
							trx_addons_gutenberg_add_param(
								{
									'name': 'consumer_key',
									'title': i18n.__( 'Consumer Key' ),
									'descr': i18n.__( "Specify Consumer Key from Twitter application" ),
									'type': 'text'
								}, props
							),
							// Consumer Secret
							trx_addons_gutenberg_add_param(
								{
									'name': 'consumer_secret',
									'title': i18n.__( 'Consumer Secret' ),
									'descr': i18n.__( "Specify Consumer Secret from Twitter application" ),
									'type': 'text'
								}, props
							),
							// Token Key
							trx_addons_gutenberg_add_param(
								{
									'name': 'token_key',
									'title': i18n.__( 'Token Key' ),
									'descr': i18n.__( "Specify Token Key from Twitter applicationd" ),
									'type': 'text'
								}, props
							),
							// Token Secret
							trx_addons_gutenberg_add_param(
								{
									'name': 'token_secret',
									'title': i18n.__( 'Token Secret' ),
									'descr': i18n.__( "Select or upload image or write URL from other site for use it as widget background" ),
									'type': 'text'
								}, props
							),
						),
						'additional_params': el(
							'div', {},
							// Slider params
							trx_addons_gutenberg_add_param_slider( props ),
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
