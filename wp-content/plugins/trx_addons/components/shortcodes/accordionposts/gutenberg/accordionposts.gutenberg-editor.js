(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	var trx_addons_gutenberg_add_param_key = 0;

	// Register Block - Action
	blocks.registerBlockType(
		'trx-addons/accordionposts', {
			title: i18n.__( 'Accordion posts' ),
			description: i18n.__( "Accordion of posts" ),
			icon: 'excerpt-view',
			category: 'trx-addons-blocks',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					accordions: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					}
				},
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_accordionposts'] )
								}, props
							)
						),
						'additional_params': el( 'div', {},
							// ID, Class, CSS params
							trx_addons_gutenberg_add_param_id( props )
						)
					}, props
				);
			},
			save: function(props) {
				// Get child block values of attributes
				props.attributes.accordions = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		}
	);

	// Register block Accordionposts Item
	var first_page = trx_addons_array_first_key(TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_pages']),
		first_layout = trx_addons_array_first_key(TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_layouts']);
	blocks.registerBlockType(
		'trx-addons/accordionposts-item', {
			title: i18n.__( 'Accordion posts item' ),
			description: i18n.__( "Insert 'Accordion posts' item" ),
			icon: 'excerpt-view',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/accordionposts'],
			attributes: {
				// Accordion posts item attributes
				title: {
					type: 'string',
					default: i18n.__( "Item's title" )
				},
				subtitle: {
					type: 'string',
					default: i18n.__( 'Description' )
				},
				icon: {
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
				content_source: {
					type: 'string',
					default: 'text'
				},
				post_id: {
					type: 'string',
					default: first_page
				},
				layout_id: {
					type: 'string',
					default: first_layout
				},
				inner_content: {
					type: 'string',
					default: ''
				},
				advanced_rolled_content: {
					type: 'boolean',
					default: false
				},
				rolled_content: {
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
						'title': i18n.__( 'Accordion item' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el( 'div', {},
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'type': 'text'
								}, props
							),
							// Subtitle
							trx_addons_gutenberg_add_param(
								{
									'name': 'subtitle',
									'title': i18n.__( 'Subtitle' ),
									'type': 'text'
								}, props
							),
							// Icon
							trx_addons_gutenberg_add_param(
								{
									'name': 'icon',
									'title': i18n.__( 'Icon' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_option_icons_classes()
								}, props
							),
							// Icon Color
							trx_addons_gutenberg_add_param(
								{
									'name': 'color',
									'title': i18n.__( 'Icon Color' ),
									'descr': i18n.__( "Selected color will also be applied to the subtitle" ),
									'type': 'color'
								}, props
							),
							// Icon Background Color
							trx_addons_gutenberg_add_param(
								{
									'name': 'bg_color',
									'title': i18n.__( 'Icon Background Color' ),
									'descr': i18n.__( "Selected color will also be applied to the subtitle" ),
									'type': 'color'
								}, props
							),
							// Select content source
							trx_addons_gutenberg_add_param(
								{
									'name': 'content_source',
									'title': i18n.__( 'Select content source' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists({
										'text': i18n.__( 'Use content' ),
										'page': i18n.__( 'Pages' ),
										'layout': i18n.__( 'Layouts' ),
									})
								}, props
							),
							// Page ID
							trx_addons_gutenberg_add_param(
								{
									'name': 'post_id',
									'title': i18n.__( 'Page ID' ),
									'descr': i18n.__( "'Use Content' option allows you to create custom content for the selected content area, otherwise you will be prompted to choose an existing page to import content from it. " ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_pages'] ),
									'dependency': {
										'content_source': ['page']
									}
								}, props
							),
							// Layout ID
							trx_addons_gutenberg_add_param(
								{
									'name': 'layout_id',
									'title': i18n.__( 'Layout ID' ),
									'descr': i18n.__( "'Use Content' option allows you to create custom content for the selected content area, otherwise you will be prompted to choose an existing page to import content from it. " ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_layouts'] ),
									'dependency': {
										'content_source': ['layout']
									}
								}, props
							),
							// Inner content
							trx_addons_gutenberg_add_param(
								{
									'name': 'inner_content',
									'title': i18n.__( 'Inner content' ),
									'type': 'textarea',
									'dependency': {
										'content_source': ['text']
									}
								}, props
							),
							// Advanced Header Options
							trx_addons_gutenberg_add_param(
								{
									'name': 'advanced_rolled_content',
									'title': i18n.__( 'Advanced Header Options' ),
									'type': 'boolean'
								}, props
							),
							// Advanced Header Options
							trx_addons_gutenberg_add_param(
								{
									'name': 'rolled_content',
									'title': i18n.__( 'Advanced Header Options' ),
									'type': 'textarea',
									'dependency': {
										'advanced_rolled_content': [ true ]
									}
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
