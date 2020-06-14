/* global jQuery:false */
/* global PIQES_STORAGE:false */

jQuery( document ).ready(
	function() {
		"use strict";

		var theme_init_counter = 0;

		piqes_init_actions();

		// Theme init actions
		function piqes_init_actions() {

			if (PIQES_STORAGE['vc_edit_mode'] && jQuery( '.vc_empty-placeholder' ).length == 0 && theme_init_counter++ < 30) {
				setTimeout( piqes_init_actions, 200 );
				return;
			}

			// Check fullheight elements
			jQuery( document ).on( 'action.init_hidden_elements', piqes_stretch_height );
			jQuery( document ).on( 'action.sc_layouts_row_fixed_off', piqes_stretch_height );
			jQuery( document ).on( 'action.sc_layouts_row_fixed_on', piqes_stretch_height );

			// Add resize on VC action vc-full-width-row
			// But we emulate 'action.resize_vc_row_start' and 'action.resize_vc_row_end'
			// to correct resize sliders and video inside 'boxed' pages
			var vc_resize = false;
			jQuery( document ).on(
				'action.resize_vc_row_start', function(e, el) {
					vc_resize = true;
					piqes_resize_actions( el );
				}
			);

			// Resize handlers
			jQuery( window ).resize(
				function() {
					if ( ! vc_resize) {
						piqes_resize_actions();
					}
				}
			);

			// Scroll handlers
			PIQES_STORAGE['scroll_busy'] = true;
			jQuery( window ).scroll(
				function() {
					if (window.requestAnimationFrame) {
						if ( ! PIQES_STORAGE['scroll_busy']) {
							window.requestAnimationFrame( piqes_scroll_actions );
							PIQES_STORAGE['scroll_busy'] = true;
						}
					} else {
						piqes_scroll_actions();
					}
				}
			);

			// First call to init core actions
			piqes_ready_actions();
			piqes_resize_actions();
			piqes_scroll_actions();

			// Wait when logo is loaded
			if (jQuery( 'body' ).hasClass( 'menu_style_side' )) {
				var side_logo = jQuery( '.menu_side_wrap .sc_layouts_logo' );
				if (side_logo.length > 0 && ! piqes_is_images_loaded( side_logo )) {
					piqes_when_images_loaded(
						side_logo, function() {
							piqes_stretch_sidemenu();
						}
					);
				}
			}
		}

		// Theme first load actions
		//==============================================
		function piqes_ready_actions() {

			// Add scheme class and js support
			//------------------------------------
			document.documentElement.className = document.documentElement.className.replace( /\bno-js\b/,'js' );
			if (document.documentElement.className.indexOf( PIQES_STORAGE['site_scheme'] ) == -1) {
				document.documentElement.className += ' ' + PIQES_STORAGE['site_scheme'];
			}

            // mc4wp - id
            if (jQuery( '.mc4wp-form-fields' ).length > 0) {
                var count_mc4wp = 1;
                jQuery( '.mc4wp-form-fields' ).each(
                    function () {
                        jQuery(this).find('input[type="checkbox"]').each(
                            function () {
                                var id = jQuery(this).attr( 'id' );
                                if(id) {}
                                else {
                                    id = 'go';
                                }
                                jQuery(this).attr('id', id + count_mc4wp);
                                jQuery(this).next('label').attr('for', id + count_mc4wp);
                                count_mc4wp++;
                            });
                    });
            }

			// Init background video
			//------------------------------------
			// Use Bideo to play local video
			if (PIQES_STORAGE['background_video'] && jQuery( '.top_panel.with_bg_video' ).length > 0 && window.Bideo) {
				// Waiting 10ms after mejs init
				setTimeout(
					function() {
						jQuery( '.top_panel.with_bg_video' ).prepend( '<video id="background_video" loop muted></video>' );
						var bv = new Bideo();
						bv.init(
							{
								// Video element
								videoEl: document.querySelector( '#background_video' ),

								// Container element
								container: document.querySelector( '.top_panel' ),

								// Resize
								resize: true,

								// autoplay: false,

								isMobile: window.matchMedia( '(max-width: 768px)' ).matches,

								playButton: document.querySelector( '#background_video_play' ),
								pauseButton: document.querySelector( '#background_video_pause' ),

								// Array of objects containing the src and type
								// of different video formats to add
								// For example:
								//	src: [
								//			{	src: 'night.mp4', type: 'video/mp4' }
								//			{	src: 'night.webm', type: 'video/webm;codecs="vp8, vorbis"' }
								//		]
								src: [
								{
									src: PIQES_STORAGE['background_video'],
									type: 'video/' + piqes_get_file_ext( PIQES_STORAGE['background_video'] )
								}
								],

								// What to do once video loads (initial frame)
								onLoad: function () {
									//document.querySelector('#background_video_cover').style.display = 'none';
								}
							}
						);
					}, 10
				);

				// Use Tubular to play video from Youtube
			} else if (jQuery.fn.tubular) {
				jQuery( 'div#background_video' ).each(
					function() {
						var youtube_code = jQuery( this ).data( 'youtube-code' );
						if (youtube_code) {
							jQuery( this ).tubular( {videoId: youtube_code} );
							jQuery( '#tubular-player' ).appendTo( jQuery( this ) ).show();
							jQuery( '#tubular-container,#tubular-shield' ).remove();
						}
					}
				);
			}

			// Tabs
			//------------------------------------
			if (jQuery( '.piqes_tabs:not(.inited)' ).length > 0 && jQuery.ui && jQuery.ui.tabs) {
				jQuery( '.piqes_tabs:not(.inited)' ).each(
					function () {
						// Get initially opened tab
						var init = jQuery( this ).data( 'active' );
						if (isNaN( init )) {
							init       = 0;
							var active = jQuery( this ).find( '> ul > li[data-active="true"]' ).eq( 0 );
							if (active.length > 0) {
								init = active.index();
								if (isNaN( init ) || init < 0) {
									init = 0;
								}
							}
						} else {
							init = Math.max( 0, init );
						}
						// Init tabs
						jQuery( this ).addClass( 'inited' ).tabs(
							{
								active: init,
								show: {
									effect: 'fadeIn',
									duration: 300
								},
								hide: {
									effect: 'fadeOut',
									duration: 300
								},
								create: function( event, ui ) {
									if (ui.panel.length > 0) {
										jQuery( document ).trigger( 'action.init_hidden_elements', [ui.panel] );
									}
								},
								activate: function( event, ui ) {
									if (ui.newPanel.length > 0) {
										jQuery( document ).trigger( 'action.init_hidden_elements', [ui.newPanel] );
									}
								}
							}
						);
					}
				);
			}
			// AJAX loader for the tabs
			jQuery( '.piqes_tabs_ajax' ).on(
				"tabsbeforeactivate", function( event, ui ) {
					if (ui.newPanel.data( 'need-content' )) {
						piqes_tabs_ajax_content_loader( ui.newPanel, 1, ui.oldPanel );
					}
				}
			);
			// AJAX loader for the pages in the tabs
			jQuery( '.piqes_tabs_ajax' ).on(
				"click", '.nav-links a', function(e) {
					var panel = jQuery( this ).parents( '.piqes_tabs_content' );
					var page  = 1;
					var href  = jQuery( this ).attr( 'href' );
					var pos   = -1;
					if ((pos = href.lastIndexOf( '/page/' )) != -1 ) {
						page = Number( href.substr( pos + 6 ).replace( "/", "" ) );
						if ( ! isNaN( page )) {
							page = Math.max( 1, page );
						}
					}
					piqes_tabs_ajax_content_loader( panel, page );
					e.preventDefault();
					return false;
				}
			);


			// Sidebar open/close
			//----------------------------------------------
			jQuery( '.sidebar_control' ).on(
				'click', function(e){
					jQuery( this ).parent().toggleClass( 'opened' );
					if ( jQuery('body').hasClass('sidebar_small_screen_above') ) {
						jQuery( this ).next().slideToggle();
						if ( jQuery( this ).parent().hasClass( 'opened' ) ) {
							setTimeout( function() {
								jQuery( document ).trigger( 'action.init_hidden_elements', [jQuery( this ).next()] );
							}, 310 );
						}
					}
					e.preventDefault();
					return false;
				}
			);



			// Menu
			//----------------------------------------------

			// Open/Close side menu
			jQuery( '.menu_side_button' ).on(
				'click', function(e){
					jQuery( this ).parent().toggleClass( 'opened' );
					e.preventDefault();
					return false;
				}
			);

			// Add images to the menu items with classes image-xxx
			jQuery( '.sc_layouts_menu li[class*="image-"]' ).each(
				function() {
					var classes = jQuery( this ).attr( 'class' ).split( ' ' );
					var icon    = '';
					for (var i = 0; i < classes.length; i++) {
						if (classes[i].indexOf( 'image-' ) >= 0) {
							icon = classes[i].replace( 'image-', '' );
							break;
						}
					}
					if (icon) {
						jQuery( this ).find( '>a' ).css( 'background-image', 'url(' + PIQES_STORAGE['theme_url'] + 'trx_addons/css/icons.png/' + icon + '.png' );
					}
				}
			);

			// Add arrows to the mobile menu
			jQuery( '.menu_mobile .menu-item-has-children > a,.sc_layouts_menu_dir_vertical .menu-item-has-children > a' ).append( '<span class="open_child_menu"></span>' );

			// Open/Close mobile menu
			jQuery( '.sc_layouts_menu_mobile_button > a,.menu_mobile_button,.menu_mobile_description' ).on(
				'click', function(e) {
					if (jQuery( this ).parent().hasClass( 'sc_layouts_menu_mobile_button_burger' ) && jQuery( this ).next().hasClass( 'sc_layouts_menu_popup' )) {
						return;
					}

                    if(jQuery('.search_wrap')) {
                        jQuery('.search_wrap').removeClass('search_opened');
                        jQuery( '.search_overlay' ).fadeOut();
                        jQuery('.search_wrap').find('.search_results').fadeOut();
                        jQuery('body').removeClass('search_open_anim');
                    }

					jQuery( '.menu_mobile_overlay' ).fadeIn();
					jQuery( '.menu_mobile' ).addClass( 'opened' );
					jQuery( document ).trigger( 'action.stop_wheel_handlers' );
					e.preventDefault();
					return false;
				}
			);
			jQuery( document ).on(
				'keypress', function(e) {
					if (e.keyCode == 27) {
						if (jQuery( '.menu_mobile.opened' ).length == 1) {
							jQuery( '.menu_mobile_overlay' ).fadeOut();
							jQuery( '.menu_mobile' ).removeClass( 'opened' );
							jQuery( document ).trigger( 'action.start_wheel_handlers' );
							e.preventDefault();
							return false;
						}
					}
				}
			);
			jQuery( '.menu_mobile_close, .menu_mobile_overlay' ).on(
				'click', function(e){
					jQuery( '.menu_mobile_overlay' ).fadeOut();
					jQuery( '.menu_mobile' ).removeClass( 'opened' );
					jQuery( document ).trigger( 'action.start_wheel_handlers' );
					e.preventDefault();
					return false;
				}
			);

			// Open/Close mobile submenu
			jQuery( '.menu_mobile,.sc_layouts_menu_dir_vertical' ).on(
				'click', 'li a, li a .open_child_menu', function(e) {
					var $a = jQuery( this ).hasClass( 'open_child_menu' ) ? jQuery( this ).parent() : jQuery( this );
					if ($a.parent().hasClass( 'menu-item-has-children' )) {
						if ($a.attr( 'href' ) == '#' || jQuery( this ).hasClass( 'open_child_menu' )) {
							if ($a.siblings( 'ul:visible' ).length > 0) {
								$a.siblings( 'ul' ).slideUp().parent().removeClass( 'opened' );
							} else {
								jQuery( this ).parents( 'li' ).eq(0).siblings( 'li' ).find( 'ul:visible' ).slideUp().parent().removeClass( 'opened' );
								$a.siblings( 'ul' ).slideDown(
									function() {
										// Init layouts
										if ( ! jQuery( this ).hasClass( 'layouts_inited' ) && jQuery( this ).parents( '.menu_mobile' ).length > 0) {
											jQuery( this ).addClass( 'layouts_inited' );
											jQuery( document ).trigger( 'action.init_hidden_elements', [jQuery( this )] );
										}
									}
								).parent().addClass( 'opened' );
							}
						}
					}
					if ( ! jQuery( this ).hasClass( 'open_child_menu' ) && jQuery( this ).parents( '.menu_mobile' ).length > 0 && piqes_is_local_link( $a.attr( 'href' ) )) {
						jQuery( '.menu_mobile_close' ).trigger( 'click' );
					}
					if (jQuery( this ).hasClass( 'open_child_menu' ) || $a.attr( 'href' ) == '#') {
						e.preventDefault();
						return false;
					}
				}
			);

			if ( ! PIQES_STORAGE['trx_addons_exist'] || jQuery( '.top_panel.top_panel_default .sc_layouts_menu_default' ).length > 0) {
				// Init superfish menus
				piqes_init_sfmenu( '.sc_layouts_menu:not(.inited) > ul:not(.inited)' );
				// Show menu
				jQuery( '.sc_layouts_menu:not(.inited)' ).each(
					function() {
						if (jQuery( this ).find( '>ul.inited' ).length == 1) {
							jQuery( this ).addClass( 'inited' );
						}
					}
				);
				// Generate 'scroll' event after the menu is showed
				jQuery( window ).trigger( 'scroll' );
			}


			// Pagination
			//------------------------------------

			// Load more
			jQuery( '.nav-load-more' ).on(
				'click', function(e) {
					if (PIQES_STORAGE['load_more_link_busy']) {
						return;
					}
					PIQES_STORAGE['load_more_link_busy'] = true;
					var more                               = jQuery( this );
					var page                               = Number( more.data( 'page' ) );
					var max_page                           = Number( more.data( 'max-page' ) );
					if (page >= max_page) {
						more.parent().hide();
						return;
					}
					more.parent().addClass( 'loading' );

					var panel = more.parents( '.piqes_tabs_content' );

					// Load simple page content
					if (panel.length == 0) {
						jQuery.get(
							location.href, {
								paged: page + 1
							}
						).done(
							function(response) {
								// Get inline styles and add to the page styles
								var selector = 'piqes-inline-styles-inline-css';
								var p1       = response.indexOf( selector );
								if (p1 < 0) {
									selector = 'trx_addons-inline-styles-inline-css';
									p1       = response.indexOf( selector );
								}
								if (p1 > 0) {
									p1                 = response.indexOf( '>', p1 ) + 1;
									var p2             = response.indexOf( '</style>', p1 );
									var inline_css_add = response.substring( p1, p2 );
									var inline_css     = jQuery( '#' + selector );
									if (inline_css.length == 0) {
										jQuery( 'body' ).append( '<style id="' + selector + '" type="text/css">' + inline_css_add + '</style>' );
									} else {
										inline_css.append( inline_css_add );
									}
								}
								// Get new posts and append to the .posts_container
								var posts_container = jQuery( response ).find('.content .posts_container');
								if ( posts_container.length == 0 ) {
									posts_container = jQuery( response ).find('.posts_container');
								}
								if ( posts_container.length > 0 ) {
									piqes_loadmore_add_items(
										jQuery( '.content .posts_container' ).eq( 0 ),
										posts_container.find(
											'> .masonry_item,'
											+ '> div[class*="column-"],'
											+ '> article'
										)
									);
								}
							}
						);

						// Load tab's panel content
					} else {
						jQuery.post(
							PIQES_STORAGE['ajax_url'], {
								nonce: PIQES_STORAGE['ajax_nonce'],
								action: 'piqes_ajax_get_posts',
								blog_template: panel.data( 'blog-template' ),
								blog_style: panel.data( 'blog-style' ),
								posts_per_page: panel.data( 'posts-per-page' ),
								cat: panel.data( 'cat' ),
								parent_cat: panel.data( 'parent-cat' ),
								post_type: panel.data( 'post-type' ),
								taxonomy: panel.data( 'taxonomy' ),
								page: page + 1
							}
						).done(
							function(response) {
								var rez = {};
								try {
									rez = JSON.parse( response );
								} catch (e) {
									rez = { error: PIQES_STORAGE['msg_ajax_error'] };
									console.log( response );
								}
								if (rez.error !== '') {
									panel.html( '<div class="piqes_error">' + rez.error + '</div>' );
								} else {
									piqes_loadmore_add_items(
										panel.find( '.posts_container' ),
										jQuery( rez.data ).find(
											'> .masonry_item,'
											+ '> div[class*="column-"],'
											+ '> article'
										)
									);
								}
							}
						);
					}

					// Append items to the container
					function piqes_loadmore_add_items(container, items) {
						if (container.length > 0 && items.length > 0) {
							items.addClass( 'just_loaded_items' );
							container.append( items );
							var just_loaded_items = container.find( '.just_loaded_items' );
							if (container.hasClass( 'portfolio_wrap' ) || container.hasClass( 'masonry_wrap' )) {
								just_loaded_items.addClass( 'hidden' );
								piqes_when_images_loaded(
									just_loaded_items, function() {
										just_loaded_items.removeClass( 'hidden' );
										container.masonry( 'appended', items ).masonry();
										if (container.hasClass( 'gallery_wrap' )) {
											PIQES_STORAGE['GalleryFx'][container.attr( 'id' )].appendItems();
										}
									}
								);
							}
							just_loaded_items.removeClass( 'just_loaded_items hidden' );
							more.data( 'page', page + 1 ).parent().removeClass( 'loading' );
							// Remove TOC if exists (rebuild on init_hidden_elements)
							jQuery( '#toc_menu' ).remove();
							// Trigger actions to init new elements
							PIQES_STORAGE['init_all_mediaelements'] = true;
							jQuery( document ).trigger( 'action.init_hidden_elements', [container.parent()] );
						}
						if (page + 1 >= max_page) {
							more.parent().hide();
						} else {
							PIQES_STORAGE['load_more_link_busy'] = false;
						}
						// Fire 'window.scroll' after clearing busy state
						jQuery( window ).trigger( 'scroll' );
					}
					e.preventDefault();
					return false;
				}
			);

			// Infinite scroll in the blog streampages
			jQuery( document ).on(
				'action.scroll_piqes', function(e) {
					if (PIQES_STORAGE['load_more_link_busy']) {
						return;
					}
					var inf = jQuery( '.nav-links-infinite' );
					if (inf.length == 0) {
						return;
					}
					var container = jQuery( '.content > .posts_container' ).eq( 0 );
					if (container.offset().top + container.height() < jQuery( window ).scrollTop() + jQuery( window ).height() * 1.5) {
						inf.find( 'a' ).trigger( 'click' );
					}
				}
			);

			// Infinite scroll in the single posts
			PIQES_STORAGE['cur_page_url']   = location.href;
			PIQES_STORAGE['cur_page_title'] = jQuery('head title').text();
			jQuery( document ).on(
				'action.scroll_piqes', function(e) {
					var scrollers = jQuery( '.nav-links-single-scroll' );
					if ( scrollers.length == 0 ) {
						return;
					}
					var container      = jQuery( '.content' ).eq( 0 ),
						cur_page_link  = PIQES_STORAGE['cur_page_url'],
						cur_page_title = PIQES_STORAGE['cur_page_title'];
					scrollers.each( function() {
						var inf  = jQuery(this),
							link = inf.data('post-link'),
							off  = inf.offset().top,
							st   = jQuery( window ).scrollTop(),
							wh   = jQuery( window ).height();
						
						// Change location url
						if (inf.hasClass('nav-links-single-scroll-loaded')) {
							if (link && off < st + wh / 2) {
								cur_page_link  = link;
								cur_page_title = inf.data('post-title');
							}
						
						// Load next post
						} else if ( !inf.hasClass('piqes_loading') && link && off < st + wh * 2) {
							piqes_add_to_read_list( container.find('.previous_post_content:last-child > article[data-post-id]').data('post-id'));
							inf.addClass('piqes_loading');
							jQuery.get( piqes_add_to_url( link, { 'action': 'prev_post_loading' } ) ).done(
								function( response ) {
									var post_content = jQuery( response ).find('.content');
									if ( post_content.length > 0 ) {
										container.append('<div class="previous_post_content">' + post_content.html() + '</div>');
										inf.removeClass('piqes_loading').addClass( 'nav-links-single-scroll-loaded' );
										// Remove TOC if exists (rebuild on init_hidden_elements)
										jQuery( '#toc_menu' ).remove();
										// Trigger actions to init new elements
										PIQES_STORAGE['init_all_mediaelements'] = true;
										jQuery( document ).trigger( 'action.init_hidden_elements', [container] );
										jQuery( window ).trigger( 'scroll' ).trigger( 'resize' );
									}
								}
							);
						}						
					} );
					if (cur_page_link != location.href) {
						piqes_document_set_location(cur_page_link);
						jQuery( 'head title' ).html( cur_page_title );
					}
				}
			);

			// Mark single post as readed
			if (jQuery('body').hasClass('single')) {
				piqes_add_to_read_list(jQuery('.content > article[data-post-id]').data('post-id'));
			}

			// Mark readed posts
			jQuery( document ).on(
				'action.init_hidden_elements', function(e, cont) {
					var read_list = piqes_get_storage('piqes_post_read');
					if ( read_list && read_list.charAt(0) == '[' ) {
						read_list = JSON.parse(read_list);
						for (var p=0; p<read_list.length; p++) {
							var read_post = cont.find('[data-post-id="'+read_list[p]+'"]');
							if (!read_post.addClass('full_post_read') && !read_post.parent().hasClass('content')) {
								read_post.addClass('full_post_read');
							}
						}
					}
				}
			);

			// Open single post right in the blog
			if ( PIQES_STORAGE['open_full_post'] ) {
				jQuery( '.posts_container,.sc_blogger_content.sc_item_posts_container' ).on( 'click', 'a', function(e) {
					var link = jQuery(this),
						link_url = link.attr( 'href' ),
						post = link.parents( '.post_item,.sc_blogger_item' ).eq(0),
						post_url = post.find( '.post_title > a,.entry-title > a' ).attr( 'href' ),
						posts_container = post.parents('.posts_container,.sc_item_posts_container').eq(0);
					if ( link_url && post_url && link_url == post_url
						&& ! posts_container.hasClass('columns_wrap')
						&& ! posts_container.hasClass('masonry_wrap')
						&& ! posts_container.hasClass('chess_wrap')
						&& posts_container.find('.sc_blogger_grid_wrap').length == 0
						&& posts_container.find('.masonry_wrap').length == 0
						&& posts_container.parents('.wp-block-columns').length == 0
						&& ( posts_container.parents('.wpb_column').length == 0 || posts_container.parents('.wpb_column').eq(0).hasClass('vc_col-sm-12') )
						&& ( posts_container.parents('.elementor-column').length == 0 || posts_container.parents('.elementor-column').eq(0).hasClass('elementor-col-100') )
					) {
						posts_container.find('.full_post_opened').removeClass('full_post_opened').show();
						posts_container.find('.full_post_content').remove();
						post.addClass('full_post_loading');
						jQuery.get( piqes_add_to_url( post_url, { 'action': 'full_post_loading' } ) ).done(
							function( response ) {
								var post_content = jQuery( response ).find('.content');
								if ( post_content.length > 0 ) {
									var cs = post.offset().top - (post.parents('.posts_container').length > 0 ? 100 : 200);
									piqes_document_animate_to( cs );
									post.after( 
											'<div class="full_post_content">'
												+ '<button class="full_post_close" data-post-url="' + post_url + '"></button>'
												+ post_content.html()
											+ '</div>'
										)
										.removeClass('full_post_loading')
										.addClass('full_post_opened')
										.slideUp('fast')
										.next().slideDown('slow');
									// Close full post content on click
									post.next().find('.full_post_close').on('click', function(e) {
										var content = jQuery(this).parent(),
											cs = content.offset().top - (content.parents('.posts_container').length > 0 ? 100 : 200),
											post = content.prev();
										post
											.removeClass('full_post_opened')
											.slideDown();
										piqes_document_animate_to( cs );
										content.remove();
										e.preventDefault();
										return false;
									});
									// Remove TOC if exists (rebuild on init_hidden_elements)
									jQuery( '#toc_menu' ).remove();
									// Trigger actions to init new elements
									PIQES_STORAGE['init_all_mediaelements'] = true;
									jQuery( document ).trigger( 'action.init_hidden_elements', [posts_container] );
									jQuery( window ).trigger( 'scroll' ).trigger( 'resize' );
								}
							}
						);
						e.preventDefault();
						return false;
					}
				} );
			}


			// Comments
			//------------------------------------

			// Checkbox with "I agree..."
			if (jQuery('input[type="checkbox"][name="i_agree_privacy_policy"]:not(.inited),input[type="checkbox"][name="gdpr_terms"]:not(.inited),input[type="checkbox"][name="wpgdprc"]:not(.inited)').length > 0) {
				jQuery('input[type="checkbox"][name="i_agree_privacy_policy"]:not(.inited),input[type="checkbox"][name="gdpr_terms"]:not(.inited),input[type="checkbox"][name="wpgdprc"]:not(.inited)')
					.addClass('inited')
					.on('change', function(e) {
						if (jQuery(this).get(0).checked)
							jQuery(this).parents('form').find('button,input[type="submit"]').removeAttr('disabled');
						else
							jQuery(this).parents('form').find('button,input[type="submit"]').attr('disabled', 'disabled');
					}).trigger('change');
			}


			// Other settings
			//------------------------------------

			jQuery( document ).trigger( 'action.ready_piqes' );


			// Blocks with stretch width
			//----------------------------------------------
			// Action to prepare stretch blocks in the third-party plugins
			jQuery( document ).trigger( 'action.prepare_stretch_width' );
			// Wrap stretch blocks
			jQuery( '.trx-stretch-width' ).wrap( '<div class="trx-stretch-width-wrap"></div>' );
			jQuery( '.trx-stretch-width' ).after( '<div class="trx-stretch-width-original"></div>' );
			piqes_stretch_width();


			// Add theme-specific handlers on 'action.init_hidden_elements'
			//---------------------------------------------------------------
			jQuery( document ).on( 'action.init_hidden_elements', piqes_init_post_formats );
			jQuery( document ).on( 'action.init_hidden_elements', piqes_add_toc_to_sidemenu );

			// Init hidden elements (if exists)
			jQuery( document ).trigger( 'action.init_hidden_elements', [jQuery( 'body' ).eq( 0 )] );

		} //end ready

		// Scroll actions
		//==============================================

		// Do actions when page scrolled
		function piqes_scroll_actions() {

			// Call theme/plugins specific action (if exists)
			//----------------------------------------------
			jQuery( document ).trigger( 'action.scroll_piqes' );

			// Fix/unfix sidebar
			piqes_fix_sidebar();

			// Shift top and footer panels when header position is 'Under content'
			piqes_shift_under_panels();

			// Fix/unfix nav links
			piqes_fix_nav_links();

			// Show full post reading progress
			piqes_full_post_reading();

			// Set flag about scroll actions are finished
			PIQES_STORAGE['scroll_busy'] = false;
		}

		// Add post_id to the readed list
		function piqes_add_to_read_list(post_id) {
			if ( post_id > 0 ) {
				var read_list = piqes_get_storage('piqes_post_read');
				if ( read_list && read_list.charAt(0) == '[' ) {
					read_list = JSON.parse(read_list);
				} else {
					read_list = [];
				}
				if ( read_list.indexOf(post_id) == -1 ) {
					read_list.push(post_id);
				}
				piqes_set_storage('piqes_post_read', JSON.stringify(read_list));
			}
		}

		// Show full post reading progress
		function piqes_full_post_reading() {
			if ( PIQES_STORAGE['open_full_post'] ) {
				var bt = jQuery('.full_post_close');
				if ( bt.length == 1 ) {
					var cont = bt.parent(),
						cs = cont.offset().top,
						ch = cont.height(),
						ws = jQuery( window ).scrollTop(),
						wh = jQuery( window ).height(),
						pw = bt.find('.full_post_progress');
					if ( ws > cs ) {
						if (pw.length == 0) {
							bt.append(
								'<span class="full_post_progress">'
									+ '<svg viewBox="0 0 50 50">'
										+ '<circle class="full_post_progress_bar" cx="25" cy="25" r="22"></circle>'
									+ '</svg>'
								+ '</span>'
							);
							pw = bt.find('.full_post_progress');
						}
						var bar = pw.find('.full_post_progress_bar'),
							bar_max = parseFloat(bar.css('stroke-dasharray'));
						if ( cs+ch > ws+wh ) {
							var now = cs+ch - (ws+wh),
								delta = bar.data('delta');
							if ( delta == undefined ) {
								delta = now;
								bar.data('delta', delta);
							}
							bar.css('stroke-dashoffset', Math.min( 1, now / delta ) * bar_max );
							if ( now / delta < 0.5 ) {
								var post = cont.prev(),
									post_id = post.data('post-id');
								post.addClass('full_post_read');
								piqes_add_to_read_list(post_id);
							}
						} else if ( !bt.hasClass('full_post_read_complete') ) {
							bt.addClass('full_post_read_complete');
						} else if ( cs+ch+wh/3 < ws+wh ) {
							bt.trigger('click');
						}
					} else {
						if (pw.length == 0) {
							pw.remove();
						}
					}
				}
			}
		}

		// Shift top and footer panels when header position is 'Under content'
		function piqes_shift_under_panels() {
			if (jQuery( 'body' ).hasClass( 'header_position_under' ) && ! piqes_browser_is_mobile()) {

				var header  = jQuery( '.top_panel' );
				var footer  = jQuery( '.footer_wrap' );
				var content = jQuery( '.page_content_wrap' );

				// Disable 'under' behavior on small screen
				if (jQuery( 'body' ).hasClass( 'mobile_layout' )) {	//jQuery(window).width() < 768) {
					if (header.css( 'position' ) == 'fixed') {
						// Header
						header.css(
							{
								'position': 'relative',
								'left': 'auto',
								'top': 'auto',
								'width': 'auto',
								'transform': 'none',
								'zIndex': 3
							}
						);
						header.find( '.top_panel_mask' ).hide();
						// Content
						content.css(
							{
								'marginTop': 0,
								'marginBottom': 0,
								'zIndex': 2
							}
						);
						// Footer
						footer.css(
							{
								'position': 'relative',
								'left': 'auto',
								'bottom': 'auto',
								'width': 'auto',
								'transform': 'none',
								'zIndex': 1
							}
						);
						footer.find( '.top_panel_mask' ).hide();
					}
					return;
				}
				var delta           = 50;
				var scroll_offset   = jQuery( window ).scrollTop();
				var header_height   = header.height();
				var shift           = ! (/Chrome/.test( navigator.userAgent ) && /Google Inc/.test( navigator.vendor )) || header.find( '.slider_engine_revo' ).length == 0
							? 0	//1.2		// Parallax speed (if 0 - disable parallax)
							: 0;
				var adminbar        = jQuery( '#wpadminbar' );
				var adminbar_height = adminbar.length == 0 ? 0 : adminbar.height();
				var mask            = header.find( '.top_panel_mask' );
				var css             = {};
				if (mask.length == 0) {
					header.append( '<div class="top_panel_mask"></div>' );
					mask = header.find( '.top_panel_mask' );
				}
				if (header.css( 'position' ) !== 'fixed') {
					content.css(
						{
							'zIndex': 5,
							'marginTop': header_height + 'px'
						}
					);
					header.css(
						{
							'position': 'fixed',
							'left': 0,
							'top': adminbar_height + 'px',
							'width': '100%',
							'zIndex': 3
						}
					);
				} else {
					content.css( 'marginTop', header_height + 'px' );
				}
				if (scroll_offset > 0) {
					var offset = scroll_offset;	// - adminbar_height;
					if (offset <= header_height) {
						var mask_opacity = Math.max( 0, Math.min( 0.8, (offset - delta) / header_height ) );
						// Don't shift header with Revolution slider in Chrome
						if (shift) {
							header.css( 'transform', 'translate3d(0px, ' + (-Math.round( offset / shift )) + 'px, 0px)' );
						}
						mask.css(
							{
								'opacity': mask_opacity,
								'display': offset == 0 ? 'none' : 'block'
							}
						);
					} else {
						if (shift) {
							header.css( 'transform', 'translate3d(0px, ' + (-Math.round( offset / shift )) + 'px, 0px)' );
						}
					}
				} else {
					if (shift) {
						header.css( 'transform', 'none' );
					}
					if (mask.css( 'display' ) != 'none') {
						mask.css(
							{
								'opacity': 0,
								'display': 'none'
							}
						);
					}
				}
				var footer_height  = Math.min( footer.height(), jQuery( window ).height() );
				var footer_visible = (scroll_offset + jQuery( window ).height()) - (header.outerHeight() + jQuery( '.page_content_wrap' ).outerHeight());
				if (footer.css( 'position' ) !== 'fixed') {
					content.css(
						{
							'marginBottom': footer_height + 'px'
						}
					);
					footer.css(
						{
							'position': 'fixed',
							'left': 0,
							'bottom': 0,
							'width': '100%',
							'zIndex': 2
						}
					);
				} else {
					content.css( 'marginBottom', footer_height + 'px' );
				}
				if (footer_visible > 0) {
					if (footer.css( 'zIndex' ) == 2) {
						footer.css( 'zIndex', 4 );
					}
					mask = footer.find( '.top_panel_mask' );
					if (mask.length == 0) {
						footer.append( '<div class="top_panel_mask"></div>' );
						mask = footer.find( '.top_panel_mask' );
					}
					if (footer_visible <= footer_height) {
						var mask_opacity = Math.max( 0, Math.min( 0.8, (footer_height - footer_visible) / footer_height ) );
						// Don't shift header with Revolution slider in Chrome
						if (shift) {
							footer.css( 'transform', 'translate3d(0px, ' + Math.round( (footer_height - footer_visible) / shift ) + 'px, 0px)' );
						}
						mask.css(
							{
								'opacity': mask_opacity,
								'display': footer_height - footer_visible <= 0 ? 'none' : 'block'
							}
						);
					} else {
						if (shift) {
							footer.css( 'transform', 'none' );
						}
						if (mask.css( 'display' ) != 'none') {
							mask.css(
								{
									'opacity': 0,
									'display': 'none'
								}
							);
						}
					}
				} else {
					if (footer.css( 'zIndex' ) == 4) {
						footer.css( 'zIndex', 2 );
					}
				}
			}
		}

		// Resize actions
		//==============================================

		// Do actions when page scrolled
		function piqes_resize_actions(cont) {
			piqes_check_layout();
			piqes_fix_sidebar(true);
			piqes_fix_footer();
			piqes_fix_nav_links();
			piqes_stretch_width( cont );
			piqes_stretch_height( null, cont );
			piqes_stretch_bg_video();
			piqes_vc_row_fullwidth_to_boxed( cont );
			piqes_stretch_sidemenu();
			piqes_resize_video( cont );
			piqes_shift_under_panels();

			// Call theme/plugins specific action (if exists)
			//----------------------------------------------
			jQuery( document ).trigger( 'action.resize_piqes', [cont] );
		}

		// Stretch sidemenu (if present)
		function piqes_stretch_sidemenu() {
			var toc_items = jQuery( '.menu_side_wrap .toc_menu_item' );
			if (toc_items.length == 0) {
				return;
			}
			var toc_items_height = jQuery( window ).height()
								- piqes_fixed_rows_height( true, false )
								- jQuery( '.menu_side_wrap .sc_layouts_logo' ).outerHeight()
								- toc_items.length;
			var th               = Math.floor( toc_items_height / toc_items.length );
			var th_add           = toc_items_height - th * toc_items.length;
			if (PIQES_STORAGE['menu_side_stretch'] && toc_items.length >= 5 && th >= 30) {
				toc_items.find( ".toc_menu_description,.toc_menu_icon" ).css(
					{
						'height': th + 'px',
						'lineHeight': th + 'px'
					}
				);
				toc_items.eq( 0 ).find( ".toc_menu_description,.toc_menu_icon" ).css(
					{
						'height': (th + th_add) + 'px',
						'lineHeight': (th + th_add) + 'px'
					}
				);
			}
			//jQuery('.menu_side_wrap #toc_menu').height(toc_items_height + toc_items.length - toc_items.eq(0).height());
		}

		// Scroll sidemenu (if present)
		jQuery( document ).on(
			'action.toc_menu_item_active', function() {
				var toc_menu = jQuery( '.menu_side_wrap #toc_menu' );
				if (toc_menu.length == 0) {
					return;
				}
				var toc_items = toc_menu.find( '.toc_menu_item' );
				if (toc_items.length == 0) {
					return;
				}
				var th           = toc_items.eq( 0 ).height(),
				toc_menu_pos     = parseFloat( toc_menu.css( 'top' ) ),
				toc_items_height = toc_items.length * th,
				menu_side_height = jQuery( window ).height()
								- piqes_fixed_rows_height( true, false )
								- jQuery( '.menu_side_wrap .sc_layouts_logo' ).outerHeight()
								- jQuery( '.menu_side_wrap .sc_layouts_logo + .toc_menu_item' ).outerHeight();
				if (toc_items_height > menu_side_height) {
					var toc_item_active = jQuery( '.menu_side_wrap .toc_menu_item_active' ).eq( 0 );
					if (toc_item_active.length == 1) {
						var toc_item_active_pos = (toc_item_active.index() + 1) * th;
						if (toc_menu_pos + toc_item_active_pos > menu_side_height - th) {
							toc_menu.css( 'top', Math.max( -toc_item_active_pos + 3 * th, menu_side_height - toc_items_height ) );
						} else if (toc_menu_pos < 0 && toc_item_active_pos < -toc_menu_pos + 2 * th) {
							toc_menu.css( 'top', Math.min( -toc_item_active_pos + 3 * th, 0 ) );
						}
					}
				} else if (toc_menu_pos < 0) {
					toc_menu.css( 'top', 0 );
				}
			}
		);

		// Check for mobile layout
		function piqes_check_layout() {
			var resize = true;
			if (jQuery( 'body' ).hasClass( 'no_layout' )) {
				jQuery( 'body' ).removeClass( 'no_layout' );
				resize = false;
			}
			var w = window.innerWidth;
			if (w == undefined) {
				w = jQuery( window ).width() + (jQuery( window ).height() < jQuery( document ).height() || jQuery( window ).scrollTop() > 0 ? 16 : 0);
			}
			if (PIQES_STORAGE['mobile_layout_width'] >= w) {
				if ( ! jQuery( 'body' ).hasClass( 'mobile_layout' )) {
					jQuery( 'body' ).removeClass( 'desktop_layout' ).addClass( 'mobile_layout' );
					jQuery( document ).trigger( 'action.switch_to_mobile_layout' );
					if (resize) {
						jQuery( window ).trigger( 'resize' );
					}
				}
			} else {
				if ( ! jQuery( 'body' ).hasClass( 'desktop_layout' )) {
					jQuery( 'body' ).removeClass( 'mobile_layout' ).addClass( 'desktop_layout' );
					jQuery( '.menu_mobile' ).removeClass( 'opened' );
					jQuery( '.menu_mobile_overlay' ).hide();
					jQuery( document ).trigger( 'action.switch_to_desktop_layout' );
					if (resize) {
						jQuery( window ).trigger( 'resize' );
					}
				}
			}
			if (PIQES_STORAGE['mobile_device'] || piqes_browser_is_mobile()) {
				jQuery( 'body' ).addClass( 'mobile_device' );
			}
		}

		// Stretch area to full window width
		function piqes_stretch_width(cont) {
			if (cont === undefined) {
				cont = jQuery( 'body' );
			}
			cont.find( '.trx-stretch-width' ).each(
				function() {
					var $el             = jQuery( this );
					var $el_cont        = $el.parents( '.page_wrap' );
					var $el_cont_offset = 0;
					if ($el_cont.length == 0) {
						$el_cont = jQuery( window );
					} else {
						$el_cont_offset = $el_cont.offset().left;
					}
					var $el_full        = $el.next( '.trx-stretch-width-original' );
					var el_margin_left  = parseInt( $el.css( 'margin-left' ), 10 );
					var el_margin_right = parseInt( $el.css( 'margin-right' ), 10 );
					var offset          = $el_cont_offset - $el_full.offset().left - el_margin_left;
					var width           = $el_cont.width();
					if ( ! $el.hasClass( 'inited' )) {
						$el.addClass( 'inited invisible' );
						$el.css(
							{
								'position': 'relative',
								'box-sizing': 'border-box'
							}
						);
					}
					$el.css(
						{
							'left': offset,
							'width': $el_cont.width()
						}
					);
					if ( ! $el.hasClass( 'trx-stretch-content' ) ) {
						var padding      = Math.max( 0, -1 * offset );
						var paddingRight = Math.max( 0, width - padding - $el_full.width() + el_margin_left + el_margin_right );
						$el.css( { 'padding-left': padding + 'px', 'padding-right': paddingRight + 'px' } );
					}
					$el.removeClass( 'invisible' );
				}
			);
		}

		// Stretch area to the full window height
		function piqes_stretch_height(e, cont) {
			if (cont === undefined) {
				cont = jQuery( 'body' );
			}
			cont.find( '.piqes-full-height' ).each(
				function () {
					// If item now invisible
					if ( jQuery( this ).parents( 'div:hidden,section:hidden,article:hidden' ).length > 0 ) {
						return;
					}
					var fullheight_item = jQuery( this ),
						fullheight_row  = jQuery( this ).closest('.vc_row,.elementor-section').eq(0);
					if (fullheight_row.hasClass('vc_row-o-full-height') || fullheight_row.hasClass('elementor-section-height-full')) {
						if (fullheight_row.css('height') != 'auto') {
							fullheight_item.height( fullheight_row.height() );
						} else if (fullheight_item.css( 'height' ) != 'auto') {
							fullheight_item.height( 'auto' );
						}
					} else {
						var wh = jQuery( window ).height() >= 698 && jQuery( window ).width() > 1024 
							? jQuery( window ).height() - piqes_fixed_rows_height()
							: 'auto';
						if ( wh > 0 ) {
							if ( fullheight_item.data( 'display' ) != fullheight_item.css( 'display' ) ) {
								fullheight_item.css( 'display', fullheight_item.data( 'display' ) );
							}
							if ( fullheight_item.css( 'height', 'auto' ).outerHeight() <= wh ) {
								fullheight_item.css( 'height', wh );
							}
						} else if ( wh == 'auto' && fullheight_item.css( 'height' ) != 'auto' ) {
							if (fullheight_item.data( 'display' ) == undefined) {
								fullheight_item.attr( 'data-display', fullheight_item.css( 'display' ) );
							}
							fullheight_item.css( {'height': wh, 'display': 'block'} );
						}
					}
				}
			);
		}

		// Fit video frames to document width
		function piqes_resize_video(cont) {
			if (cont === undefined) {
				cont = jQuery( 'body' );
			}
			cont.find( 'video' ).each(
				function() {
					// If item now invisible
					if (jQuery( this ).hasClass( 'trx_addons_resize' ) || jQuery( this ).parents( 'div:hidden,section:hidden,article:hidden' ).length > 0) {
						return;
					}
					var video     = jQuery( this ).addClass( 'piqes_resize' ).eq( 0 );
					var ratio     = (video.data( 'ratio' ) !== undefined ? video.data( 'ratio' ).split( ':' ) : [16,9]);
					ratio         = ratio.length != 2 || ratio[0] == 0 || ratio[1] == 0 ? 16 / 9 : ratio[0] / ratio[1];
					var mejs_cont = video.parents( '.mejs-video' ).eq(0);
					var w_attr    = video.data( 'width' );
					var h_attr    = video.data( 'height' );
					if ( ! w_attr || ! h_attr) {
						w_attr = video.attr( 'width' );
						h_attr = video.attr( 'height' );
						if ( ! w_attr || ! h_attr) {
							return;
						}
						video.data( {'width': w_attr, 'height': h_attr} );
					}
					var percent = ('' + w_attr).substr( -1 ) == '%';
					w_attr      = parseInt( w_attr, 10 );
					h_attr      = parseInt( h_attr, 10 );
					var w_real  = Math.round(
						mejs_cont.length > 0
									? Math.min( percent ? 10000 : w_attr, mejs_cont.parents( 'div,article' ).eq(0).width() )
									: Math.min( percent ? 10000 : w_attr, video.parents( 'div,article' ).eq(0).width() )
					),
					h_real      = Math.round( percent ? w_real / ratio : w_real / w_attr * h_attr );
					if (parseInt( video.attr( 'data-last-width' ), 10 ) == w_real) {
						return;
					}
					if (percent) {
						video.height( h_real );
					} else if (video.parents( '.wp-video-playlist' ).length > 0) {
						if (mejs_cont.length === 0) {
							video.attr( {'width': w_real, 'height': h_real} );
						}
					} else {
						video.attr( {'width': w_real, 'height': h_real} ).css( {'width': w_real + 'px', 'height': h_real + 'px'} );
						if (mejs_cont.length > 0) {
							piqes_set_mejs_player_dimensions( video, w_real, h_real );
						}
					}
					video.attr( 'data-last-width', w_real );
				}
			);
			cont.find( '.video_frame iframe' ).each(
				function() {
					// If item now invisible
					if (jQuery( this ).hasClass( 'trx_addons_resize' ) || jQuery( this ).addClass( 'piqes_resize' ).parents( 'div:hidden,section:hidden,article:hidden' ).length > 0) {
						return;
					}
					var iframe = jQuery( this ).eq( 0 );
					if (iframe.attr( 'src' ).indexOf( 'soundcloud' ) > 0) {
						return;
					}
					var ratio  = (iframe.data( 'ratio' ) !== undefined
							? iframe.data( 'ratio' ).split( ':' )
							: (iframe.parent().data( 'ratio' ) !== undefined
								? iframe.parent().data( 'ratio' ).split( ':' )
								: (iframe.find( '[data-ratio]' ).length > 0
									? iframe.find( '[data-ratio]' ).data( 'ratio' ).split( ':' )
									: [16,9]
									)
								)
							);
					ratio      = ratio.length != 2 || ratio[0] == 0 || ratio[1] == 0 ? 16 / 9 : ratio[0] / ratio[1];
					var w_attr = iframe.attr( 'width' );
					var h_attr = iframe.attr( 'height' );
					if ( ! w_attr || ! h_attr) {
						return;
					}
					var percent = ('' + w_attr).substr( -1 ) == '%';
					w_attr      = parseInt( w_attr, 10 );
					h_attr      = parseInt( h_attr, 10 );
					var par     = iframe.parents( 'div,section' ).eq(0),
					pw          = par.width(),
					ph          = par.height(),
					w_real      = pw,
					h_real      = Math.round( percent ? w_real / ratio : w_real / w_attr * h_attr );
					if (par.css( 'position' ) == 'absolute' && h_real > ph) {
						h_real = ph;
						w_real = Math.round( percent ? h_real * ratio : h_real * w_attr / h_attr )
					}
					if (parseInt( iframe.attr( 'data-last-width' ), 10 ) == w_real) {
						return;
					}
					iframe.css( {'width': w_real + 'px', 'height': h_real + 'px'} );
					iframe.attr( 'data-last-width', w_real );
				}
			);
		}

		// Set Media Elements player dimensions
		function piqes_set_mejs_player_dimensions(video, w, h) {
			if (mejs) {
				for (var pl in mejs.players) {
					if (mejs.players[pl].media.src == video.attr( 'src' )) {
						if (mejs.players[pl].media.setVideoSize) {
							mejs.players[pl].media.setVideoSize( w, h );
						} else if (mejs.players[pl].media.setSize) {
							mejs.players[pl].media.setSize( w, h );
						}
						mejs.players[pl].setPlayerSize( w, h );
						mejs.players[pl].setControlsSize();
					}
				}
			}
		}

		// Stretch background video
		function piqes_stretch_bg_video() {
			var video_wrap = jQuery( 'div#background_video,.tourmaster-background-video' );
			if (video_wrap.length == 0) {
				return;
			}
			var cont = video_wrap.hasClass( 'tourmaster-background-video' ) ? video_wrap.parent() : video_wrap,
			w        = cont.width(),
			h        = cont.height(),
			video    = video_wrap.find( '>iframe,>video' );
			if (w / h < 16 / 9) {
				w = h / 9 * 16;
			} else {
				h = w / 16 * 9;
			}
			video
			.attr( {'width': w, 'height': h} )
			.css( {'width': w, 'height': h} );
		}

		// Recalculate width of the vc_row[data-vc-full-width="true"] when content boxed or menu_style=='left|right'
		function piqes_vc_row_fullwidth_to_boxed(cont) {
			if (jQuery( 'body' ).hasClass( 'body_style_boxed' ) || jQuery( 'body' ).hasClass( 'menu_style_side' )) {
				if (cont === undefined || ! cont.hasClass( '.vc_row' ) || ! cont.data( 'vc-full-width' )) {
					cont = jQuery( '.vc_row[data-vc-full-width="true"]' );
				}
				var width_content      = jQuery( '.page_wrap' ).width();
				var width_content_wrap = jQuery( '.page_content_wrap .content_wrap' ).width();
				var indent             = ( width_content - width_content_wrap ) / 2;
				var rtl                = jQuery( 'html' ).attr( 'dir' ) == 'rtl';
				cont.each(
					function() {
						var mrg             = parseInt( jQuery( this ).css( 'marginLeft' ) );
						var stretch_content = jQuery( this ).attr( 'data-vc-stretch-content' );
						var in_content      = jQuery( this ).parents( '.content_wrap' ).length > 0;
						jQuery( this ).css(
							{
								'width': width_content,
								'left': rtl ? 'auto' : (in_content ? -indent : 0) - mrg,
								'right': ! rtl ? 'auto' : (in_content ? -indent : 0) - mrg,
								'padding-left': stretch_content ? 0 : indent + mrg,
								'padding-right': stretch_content ? 0 : indent + mrg
							}
						);
					}
				);
			}
		}

		// Fix/unfix footer
		function piqes_fix_footer() {
			if (jQuery( 'body' ).hasClass( 'header_position_under' ) && ! piqes_browser_is_mobile()) {
				var ft = jQuery( '.footer_wrap' );
				if (ft.length > 0) {
					var ft_height = ft.outerHeight( false ),
					pc            = jQuery( '.page_content_wrap' ),
					pc_offset     = pc.offset().top,
					pc_height     = pc.height();
					if (pc_offset + pc_height + ft_height < jQuery( window ).height()) {
						if (ft.css( 'position' ) != 'absolute') {
							ft.css(
								{
									'position': 'absolute',
									'left': 0,
									'bottom': 0,
									'width' :'100%'
								}
							);
						}
					} else {
						if (ft.css( 'position' ) != 'relative') {
							ft.css(
								{
									'position': 'relative',
									'left': 'auto',
									'bottom': 'auto'
								}
							);
						}
					}
				}
			}
		}

		// Fix/unfix sidebar
		function piqes_fix_sidebar(force) {
			var sb      = jQuery( '.sidebar:not(.sidebar_fixed_placeholder)' );
			var content = sb.siblings( '.content' );
			if (sb.length > 0) {

				// Unfix when sidebar is under content
				if (content.css( 'float' ) == 'none') {
					var old_style = sb.data( 'old_style' );
					if (old_style !== undefined) {
						sb.attr( 'style', old_style ).removeAttr( 'data-old_style' );
					}

				} else {

					var sb_height      = sb.outerHeight();
					var content_height = content.outerHeight();
					var content_top    = content.offset().top;
					var scroll_offset  = jQuery( window ).scrollTop();
					var top_panel_fixed_height = piqes_fixed_rows_height();

					// If sidebar shorter then content and page scrolled below the content's top
					if (sb_height < content_height && scroll_offset + top_panel_fixed_height > content_top) {

						var sb_init = {
							'position': 'undefined',
							'float': 'none',
							'top': 'auto',
							'bottom': 'auto',
							'marginLeft': '0',
							'marginRight': '0'
						};

						if (typeof PIQES_STORAGE['scroll_offset_last'] == 'undefined') {
							PIQES_STORAGE['sb_top_last']        = content_top;
							PIQES_STORAGE['scroll_offset_last'] = scroll_offset;
							PIQES_STORAGE['scroll_dir_last']    = 1;
						}
						var scroll_dir = scroll_offset - PIQES_STORAGE['scroll_offset_last'];
						if (scroll_dir == 0) {
							scroll_dir = PIQES_STORAGE['scroll_dir_last'];
						} else {
							scroll_dir = scroll_dir > 0 ? 1 : -1;
						}

						var sb_big = sb_height + 30 >= jQuery( window ).height() - top_panel_fixed_height,
						sb_top     = sb.offset().top;

						if (sb_top < 0) {
							sb_top = PIQES_STORAGE['sb_top_last'];
						}

						// If sidebar height greater then window height
						if (sb_big) {

							// If change scrolling dir
							if (scroll_dir != PIQES_STORAGE['scroll_dir_last'] && sb.css( 'position' ) == 'fixed') {
								sb_init.top      = sb_top - content_top;
								sb_init.position = 'absolute';

							// If scrolling down
							} else if (scroll_dir > 0) {
								if (scroll_offset + jQuery( window ).height() >= content_top + content_height + 30) {
									sb_init.bottom   = 0;
									sb_init.position = 'absolute';
								} else if (scroll_offset + jQuery( window ).height() >= (sb.css( 'position' ) == 'absolute' ? sb_top : content_top) + sb_height + 30) {
									sb_init.bottom   = 30;
									sb_init.position = 'fixed';
								}

							// If scrolling up
							} else {
								if (scroll_offset + top_panel_fixed_height <= sb_top) {
									sb_init.top      = top_panel_fixed_height;
									sb_init.position = 'fixed';
								}
							}

						// If sidebar height less then window height
						} else {
							if (scroll_offset + top_panel_fixed_height >= content_top + content_height - sb_height) {
								sb_init.bottom   = 0;
								sb_init.position = 'absolute';
							} else {
								sb_init.top      = top_panel_fixed_height;
								sb_init.position = 'fixed';
							}
						}
						
						if (force && sb_init.position == 'undefined' && sb.css('position') == 'absolute') {
							sb_init.position = 'absolute';
							if (sb.css('top') != 'auto') {
								sb_init.top = sb.css('top');
							} else {
								sb_init.bottom = sb.css('bottom');
							}
						}

						if (sb_init.position != 'undefined') {
							// Insert placeholder before sidebar
							var style = sb.attr('style');
							if (!style) style = '';
							if (!sb.prev().hasClass('sidebar_fixed_placeholder')) {
								sb.css(sb_init);
								PIQES_STORAGE['scroll_dir_last'] = 0;
								sb.before('<div class="sidebar_fixed_placeholder '+sb.attr('class')+'"'
										   		+ (sb.data('sb') ? ' data-sb="' + sb.data('sb') + '"' : '')
										   + '></div>');
							}
							// Detect horizontal position
							sb_init.left = sb_init.position == 'fixed' || jQuery('body').hasClass('body_style_fullwide') || jQuery('body').hasClass('body_style_fullscreen')
												? sb.prev().offset().left
												: sb.prev().position().left;
							sb_init.right = 'auto';
							sb_init.width = sb.prev().width() + parseFloat(sb.prev().css('paddingLeft')) + parseFloat(sb.prev().css('paddingRight'));
							// Set position
							if (force
								|| sb.css('position') != sb_init.position 
								|| PIQES_STORAGE['scroll_dir_last'] != scroll_dir
								|| sb.width() != sb_init.width) {
								if (sb.data('old_style') === undefined) {
									sb.attr('data-old_style', style);
								}
								sb.css(sb_init);
							}
						}

						PIQES_STORAGE['sb_top_last']        = sb_top;
						PIQES_STORAGE['scroll_offset_last'] = scroll_offset;
						PIQES_STORAGE['scroll_dir_last']    = scroll_dir;

					} else {

						// Unfix when page scrolling to top
						var old_style = sb.data( 'old_style' );
						if (old_style !== undefined) {
							sb.attr( 'style', old_style ).removeAttr( 'data-old_style' );
							if (sb.prev().hasClass('sidebar_fixed_placeholder')) {
								sb.prev().remove();
							}
						}

					}
				}
			}
		}

		// Fix/unfix .nav_links_fixed
		function piqes_fix_nav_links() {
			var nav_links = jQuery( '.nav-links-single.nav-links-fixed' );
			if (nav_links.length > 0 && nav_links.css( 'position' ) == 'fixed') {
				var window_height = jQuery(window).height(),
					window_bottom = jQuery(window).scrollTop() + window_height,
					article = jQuery('.post_item_single'),
					article_top = article.length > 0 ? article.offset().top : window_height,
					article_bottom = article_top + ( article.length > 0 ? article.height() : 0 ),
					footer = jQuery('.footer_wrap'),
					footer_top = footer.length > 0 ? footer.offset().top : 100000;
				if (article_bottom < window_bottom && footer_top > window_bottom) {
					if (!nav_links.hasClass('nav-links-visible')) {
						nav_links.addClass('nav-links-visible');
					}
				} else {
					if (nav_links.hasClass('nav-links-visible')) {
						nav_links.removeClass('nav-links-visible');
					}					
				}
			}
		}


		// Navigation
		//==============================================

		// Init Superfish menu
		function piqes_init_sfmenu(selector) {
			jQuery( selector ).show().each(
				function() {
					// Do not init the mobile menu - only add class 'inited'
					if (jQuery( this ).addClass( 'inited' ).parents( '.menu_mobile' ).length > 0) {
						return;
					}
					var animation_in = jQuery( this ).parent().data( 'animation_in' );
					if (animation_in == undefined) {
						animation_in = "none";
					}
					var animation_out = jQuery( this ).parent().data( 'animation_out' );
					if (animation_out == undefined) {
						animation_out = "none";
					}
					jQuery( this ).superfish(
						{
							delay: 500,
							animation: {
								opacity: 'show'
							},
							animationOut: {
								opacity: 'hide'
							},
							speed: 		animation_in != 'none' ? 500 : 200,
							speedOut:	animation_out != 'none' ? 500 : 200,
							autoArrows: false,
							dropShadows: false,
							onBeforeShow: function(ul) {
								// Detect horizontal position (left | right)
								if (jQuery( this ).parents( "ul" ).length > 1) {
									var w          = jQuery( '.page_wrap' ).width();
									var par_offset = jQuery( this ).parents( "ul" ).eq(0).offset().left;
									var par_width  = jQuery( this ).parents( "ul" ).eq(0).outerWidth();
									var ul_width   = jQuery( this ).outerWidth();
									if (par_offset + par_width + ul_width > w - 20 && par_offset - ul_width > 0) {
										jQuery( this ).addClass( 'submenu_left' );
									} else {
										jQuery( this ).removeClass( 'submenu_left' );
									}
								}
								// Shift vertical if menu going out the window
								if (jQuery( this ).parents( '.top_panel' ).length > 0) {
									var ul_height = jQuery( this ).outerHeight(),
									w_height      = jQuery( window ).height(),
									row           = jQuery( this ).parents( '.sc_layouts_row' ).eq(0),
									row_offset    = 0,
									row_height    = 0,
									par           = jQuery( this ).parent(),
									par_offset    = 0;
									while (row.length > 0) {
										row_offset += row.outerHeight();
										if (row.hasClass( 'sc_layouts_row_fixed_on' )) {
											break;
										}
										row = row.prev();
									}
									while (par.length > 0) {
										par_offset += par.position().top + par.parent().position().top;
										row_height  = par.outerHeight();
										if (par.position().top == 0) {
											break;
										}
										par = par.parents( 'li' ).eq(0);
									}
									if (row_offset + par_offset + ul_height > w_height) {
										if (par_offset > ul_height) {
											jQuery( this ).css(
												{
													'top': 'auto',
													'bottom': '-1.4em'
												}
											);
										} else {
											jQuery( this ).css(
												{
													'top': '-' + (par_offset - row_height - 2) + 'px',
													'bottom': 'auto'
												}
											);
										}
									}
								}
								// Animation in
								if (animation_in != 'none') {
									jQuery( this ).removeClass( 'animated fast ' + animation_out );
									jQuery( this ).addClass( 'animated fast ' + animation_in );
								}
							},
							onBeforeHide: function(ul) {
								if (animation_out != 'none') {
									jQuery( this ).removeClass( 'animated fast ' + animation_in );
									jQuery( this ).addClass( 'animated fast ' + animation_out );
								}
							},
							onShow: function(ul) {
								// Init layouts
								if ( ! jQuery( this ).hasClass( 'layouts_inited' )) {
									jQuery( this ).addClass( 'layouts_inited' );
									jQuery( document ).trigger( 'action.init_hidden_elements', [jQuery( this )] );
								}
							}
						}
					);
				}
			);
		}

		// Add TOC in the side menu
		// Make this function global because it used in the elementor.js
		function piqes_add_toc_to_sidemenu() {
			if (jQuery( '.menu_side_inner' ).length > 0 && jQuery( '#toc_menu' ).length > 0) {
				jQuery( '#toc_menu' ).appendTo( '.menu_side_inner' );
				piqes_stretch_sidemenu();
			}
		}

		// Post formats init
		//=====================================================

		function piqes_init_post_formats(e, cont) {

			// Wrap select with .select_container
			cont.find( 'select:not(.esg-sorting-select):not([class*="trx_addons_attrib_"])' ).each(
				function() {
					var s = jQuery( this );
					if ( s.css( 'display' ) != 'none'
						&& s.parents( '.select_container' ).length == 0
						&& ! s.next().hasClass( 'select2' )
						&& ! s.hasClass( 'select2-hidden-accessible' )) {
							s.wrap( '<div class="select_container"></div>' );
							// Bubble submit() up for widget "Categories"
							if ( s.parents( '.widget_categories' ).length > 0 ) {
								s.parent().get(0).submit = function() {
									jQuery(this).closest('form').eq(0).submit();
								};
							}
					}
				}
			);

			// MediaElement init
			piqes_init_media_elements( cont );

			// Video play button
			cont.find( '.format-video .post_featured.with_thumb .post_video_hover:not(.inited)' )
				.addClass( 'inited' )
				.on(
					'click', function(e) {
						jQuery( this ).parents( '.post_featured' ).eq(0)
							.addClass( 'post_video_play' )
							.find( '.post_video' ).html( jQuery( this ).data( 'video' ) );
						jQuery( window ).trigger( 'resize' );
						e.preventDefault();
						return false;
					}
				);
		}

		PIQES_STORAGE['mejs_attempts'] = 0;
		function piqes_init_media_elements(cont) {
			if (PIQES_STORAGE['use_mediaelements'] && cont.find( 'audio:not(.inited),video:not(.inited)' ).length > 0) {
				if (window.mejs) {
					if (window.mejs.MepDefaults) {
						window.mejs.MepDefaults.enableAutosize = true;
					}
					if (window.mejs.MediaElementDefaults) {
						window.mejs.MediaElementDefaults.enableAutosize = true;
					}
					cont.find( 'audio:not(.inited),video:not(.inited)' ).each(
						function() {
							// If item now invisible
							if (jQuery( this ).parents( 'div:hidden,section:hidden,article:hidden' ).length > 0) {
								return;
							}
							if (jQuery( this ).addClass( 'inited' ).parents( '.mejs-mediaelement' ).length == 0
                                && jQuery( this ).parents( '.wp-block-video' ).length == 0
                                && ! jQuery( this ).hasClass( 'wp-block-cover__video-background' )
							&& jQuery( this ).parents( '.elementor-background-video-container' ).length == 0
							&& (PIQES_STORAGE['init_all_mediaelements']
								|| ( ! jQuery( this ).hasClass( 'wp-audio-shortcode' )
									&& ! jQuery( this ).hasClass( 'wp-video-shortcode' )
									&& ! jQuery( this ).parent().hasClass( 'wp-playlist' )
									)
								)
							) {
								var media_tag  = jQuery( this ),
									media_cont = media_tag.parents('.post_video,.video_frame').eq(0),
									cont_w     = media_cont.length > 0 ? media_cont.width() : -1,
									cont_h     = media_cont.length > 0 ? Math.floor(cont_w / 16 * 9) : -1,
									settings   = {
										enableAutosize: true,
										videoWidth: cont_w,		// if set, overrides <video width>
										videoHeight: cont_h,	// if set, overrides <video height>
										audioWidth: '100%',		// width of audio player
										audioHeight: 40,		// height of audio player
										success: function(mejs) {
											if ( mejs.pluginType && 'flash' === mejs.pluginType && mejs.attributes ) {
												mejs.attributes.autoplay
												&& 'false' !== mejs.attributes.autoplay
												&& mejs.addEventListener( 'canplay', function () {	mejs.play(); }, false );
												mejs.attributes.loop
												&& 'false' !== mejs.attributes.loop
												&& mejs.addEventListener( 'ended', function () {	mejs.play(); }, false );
											}
										}
									};
								jQuery( this ).mediaelementplayer( settings );
							}
						}
					);
				} else if ( PIQES_STORAGE['mejs_attempts']++ < 5 ) {
					setTimeout( function() { piqes_init_media_elements( cont ); }, 400 );
				}
			}
			// Init all media elements after first run
			setTimeout( function() { PIQES_STORAGE['init_all_mediaelements'] = true; }, 1000 );
		}

		// Load the tab's content
		function piqes_tabs_ajax_content_loader(panel, page, oldPanel) {
			if (panel.html().replace( /\s/g, '' ) == '') {
				var height = oldPanel === undefined ? panel.height() : oldPanel.height();
				if (isNaN( height ) || height < 100) {
					height = 100;
				}
				panel.html( '<div class="piqes_tab_holder" style="min-height:' + height + 'px;"></div>' );
			} else {
				panel.find( '> *' ).addClass( 'piqes_tab_content_remove' );
			}
			panel.data( 'need-content', false ).addClass( 'piqes_loading' );
			jQuery.post(
				PIQES_STORAGE['ajax_url'], {
					nonce: PIQES_STORAGE['ajax_nonce'],
					action: 'piqes_ajax_get_posts',
					blog_template: panel.data( 'blog-template' ),
					blog_style: panel.data( 'blog-style' ),
					posts_per_page: panel.data( 'posts-per-page' ),
					cat: panel.data( 'cat' ),
					parent_cat: panel.data( 'parent-cat' ),
					post_type: panel.data( 'post-type' ),
					taxonomy: panel.data( 'taxonomy' ),
					page: page
				}
			).done(
				function(response) {
						panel.removeClass( 'piqes_loading' );
						var rez = {};
					try {
						rez = JSON.parse( response );
					} catch (e) {
						rez = { error: PIQES_STORAGE['msg_ajax_error'] };
						console.log( response );
					}
					if (rez.error !== '') {
						panel.html( '<div class="piqes_error">' + rez.error + '</div>' );
					} else {
						panel.prepend( rez.data ).fadeIn(
							function() {
								jQuery( document ).trigger( 'action.init_hidden_elements', [panel] );
								jQuery( window ).trigger( 'scroll' );
								setTimeout(
									function() {
										panel.find( '.piqes_tab_holder,.piqes_tab_content_remove' ).remove();
										jQuery( window ).trigger( 'scroll' );
									}, 600
								);
							}
						);
					}
				}
			);
		}

	}
);
