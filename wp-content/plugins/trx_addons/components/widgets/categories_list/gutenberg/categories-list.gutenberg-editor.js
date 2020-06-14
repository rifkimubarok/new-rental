(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Categories List
	blocks.registerBlockType(
		'trx-addons/categories-list', {
			title: i18n.__( 'Widget: Categories List' ),
			description: i18n.__( "Insert categories list with icons or images" ),
			icon: 'editor-ul',
			category: 'trx-addons-widgets',
			attributes: trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: i18n.__( 'Categories List' )
					},
					style: {
						type: 'string',
						default: '1'
					},
					number: {
						type: 'number',
						default: 5
					},
					columns: {
						type: 'number',
						default: 5
					},
					show_thumbs: {
						type: 'boolean',
						default: true
					},
					show_posts: {
						type: 'boolean',
						default: true
					},
					show_children: {
						type: 'boolean',
						default: false
					},
					post_type: {
						type: 'string',
						default: 'post'
					},
					taxonomy: {
						type: 'string',
						default: 'category'
					},
					cat_list: {
						type: 'string',
						default: ''
					},
				},
				trx_addons_gutenberg_get_param_id()
			),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {},
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'type': 'text',
								}, props
							),
							// Style
							trx_addons_gutenberg_add_param(
								{
									'name': 'style',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Select the style to display a categories list" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_categories_list'] )
								}, props
							),
							// Post type
							trx_addons_gutenberg_add_param(
								{
									'name': 'post_type',
									'title': i18n.__( 'Post type' ),
									'descr': i18n.__( "Select the post type to get featured images from the posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['posts_types'] )
								}, props
							),
							// Taxonomy
							trx_addons_gutenberg_add_param(
								{
									'name': 'taxonomy',
									'title': i18n.__( 'Taxonomy' ),
									'descr': i18n.__( "Select the taxonomy to get featured images from the posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type], true ),
								}, props
							),
							// List of the terms
							trx_addons_gutenberg_add_param(
								{
									'name': 'cat_list',
									'title': i18n.__( 'List of the terms' ),
									'descr': i18n.__( "The comma separated list of the term's slugs to show. If empty - show 'number' terms (see the field below)" ),
									'type': 'text',
								}, props
							),
							// Number of categories to show
							trx_addons_gutenberg_add_param(
								{
									'name': 'number',
									'title': i18n.__( 'Number of categories to show' ),
									'descr': i18n.__( "How many categories display in widget?" ),
									'type': 'number',
									'min': 1
								}, props
							),
							// Columns number to show
							trx_addons_gutenberg_add_param(
								{
									'name': 'columns',
									'title': i18n.__( 'Columns number to show' ),
									'descr': i18n.__( "How many columns use to display categories list?" ),
									'type': 'number',
									'min': 1
								}, props
							),
							// Show thumbs
							trx_addons_gutenberg_add_param(
								{
									'name': 'show_thumbs',
									'title': i18n.__( 'Show thumbs' ),
									'descr': i18n.__( "Do you want display term's thumbnails (if exists)?" ),
									'type': 'boolean',
								}, props
							),
							// Show posts number
							trx_addons_gutenberg_add_param(
								{
									'name': 'show_posts',
									'title': i18n.__( 'Show posts number' ),
									'descr': i18n.__( "Do you want display posts number?" ),
									'type': 'boolean',
								}, props
							),
							// Show children
							trx_addons_gutenberg_add_param(
								{
									'name': 'show_children',
									'title': i18n.__( 'Show children' ),
									'descr': i18n.__( "Show only children of the current category" ),
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
				return el( '', null );
			}
		}
	);
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element, );
