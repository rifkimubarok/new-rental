// Return query params
//-------------------------------------------
function trx_addons_gutenberg_get_param_query() {
	return {
		// Query attributes
		ids: {
			type: 'string',
			default: ''
		},
		count: {
			type: 'number',
			default: 2
		},
		columns: {
			type: 'number',
			default: 2
		},
		offset: {
			type: 'number',
			default: 0
		},
		orderby: {
			type: 'string',
			default: 'none'
		},
		order: {
			type: 'string',
			default: 'asc'
		}
	};
}

function trx_addons_gutenberg_add_param_query(props) {
	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	var params = el( 'div', {},
		// IDs to show
		trx_addons_gutenberg_add_param(
			{
				'name': 'ids',
				'title': i18n.__( "IDs to show" ),
				'descr': i18n.__( "Comma separated list of IDs to display. If not empty, parameters 'cat', 'offset' and 'count' are ignored!" ),
				'type': 'text'
			}, props
		),
		// Count
		trx_addons_gutenberg_add_param(
			{
				'name': 'count',
				'title': i18n.__( "Count" ),
				'descr': i18n.__( "The number of displayed posts. If IDs are used, this parameter is ignored." ),
				'type': 'number',
				'min': 1,
				'dependency': {
					'ids': ['']
				}
			}, props
		),
		// Columns
		trx_addons_gutenberg_add_param(
			{
				'name': 'columns',
				'title': i18n.__( "Columns" ),
				'descr': i18n.__( "Specify the number of columns. If left empty or assigned the value '0' - auto detect by the number of items." ),
				'type': 'number',
				'min': 1,
				'max': 6
			}, props
		),
		// Offset
		trx_addons_gutenberg_add_param(
			{
				'name': 'offset',
				'title': i18n.__( "Offset" ),
				'descr': i18n.__( "Specify the number of items to be skipped before the displayed items." ),
				'type': 'number',
				'min': 0,
				'dependency': {
					'ids': ['']
				}
			}, props
		),
		// Order by
		trx_addons_gutenberg_add_param(
			{
				'name': 'orderby',
				'title': i18n.__( "Order by" ),
				'descr': i18n.__( "Select how to sort the posts" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_query_orderby'] )
			}, props
		),
		// Order
		trx_addons_gutenberg_add_param(
			{
				'name': 'order',
				'title': i18n.__( "Order" ),
				'descr': i18n.__( "Select sort order" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_query_orders'] )
			}, props
		)
	);

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "Query" ) },
						params
						)
					)
				);
}




// Return filters params
//-------------------------------------------
function trx_addons_gutenberg_get_param_filters() {
	var i18n   = window.wp.i18n;
	return {
		// Filters
		show_filters: {
			type: 'boolean',
			default: false
		},
		filters_title: {
			type: 'string',
			default: ''
		},
		filters_subtitle: {
			type: 'string',
			default: ''
		},
		filters_title_align: {
			type: 'string',
			default: 'left'
		},
		filters_taxonomy: {
			type: 'string',
			default: 'category'
		},
		filters_ids: {
			type: 'string',
			default: ''
		},
		filters_all: {
			type: 'boolean',
			default: true
		},
		filters_all_text: {
			type: 'string',
			default: i18n.__( 'All' )
		},
		filters_more_text: {
			type: 'string',
			default: i18n.__( 'More posts' )
		}
	};
}

function trx_addons_gutenberg_add_param_filters(props) {
	if (!TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type].hasOwnProperty(props.attributes.filters_taxonomy)) {
		props.attributes.filters_taxonomy = 0;
	}
	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	var params = el( 'div', {},
		// Filters title
		trx_addons_gutenberg_add_param(
			{
				'name': 'filters_title',
				'title': i18n.__( 'Filters area title' ),
				'descr': '',
				'type': 'text',
			}, props
		),
		// Filters subtitle
		trx_addons_gutenberg_add_param(
			{
				'name': 'filters_subtitle',
				'title': i18n.__( 'Filters area subtitle' ),
				'descr': '',
				'type': 'text',
			}, props
		),
		// Filters alignment
		trx_addons_gutenberg_add_param(
			{
				'name': 'filters_title_align',
				'title': i18n.__( 'Filters titles position' ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns_short'] )
			}, props
		),
		// Show filters
		trx_addons_gutenberg_add_param(
			{
				'name': 'show_filters',
				'title': i18n.__( 'Show filters tabs' ),
				'type': 'boolean'
			}, props
		),
		// Filters taxonomy
		trx_addons_gutenberg_add_param(
			{
				'name': 'filters_taxonomy',
				'title': i18n.__( 'Filters taxonomy' ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['taxonomies'][props.attributes.post_type], true ),
				'dependency': {
					'show_filters': [true]
				}
			}, props
		),
		// Filters taxonomy to show
		trx_addons_gutenberg_add_param(
			{
				'name': 'filters_ids',
				'title': i18n.__( 'Filters taxonomy to show' ),
				'descr': i18n.__( "Comma separated list with term IDs or term names to show as filters. If empty - show all terms from filters taxonomy above" ),
				'type': 'text',
				'dependency': {
					'show_filters': [true]
				}
			}, props
		),
		// Display the "All Filters" tab
		trx_addons_gutenberg_add_param(
			{
				'name': 'filters_all',
				'title': i18n.__( 'Show the "All" tab' ),
				'type': 'boolean',
				'dependency': {
					'show_filters': [true]
				}
			}, props
		),
		// "All Filters" tab text
		trx_addons_gutenberg_add_param(
			{
				'name': 'filters_all_text',
				'title': i18n.__( '"All" tab text' ),
				'type': 'text',
				'dependency': {
					'show_filters': [true]
				}
			}, props
		),
		// 'More posts' text
		trx_addons_gutenberg_add_param(
			{
				'name': 'filters_more_text',
				'title': i18n.__( "'More posts' text" ),
				'type': 'text',
				'dependency': {
					'show_filters': [false]
				}
			}, props
		)
	);

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "Filters" ) },
						params
						)
					)
				);
}



