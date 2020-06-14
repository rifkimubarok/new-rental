(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Countdown
	blocks.registerBlockType(
		'trx-addons/countdown', {
			title: i18n.__( 'Countdown' ),
			description: i18n.__( "Put the countdown to the specified date and time" ),
			icon: 'clock',
			category: 'trx-addons-blocks',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					align: {
						type: 'string',
						default: 'none'
					},
					date: {
						type: 'string',
						default: ''
					},
					time: {
						type: 'string',
						default: ''
					},
					count_to: {
						type: 'boolean',
						default: true
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
						'general_params': el(
							'div', {},
							// Layout
							trx_addons_gutenberg_add_param(
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_countdown'] )
								}, props
							),
							// Alignment
							trx_addons_gutenberg_add_param(
								{
									'name': 'align',
									'title': i18n.__( 'Alignment' ),
									'descr': i18n.__( "Select alignment of the countdown" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
								}, props
							),
							// Date
							trx_addons_gutenberg_add_param(
								{
									'name': 'date',
									'title': i18n.__( 'Date' ),
									'descr': i18n.__( "Target date. Attention! Write the date in the format: yyyy-mm-dd" ),
									'type': 'text'
								}, props
							),
							// Time
							trx_addons_gutenberg_add_param(
								{
									'name': 'time',
									'title': i18n.__( 'Time' ),
									'descr': i18n.__( "Target time. Attention! Put the time in the 24-hours format: HH:mm:ss" ),
									'type': 'text'
								}, props
							),
							// Count to
							trx_addons_gutenberg_add_param(
								{
									'name': 'count_to',
									'title': i18n.__( 'Count to' ),
									'descr': i18n.__( "If checked - date above is a finish date, else - is a start date" ),
									'type': 'boolean'
								}, props
							)
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
				return el( '', null );
			}
		}
	);
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element, );
