(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Popular Posts
	blocks.registerBlockType(
		'trx-addons/popular-posts', {
			title: i18n.__( 'Widget: Popular Posts' ),
			description: i18n.__( "Insert popular posts list with thumbs, post's meta and category" ),
			icon: 'list-view',
			category: 'trx-addons-widgets',
			attributes: trx_addons_object_merge(
				{				
					title: {
						type: 'string',
						default: ''
					},
					title_1: {
						type: 'string',
						default: i18n.__( 'Tab 1' )
					},
					title_2: {
						type: 'string',
						default: i18n.__( 'Tab 2' )
					},
					title_3: {
						type: 'string',
						default: i18n.__( 'Tab 3' )
					},
					orderby_1: {
						type: 'string',
						default: 'views'
					},
					orderby_2: {
						type: 'string',
						default: 'comments'
					},
					orderby_3: {
						type: 'string',
						default: 'likes'
					},
					post_type_1: {
						type: 'string',
						default: 'post'
					},
					post_type_2: {
						type: 'string',
						default: 'post'
					},
					post_type_3: {
						type: 'string',
						default: 'post'
					},
					taxonomy_1: {
						type: 'string',
						default: 'category'
					},
					taxonomy_2: {
						type: 'string',
						default: 'category'
					},
					taxonomy_3: {
						type: 'string',
						default: 'category'
					},
					cat_1: {
						type: 'number',
						default: 0
					},
					cat_2: {
						type: 'number',
						default: 0
					},
					cat_3: {
						type: 'number',
						default: 0
					},
					number: {
						type: 'number',
						default: 4
					},
					show_date: {
						type: 'boolean',
						default: true
					},
					show_image: {
						type: 'true',
						default: true
					},
					show_author: {
						type: 'true',
						default: true
					},
					show_counters: {
						type: 'true',
						default: true
					},
					show_categories: {
						type: 'true',
						default: true
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
							// Widget title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Widget title' ),
									'descr': i18n.__( "Title of the widget" ),
									'type': 'text',
								}, props
							),
							// Number posts to show
							trx_addons_gutenberg_add_param(
								{
									'name': 'number',
									'title': i18n.__( 'Number posts to show' ),
									'descr': i18n.__( "How many posts display in widget?" ),
									'type': 'number',
									'min': 1
								}, props
							),
							// Show post's image
							trx_addons_gutenberg_add_param(
								{
									'name': 'show_image',
									'title': i18n.__( "Show post's image" ),
									'descr': i18n.__( "Do you want display post's featured image?" ),
									'type': 'boolean'
								}, props
							),
							// Show post's author
							trx_addons_gutenberg_add_param(
								{
									'name': 'show_author',
									'title': i18n.__( "Show post's author" ),
									'descr': i18n.__( "Do you want display post's author?" ),
									'type': 'boolean'
								}, props
							),
							// Show post's date
							trx_addons_gutenberg_add_param(
								{
									'name': 'show_date',
									'title': i18n.__( "Show post's date" ),
									'descr': i18n.__( "Do you want display post's publish date?" ),
									'type': 'boolean'
								}, props
							),
							// Show post's counters
							trx_addons_gutenberg_add_param(
								{
									'name': 'show_counters',
									'title': i18n.__( "Show post's counters" ),
									'descr': i18n.__( "Do you want display post's counters?" ),
									'type': 'boolean'
								}, props
							),
							// Show post's categories
							trx_addons_gutenberg_add_param(
								{
									'name': 'show_categories',
									'title': i18n.__( "Show post's categories" ),
									'descr': i18n.__( "Do you want display post's categories?" ),
									'type': 'boolean'
								}, props
							),
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title_1',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Tab 1 title" ),
									'type': 'text',
								}, props
							),
							// Order by
							trx_addons_gutenberg_add_param(
								{
									'name': 'orderby_1',
									'title': i18n.__( "Order by" ),
									'descr': i18n.__( "Select posts order" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['widget_query_orderby'] )
								}, props
							),
							// Post type
							trx_addons_gutenberg_add_param(
								{
									'name': 'post_type_1',
									'title': i18n.__( 'Post type' ),
									'descr': i18n.__( "Select post type to show posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['posts_types'] )
								}, props
							),
							// Taxonomy
							trx_addons_gutenberg_add_param(
								{
									'name': 'taxonomy_1',
									'title': i18n.__( 'Taxonomy' ),
									'descr': i18n.__( "Select taxonomy to show posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type_1], true )
								}, props
							),
							// Category
							trx_addons_gutenberg_add_param(
								{
									'name': 'cat_1',
									'title': i18n.__( 'Category' ),
									'descr': i18n.__( "Select category to show posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['categories'][props.attributes.taxonomy_1], true  )
								}, props
							),
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title_2',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Tab 2 title" ),
									'type': 'text',
								}, props
							),
							// Order by
							trx_addons_gutenberg_add_param(
								{
									'name': 'orderby_2',
									'title': i18n.__( "Order by" ),
									'descr': i18n.__( "Select posts order" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['widget_query_orderby'] )
								}, props
							),
							// Post type
							trx_addons_gutenberg_add_param(
								{
									'name': 'post_type_2',
									'title': i18n.__( 'Post type' ),
									'descr': i18n.__( "Select post type to show posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['posts_types'] )
								}, props
							),
							// Taxonomy
							trx_addons_gutenberg_add_param(
								{
									'name': 'taxonomy_2',
									'title': i18n.__( 'Taxonomy' ),
									'descr': i18n.__( "Select taxonomy to show posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type_2], true )
								}, props
							),
							// Category
							trx_addons_gutenberg_add_param(
								{
									'name': 'cat_2',
									'title': i18n.__( 'Category' ),
									'descr': i18n.__( "Select category to show posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['categories'][props.attributes.taxonomy_2], true )
								}, props
							),
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title_3',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Tab 3 title" ),
									'type': 'text',
								}, props
							),
							// Order by
							trx_addons_gutenberg_add_param(
								{
									'name': 'orderby_3',
									'title': i18n.__( "Order by" ),
									'descr': i18n.__( "Select posts order" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['widget_query_orderby'] )
								}, props
							),
							// Post type
							trx_addons_gutenberg_add_param(
								{
									'name': 'post_type_3',
									'title': i18n.__( 'Post type' ),
									'descr': i18n.__( "Select post type to show posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['posts_types'] )
								}, props
							),
							// Taxonomy
							trx_addons_gutenberg_add_param(
								{
									'name': 'taxonomy_3',
									'title': i18n.__( 'Taxonomy' ),
									'descr': i18n.__( "Select taxonomy to show posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type_3], true  )
								}, props
							),
							// Category
							trx_addons_gutenberg_add_param(
								{
									'name': 'cat_3',
									'title': i18n.__( 'Category' ),
									'descr': i18n.__( "Select category to show posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['categories'][props.attributes.taxonomy_3], true  )
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
