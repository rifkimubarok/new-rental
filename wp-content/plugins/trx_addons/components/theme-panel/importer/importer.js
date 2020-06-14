/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

jQuery(document).ready(function(){

	"use strict";

	// Start banners rotator (if visible)
	if ( !jQuery('.trx_banners_section').hasClass('trx_addons_hidden') ) {
		trx_addons_banners_rotator();
	}

	// Hide/Show pages list on change import_posts
	jQuery('#trx_importer_form .trx_importer_item_posts').on('change', function() {
		var demo_set = jQuery('#trx_importer_form [name="demo_set"]:checked').val();
		if (jQuery(this).get(0).checked && demo_set=='part') 
			jQuery('.trx_importer_part_pages').show();
		else
			jQuery('.trx_importer_part_pages').hide();
	});

	// Change demo type
	jQuery('.trx_importer_demo_type input[type="radio"]').on('change', function() {
		var type = jQuery(this).val();
		// Refresh list of the pages
		var data = {
			ajax_nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
			action: 'trx_addons_importer_get_list_pages',
			demo_type: type
		};
		jQuery.post(TRX_ADDONS_STORAGE['ajax_url'], data, function(response) {
			var rez = {};
			try {
				rez = JSON.parse(response);
			} catch (e) {
				rez = { error: TRX_ADDONS_STORAGE['ajax_error']+':<br>'+response };
				console.log(response);
			}
			if (rez.error === '') {
				var html = '';
				for (var id in rez.data) {
					html += '<label>'
							+ '<input class="trx_importer_pages" type="checkbox" value="'+id+'" name="import_pages_'+id+'" id="import_pages_'+id+'" />'
							+ ' ' + rez.data[id]
							+ '</label>';
				}
				if (html !== '') jQuery('.trx_importer_part_pages').html(html);
			}
		});
	});

	// Demo set radio buttons
	jQuery('.trx_importer_demo_set input[type="radio"]').on('change', function() {
		var set = jQuery(this).val(),
			set_controls = jQuery(this).parents('.trx_importer_demo_set_controls');
		// Confirm about full installation
		if (set == 'full') {
			trx_addons_msgbox_confirm(
				TRX_ADDONS_STORAGE['msg_importer_full_alert'],
				TRX_ADDONS_STORAGE['msg_caption_warning'],
				function(btn) {
					if (btn == 1) {
						trx_addons_importer_change_demo_set(set);
					} else {
						set_controls.find('input[type="radio"]').removeAttr('checked').get(0).checked = true;
					}
				}
			);
		} else {
			trx_addons_importer_change_demo_set(set);
		}
	});
	jQuery('.trx_importer_demo_set input[type="radio"]').eq(0).trigger('change');

	// Change demo set
	function trx_addons_importer_change_demo_set(set) {
		var set_controls = jQuery('.trx_importer_demo_set_controls'),
			set_radio = set_controls.find('input[type="radio"][value="'+set+'"]'),
			set_form = set_controls.parents('form');
		set_controls.find('label').removeClass('trx_importer_demo_set_active');
		set_radio.parent().addClass('trx_importer_demo_set_active');
		// Check all components if full installation is checked and uncheck otherwise
		jQuery('.trx_importer_advanced_settings_block > label > input[type="checkbox"]').each(function() {
			this.checked = set == 'full' || jQuery(this).attr('id') == 'import_posts';
			jQuery(this).trigger('change');
		});
		// Hide advanced settings if full installation is selected
		if ( ( set == 'full' && jQuery('.trx_importer_advanced_settings_wrap').hasClass('trx_importer_advanced_settings_opened') )
			||
			( set == 'part' && !jQuery('.trx_importer_advanced_settings_wrap').hasClass('trx_importer_advanced_settings_opened') )
		) {
			jQuery('.trx_importer_advanced_settings_title').trigger('click');
		}
		// Show/hide description of the set
		set_radio.parents('form')
			.find('.trx_importer_description:not(.trx_importer_description_both)').slideUp()
			.end()
			.find('.trx_importer_description_'+set).slideDown();
		// Show/hide set items

		set_form.find('[data-set-'+set+'="1"]').parent().show();
		set_form.find('[data-set-'+set+'="0"]').removeAttr('checked').parent().hide();
		set_form.find('.trx_importer_item_posts').trigger('change');
	}
	
	// Show/Hide advanced settings
	jQuery('.trx_importer_advanced_settings_title').on('click', function(e) {
		var wrap = jQuery(this).parent();
		if (wrap.hasClass('trx_importer_advanced_settings_opened')) {
			jQuery('.trx_importer_advanced_settings').slideUp();
			wrap.removeClass('trx_importer_advanced_settings_opened');
		} else {
			jQuery('.trx_importer_advanced_settings').slideDown();
			wrap.addClass('trx_importer_advanced_settings_opened');			
		}
		e.preventDefault();
		return false;
	});

	// Start import
	jQuery('.trx_importer_section').on('click', '.trx_buttons input[type="button"]', function() {
		var steps = [];
		var demo_type = jQuery('#trx_importer_form [name="demo_type"]:checked').val();
		var demo_set = jQuery('#trx_importer_form [name="demo_set"]:checked').val();
		var demo_parts = '', demo_pages = '';
		jQuery(this).parents('form').find('input[type="checkbox"].trx_importer_item').each(function() {
			var name = jQuery(this).attr('name');
			// Collect parts to be imported
			if (jQuery(this).get(0).checked) {
				demo_parts += (demo_parts ? ',' : '') + name.substr(7); // Remove 'import_' from name - save only slug
				// Collect pages to be import
				if (demo_set=='part' && name == 'import_posts') {
					jQuery('.trx_importer_part_pages input[type="checkbox"]').each(function() {
						if (jQuery(this).get(0).checked) {
							demo_pages += (demo_pages ? ',' : '') + jQuery(this).val();
						}
					});
				}
				var step = {
					action: name,
					data: {
						demo_type: demo_type,
						demo_set: demo_set,
						demo_parts: demo_parts,
						demo_pages: demo_pages,
						start_from_id: 0
					}
				};
				steps.push(step);
			} else
				jQuery('#trx_importer_progress .'+name).hide();
		});
		// Move 'uploads' and 'thumbnails' to the end of the list
		var uploads = false, thumbs = false;
		for (var s=steps.length-1; s>=0; s--) {
			if (steps[s].action == 'import_uploads') {
				uploads = steps[s];
				steps.splice(s, 1);
			} else if (steps[s].action == 'import_thumbnails') {
				thumbs = steps[s];
				steps.splice(s, 1);
			}
		}
		steps.unshift({
			action: 'import_start',
			data: { 
				demo_type: demo_type,
				demo_set: demo_set,
				demo_parts: demo_parts
			}
		});
		if (uploads !== false) {
			steps.push(uploads);
		}
		if (thumbs !== false) {
			steps.push(thumbs);
		}
		steps.push({
			action: 'import_end',
			data: { 
				demo_type: demo_type,
				demo_set: demo_set,
				demo_parts: demo_parts
			}
		});
		// Hide Exporter
		jQuery('.trx_exporter_section').fadeOut();
		// Start banners rotator
		if (jQuery('.trx_banners_section').hasClass('trx_addons_hidden')) {
			jQuery('.trx_banners_section').removeClass('trx_addons_hidden');
			trx_addons_banners_rotator();
		}
		// Start import
		trx_addons_document_animate_to('trx_addons_theme_panel_section_demo');
		jQuery('#trx_addons_theme_panel_section_demo .trx_addons_theme_panel_buttons').css('pointer-events', 'none');
		jQuery('#trx_importer_form').hide();
		jQuery('#trx_importer_progress').slideDown();
		TRX_ADDONS_STORAGE['importer_error_messages'] = '';
		TRX_ADDONS_STORAGE['importer_ignore_errors'] = true;
		trx_addons_importer_do_action(steps, 0);
	});
	
	// Call specified action (step)
	function trx_addons_importer_do_action(steps, idx) {
		if ( !jQuery('#trx_importer_progress .'+steps[idx].action+' .import_progress_status').hasClass('step_in_progress') )
			jQuery('#trx_importer_progress .'+steps[idx].action+' .import_progress_status').addClass('step_in_progress').html('0%');
		// AJAX query params
		var data = {
			ajax_nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
			action: 'trx_addons_importer_start_import',
			importer_action: steps[idx].action
		};
		// Additional params depend current step
		for (var i in steps[idx].data)
			data[i] = steps[idx].data[i];
		// Send request to server
		jQuery.post(TRX_ADDONS_STORAGE['ajax_url'], data, function(response) {
			var rez = {}, pos = -1;
			try {
				if ( (pos = response.indexOf('{"action":')) >= 0 || (pos = response.indexOf('{"error":')) >= 0 || (pos = response.indexOf('{"data":')) >= 0 ) {
					response = response.substr(pos);
					rez = JSON.parse( response );
				} else {
					rez.error = TRX_ADDONS_STORAGE['ajax_error'];
				}
			} catch (e) {
				rez = { error: TRX_ADDONS_STORAGE['ajax_error']+':<br>'+response };
				console.log(response);
			}
			if (rez.error === '' || TRX_ADDONS_STORAGE['importer_ignore_errors']) {
				if (rez.error !== '') 
					TRX_ADDONS_STORAGE['importer_error_messages'] += '<span class="error_message">' + rez.error + '</span>';
				var action = rez.action;
				if (rez.result === null || rez.result >= 100) {
					jQuery('#trx_importer_progress .'+action+' .import_progress_status').html('');
					jQuery('#trx_importer_progress .'+action+' .import_progress_status').removeClass('step_in_progress').addClass('step_complete'+(rez.error ? ' step_complete_with_error' : ''));
					idx++;
				} else {
					jQuery('#trx_importer_progress .'+action+' .import_progress_status').html(rez.result + '%');
					steps[idx].data['start_from_id'] = (typeof rez.start_from_id != 'undefined') ? rez.start_from_id : 0;
					steps[idx].data['attempt'] = (typeof rez.attempt != 'undefined') ? rez.attempt : 0;
				}
				// Do next action
				if (idx < steps.length) {
					trx_addons_importer_do_action(steps, idx);
				} else {
					if (TRX_ADDONS_STORAGE['importer_error_messages']) {
						jQuery('#trx_importer_progress')
							.removeClass('notice-info').addClass('notice-error')
							.find('.trx_importer_progress_result')
								.prepend(TRX_ADDONS_STORAGE['msg_importer_error'] + '<br>')
								.find('.trx_importer_progress_result_msg')
									.addClass('trx_importer_progress_error')
									.html(TRX_ADDONS_STORAGE['importer_error_messages']);
					} else {
						jQuery('#trx_importer_progress')
							.removeClass('notice-info').addClass('notice-success')
							.find('.trx_importer_progress_result_msg')
								.addClass('trx_importer_progress_complete');
					}
					jQuery('.trx_importer_progress_result').show();
					// Reload page after the import
					if (jQuery('.trx_addons_theme_panel').length > 0) {
						if (jQuery('.trx_addons_theme_panel .trx_addons_tabs').hasClass('trx_addons_panel_wizard')) {
							trx_addons_set_cookie('trx_addons_theme_panel_wizard_section', 'trx_addons_theme_panel_section_demo');
						} else {
							if ( location.hash != 'trx_addons_theme_panel_section_qsetup' ) {
								trx_addons_document_set_location( location.href.split('#')[0] + '#' + 'trx_addons_theme_panel_section_qsetup' );
							}
						}
						location.reload( true );
					}
				}
			} else {
				// Add Error block above Import section
				jQuery('#trx_importer_progress').removeClass('notice-info').addClass('notice-error').css({'paddingTop': '1em', 'paddingBottom': '1em'}).html(rez.error);
			}
		});
	}
	
	
	// Rotate banners
	function trx_addons_banners_rotator() {
		var banners = jQuery('.trx_banners_item');
		if (banners.length == 0) return;
		var active = jQuery('.trx_banners_item_active').index(),
			next = (active + 1) % banners.length,
			duration = 20000;
		if (active >= 0) {
			banners.eq(active).fadeOut(function() {
				jQuery(this).removeClass('trx_banners_item_active');
				banners.eq(next).fadeIn().addClass('trx_banners_item_active');
			});
		} else {
			banners.eq(next).fadeIn().addClass('trx_banners_item_active');
		}
		if (!isNaN(banners.eq(next).data('duration'))) {
			duration = Math.max(1000, Math.min(60000, Number(banners.eq(next).data('duration'))));
		}
		setTimeout(trx_addons_banners_rotator, duration);
	}

});
