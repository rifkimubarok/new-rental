(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Contacts
	blocks.registerBlockType(
		'trx-addons/contacts', {
			title: i18n.__( 'Widget: Contacts' ),
			description: i18n.__( "Insert widget with logo, short description and contacts" ),
			icon: 'admin-home',
			category: 'trx-addons-widgets',
			attributes: trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: i18n.__( 'Contacts' )
					},
					logo: {
						type: 'number',
						default: 0
					},
					logo_url: {
						type: 'string',
						default: ''
					},
					logo_retina: {
						type: 'number',
						default: 0
					},
					description: {
						type: 'string',
						default: ''
					},
					googlemap: {
						type: 'boolean',
						default: false
					},
					googlemap_height: {
						type: 'number',
						default: 140
					},
					googlemap_position: {
						type: 'string',
						default: 'top'
					},
					address: {
						type: 'string',
						default: ''
					},
					phone: {
						type: 'string',
						default: ''
					},
					email: {
						type: 'string',
						default: ''
					},
					columns: {
						type: 'boolean',
						default: false
					},
					socials: {
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
							// Logo
							trx_addons_gutenberg_add_param(
								{
									'name': 'logo',
									'name_url': 'logo_url',
									'title': i18n.__( 'Logo' ),
									'descr': i18n.__( "Select or upload image or write URL from other site for site's logo." ),
									'type': 'image',
								}, props
							),
							// Logo Retina
							trx_addons_gutenberg_add_param(
								{
									'name': 'logo_retina',
									'name_url': 'logo_retina_url',
									'title': i18n.__( 'Logo Retina' ),
									'descr': i18n.__( "Select or upload image or write URL from other site: site's logo for the Retina display." ),
									'type': 'image',
								}, props
							),
							// Description
							trx_addons_gutenberg_add_param(
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'descr': i18n.__( "Short description about user. If empty - get description of the first registered blog user" ),
									'type': 'textarea',
								}, props
							),
							// Address
							trx_addons_gutenberg_add_param(
								{
									'name': 'address',
									'title': i18n.__( 'Address' ),
									'descr': i18n.__( "Address string. Use '|' to split this string on two parts" ),
									'type': 'text',
								}, props
							),
							// Phone
							trx_addons_gutenberg_add_param(
								{
									'name': 'phone',
									'title': i18n.__( 'Phone' ),
									'descr': i18n.__( "Your phone" ),
									'type': 'text',
								}, props
							),
							// E-mail
							trx_addons_gutenberg_add_param(
								{
									'name': 'email',
									'title': i18n.__( 'E-mail' ),
									'descr': i18n.__( "Your e-mail address" ),
									'type': 'text',
								}, props
							),
							// Break into columns
							trx_addons_gutenberg_add_param(
								{
									'name': 'columns',
									'title': i18n.__( 'Break into columns' ),
									'descr': i18n.__( "Break contact information into two columns with the address being displayed on the left hand side and phone/email - on the right." ),
									'type': 'boolean',
								}, props
							),
							// Show Googlemap
							trx_addons_gutenberg_add_param(
								{
									'name': 'googlemap',
									'title': i18n.__( 'Show Googlemap' ),
									'descr': i18n.__( "Do you want to display Google map with address above" ),
									'type': 'boolean',
								}, props
							),
							// Googlemap height
							trx_addons_gutenberg_add_param(
								{
									'name': 'googlemap_height',
									'title': i18n.__( 'Googlemap height' ),
									'descr': i18n.__( "Height of the Google map" ),
									'type': 'number',
									'min': 100,
									'dependency': {
										'googlemap': [true]
									}
								}, props
							),
							// Googlemap position
							trx_addons_gutenberg_add_param(
								{
									'name': 'googlemap_position',
									'title': i18n.__( 'Googlemap position' ),
									'descr': i18n.__( "Select position of the Google map" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists({
										'top': i18n.__( 'Top' ),
										'left': i18n.__( 'Left' ),
										'right': i18n.__( 'Right' ),
									}),
									'dependency': {
										'googlemap': [true]
									}
								}, props
							),
							// Show Social Icons
							trx_addons_gutenberg_add_param(
								{
									'name': 'socials',
									'title': i18n.__( 'Show Social Icons' ),
									'descr': i18n.__( "Do you want to display icons with links on your profiles in the Social networks?" ),
									'type': 'boolean'
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