// Return slider params
//-------------------------------------------
function trx_addons_gutenberg_get_param_slider() {
	return {
		// Slider attributes
		slider: {
			type: 'boolean',
			default: false
		},
		slides_space: {
			type: 'number',
			default: 0
		},
		slides_centered: {
			type: 'boolean',
			default: false
		},
		slides_overflow: {
			type: 'boolean',
			default: false
		},
		slider_mouse_wheel: {
			type: 'boolean',
			default: false
		},
		slider_autoplay: {
			type: 'boolean',
			default: true
		},
		slider_controls: {
			type: 'string',
			default: 'none'
		},
		slider_pagination: {
			type: 'string',
			default: 'none'
		},
		slider_pagination_type: {
			type: 'string',
			default: 'bullets'
		}
	};
}

function trx_addons_gutenberg_add_param_slider(props) {
	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	var params = el( 'div', {},
		// Slider
		trx_addons_gutenberg_add_param(
			{
				'name': 'slider',
				'title': i18n.__( "Slider" ),
				'descr': i18n.__( "Show items as slider" ),
				'type': 'boolean'
			}, props
		),
		// Space
		trx_addons_gutenberg_add_param(
			{
				'name': 'slides_space',
				'title': i18n.__( "Space" ),
				'descr': i18n.__( "Space between slides" ),
				'type': 'number',
				'min': 0,
				'max': 50,
				'dependency': {
					'slider': [true]
				}
			}, props
		),
		// Slides centered
		trx_addons_gutenberg_add_param(
			{
				'name': 'slides_centered',
				'title': i18n.__( "Slides centered" ),
				'descr': i18n.__( "Center active slide" ),
				'type': 'boolean',
				'dependency': {
					'slider': [true]
				}
			}, props
		),
		// Slides overflow visible
		trx_addons_gutenberg_add_param(
			{
				'name': 'slides_overflow',
				'title': i18n.__( "Slides overflow visible" ),
				'descr': i18n.__( "Don't hide slides outside the borders of the viewport" ),
				'type': 'boolean',
				'dependency': {
					'slider': [true]
				}
			}, props
		),
		// Enable mouse wheel
		trx_addons_gutenberg_add_param(
			{
				'name': 'slider_mouse_wheel',
				'title': i18n.__( "Enable mouse wheel" ),
				'descr': i18n.__( "Enable mouse wheel to control slides" ),
				'type': 'boolean',
				'dependency': {
					'slider': [true]
				}
			}, props
		),
		// Enable autoplay
		trx_addons_gutenberg_add_param(
			{
				'name': 'slider_autoplay',
				'title': i18n.__( "Enable autoplay" ),
				'descr': i18n.__( "Enable autoplay for this slider" ),
				'type': 'boolean',
				'dependency': {
					'slider': [true]
				}
			}, props
		),
		// Slider controls
		trx_addons_gutenberg_add_param(
			{
				'name': 'slider_controls',
				'title': i18n.__( "Slider controls" ),
				'descr': i18n.__( "Show arrows in the slider" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_controls'] ),
				'dependency': {
					'slider': [true]
				}
			}, props
		),
		// Slider pagination
		trx_addons_gutenberg_add_param(
			{
				'name': 'slider_pagination',
				'title': i18n.__( "Slider pagination" ),
				'descr': i18n.__( "Show pagination in the slider" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_paginations'] ),
				'dependency': {
					'slider': [true]
				}
			}, props
		),
		// Slider pagination type
		trx_addons_gutenberg_add_param(
			{
				'name': 'slider_pagination_type',
				'title': i18n.__( "Slider pagination type" ),
				'descr': i18n.__( "Select type of the pagination in the slider" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_slider_paginations_types'] ),
				'dependency': {
					'slider': [true],
					'slider_pagination': ['bullets', 'fraction', 'progressbar']
				}
			}, props
		)
	);

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "Slider" ) },
						params
						)
					)
				);
}



