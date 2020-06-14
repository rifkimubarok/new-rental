(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Slider
	blocks.registerBlockType(
		'trx-addons/slider', {
			title: i18n.__( 'Widget: Slider' ),
			description: i18n.__( "Insert slider " ),
			icon: 'images-alt',
			category: 'trx-addons-widgets',
			attributes: trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: ''
					},
					engine: {
						type: 'string',
						default: 'swiper'
					},
					slider_id: {
						type: 'string',
						default: ''
					},
					slider_style: {
						type: 'string',
						default: 'default'
					},
					slides_per_view: {
						type: 'number',
						default: 1
					},
					slides_space: {
						type: 'number',
						default: 0
					},
					slides_type: {
						type: 'string',
						default: 'bg'
					},
					slides_ratio: {
						type: 'string',
						default: '16:9'
					},
					slides_centered: {
						type: 'boolean',
						default: false
					},
					slides_overflow: {
						type: 'boolean',
						default: false
					},
					autoplay: {
						type: 'boolean',
						default: true
					},
					mouse_wheel: {
						type: 'boolean',
						default: false
					},
					noswipe: {
						type: 'boolean',
						default: false
					},
					noresize: {
						type: 'boolean',
						default: false
					},
					effect: {
						type: 'string',
						default: 'slide'
					},
					height: {
						type: 'string',
						default: ''
					},
					alias: {
						type: 'string',
						default: ''
					},
					post_type: {
						type: 'string',
						default: 'post'
					},
					taxonomy: {
						type: 'string',
						default: 'category'
					},
					category: {
						type: 'string',
						default: '0'
					},
					posts: {
						type: 'number',
						default: 5
					},
					interval: {
						type: 'number',
						default: 7000
					},
					titles: {
						type: 'string',
						default: 'center'
					},
					large: {
						type: 'boolean',
						default: false
					},
					controls: {
						type: 'boolean',
						default: false
					},
					controls_pos: {
						type: 'string',
						default: 'side'
					},
					label_prev: {
						type: 'string',
						default: i18n.__( 'Prev|PHOTO' )
					},
					label_next: {
						type: 'string',
						default: i18n.__( 'Next|PHOTO' )
					},
					pagination: {
						type: 'boolean',
						default: false
					},
					pagination_type: {
						type: 'string',
						default: 'bullets'
					},
					pagination_pos: {
						type: 'string',
						default: 'bottom'
					},
					direction: {
						type: 'string',
						default: 'horizontal'
					},
					slides: {
						type: 'string',
						default: ''
					},
					// Reload block - hidden option
					reload: {
						type: 'string'
					},
				},
				trx_addons_gutenberg_get_param_id()
			),
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'render_button': true,
						'parent': true,
						'general_params': el(
							'div', {},
							// Widget title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Widget title' ),
									'type': 'text'
								}, props
							),
							// Slider engine
							trx_addons_gutenberg_add_param(
								{
									'name': 'engine',
									'title': i18n.__( 'Slider engine' ),
									'descr': i18n.__( "Select engine to show slider" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sliders_list'] )
								}, props
							),
							// RevSlider alias
							trx_addons_gutenberg_add_param(
								{
									'name': 'alias',
									'title': i18n.__( 'RevSlider alias' ),
									'descr': i18n.__( "Select previously created Revolution slider" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['list_revsliders'] ),
									'dependency': {
										'engine': ['revo']
									}
								}, props
							),
							// Swiper style
							trx_addons_gutenberg_add_param(
								{
									'name': 'slider_style',
									'title': i18n.__( 'Swiper style' ),
									'descr': i18n.__( "Select style of the Swiper slider" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_slider'] ),
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),
							// Slider height
							trx_addons_gutenberg_add_param(
								{
									'name': 'height',
									'title': i18n.__( "Slider height" ),
									'descr': i18n.__( "Initial height of the slider. If empty - calculate from width and aspect ratio" ),
									'type': 'text',
									'dependency': {
										'noresize': [true]
									}
								}, props
							),
							// Swiper effect
							trx_addons_gutenberg_add_param(
								{
									'name': 'effect',
									'title': i18n.__( 'Swiper effect' ),
									'descr': i18n.__( "Select slides effect of the Swiper slider" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_effects'] ),
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),
							// Direction
							trx_addons_gutenberg_add_param(
								{
									'name': 'direction',
									'title': i18n.__( 'Direction' ),
									'descr': i18n.__( "Select direction to change slides" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_directions'] ),
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),
							// Slides per view in the Swiper
							trx_addons_gutenberg_add_param(
								{
									'name': 'slides_per_view',
									'title': i18n.__( 'Slides per view in the Swiper' ),
									'descr': i18n.__( "Specify slides per view in the Swiper" ),
									'type': 'number',
									'min': 1,
									'max': 6,
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),
							// Space between slides in the Swiper
							trx_addons_gutenberg_add_param(
								{
									'name': 'slides_space',
									'title': i18n.__( 'Space between slides in the Swiper' ),
									'type': 'number',
									'min': 0,
									'max': 100,
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),

							// Post type
							trx_addons_gutenberg_add_param(
								{
									'name': 'post_type',
									'title': i18n.__( 'Post type' ),
									'descr': i18n.__( "Select post type to get featured images from the posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['posts_types'] ),
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								}, props
							),
							// Taxonomy
							trx_addons_gutenberg_add_param(
								{
									'name': 'taxonomy',
									'title': i18n.__( 'Taxonomy' ),
									'descr': i18n.__( "Select taxonomy to get featured images from the posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type], true ),
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								}, props
							),
							// Category
							trx_addons_gutenberg_add_param(
								{
									'name': 'category',
									'title': i18n.__( 'Category' ),
									'descr': i18n.__( "Select category to get featured images from the posts" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['categories'][props.attributes.taxonomy] ),
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								}, props
							),
							// Posts number
							trx_addons_gutenberg_add_param(
								{
									'name': 'posts',
									'title': i18n.__( 'Posts number' ),
									'descr': i18n.__( "Number of posts or comma separated post's IDs to show images" ),
									'type': 'number',
									'min': 1,
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								}, props
							),

							// Controls
							trx_addons_gutenberg_add_param(
								{
									'name': 'controls',
									'title': i18n.__( 'Controls' ),
									'descr': i18n.__( "Do you want to show arrows to change slides?" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								}, props
							),
							// Controls position
							trx_addons_gutenberg_add_param(
								{
									'name': 'controls_pos',
									'title': i18n.__( 'Controls position' ),
									'descr': i18n.__( "Select controls position" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_controls'] ),
									'dependency': {
										'engine': ['swiper'],
										'controls': [true]
									}
								}, props
							),
							// Prev Slide
							trx_addons_gutenberg_add_param(
								{
									'name': 'label_prev',
									'title': i18n.__( 'Prev Slide' ),
									'descr': i18n.__( "Label of the 'Prev Slide' button in the Swiper (Modern style). Use '|' to break line" ),
									'type': 'text',
									'dependency': {
										'slider_style': ['modern'],
										'controls': [true]
									}
								}, props
							),
							// Next Slide
							trx_addons_gutenberg_add_param(
								{
									'name': 'label_next',
									'title': i18n.__( 'Next Slide' ),
									'descr': i18n.__( "Label of the 'Next Slide' button in the Swiper (Modern style). Use '|' to break line" ),
									'type': 'text',
									'dependency': {
										'slider_style': ['modern'],
										'controls': [true]
									}
								}, props
							),
							// Pagination
							trx_addons_gutenberg_add_param(
								{
									'name': 'pagination',
									'title': i18n.__( 'Pagination' ),
									'descr': i18n.__( "Do you want to show bullets to change slides?" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),
							// Pagination type
							trx_addons_gutenberg_add_param(
								{
									'name': 'pagination_type',
									'title': i18n.__( 'Pagination type' ),
									'descr': i18n.__( "Select type of the pagination" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_paginations_types'] ),
									'dependency': {
										'pagination': [true]
									}
								}, props
							),
							// Pagination position
							trx_addons_gutenberg_add_param(
								{
									'name': 'pagination_pos',
									'title': i18n.__( 'Pagination position' ),
									'descr': i18n.__( "Select pagination position" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_paginations'] ),
									'dependency': {
										'pagination': [true]
									}
								}, props
							),

							// Enable autoplay
							trx_addons_gutenberg_add_param(
								{
									'name': 'autoplay',
									'title': i18n.__( 'Enable autoplay' ),
									'descr': i18n.__( "Enable autoplay for this slider" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),
							// Interval between slides in the Swiper
							trx_addons_gutenberg_add_param(
								{
									'name': 'interval',
									'title': i18n.__( 'Interval between slides in the Swiper' ),
									'descr': i18n.__( "Specify interval between slides change in the Swiper" ),
									'type': 'number',
									'min': 0,
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),

							// Enable mouse wheel
							trx_addons_gutenberg_add_param(
								{
									'name': 'mouse_wheel',
									'title': i18n.__( 'Enable mouse wheel' ),
									'descr': i18n.__( "Enable mouse wheel to control slidest" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),
							// Disable swipe
							trx_addons_gutenberg_add_param(
								{
									'name': 'noswipe',
									'title': i18n.__( 'Disable swipe' ),
									'descr': i18n.__( "Disable swipe guestures" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),
							// No resize slide's content
							trx_addons_gutenberg_add_param(
								{
									'name': 'noresize',
									'title': i18n.__( "No resize slide's content" ),
									'descr': i18n.__( "Disable resize slide's content, stretch images to cover slide" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								}, props
							),

							// Type of the slides content
							trx_addons_gutenberg_add_param(
								{
									'name': 'slides_type',
									'title': i18n.__( 'Type of the slides content' ),
									'descr': i18n.__( "Use images from slides as background (default) or insert it as tag inside each slide" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['slides_type'] ),
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								}, props
							),
							// Slides ratio
							trx_addons_gutenberg_add_param(
								{
									'name': 'slides_ratio',
									'title': i18n.__( "Slides ratio" ),
									'descr': i18n.__( "Ratio to resize slides on tabs and mobile. If empty - 16:9" ),
									'type': 'text',
									'dependency': {
										'noresize': [false]
									}
								}, props
							),
							// Slides centered
							trx_addons_gutenberg_add_param(
								{
									'name': 'slides_centered',
									'title': i18n.__( 'Slides centered' ),
									'descr': i18n.__( "Center active slide" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),
							// Slides overflow visible
							trx_addons_gutenberg_add_param(
								{
									'name': 'slides_overflow',
									'title': i18n.__( 'Slides overflow visible' ),
									'descr': i18n.__( "Don't hide slides outside the borders of the viewport" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper']
									}
								}, props
							),
							// Titles in the Swiper
							trx_addons_gutenberg_add_param(
								{
									'name': 'titles',
									'title': i18n.__( 'Titles in the slides' ),
									'descr': i18n.__( "Show post's titles and categories on the slides" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_titles'] ),
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
								}, props
							),
							// Large titles
							trx_addons_gutenberg_add_param(
								{
									'name': 'large',
									'title': i18n.__( 'Large titles' ),
									'descr': i18n.__( "Do you want use large titles?" ),
									'type': 'boolean',
									'dependency': {
										'engine': ['swiper', 'elastistack']
									}
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
				// Get child block values of attributes
				props.attributes.slides = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		}
	);

	// Register block Slider Item
	blocks.registerBlockType(
		'trx-addons/slider-item', {
			title: i18n.__( 'Slide' ),
			description: i18n.__( "Select icons, specify title and/or description for each item" ),
			icon: 'images-alt',
			category: 'trx-addons-widgets',
			parent: ['trx-addons/slider'],
			attributes: {
				title: {
					type: 'string',
					default: ''
				},
				subtitle: {
					type: 'string',
					default: ''
				},
				link: {
					type: 'string',
					default: ''
				},
				image: {
					type: 'number',
					default: 0
				},
				image_url: {
					type: 'string',
					default: ''
				},
				video_url: {
					type: 'string',
					default: ''
				},
				video_embed: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				},
			},
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Slide' ) + (props.attributes.title ? ': ' + props.attributes.title : ''),
						'general_params': el(
							'div', {},
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'descr': i18n.__( "Enter title of the item" ),
									'type': 'text'
								}, props
							),
							// Subtitle
							trx_addons_gutenberg_add_param(
								{
									'name': 'subtitle',
									'title': i18n.__( 'Subtitle' ),
									'descr': i18n.__( "Enter subtitle of the item" ),
									'type': 'text'
								}, props
							),
							// Link
							trx_addons_gutenberg_add_param(
								{
									'name': 'link',
									'title': i18n.__( 'Link' ),
									'descr': i18n.__( "URL to link this item" ),
									'type': 'text'
								}, props
							),
							// Image
							trx_addons_gutenberg_add_param(
								{
									'name': 'image',
									'name_url': 'image_url',
									'title': i18n.__( 'Image' ),
									'descr': i18n.__( "Select or upload image or specify URL from other site to use it as icon" ),
									'type': 'image'
								}, props
							),
							// Video URL
							trx_addons_gutenberg_add_param(
								{
									'name': 'video_url',
									'title': i18n.__( 'Video URL' ),
									'descr': i18n.__( "Enter link to the video (Note: read more about available formats at WordPress Codex page)" ),
									'type': 'text'
								}, props
							),
							// Video embed code
							trx_addons_gutenberg_add_param(
								{
									'name': 'video_embed',
									'title': i18n.__( 'Video embed code' ),
									'descr': i18n.__( "or paste the HTML code to embed video in this slide" ),
									'type': 'textarea'
								}, props
							),
						)
					}, props
				);
			},
			save: function(props) {
				return el( '', null );
			}
		}
	);

	// Register Block - Slider Controller
	blocks.registerBlockType(
		'trx-addons/slider-controller', {
			title: i18n.__( 'Slider Controller' ),
			description: i18n.__( "Insert slider controller" ),
			icon: 'images-alt',
			category: 'trx-addons-widgets',
			attributes: {
				slider_id: {
					type: 'string',
					default: ''
				},
				height: {
					type: 'string',
					default: '50px'
				},
				controls: {
					type: 'boolean',
					default: false
				},
				controller_style: {
					type: 'string',
					default: 'thumbs'
				},
				effect: {
					type: 'string',
					default: 'slide'
				},
				direction: {
					type: 'string',
					default: 'horizontal'
				},
				slides_per_view: {
					type: 'number',
					default: 1
				},
				slides_space: {
					type: 'number',
					default: 0
				},
				interval: {
					type: 'number',
					default: 7000
				},
				// ID, Class, CSS attributes
				id: {
					type: 'string',
					default: ''
				},
				class: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				},
				css: {
					type: 'string',
					default: ''
				},
			},
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {},
							// Controlled Slider ID
							trx_addons_gutenberg_add_param(
								{
									'name': 'slider_id',
									'title': i18n.__( 'Slave slider ID' ),
									'descr': i18n.__( "ID of the controlled slider" ),
									'type': 'text'
								}, props
							),
							// Slider height
							trx_addons_gutenberg_add_param(
								{
									'name': 'height',
									'title': i18n.__( "Slider height" ),
									'descr': i18n.__( "Initial height of the slider. If empty - calculate from width and aspect ratio" ),
									'type': 'text'
								}, props
							),
							// Controls
							trx_addons_gutenberg_add_param(
								{
									'name': 'controls',
									'title': i18n.__( 'Controls' ),
									'descr': i18n.__( "Do you want to show arrows to change slides?" ),
									'type': 'boolean'
								}, props
							),
							// Controller style
							trx_addons_gutenberg_add_param(
								{
									'name': 'controller_style',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Select style of the Controller" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_controller_styles'] )
								}, props
							),
							// Swiper effect
							trx_addons_gutenberg_add_param(
								{
									'name': 'effect',
									'title': i18n.__( 'Effect' ),
									'descr': i18n.__( "Select slides effect of the controller slider" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_effects'] )
								}, props
							),
							// Direction
							trx_addons_gutenberg_add_param(
								{
									'name': 'direction',
									'title': i18n.__( 'Direction' ),
									'descr': i18n.__( "Select direction to change slides" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_directions'] )
								}, props
							),
							// Slides per view in the Swiper
							trx_addons_gutenberg_add_param(
								{
									'name': 'slides_per_view',
									'title': i18n.__( 'Slides per view' ),
									'descr': i18n.__( "Specify slides per view in the Swiper" ),
									'type': 'number',
									'min': 1,
									'max': 6
								}, props
							),
							// Space between slides in the Swiper
							trx_addons_gutenberg_add_param(
								{
									'name': 'slides_space',
									'title': i18n.__( 'Space between slides' ),
									'type': 'number',
									'min': 0,
									'max': 100
								}, props
							),
							// Interval between slides in the Swiper
							trx_addons_gutenberg_add_param(
								{
									'name': 'interval',
									'title': i18n.__( 'Interval between slides change' ),
									'descr': i18n.__( "Specify interval between slides change" ),
									'type': 'number',
									'min': 0
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
			},
		}
	);

	// Register Block - Slider Controls
	blocks.registerBlockType(
		'trx-addons/slider-controls', {
			title: i18n.__( 'Slider Controls' ),
			description: i18n.__( "Insert slider controls" ),
			icon: 'images-alt',
			category: 'trx-addons-widgets',
			attributes: {
				slider_id: {
					type: 'string',
					default: ''
				},
				controls_style: {
					type: 'string',
					default: 'default'
				},
				align: {
					type: 'string',
					default: 'left'
				},
				hide_prev: {
					type: 'boolean',
					default: false
				},
				title_prev: {
					type: 'string',
					default: ''
				},
				hide_next: {
					type: 'boolean',
					default: false
				},
				title_next: {
					type: 'string',
					default: ''
				},
				pagination_style: {
					type: 'string',
					default: 'none'
				},
				// ID, Class, CSS attributes
				id: {
					type: 'string',
					default: ''
				},
				class: {
					type: 'string',
					default: ''
				},
				className: {
					type: 'string',
					default: ''
				},
				css: {
					type: 'string',
					default: ''
				},
			},
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'render': true,
						'general_params': el(
							'div', {},
							// Controlled Slider ID
							trx_addons_gutenberg_add_param(
								{
									'name': 'slider_id',
									'title': i18n.__( 'Slave slider ID' ),
									'descr': i18n.__( "ID of the controlled slider" ),
									'type': 'text'
								}, props
							),
							// Controls style
							trx_addons_gutenberg_add_param(
								{
									'name': 'controls_style',
									'title': i18n.__( 'Style' ),
									'descr': i18n.__( "Select style of the Controls" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_controls_styles'] )
								}, props
							),
							// Alignment
							trx_addons_gutenberg_add_param(
								{
									'name': 'align',
									'title': i18n.__( 'Alignment' ),
									'descr': i18n.__( "Select alignment of the arrows" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns_short'] )
								}, props
							),
							// Hide 'Prev'
							trx_addons_gutenberg_add_param(
								{
									'name': 'hide_prev',
									'title': i18n.__( "Hide 'Prev'" ),
									'descr': i18n.__( "Hide the button 'Prev'" ),
									'type': 'boolean'
								}, props
							),
							// Title 'Prev'
							trx_addons_gutenberg_add_param(
								{
									'name': 'title_prev',
									'title': i18n.__( "Title 'Prev'" ),
									'descr': i18n.__( "Title of the button 'Prev'" ),
									'type': 'text'
								}, props
							),
							// Hide 'Next'
							trx_addons_gutenberg_add_param(
								{
									'name': 'hide_next',
									'title': i18n.__( "Hide 'Next'" ),
									'descr': i18n.__( "Hide the button 'Next'" ),
									'type': 'boolean'
								}, props
							),
							// Title 'Next'
							trx_addons_gutenberg_add_param(
								{
									'name': 'title_next',
									'title': i18n.__( "Title 'Next'" ),
									'descr': i18n.__( "Title of the button 'Next'" ),
									'type': 'text'
								}, props
							),
							// Pagination
							trx_addons_gutenberg_add_param(
								{
									'name': 'pagination_style',
									'title': i18n.__( 'Show pagination' ),
									'descr': i18n.__( "Select pagination style of the controls" ),
									'type': 'select',
									'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_controls_paginations_types'] )
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
			},
		}
	);
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element, );
