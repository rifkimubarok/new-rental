( function() {

	'use strict';

	var $window = jQuery( window ),
		$body   = jQuery( 'body' );


	$window.on( 'elementor/frontend/init', function() {
		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/section', function( $target ) {
			var parallax = new trx_addons_parallax( $target );
			parallax.init();
		} );
		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $target ) {
			var parallax = new trx_addons_parallax( $target );
			parallax.init();
		} );
	} );

	window.trx_addons_parallax = function( $target ) {
		var self          = this,
			settings      = false,
			parallax_type = 'none',
			edit_mode     = Boolean( window.elementorFrontend.isEditMode() ),
			scroll_list   = [],
			mouse_list    = [],
			wst           = $window.scrollTop(),
			ww            = $window.width(),
			wh            = $window.height(),
			tx            = 0,
			ty            = 0,
			is_safari     = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/),
			platform      = navigator.platform;

		self.init = function() {
			if ( ! edit_mode ) {
				settings = $target.data( 'parallax-blocks' ) || false;
				if ( ! settings ) {
					var params = $target.data( 'parallax-params' ) || false;					
					if ( params ) {
						settings = [];
						settings.push(params);
						parallax_type = 'blocks';
					}
				} else {
					parallax_type = 'layers';
				}
			} else {
				settings = self.get_editor_settings( $target );
			}
			if ( ! settings ) return false;
			if ( parallax_type == 'layers' ) {
				self.create_layers();
				$target.on( 'mousemove.trx_addons_parallax', self.mouse_move_handler );
				$target.on( 'mouseleave.trx_addons_parallax', self.mouse_leave_handler );
			} else if ( parallax_type == 'blocks' ) {
				settings[0].selector = $target;
				scroll_list.push(settings[0]);
			}
			$window.on( 'action.resize_trx_addons action.scroll_trx_addons', self.scroll_handler );
			self.scroll_update();
		};

		self.get_editor_settings = function( $target ) {
			if ( ! window.elementor.hasOwnProperty( 'elements' ) ) {
				return false;
			}

			var elements = window.elementor.elements;

			if ( ! elements.models ) {
				return false;
			}

			var section_id = $target.data('id'),
				section_data = {};

			jQuery.each( elements.models, function( index, obj ) {
				if ( section_id == obj.id ) {
					section_data = obj.attributes.settings.attributes;
				}
			} );

			if ( 0 === Object.keys( section_data ).length ) {
				return false;
			}

			var settings = [];

			if ( section_data.hasOwnProperty( 'parallax_blocks' ) ) {
				parallax_type = 'layers';
				jQuery.each( section_data[ 'parallax_blocks' ].models, function( index, obj ) {
					settings.push( obj.attributes );
				} );
			} else if ( section_data.hasOwnProperty( 'parallax' ) ) {
				parallax_type = 'blocks';
				settings.push( {
					type: section_data.hasOwnProperty( 'parallax_type' ) ? section_data.parallax_type : 'object',
					x: section_data.hasOwnProperty( 'parallax_x' ) ? section_data.parallax_x.size : 0,
					y: section_data.hasOwnProperty( 'parallax_y' ) ? section_data.parallax_y.size : 0,
					scale: section_data.hasOwnProperty( 'parallax_scale' ) ? section_data.parallax_scale.size : 0,
					rotate: section_data.hasOwnProperty( 'parallax_rotate' ) ? section_data.parallax_rotate.size : 0,
					opacity: section_data.hasOwnProperty( 'parallax_opacity' ) ? section_data.parallax_opacity.size : 0,
					duration: section_data.hasOwnProperty( 'parallax_duration' ) ? section_data.parallax_duration.size : 1,
					text: section_data.hasOwnProperty( 'parallax_text' ) ? section_data.parallax_text : 'block'
				} );
			}

			if ( 0 !== settings.length ) {
				return settings;
			}

			return false;
		};

		self.create_layers = function() {

			$target.find( '> .sc_parallax_block' ).remove();
			$.each( settings, function( index, block ) {
				var image       = block['image'].url,
					speed       = block['speed'].size || 50,
					z_index     = block['z_index'].size,
					bg_size     = block['bg_size'] || 'auto',
					anim_prop   = block['animation_prop'] || 'background',
					left        = block['left'].size,
					top         = block['top'].size,
					type        = block['type'] || 'none',
					$layout     = null;

				if ( '' !== image || 'none' !== type ) {
					var layout_init = {
						'z-index': z_index
					};
					if ( 'none' === type ) {
						layout_init['left'] = left + '%';
						layout_init['top'] = top + '%';
					}
					$layout = jQuery( '<div class="sc_parallax_block sc_parallax_block_type_' + type
											+ (is_safari ? ' is-safari' : '')
											+ ('MacIntel' == platform ? ' is-mac' : '')
											+ (typeof block['class'] !== undefined && block['class'] != '' ? ' ' + block['class'] : '')
										+ '"><div class="sc_parallax_block_image"></div></div>' )
								.prependTo( $target )
								.css( layout_init );

					layout_init = {
						'background-image': 'url(' + image + ')',
						'background-size': bg_size,
						'background-position-x': left + '%',
						'background-position-y': top + '%'
					};
					$layout.find( '> .sc_parallax_block_image' ).css(layout_init);

					var layout_data = {
						selector: $layout,
						image: image,
						size: bg_size,
						prop: anim_prop,
						type: type,
						x: left,
						y: top,
						z: z_index,
						speed: 2 * ( speed / 100 )
					};

					if ( 'scroll' === type ) {
						scroll_list.push( layout_data );
					} else if ( 'mouse' === type ) {
						mouse_list.push( layout_data );
					}

				}
			});
		};


		// Mouse move/leave handlers
		//-----------------------------------------
		self.mouse_move_handler = function( e ) {
			var cx = Math.ceil( ww / 2 ),
				cy = Math.ceil( wh / 2 ),
				dx = e.clientX - cx,
				dy = e.clientY - cy;
			tx = -1 * ( dx / cx );
			ty = -1 * ( dy / cy );
			self.mouse_move_update();
		};

		self.mouse_leave_handler = function( e ) {
			jQuery.each( mouse_list, function( index, block ) {
				var $image = block.selector.find( '.sc_parallax_block_image' ).eq(0);
				if ( block.prop == 'transform3d' ) {
					TweenMax.to(
						$image,
						1.5, {
							x: 0,
							y: 0,
							z: 0,
							rotationX: 0,
							rotationY: 0,
							ease:Power2.easeOut
						}
					);
				}

			} );
		};

		self.mouse_move_update = function() {
			jQuery.each( mouse_list, function( index, block ) {
				var $image   = block.selector.find( '.sc_parallax_block_image' ).eq(0),
					speed    = block.speed,
					x        = parseFloat( tx * 125 * speed ).toFixed(1),
					y        = parseFloat( ty * 125 * speed ).toFixed(1),
					z        = block.z * 50,
					rotate_x = parseFloat( tx * 25 * speed ).toFixed(1),
					rotate_y = parseFloat( ty * 25 * speed ).toFixed(1);

				if ( block.prop == 'background' ) {
					TweenMax.to(
						$image,
						1, {
							backgroundPositionX: 'calc(' + block.x + '% + ' + x + 'px)',
							backgroundPositionY: 'calc(' + block.y + '% + ' + y + 'px)',
							ease:Power2.easeOut
						}
					);
				} else if ( block.prop == 'transform' ) {
					TweenMax.to(
						$image,
						1, {
							x: x,
							y: y,
							ease:Power2.easeOut
						}
					);
				} else if ( block.prop == 'transform3d' ) {
					TweenMax.to(
						$image,
						2, {
							x: x,
							y: y,
							z: z,
							rotationX: rotate_y,
							rotationY: -rotate_x,
							ease:Power2.easeOut
						}
					);
				}

			} );
		};

		// Scroll handlers
		//-------------------------------------
		self.scroll_handler = function( e ) {
			wst = $window.scrollTop(),
			ww  = $window.width();
			wh  = $window.height();
			self.scroll_update();
		};

		self.scroll_update = function() {
			jQuery.each( scroll_list, function( index, block ) {
				// Section (row) layers
				if ( parallax_type == 'layers' ) {
					var $image     = block.selector.find( '.sc_parallax_block_image' ),
						speed      = block.speed,
						prop       = block.prop,
						offset_top = block.selector.offset().top,
						h          = block.selector.outerHeight(),
						y          = ( wst + wh - offset_top ) / h * 100;

					if ( wst < offset_top - wh) y = 0;
					if ( wst > offset_top + h)  y = 200;

					y = parseFloat( speed * y ).toFixed(1);
					if ( 'background' === block.prop ) {
						$image.css( {
							'background-position-y': 'calc(' + block.y + '% + ' + y + 'px)'
						} );
					} else {
						$image.css( {
							'transform': 'translateY(' + y + 'px)'
						} );
					}

				// Widgets (blocks)
				} else {
					var w_top = wst,
						w_bottom = w_top + wh,
						obj = block.selector,
						obj_width = obj.outerWidth(),
						obj_height = obj.outerHeight(),
						obj_top = obj.offset().top,
						obj_bottom = obj_top + obj_height;

					var entrance = obj.hasClass('sc_parallax_entrance'),
						entrance_complete = obj.hasClass('sc_parallax_entrance_complete'),
						bottom_delta = entrance ? 100: 0,
						start = obj.hasClass('sc_parallax_start'),
						params = obj.data('parallax-params') 
									? obj.data('parallax-params') 
									: {};
					if ( typeof params.type == 'undefined' ) params.type = 'object';
					if ( typeof params.x == 'undefined' ) params.x = 0;
					if ( typeof params.y == 'undefined' ) params.y = 0;
					if ( typeof params.scale == 'undefined' ) params.scale = 0;
					if ( typeof params.rotate == 'undefined' ) params.rotate = 0;
					if ( typeof params.opacity == 'undefined' ) params.opacity = 0;
					if ( typeof params.duration == 'undefined' ) params.duration = 1;
					if ( typeof params.text == 'undefined' ) params.text = 'block';
					if ( typeof params.ease == 'undefined' ) params.ease = "Power2";

					if ( obj.data('inited') === undefined ) {
						if ( obj_top > w_bottom ) obj_top = w_bottom - bottom_delta;
						else if ( obj_bottom < w_top ) obj_bottom = w_top;
						obj.data('inited', 1);
					}

					if ( w_top <= obj_bottom && obj_top <= w_bottom - bottom_delta && !entrance_complete ) {
						if ( entrance ) {
							var entrance_start = false;
							if (start && !obj.data('entrance-inited')) {
								if (obj_top < w_bottom - bottom_delta) {
									obj.addClass('sc_parallax_entrance_complete');
									return;
								}
								obj.data('entrance-inited', 1);
								entrance_start = true;
							} else {
								obj.addClass('sc_parallax_entrance_complete');
							}
						}
						var delta = entrance ? 1 : (wh + obj_height) / 2.5,
							shift = entrance ? (entrance_start ? 0 : 1) : w_bottom - obj_top,
							step_x = params.x != 0 ? params.x / delta : 0,
							step_y = params.y != 0 ? params.y / delta : 0,
							step_scale = params.scale != 0 ? params.scale / 100 / delta : 0,
							step_rotate = params.rotate != 0 ? params.rotate / delta : 0,
							step_opacity = params.opacity != 0 ? params.opacity / delta : 0;
						var scroller_init = { ease: self.get_ease(params.ease) },
							transform = '',
							val = 0;
						if (step_opacity != 0) {
							scroller_init.opacity = trx_addons_round_number(
													start
														? Math.min(1, 1 - shift * step_opacity + params.opacity)
														: 1 + shift * step_opacity,
													2);
						}
						if (step_x != 0) {
							val = Math.round( start
												? params.x - shift * step_x
												: shift * step_x - (params.type == 'bg' && params.x > 0 ? params.x : 0)
											);
							if ( start && ( (params.x < 0 && val > 0) || (params.x > 0 && val < 0) ) ) val = 0;
							transform += 'translateX(' + val + 'px)';
							scroller_init.x = val;
						}
						if (step_y != 0) {
							val = Math.round( start
												? params.y - shift * step_y
												: shift * step_y - (params.type == 'bg' && params.y > 0 ? params.y : 0)
											);
							if ( start && ( (params.y < 0 && val > 0) || (params.y > 0 && val < 0) ) ) val = 0;
							transform += (transform != '' ? ' ' : '') + 'translateY(' + val + 'px)';
							scroller_init.y = val;
						}
						if (step_rotate != 0) {
							val = trx_addons_round_number( start
															? params.rotate - shift * step_rotate
															: shift * step_rotate,
														2);
							if ( start && ( (params.rotate < 0 && val > 0) || (params.rotate > 0 && val < 0) ) ) val = 0;
							transform += (transform != '' ? ' ' : '') + 'rotate(' + val + 'deg)';
							scroller_init.rotation = val;
						}
						if (step_scale != 0) {
							val = trx_addons_round_number( start
															? 1 + params.scale / 100 - shift * step_scale
															: 1 + shift * step_scale - (params.type == 'bg' && params.scale < 0 ? params.scale / 100 : 0),
														2);
							if ( start && ( (params.scale < 1 && val > 1) || (params.scale > 1 && val < 1) ) ) val = 1;
							transform += (transform != '' ? ' ' : '') + 'scale(' + val + ')';
							scroller_init.scale = val;
						}
						/*
						if (transform != '') {
							scroller_init.transform = transform;
							scroller_init.transformOrigin = '50% 50% 0px';
						}
						obj.css(scroller_init);
						*/
						if ( [ 'chars', 'words'].indexOf(params.text) != -1 && obj.data('element_type') !== undefined ) {
							var sc = obj.data('element_type').split('.')[0],
								inner_obj = obj.find('.sc_parallax_text_block');
							if (inner_obj.length == 0) {
								inner_obj = obj.find(
											sc == 'trx_sc_title'
												? '.sc_item_title_text,.sc_item_subtitle'
												: ( sc == 'trx_sc_supertitle'
													? '.sc_supertitle_text'
													: ( sc == 'heading'
														? '.elementor-heading-title'
														: 'p')
													)
											);
								if (inner_obj.length > 0) {
									inner_obj.each(function(idx) {
										inner_obj.eq(idx)
											.html(
												params.text == 'chars'
													? self.wrap_chars(inner_obj.eq(idx).html())
													: self.wrap_words(inner_obj.eq(idx).html())
											);
									});
									inner_obj = inner_obj.find('.sc_parallax_text_block');
								}
							}
							if (inner_obj.length > 0) {
								obj = inner_obj;
							}
						}
						obj.each( function(idx) {
							if (idx == 0) {
								TweenMax.to( obj.eq(idx), params.duration, scroller_init );
							} else {
								setTimeout(function() {
									TweenMax.to( obj.eq(idx), params.duration, scroller_init );
								}, ( params.text == 'chars' ? 50 : 250 ) * idx);
							}
						});
					}
				}
			} );
		};
	
		// Return easing method from its name
		self.get_ease = function(name) {
			name = name.toLowerCase();
			if ( name == 'none' || name == 'line' || name == 'linear' || name == 'power0' )
				return Power0.easeNone;
			else if ( name == 'power1')
				return Power1.easeOut;
			else if ( name == 'power2')
				return Power2.easeOut;
			else if ( name == 'power3')
				return Power3.easeOut;
			else if ( name == 'power4')
				return Power4.easeOut;
			else if ( name == 'back')
				return Back.easeOut;
			else if ( name == 'elastic')
				return Elastic.easeOut;
			else if ( name == 'bounce')
				return Bounce.easeOut;
			else if ( name == 'rough')
				return Rough.easeOut;
			else if ( name == 'slowmo')
				return SlowMo.easeOut;
			else if ( name == 'stepped')
				return Stepped.easeOut;
			else if ( name == 'circ')
				return Circ.easeOut;
			else if ( name == 'expo')
				return Expo.easeOut;
			else if ( name == 'sine')
				return Sine.easeOut;
		};

		// Wrap each char to the <span>
		self.wrap_chars = function(txt) {
			var rez = '', ch = '', in_tag = false;
			for (var i=0; i<txt.length; i++) {
				ch = txt.substr(i, 1);
				if ( ch == '<' ) {
					in_tag = true;
				}
				rez += in_tag 
						? ch
						: '<span class="sc_parallax_text_block">'
							+ (txt.substr(i, 1) == ' ' ? '&nbsp;' : txt.substr(i, 1))
							+ '</span>';
				if (ch == '>') {
					in_tag = false;
				}
			}
			return rez;
		};

		// Wrap each word to the <span>
		self.wrap_words = function(txt) {
			var rez = '', ch = '', in_tag = false, in_word = false;
			for (var i=0; i<txt.length; i++) {
				ch = txt.substr(i, 1);
				if ( ch == '<' ) {
					in_tag = true;
					if ( in_word ) {
						rez += '</span>';
						in_word = false;
					}
				}
				if ( !in_tag ) {
					if ( ch == ' ' ) {
						if ( in_word ) {
							rez += '</span>';
							in_word = false;
						}
					} else {
						if ( !in_word ) {
							rez += '<span class="sc_parallax_text_block">';
							in_word = true;
						}
					}
				}
				rez += ch;
				if (ch == '>') {
					in_tag = false;
				}
			}
			return rez;
		};

	};

}() );
