(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Login link
	blocks.registerBlockType(
		'trx-addons/layouts-login', {
			title: i18n.__( 'Login link' ),
			description: i18n.__( 'Insert Login/Logout link to the custom layout' ),
			icon: 'admin-users',
			category: 'trx-addons-layouts',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					user_menu: {
						type: 'boolean',
						default: false
					},
					text_login: {
						type: 'string',
						default: ''
					},
					text_logout: {
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_login'] ),
								}, props
							),
							// User menu
							trx_addons_gutenberg_add_param(
								{
									'name': 'user_menu',
									'title': i18n.__( 'User menu' ),
									'descr': i18n.__( "Show user menu on mouse hover" ),
									'type': 'boolean',
								}, props
							),
							// Login text
							trx_addons_gutenberg_add_param(
								{
									'name': 'text_login',
									'title': i18n.__( 'Login text' ),
									'descr': i18n.__( "Text of the Login link" ),
									'type': 'text',
								}, props
							),
							// Logout text
							trx_addons_gutenberg_add_param(
								{
									'name': 'text_logout',
									'title': i18n.__( 'Logout text' ),
									'descr': i18n.__( "Text of the Logout link" ),
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