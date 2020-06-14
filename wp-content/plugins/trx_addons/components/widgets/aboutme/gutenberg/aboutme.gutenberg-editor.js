(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - About me
	blocks.registerBlockType(
		'trx-addons/aboutme', {
			title: i18n.__( 'Widget: About me' ),
			description: i18n.__( "About me - photo and short description about the blog author" ),
			icon: 'admin-users',
			category: 'trx-addons-widgets',
			attributes: trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: i18n.__( 'About me' )
					},
					avatar: {
						type: 'number',
						default: 0
					},
					avatar_url: {
						type: 'string',
						default: ''
					},
					username: {
						type: 'string',
						default: ''
					},
					description: {
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
							// Widget title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Widget title' ),
									'type': 'text'
								}, props
							),
							// Avatar
							trx_addons_gutenberg_add_param(
								{
									'name': 'avatar',
									'name_url': 'avatar_url',
									'title': i18n.__( 'Avatar' ),
									'descr': i18n.__( 'Avatar (if empty - get gravatar by admin email)' ),
									'type': 'image'
								}, props
							),
							// User name
							trx_addons_gutenberg_add_param(
								{
									'name': 'username',
									'title': i18n.__( 'User name' ),
									'descr': i18n.__( 'User name (if equal to # - not show)' ),
									'type': 'text'
								}, props
							),
							// Description
							trx_addons_gutenberg_add_param(
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'descr': i18n.__( 'Short description about user (if equal to # - not show)' ),
									'type': 'textarea'
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
