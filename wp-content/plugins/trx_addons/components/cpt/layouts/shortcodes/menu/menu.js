/* global jQuery:false */

(function() {
	"use strict";

	jQuery(document).on('action.before_ready_trx_addons', function() {
		// Init Superfish menu - global declaration to use in other scripts
		window.trx_addons_init_sfmenu = function(selector) {
			jQuery(selector).show().each(function() {
				var animation_in = jQuery(this).parent().data('animation-in');
				if (animation_in == undefined) animation_in = "none";
				var animation_out = jQuery(this).parent().data('animation-out');
				if (animation_out == undefined) animation_out = "none";
				jQuery(this).addClass('inited').superfish({
					delay: 500,
					animation: {
						opacity: 'show'
					},
					animationOut: {
						opacity: 'hide'
					},
					speed: 		animation_in!='none' ? 500 : 200,
					speedOut:	animation_out!='none' ? 500 : 200,
					autoArrows: false,
					dropShadows: false,
					onBeforeShow: function(ul) {
						var menu_item = jQuery(this);
						if (menu_item.hasClass('sc_layouts_submenu') && !menu_item.hasClass('layouts_inited') && menu_item.find('.slider_container').length > 0) {
							menu_item.addClass('sc_layouts_submenu_prepare');
						} else {
							trx_addons_before_show_menu(menu_item);
						}
					},
					onBeforeHide: function(ul) {
						trx_addons_before_hide_menu(jQuery(this));
					},
					onShow: function(ul) {
						trx_addons_after_show_menu(jQuery(this));
					}
				});

				// Before show submenu
				function trx_addons_before_show_menu(menu_item) {
					// Disable show submenus in the vertical menu on the mobile screen
					//if (jQuery(window).width() < 768 && menu_item.parents(".sc_layouts_menu_dir_vertical").length > 0)
					//	return false;
					// Detect horizontal position (left | right)
					if (menu_item.parents("ul").length > 1){
						var page_wrap = jQuery('.page_wrap').eq(0),
							w = page_wrap.length > 0 ? page_wrap.width() : jQuery(window).width(),
							w_offset = page_wrap.length > 0 ? page_wrap.offset().left : 0,
							par = menu_item.parents("ul").eq(0),
							par_offset = par.offset().left - w_offset,
							par_width  = par.outerWidth(),
							ul_width   = menu_item.outerWidth();
						if (par_offset + par_width + ul_width > w - 10 && par_offset - ul_width > 0)
							menu_item.addClass('submenu_left');
						else
							menu_item.removeClass('submenu_left');
					}
					// Shift submenu in the main menu (if submenu is going out of the window)
					if (menu_item.parents('.top_panel').length > 0) {
						// Shift horizontal
						var ul_width = menu_item.outerWidth(),
							w_width = jQuery(window).width();
						if (menu_item.hasClass('submenu_left')) {
							var ul_pos = menu_item.data('ul_pos'),
								ul_offset = menu_item.offset().left;
							if (ul_pos === undefined) {
								ul_pos = parseInt(menu_item.css('right'), 10);
							}
							if ( isNaN(ul_pos) ) {
								ul_pos = 0;
							}
							if (ul_offset < 0) {
								if (menu_item.data('ul_pos') == undefined) {
									menu_item.data('ul_pos', ul_pos);
								}
								menu_item.css({
									'right': ul_pos + ul_offset + 'px'
								});
							}
						} else {
							var ul_pos = menu_item.data('ul_pos'),
								ul_offset = menu_item.parents("ul").length > 1 ? menu_item.offset().left : menu_item.parent().offset().left;
							if (ul_pos === undefined) {
								ul_pos = parseInt(menu_item.css('left'), 10);
							}
							if ( isNaN(ul_pos) ) {
								ul_pos = 0;
							}
							if (ul_offset + ul_width >= w_width) {
								if (menu_item.data('ul_pos') == undefined) {
									menu_item.data('ul_pos', ul_pos);
								}
								menu_item.css({
									'left': ( ul_pos - ( ul_offset + ul_width - w_width ) ) + 'px'
								});
							}
						}
						// Shift vertical
						var ul_height = menu_item.outerHeight(),
							w_height = jQuery(window).height(),
							row = menu_item.parents('.sc_layouts_row'),
							row_offset = 0,
							row_height = 0,
							par = menu_item.parent(),
							par_offset = 0;
						while (row.length > 0) {
							row_offset += row.outerHeight();
							if (row.hasClass('sc_layouts_row_fixed_on')) break;
							row = row.prev();
						}
						while (par.length > 0) {
							par_offset += par.position().top + par.parent().position().top;
							row_height = par.outerHeight();
							if (par.position().top == 0) break;
							par = par.parents('li');
						}
						if (row_offset + par_offset + ul_height > w_height) {
							if (par_offset > ul_height) {
								menu_item.css({
									'top': 'auto',
									'bottom': '-1.4em'
								});
							} else {
								menu_item.css({
									'top': '-' + (par_offset - row_height - 2) + 'px',
									'bottom': 'auto'
								});
							}
						}
					}
					// Animation in
					if (menu_item.parents('[class*="columns-"]').length == 0 && animation_in!='none') {
						menu_item.removeClass('animated fast '+animation_out);
						menu_item.addClass('animated fast '+animation_in);
					}
				}

				// Before hide submenu
				function trx_addons_before_hide_menu(menu_item) {
					// Remove video
					menu_item.find('.trx_addons_video_player.with_cover.video_play').removeClass('video_play').find('.video_embed').empty();
					// Disable show submenus in the vertival menu on the mobile screen
					//if (jQuery(window).width() < 768 && menu_item.parents(".sc_layouts_menu_dir_vertical").length > 0)
					//	return false;
					// Animation out
					if (menu_item.parents('[class*="columns-"]').length == 0 && animation_out!='none') {
						menu_item.removeClass('animated fast '+animation_in);
						menu_item.addClass('animated fast '+animation_out);
					}
				}

				// After show submenu
				function trx_addons_after_show_menu(menu_item) {
					// Init layouts
					if (menu_item.hasClass('sc_layouts_submenu') && !menu_item.hasClass('layouts_inited')) {
						jQuery(document).trigger('action.init_hidden_elements', [menu_item]);
						if (menu_item.find('.slider_container').length > 0) {
							jQuery(document).on('action.slider_inited', function(e, slider, id) {
								trx_addons_before_show_menu(menu_item);
								menu_item
									.removeClass('sc_layouts_submenu_prepare')
									.addClass('layouts_inited');
							});
						} else {
							menu_item.addClass('layouts_inited');
						}
					}
				}

			});
		};
	
		// Init superfish menus
		trx_addons_init_sfmenu('.sc_layouts_menu:not(.inited) > ul:not(.inited)');
	
		// Check if menu need collapse (before menu showed)
		trx_addons_menu_collapse();

		// Show menu		
		jQuery('.sc_layouts_menu:not(.inited)').each(function() {
			if (jQuery(this).find('>ul.inited').length == 1) jQuery(this).addClass('inited');
		});
	
		// Slide effect for menu
		jQuery('.menu_hover_slide_line:not(.slide_inited),.menu_hover_slide_box:not(.slide_inited)').each(function() {
			var menu = jQuery(this).addClass('slide_inited');
			var style = menu.hasClass('menu_hover_slide_line') ? 'line' : 'box';
			setTimeout(function() {
				if (jQuery.fn.spasticNav !== undefined) {
					menu.find('>ul').spasticNav({
						style: style,
						//color: '',
						colorOverride: false
					});
				}
			}, 500);
		});
	
		// Burger with popup
		jQuery('.sc_layouts_menu_mobile_button_burger:not(.inited)').each(function() {
			var burger = jQuery(this);
			var popup = burger.find('.sc_layouts_menu_popup');
			if (popup.length == 1) {
				burger.addClass('inited').on('click', '>a', function(e) {
					popup.toggleClass('opened').slideToggle();
					e.preventDefault();
					return false;
				});
				popup.on('click', 'a', function(e) {
					if ( jQuery(this).next().hasClass('sub-menu') ) {
						jQuery(this).next().fadeToggle();
						e.preventDefault();
						return false;
					}
				});
				jQuery(document).on('click', function(e) {
					jQuery('.sc_layouts_menu_popup.opened').removeClass('opened').slideUp();
				});
			}
		});
	
	});
	

	// Collapse menu on resize
	jQuery(document).on('action.resize_trx_addons', function() {
		trx_addons_menu_collapse();
	});
	
	// Collapse menu items
	function trx_addons_menu_collapse() {
		if (TRX_ADDONS_STORAGE['menu_collapse'] == 0) return;
		jQuery('.sc_layouts_menu:not(.sc_layouts_menu_dir_vertical)').each(function() {
			if (jQuery(this).parents('div:hidden,section:hidden,article:hidden').length > 0) return;
			var ul = jQuery(this).find('>ul:not(.sc_layouts_menu_no_collapse).inited');
			if (ul.length == 0 || ul.find('> li').length < 2) return;
			var sc_layouts_item = ul.parents('.sc_layouts_item');
			if (    !sc_layouts_item.parent().hasClass('wpb_wrapper')
				 && !sc_layouts_item.parent().hasClass('sc_layouts_column')
				 && !sc_layouts_item.parent().hasClass('elementor-widget-wrap')
				) return;
			// Calculate max free space for menu
			var w_max = sc_layouts_item.parent().width()
						- (Math.ceil(parseFloat(sc_layouts_item.css('marginLeft'))) + Math.ceil(parseFloat(sc_layouts_item.css('marginRight'))))
						- 2;	// Leave additional 2px empty
			var w_siblings = 0, in_group = 0, ul_id = ul.attr('id');
			sc_layouts_item.parent().find('>div').each(function() {
				if ( in_group > 1 ) return;
				if (   jQuery(this).hasClass('vc_empty_space')
					|| jQuery(this).hasClass('vc_separator') 
					|| jQuery(this).hasClass('elementor-widget-spacer')
					|| jQuery(this).hasClass('elementor-widget-divider') ) {
					if (in_group == 1)
						in_group = 2;
					else
						w_siblings = 0;
				} else {
					if (jQuery(this).find('#'+ul_id).length > 0)
						in_group = 1;
					else
						w_siblings += (jQuery(this).outerWidth() + Math.ceil(parseFloat(jQuery(this).css('marginLeft'))) + Math.ceil(parseFloat(jQuery(this).css('marginRight'))));
				}
			});
			w_max -= w_siblings;
			// Add collapse item if not exists
			var w_all = 0;
			var move = false;
			var li_collapse = ul.find('li.menu-item.menu-collapse');
			if (li_collapse.length==0) {
				ul.append('<li class="menu-item menu-collapse"><a href="#" class="sf-with-ul '+TRX_ADDONS_STORAGE['menu_collapse_icon']+'"></a><ul class="submenu"></ul></li>');
				li_collapse = ul.find('li.menu-item.menu-collapse');
			}
			var li_collapse_ul = li_collapse.find('> ul');
			// Check if need to move items
			ul.find('> li').each(function(idx) {
				var cur_item = jQuery(this);
				cur_item.data('index', idx);
				if (move || cur_item.attr('id') == 'blob') return;
				w_all += !cur_item.hasClass('menu-collapse') || cur_item.css('display')!='none' 
							? cur_item.outerWidth() + Math.ceil(parseFloat(cur_item.css('marginLeft'))) + Math.ceil(parseFloat(cur_item.css('marginRight')))
							: 0;
				if (w_all > w_max) move = true;
			});
			// If need to move items to the collapsed item
			if (move) {
				w_all = li_collapse.outerWidth() + Math.ceil(parseFloat(li_collapse.css('marginLeft'))) + Math.ceil(parseFloat(li_collapse.css('marginRight')));
				ul.find("> li:not('.menu-collapse')").each(function(idx) {
					var cur_item = jQuery(this);
					var cur_width = cur_item.outerWidth() + Math.ceil(parseFloat(cur_item.css('marginLeft'))) + Math.ceil(parseFloat(cur_item.css('marginRight')));
					if (w_all <= w_max) w_all += cur_width;
					if (w_all > w_max) {
						var moved = false;
						li_collapse_ul.find('>li').each(function() {
							if (!moved && Number(jQuery(this).data('index')) > idx) {
								cur_item.attr('data-width', cur_width).insertBefore(jQuery(this));
								moved = true;
							}
						});
						if (!moved) cur_item.attr('data-width', cur_width).appendTo(li_collapse_ul);
					}
				});
				li_collapse.show();
				
			// Else - move items to the menu again
			} else {
				var items = li_collapse_ul.find('>li');
				var cnt = 0;
				move = true;
				//w_all += 20; 	// Leave 20px empty
				items.each(function() {
					if (!move) return;
					if (items.length - cnt == 1)
						w_all -= (li_collapse.outerWidth() + Math.ceil(parseFloat(li_collapse.css('marginLeft'))) + Math.ceil(parseFloat(li_collapse.css('marginRight'))));
					w_all += parseFloat(jQuery(this).data('width'));
					if (w_all < w_max) {
						jQuery(this).insertBefore(li_collapse);
						cnt++;
					} else
						move = false;
				});
				if (items.length - cnt == 0) li_collapse.hide();
			}
		});
	}

})();