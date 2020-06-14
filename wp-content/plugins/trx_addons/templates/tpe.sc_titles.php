<?php
/**
 * The template to display shortcode's title, subtitle and description
 * on the Elementor's preview page
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.41
 */

extract(get_query_var('trx_addons_args_sc_show_titles'));
if (empty($size)) $size = 'large';
?><#
var title_text = settings.title;
var title_align = !trx_addons_is_off(settings.title_align) ? ' sc_align_'+settings.title_align : '';
var title_style = !trx_addons_is_off(settings.title_style) ? ' sc_item_title_style_'+settings.title_style : '';
var title_class = "<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_title_class', 'sc_item_title '.$sc.'_title', $sc)); ?>";

var subtitle_align = !trx_addons_is_off(settings.subtitle_align) ? ' sc_align_'+settings.subtitle_align : title_align;
var subtitle_position = !trx_addons_is_off(settings.subtitle_position) ? settings.subtitle_position : 'above';
var subtitle_class = "<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_subtitle_class', 'sc_item_subtitle '.$sc.'_subtitle', $sc)); ?>";

var description_class = "<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_description_class', 'sc_item_descr '.$sc.'_descr', $sc)); ?>";

var title_html  = '';
var subtitle_html = '';

if (settings.subtitle) {
	subtitle_html += '<span class="'
						+ subtitle_class
						+ subtitle_align
						+ ' sc_item_subtitle_' + subtitle_position
						+ title_style
					+ '">'
						+ trx_addons_prepare_macros(settings.subtitle)
					+ '</span>';
}
if (settings.subtitle_position == 'above' && (settings.title == '' || trx_addons_is_off(settings.subtitle_align) || settings.subtitle_align == settings.title_align) ) {
	title_html += subtitle_html;
}
if (settings.title) {
	if (settings.typed > 0 && settings.typed_strings != '') {
		var typed_strings = settings.typed_strings.split("\n"),
			typed_strings_json = JSON.stringify(typed_strings).replace(/"/g, '&quot;');
		title_text = title_text.replace(
							typed_strings[0],
							'<span class="sc_typed_entry"'
								+ ' data-strings="' + typed_strings_json + '"'
								+ ' data-loop="' + (settings.typed_loop ? 1 : 0 ) + '"'
								+ ' data-cursor="' + ( settings.typed_cursor ? 1 : 0 ) + '"'
								+ ' data-cursor-char="|"'
								+ ' data-speed="' + settings.typed_speed.size + '"'
								+ ' data-delay="' + settings.typed_delay.size + '"'
								+ ( settings.typed_color != '' ? ' style="color:' + settings.typed_color + '"' : '')
								+ '>' + typed_strings[0] + '</span>'
						);
	}
	var title_tag = !trx_addons_is_off(settings.title_tag)
					? settings.title_tag
					: "<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_title_tag', 'large' == $size ? 'h2' : ('tiny' == $size ? 'h4' : 'h3'))); ?>";
	var title_tag_class = (!trx_addons_is_off(settings.title_tag)
								? ' sc_item_title_tag'
								: '')
						+ (settings.typed > 0
								? ' sc_typed'
								: '');
	var title_tag_style = settings.title_color != ''
					? (settings.title_style != 'gradient'
						? 'color:' + settings.title_color
						: ''
						)
					: '';
	title_html += '<' + title_tag + ' class="'
						+ title_class
						+ title_align
						+ title_style
						+ '"'
						+ (title_tag_style != ''
							? ' style="' + title_tag_style + '"'
							: '')
					+ '>'
					+ ( !trx_addons_is_off(settings.subtitle_align) && subtitle_align != title_align
							? '<span class="sc_item_title_inner">'
								+ ( subtitle_position == 'above'
									? subtitle_html
									: ''
									)
							: ''
							)
					+ (settings.title_style == 'gradient'
						? '<span class="trx_addons_text_gradient"'
							+ (settings.title_color != ''
								? ' style="'
									+ 'color:' + settings.title_color + ';'
									+ 'background:linear-gradient(' 
										+ Math.max(0, Math.min(360, settings.gradient_direction.size)) + 'deg,'
										+ (settings.title_color2 ? settings.title_color2 : 'transparent') + ','
										+ settings.title_color
										+ ');'
									+ '"'
								: '')
							+ '>'
								+ trx_addons_prepare_macros(title_text)
							+ '</span>'
						: '<span class="sc_item_title_text">'
								+ trx_addons_prepare_macros(title_text)
							+ '</span>'
						)
					+ ( !trx_addons_is_off(settings.subtitle_align) && subtitle_align != title_align
							? (subtitle_position != 'above'
									? subtitle_html
									: ''
									)
								+ '</span>'
							: ''
							)
					+ '</' + title_tag + '>';
}
if (settings.subtitle_position != 'above' && (trx_addons_is_off(settings.subtitle_align) || settings.subtitle_align == settings.title_align) ) {
	title_html += subtitle_html;
}
if (settings.description) {
	title_html += '<div class="' + description_class + title_align + '">'
					+ trx_addons_prepare_macros(settings.description)
					+ '</div>';
}
print(title_html);
#>