// Return button params
//-------------------------------------------
function trx_addons_gutenberg_get_param_button() {
	return {
		// Button attributes
		link: {
			type: 'string',
			default: ''
		},
		link_text: {
			type: 'string',
			default: ''
		},
		link_style: {
			type: 'string',
			default: ''
		},
		link_image: {
			type: 'number',
			default: 0
		},
		link_image_url: {
			type: 'string',
			default: ''
		}
	};
}

function trx_addons_gutenberg_add_param_button(props) {
	var el   = window.wp.element.createElement;
	var i18n = window.wp.i18n;
	var attr = props.attributes;
	return el( 'div', {},
		// Button's URL
		trx_addons_gutenberg_add_param(
			{
				'name': 'link',
				'title': i18n.__( "Button's URL" ),
				'descr': i18n.__( "Link URL for the button at the bottom of the block" ),
				'type': 'text'
			}, props
		),
		// Button's text
		trx_addons_gutenberg_add_param(
			{
				'name': 'link_text',
				'title': i18n.__( "Button's text" ),
				'descr': i18n.__( "Caption for the button at the bottom of the block" ),
				'type': 'text'
			}, props
		),
		// Button's style
		trx_addons_gutenberg_add_param(
			{
				'name': 'link_style',
				'title': i18n.__( "Button's style" ),
				'descr': i18n.__( "Select the style (layout) of the button" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_button'] )
			}, props
		),
		// Button's image
		trx_addons_gutenberg_add_param(
			{
				'name': 'link_image',
				'name_url': 'link_image_url',
				'title': i18n.__( "Button's image" ),
				'descr': i18n.__( "Select the promo image from the library for this button" ),
				'type': 'image'
			}, props
		)
	);
}



// Return button 2 params
//-------------------------------------------
function trx_addons_gutenberg_get_param_button2() {
	return {
		// Button attributes
		link2: {
			type: 'string',
			default: ''
		},
		link2_text: {
			type: 'string',
			default: ''
		},
		link2_style: {
			type: 'string',
			default: ''
		}
	};
}

function trx_addons_gutenberg_add_param_button2(props) {
	var el   = window.wp.element.createElement;
	var i18n = window.wp.i18n;
	var attr = props.attributes;
	return el( 'div', {},
		// Button 2 URL
		trx_addons_gutenberg_add_param(
			{
				'name': 'link2',
				'title': i18n.__( 'Button 2 URL' ),
				'descr': i18n.__( "URL for the second button (at the side of the image)" ),
				'type': 'text',
				'dependency': {
					'type': ['modern']
				}
			}, props
		),
		// Button 2 text
		trx_addons_gutenberg_add_param(
			{
				'name': 'link2_text',
				'title': i18n.__( 'Button 2 text' ),
				'descr': i18n.__( "Caption for the second button (at the side of the image)" ),
				'type': 'text',
				'dependency': {
					'type': ['modern']
				}
			}, props
		),
		// Button 2 style
		trx_addons_gutenberg_add_param(
			{
				'name': 'link2_style',
				'title': i18n.__( 'Button 2 style' ),
				'descr': i18n.__( "Select the style (layout) of the second button" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_button'] ),
				'dependency': {
					'type': ['modern']
				}
			}, props
		),
	);
}



// Return title params
//-------------------------------------------
function trx_addons_gutenberg_get_param_title() {
	return {
		// Title attributes
		title_style: {
			type: 'string',
			default: ''
		},
		title_tag: {
			type: 'string',
			default: ''
		},
		title_align: {
			type: 'string',
			default: ''
		},
		title_color: {
			type: 'string',
			default: ''
		},
		title_color2: {
			type: 'string',
			default: ''
		},
		gradient_direction: {
			type: 'number',
			default: 0
		},
		title: {
			type: 'string',
			default: ''
		},
		subtitle: {
			type: 'string',
			default: ''
		},
		subtitle_align: {
			type: 'string',
			default: 'none'
		},
		subtitle_position: {
			type: 'string',
			default: TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_subtitle_position']
		},
		description: {
			type: 'string',
			default: ''
		},
		typed: {
			type: 'boolean',
			default: false
		},
		typed_loop: {
			type: 'boolean',
			default: true
		},
		typed_cursor: {
			type: 'boolean',
			default: true
		},
		typed_strings: {
			type: 'string',
			default: ''
		},
		typed_color: {
			type: 'string',
			default: ''
		},
		typed_speed: {
			type: 'number',
			default: 6
		},
		typed_delay: {
			type: 'number',
			default: 1
		}
	};
}

function trx_addons_gutenberg_add_param_title(props, button, button2) {
	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	var attr   = props.attributes;
	var params = el( 'div', {},
		// Title style
		trx_addons_gutenberg_add_param(
			{
				'name': 'title_style',
				'title': i18n.__( 'Title style' ),
				'descr': i18n.__( "Select style of the title and subtitle" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_layouts']['sc_title'] )
			}, props
		),
		// Title tag
		trx_addons_gutenberg_add_param(
			{
				'name': 'title_tag',
				'title': i18n.__( 'Title tag' ),
				'descr': i18n.__( "Select tag (level) of the title" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_title_tags'] )
			}, props
		),
		// Title alignment
		trx_addons_gutenberg_add_param(
			{
				'name': 'title_align',
				'title': i18n.__( 'Title alignment' ),
				'descr': i18n.__( "Select alignment of the title, subtitle and description" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
			}, props
		),
		// Color
		trx_addons_gutenberg_add_param(
			{
				'name': 'title_color',
				'title': i18n.__( 'Color' ),
				'descr': i18n.__( "Title custom color" ),
				'type': 'color'
			}, props
		),
		// Color 2
		trx_addons_gutenberg_add_param(
			{
				'name': 'title_color2',
				'title': i18n.__( 'Color 2' ),
				'descr': i18n.__( "Used for gradient." ),
				'type': 'color',
				'dependency': {
					'title_style': ['gradient']
				}
			}, props
		),
		// Gradient direction
		trx_addons_gutenberg_add_param(
			{
				'name': 'gradient_direction',
				'title': i18n.__( 'Gradient direction' ),
				'descr': i18n.__( "Gradient direction in degress (0 - 360)" ),
				'type': 'number',
				'min': 0,
				'max': 360,
				'step': 1,
				'dependency': {
					'title_style': ['gradient']
				}
			}, props
		),
		// Title
		trx_addons_gutenberg_add_param(
			{
				'name': 'title',
				'title': i18n.__( 'Title' ),
				'descr': i18n.__( "Title of the block. Enclose any words in {{ and }} to make them italic or in (( and )) to make them bold. If title style is 'accent' - bolded element styled as shadow, italic - as a filled circle" ),
				'type': 'text'
			}, props
		),
		// Autotype
		trx_addons_gutenberg_add_param(
			{
				'name': 'typed',
				'title': i18n.__( 'Use autotype' ),
				'descr': '',
				'type': 'boolean'
			}, props
		),
		// Autotype loop
		trx_addons_gutenberg_add_param(
			{
				'name': 'typed_loop',
				'title': i18n.__( 'Autotype loop' ),
				'descr': '',
				'dependency': {
					'typed': [true]
				},
				'type': 'boolean'
			}, props
		),
		// Autotype cursor
		trx_addons_gutenberg_add_param(
			{
				'name': 'typed_cursor',
				'title': i18n.__( 'Autotype cursor' ),
				'descr': '',
				'dependency': {
					'typed': [true]
				},
				'type': 'boolean'
			}, props
		),
		// Autotype strings
		trx_addons_gutenberg_add_param(
			{
				'name': 'typed_strings',
				'title': i18n.__( 'Alternative strings' ),
				'descr': i18n.__( "Alternative strings to type. Attention! First string must be equal of the part of the title." ),
				'dependency': {
					'typed': [true]
				},
				'rows': 5,
				'type': 'textarea'
			}, props
		),
		// Color
		trx_addons_gutenberg_add_param(
			{
				'name': 'typed_color',
				'title': i18n.__( 'Autotype color' ),
				'descr': '',
				'dependency': {
					'typed': [true]
				},
				'type': 'color'
			}, props
		),
		// Autotype speed
		trx_addons_gutenberg_add_param(
			{
				'name': 'typed_speed',
				'title': i18n.__( "Autotype speed" ),
				'descr': i18n.__( "Typing speed from 1 (min) to 10 (max)" ),
				'type': 'number',
				'min': 1,
				'max': 10,
				'step': 0.5,
				'dependency': {
					'typed': [true]
				}
			}, props
		),
		// Autotype delay
		trx_addons_gutenberg_add_param(
			{
				'name': 'typed_delay',
				'title': i18n.__( "Autotype delay" ),
				'descr': i18n.__( "Delay before erase text" ),
				'type': 'number',
				'min': 0,
				'max': 10,
				'step': 0.5,
				'dependency': {
					'typed': [true]
				}
			}, props
		),
		// Subtitle
		trx_addons_gutenberg_add_param(
			{
				'name': 'subtitle',
				'title': i18n.__( 'Subtitle' ),
				'descr': i18n.__( "Subtitle of the block" ),
				'type': 'text'
			}, props
		),
		// Subtitle alignment
		trx_addons_gutenberg_add_param(
			{
				'name': 'subtitle_align',
				'title': i18n.__( 'Subtitle alignment' ),
				'descr': i18n.__( "Select alignment of the subtitle" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_aligns'] )
			}, props
		),
		// Subtitle position
		trx_addons_gutenberg_add_param(
			{
				'name': 'subtitle_position',
				'title': i18n.__( 'Subtitle position' ),
				'descr': i18n.__( "Select position of the subtitle" ),
				'type': 'select',
				'options': trx_addons_gutenberg_get_lists( TRX_ADDONS_STORAGE['gutenberg_sc_params']['sc_subtitle_positions'] )
			}, props
		),
		// Description
		trx_addons_gutenberg_add_param(
			{
				'name': 'description',
				'title': i18n.__( 'Description' ),
				'descr': i18n.__( "Description of the block" ),
				'type': 'textarea'
			}, props
		),
		// Button
		button ? trx_addons_gutenberg_add_param_button( props ) : '',
		// Button 2
		button2 ? trx_addons_gutenberg_add_param_button2( props ) : ''
	);

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "Title" ) },
						params
						)
					)
				);
}



// Hide on devices params
//-------------------------------------------
function trx_addons_gutenberg_get_param_hide(frontpage) {
	return trx_addons_object_merge(
		{
			// Hide on devices attributes
			hide_on_wide: {
				type: 'boolean',
				default: false
			},
			hide_on_desktop: {
				type: 'boolean',
				default: false
			},
			hide_on_notebook: {
				type: 'boolean',
				default: false
			},
			hide_on_tablet: {
				type: 'boolean',
				default: false
			},
			hide_on_mobile: {
				type: 'boolean',
				default: false
			}
		},
		! frontpage ? {} : {
			hide_on_frontpage: {
				type: 'boolean',
				default: false
			},
			hide_on_singular: {
				type: 'boolean',
				default: false
			},
			hide_on_other: {
				type: 'boolean',
				default: false
			}			
		}
	);
}

function trx_addons_gutenberg_add_param_hide(props, hide_on_frontpage) {
	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	var params = el( 'div', {},
		// Hide on wide
		trx_addons_gutenberg_add_param(
			{
				'name': 'hide_on_wide',
				'title': i18n.__( 'Hide on wide' ),
				'descr': i18n.__( "Hide this item on wide screens" ),
				'type': 'boolean'
			}, props
		),
		// Hide on desktops
		trx_addons_gutenberg_add_param(
			{
				'name': 'hide_on_desktop',
				'title': i18n.__( 'Hide on desktops' ),
				'descr': i18n.__( "Hide this item on desktops" ),
				'type': 'boolean'
			}, props
		),
		// Hide on notebooks
		trx_addons_gutenberg_add_param(
			{
				'name': 'hide_on_notebook',
				'title': i18n.__( 'Hide on notebooks' ),
				'descr': i18n.__( "Hide this item on notebooks" ),
				'type': 'boolean'
			}, props
		),
		// Hide on tablets
		trx_addons_gutenberg_add_param(
			{
				'name': 'hide_on_tablet',
				'title': i18n.__( 'Hide on tablets' ),
				'descr': i18n.__( "Hide this item on tablets" ),
				'type': 'boolean'
			}, props
		),
		// Hide on mobile devices
		trx_addons_gutenberg_add_param(
			{
				'name': 'hide_on_mobile',
				'title': i18n.__( 'Hide on mobile devices' ),
				'descr': i18n.__( "Hide this item on mobile devices" ),
				'type': 'boolean'
			}, props
		),
		hide_on_frontpage ?
		el( 'div', {},
			// Hide on Frontpage
			trx_addons_gutenberg_add_param(
				{
					'name': 'hide_on_frontpage',
					'title': i18n.__( 'Hide on Frontpage' ),
					'descr': i18n.__( "Hide this item on the Frontpage" ),
					'type': 'boolean'
				}, props
			),
			// Hide on single posts
			trx_addons_gutenberg_add_param(
				{
					'name': 'hide_on_singular',
					'title': i18n.__( 'Hide on single posts' ),
					'descr': i18n.__( "Hide this item on single posts" ),
					'type': 'boolean'
				}, props
			),
			// Hide on other pages
			trx_addons_gutenberg_add_param(
				{
					'name': 'hide_on_other',
					'title': i18n.__( 'Hide on other pages' ),
					'descr': i18n.__( "Hide this item on other pages" ),
					'type': 'boolean'
				}, props
			),
		) : ''
	);

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "Hide on devices" ) },
						params
						)
					)
				);
}



