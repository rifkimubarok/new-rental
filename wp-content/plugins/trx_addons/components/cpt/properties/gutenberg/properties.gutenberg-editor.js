(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Properties
	blocks.registerBlockType(
		'trx-addons/properties', {
			title: i18n.__( 'Properties' ),
			icon: 'admin-multisite',
			category: 'trx-addons-cpt',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					more_text: {
						type: 'string',
						default: i18n.__( 'Read more' ),
					},
					pagination: {
						type: 'string',
						default: 'none'
					},
					map_height: {
						type: 'number',
						default: 350
					},
					properties_type: {
						type: 'string',
						default: '0'
					},
					properties_status: {
						type: 'string',
						default: '0'
					},
					properties_labels: {
						type: 'string',
						default: '0'
					},
					properties_country: {
						type: 'string',
						default: '0'
					},
					properties_city: {
						type: 'string',
						default: '0'
					},
					properties_neighborhood: {
						type: 'string',
						default: '0'
					},
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
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['trx_sc_properties'] )
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
							//  Map height
							trx_addons_gutenberg_add_param(
								{
									'name': 'map_height',
									'title': i18n.__( "Map height" ),
									'descr': i18n.__( "Specify height of the map with properties" ),
									'type': 'number',
									'min': 100,
									'dependency': {
										'type': ['map']
									}
								}, props
							),
							// Type
							trx_addons_gutenberg_add_param(
								{
									'name': 'properties_type',
									'title': i18n.__( 'Type' ),
									'descr': i18n.__( "Select the type to show properties that have it!" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_properties_type'] )
								}, props
							),
							// Status
							trx_addons_gutenberg_add_param(
								{
									'name': 'properties_status',
									'title': i18n.__( 'Status' ),
									'descr': i18n.__( "Select the status to show properties that have it" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_properties_status'] )
								}, props
							),
							// Label
							trx_addons_gutenberg_add_param(
								{
									'name': 'properties_labels',
									'title': i18n.__( 'Label' ),
									'descr': i18n.__( "Select the label to show properties that have it" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_properties_labels'] )
								}, props
							),
							// Country
							trx_addons_gutenberg_add_param(
								{
									'name': 'properties_country',
									'title': i18n.__( 'Country' ),
									'descr': i18n.__( "Select the country to show properties from" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_properties_country'] )
								}, props
							),
							// State
							trx_addons_gutenberg_add_param(
								{
									'name': 'properties_state',
									'title': i18n.__( 'State' ),
									'descr': i18n.__( "Select the county/state to show properties from" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_properties_states'] )
								}, props
							),
							// City
							trx_addons_gutenberg_add_param(
								{
									'name': 'properties_city',
									'title': i18n.__( 'City' ),
									'descr': i18n.__( "Select the city to show properties from it" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_properties_cities'] )
								}, props
							),
							// Neighborhood
							trx_addons_gutenberg_add_param(
								{
									'name': 'properties_neighborhood',
									'title': i18n.__( 'Neighborhood' ),
									'descr': i18n.__( "Select the neighborhood to show properties from" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_properties_neighborhoods'] )
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
