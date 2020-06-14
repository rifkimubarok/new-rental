(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Menu
	blocks.registerBlockType(
		'trx-addons/layouts-menu', {
			title: i18n.__( 'Menu' ),
			description: i18n.__( 'Insert any menu to the custom layout' ),
			icon: 'menu',
			category: 'trx-addons-layouts',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					direction: {
						type: 'string',
						default: 'horizontal'
					},
					location: {
						type: 'string',
						default: 'menu_main'
					},
					menu: {
						type: 'string',
						default: ''
					},
					mobile_menu: {
						type: 'boolean',
						default: false
					},
					mobile_button: {
						type: 'boolean',
						default: false
					},
					animation_in: {
						type: 'string',
						default: ''
					},
					animation_out: {
						type: 'string',
						default: ''
					},
					hover: {
						type: 'string',
						default: 'fade'
					},
					hide_on_mobile: {
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
							// Layout
							trx_addons_gutenberg_add_param(
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select layout's type" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_menu'] ),
								}, props
							),
							// Direction
							trx_addons_gutenberg_add_param(
								{
									'name': 'direction',
									'title': i18n.__( 'Direction' ),
									'descr': i18n.__( "Select direction of the menu items" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_directions'] ),
									'dependency': {
										'type': ['default']
									}
								}, props
							),
							// Location
							trx_addons_gutenberg_add_param(
								{
									'name': 'location',
									'title': i18n.__( 'Location' ),
									'descr': i18n.__( "Select menu location to insert to the layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['menu_locations'] ),
								}, props
							),
							// Menu
							trx_addons_gutenberg_add_param(
								{
									'name': 'menu',
									'title': i18n.__( 'Menu' ),
									'descr': i18n.__( "Select menu to insert to the layout. If empty - use menu assigned in the field 'Location'" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['menus'] ),
									'dependency': {
										'location': ['none']
									}
								}, props
							),
							// Hover
							trx_addons_gutenberg_add_param(
								{
									'name': 'hover',
									'title': i18n.__( 'Hover' ),
									'descr': i18n.__( "Select the menu items hover" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['menu_hover'] ),
									'dependency': {
										'type': ['default']
									}
								}, props
							),
							// Submenu animation in
							trx_addons_gutenberg_add_param(
								{
									'name': 'animation_in',
									'title': i18n.__( 'Submenu animation in' ),
									'descr': i18n.__( "Select animation to show submenu" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['animations_in'] ),
									'dependency': {
										'type': ['default']
									}
								}, props
							),
							// Submenu animation out
							trx_addons_gutenberg_add_param(
								{
									'name': 'animation_out',
									'title': i18n.__( 'Submenu animation out' ),
									'descr': i18n.__( "Select animation to hide submenu" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['animations_out'] ),
									'dependency': {
										'type': ['default']
									}
								}, props
							),
							// Mobile button
							trx_addons_gutenberg_add_param(
								{
									'name': 'mobile_button',
									'title': i18n.__( 'Mobile button' ),
									'descr': i18n.__( "Replace the menu with a menu button on mobile devices. Open the menu when the button is clicked." ),
									'type': 'boolean',
								}, props
							),
							// Add to the mobile menu
							trx_addons_gutenberg_add_param(
								{
									'name': 'mobile_menu',
									'title': i18n.__( 'Add to the mobile menu' ),
									'descr': i18n.__( "Use these menu items as a mobile menu (if mobile menu is not selected in the theme)." ),
									'type': 'boolean',
								}, props
							),
							// Hide on mobile devices
							trx_addons_gutenberg_add_param(
								{
									'name': 'hide_on_mobile',
									'title': i18n.__( 'Hide on mobile devices' ),
									'descr': i18n.__( "Hide this item on mobile devices" ),
									'type': 'boolean',
									'dependency': {
										'type': ['default']
									}
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