// Return ID, Class, CSS params
//-------------------------------------------
function trx_addons_gutenberg_get_param_id() {
	return {
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
		}
	};
}

function trx_addons_gutenberg_add_param_id(props, id_name) {
	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;
	if (id_name === undefined) id_name = 'id';
	var params = el( 'div', {},
		// Element ID
		trx_addons_gutenberg_add_param(
			{
				'name': id_name,
				'title': i18n.__( 'Element ID' ),
				'descr': i18n.__( "ID for current element" ),
				'type': 'text'
			}, props
		),
		// Element CSS class
		trx_addons_gutenberg_add_param(
			{
				'name': 'class',
				'title': i18n.__( 'Element CSS class' ),
				'descr': i18n.__( "CSS class for current element" ),
				'type': 'text'
			}, props
		),
		// CSS box
		trx_addons_gutenberg_add_param(
			{
				'name': 'css',
				'title': i18n.__( 'CSS box' ),
				'descr': i18n.__( "Design Options" ),
				'type': 'textarea'
			}, props
		)
	);

	return el( wp.element.Fragment, {},
				el( wp.editor.InspectorControls, {},
					el( wp.components.PanelBody, { title: i18n.__( "ID & Class" ) },
						params
						)
					)
				);
}





//
//
//
// ADD PARAMETERS
// Parameters constructor
//-------------------------------------------
function trx_addons_gutenberg_block_params(args, props){
	var blocks = window.wp.blocks;
	var el     = window.wp.element.createElement;
	var i18n   = window.wp.i18n;

	return [
			// Title
			args['title']
				? el( 'div', { className: 'editor-block-params' },
					el( 'span', {}, args['title'] )
					)
				: '',

			// General params
			args['general_params']
				? el( wp.element.Fragment, {},
					el( wp.editor.InspectorControls, {},
						el( wp.components.PanelBody, { title: i18n.__( "General" ) },
							args['general_params']
							)
						)
					)
				: '',

			// Additional params
			args['additional_params']
				? args['additional_params']
				: '',

			// Block render
			args['render']
				? el( wp.components.ServerSideRender, {
						block: props.name,
						attributes: props.attributes
					} )
				: '',

			// Block "reload" button
			args['render_button']
				? el( wp.components.Button, {
						className: 'button wp-block-reload trx_addons_gb_reload',// + (!args['parent'] ? ' hide' : ''),
						onClick: function(x) {
							var block = wp.data.select("core/editor").getBlock(props.clientId);
							var block_type = blocks.getBlockType( props.name );

							// If block have inner blocks - update their attributes in the parent block
							if ( block && typeof block.innerBlocks == 'object' && block.innerBlocks.length > 0 && typeof block_type.save != 'undefined' ) {
								block_type.save(block);
								props.setAttributes( block.attributes );
							}

							// Change attribute 'reload' to get new layout from server
							var upd_attr = {
								'reload': Math.floor( Math.random() * 100 )
							};
							props.setAttributes( upd_attr );

							// Reload hidden elements like sliders
							trx_addons_gutenberg_reload_hidden_elements( props );
							}
						},
						''	//i18n.__( "Reload" )
					)
				: '',

			// Block items
			args['parent']
				? el( wp.components.PanelBody, {
							title: i18n.__( "Inner blocks" ),
							className: 'wp-inner-blocks trx_addons_gb_inner_blocks',	//remove 'wp-block-columns'
						},
						el( wp.editor.InnerBlocks, {
							allowedBlocks: args['allowedblocks'] ? args['allowedblocks'] : [ 'core/paragraph' ]
							}
						)
					)
				: ''
		];
}

