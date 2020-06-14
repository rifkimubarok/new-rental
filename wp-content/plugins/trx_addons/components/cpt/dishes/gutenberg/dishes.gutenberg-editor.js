(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Dishes
	blocks.registerBlockType(
		'trx-addons/dishes', {
			title: i18n.__( 'Dishes' ),
			icon: 'carrot',
			category: 'trx-addons-cpt',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					pagination: {
						type: 'string',
						default: 'none'
					},
					more_text: {
						type: 'string',
						default: i18n.__( 'Read more' ),
					},
					featured_position: {
						type: 'string',
						default: 'top'
					},
					hide_excerpt: {
						type: 'boolean',
						default: false
					},
					popup: {
						type: 'boolean',
						default: false
					},
					cat: {
						type: 'string',
						default: '0'
					}
				},
				trx_addons_gutenberg_get_param_query(),
				trx_addons_gutenberg_get_param_slider(),
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
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
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['trx_sc_dishes'] )
								}, props
							),
							// Featured position
							trx_addons_gutenberg_add_param(
								{
									'name': 'featured_position',
									'title': i18n.__( 'Featured position' ),
									'descr': i18n.__( "Select the position of the featured element" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_dishes_positions'] )
								}, props
							),
							// 'More' text
							trx_addons_gutenberg_add_param(
								{
									'name': 'more_text',
									'title': i18n.__( "'More' text" ),
									'descr': i18n.__( "Specify caption of the 'Read more' button. If empty - hide button" ),
									'type': 'text',
								}, props
							),
							// Pagination
							trx_addons_gutenberg_add_param(
								{
									'name': 'pagination',
									'title': i18n.__( 'Pagination' ),
									'descr': i18n.__( "Add pagination links after posts. Attention! Pagination is not allowed if the slider layout is used." ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_paginations'] )
								}, props
							),
							// Excerpt
							trx_addons_gutenberg_add_param(
								{
									'name': 'hide_excerpt',
									'title': i18n.__( "Excerpt" ),
									'descr': i18n.__( "Toggle this option to hide the excerpt." ),
									'type': 'boolean',
								}, props
							),
							// Open in the popup
							trx_addons_gutenberg_add_param(
								{
									'name': 'popup',
									'title': i18n.__( "Open in the popup" ),
									'descr': i18n.__( "Open details in the popup or navigate to the single post (default)" ),
									'type': 'boolean',
								}, props
							),
							// Group
							trx_addons_gutenberg_add_param(
								{
									'name': 'cat',
									'title': i18n.__( "Group" ),
									'descr': i18n.__( "Dishes group" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_dishes_cat'] )
								}, props
							),				
						),
						'additional_params': el(
							'div', {},
							// Query params
							trx_addons_gutenberg_add_param_query( props ),
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
				return el( '', null );
			}
		}
	);
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element, );
