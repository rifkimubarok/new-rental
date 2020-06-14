(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Super Title
	blocks.registerBlockType(
		'trx-addons/supertitle', {
			title: i18n.__( 'Super Title' ),
			description: i18n.__( "Insert 'Super Title' element" ),
			icon: 'editor-bold',
			category: 'trx-addons-blocks',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					icon_column: {
						type: 'number',
						default: 1
					},
					header_column: {
						type: 'number',
						default: 8
					},
					image: {
						type: 'number',
						default: 0
					},
					icon: {
						type: 'string',
						default: ''
					},
					icon_color: {
						type: 'string',
						default: ''
					},
					icon_bg_color: {
						type: 'string',
						default: ''
					},
					icon_size: {
						type: 'string',
						default: ''
					},
					image: {
						type: 'number',
						default: 0
					},
					image_url: {
						type: 'string',
						default: ''
					},
					items: {
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
							// Layout
							trx_addons_gutenberg_add_param(
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_supertitle'] )
								}, props
							),
							// Icon column size
							trx_addons_gutenberg_add_param(
								{
									'name': 'icon_column',
									'title': i18n.__( 'Icon column size' ),
									'descr': i18n.__( "Specify the width of the icon (left) column from 0 (no left column) to 6." ),
									'type': 'number',
									'min': 1,
									'max': 6
								}, props
							),
							// Left column size
							trx_addons_gutenberg_add_param(
								{
									'name': 'header_column',
									'title': i18n.__( 'Left column size' ),
									'descr': i18n.__( "Specify the width of the main (middle) column from 0 (no middle column) to 12. Attention! The sum of values for the two columns (Icon and Main) must not exceed 12." ),
									'type': 'number',
									'min': 1,
									'max': 12
								}, props
							),
							// Choose media
							trx_addons_gutenberg_add_param(
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Choose media' ),
									'descr': i18n.__( "Select or upload image or specify URL from other site to use it as icon" ),
									'type': 'image'
								}, props
							),
							// Icon
							trx_addons_gutenberg_add_param(
								{
									'name': 'icon',
									'title': i18n.__( 'Icon' ),
									'descr': i18n.__( "Select icon from library" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes()
								}, props
							),
							// Color
							trx_addons_gutenberg_add_param(
								{
									'name': 'icon_color',
									'title': i18n.__( 'Color' ),
									'descr': i18n.__( "Selected color will be applied to the Super Title icon or border (if no icon selected)" ),
									'type': 'color',
								}, props
							),
							// Background color
							trx_addons_gutenberg_add_param(
								{
									'name': 'icon_bg_color',
									'title': i18n.__( 'Background color' ),
									'descr': i18n.__( "Selected background color will be applied to the Super Title icon" ),
									'type': 'color',
								}, props
							),				
							// Icon size or image width
							trx_addons_gutenberg_add_param(
								{
									'name': 'icon_size',
									'title': i18n.__( 'Icon size or image width' ),
									'descr': i18n.__( "For example, use 14px or 1em." ),
									'type': 'text',
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
				props.attributes.items = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		}
	);

	// Register block Supertitle Item
	blocks.registerBlockType(
		'trx-addons/supertitle-item', {
			title: i18n.__( 'Super Title Item' ),
			description: i18n.__( "Select icons, specify title and/or description for each item" ),
			icon: 'editor-bold',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/supertitle'],
			attributes: {
				item_type: {
					type: 'string',
					default: 'text'
				},
				text: {
					type: 'string',
					default: ''
				},
				link: {
					type: 'string',
					default: ''
				},
				new_window: {
					type: 'boolean',
					default: false
				},
				tag: {
					type: 'string',
					default: ''
				},
				media: {
					type: 'number',
					default: 0
				},
				media_url: {
					type: 'string',
					default: ''
				},
				item_icon: {
					type: 'string',
					default: ''
				},
				size: {
					type: 'string',
					default: ''
				},
				float_position: {
					type: 'string',
					default: ''
				},
				align: {
					type: 'string',
					default: 'left'
				},
				inline: {
					type: 'boolean',
					default: false
				},
				color: {
					type: 'string',
					default: ''
				},
				color2: {
					type: 'string',
					default: ''
				},
				gradient_direction: {
					type: 'number',
					default: 0
				},
				className: {
					type: 'string',
					default: ''
				},
			},
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Title' ) + (props.attributes.item_type ? ': ' + props.attributes.item_type : ''),
						'general_params': el(
							'div', {},
							// Item Type
							trx_addons_gutenberg_add_param(
								{
									'name': 'item_type',
									'title': i18n.__( 'Item Type' ),
									'descr': i18n.__( "Select type of the item" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_supertitle_item_types'] )
								}, props
							),
							// Text
							trx_addons_gutenberg_add_param(
								{
									'name': 'text',
									'title': i18n.__( 'Text' ),
									'type': 'text',
									'dependency': {
										'item_type': ['text']
									}
								}, props
							),
							// Link text
							trx_addons_gutenberg_add_param(
								{
									'name': 'link',
									'title': i18n.__( 'Link text' ),
									'descr': i18n.__( "Specify link for the text" ),
									'type': 'text',
									'dependency': {
										'item_type': ['text']
									}
								}, props
							),
							// Open in the new tab
							trx_addons_gutenberg_add_param(
								{
									'name': 'new_window',
									'title': i18n.__( 'Open in the new tab' ),
									'descr': i18n.__( "Open this link in the new browser's tab" ),
									'type': 'boolean',
									'dependency': {
										'item_type': ['text']
									}
								}, props
							),
							// HTML Tag
							trx_addons_gutenberg_add_param(
								{
									'name': 'tag',
									'title': i18n.__( 'HTML Tag' ),
									'descr': i18n.__( "Select HTML wrapper of the item" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_title_tags'] ),
									'dependency': {
										'item_type': ['text']
									}
								}, props
							),
							// Choose media
							trx_addons_gutenberg_add_param(
								{
									'name': 'media',
									'name_url': 'media_url',
									'title': i18n.__( 'Choose media' ),
									'descr': i18n.__( "Select or upload image or specify URL from other site to use it as icon" ),
									'type': 'image',
									'dependency': {
										'item_type': ['media']
									}
								}, props
							),
							// Icon
							trx_addons_gutenberg_add_param(
								{
									'name': 'item_icon',
									'title': i18n.__( 'Icon' ),
									'descr': i18n.__( "Select icon from library" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes(),
									'dependency': {
										'item_type': ['icon']
									}
								}, props
							),							
							// Size
							trx_addons_gutenberg_add_param(
								{
									'name': 'size',
									'title': i18n.__( 'Size' ),
									'descr': i18n.__( "For example, use 14px or 1em." ),
									'type': 'text',
									'dependency': {
										'item_type': ['icon']
									}
								}, props
							),
							// Float
							trx_addons_gutenberg_add_param(
								{
									'name': 'float_position',
									'title': i18n.__( 'Position' ),
									'descr': i18n.__( "Select position of the item - in the left or right column" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] ),
									'dependency': {
										'item_type': ['icon', 'media']
									}
								}, props
							),
							// Alignment
							trx_addons_gutenberg_add_param(
								{
									'name': 'align',
									'title': i18n.__( 'Alignment' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists({
										'left': i18n.__( 'Left' ),
										'right': i18n.__( 'Right' ),
									})
								}, props
							),
							// Inline
							trx_addons_gutenberg_add_param(
								{
									'name': 'inline',
									'title': i18n.__( 'Inline' ),
									'descr': i18n.__( "Make it inline" ),
									'type': 'boolean',
								}, props
							),
							// Color
							trx_addons_gutenberg_add_param(
								{
									'name': 'color',
									'title': i18n.__( 'Color' ),
									'descr': i18n.__( "Selected color will also be applied to the subtitle" ),
									'type': 'color',
								}, props
							),
							// Color 2
							trx_addons_gutenberg_add_param(
								{
									'name': 'color2',
									'title': i18n.__( 'Color 2' ),
									'descr': i18n.__( "'If not empty - used for gradient." ),
									'type': 'color',
									'dependency': {
										'item_type': ['text']
									}
								}, props
							),
							// Gradient direction
							trx_addons_gutenberg_add_param(
								{
									'name': 'gradient_direction',
									'title': i18n.__( 'Gradient direction' ),
									'descr': i18n.__( "Gradient direction in degress (0 - 360)" ),
									'type': 'number',
									'min': 0,
									'max': 360,
									'step': 1
								}, props
							),
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