// Add new parameter by type
//-------------------------------------------
function trx_addons_gutenberg_add_param(args, props){
	var el   = window.wp.element.createElement;
	var i18n = window.wp.i18n;

	// Set variables
	var param_name     	= args['name'] ? args['name'] : '';
	var param_name_url 	= args['name_url'] ? args['name_url'] : '';
	var param_title    	= args['title'] ? args['title'] : '';
	var param_descr    	= args['descr'] ? args['descr'] : '';
	var param_options  	= args['options'] ? args['options'] : '';
	var param_value    	= param_name ? props.attributes[param_name] : '';
	var param_url_value	= param_name_url ? props.attributes[param_name_url] : '';
	var upd_attr       	= {};

	// Set onChange functions
	var param_change     = function(x) {
								upd_attr[param_name] = x;
								props.setAttributes( upd_attr );
								// Reload hidden elements like sliders
								trx_addons_gutenberg_reload_hidden_elements( props, param_name, x );
	};
	var param_change_img = function(x) {
								upd_attr[param_name]     = x.id;
								upd_attr[param_name_url] = x.url;
								props.setAttributes( upd_attr );
								// Reload hidden elements like sliders
								trx_addons_gutenberg_reload_hidden_elements( props, param_name, x );
	};

	// Parameters dependency
	var dependency = true;
	if (args['dependency']) {
		for (var i in args['dependency']) { 
			for (var t in args['dependency'][i]) {
				if ( dependency === true 
					&& 
					( props.attributes[i] === args['dependency'][i][t] 
						||
						((''+args['dependency'][i][t]).charAt(0) == '^' && props.attributes[i] !== args['dependency'][i][t].substr(1))
					)
				) {
					dependency = false;
				}	
			}
		}
	} else {
		dependency = false;
	}

	// Return parameters options
	if ( dependency === false ) {
		if (args['type'] === 'text') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( wp.components.TextControl, {
							label: param_descr,
							value: param_value,
							onChange: param_change
							}
						)
					);
		}
		if (args['type'] === 'textarea') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( wp.components.TextareaControl, {
							label: param_descr,
							value: param_value,
							onChange: param_change
							}
						)
					);
		}
		if (args['type'] === 'boolean') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el(	wp.components.ToggleControl, {
							label: param_descr,
							checked: param_value,
							onChange: param_change
							}
						)
					);
		}
		if (args['type'] === 'select') {
			if (args['multiple']) {
				param_value = param_value.split( ',' );
			}
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( wp.components.SelectControl, {
							multiple: args['multiple'] ? 1 : 0,
							size: args['multiple'] ? 9 : 1,
							label: param_descr,
							value: param_value,
							onChange: function(x) {
								if (args['multiple']) {
									var y = '';
									for (var i = 0; i < x.length; i++) {
										y = y + (y ? ',' : '') + x[i];
									}
									upd_attr[param_name] = y;
								} else {
									upd_attr[param_name] = x;
								}
								props.setAttributes( upd_attr );
								// Reload hidden elements like sliders
								trx_addons_gutenberg_reload_hidden_elements( props, param_name, x );
							},
							options: param_options
							}
						)
					);
		}
		if (args['type'] === 'number') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( wp.components.RangeControl, {
							label: param_descr,
							value: param_value,
							onChange: param_change,
							min: args['min'],
							max: args['max'],
							step: args['step']
							}
						)
					);
		}
		if (args['type'] === 'color') {
			return el( 'div', { style: { position: 'relative' } },
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( 'p', {}, param_descr ),
						el( wp.components.ColorPalette, {
								value: param_value,
								colors: TRX_ADDONS_STORAGE['gutenberg_sc_params']['theme_colors'],
								onChange: param_change
								}
							),
						el( 'div', {
								className: "components-color-palette-preview",
								style: {backgroundColor: param_value}
								}
							)
						);
		}
		if (args['type'] === 'image') {
			return el( 'div', {},
						el( 'h3', { className: "components-base-control-title" }, param_title ),
						el( 'p', {}, param_descr ),
						el( wp.editor.MediaUpload, {
								onSelect: param_change_img,
								type: 'image',
								value: param_value,
								render: function(obj) {
									return el( 'div', {},
												el( wp.components.Button, {
													className: param_value ? 'image-button-1' : 'components-button button button-large button-one',
													onClick: obj.open
													},
													param_value
														? el( 'img', { src: param_url_value } )
														: i18n.__( 'Upload Image' )
												),
												param_value
													? el( wp.components.Button, {
																className: 'components-button button button-large button-one',
																onClick: function(x) {
																	upd_attr[param_name]     = 0
																	upd_attr[param_name_url] = 0;
																	props.setAttributes( upd_attr );
																}
															},
															i18n.__( 'Remove Image' )
														)
													: ''
												);
								}
							}
						)
					);
		}
	}
}

