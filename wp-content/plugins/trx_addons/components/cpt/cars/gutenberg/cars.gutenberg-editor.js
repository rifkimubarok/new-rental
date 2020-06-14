(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Cars
	blocks.registerBlockType(
		'trx-addons/cars', {
			title: i18n.__( 'Cars' ),
			icon: 'format-aside',
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
					cars_type: {
						type: 'string',
						default: '0'
					},
					cars_maker: {
						type: 'string',
						default: '0'
					},
					cars_model: {
						type: 'string',
						default: '0'
					},
					cars_status: {
						type: 'string',
						default: '0'
					},
					cars_labels: {
						type: 'string',
						default: '0'
					},
					cars_city: {
						type: 'string',
						default: '0'
					},
					cars_transmission: {
						type: 'string',
						default: ''
					},
					cars_type_drive: {
						type: 'string',
						default: ''
					},
					cars_fuel: {
						type: 'string',
						default: ''
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['trx_sc_cars'] )
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
							// 'More' text
							trx_addons_gutenberg_add_param(
								{
									'name': 'more_text',
									'title': i18n.__( "'More' text" ),
									'descr': i18n.__( "Specify caption of the 'Read more' button. If empty - hide button" ),
									'type': 'text',
								}, props
							),
							// Type
							trx_addons_gutenberg_add_param(
								{
									'name': 'cars_type',
									'title': i18n.__( 'Type' ),
									'descr': i18n.__( "Select the type to show cars that have it!" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_cars_type'] )
								}, props
							),
							// Manufacturer
							trx_addons_gutenberg_add_param(
								{
									'name': 'cars_maker',
									'title': i18n.__( 'Manufacturer' ),
									'descr': i18n.__( "Select the car's manufacturer" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_cars_maker'] )
								}, props
							),
							// Model
							trx_addons_gutenberg_add_param(
								{
									'name': 'cars_model',
									'title': i18n.__( 'Model' ),
									'descr': i18n.__( "Select the car's model" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_cars_model'] )
								}, props
							),
							// Status
							trx_addons_gutenberg_add_param(
								{
									'name': 'cars_status',
									'title': i18n.__( 'Status' ),
									'descr': i18n.__( "Select the status to show cars that have it" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_cars_status'] )
								}, props
							),
							// Label
							trx_addons_gutenberg_add_param(
								{
									'name': 'cars_labels',
									'title': i18n.__( 'Label' ),
									'descr': i18n.__( "Select the label to show cars that have it" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_cars_labels'] )
								}, props
							),
							// City
							trx_addons_gutenberg_add_param(
								{
									'name': 'cars_city',
									'title': i18n.__( 'City' ),
									'descr': i18n.__( "Select the city to show cars from it" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_cars_city'] )
								}, props
							),
							// Transmission
							trx_addons_gutenberg_add_param(
								{
									'name': 'cars_transmission',
									'title': i18n.__( 'Transmission' ),
									'descr': i18n.__( "Select type of the transmission" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_cars_transmission'] )
								}, props
							),
							// Type of drive
							trx_addons_gutenberg_add_param(
								{
									'name': 'cars_type_drive',
									'title': i18n.__( 'Type of drive' ),
									'descr': i18n.__( "Select type of drive" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_cars_type_drive'] )
								}, props
							),
							// Fuel
							trx_addons_gutenberg_add_param(
								{
									'name': 'cars_fuel',
									'title': i18n.__( 'Fuel' ),
									'descr': i18n.__( "Select type of the fuel" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_cars_fuel'] )
								}, props
							),							
						),
						'additional_params': el(
							'div', {},
							// Query params
							trx_addons_gutenberg_add_param_query( props ),
							// Title & Button params
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
