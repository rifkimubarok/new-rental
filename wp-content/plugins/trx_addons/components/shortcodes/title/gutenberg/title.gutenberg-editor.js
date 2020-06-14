(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Title
	blocks.registerBlockType(
		'trx-addons/title', {
			title: i18n.__( 'Title' ),
			description: i18n.__( "Add title, subtitle and description" ),
			icon: 'editor-italic',
			category: 'trx-addons-blocks',
			attributes: trx_addons_object_merge(
				trx_addons_gutenberg_get_param_title(),
				trx_addons_gutenberg_get_param_button(),
				trx_addons_gutenberg_get_param_id()
			),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
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
			},
		}
	);
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element, );