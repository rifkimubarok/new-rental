/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

jQuery(document).ready(function() {	
	"use strict";

	// Votes in the comment
	var votes_wrap = jQuery(".trx_addons_reviews_stars[data-mark-max]");
	if (votes_wrap.length > 0) {		
		votes_wrap
			// Show value slider on hover
			.on('mousemove', function(e) {	
				var mark_wrap = jQuery(this),
					mark_max  = mark_wrap.data('mark-max'),
					w = mark_wrap.width(),
					x = Math.min( w, Math.max( 0, Math.round( e.pageX - mark_wrap.offset().left ) ) ) + 1;
				if (x <= w) {
					var pos = Math.round(x / w * 100),
						mark_show = trx_addons_reviews_mark2show(pos, mark_max);
					pos = trx_addons_reviews_mark2save(mark_show, mark_max);
					// Shift bubble and show new value in it
					mark_wrap
						.data("mark", pos)
						.find(".trx_addons_reviews_bubble")
						.fadeIn()
						.css({"left": pos + "%"})
							.find('.trx_addons_reviews_bubble_value')
							.text(mark_show);
					// Set new width of the 'stars hover'
					mark_wrap
						.find(".trx_addons_reviews_stars_hover")
						.css({"width": pos+"%"});
				}
			})
			// Hide value slider
			.on('mouseleave', function(e) {
				var mark_wrap = jQuery(this),
					pos = Math.max(0, Number(mark_wrap.find('input[name="trx_addons_reviews_vote"]').val()));
				mark_wrap.find(".trx_addons_reviews_bubble").fadeOut();
				mark_wrap.find(".trx_addons_reviews_stars_hover").css({"width": pos+"%"});
			})
			// Save vote on click
			.on('click', function(e) {
				var mark_wrap = jQuery(this);
				mark_wrap
					.find('input[name="trx_addons_reviews_vote"]')
					.val( mark_wrap.data("mark") );
				mark_wrap
					.next('.trx_addons_reviews_text')
						.find('.trx_addons_reviews_text_mark')
						.text(mark_wrap.find('.trx_addons_reviews_bubble_value').text());
			});
	}

	// Convert rating mark to the display equivalent
	function trx_addons_reviews_mark2show(mark, mark_max) {
		if (mark_max < 100) {
			mark = Math.round(mark / 100 * mark_max * 10) / 10;
			if (String(mark).indexOf(".") < 0) {
				mark += ".0";
			}
		} else {
			mark = Math.round(mark);
		}
		return mark;
	}

	// Convert rating mark to the storage equivalent
	function trx_addons_reviews_mark2save(mark, mark_max) {
		if (mark_max < 100) {
			mark = Math.round(mark * 100 / mark_max);
		} else {
			mark = Math.round(mark);
		}
		return mark;
	}
	
	jQuery(document).on('action.init_hidden_elements', trx_addons_reviews_block_mark_init);
	jQuery(document).on('action.scroll_trx_addons', trx_addons_reviews_block_mark_init);
	jQuery(document).on('action.resize_trx_addons', trx_addons_reviews_block_mark_resize);
	
	// Init marks in the reviews blocks
	function trx_addons_reviews_block_mark_init(e, container) {
	
		if (container === undefined) container = jQuery('body');
	
		var scrollPosition = jQuery(window).scrollTop() + jQuery(window).height();
	
		container.find('.trx_addons_reviews_block_mark:not(.inited)'
			+',.trx_addons_reviews_stars:not([data-mark-max]):not(.inited)'
			+',.trx_addons_reviews_block_detailed .trx_addons_reviews_block_criterias[data-mark-max="10"] .trx_addons_reviews_block_list_mark_line_hover:not(.inited)'
			+',.trx_addons_reviews_block_detailed .trx_addons_reviews_block_criterias[data-mark-max="100"] .trx_addons_reviews_block_list_mark_line_hover:not(.inited)'
		).each(function () {
			var item = jQuery(this);
			// If item now invisible
			if (jQuery(this).parents('div:hidden,article:hidden').length > 0) {
				return;
			}
			var scrollMark = item.offset().top;
			if (scrollPosition - 50 > scrollMark) {
				item.addClass('inited');
				if (item.hasClass('trx_addons_reviews_block_mark')) {
					var canvas = item.find('canvas').eq(0),
						mark   = parseFloat(canvas.data('value')),
						max    = parseInt(canvas.data('max-value'), 10),
						digits = item.find('.trx_addons_reviews_block_mark_value');
					item.find('.trx_addons_reviews_block_mark_progress').animate(
						{
							'width': trx_addons_reviews_mark2save( mark, max )+'%'
						},
						{
							duration: 2000,
							easing: 'linear',
							step: function(now, fx) {
								var m = trx_addons_reviews_mark2show( now, max );
								digits.text(m);
								trx_addons_draw_arc_on_canvas(item, m);
							}
						}
					);
				}
			}
		});
	}

	function trx_addons_reviews_block_mark_resize( e ) {
		jQuery('.trx_addons_reviews_block_mark.inited canvas').each(function () {
			var canvas = jQuery(this);
			// If item now invisible
			if (canvas.parents('div:hidden,article:hidden').length > 0) {
				return;
			}
			var item = canvas.parent();
			if (item.width() != canvas.width()) {
				trx_addons_draw_arc_on_canvas(item, parseFloat(canvas.data('value')));
			}
		});
	}

});