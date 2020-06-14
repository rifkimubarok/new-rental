<?php
// Add plugin-specific vars to the custom CSS
if ( ! function_exists( 'piqes_gutenberg_add_theme_vars' ) ) {
	add_filter( 'piqes_filter_add_theme_vars', 'piqes_gutenberg_add_theme_vars', 10, 2 );
	function piqes_gutenberg_add_theme_vars( $rez, $vars ) {
		return $rez;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'piqes_gutenberg_get_css' ) ) {
	add_filter( 'piqes_filter_get_css', 'piqes_gutenberg_get_css', 10, 2 );
	function piqes_gutenberg_get_css( $css, $args ) {

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			$vars         = $args['vars'];
			$css['vars'] .= <<<CSS
/* Editor area width for all post types */
.editor-block-list__block,
.editor-post-title__block,
.editor-default-block-appender {
	max-width: {$vars['content']} !important;
}
/* Editor area width for pages without sidebar */
body.sidebar_position_hide.expand_content .editor-block-list__block,
body.sidebar_position_hide.expand_content .editor-post-title__block,
body.sidebar_position_hide.expand_content .editor-default-block-appender {
	max-width: {$vars['page']} !important;
}
body.single-cpt_layouts .trx-addons-layout--single-preview {
	max-width: {$vars['page']} !important;
}
CSS;
		}

		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts                   = $args['fonts'];
			$fonts['p_font-family!'] = str_replace(';', ' !important;', $fonts['p_font-family']);
			$fonts['p_font-size!'] = str_replace(';', ' !important;', $fonts['p_font-size']);
			$css['fonts']           .= <<<CSS
body.edit-post-visual-editor {
	{$fonts['p_font-family!']}
	{$fonts['p_font-size']}
	{$fonts['p_font-weight']}
	{$fonts['p_font-style']}
	{$fonts['p_line-height']}
	{$fonts['p_text-decoration']}
	{$fonts['p_text-transform']}
	{$fonts['p_letter-spacing']}
}
.editor-post-title__block .editor-post-title__input {
	{$fonts['h1_font-family']}
	{$fonts['h1_font-size']}
	{$fonts['h1_font-weight']}
	{$fonts['h1_font-style']}
}
CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS
.editor-post-sidebar-holder {
	background-color: {$colors['alter_bg_color']};	
}
.editor-post-sidebar-holder:before {
	color: {$colors['alter_text']};
}
.scheme_self.editor-block-list__layout {
	color: {$colors['text']};
	background-color: {$colors['bg_color']};
}
.scheme_self.editor-block-list__layout p {
	color: {$colors['text']};
}

/* Theme-specific colors */
.has-bg-color-color {		color: {$colors['bg_color']}; }
.has-bd-color-color {		color: {$colors['bd_color']}; }
.has-text-color-color {		color: {$colors['text']}; }
.has-text-light-color {		color: {$colors['text_light']}; }
.has-text-dark-color {		color: {$colors['text_dark']}; }
.has-text-link-color {		color: {$colors['text_link']}; }
.has-text-hover-color {		color: {$colors['text_hover']}; }
.has-text-link-2-color {	color: {$colors['text_link2']}; }
.has-text-hover-2-color {	color: {$colors['text_hover2']}; }
.has-text-link-3-color {	color: {$colors['text_link3']}; }
.has-text-hover-3-color {	color: {$colors['text_hover3']}; }

.has-bg-color-background-color {		background-color: {$colors['bg_color']};}
.has-bd-color-background-color {		background-color: {$colors['bd_color']}; }
.has-text-color-background-color {		background-color: {$colors['text']}; }
.has-text-light-background-color {		background-color: {$colors['text_light']}; }
.has-text-dark-background-color {		background-color: {$colors['text_dark']}; }
.has-text-link-background-color {		background-color: {$colors['text_link']}; }
.has-text-hover-background-color {		background-color: {$colors['text_hover']}; }
.has-text-link-2-background-color {		background-color: {$colors['text_link2']}; }
.has-text-hover-2-background-color {	background-color: {$colors['text_hover2']}; }
.has-text-link-3-background-color {		background-color: {$colors['text_link3']}; }
.has-text-hover-3-background-color {	background-color: {$colors['text_hover3']}; }

CSS;
		}

		return $css;
	}
}

