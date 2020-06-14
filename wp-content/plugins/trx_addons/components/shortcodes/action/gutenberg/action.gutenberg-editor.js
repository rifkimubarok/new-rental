(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Action
	blocks.registerBlockType(
		'trx-addons/action', {
			title: i18n.__( 'Action' ),
			description: i18n.__( "Insert 'Call to action' or custom Events as slider or columns layout" ),
			icon: 'align-right',
			category: 'trx-addons-blocks',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					columns: {
						type: 'number',
						default: 1
					},
					full_height: {
						type: 'boolean',
						default: false
					},
					actions: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					},
				},
				trx_addons_gutenberg_get_param_slider(),
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
				trx_addons_gutenberg_get_param_id()
			),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'render_button': true,
						'parent': true,
						'general_params': el( 'div', {},
							// Layout
							trx_addons_gutenberg_add_param(
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_action'] )
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
									'max': 4
								}, props
							),
							// Full Height
							trx_addons_gutenberg_add_param(
								{
									'name': 'full_height',
									'title': i18n.__( 'Full Height' ),
									'descr': i18n.__( "Stretch the height of the element to the full screen's height" ),
									'type': 'boolean'
								}, props
							)
						),
						'additional_params': el( 'div', {},
							// Title params
							trx_addons_gutenberg_add_param_title( props, true ),
							// Slider params
							trx_addons_gutenberg_add_param_slider( props ),
							// ID, Class, CSS params
							trx_addons_gutenberg_add_param_id( props )
						)
					}, props
				);
			},
			save: function(props) {
				// Get child block values of attributes
				props.attributes.actions = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		}
	);

	// Register block Action Item
	blocks.registerBlockType(
		'trx-addons/action-item', {
			title: i18n.__( 'Action Item' ),
			description: i18n.__( "Insert 'Call to action' item" ),
			icon: 'align-right',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/action'],
			attributes: {
				// Action Item attributes
				position: {
					type: 'string',
					default: 'mc'
				},
				title: {
					type: 'string',
					default: i18n.__( 'One' )
				},
				subtitle: {
					type: 'string',
					default: ''
				},
				date: {
					type: 'string',
					default: ''
				},
				info: {
					type: 'string',
					default: ''
				},
				description: {
					type: 'string',
					default: ''
				},
				link: {
					type: 'string',
					default: ''
				},
				link_text: {
					type: 'string',
					default: ''
				},
				color: {
					type: 'string',
					default: ''
				},
				bg_color: {
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
				bg_image: {
					type: 'number',
					default: 0
				},
				bg_image_url: {
					type: 'string',
					default: ''
				},
				height: {
					type: 'string',
					default: ''
				},
				icon: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				},
			},
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Action item' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el( 'div', {},
							// Position
							trx_addons_gutenberg_add_param(
								{
									'name': 'position',
									'title': i18n.__( 'Position' ),
									'descr': i18n.__( "Text position inside item" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_positions'] )
								}, props
							),
							// Height
							trx_addons_gutenberg_add_param(
								{
									'name': 'height',
									'title': i18n.__( 'Height' ),
									'descr': i18n.__( "Height of the block" ),
									'type': 'text'
								}, props
							),
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Enter title of the item" ),
									'type': 'text'
								}, props
							),
							// Subtitle
							trx_addons_gutenberg_add_param(
								{
									'name': 'subtitle',
									'title': i18n.__( 'Subtitle' ),
									'descr': i18n.__( "Enter subtitle of the item" ),
									'type': 'text'
								}, props
							),
							// Date
							trx_addons_gutenberg_add_param(
								{
									'name': 'date',
									'title': i18n.__( 'Date' ),
									'descr': i18n.__( "Specify date (and/or time) of this event" ),
									'type': 'text'
								}, props
							),
							// Brief info
							trx_addons_gutenberg_add_param(
								{
									'name': 'info',
									'title': i18n.__( 'Brief info' ),
									'descr': i18n.__( "Additional info for this item" ),
									'type': 'text'
								}, props
							),
							// Description
							trx_addons_gutenberg_add_param(
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'descr': i18n.__( "Enter short description of the item" ),
									'type': 'textarea'
								}, props
							),
							// Link
							trx_addons_gutenberg_add_param(
								{
									'name': 'link',
									'title': i18n.__( 'Link' ),
									'descr': i18n.__( "URL to link this item" ),
									'type': 'text'
								}, props
							),
							// Link Text
							trx_addons_gutenberg_add_param(
								{
									'name': 'link_text',
									'title': i18n.__( 'Link Text' ),
									'descr': i18n.__( "Caption of the link" ),
									'type': 'text'
								}, props
							),
							// Color
							trx_addons_gutenberg_add_param(
								{
									'name': 'color',
									'title': i18n.__( 'Color' ),
									'descr': i18n.__( "Select custom color of this item" ),
									'type': 'color'
								}, props
							),
							// Background Color
							trx_addons_gutenberg_add_param(
								{
									'name': 'bg_color',
									'title': i18n.__( 'Background color' ),
									'descr': i18n.__( "Select custom background color of this item" ),
									'type': 'color'
								}, props
							),
							// Image
							trx_addons_gutenberg_add_param(
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Image' ),
									'descr': i18n.__( "Select or upload image or specify URL from other site to use it as icon" ),
									'type': 'image'
								}, props
							),
							// Background Image
							trx_addons_gutenberg_add_param(
								{
									'name': 'bg_image',
									'name_url': 'bg_image_url',
									'title': i18n.__( 'Background image' ),
									'descr': i18n.__( "Select or upload image or specify URL from other site to use it as background of this item" ),
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
							)
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
