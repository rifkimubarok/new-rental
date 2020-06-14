// Popup msgbox
//-----------------------------------------------------------------
(function() {
	"use strict";

	var msgbox_callback = null,
		msgbox_timeout = 5000;

	jQuery('body').on('click', '#trx_addons_modal_bg:not(.trx_addons_dialog_bg),.trx_addons_msgbox .trx_addons_msgbox_close', function (e) {
		trx_addons_msgbox_destroy();
		if (msgbox_callback) {
			msgbox_callback(0);
			msgbox_callback = null;
		}
		e.preventDefault();
		return false;
	});


	// Warning
	window.trx_addons_msgbox_warning = function(msg) {
		var hdr  = arguments[1] ? arguments[1] : '';
		var icon = arguments[2] ? arguments[2] : 'cancel';
		var delay = arguments[3] ? arguments[3] : msgbox_timeout;
		return trx_addons_msgbox({
			msg: msg,
			hdr: hdr,
			icon: icon,
			type: 'warning',
			delay: delay,
			buttons: [],
			callback: null
		});
	};

	// Success
	window.trx_addons_msgbox_success = function(msg) {
		var hdr  = arguments[1] ? arguments[1] : '';
		var icon = arguments[2] ? arguments[2] : 'check';
		var delay = arguments[3] ? arguments[3] : msgbox_timeout;
		return trx_addons_msgbox({
			msg: msg,
			hdr: hdr,
			icon: icon,
			type: 'success',
			delay: delay,
			buttons: [],
			callback: null
		});
	};

	// Info
	window.trx_addons_msgbox_info = function(msg) {
		var hdr  = arguments[1] ? arguments[1] : '';
		var icon = arguments[2] ? arguments[2] : 'info';
		var delay = arguments[3] ? arguments[3] : msgbox_timeout;
		return trx_addons_msgbox({
			msg: msg,
			hdr: hdr,
			icon: icon,
			type: 'info',
			delay: delay,
			buttons: [],
			callback: null
		});
	};

	// Regular
	window.trx_addons_msgbox_regular = function(msg) {
		var hdr  = arguments[1] ? arguments[1] : '';
		var icon = arguments[2] ? arguments[2] : 'quote-right';
		var delay = arguments[3] ? arguments[3] : msgbox_timeout;
		return trx_addons_msgbox({
			msg: msg,
			hdr: hdr,
			icon: icon,
			type: 'regular',
			delay: delay,
			buttons: [],
			callback: null
		});
	};

	// YesNo dialog
	window.trx_addons_msgbox_yesno = function(msg) {
		var hdr  = arguments[1] ? arguments[1] : '';
		var callback = arguments[2] ? arguments[2] : null;
		return trx_addons_msgbox({
			msg: msg,
			hdr: hdr,
			icon: 'help',
			type: 'regular',
			delay: 0,
			buttons: [ TRX_ADDONS_STORAGE['msg_caption_yes'], TRX_ADDONS_STORAGE['msg_caption_no'] ],
			callback: callback
		});
	};

	// Confirm dialog
	window.trx_addons_msgbox_confirm = function(msg) {
		var hdr  = arguments[1] ? arguments[1] : '';
		var callback = arguments[2] ? arguments[2] : null;
		return trx_addons_msgbox({
			msg: msg,
			hdr: hdr,
			icon: 'attention',
			type: 'warning',
			delay: 0,
			buttons: [ TRX_ADDONS_STORAGE['msg_caption_ok'], TRX_ADDONS_STORAGE['msg_caption_cancel'] ],
			callback: callback
		});
	};

	// Modal dialog
	window.trx_addons_msgbox_dialog = function(content) {
		var hdr  = arguments[1] ? arguments[1] : '';
		var init = arguments[2] ? arguments[2] : null;
		var callback = arguments[3] ? arguments[3] : null;
		return trx_addons_msgbox({
			msg: content,
			hdr: hdr,
			icon: '',
			type: 'regular',
			delay: 0,
			buttons: [ TRX_ADDONS_STORAGE['msg_caption_apply'], TRX_ADDONS_STORAGE['msg_caption_cancel'] ],
			init: init,
			callback: callback
		});
	};

	// General msgbox window
	window.trx_addons_msgbox = function(opt) {
		var msg = opt.msg != undefined ? opt.msg : '';
		var hdr  = opt.hdr != undefined ? opt.hdr : '';
		var icon = opt.icon != undefined ? opt.icon : '';
		var type = opt.type != undefined ? opt.type : 'regular';
		var delay = opt.delay != undefined ? opt.delay : msgbox_timeout;
		var buttons = opt.buttons != undefined ? opt.buttons : [];
		var init = opt.init != undefined ? opt.init : null;
		var callback = opt.callback != undefined ? opt.callback : null;
		// Modal bg
		if (jQuery('#trx_addons_modal_bg').length == 0) {
			jQuery('body').append('<div id="trx_addons_modal_bg"></div>');
		}
		jQuery('#trx_addons_modal_bg').toggleClass('trx_addons_dialog_bg', buttons.length > 0).fadeIn();
		// Popup window
		jQuery('.trx_addons_msgbox').remove();
		var html = '<div class="trx_addons_msgbox trx_addons_msgbox_' + type
				+ (buttons.length > 0 ? ' trx_addons_msgbox_dialog' : '')
				+ (icon && !hdr ? ' trx_addons_msgbox_simple' : '')
			+ '">'
			+ '<span class="trx_addons_msgbox_close trx_addons_icon-cancel"></span>'
			+ (hdr ? '<h5 class="trx_addons_msgbox_header">'+hdr+'</h5>' : '')
			+ (icon ? '<span class="trx_addons_msgbox_icon trx_addons_icon-'+icon+'"></span>' : '')
			+ '<div class="trx_addons_msgbox_body">' + msg + '</div>';
		if (buttons.length > 0) {
			html += '<div class="trx_addons_msgbox_buttons">';
			for (var i=0; i<buttons.length; i++) {
				html += '<span class="trx_addons_msgbox_button">'+buttons[i]+'</span>';
			}
			html += '</div>';
		}
		html += '</div>';
		// Add msgbox to body
		jQuery('body').append(html);
		var msgbox = jQuery('body .trx_addons_msgbox').eq(0);
		// Prepare callback on buttons click
		if (callback != null) {
			msgbox_callback = callback;
			jQuery('.trx_addons_msgbox_button').on('click', function(e) {
				var btn = jQuery(this).index();
				callback( btn+1, msgbox );
				msgbox_callback = null;
				trx_addons_msgbox_destroy();
			});
		}
		// Call init function
		if (init != null) init(msgbox);
		// Show (animate) msgbox
		var top = jQuery(window).scrollTop();
		msgbox.animate(
			{
				top: top+Math.round((jQuery(window).height()-jQuery('.trx_addons_msgbox').height())/2),
				opacity: 1
			},
			{
				complete: function () {
							// Call init function
							//if (init != null) init(msgbox);
							}
			}
		);
		// Delayed destroy (if need)
		if (delay > 0) {
			setTimeout( function() { trx_addons_msgbox_destroy(); }, delay );
		}
		return msgbox;
	};

	// Destroy msgbox window
	window.trx_addons_msgbox_destroy = function() {
		var top = jQuery(window).scrollTop();
		jQuery('#trx_addons_modal_bg').fadeOut();
		jQuery('.trx_addons_msgbox').animate(
			{
				top: top-jQuery('.trx_addons_msgbox').height(),
				opacity: 0
			}
		);
		setTimeout( function() {
				jQuery('#trx_addons_modal_bg').remove();
				jQuery('.trx_addons_msgbox').remove();
			},
			500
		);
	};

})();
