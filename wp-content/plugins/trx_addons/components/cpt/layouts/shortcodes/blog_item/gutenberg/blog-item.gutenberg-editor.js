(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;
	// Register Block - Blog item part
	blocks.registerBlockType(
		'trx-addons/layouts-blog-item', {
			title: i18n.__( 'Blog item part' ),
			icon: 'welcome-widgets-menus',
			category: 'trx-addons-layouts',
			attributes: trx_addons_object_merge(
				{
					type: {
						type: 'string',
						default: 'title'
					},
					thumb_bg: {
						type: 'boolean',
						default: false
					},
					thumb_ratio: {
						type: 'string',
						default: '16:9'
					},
					thumb_mask: {
						type: 'string',
						default: '#000'
					},
					thumb_mask_opacity: {
						type: 'string',
						default: '0.3'
					},
					thumb_hover_mask: {
						type: 'string',
						default: '#000'
					},
					thumb_hover_opacity: {
						type: 'string',
						default: '0.1'
					},
					thumb_size: {
						type: 'string',
						default: 'full'
					},
					title_tag: {
						type: 'string',
						default: 'h4'
					},
					meta_parts: {
						type: 'string',
						default: ''
					},
					custom_meta_key: {
						type: 'string',
						default: ''
					},
					button_text: {
						type: 'string',
						default: i18n.__( "Read more" )
					},
					button_link: {
						type: 'string',
						default: 'post'
					},
					button_type: {
						type: 'string',
						default: 'default'
					},
					seo: {
						type: 'string',
						default: ''
					},
					position: {
						type: 'string',
						default: 'static'
					},
					hide_overflow: {
						type: 'boolean',
						default: false
					},
					animation_in: {
						type: 'string',
						default: 'none'
					},
					animation_in_delay: {
						type: 'number',
						default: 0
					},
					animation_out: {
						type: 'string',
						default: 'none'
					},
					animation_out_delay: {
						type: 'number',
						default: 0
					},
					text_color: {
						type: 'string',
						default: ''
					},
					text_hover: {
						type: 'string',
						default: ''
					},
					font_zoom: {
						type: 'string',
						default: '1'
					},
					post_type: {
						type: 'string',
						default: 'post,'
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
							// Layout
							trx_addons_gutenberg_add_param(
								{
									'name': 'type',
									'title': i18n.__( 'Layout' ),
									'descr': i18n.__( "Select layout's type" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_blog_item'] ),
								}, props
							),
							// Use as background
							trx_addons_gutenberg_add_param(
								{
									'name': 'thumb_bg',
									'title': i18n.__( 'Use as background' ),
									'type': 'boolean',
									'dependency': {
										'type': ['featured']
									}
								}, props
							),
							// Image ratio
							trx_addons_gutenberg_add_param(
								{
									'name': 'thumb_ratio',
									'title': i18n.__( 'Image ratio' ),
									'type': 'text',
									'dependency': {
										'thumb_bg': [true]
									}
								}, props
							),
							// Image size
							trx_addons_gutenberg_add_param(
								{
									'name': 'thumb_size',
									'title': i18n.__( 'Image size' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['thumbnail_sizes'] ),
									'dependency': {
										'type': ['featured']
									}
								}, props
							),
							// Image mask color
							trx_addons_gutenberg_add_param(
								{
									'name': 'thumb_mask',
									'title': i18n.__( 'Image mask color' ),
									'type': 'color',
									'dependency': {
										'type': ['featured']
									}
								}, props
							),
							// Image mask opacity
							trx_addons_gutenberg_add_param(
								{
									'name': 'thumb_mask_opacity',
									'title': i18n.__( 'Image mask opacity' ),
									'type': 'text',
									'dependency': {
										'type': ['featured']
									}
								}, props
							),
							// Hovered mask color
							trx_addons_gutenberg_add_param(
								{
									'name': 'thumb_hover_mask',
									'title': i18n.__( 'Hovered mask color' ),
									'type': 'color',
									'dependency': {
										'type': ['featured']
									}
								}, props
							),
							// Hovered mask opacity
							trx_addons_gutenberg_add_param(
								{
									'name': 'thumb_hover_opacity',
									'title': i18n.__( 'Hovered mask opacity' ),
									'type': 'text',
									'dependency': {
										'type': ['featured']
									}
								}, props
							),
							// Title tag
							trx_addons_gutenberg_add_param(
								{
									'name': 'title_tag',
									'title': i18n.__( 'Title tag' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_title_tags'] ),
									'dependency': {
										'type': ['title']
									}
								}, props
							),
							// Choose meta parts
							trx_addons_gutenberg_add_param(
								{
									'name': 'meta_parts',
									'title': i18n.__( 'Choose meta parts' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['meta_parts'] ),
									'dependency': {
										'type': ['meta']
									}
								}, props
							),
							// Name of the custom meta
							trx_addons_gutenberg_add_param(
								{
									'name': 'custom_meta_key',
									'title': i18n.__( 'Name of the custom meta' ),
									'type': 'text',
									'dependency': {
										'type': ['custom']
									}
								}, props
							),
							// Button type
							trx_addons_gutenberg_add_param(
								{
									'name': 'button_type',
									'title': i18n.__( 'Button type' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_button'] ),
									'dependency': {
										'type': ['button']
									}
								}, props
							),
							// Button link to
							trx_addons_gutenberg_add_param(
								{
									'name': 'button_link',
									'title': i18n.__( 'Button link to' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists({
										'post': i18n.__( 'Single post' ),
										'product': i18n.__( 'Linked product' ),
										'cart': i18n.__( 'Add to cart' ),
									}),
									'dependency': {
										'type': ['button']
									}
								}, props
							),
							// Button caption
							trx_addons_gutenberg_add_param(
								{
									'name': 'button_text',
									'title': i18n.__( 'Button caption' ),
									'type': 'text',
									'dependency': {
										'type': ['button']
									}
								}, props
							),
							// Zoom font size
							trx_addons_gutenberg_add_param(
								{
									'name': 'font_zoom',
									'title': i18n.__( 'Zoom font size' ),
									'type': 'text',
									'dependency': {
										'type': ['title', 'excerpt', 'content', 'meta', 'custom', 'button']
									}
								}, props
							),
							// Hide overflow
							trx_addons_gutenberg_add_param(
								{
									'name': 'hide_overflow',
									'title': i18n.__( 'Hide overflow' ),
									'type': 'boolean',
									'dependency': {
										'type': ['title', 'meta', 'custom']
									}
								}, props
							),
							// Position
							trx_addons_gutenberg_add_param(
								{
									'name': 'position',
									'title': i18n.__( 'Position' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blog_item_positions'] ),
									'dependency': {
										'type': ['title', 'meta', 'excerpt', 'custom', 'button']
									}
								}, props
							),
							// Hover animation in
							trx_addons_gutenberg_add_param(
								{
									'name': 'animation_in',
									'title': i18n.__( 'Hover animation in' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blog_item_animations_in'] ),
									'dependency': {
										'position': ['^static']
									}
								}, props
							),
							// Hover animation in delay (in ms)
							trx_addons_gutenberg_add_param(
								{
									'name': 'animation_in_delay',
									'title': i18n.__( 'Animation in delay' ),
									'type': 'number',
									'min': 0,
									'max': 2000,
									'step': 100,
									'dependency': {
										'animation_in': ['^none']
									}
								}, props
							),
							// Hover animation out
							trx_addons_gutenberg_add_param(
								{
									'name': 'animation_out',
									'title': i18n.__( 'Hover animation out' ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_blog_item_animations_out'] ),
									'dependency': {
										'position': ['^static']
									}
								}, props
							),
							// Hover animation out delay (in ms)
							trx_addons_gutenberg_add_param(
								{
									'name': 'animation_out_delay',
									'title': i18n.__( 'Animation out delay' ),
									'type': 'number',
									'min': 0,
									'max': 2000,
									'step': 100,
									'dependency': {
										'animation_out': ['^none']
									}
								}, props
							),
							// Text color
							trx_addons_gutenberg_add_param(
								{
									'name': 'text_color',
									'title': i18n.__( 'Text color' ),
									'type': 'color',
									'dependency': {
										'type': ['title', 'meta', 'excerpt', 'custom', 'button']
									}
								}, props
							),
							// Text color (hovered)
							trx_addons_gutenberg_add_param(
								{
									'name': 'text_hover',
									'title': i18n.__( 'Text color (hovered)' ),
									'type': 'color',
									'dependency': {
										'type': ['title', 'meta', 'excerpt', 'custom', 'button']
									}
								}, props
							),
							// Supported post types
							trx_addons_gutenberg_add_param(
								{
									'name': 'post_type',
									'title': i18n.__( 'Supported post types' ),
									'type': 'select',
									'multiple': true,
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['posts_types'] ),									
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
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element );
