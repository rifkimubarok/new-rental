(function(blocks, editor, i18n, element) {
	// Set up variables
	var el = element.createElement;

	// Register Block - Audio
	blocks.registerBlockType(
		'trx-addons/audio', {
			title: i18n.__( 'Widget: Audio' ),
			description: i18n.__( "Play audio from Soundcloud and other audio hostings or Local hosted audio" ),
			icon: 'format-audio',
			category: 'trx-addons-widgets',
			attributes: trx_addons_object_merge(
				{
					title: {
						type: 'string',
						default: ''
					},
					subtitle: {
						type: 'string',
						default: ''
					},
					next_btn: {
						type: 'boolean',
						default: true
					},
					prev_btn: {
						type: 'boolean',
						default: true
					},
					next_text: {
						type: 'string',
						default: ''
					},
					prev_text: {
						type: 'string',
						default: ''
					},
					now_text: {
						type: 'string',
						default: ''
					},
					track_time: {
						type: 'boolean',
						default: true
					},
					track_scroll: {
						type: 'boolean',
						default: true
					},
					track_volume: {
						type: 'boolean',
						default: true
					},
					media: {
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
							// Title
							trx_addons_gutenberg_add_param(
								{
									'name': 'title',
									'title': i18n.__( 'Title' ),
									'type': 'text',
								}, props
							),
							// Subtitle
							trx_addons_gutenberg_add_param(
								{
									'name': 'subtitle',
									'title': i18n.__( 'Subtitle' ),
									'type': 'text',
								}, props
							),
							// Show next button
							trx_addons_gutenberg_add_param(
								{
									'name': 'next_btn',
									'title': i18n.__( 'Show next button' ),
									'type': 'boolean'
								}, props
							),
							// Show prev button
							trx_addons_gutenberg_add_param(
								{
									'name': 'prev_btn',
									'title': i18n.__( 'Show prev button' ),
									'type': 'boolean'
								}, props
							),
							// Next button text
							trx_addons_gutenberg_add_param(
								{
									'name': 'next_text',
									'title': i18n.__( 'Next button text' ),
									'type': 'text',
								}, props
							),
							// Prev button text
							trx_addons_gutenberg_add_param(
								{
									'name': 'prev_text',
									'title': i18n.__( 'Prev button text' ),
									'type': 'text',
								}, props
							),
							// "Now playing" text
							trx_addons_gutenberg_add_param(
								{
									'name': 'now_text',
									'title': i18n.__( '"Now playing" text' ),
									'type': 'text',
								}, props
							),
							// Show tack time
							trx_addons_gutenberg_add_param(
								{
									'name': 'track_time',
									'title': i18n.__( 'Show tack time' ),
									'type': 'boolean'
								}, props
							),
							// Show track scroll bar
							trx_addons_gutenberg_add_param(
								{
									'name': 'track_scroll',
									'title': i18n.__( 'Show track scroll bar' ),
									'type': 'boolean'
								}, props
							),
							// Show track volume bar
							trx_addons_gutenberg_add_param(
								{
									'name': 'track_volume',
									'title': i18n.__( 'Show track volume bar' ),
									'type': 'boolean'
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
				props.attributes.media = trx_addons_gutenberg_get_child_attr( props );
				return el( wp.editor.InnerBlocks.Content, {} );
			},
		}
	);

	// Register block Audio Item
	blocks.registerBlockType(
		'trx-addons/audio-item', {
			title: i18n.__( 'Audio Item' ),
			description: i18n.__( "Insert audio item" ),
			icon: 'format-audio',
			category: 'trx-addons-widgets',
			parent: ['trx-addons/audio'],
			attributes: {
				url: {
					type: 'string',
					default: ''
				},
				embed: {
					type: 'string',
					default: ''
				},
				caption: {
					type: 'string',
					default: ''
				},
				author: {
					type: 'string',
					default: ''
				},
				description: {
					type: 'string',
					default: ''
				},
				cover: {
					type: 'number',
					default: 0
				},
				cover_url: {
					type: 'string',
					default: ''
				},
			},
			edit: function(props) {
				return trx_addons_gutenberg_block_params(
					{
						'title': i18n.__( 'Audio item' ) + (props.attributes.caption ? ': ' + props.attributes.caption : ''),
						'general_params': el(
							'div', {},
							// Media URL
							trx_addons_gutenberg_add_param(
								{
									'name': 'url',
									'title': i18n.__( 'Media URL' ),
									'type': 'text'
								}, props
							),
							// Embed code
							trx_addons_gutenberg_add_param(
								{
									'name': 'embed',
									'title': i18n.__( 'Embed code' ),
									'type': 'textarea'
								}, props
							),
							// Audio caption
							trx_addons_gutenberg_add_param(
								{
									'name': 'caption',
									'title': i18n.__( 'Audio caption' ),
									'type': 'text'
								}, props
							),
							// Author name
							trx_addons_gutenberg_add_param(
								{
									'name': 'author',
									'title': i18n.__( 'Author name' ),
									'type': 'text'
								}, props
							),
							// Description
							trx_addons_gutenberg_add_param(
								{
									'name': 'description',
									'title': i18n.__( 'Description' ),
									'type': 'textarea'
								}, props
							),
							// Cover image
							trx_addons_gutenberg_add_param(
								{
									'name': 'cover',
									'name_url': 'cover_url',
									'title': i18n.__( 'Cover image' ),
									'type': 'image'
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
})( window.wp.blocks, window.wp.editor, window.wp.i18n, window.wp.element, );
