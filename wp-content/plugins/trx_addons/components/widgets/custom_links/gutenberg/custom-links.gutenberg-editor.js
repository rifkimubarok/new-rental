(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Custom Links
	blocks.registerBlockType(
		'trx-addons/custom-links', {
			title: i18n.__( 'Widget: Custom Links' ),
			description: i18n.__( "Insert widget with list of the custom links" ),
			icon: 'admin-links',
			category: 'trx-addons-widgets',
			attributes: trx_addons_object_merge(
				{				
					title: {
						type: 'string',
						default: i18n.__( 'Custom Links' )
					},
					icons_animation: {
						type: 'boolean',
						default: false
					},			
					links: {
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
							// Widget title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Widget title' ),
									'descr': i18n.__( "Title of the widget" ),
									'type': 'text',
								}, props
							),
							// Animation
							trx_addons_gutenberg_add_param(
								{
									'name': 'icons_animation',
									'title': i18n.__( 'Animation' ),
									'descr': i18n.__( "Toggle on if you want to animate icons. Attention! Animation is enabled only if there is an .SVG  icon in your theme with the same name as the selected icon." ),
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
				// Get child block values of attributes
				props.attributes.links = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		}
	);

	// Register block Custom Link
	blocks.registerBlockType(
		'trx-addons/custom-links-item', {
			title: i18n.__( 'Custom Link' ),
			description: i18n.__( "Insert 'Custom Link'" ),
			icon:  'admin-links',
			category: 'trx-addons-widgets',
			parent: ['trx-addons/custom-links'],
			attributes: {
				title: {
					type: 'string',
					default: i18n.__( 'One' )
				},
				url: {
					type: 'string',
					default: ''
				},
				caption: {
					type: 'string',
					default: ''
				},
				color: {
					type: 'string',
					default: ''
				},
				label: {
					type: 'string',
					default: ''
				},
				label_bg_color: {
					type: 'string',
					default: ''
				},
				label_on_hover: {
					type: 'boolean',
					default: false
				},
				image: {
					type: 'number',
					default: 0
				},
				image_url: {
					type: 'string',
					default: ''
				},
				new_window: {
					type: 'boolean',
					default: false
				},
				icon: {
					type: 'string',
					default: ''
				},
				description: {
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
						'title': i18n.__( 'Custom Link' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {},
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Enter title of the item" ),
									'type': 'text'
								}, props
							),
							// Link URL
							trx_addons_gutenberg_add_param(
								{
									'name': 'url',
									'title': i18n.__( 'Link URL' ),
									'descr': i18n.__( "URL to link this item" ),
									'type': 'text'
								}, props
							),
							// Caption
							trx_addons_gutenberg_add_param(
								{
									'name': 'caption',
									'title': i18n.__( 'Caption' ),
									'descr': i18n.__( "Caption to create button. If empty - the button is not displayed" ),
									'type': 'text'
								}, props
							),
							// Color
							trx_addons_gutenberg_add_param(
								{
									'name': 'color',
									'title': i18n.__( 'Link color' ),
									'descr': i18n.__( "Select new color of this link. If empty - default theme color is used" ),
									'type': 'color'
								}, props
							),
							// Label
							trx_addons_gutenberg_add_param(
								{
									'name': 'label',
									'title': i18n.__( 'Label' ),
									'descr': i18n.__( "Text of the label. If empty - the label is not displayed" ),
									'type': 'text'
								}, props
							),
							// Label bg color
							trx_addons_gutenberg_add_param(
								{
									'name': 'label_bg_color',
									'title': i18n.__( 'Label bg color' ),
									'descr': i18n.__( "Select background color of the label" ),
									'type': 'color'
								}, props
							),
							// Show label on hover
							trx_addons_gutenberg_add_param(
								{
									'name': 'label_on_hover',
									'title': i18n.__( 'Show label on hover' ),
									'descr': i18n.__( "Check if you want show label on the item is hovered" ),
									'type': 'boolean'
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
							// Open link in a new window
							trx_addons_gutenberg_add_param(
								{
									'name': 'new_window',
									'title': i18n.__( 'Open link in a new window' ),
									'descr': i18n.__( "Check if you want open this link in a new window (tab)" ),
									'type': 'boolean'
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
							// Description
							trx_addons_gutenberg_add_param(
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'descr': i18n.__( "Enter short description for this item" ),
									'type': 'textarea'
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
