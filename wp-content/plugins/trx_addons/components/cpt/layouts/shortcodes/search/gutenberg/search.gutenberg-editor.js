(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Search form
	blocks.registerBlockType(
		'trx-addons/layouts-search', {
			title: i18n.__( 'Search form' ),
			description: i18n.__( 'Insert search form to the custom layout' ),
			icon: 'search',
			category: 'trx-addons-layouts',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'default'
					},
					style: {
						type: 'string',
						default: 'normal'
					},
					ajax: {
						type: 'boolean',
						default: false
					},
					post_types: {
						type: 'string',
						default: 'normal'
					},
				},
				trx_addons_gutenberg_get_param_hide(),
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
									'descr': i18n.__( "Select layout's type" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_logo'] ),
								}, props
							),
							// Style
							trx_addons_gutenberg_add_param(
								{
									'name': 'style',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Select form's style" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts_search'] ),
								}, props
							),
							// AJAX search
							trx_addons_gutenberg_add_param(
								{
									'name': 'ajax',
									'title': i18n.__( 'AJAX search' ),
									'descr': i18n.__( "Use incremental AJAX search" ),
									'type': 'boolean',
								}, props
							),
							// Post types
							trx_addons_gutenberg_add_param(
								{
									'name': 'post_types',
									'title': i18n.__( 'Post types' ),
									'descr': i18n.__( "Select the types of posts you want to search" ),
									'type': 'select',
									'multiple': true,
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['posts_types'] ),
								}, props
							),
						),
						'additional_params': el(
							'div', {},
							// Hide on devices params
							trx_addons_gutenberg_add_param_hide( props ),
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