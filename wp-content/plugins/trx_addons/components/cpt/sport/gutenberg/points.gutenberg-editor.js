(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Points
	blocks.registerBlockType(
		'trx-addons/points', {
			title: i18n.__( 'Points' ),
			icon: 'universal-access',
			category: 'trx-addons-cpt',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					sport: {
						type: 'string',
						default:  TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_sport_default']
					},
					competition: {
						type: 'string',
						default: '0'
					},
					logo: {
						type: 'boolean',
						default: false
					},
					accented_top: {
						type: 'number',
						default: 3
					},
					accented_bottom: {
						type: 'number',
						default: 3
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
						'general_params': el(
							'div', {},
							// Layout
							trx_addons_gutenberg_add_param(
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select shortcodes's layout" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['trx_sc_points'] )
								}, props
							),
							// Sport
							trx_addons_gutenberg_add_param(
								{
									'name': 'sport',
									'title': i18n.__( 'Sport' ),
									'descr': i18n.__( "Select Sport to display matches" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_sports_list'] ),
								}, props
							),
							// Competition
							trx_addons_gutenberg_add_param(
								{
									'name': 'competition',
									'title': i18n.__( 'Competition' ),
									'descr': i18n.__( "Select competition to display matches" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_sport_competitions_list'][props.attributes.sport], true ),
								}, props
							),
							// Logo
							trx_addons_gutenberg_add_param(
								{
									'name': 'logo',
									'title': i18n.__( "Logo" ),
									'descr': i18n.__( "Show logo (players photo) in the table" ),
									'type': 'boolean',
								}, props
							),
							// Accented top
							trx_addons_gutenberg_add_param(
								{
									'name': 'accented_top',
									'title': i18n.__( "Accented top" ),
									'descr': i18n.__( "How many rows should be accented at the top of the table?" ),
									'type': 'number',
									'min': 0
								}, props
							),
							// Accented bottom
							trx_addons_gutenberg_add_param(
								{
									'name': 'accented_bottom',
									'title': i18n.__( "Accented bottom" ),
									'descr': i18n.__( "How many rows should be accented at the bottom of the table?" ),
									'type': 'number',
									'min': 0
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
				return el( '', null );
			}
		}
	);
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element, );
