(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Skills
	blocks.registerBlockType(
		'trx-addons/skills', {
			title: i18n.__( 'Skills' ),
			description: i18n.__( "Skill counters and pie charts" ),
			icon: 'awards',
			category: 'trx-addons-blocks',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'counter'
					},
					cutout: {
						type: 'number',
						default: 92
					},
					compact: {
						type: 'boolean',
						default: false
					},
					color: {
						type: 'string',
						default: ''
					},
					back_color: {
						type: 'string',
						default: ''
					},
					border_color: {
						type: 'string',
						default: ''
					},
					max: {
						type: 'number',
						default: 100
					},
					columns: {
						type: 'number',
						default: 1
					},
					values: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					},
				},
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
						'general_params': el(
							'div', {},
							// Layout
							trx_addons_gutenberg_add_param(
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_skills'] )
								}, props
							),
							// Cutout
							trx_addons_gutenberg_add_param(
								{
									'name': 'cutout',
									'title': i18n.__( 'Cutout' ),
									'descr': i18n.__( "Specify the pie cutout radius. Border width = 100% - cutout value." ),
									'type': 'number',
									'min': 0,
									'max': 100,
									'dependency': {
										'type': ['pie']
									}
								}, props
							),
							// Compact pie
							trx_addons_gutenberg_add_param(
								{
									'name': 'compact',
									'title': i18n.__( 'Compact pie' ),
									'descr': i18n.__( "SShow all values in one pie or each value in the single pie" ),
									'type': 'boolean',
									'dependency': {
										'type': ['pie']
									}
								}, props
							),
							// Color
							trx_addons_gutenberg_add_param(
								{
									'name': 'color',
									'title': i18n.__( 'Color' ),
									'descr': i18n.__( "Select custom color to fill each item" ),
									'type': 'color',
								}, props
							),
							// Background color
							trx_addons_gutenberg_add_param(
								{
									'name': 'back_color',
									'title': i18n.__( 'Background color' ),
									'descr': i18n.__( "Select custom color for item's background" ),
									'type': 'color',
									'dependency': {
										'type': ['pie']
									}
								}, props
							),
							// Border color
							trx_addons_gutenberg_add_param(
								{
									'name': 'border_color',
									'title': i18n.__( 'Border color' ),
									'descr': i18n.__( "Select custom color for item's border" ),
									'type': 'color',
									'dependency': {
										'type': ['pie']
									}
								}, props
							),
							// Max. value
							trx_addons_gutenberg_add_param(
								{
									'name': 'max',
									'title': i18n.__( 'Max. value' ),
									'descr': i18n.__( "Enter max value for all items" ),
									'type': 'number'
								}, props
							),
							// Columns
							trx_addons_gutenberg_add_param(
								{
									'name': 'columns',
									'title': i18n.__( 'Columns' ),
									'descr': i18n.__( "Specify the number of columns. If left empty or assigned the value '0' - auto detect by the number of items." ),
									'type': 'number'
								}, props
							),
						),
						'additional_params': el(
							'div', {},
							// Title params
							trx_addons_gutenberg_add_param_title( props, true ),
							// ID, Class, CSS params
							trx_addons_gutenberg_add_param_id( props )
						)
					}, props
				);
			},
			save: function(props) {
				// Get child block values of attributes
				props.attributes.values = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		}
	);

	// Register block Skills Item
	blocks.registerBlockType(
		'trx-addons/skills-item', {
			title: i18n.__( 'Skills Item' ),
			description: i18n.__( "Specify values for each counter" ),
			icon: 'awards',
			category: 'trx-addons-blocks',
			parent: ['trx-addons/skills'],
			attributes: {
				title: {
					type: 'string',
					default: i18n.__( 'One' )
				},
				color: {
					type: 'string',
					default: ''
				},
				value: {
					type: 'number',
					default: 0
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
						'title': i18n.__( 'Skills item' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
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
							// Color
							trx_addons_gutenberg_add_param(
								{
									'name': 'color',
									'title': i18n.__( 'Color' ),
									'descr': i18n.__( "Select custom color of this item" ),
									'type': 'color'
								}, props
							),
							// Value
							trx_addons_gutenberg_add_param(
								{
									'name': 'value',
									'title': i18n.__( 'Value' ),
									'descr': i18n.__( "Enter value of this item" ),
									'type': 'number',
									'min': 0
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
