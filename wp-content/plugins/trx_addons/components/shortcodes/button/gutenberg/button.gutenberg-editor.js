(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Button
	blocks.registerBlockType(
		'trx-addons/button', {
			title: i18n.__( 'Buttons' ),
			description: i18n.__( "Insert set of buttons" ),
			icon: 'video-alt3',
			category: 'trx-addons-blocks',
			attributes: trx_addons_object_merge(
				{
					// Button attributes
					align: {
						type: 'string',
						default: 'none'
					},
					buttons: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					},
				},
				trx_addons_gutenberg_get_param_id()
			),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'render_button': true,
						'parent': true,
						'general_params': el(
							'div', {},
							// Button alignment
							trx_addons_gutenberg_add_param(
								{
									'name': 'align',
									'title': i18n.__( 'Button alignment' ),
									'descr': i18n.__( "Select button alignment" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
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
				// Get child block values of attributes
				props.attributes.buttons = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		}
	);

	// Register block Button Item
	blocks.registerBlockType(
		'trx-addons/button-item', {
			title: i18n.__( 'Single button' ),
			description: i18n.__( "Insert single button" ),
			icon: 'video-alt3',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/button'],
			attributes: {
				// Button attributes
				type: {
					type: 'string',
					default: 'default'
				},
				size: {
					type: 'string',
					default: 'normal'
				},
				link: {
					type: 'string',
					default: '#'
				},
				new_window: {
					type: 'boolean',
					default: false
				},
				title: {
					type: 'string',
					default: i18n.__( "Button" )
				},
				subtitle: {
					type: 'string',
					default: ''
				},
				text_align: {
					type: 'string',
					default: 'none'
				},
				back_image: {
					type: 'number',
					default: 0
				},
				back_image_url: {
					type: 'string',
					default: ''
				},
				icon: {
					type: 'string',
					default: ''
				},
				icon_position: {
					type: 'string',
					default: 'left'
				},
				image: {
					type: 'number',
					default: 0
				},
				image_url: {
					type: 'string',
					default: ''
				},
				// ID, Class, CSS attributes
				item_id: {	// 'id' not work in Elementor
					type: 'string',
					default: ''
				},
				class: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				},
				css: {
					type: 'string',
					default: ''
				},
			},
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Button' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {},
							// Layout
							trx_addons_gutenberg_add_param(
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_button'] )
								}, props
							),
							// Size
							trx_addons_gutenberg_add_param(
								{
									'name': 'size',
									'title': i18n.__( 'Size' ),
									'descr': i18n.__( "Size of the button" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_button_sizes'] )
								}, props
							),
							// Button URL
							trx_addons_gutenberg_add_param(
								{
									'name': 'link',
									'title': i18n.__( 'Button URL' ),
									'descr': i18n.__( "Link URL for the button" ),
									'type': 'text'
								}, props
							),
							// Open in the new tab
							trx_addons_gutenberg_add_param(
								{
									'name': 'new_window',
									'title': i18n.__( 'Open in the new tab' ),
									'descr': i18n.__( "Open this link in the new browser's tab" ),
									'type': 'boolean'
								}, props
							),
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Title of the button" ),
									'type': 'text'
								}, props
							),
							// Subtitle
							trx_addons_gutenberg_add_param(
								{
									'name': 'subtitle',
									'title': i18n.__( 'Subtitle' ),
									'descr': i18n.__( "Subtitle for the button" ),
									'type': 'text'
								}, props
							),
							// Text alignment
							trx_addons_gutenberg_add_param(
								{
									'name': 'text_align',
									'title': i18n.__( 'Text alignment' ),
									'descr': i18n.__( "Select text alignment" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
								}, props
							),
							// Button's background image
							trx_addons_gutenberg_add_param(
								{
									'name': 'back_image',
									'name_url': 'back_image_url',
									'title': i18n.__( "Button's background image" ),
									'descr': i18n.__( "Select the image from the library for this button's background" ),
									'type': 'image'
								}, props
							),
							// Icon
							trx_addons_gutenberg_add_param(
								{
									'name': 'icon',
									'title': i18n.__( "Icon" ),
									'descr': i18n.__( "Select icon from library" ),
									'type': 'select',									
									'options': trx_addons_gutenberg_get_option_icons_classes()
								}, props
							),
							// Icon position
							trx_addons_gutenberg_add_param(
								{
									'name': 'icon_position',
									'title': i18n.__( "Icon position" ),
									'descr': i18n.__( "Place the icon (image) to the left or to the right or to the top side of the button" ),
									'type': 'select',									
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_icon_positions'] )
								}, props
							),
							// or select an image
							trx_addons_gutenberg_add_param(
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( "or select an image" ),
									'descr': i18n.__( "Select the image instead the icon (if need)" ),
									'type': 'image'
								}, props
							)
						),
						'additional_params': el(
							'div', {},
							// ID, Class, CSS params
							trx_addons_gutenberg_add_param_id( props, 'item_id' )
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