// Rewrite array with options for gutenberg
//-------------------------------------------
function trx_addons_gutenberg_get_lists(list, none) {
	var i18n   = window.wp.i18n;
	var output = [];
	if (list != '') {
		jQuery.each(
			list, function(key, value) {
				output.push(
					{
						value: key,
						label: value
					}
				);
			}
		);
	}
	if (none) {
		output[output.length] = {
			value: "0", 
			label: i18n.__( "-" )
		};
	}
	return output;
}

// Return iconed classes list
//-------------------------------------------
function trx_addons_gutenberg_get_option_icons_classes() {
	var output = [];
	var icons  = TRX_ADDONS_STORAGE['gutenberg_sc_params']['icons_classes'];
	if (icons != '') {
		jQuery.each(
			icons, function(key, value) {
				output.push(
					{
						value: value,
						label: value
					}
				);
			}
		);
	}
	return output;
}

// Get child block values of attributes
//-------------------------------------------
function trx_addons_gutenberg_get_child_attr(props) {
	var i = 0, S = 0, N = props.innerBlocks.length, items = {};
	if (N > 0) {
		while (i < N) {
			if (props.innerBlocks[i].name && props.innerBlocks[i].name.indexOf('core/') == -1){ 
				items[i] = props.innerBlocks[i].attributes;
				S++;
			}
			i++;
		} 
		if (S > 0) {
			return JSON.stringify( items );
		} else {
			return '';
		}
	} else {
		return '';
	}
}


