/* global jQuery:false */
/* global PIQES_STORAGE:false */

jQuery( window ).load(function() {
	"use strict";
	piqes_gutenberg_first_init();
	// Create the observer to reinit visual editor after switch from code editor to visual editor
	var piqes_observers = {};
	if (typeof window.MutationObserver !== 'undefined') {
		piqes_create_observer('check_visual_editor', jQuery('.block-editor').eq(0), function(mutationsList) {
			var gutenberg_editor = jQuery('.edit-post-visual-editor:not(.piqes_inited)').eq(0);
			if (gutenberg_editor.length > 0) piqes_gutenberg_first_init();
		});
	}

	function piqes_gutenberg_first_init() {
		var gutenberg_editor = jQuery( '.edit-post-visual-editor:not(.piqes_inited)' ).eq( 0 );
		if ( 0 == gutenberg_editor.length ) {
			return;
		}
		jQuery( '.editor-block-list__layout' ).addClass( 'scheme_' + PIQES_STORAGE['color_scheme'] );
		gutenberg_editor.addClass( 'sidebar_position_' + PIQES_STORAGE['sidebar_position'] );
		if ( PIQES_STORAGE['expand_content'] > 0 ) {
			gutenberg_editor.addClass( 'expand_content' );
		}
		if ( PIQES_STORAGE['sidebar_position'] == 'left' ) {
			gutenberg_editor.prepend( '<div class="editor-post-sidebar-holder"></div>' );
		} else if ( PIQES_STORAGE['sidebar_position'] == 'right' ) {
			gutenberg_editor.append( '<div class="editor-post-sidebar-holder"></div>' );
		}

		gutenberg_editor.addClass('piqes_inited');
	}

	// Create mutations observer
	function piqes_create_observer(id, obj, callback) {
		if (typeof window.MutationObserver !== 'undefined' && obj.length > 0) {
			if (typeof piqes_observers[id] == 'undefined') {
				piqes_observers[id] = new MutationObserver(callback);
				piqes_observers[id].observe(obj.get(0), { attributes: false, childList: true, subtree: true });
			}
			return true;
		}
		return false;
	}
} );