// Reload blocks after page loading
//-------------------------------------------
jQuery( window ).load( function() {
	trx_addons_gutenberg_first_init();
	// Create the observer to reinit visual editor after switch from code editor to visual editor
	if (typeof window.MutationObserver !== 'undefined') {
		trx_addons_create_observer('check_visual_editor', jQuery('.block-editor').eq(0), function(mutationsList) {
			var gutenberg_editor = jQuery('.edit-post-visual-editor:not(.trx_addons_inited)').eq(0);
			if (gutenberg_editor.length > 0) trx_addons_gutenberg_first_init();
		});
	}
} );

function trx_addons_gutenberg_first_init() {

	var gutenberg_editor = jQuery('.edit-post-visual-editor:not(.trx_addons_inited)').eq(0);
	if (gutenberg_editor.length == 0) return;
	
	// Add class with post-type to the visual editor wrapper
	var pt_class = jQuery('body').attr('class').match(/post\-type\-[^ ]*/);
	if (pt_class && typeof pt_class[0] !== 'undefined') {
		jQuery('.edit-post-visual-editor').addClass(pt_class[0]);
	}

	// Decorate inner blocks - hide it to the button
	jQuery('.trx_addons_gb_inner_blocks.is-opened').each(function() {
		if (jQuery(this).css('position') == 'absolute') {
			jQuery(this).find('>.components-panel__body-title>button').trigger('click');
		}
	});

	// Create the observer for assign 'Blog item' position to the parent block
	if (typeof window.MutationObserver !== 'undefined') {
		trx_addons_create_observer('blog-item-position', gutenberg_editor, function(mutationsList) {
			for (var mutation of mutationsList) {
				if (mutation.type == 'childList') {
					gutenberg_editor.find('[data-type="trx-addons/layouts-blog-item"]').each(function() {
						var item = jQuery(this),
							item_position = item.find('[data-blog-item-position]').data('blog-item-position');
						if ( item_position !== undefined && !item.hasClass('sc_layouts_blog_item_position_'+item_position)) {
							var classes = item.attr('class').split(' '),
								classes_new = '';
							for (var i=0; i<classes.length; i++) {
								if (classes[i].indexOf('sc_layouts_blog_item_position_') < 0) {
									classes_new += (classes_new != '' ? ' ' : '') + classes[i];
								}
							}
							classes_new += (classes_new != '' ? ' ' : '') + 'sc_layouts_blog_item_position_' + item_position;
							item.attr('class', classes_new);
						}
					});
					break;
				}
			}
		});
	}

	// Reload dynamic blocks on post editor is loaded
	if (wp && wp.data) {
		wp.data.select( 'core/editor' ).getEditedPostContent();
		jQuery( '.components-button.wp-block-reload' ).click();
	}

	// Init hidden elements
	jQuery( document ).trigger( 'action.init_hidden_elements', [gutenberg_editor] );

	// Init 
	jQuery( document ).trigger( 'action.init_gutenberg', [gutenberg_editor] );

	gutenberg_editor.addClass('trx_addons_inited');
}


// Create mutations observer
var trx_addons_observers = {};
function trx_addons_create_observer(id, obj, callback) {
	if (typeof window.MutationObserver !== 'undefined' && obj.length > 0) {
		if (typeof trx_addons_observers[id] == 'undefined') {
			trx_addons_observers[id] = new MutationObserver(callback);
			trx_addons_observers[id].observe(obj.get(0), { attributes: false, childList: true, subtree: true });
		}
		return true;
	}
	return false;
}


// Init hidden elements when loaded
var trx_addons_gutenberg_block_reload_started = {};
function trx_addons_gutenberg_reload_hidden_elements(props, param_name, x){
	if (props) {
		trx_addons_gutenberg_block_reload_started[props.clientId] = typeof trx_addons_gutenberg_block_reload_started[props.clientId] == 'undefined' ? 1 : trx_addons_gutenberg_block_reload_started[props.clientId] + 1;
		var block = jQuery( '[data-block="' + props.clientId + '"]' );
		block.addClass( 'reload_mask' );
		// Catch when block is loaded and init hidden element
		var rez = false;
		if (typeof window.MutationObserver !== 'undefined') {
			// Create an observer instance to catch when block is loaded
			rez = trx_addons_create_observer(props.clientId, block, function(mutationsList) {
				for (var mutation of mutationsList) {
					if (mutation.type == 'childList' || mutation.type == 'subtree' ) {
						if ( trx_addons_gutenberg_block_reload_started.hasOwnProperty(props.clientId)
							&& trx_addons_gutenberg_block_reload_started[props.clientId] > 0
							&& block.find('> div [class*="sc_"]').length > 0
						) {
							trx_addons_gutenberg_block_reload_started[props.clientId] = Math.max(0, trx_addons_gutenberg_block_reload_started[props.clientId] - 1);
							block.removeClass( 'reload_mask' );
							jQuery(document).trigger('action.init_hidden_elements', [ block ]);
						}
						break;
					}
				}
			});
		}
		// If MutationObserver is not supported - wait 5 sec and init hidden elements
		// Otherwise - wait 10 sec
		setTimeout(
			function(){
				trx_addons_gutenberg_block_reload_started[props.clientId] = Math.max(0, trx_addons_gutenberg_block_reload_started[props.clientId] - 1);
				block.removeClass( 'reload_mask' );
				jQuery( document ).trigger( 'action.init_hidden_elements', [ block ] );
			}, !rez ? 5000 : 10000
		);
	}
}
