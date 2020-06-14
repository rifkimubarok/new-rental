<?php
// Add plugin-specific vars to the custom CSS
if ( ! function_exists( 'piqes_trx_addons_add_theme_vars' ) ) {
	add_filter( 'piqes_filter_add_theme_vars', 'piqes_trx_addons_add_theme_vars', 10, 2 );
	function piqes_trx_addons_add_theme_vars( $rez, $vars ) {
		if ( substr( $vars['page'], 0, 2 ) != '{{' ) {
			$rez['page_1_1'] = $vars['page'] . 'px';
			$rez['page_1_2'] = ( $vars['page'] / 2 ) . 'px';
			$rez['page_1_3'] = ( $vars['page'] / 3 ) . 'px';
			$rez['page_2_3'] = ( $vars['page'] / 3 * 2 ) . 'px';
			$rez['page_1_4'] = ( $vars['page'] / 4 ) . 'px';
			$rez['page_3_4'] = ( $vars['page'] / 4 * 3 ) . 'px';
		} else {
			$rez['page_1_1'] = '{{ data.page_1_1 }}';
			$rez['page_1_2'] = '{{ data.page_1_2 }}';
			$rez['page_1_3'] = '{{ data.page_1_3 }}';
			$rez['page_2_3'] = '{{ data.page_2_3 }}';
			$rez['page_1_4'] = '{{ data.page_1_4 }}';
			$rez['page_3_4'] = '{{ data.page_3_4 }}';
		}
		return $rez;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'piqes_trx_addons_get_css' ) ) {
	add_filter( 'piqes_filter_get_css', 'piqes_trx_addons_get_css', 10, 2 );
	function piqes_trx_addons_get_css( $css, $args ) {

		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS

.sc_skills_pie.sc_skills_compact_off .sc_skills_item_title,
.sc_dishes_compact .sc_services_item_title,
.sc_services_iconed .sc_services_item_title {
	{$fonts['p_font-family']}
}
.toc_menu_item .toc_menu_description,
.sc_recent_news .post_item .post_footer .post_meta .post_meta_item,
.sc_item_subtitle,
.sc_icons_item_title,
.sc_price_item_title, .sc_price_item_price,
.sc_courses_default .sc_courses_item_price,
.sc_courses_default .trx_addons_hover_content .trx_addons_hover_links a,
.sc_events_classic .sc_events_item_price,
.sc_events_classic .trx_addons_hover_content .trx_addons_hover_links a,
.sc_promo_modern .sc_promo_link2 span+span,
.sc_skills_counter .sc_skills_total,
.sc_skills_pie.sc_skills_compact_off .sc_skills_total,
.slider_container .slide_info.slide_info_large .slide_title,
.slider_style_modern .slider_controls_label span + span,
.slider_pagination_wrap,
.sc_slider_controller_info {
	{$fonts['h5_font-family']}
}
.sc_recent_news .post_item .post_meta,
.sc_action_item_description,
.sc_price_item_description,
.sc_price_item_details,
.sc_courses_default .sc_courses_item_date,
.courses_single .courses_page_meta,
.sc_events_classic .sc_events_item_date,
.sc_promo_modern .sc_promo_link2 span,
.sc_skills_counter .sc_skills_item_title,
.slider_style_modern .slider_controls_label span,
.slider_titles_outside_wrap .slide_cats,
.slider_titles_outside_wrap .slide_subtitle,
.sc_team .sc_team_item_subtitle,
.sc_dishes .sc_dishes_item_subtitle,
.sc_services .sc_services_item_subtitle,
.team_member_page .team_member_brief_info_text,
.sc_testimonials_item_author_title {
	{$fonts['info_font-family']}
}
.sc_button,
.sc_button_simple,
.sc_form button {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
.sc_promo_modern .sc_promo_link2 {
	{$fonts['button_font-family']}
}
.trx_addons_dropcap  {
	{$fonts['h2_font-family']}
}
.sc_price .sc_price_item .sc_price_item_info .sc_price_item_price .sc_price_item_price_after {
	{$fonts['p_font-family']}
}
CSS;
		}

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			$vars         = $args['vars'];
			$css['vars'] .= <<<CSS

.trx_addons_hover_content .trx_addons_hover_link,
.trx_addons_hover_content .trx_addons_hover_links a,
.properties_search_form .properties_search_basic,
.cars_search_form .cars_search_basic,
.sc_promo_modern .sc_promo_link2,
.sc_slider_controls .slider_controls_wrap > a,
.sc_slider_controls.slider_pagination_style_progress .sc_slider_controls_wrap,
.sc_slider_controls .slider_progress_bar,
.slider_container.slider_controls_side .slider_controls_wrap > a,
.slider_outer_controls_side .slider_controls_wrap > a,
.slider_outer_controls_outside .slider_controls_wrap > a,
.slider_outer_controls_top .slider_controls_wrap > a,
.slider_outer_controls_bottom .slider_controls_wrap > a {
	-webkit-border-radius: {$vars['rad4']};
	    -ms-border-radius: {$vars['rad4']};
			border-radius: {$vars['rad4']};
}
.sc_button,
.sc_form button,
.sc_matches_item_pair .sc_matches_item_player .post_featured > img {
	-webkit-border-radius: {$vars['rad']};
	    -ms-border-radius: {$vars['rad']};
			border-radius: {$vars['rad']};
}
.trx_addons_scroll_to_top,
.socials_wrap .social_item .social_icon,
.sc_matches_other .sc_matches_item_logo1 img,
.sc_matches_other .sc_matches_item_logo2 img,
.sc_points_table .sc_points_table_logo img {
	-webkit-border-radius: {$vars['rad50']};
	    -ms-border-radius: {$vars['rad50']};
			border-radius: {$vars['rad50']};
}

.sc_content_width_1_1, .sc_inner_width_1_1 > .elementor-column-wrap {	width: {$vars['page']}; }
.sc_content_width_1_2, .sc_inner_width_1_2 > .elementor-column-wrap {	width: {$vars['page_1_2']}; }
.sc_content_width_1_3, .sc_inner_width_1_3 > .elementor-column-wrap {	width: {$vars['page_1_3']}; }
.sc_content_width_2_3, .sc_inner_width_2_3 > .elementor-column-wrap {	width: {$vars['page_2_3']}; }
.sc_content_width_1_4, .sc_inner_width_1_4 > .elementor-column-wrap {	width: {$vars['page_1_4']}; }
.sc_content_width_3_4, .sc_inner_width_3_4 > .elementor-column-wrap {	width: {$vars['page_3_4']}; }

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS


/* User styles
------------------------------------------ */
.trx_addons_accent,
.trx_addons_accent > a,
.trx_addons_accent > * {
	color: {$colors['text_link']};
}
.trx_addons_accent > a:hover {
	color: {$colors['text_dark']};
}
.sidebar .trx_addons_accent,
.scheme_self.sidebar .trx_addons_accent,
.sidebar .trx_addons_accent > a,
.scheme_self.sidebar .trx_addons_accent > a,
.sidebar .trx_addons_accent > *,
.scheme_self.sidebar .trx_addons_accent > *,
.footer_wrap .trx_addons_accent,
.scheme_self.footer_wrap .trx_addons_accent,
.footer_wrap .trx_addons_accent > a,
.scheme_self.footer_wrap .trx_addons_accent > a,
.footer_wrap .trx_addons_accent > *,
.scheme_self.footer_wrap .trx_addons_accent > * {
	color: {$colors['alter_link']};
}
.sidebar .trx_addons_accent > a:hover,
.scheme_self.sidebar .trx_addons_accent > a:hover,
.footer_wrap .trx_addons_accent > a:hover,
.scheme_self.footer_wrap .trx_addons_accent > a:hover {
	color: {$colors['alter_dark']};
}

.trx_addons_hover,
.trx_addons_hover > * {
	color: {$colors['text_hover']};
}
.trx_addons_accent_bg {
	background-color: {$colors['text_link']};
	color: {$colors['inverse_text']};
}
.trx_addons_inverse {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
.trx_addons_dark,
.trx_addons_dark > a {
	color: {$colors['text_dark']};
}
.trx_addons_dark > a:hover {
	color: {$colors['text_link']};
}

.trx_addons_inverse,
.trx_addons_inverse > a {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
.trx_addons_inverse > a:hover {
	color: {$colors['inverse_hover']};
}

.trx_addons_dropcap_style_1 {
	color: {$colors['text_dark']};
	background-color: transparent;
}
.trx_addons_dropcap_style_2 {
	color: {$colors['inverse_text']};
	background-color: {$colors['text_link3']};
}

ul[class*="trx_addons_list"] > li:before {
	color: {$colors['text_link']};
}

ul[class*="trx_addons_list"][class*="_circled"] > li:before {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.trx_addons_list_parameters > li + li {
	border-color: {$colors['bd_color']};
}

.trx_addons_tooltip {
	color: {$colors['text']};
	border-color: {$colors['text']};
}
.trx_addons_tooltip:before {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
.trx_addons_tooltip:after {
	border-top-color: {$colors['text_dark']};
}

blockquote.trx_addons_blockquote_style_1:before,
blockquote.trx_addons_blockquote_style_1 {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
blockquote.trx_addons_blockquote_style_1 b {
	color: {$colors['bg_color']};
}
blockquote.trx_addons_blockquote_style_1 a,
blockquote.trx_addons_blockquote_style_1 cite {
	color: {$colors['text_link']};
}
blockquote.trx_addons_blockquote_style_1 a:hover {
	color: {$colors['bg_color']};
}
blockquote.trx_addons_blockquote_style_2 {
	color: {$colors['inverse_text']};
	background-color: {$colors['text_link']};
}
blockquote.trx_addons_blockquote_style_2:before,
blockquote.trx_addons_blockquote_style_2 a,
blockquote.trx_addons_blockquote_style_2 cite {
	color: {$colors['inverse_link']};
}
blockquote.trx_addons_blockquote_style_2 a:hover {
	color: {$colors['inverse_hover']};
}

.trx_addons_hover_mask {
	background-color: {$colors['extra_bg_color_013']};
}
.trx_addons_hover_title {
	color: {$colors['extra_dark']};
}
.trx_addons_hover_text {
	color: {$colors['extra_text']};
}
.trx_addons_hover_icon,
.trx_addons_hover_links a {
	color: {$colors['inverse_link']};
	background-color: {$colors['extra_link']};
}
.trx_addons_hover_icon:hover,
.trx_addons_hover_links a:hover {
	color: {$colors['inverse_hover']} !important;
	background-color: {$colors['extra_hover']};
}

/* Typed title */
.sc_typed_entry {
	color: {$colors['text_link']};
}

/* Gradient */
body:not(.ua_ie) .trx_addons_text_gradient {
/*
body:not(.ua_ie) .trx_addons_text_gradient * {
*/
	background: {$colors['text_link']};
	background: linear-gradient(0deg, {$colors['text_link']}, {$colors['text_hover']});	
}


/* Tabs */
.widget .trx_addons_tabs .trx_addons_tabs_titles li a {
	color: {$colors['text']};
	background-color: {$colors['bd_color']};
}
.widget .trx_addons_tabs .trx_addons_tabs_titles li.ui-state-active a,
.widget .trx_addons_tabs .trx_addons_tabs_titles li a:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.scheme_self.sidebar .widget .trx_addons_tabs .trx_addons_tabs_titles li a {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bd_color']};
}
.scheme_self.sidebar .widget .trx_addons_tabs .trx_addons_tabs_titles li.ui-state-active a,
.scheme_self.sidebar .widget .trx_addons_tabs .trx_addons_tabs_titles li a:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['alter_link']};
}


/* Posts emotions */
.trx_addons_emotions_item {
	background-color: {$colors['bg_color']};
	border-color: {$colors['bd_color']};
	color: {$colors['text_light']};
}
.trx_addons_emotions_item:hover {
	color: {$colors['alter_dark']};
	border-color: {$colors['alter_bd_hover']};
	background-color: {$colors['alter_bg_hover']};
}
.trx_addons_emotions_active {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color']};
}
.trx_addons_emotions_item_number {
	color: {$colors['text']};
}


/* Posts slider */
.slider_container .slide_info.slide_info_large {
	background-color: {$colors['bg_color_07']};
}
.slider_container .slide_info.slide_info_large:hover {
	background-color: {$colors['bg_color']};
}
.slider_container .slide_info.slide_info_large .slide_cats a {
	color: {$colors['text_link']};
}
.slider_container .slide_info.slide_info_large .slide_title a {
	color: {$colors['text_dark']};
}
.slider_container .slide_info.slide_info_large .slide_date {
	color: {$colors['text']};
}
.slider_container .slide_info.slide_info_large:hover .slide_date {
	color: {$colors['text_light']};
}
.slider_container .slide_info.slide_info_large .slide_cats a:hover,
.slider_container .slide_info.slide_info_large .slide_title a:hover {
	color: {$colors['text_hover']};
}
.slider_container.slider_multi .slide_cats a:hover,
.slider_container.slider_multi .slide_title a:hover,
.slider_container.slider_multi a:hover .slide_title {
	color: {$colors['text_hover']};
}

.sc_slider_controls .slider_controls_wrap > a,
.slider_outer_controls_side .slider_controls_wrap > a,
.slider_outer_controls_outside .slider_controls_wrap > a {
	color: {$colors['text_dark']};
	background-color: transparent;
	border-color: {$colors['text_dark']};
}
.slider_container.slider_controls_side .slider_controls_wrap > a {
	color: {$colors['inverse_link']};
	background-color: transparent;
	border-color: transparent;
}

.sc_slider_controls .slider_controls_wrap > a:hover,
.slider_outer_controls_side .slider_controls_wrap > a:hover,
.slider_outer_controls_outside .slider_controls_wrap > a:hover {
	color: {$colors['text_hover']};
	background-color:  transparent;
	border-color: transparent;
}

.slider_container.slider_controls_side .slider_controls_wrap > a:hover {
	color: {$colors['text_link']};
	background-color: transparent;
	border-color: transparent;
}
.sc_slider_controls.slider_pagination_style_progress .sc_slider_controls_wrap {
	background-color: {$colors['bd_color']};
}
.sc_slider_controls .slider_progress_bar {
	background-color: {$colors['text_link']};
}

.slider_container.slider_controls_top .slider_controls_wrap > a,
.slider_container.slider_controls_bottom .slider_controls_wrap > a,
.slider_outer_controls_top .slider_controls_wrap > a,
.slider_outer_controls_bottom .slider_controls_wrap > a {
	color: {$colors['extra_dark']};
	background-color: transparent !important;
	border-color: {$colors['extra_bd_color']};
}
.slider_container.slider_controls_top .slider_controls_wrap > a:hover,
.slider_container.slider_controls_bottom .slider_controls_wrap > a:hover,
.slider_outer_controls_top .slider_controls_wrap > a:hover,
.slider_outer_controls_bottom .slider_controls_wrap > a:hover {
	color: {$colors['extra_link']};
	border-color: transparent !important;
	background-color: {$colors['extra_bg_hover']};
}

.sc_slider_controls.slider_pagination_style_bullets .slider_pagination_bullet,
.slider_container .slider_pagination_wrap .swiper-pagination-bullet,
.slider_outer .slider_pagination_wrap .swiper-pagination-bullet,
.swiper-pagination-custom .swiper-pagination-button {
	border-color: {$colors['inverse_light']};
	background-color: transparent;
}
.widget_slider .slider_container .slider_pagination_wrap .swiper-pagination-bullet,
.post_format_gallery .slider_container .slider_pagination_wrap .swiper-pagination-bullet {
	border-color: {$colors['inverse_hover']};
}
.swiper-pagination-custom .swiper-pagination-button.swiper-pagination-button-active,
.sc_slider_controls.slider_pagination_style_bullets .slider_pagination_bullet.swiper-pagination-bullet-active,
.sc_slider_controls.slider_pagination_style_bullets .slider_pagination_bullet:hover,
.slider_container .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
.slider_outer .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
.slider_container .slider_pagination_wrap .swiper-pagination-bullet:hover,
.slider_outer .slider_pagination_wrap .swiper-pagination-bullet:hover {
	border-color: {$colors['extra_link']};
	background-color: {$colors['extra_link']};
}
.slider_container .swiper-pagination-progressbar .swiper-pagination-progressbar-fill,
.slider_outer .swiper-pagination-progressbar .swiper-pagination-progressbar-fill {
	background-color: {$colors['text_link']};
}
.slider_container .swiper-pagination,
.slider_outer .swiper-pagination,
.slider_outer > .swiper-pagination-fraction {
	color: {$colors['text_dark']};
}

.slider_titles_outside_wrap .slide_title a {
	color: {$colors['text_dark']};
}
.slider_titles_outside_wrap .slide_title a:hover {
	color: {$colors['text_link']};
}
.slider_titles_outside_wrap .slide_cats,
.slider_titles_outside_wrap .slide_subtitle {
	color: {$colors['text_link']};
}

.slider_style_modern .slider_controls_label {
	color: {$colors['bg_color']};
}
.slider_style_modern .slider_pagination_wrap {
	color: {$colors['text_light']};
}
.slider_style_modern .swiper-pagination-current {
	color: {$colors['text_dark']};
}

.sc_slider_controller .slider-slide.swiper-slide-active:after {
	background-color: {$colors['text_link']};
}
.sc_slider_controller_titles .slider-slide {
	background-color: {$colors['alter_bg_color']};
}
.sc_slider_controller_titles .slider-slide:after {
	background-color: {$colors['alter_bd_color']};
}
.sc_slider_controller_titles .slider-slide.swiper-slide-active {
	background-color: {$colors['bg_color']};
}
.sc_slider_controller_titles .sc_slider_controller_info_title {
	color: {$colors['alter_dark']};
}
.sc_slider_controller_titles .sc_slider_controller_info_number {
	color: {$colors['alter_light']};
}
.sc_slider_controller_titles .slider_controls_wrap > a {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.sc_slider_controller_titles .slider_controls_wrap > a:hover {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}


/* Widgets 
--------------------------------------------------- */

/* Categories list */
.widget_categories_list .categories_list_style_3 .categories_list_item {
	background-color: {$colors['alter_bg_color']};
}
.widget_categories_list .categories_list_style_1 .categories_list_item:hover .categories_list_title,
.widget_categories_list .categories_list_style_3 .categories_list_item:hover .categories_list_title {
	color: {$colors['text_link']};
}
.widget_categories_list .categories_list_style_2 .categories_list_title {
	color: {$colors['alter_dark']};
	background-color: {$colors['alter_bg_color_07']};
}
.widget_categories_list .categories_list_style_2 .categories_list_item:hover .categories_list_title {
	color: {$colors['alter_link']};
	background-color: {$colors['alter_bg_hover']};
}

/* Reviews stars */
.trx_addons_reviews_stars_default,
.trx_addons_reviews_stars_hover {
	color: {$colors['text_link']};	
}
.scheme_self.sidebar .trx_addons_reviews_stars_default,
.scheme_self.sidebar .trx_addons_reviews_stars_hover {
	color: {$colors['alter_link']};	
}
.trx_addons_reviews_bubble {
	background-color: {$colors['bg_color']};
}
.trx_addons_reviews_bubble:before {
	background-color: {$colors['bg_color']};
	border-right-color: {$colors['bd_color']};
	border-bottom-color: {$colors['bd_color']};
}

/* Reviews in the single post */
.trx_addons_reviews_block_short  .trx_addons_reviews_block_info {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_color']};
}
.trx_addons_reviews_block_short .trx_addons_reviews_block_title {
	color: {$colors['extra_dark']};
	background-color: {$colors['extra_bg_color']};	
}
.trx_addons_reviews_block_short .trx_addons_reviews_block_title:after {
	border-top-color: {$colors['extra_bg_color']};	
}
.trx_addons_reviews_block_short  .trx_addons_reviews_block_mark_value {
	border-color: {$colors['alter_bd_hover']};	
	background-color: {$colors['alter_bg_hover']};	
}

.trx_addons_reviews_block_detailed {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_color']};
}
.trx_addons_reviews_block_detailed .trx_addons_reviews_block_title {
	color: {$colors['extra_dark']};
	background-color: {$colors['extra_bg_color']};	
}
.trx_addons_reviews_block_detailed .trx_addons_reviews_block_pn {
	color: {$colors['alter_dark']};
	background-color: {$colors['alter_bg_hover']};	
}
.trx_addons_reviews_block_detailed .trx_addons_reviews_block_pn .trx_addons_reviews_block_list li:before {
	color: {$colors['alter_dark']};
}

.trx_addons_reviews_block_detailed .trx_addons_reviews_block_criterias {
	color: {$colors['alter_dark']};
}
.trx_addons_reviews_block_detailed .trx_addons_reviews_block_criterias[data-mark-max="10"] [class*="trx_addons_reviews_block_list_mark_line"],
.trx_addons_reviews_block_detailed .trx_addons_reviews_block_criterias[data-mark-max="100"] [class*="trx_addons_reviews_block_list_mark_line"] {
	background-color: {$colors['text_link']};	
}

/* Contacts */
.widget_contacts .contacts_info {
	color: {$colors['text']};
}
.widget_contacts .contacts_info span:before,
.widget_contacts .contacts_info > div > a:before,
.widget_contacts .contacts_info > a:before {
	color: {$colors['text_link']};
}
.widget_contacts .contacts_info span a,
.widget_contacts .contacts_info > div > a,
.widget_contacts .contacts_info > a {
	color: {$colors['text_dark']};
}
.widget_contacts .contacts_info span a:hover,
.widget_contacts .contacts_info > div > a:hover,
.widget_contacts .contacts_info > a:hover {
	color: {$colors['text_link']};
}
.scheme_self.sidebar .widget_contacts .contacts_info,
.scheme_self.footer_wrap .widget_contacts .contacts_info {
	color: {$colors['alter_text']};
}
.scheme_self.sidebar .widget_contacts .contacts_info span:before,
.scheme_self.sidebar .widget_contacts .contacts_info > div > a:before,
.scheme_self.sidebar .widget_contacts .contacts_info > a:before,
.scheme_self.footer_wrap .widget_contacts .contacts_info span:before,
.scheme_self.footer_wrap .widget_contacts .contacts_info > div > a:before,
.scheme_self.footer_wrap .widget_contacts .contacts_info > a:before {
	color: {$colors['alter_link']};
}
.scheme_self.sidebar .widget_contacts .contacts_info span a,
.scheme_self.sidebar .widget_contacts .contacts_info > div > a,
.scheme_self.sidebar .widget_contacts .contacts_info > a,
.scheme_self.footer_wrap .widget_contacts .contacts_info span a,
.scheme_self.footer_wrap .widget_contacts .contacts_info > div > a,
.scheme_self.footer_wrap .widget_contacts .contacts_info > a {
	color: {$colors['alter_dark']};
}
.scheme_self.sidebar .widget_contacts .contacts_info span a:hover,
.scheme_self.sidebar .widget_contacts .contacts_info > div > a:hover,
.scheme_self.sidebar .widget_contacts .contacts_info > a:hover,
.scheme_self.footer_wrap .widget_contacts .contacts_info span a:hover,
.scheme_self.footer_wrap .widget_contacts .contacts_info > div > a:hover,
.scheme_self.footer_wrap .widget_contacts .contacts_info > a:hover {
	color: {$colors['alter_link']};
}

/* Recent News */
/* Attention! This widget placed in the content area and should use main text colors */
.sc_recent_news_header {
	border-color: {$colors['text_dark']};
}
.sc_recent_news_header_category_item_more {
	color: {$colors['text_link']};
}
.sc_recent_news_header_more_categories {
	border-color: {$colors['extra_bd_color']};
	background-color:{$colors['extra_bg_color']};
}
.sc_recent_news_header_more_categories > a {
	color:{$colors['extra_link']};
}
.sc_recent_news_header_more_categories > a:hover {
	color:{$colors['extra_hover']};
	background-color:{$colors['extra_bg_hover']};
}
/*
.sc_recent_news .post_meta_item,
.sc_recent_news .post_meta .post_meta_edit a {
	color:{$colors['inverse_link']};
	background-color:{$colors['text_link']};
}
.sc_recent_news .post_meta_item:hover,
.sc_recent_news .post_meta .post_meta_edit a:hover {
	color:{$colors['bg_color']};
	background-color:{$colors['text_dark']};
}
.sidebar_inner .sc_recent_news .post_meta_item:hover,
.sidebar_inner .sc_recent_news .post_meta .post_meta_edit a:hover {
	color:{$colors['alter_dark']};
	background-color:{$colors['alter_bg_color']};
}
*/
.sc_recent_news_style_news-magazine .post_accented_border {
	border-color: {$colors['bd_color']};
}
.sc_recent_news_style_news-excerpt .post_item {
	border-color: {$colors['bd_color']};
}

/* Twitter */
.widget_twitter .widget_content .sc_twitter_item,
.widget_twitter .widget_content li {
	color: {$colors['text']};
}
.widget_twitter .widget_content .sc_twitter_item .sc_twitter_item_icon {
	color: {$colors['text_link']} !important;
}
.widget_twitter .swiper-pagination-bullet {
	background-color: {$colors['text_light']};
}
.widget_twitter .swiper-pagination-bullet-active {
	background-color: {$colors['text_link']};
}

.widget_twitter .widget_content .sc_twitter_list li {
	color: {$colors['text']};
}
.widget_twitter .widget_content .sc_twitter_list li:before {
	color: {$colors['text_link']} !important;
}
.scheme_self.sidebar .widget_twitter .widget_content .sc_twitter_list li {
	color: {$colors['alter_text']};
}
.scheme_self.sidebar .widget_twitter .widget_content .sc_twitter_list li:before {
	color: {$colors['alter_link']} !important;
}


/* Shortcodes
--------------------------------------------------- */

.sc_item_subtitle {
	color:{$colors['text']};
}
.color_style_link2 .sc_item_subtitle {
	color:{$colors['text']};
}
.color_style_link3 .sc_item_subtitle {
	color:{$colors['text_link3']};
}
.sc_item_subtitle.sc_item_title_style_shadow {
	color:{$colors['text_light']};
}

.theme_scroll_down:hover {
	color: {$colors['text_link']};
}

.sc_item_filters_align_left,
.sc_item_filters_align_right,
.sc_item_filters .sc_item_filters_header {
	border-color: {$colors['text_dark']};
}

.sc_item_featured [class*="post_info_"] {
	color:{$colors['extra_text']};	
	background-color:{$colors['extra_bg_color_07']};	
}
.sc_item_featured:hover [class*="post_info_"] {
	background-color:{$colors['extra_bg_hover']};	
}
.sc_blogger .sc_item_featured .post_meta .post_meta_views,
.sc_blogger .sc_item_featured .post_meta .post_date,
.sc_blogger .post_meta .socials_share .socials_caption,
.sc_item_featured [class*="post_info_"] a {
	color:{$colors['extra_link']};
}
.sc_blogger .post_meta .socials_share .socials_caption:hover,
.sc_item_featured [class*="post_info_"] a:hover {
	color:{$colors['extra_hover']};
}

/* Action */
.sc_action_item .sc_action_item_subtitle {						color:{$colors['inverse_link']}; }
.sc_action_item.color_style_link2 .sc_action_item_subtitle {	color:{$colors['text_link2']}; }
.sc_action_item.color_style_link3 .sc_action_item_subtitle {	color:{$colors['text_link3']}; }
.sc_action_item.color_style_dark .sc_action_item_subtitle {		color:{$colors['text_dark']}; }

.sc_action_item_event .sc_action_item_date,
.sc_action_item_event .sc_action_item_info {
	color:{$colors['text_dark']};
	border-color:{$colors['text']};
}
.sc_action_item_event .sc_action_item_description {
	color:{$colors['text']};
}
.sc_action_item_event.with_image .sc_action_item_inner {
	background-color:{$colors['bg_color']};
}


/* Blogger */
.sc_blogger.slider_container .swiper-pagination-bullet {
	border-color: {$colors['text_light']};
}
.sc_blogger_item_on_plate .sc_blogger_item_body {
	color: {$colors['alter_text']};
}
.sc_blogger_item_default.sc_blogger_item_on_plate .sc_blogger_item_body,
.sc_blogger_item_list.sc_blogger_item_on_plate .sc_blogger_item_body,
.sc_blogger_item_wide.sc_blogger_item_on_plate {
	background-color: {$colors['alter_bg_color']};
}
.sc_blogger_item_on_plate .sc_blogger_item_content .post_meta,
.sc_blogger_item_on_plate .sc_blogger_item_content .post_meta a {
	color: {$colors['alter_light']};
}
.sc_blogger_item_on_plate .sc_blogger_item_content .post_meta a:hover {
	color: {$colors['alter_dark']};
}
.sc_blogger_item_on_plate .sc_blogger_item_content a {
	color: {$colors['alter_link']};
}
.sc_blogger_item_on_plate .sc_blogger_item_content a:hover {
	color: {$colors['alter_hover']};
}
.sc_blogger_item_on_plate .sc_blogger_item_content a.sc_button_simple:hover {
	color: {$colors['alter_hover']} !important;
}
.sc_blogger_item_on_plate .sc_blogger_item_content .sc_blogger_item_title a {
	color: {$colors['alter_dark']};
}
.sc_blogger_item_on_plate .sc_blogger_item_content .sc_blogger_item_title a:hover {
	color: {$colors['alter_link']};
}
.sc_blogger_item_default.sc_blogger_item_on_plate .sc_blogger_item_excerpt:after {
	background-image: -webkit-gradient(linear,left top,left bottom,from({$colors['alter_bg_color_00']}),to({$colors['alter_bg_color']}));
	background-image: -webkit-linear-gradient(top,{$colors['alter_bg_color_00']},{$colors['alter_bg_color']});
	background-image: -o-linear-gradient(top,{$colors['alter_bg_color_00']},{$colors['alter_bg_color']});
	background-image: linear-gradient(180deg,{$colors['alter_bg_color_00']},{$colors['alter_bg_color']});	
}
.sc_blogger_content .sc_blogger_item {
	border-color: {$colors['bd_color']};
}
.sc_blogger_item_list.sc_blogger_item_with_numbers:not(.sc_blogger_item_with_image) .sc_blogger_item_title:before,
.sc_blogger_item_list.sc_blogger_item_with_numbers.sc_blogger_item_with_image .sc_blogger_item_featured:after {
	color: {$colors['extra_dark']};
	background-color: {$colors['extra_bg_color']};
}

/* Cars */
.sc_cars_item,
.sc_cars_item_params {
	border-color: {$colors['bd_color']};
}
.sc_cars_item_param {
	color: {$colors['text_light']};
}
.sc_cars_item_param .sc_cars_item_param_text,
.sc_cars_item_footer {
	color: {$colors['text']};
}
.sc_cars_columns_1 .sc_cars_item,
.sc_cars_item .sc_cars_item_thumb {
	background-color: {$colors['alter_bg_color']};
}
.sc_cars_item_status > a,
.sc_cars_item_type > a,
.sc_cars_item_compare {
	color: {$colors['text_light']};
}
.sc_cars_item_compare.in_compare_list {
	color: {$colors['text_link']};
}
.sc_cars_item_status > a:hover,
.sc_cars_item_type > a:hover,
.sc_cars_item_compare:hover,
.sc_cars_item_compare.in_compare_list:hover {
	color: {$colors['text_dark']};
}
.sc_cars_item_options .sc_cars_item_row_address,
.sc_cars_item_options .sc_cars_item_row_meta {
	color: {$colors['text_light']};
}
.cars_page_title .cars_page_status > a {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.cars_page_title .cars_page_status > a:hover {
	color: {$colors['inverse_hover']};
	background-color: {$colors['text_link_blend']};
}
.cars_page_title_address {
	color: {$colors['text_light']};
}
.cars_price {
	color: {$colors['text_light']};
}
.cars_page_attachments_list > a:before,
.cars_page_features_list > a:before {
	color: {$colors['text_link']};
}
.cars_page_tabs.trx_addons_tabs .trx_addons_tabs_titles {
	border-color: {$colors['alter_bd_color']};
}
.cars_page_tabs.trx_addons_tabs .trx_addons_tabs_titles li > a {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['alter_bg_color']};
	border-bottom-color: {$colors['alter_bd_color']};
}
.cars_page_tabs.trx_addons_tabs .trx_addons_tabs_titles li.ui-state-active > a {
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['bg_color']};
	border-bottom-color: {$colors['bg_color']};
}
.cars_page_tabs.trx_addons_tabs .trx_addons_tabs_titles li:not(.ui-state-active) > a:hover {
	background-color: {$colors['alter_bg_hover']};
	border-color: {$colors['alter_bg_hover']} {$colors['alter_bg_hover']} {$colors['alter_bd_color']};
}

.cars_page_section_title {
	border-color: {$colors['bd_color']};
}

.cars_page_agent_info_position {
	color: {$colors['text_light']};
}
.cars_page_agent_info_phones > span,
.cars_page_agent_info_phones > a {
	color: {$colors['text']};
}
.cars_page_agent_info_phones > a:hover {
	color: {$colors['text_link']};
}
.cars_page_agent_info_address:before,
.cars_page_agent_info_phones > :before {
	color: {$colors['text_dark']};
}
.cars_page_agent_info_profiles.socials_wrap .social_item .social_icon {
	color: {$colors['text']};
}

.cars_search_form .cars_search_basic .cars_search_show_advanced {
	color: {$colors['input_text']};
	background-color: {$colors['input_bg_color']};
}
.cars_search_form .cars_search_basic .cars_search_show_advanced:hover {
	color: {$colors['input_dark']};
}

.sc_cars_compare_data .cars_feature_present {
	color: {$colors['text_link']};
}


/* Content area */
.sc_content_number {
	color: {$colors['alter_bg_hover']};
}


/* Countdown */
.sc_countdown_default .sc_countdown_digits span {
	color: {$colors['inverse_link']};
	border-color: {$colors['text_hover']};
	background-color: {$colors['text_link']};
}
.sc_countdown_circle .sc_countdown_digits {
	color: {$colors['alter_link']};
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color']};
}

/* Courses */
.sc_courses.slider_container .swiper-pagination-bullet {
	border-color: {$colors['text_light']};
}

.sc_courses_default .sc_courses_item {
	background-color: {$colors['alter_bg_color']};
}
.sc_courses_default .sc_courses_item_categories {
	background-color: {$colors['alter_dark']};
}
.sc_courses_default .sc_courses_item_categories a {
	color: {$colors['bg_color']};
}
.sc_courses_default .sc_courses_item_categories a:hover {
	color: {$colors['alter_link']};
}
.sc_courses_default .sc_courses_item_meta {
	color: {$colors['alter_light']};
}
.sc_courses_default .sc_courses_item_date {
	color: {$colors['alter_dark']};
}
.sc_courses_default .sc_courses_item_price {
	color: {$colors['alter_link']};
}
.sc_courses_default .sc_courses_item_period {
	color: {$colors['alter_light']};
}
.courses_single .courses_page_meta {
	color: {$colors['text_light']};
}
.courses_single .courses_page_meta_item_date {
	color: {$colors['text_dark']};
}
.courses_single .courses_page_period {
	color: {$colors['text_light']};
}


/* Dishes */
.sc_dishes_default .sc_dishes_item {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_color']};
}
.sc_dishes_default .sc_dishes_item_subtitle,
.sc_dishes_default .sc_dishes_item_subtitle a {
	color: {$colors['alter_link']};
}
.sc_dishes_default .sc_dishes_item_subtitle a:hover {
	color: {$colors['alter_hover']};
}
.sc_dishes_default.color_style_link2 .sc_dishes_item_subtitle,
.sc_dishes_default.color_style_link2 .sc_dishes_item_subtitle a {
	color: {$colors['alter_link2']};
}
.sc_dishes_default.color_style_link2 .sc_dishes_item_subtitle a:hover {
	color: {$colors['alter_hover2']};
}
.sc_dishes_default.color_style_link3 .sc_dishes_item_subtitle,
.sc_dishes_default.color_style_link3 .sc_dishes_item_subtitle a {
	color: {$colors['alter_link3']};
}
.sc_dishes_default.color_style_link3 .sc_dishes_item_subtitle a:hover {
	color: {$colors['alter_hover3']};
}
.sc_dishes_default.color_style_dark .sc_dishes_item_subtitle,
.sc_dishes_default.color_style_dark .sc_dishes_item_subtitle a {
	color: {$colors['alter_dark']};
}
.sc_dishes_default.color_style_dark .sc_dishes_item_subtitle a:hover {
	color: {$colors['alter_link']};
}
.sc_dishes_default .sc_dishes_item_featured_left,
.sc_dishes_default .sc_dishes_item_featured_right {
	color: {$colors['text']};
	background-color: transparent;
}
.sc_dishes_default .sc_dishes_item_featured_left .sc_dishes_item_subtitle,
.sc_dishes_default .sc_dishes_item_featured_left .sc_dishes_item_subtitle a,
.sc_dishes_default .sc_dishes_item_featured_right .sc_dishes_item_subtitle,
.sc_dishes_default .sc_dishes_item_featured_right .sc_dishes_item_subtitle a {
	color: {$colors['text_link']};
}
.sc_dishes_default .sc_dishes_item_featured_left .sc_dishes_item_subtitle a:hover,
.sc_dishes_default .sc_dishes_item_featured_right .sc_dishes_item_subtitle a:hover {
	color: {$colors['text_hover']};
}
.sc_dishes_default.color_style_link2 .sc_dishes_item_featured_left .sc_dishes_item_subtitle,
.sc_dishes_default.color_style_link2 .sc_dishes_item_featured_left .sc_dishes_item_subtitle a,
.sc_dishes_default.color_style_link2 .sc_dishes_item_featured_right .sc_dishes_item_subtitle,
.sc_dishes_default.color_style_link2 .sc_dishes_item_featured_right .sc_dishes_item_subtitle a {
	color: {$colors['text_link2']};
}
.sc_dishes_default.color_style_link2 .sc_dishes_item_featured_left .sc_dishes_item_subtitle a:hover,
.sc_dishes_default.color_style_link2 .sc_dishes_item_featured_right .sc_dishes_item_subtitle a:hover {
	color: {$colors['text_hover2']};
}
.sc_dishes_default.color_style_link3 .sc_dishes_item_featured_left .sc_dishes_item_subtitle,
.sc_dishes_default.color_style_link3 .sc_dishes_item_featured_left .sc_dishes_item_subtitle a,
.sc_dishes_default.color_style_link3 .sc_dishes_item_featured_right .sc_dishes_item_subtitle,
.sc_dishes_default.color_style_link3 .sc_dishes_item_featured_right .sc_dishes_item_subtitle a {
	color: {$colors['text_link3']};
}
.sc_dishes_default.color_style_link3 .sc_dishes_item_featured_left .sc_dishes_item_subtitle a:hover,
.sc_dishes_default.color_style_link3 .sc_dishes_item_featured_right .sc_dishes_item_subtitle a:hover {
	color: {$colors['text_hover3']};
}
.sc_dishes_default.color_style_dark .sc_dishes_item_featured_left .sc_dishes_item_subtitle,
.sc_dishes_default.color_style_dark .sc_dishes_item_featured_left .sc_dishes_item_subtitle a,
.sc_dishes_default.color_style_dark .sc_dishes_item_featured_right .sc_dishes_item_subtitle,
.sc_dishes_default.color_style_dark .sc_dishes_item_featured_right .sc_dishes_item_subtitle a {
	color: {$colors['text_dark']};
}
.sc_dishes_default.color_style_dark .sc_dishes_item_featured_left .sc_dishes_item_subtitle a:hover,
.sc_dishes_default.color_style_dark .sc_dishes_item_featured_right .sc_dishes_item_subtitle a:hover {
	color: {$colors['text_link']};
}

.sc_dishes_compact .sc_dishes_item {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_color']};
}
.sc_dishes_compact .sc_dishes_item_header {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
.sc_dishes_compact .sc_dishes_item_price,
.sc_dishes_compact .sc_dishes_item_subtitle a {
	color: {$colors['bg_color']};
}
.sc_dishes_compact .sc_dishes_item_price:hover,
.sc_dishes_compact .sc_dishes_item:hover .sc_dishes_item_price,
.sc_dishes_compact .sc_dishes_item_subtitle a:hover,
.sc_dishes_compact .sc_dishes_item:hover .sc_dishes_item_subtitle a {
	color: {$colors['text_link']};
}
.sc_dishes_compact.color_style_link2 .sc_dishes_item_price:hover,
.sc_dishes_compact.color_style_link2 .sc_dishes_item:hover .sc_dishes_item_price,
.sc_dishes_compact.color_style_link2 .sc_dishes_item_subtitle a:hover,
.sc_dishes_compact.color_style_link2 .sc_dishes_item:hover .sc_dishes_item_subtitle a {
	color: {$colors['text_link2']};
}
.sc_dishes_compact.color_style_link3 .sc_dishes_item_price:hover,
.sc_dishes_compact.color_style_link3 .sc_dishes_item:hover .sc_dishes_item_price,
.sc_dishes_compact.color_style_link3 .sc_dishes_item_subtitle a:hover,
.sc_dishes_compact.color_style_link3 .sc_dishes_item:hover .sc_dishes_item_subtitle a {
	color: {$colors['text_link3']};
}
.sc_dishes_compact .sc_dishes_item_title a {
	color: {$colors['text_link']};
}
.sc_dishes_compact.color_style_link2 .sc_dishes_item_title a {
	color: {$colors['text_link2']};
}
.sc_dishes_compact.color_style_link3 .sc_dishes_item_title a {
	color: {$colors['text_link3']};
}
.sc_dishes_compact .sc_dishes_item_title a:hover,
.sc_dishes_compact .sc_dishes_item:hover .sc_dishes_item_title a {
	color: {$colors['bg_color']};
}
.sc_dishes.slider_container .swiper-pagination-bullet {
	border-color: {$colors['text_light']};
}


/* Events */
.sc_events.slider_container .swiper-pagination-bullet {
	border-color: {$colors['text_light']};
}

.sc_events_default .sc_events_item_thumb .sc_events_item_date {
	background-color: {$colors['alter_bg_color']};
	color: {$colors['alter_text']};
}
.sc_events_default .sc_events_item_thumb .sc_events_item_date_day {
	color: {$colors['alter_link']};
}
.sc_events_default .sc_events_item_thumb:hover .sc_events_item_date {
	background-color: {$colors['alter_bg_hover']};
	color: {$colors['alter_dark']};
}
.sc_events_default .sc_events_item_thumb:hover .sc_events_item_date_day {
	color: {$colors['alter_hover']};
}
.sc_events_default .sc_events_item_meta {
	color: {$colors['text_light']};
}
.sc_events_default .sc_events_item_price {
	color: {$colors['text_link']};
}

.sc_events_classic .sc_events_item {
	background-color: {$colors['alter_bg_color']};
}
.sc_events_classic .sc_events_item_categories {
	background-color: {$colors['alter_dark']};
}
.sc_events_classic .sc_events_item_categories a {
	color: {$colors['bg_color']};
}
.sc_events_classic .sc_events_item_categories a:hover {
	color: {$colors['alter_link']};
}
.sc_events_classic .sc_events_item_meta {
	color: {$colors['alter_light']};
}
.sc_events_classic .sc_events_item_date {
	color: {$colors['alter_dark']};
}
.sc_events_classic .sc_events_item_price {
	color: {$colors['alter_link']};
}
.sc_events_classic .sc_events_item_period {
	color: {$colors['alter_light']};
}

/* Form */
.scheme_self.sc_form {
	background-color: {$colors['bg_color']};
}
span.sc_form_field_title {
	color: {$colors['text_dark']};
}
.sc_form .sc_form_info_icon {
	color: {$colors['text_link']};
}
.sc_form .sc_form_info_data > a,
.sc_form .sc_form_info_data > span {
	color: {$colors['text_dark']};
}
.sc_form .sc_form_info_data > a:hover {
	color: {$colors['text_link']};
}


/* input hovers */
[class*="sc_input_hover_"] .sc_form_field_hover {
	color: {$colors['text_dark']};
}
.sc_input_hover_accent input[type="text"]:focus,
.sc_input_hover_accent input[type="number"]:focus,
.sc_input_hover_accent input[type="email"]:focus,
.sc_input_hover_accent input[type="password"]:focus,
.sc_input_hover_accent input[type="search"]:focus,
.sc_input_hover_accent select:focus,
.sc_input_hover_accent .select2-container.select2-container--focus span.select2-selection,
.sc_input_hover_accent .select2-container.select2-container--open span.select2-selection,
.sc_input_hover_accent textarea:focus {
	border-color: {$colors['text_link']} !important;
}
.sc_input_hover_accent .sc_form_field_hover:before {
	color: {$colors['text_link_02']};
}

.sc_input_hover_path .sc_form_field_graphic {
	stroke: {$colors['input_bd_color']};
}

.sc_input_hover_jump .sc_form_field_hover {
	color: {$colors['input_light']};
}
.sc_input_hover_jump .sc_form_field_content:before {
	color: {$colors['text_link']};
}
.sc_input_hover_jump input[type="text"],
.sc_input_hover_jump input[type="number"],
.sc_input_hover_jump input[type="email"],
.sc_input_hover_jump input[type="password"],
.sc_input_hover_jump input[type="search"],
.sc_input_hover_jump textarea {
	border-color: {$colors['input_bd_color']};
}
.sc_input_hover_jump input[type="text"]:focus,
.sc_input_hover_jump input[type="number"]:focus,
.sc_input_hover_jump input[type="email"]:focus,
.sc_input_hover_jump input[type="password"]:focus,
.sc_input_hover_jump input[type="search"]:focus,
.sc_input_hover_jump textarea:focus {
	border-color: {$colors['text_link']} !important;
}

.sc_input_hover_underline .sc_form_field_hover:before {
	background-color: {$colors['input_bd_color']};
}
.sc_input_hover_underline input:focus + .sc_form_field_hover:before,
.sc_input_hover_underline textarea:focus + .sc_form_field_hover:before,
.sc_input_hover_underline input.filled + .sc_form_field_hover:before,
.sc_input_hover_underline textarea.filled + .sc_form_field_hover:before {
	background-color: {$colors['text_link']};
}
.sc_input_hover_underline .sc_form_field_content {
	color: {$colors['input_dark']};
}
.sc_input_hover_underline input:focus,
.sc_input_hover_underline textarea:focus,
.sc_input_hover_underline input.filled,
.sc_input_hover_underline textarea.filled,
.sc_input_hover_underline input:focus + .sc_form_field_hover > .sc_form_field_content,
.sc_input_hover_underline textarea:focus + .sc_form_field_hover > .sc_form_field_content,
.sc_input_hover_underline input.filled + .sc_form_field_hover > .sc_form_field_content,
.sc_input_hover_underline textarea.filled + .sc_form_field_hover > .sc_form_field_content {
	color: {$colors['text_link']} !important;
}

.sc_input_hover_iconed .sc_form_field_hover {
	color: {$colors['input_light']};
}
.sc_input_hover_iconed input:focus + .sc_form_field_hover,
.sc_input_hover_iconed textarea:focus + .sc_form_field_hover,
.sc_input_hover_iconed input.filled + .sc_form_field_hover,
.sc_input_hover_iconed textarea.filled + .sc_form_field_hover {
	color: {$colors['input_dark']};
}

/* Googlemap */
.sc_googlemap_content,
.scheme_self.sc_googlemap_content {
	color: {$colors['text']};
	background-color: {$colors['bg_color']};
}
.sc_googlemap_content b,
.sc_googlemap_content strong,
.scheme_self.sc_googlemap_content b,
.scheme_self.sc_googlemap_content strong {
	color: {$colors['text_dark']};
}
.sc_googlemap_content_detailed:before {
	color: {$colors['text_link']};
}


/* Yandexmap */
.sc_yandexmap_content,
.scheme_self.sc_yandexmap_content {
	color: {$colors['text']};
	background-color: {$colors['bg_color']};
}
.sc_yandexmap_content b,
.sc_yandexmap_content strong,
.scheme_self.sc_yandexmap_content b,
.scheme_self.sc_yandexmap_content strong {
	color: {$colors['text_dark']};
}
.sc_yandexmap_content_detailed:before {
	color: {$colors['text_link']};
}

/* Icons */
.sc_icons .sc_icons_icon {
	color: {$colors['text_link2']};
}
.sc_icons .sc_icons_item_linked:hover .sc_icons_icon {
	color: {$colors['text_dark']};
}
.sc_icons .sc_icons_item_title {
	color: {$colors['text_dark']};
}
.scheme_self.footer_wrap .sc_icons .sc_icons_item_title {
	color: {$colors['text_dark']};
}
.scheme_self.footer_wrap .sc_icons .sc_icons_item_description {
	color: {$colors['text']};
}
.sc_icons_item_description {
	color: {$colors['text']};
}
.sc_icons_item_description a {
	color: {$colors['text']};
}
.sc_icons_item_description a:hover {
	color: {$colors['text_dark']};
}

/* Sports: Matches and Players */
.sc_sport_default .sc_sport_item_subtitle .sc_sport_item_date {
	color: {$colors['text_light']};
}

.sc_matches_main .swiper-pagination .swiper-pagination-bullet {
	border-color: {$colors['bd_color']};
}
.sc_matches_main .sc_matches_item_score a {
	color: {$colors['text_dark']};
}
.sc_matches_main .sc_matches_item_score a:hover {
	color: {$colors['text_link']};
}
.color_style_link2 .sc_matches_main .sc_matches_item_score a:hover {
	color: {$colors['text_link2']};
}
.color_style_link3 .sc_matches_main .sc_matches_item_score a:hover {
	color: {$colors['text_link3']};
}
.color_style_dark .sc_matches_main .sc_matches_item_score a:hover {
	color: {$colors['text_dark']};
}

.sc_matches_other .sc_matches_item_link {
	color: {$colors['alter_dark']};
	background-color: {$colors['alter_bg_color']};
}
.sc_matches_other .sc_matches_item_club {
	color: {$colors['alter_light']};
}
.sc_matches_other .sc_matches_item_date {
	color: {$colors['alter_dark']};
	background-color: {$colors['alter_bd_color']};
}
.sc_matches_other .sc_matches_item_link:hover {
	background-color: {$colors['alter_bg_hover']};
}
.sc_matches_other .sc_matches_item_link:hover .sc_matches_item_date {
	background-color: {$colors['alter_bd_hover']};
}

.sc_points_table td a {
	color: {$colors['alter_dark']};
}
.sc_points_table tr:hover td {
	background-color: {$colors['alter_hover']} !important;
}
.sc_points_table tr:hover a,
.sc_points_table td a:hover {
	color: {$colors['inverse_hover']} !important;
}
.sc_points_table tr.sc_points_table_accented_top td {
	background-color: {$colors['text_link_07']};
}
.sc_points_table tr.sc_points_table_accented_bottom td {
	background-color: {$colors['alter_bg_color']};
}


/* Portfolio */
.sc_portfolio_default .sc_portfolio_item {
	background-color: {$colors['alter_bg_color']};
	color: {$colors['alter_text']};
}
.sc_portfolio_default .sc_portfolio_item a,
.sc_portfolio_default .sc_portfolio_item .sc_button_simple:not(.sc_button_bg_image),
.sc_portfolio_default .sc_portfolio_item .sc_button_simple:not(.sc_button_bg_image):before,
.sc_portfolio_default .sc_portfolio_item .sc_button_simple:not(.sc_button_bg_image):after {
	color: {$colors['alter_link']} !important;
}
.sc_portfolio_default .sc_portfolio_item a:hover,
.sc_portfolio_default .sc_portfolio_item .sc_button_simple:not(.sc_button_bg_image):hover,
.sc_portfolio_default .sc_portfolio_item .sc_button_simple:not(.sc_button_bg_image):hover:before,
.sc_portfolio_default .sc_portfolio_item .sc_button_simple:not(.sc_button_bg_image):hover:after {
	color: {$colors['alter_hover']} !important;
}
.sc_portfolio_default .sc_portfolio_item:hover {
	background-color: {$colors['alter_bg_hover']};
}
.sc_portfolio_default .sc_portfolio_item_title {
	color: {$colors['alter_dark']};
}

.portfolio_page_details_share {
	border-color: {$colors['bd_color']};	
}

/* Price */
.sc_price_item {
	color: {$colors['text']};
	background-color: {$colors['bg_color']};
	border-color: transparent;
	box-shadow: 0 0 43px 0 {$colors['inverse_bd_color_006']};
}
.sc_price_item:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['bg_color']};
	border-color: transparent;
}
.sc_price_item .sc_price_item_icon {
	color: {$colors['text_dark']};
}
.sc_price_item:hover .sc_price_item_icon {
	color: {$colors['text_dark']};
}
.sc_price_item .sc_price_item_label {
	background-color: {$colors['extra_link']};
	color: {$colors['inverse_text']};
}
.sc_price_item:hover .sc_price_item_label {
	background-color: {$colors['extra_hover']};
	color: {$colors['inverse_text']};
}
.sc_price_item .sc_price_item_subtitle {
	color: {$colors['text_dark']};
}
.sc_price_item .sc_price_item_title,
.sc_price_item .sc_price_item_title a {
	color: {$colors['text_dark']};
}
.sc_price_item .sc_price_item_price {
	color: {$colors['text_dark']};
}
.sc_price .sc_price_item .sc_price_item_info .sc_price_item_price .sc_price_item_price_after,
.sc_price_item .sc_price_item_description,
.sc_price_item .sc_price_item_details {
	color: {$colors['text']};
}
.sc_price_item.with_image .sc_price_item_info .sc_price_item_price .sc_price_item_price_after,
.sc_price_item.with_image .sc_price_item_icon,
.sc_price_item.with_image .sc_price_item_subtitle,
.sc_price_item.with_image .sc_price_item_title,
.sc_price_item.with_image .sc_price_item_title a,
.sc_price_item.with_image .sc_price_item_price,
.sc_price_item.with_image .sc_price_item_description,
.sc_price_item.with_image .sc_price_item_details {
	color: {$colors['inverse_link']};
}

.sc_price .sc_price_item.with_image .sc_price_item_info .sc_price_item_description ul[class*="trx_addons_list"] li:before,
.sc_price .sc_price_item.with_image .sc_price_item_info .sc_price_item_details ul[class*="trx_addons_list"] li:before {
	color: {$colors['inverse_link']};
}

.sc_price_item_link {
	color: {$colors['extra_link2']} !important;
	background-color: {$colors['inverse_hover']} !important;
}
.sc_price_item_link:before {
	color: {$colors['extra_link2']} !important;
}
.sc_price_item_link:after {
	background-color: {$colors['extra_link2']} !important;
}
.sc_price_item_link:hover {
	color: {$colors['extra_link2']} !important;
	background-color: {$colors['inverse_hover']} !important;
}
/* Promo */
.sc_promo_icon {
	color:{$colors['text_link']};
}
.sc_promo .sc_promo_title,
.sc_promo .sc_promo_descr {
	color:{$colors['text_dark']};
}
.sc_promo .sc_promo_content {
	color:{$colors['text']};
}
.sc_promo_modern .sc_promo_link2 {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']} !important;
}
.sc_promo_modern .sc_promo_link2:hover {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
.scheme_self.sc_promo .sc_promo_text.trx_addons_stretch_height,
.scheme_self.sc_promo .sc_promo_text_inner {
	background-color: {$colors['alter_bg_color']};
}
.scheme_self.sc_promo .sc_promo_title {
	color:{$colors['alter_link']};
}
.scheme_self.sc_promo .sc_promo_subtitle {
	color:{$colors['alter_hover']};
}
.scheme_self.sc_promo .sc_promo_descr {
	color:{$colors['alter_dark']};
}
.scheme_self.sc_promo .sc_promo_content {
	color:{$colors['alter_text']};
}


/* Properties */
.sc_properties_columns_1 .sc_properties_item {
	background-color: {$colors['alter_bg_color']};
}
.sc_properties_item_status > a,
.sc_properties_item_type > a,
.sc_properties_item_compare {
	color: {$colors['text_light']};
}
.sc_properties_item_compare.in_compare_list {
	color: {$colors['text_link']};
}
.sc_properties_item_status > a:hover,
.sc_properties_item_type > a:hover,
.sc_properties_item_compare:hover,
.sc_properties_item_compare.in_compare_list:hover {
	color: {$colors['text_dark']};
}
.sc_properties_item_options .sc_properties_item_row_address,
.sc_properties_item_options .sc_properties_item_row_meta {
	color: {$colors['text_light']};
}
.properties_page_title .properties_page_status > a {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.properties_page_title .properties_page_status > a:hover {
	color: {$colors['inverse_hover']};
	background-color: {$colors['text_link_blend']};
}
.properties_page_title_address {
	color: {$colors['text_light']};
}
.properties_price {
	color: {$colors['text_light']};
}
.properties_page_section_title {
	border-color: {$colors['bd_color']};
}
.properties_page_attachments_list > a:before,
.properties_page_features_list > a:before {
	color: {$colors['text_link']};
}

.properties_page_floor_plans_list .properties_page_floor_plans_list_item_title {
	background-color: {$colors['alter_bg_color']} !important;
	color: {$colors['alter_text']};
}

.properties_page_virtual_tour_wrap {
	background-color: {$colors['alter_bg_color']};	
	color: {$colors['alter_text']};	
}

.properties_page_tabs.trx_addons_tabs .trx_addons_tabs_titles {
	border-color: {$colors['alter_bd_color']};
}
.properties_page_tabs.trx_addons_tabs .trx_addons_tabs_titles li > a {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['alter_bg_color']};
	border-bottom-color: {$colors['alter_bd_color']};
}
.properties_page_tabs.trx_addons_tabs .trx_addons_tabs_titles li.ui-state-active > a {
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['bg_color']};
	border-bottom-color: {$colors['bg_color']};
}
.properties_page_tabs.trx_addons_tabs .trx_addons_tabs_titles li:not(.ui-state-active) > a:hover {
	background-color: {$colors['alter_bg_hover']};
	border-color: {$colors['alter_bg_hover']} {$colors['alter_bg_hover']} {$colors['alter_bd_color']};
}

.properties_page_agent_info_position {
	color: {$colors['text_light']};
}
.properties_page_agent_info_phones > span,
.properties_page_agent_info_phones > a {
	color: {$colors['text']};
}
.properties_page_agent_info_phones > a:hover {
	color: {$colors['text_link']};
}
.properties_page_agent_info_address:before,
.properties_page_agent_info_phones > :before {
	color: {$colors['text_dark']};
}
.properties_page_agent_info_profiles.socials_wrap .social_item .social_icon {
	color: {$colors['text']};
}

.properties_search_form .properties_search_basic .properties_search_show_advanced {
	color: {$colors['input_text']};
	background-color: {$colors['input_bg_color']};
}
.properties_search_form .properties_search_basic .properties_search_show_advanced:hover {
	color: {$colors['input_dark']};
}

.sc_properties_compare_data .properties_feature_present {
	color: {$colors['text_link']};
}


/* Services */
.sc_services .sc_services_item_number {
	color: {$colors['alter_bg_hover']};
}

.sc_services_default .sc_services_item {
	color: {$colors['alter_text']};
}
.sc_services_triangle .sc_services_item_icon {
	color: {$colors['text_link']};
}
.sc_services_default .sc_services_item_icon {
	color: {$colors['text_link3']};
}
.sc_services_default .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_link']};
}
.sc_services_triangle .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_link3']};
}
.sc_services_default.color_style_link2 .sc_services_item_icon {
	color: {$colors['alter_link2']};
	border-color: {$colors['alter_link2']};
}
.sc_services_default.color_style_link2 .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['inverse_dark']};
	background-color: {$colors['alter_link2']};
	border-color: {$colors['alter_link2']};
}
.sc_services_default.color_style_link3 .sc_services_item_icon {
	color: {$colors['alter_link3']};
	border-color: {$colors['alter_link3']};
}
.sc_services_default.color_style_link3 .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['inverse_dark']};
	background-color: {$colors['alter_link3']};
	border-color: {$colors['alter_link3']};
}
.sc_services_default.color_style_dark .sc_services_item_icon {
	color: {$colors['alter_dark']};
	border-color: {$colors['alter_dark']};
}
.sc_services_default.color_style_dark .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['inverse_dark']};
	background-color: {$colors['alter_dark']};
	border-color: {$colors['alter_dark']};
}
.sc_services_default .sc_services_item_subtitle a {
	color: {$colors['alter_link']};
}
.sc_services_default .sc_services_item_subtitle a:hover {
	color: {$colors['alter_hover']};
}
.sc_services_default.color_style_link2 .sc_services_item_subtitle a {
	color: {$colors['alter_link2']};
}
.sc_services_default.color_style_link2 .sc_services_item_subtitle a:hover {
	color: {$colors['alter_hover2']};
}
.sc_services_default.color_style_link3 .sc_services_item_subtitle a {
	color: {$colors['alter_link3']};
}
.sc_services_default.color_style_link3 .sc_services_item_subtitle a:hover {
	color: {$colors['alter_hover3']};
}
.sc_services_default.color_style_dark .sc_services_item_subtitle a {
	color: {$colors['alter_dark']};
}
.sc_services_default.color_style_dark .sc_services_item_subtitle a:hover {
	color: {$colors['alter_link']};
}
.sc_services_default .sc_services_item_featured_left,
.sc_services_default .sc_services_item_featured_right,
.sc_services_list .sc_services_item {
	color: {$colors['text']};
	background-color: transparent;
}

.sc_services_default .sc_services_item_featured_left .sc_services_item_icon,
.sc_services_default .sc_services_item_featured_right .sc_services_item_icon,
.sc_services_list .sc_services_item_icon {
	color: {$colors['text_link']};
	border-color: {$colors['text_link']};
}
.sc_services_list .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_hover']};
}
.sc_services_default .sc_services_item_featured_left:hover .sc_services_item_icon,
.sc_services_default .sc_services_item_featured_right:hover .sc_services_item_icon,
.sc_services_list .sc_services_item_featured_left:hover .sc_services_item_icon,
.sc_services_list .sc_services_item_featured_right:hover .sc_services_item_icon {
	color: {$colors['inverse_dark']};
	background-color: {$colors['text_link']};
	border-color: {$colors['text_link']};
}
.sc_services_default .sc_services_item_featured_left .sc_services_item_subtitle a,
.sc_services_default .sc_services_item_featured_right .sc_services_item_subtitle a {
	color: {$colors['text_link']};
}
.sc_services_default .sc_services_item_featured_left .sc_services_item_subtitle a:hover,
.sc_services_default .sc_services_item_featured_right .sc_services_item_subtitle a:hover {
	color: {$colors['text_hover']};
}
.sc_services_default.color_style_link2 .sc_services_item_featured_left .sc_services_item_icon,
.sc_services_default.color_style_link2 .sc_services_item_featured_right .sc_services_item_icon,
.sc_services_list.color_style_link2 .sc_services_item_icon {
	color: {$colors['text_link2']};
	border-color: {$colors['text_link2']};
}
.sc_services_list.color_style_link2 .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_hover2']};
}
.sc_services_default.color_style_link2 .sc_services_item_featured_left:hover .sc_services_item_icon,
.sc_services_default.color_style_link2 .sc_services_item_featured_right:hover .sc_services_item_icon,
.sc_services_list.color_style_link2 .sc_services_item_featured_left:hover .sc_services_item_icon,
.sc_services_list.color_style_link2 .sc_services_item_featured_right:hover .sc_services_item_icon {
	color: {$colors['inverse_dark']};
	background-color: {$colors['text_link2']};
	border-color: {$colors['text_link2']};
}
.sc_services_default.color_style_link2 .sc_services_item_featured_left .sc_services_item_subtitle a,
.sc_services_default.color_style_link2 .sc_services_item_featured_right .sc_services_item_subtitle a {
	color: {$colors['text_link2']};
}
.sc_services_default.color_style_link2 .sc_services_item_featured_left .sc_services_item_subtitle a:hover,
.sc_services_default.color_style_link2 .sc_services_item_featured_right .sc_services_item_subtitle a:hover {
	color: {$colors['text_hover2']};
}
.sc_services_default.color_style_link3 .sc_services_item_featured_left .sc_services_item_icon,
.sc_services_default.color_style_link3 .sc_services_item_featured_right .sc_services_item_icon,
.sc_services_list.color_style_link3 .sc_services_item_icon {
	color: {$colors['text_link3']};
	border-color: {$colors['text_link3']};
}
.sc_services_list.color_style_link3 .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_hover3']};
}
.sc_services_default.color_style_link3 .sc_services_item_featured_left:hover .sc_services_item_icon,
.sc_services_default.color_style_link3 .sc_services_item_featured_right:hover .sc_services_item_icon,
.sc_services_list.color_style_link3 .sc_services_item_featured_left:hover .sc_services_item_icon,
.sc_services_list.color_style_link3 .sc_services_item_featured_right:hover .sc_services_item_icon {
	color: {$colors['inverse_dark']};
	background-color: {$colors['text_link3']};
	border-color: {$colors['text_link3']};
}
.sc_services_default.color_style_link3 .sc_services_item_featured_left .sc_services_item_subtitle a,
.sc_services_default.color_style_link3 .sc_services_item_featured_right .sc_services_item_subtitle a {
	color: {$colors['text_link3']};
}
.sc_services_default.color_style_link3 .sc_services_item_featured_left .sc_services_item_subtitle a:hover,
.sc_services_default.color_style_link3 .sc_services_item_featured_right .sc_services_item_subtitle a:hover {
	color: {$colors['text_hover3']};
}
.sc_services_default.color_style_dark .sc_services_item_featured_left .sc_services_item_icon,
.sc_services_default.color_style_dark .sc_services_item_featured_right .sc_services_item_icon,
.sc_services_list.color_style_dark .sc_services_item_icon {
	color: {$colors['text_dark']};
	border-color: {$colors['text_dark']};
}
.sc_services_list.color_style_dark .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_link']};
}
.sc_services_default.color_style_dark .sc_services_item_featured_left:hover .sc_services_item_icon,
.sc_services_default.color_style_dark .sc_services_item_featured_right:hover .sc_services_item_icon,
.sc_services_list.color_style_dark .sc_services_item_featured_left:hover .sc_services_item_icon,
.sc_services_list.color_style_dark .sc_services_item_featured_right:hover .sc_services_item_icon {
	color: {$colors['inverse_dark']};
	background-color: {$colors['text_dark']};
	border-color: {$colors['text_dark']};
}
.sc_services_default.color_style_dark .sc_services_item_featured_left .sc_services_item_subtitle a,
.sc_services_default.color_style_dark .sc_services_item_featured_right .sc_services_item_subtitle a {
	color: {$colors['text_dark']};
}
.sc_services_default.color_style_dark .sc_services_item_featured_left .sc_services_item_subtitle a:hover,
.sc_services_default.color_style_dark .sc_services_item_featured_right .sc_services_item_subtitle a:hover {
	color: {$colors['text_link']};
}


.sc_services_light .sc_services_item_icon {
	color: {$colors['text_link']};
}
.sc_services_light .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_hover']};
}
.sc_services_light.color_style_link2 .sc_services_item_icon {
	color: {$colors['text_link2']};
}
.sc_services_light.color_style_link2 .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_hover2']};
}
.sc_services_light.color_style_link3 .sc_services_item_icon {
	color: {$colors['text_link3']};
}
.sc_services_light.color_style_link3 .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_hover3']};
}
.sc_services_light.color_style_dark .sc_services_item_icon {
	color: {$colors['text_dark']};
}
.sc_services_light.color_style_dark .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_link']};
}


.sc_services_callouts .sc_services_item {
	background-color:{$colors['alter_bg_color']};
}
.sc_services_callouts .sc_services_item_marker {
	border-color: {$colors['bg_color']};
	background-color:{$colors['alter_link']};
	color: {$colors['inverse_link']};
}
.sc_services_callouts .sc_services_item .sc_services_item_marker_back {
	border-color: {$colors['bg_color']};
	background-color:{$colors['alter_hover']};
	color: {$colors['inverse_hover']};
}
.sc_services_callouts.color_style_link2 .sc_services_item_marker {
	background-color:{$colors['alter_link2']};
}
.sc_services_callouts.color_style_link2 .sc_services_item .sc_services_item_marker_back {
	background-color:{$colors['alter_hover2']};
}
.sc_services_callouts.color_style_link3 .sc_services_item_marker {
	background-color:{$colors['alter_link3']};
}
.sc_services_callouts.color_style_link3 .sc_services_item .sc_services_item_marker_back {
	background-color:{$colors['alter_hover3']};
}
.sc_services_callouts.color_style_dark .sc_services_item_marker {
	background-color:{$colors['alter_dark']};
}
.sc_services_callouts.color_style_dark .sc_services_item .sc_services_item_marker_back {
	background-color:{$colors['alter_link']};
}
.sc_services_callouts .sc_services_item_marker_bg {
	border-color: {$colors['bg_color']};
	background-color:{$colors['bg_color']};
}

.sc_services_timeline .sc_services_item_timeline {
	border-color: {$colors['bd_color']};
}
.sc_services_timeline .sc_services_item_marker {
	border-color: {$colors['text_link']};
	background-color:{$colors['text_link']};
	color: {$colors['inverse_link']};
}
.sc_services_timeline .sc_services_item:hover .sc_services_item_marker {
	border-color: {$colors['text_hover']};
	background-color:{$colors['text_hover']};
	color: {$colors['inverse_hover']};
}
.sc_services_timeline.color_style_link2 .sc_services_item_marker {
	border-color: {$colors['text_link2']};
	background-color:{$colors['text_link2']};
}
.sc_services_timeline.color_style_link2 .sc_services_item:hover .sc_services_item_marker {
	border-color: {$colors['text_hover2']};
	background-color:{$colors['text_hover2']};
}
.sc_services_timeline.color_style_link3 .sc_services_item_marker {
	border-color: {$colors['text_link3']};
	background-color:{$colors['text_link3']};
}
.sc_services_timeline.color_style_link3 .sc_services_item:hover .sc_services_item_marker {
	border-color: {$colors['text_hover3']};
	background-color:{$colors['text_hover3']};
}
.sc_services_timeline.color_style_dark .sc_services_item_marker {
	border-color: {$colors['text_dark']};
	background-color:{$colors['text_dark']};
}
.sc_services_timeline.color_style_dark .sc_services_item:hover .sc_services_item_marker {
	border-color: {$colors['text_link']};
	background-color:{$colors['text_link']};
}

.sc_services_iconed .sc_services_item {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_color']};
}
.sc_services_iconed .sc_services_item_icon:hover,
.sc_services_iconed .sc_services_item:hover .sc_services_item_icon,
.sc_services_iconed .sc_services_item_header .sc_services_item_subtitle a:hover,
.sc_services_iconed .sc_services_item:hover .sc_services_item_header .sc_services_item_subtitle a {
	color: {$colors['text_link']};
}
.sc_services_iconed.color_style_link2 .sc_services_item_icon:hover,
.sc_services_iconed.color_style_link2 .sc_services_item:hover .sc_services_item_icon,
.sc_services_iconed.color_style_link2 .sc_services_item_header .sc_services_item_subtitle a:hover,
.sc_services_iconed.color_style_link2 .sc_services_item:hover .sc_services_item_header .sc_services_item_subtitle a {
	color: {$colors['text_link2']};
}
.sc_services_iconed.color_style_link3 .sc_services_item_icon:hover,
.sc_services_iconed.color_style_link3 .sc_services_item:hover .sc_services_item_icon,
.sc_services_iconed.color_style_link3 .sc_services_item_header .sc_services_item_subtitle a:hover,
.sc_services_iconed.color_style_link3 .sc_services_item:hover .sc_services_item_header .sc_services_item_subtitle a {
	color: {$colors['text_link3']};
}
.sc_services_iconed .sc_services_item_header .sc_services_item_title a {
	color: {$colors['text_link']};
}
.sc_services_iconed.color_style_link2 .sc_services_item_header .sc_services_item_title a {
	color: {$colors['text_link2']};
}
.sc_services_iconed.color_style_link3 .sc_services_item_header .sc_services_item_title a {
	color: {$colors['text_link3']};
}
.sc_services_iconed .sc_services_item_header .sc_services_item_title a:hover,
.sc_services_iconed .sc_services_item:hover .sc_services_item_header .sc_services_item_title a {
	color: #fff;
}
.sc_services_iconed .sc_services_item .sc_services_item_header .sc_services_item_subtitle a {
	color: #fff;
}
.sc_services_iconed .sc_services_item:hover .sc_services_item_header .sc_services_item_subtitle a,
.sc_services_iconed .sc_services_item .sc_services_item_header .sc_services_item_subtitle a:hover {
	color: {$colors['text_link']};
}
.sc_services_iconed.color_style_link2 .sc_services_item:hover .sc_services_item_header .sc_services_item_subtitle a,
.sc_services_iconed.color_style_link2 .sc_services_item .sc_services_item_header .sc_services_item_subtitle a:hover {
	color: {$colors['text_link2']};
}
.sc_services_iconed.color_style_link3 .sc_services_item:hover .sc_services_item_header .sc_services_item_subtitle a,
.sc_services_iconed.color_style_link3 .sc_services_item .sc_services_item_header .sc_services_item_subtitle a:hover {
	color: {$colors['text_link3']};
}
.sc_services_iconed .sc_services_item_content .sc_services_item_title a {
	color: {$colors['alter_dark']};
}
.sc_services_iconed .sc_services_item_content .sc_services_item_title a:hover,
.sc_services_iconed .sc_services_item:hover .sc_services_item_content .sc_services_item_title a {
	color: {$colors['alter_link']};
}
.sc_services_iconed.color_style_link2 .sc_services_item_content .sc_services_item_title a:hover,
.sc_services_iconed.color_style_link2 .sc_services_item:hover .sc_services_item_content .sc_services_item_title a {
	color: {$colors['alter_link2']};
}
.sc_services_iconed.color_style_link3 .sc_services_item_content .sc_services_item_title a:hover,
.sc_services_iconed.color_style_link3 .sc_services_item:hover .sc_services_item_content .sc_services_item_title a {
	color: {$colors['alter_link3']};
}
.sc_services_iconed.color_style_dark .sc_services_item_content .sc_services_item_title a:hover,
.sc_services_iconed.color_style_dark .sc_services_item:hover .sc_services_item_content .sc_services_item_title a {
	color: {$colors['alter_dark']};
}
.sc_services.slider_container .swiper-pagination-bullet {
	border-color: {$colors['text_light']};
}

.sc_services_list .sc_services_item_featured_left .sc_services_item_number,
.sc_services_list .sc_services_item_featured_right .sc_services_item_number {
	color: {$colors['text_light']};
}

.sc_services_hover .sc_services_item_icon,
.sc_services_hover .sc_services_item_title a:hover,
.sc_services_hover .sc_services_item_subtitle a:hover {
	color: {$colors['text_link']};
}
.sc_services_hover.color_style_link2 .sc_services_item_icon,
.sc_services_hover.color_style_link2 .sc_services_item_title a:hover,
.sc_services_hover.color_style_link2 .sc_services_item_subtitle a:hover {
	color: {$colors['text_link2']};
}
.sc_services_hover.color_style_link3 .sc_services_item_icon,
.sc_services_hover.color_style_link3 .sc_services_item_title a:hover,
.sc_services_hover.color_style_link3 .sc_services_item_subtitle a:hover {
	color: {$colors['text_link3']};
}
.sc_services_hover [class*="column-"]:nth-child(2n) .sc_services_item.with_image .sc_services_item_header.without_image,
.sc_services_hover .slider-slide:nth-child(2n) .sc_services_item.with_image .sc_services_item_header.without_image {
	background-color:{$colors['alter_bg_hover']};
}
.sc_services_hover [class*="column-"]:nth-child(2n+1) .sc_services_item.with_image .sc_services_item_header.without_image,
.sc_services_hover .slider-slide:nth-child(2n+1) .sc_services_item.with_image .sc_services_item_header.without_image {
	background-color:{$colors['alter_bg_color']};
}
.sc_services_hover .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_icon,
.sc_services_hover .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_number {
	color: {$colors['alter_light']};
}
.sc_services_hover .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_title,
.sc_services_hover .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_title a {
	color: {$colors['alter_dark']};
}
.sc_services_hover .sc_services_item.with_image:hover .sc_services_item_header.without_image .sc_services_item_title a,
.sc_services_hover .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_title a:hover {
	color: {$colors['alter_link']};
}
.sc_services_hover.color_style_link2 .sc_services_item.with_image:hover .sc_services_item_header.without_image .sc_services_item_title a,
.sc_services_hover.color_style_link2 .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_title a:hover {
	color: {$colors['alter_link2']};
}
.sc_services_hover.color_style_link3 .sc_services_item.with_image:hover .sc_services_item_header.without_image .sc_services_item_title a,
.sc_services_hover.color_style_link3 .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_title a:hover {
	color: {$colors['alter_link3']};
}
.sc_services_hover .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_subtitle,
.sc_services_hover .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_subtitle a {
	color: {$colors['alter_link']};
}
.sc_services_hover.color_style_link2 .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_subtitle,
.sc_services_hover.color_style_link2 .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_subtitle a {
	color: {$colors['alter_link2']};
}
.sc_services_hover.color_style_link3 .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_subtitle,
.sc_services_hover.color_style_link3 .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_subtitle a {
	color: {$colors['alter_link3']};
}
.sc_services_hover .sc_services_item.with_image:hover .sc_services_item_header.without_image .sc_services_item_subtitle a,
.sc_services_hover .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_subtitle a:hover {
	color: {$colors['alter_hover']};
}
.sc_services_hover.color_style_link2 .sc_services_item.with_image:hover .sc_services_item_header.without_image .sc_services_item_subtitle a,
.sc_services_hover.color_style_link2 .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_subtitle a:hover {
	color: {$colors['alter_hover2']};
}
.sc_services_hover.color_style_link3 .sc_services_item.with_image:hover .sc_services_item_header.without_image .sc_services_item_subtitle a,
.sc_services_hover.color_style_link3 .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_subtitle a:hover {
	color: {$colors['alter_hover3']};
}
.sc_services_hover .sc_services_item.with_image .sc_services_item_header.without_image .sc_services_item_text {
	color: {$colors['alter_text']};
}

.sc_services_chess .sc_services_item {
	color:{$colors['alter_text']};
	background-color:{$colors['alter_bg_color']};
}
.sc_services_chess .sc_services_item_title,
.sc_services_chess .sc_services_item_title a {
	color:{$colors['alter_dark']};
}
.sc_services_chess .sc_services_item_title a:hover {
	color:{$colors['alter_link']};
}
.sc_services_chess.color_style_link2 .sc_services_item_title a:hover {
	color:{$colors['alter_link2']};
}
.sc_services_chess.color_style_link3 .sc_services_item_title a:hover {
	color:{$colors['alter_link3']};
}
.sc_services_chess .sc_services_item:hover {
	color:{$colors['extra_light']};
	background-color:{$colors['extra_bg_color']};
}
.sc_services_chess .sc_services_item:hover .sc_services_item_title,
.sc_services_chess .sc_services_item:hover .sc_services_item_title a {
	color:{$colors['extra_dark']};
}
.sc_services_chess .sc_services_item:hover .sc_services_item_title a:hover {
	color:{$colors['extra_link']};
}


.sc_services_tabs_simple .sc_services_item_icon {
	color: {$colors['text_link']};
}
.sc_services_tabs_simple.color_style_link2 .sc_services_item_icon {
	color: {$colors['text_link2']};
}
.sc_services_tabs_simple.color_style_link3 .sc_services_item_icon {
	color: {$colors['text_link3']};
}
.sc_services_tabs_simple.color_style_dark .sc_services_item_icon {
	color: {$colors['text_dark']};
}
.sc_services_tabs_simple .sc_services_item:hover .sc_services_item_icon,
.sc_services_tabs_simple .sc_services_item:hover .sc_services_item_title,
.sc_services_tabs_simple .sc_services_item:hover .sc_services_item_subtitle,
.sc_services_tabs_simple .sc_services_tabs_list_item_active .sc_services_item_icon,
.sc_services_tabs_simple .sc_services_tabs_list_item_active .sc_services_item_title,
.sc_services_tabs_simple .sc_services_tabs_list_item_active .sc_services_item_subtitle {
	color: {$colors['text_hover']};
}
.sc_services_tabs_simple.color_style_link2 .sc_services_item:hover .sc_services_item_icon,
.sc_services_tabs_simple.color_style_link2 .sc_services_item:hover .sc_services_item_title,
.sc_services_tabs_simple.color_style_link2 .sc_services_item:hover .sc_services_item_subtitle,
.sc_services_tabs_simple.color_style_link2 .sc_services_tabs_list_item_active .sc_services_item_icon,
.sc_services_tabs_simple.color_style_link2 .sc_services_tabs_list_item_active .sc_services_item_title,
.sc_services_tabs_simple.color_style_link2 .sc_services_tabs_list_item_active .sc_services_item_subtitle {
	color: {$colors['text_hover2']};
}
.sc_services_tabs_simple.color_style_link3 .sc_services_item:hover .sc_services_item_icon,
.sc_services_tabs_simple.color_style_link3 .sc_services_item:hover .sc_services_item_title,
.sc_services_tabs_simple.color_style_link3 .sc_services_item:hover .sc_services_item_subtitle,
.sc_services_tabs_simple.color_style_link3 .sc_services_tabs_list_item_active .sc_services_item_icon,
.sc_services_tabs_simple.color_style_link3 .sc_services_tabs_list_item_active .sc_services_item_title,
.sc_services_tabs_simple.color_style_link3 .sc_services_tabs_list_item_active .sc_services_item_subtitle {
	color: {$colors['text_hover3']};
}

.sc_services_tabs .sc_services_item_content {
	color:{$colors['alter_text']};
	background-color:{$colors['alter_bg_color']};
}
.sc_services_tabs .sc_services_item_title a {
	color:{$colors['alter_dark']};
}
.sc_services_tabs .sc_services_item_title a:hover {
	color:{$colors['alter_link']};
}
.sc_services_tabs.color_style_link2 .sc_services_item_title a:hover {
	color:{$colors['alter_link2']};
}
.sc_services_tabs.color_style_link3 .sc_services_item_title a:hover {
	color:{$colors['alter_link3']};
}
.sc_services_tabs .sc_services_tabs_list_item .sc_services_item_icon {
	color: {$colors['alter_link']};
}
.sc_services_tabs.color_style_link2 .sc_services_tabs_list_item .sc_services_item_icon {
	color: {$colors['alter_link2']};
}
.sc_services_tabs.color_style_link3 .sc_services_tabs_list_item .sc_services_item_icon {
	color: {$colors['alter_link3']};
}
.sc_services_tabs .sc_services_tabs_list_item .sc_services_item_number {
	color: {$colors['alter_light']};
}
.sc_services_tabs .sc_services_tabs_list_item {
	background-color:{$colors['alter_bg_color']};
}
.sc_services_tabs .sc_services_tabs_list_item:nth-child(2n+2) {
	background-color:{$colors['alter_bg_hover']};
}
.sc_services_tabs .sc_services_tabs_list_item:hover,
.sc_services_tabs .sc_services_tabs_list_item:nth-child(2n+2):hover {
	background-color:{$colors['alter_bd_hover']};
}
.sc_services_tabs .sc_services_tabs_list_item .sc_services_item_title {
	color:{$colors['alter_dark']};
}
.sc_services_tabs .sc_services_tabs_list_item:hover .sc_services_item_title {
	color:{$colors['alter_link']};
}
.sc_services_tabs.color_style_link2 .sc_services_tabs_list_item:hover .sc_services_item_title {
	color:{$colors['alter_link2']};
}
.sc_services_tabs.color_style_link3 .sc_services_tabs_list_item:hover .sc_services_item_title {
	color:{$colors['alter_link3']};
}
.sc_services_tabs.color_style_dark .sc_services_tabs_list_item:hover .sc_services_item_title {
	color:{$colors['alter_dark']};
}
.sc_services_tabs .sc_services_tabs_list_item:hover .sc_services_item_icon {
	color:{$colors['alter_hover']};
}
.sc_services_tabs.color_style_link2 .sc_services_tabs_list_item:hover .sc_services_item_icon {
	color:{$colors['alter_hover2']};
}
.sc_services_tabs.color_style_link3 .sc_services_tabs_list_item:hover .sc_services_item_icon {
	color:{$colors['alter_hover3']};
}
.sc_services_tabs.color_style_dark .sc_services_tabs_list_item:hover .sc_services_item_icon {
	color:{$colors['alter_dark']};
}
.sc_services_tabs .sc_services_tabs_list_item:hover .sc_services_item_number {
	color: {$colors['alter_text']};
}
.sc_services_tabs .sc_services_tabs_list_item.sc_services_tabs_list_item_active {
	background-color:{$colors['alter_dark']} !important;
}
.sc_services_tabs .sc_services_tabs_list_item.sc_services_tabs_list_item_active .sc_services_item_title {
	color: {$colors['bg_color']};
}
.sc_services_tabs .sc_services_tabs_list_item.sc_services_tabs_list_item_active .sc_services_item_icon,
.sc_services_tabs .sc_services_tabs_list_item.sc_services_tabs_list_item_active .sc_services_item_number {
	color: {$colors['alter_link']};
}
.sc_services_tabs.color_style_link2 .sc_services_tabs_list_item.sc_services_tabs_list_item_active .sc_services_item_icon,
.sc_services_tabs.color_style_link2 .sc_services_tabs_list_item.sc_services_tabs_list_item_active .sc_services_item_number {
	color: {$colors['alter_link2']};
}
.sc_services_tabs.color_style_link3 .sc_services_tabs_list_item.sc_services_tabs_list_item_active .sc_services_item_icon,
.sc_services_tabs.color_style_link3 .sc_services_tabs_list_item.sc_services_tabs_list_item_active .sc_services_item_number {
	color: {$colors['alter_link3']};
}
.sc_services_tabs.color_style_dark .sc_services_tabs_list_item.sc_services_tabs_list_item_active .sc_services_item_icon,
.sc_services_tabs.color_style_dark .sc_services_tabs_list_item.sc_services_tabs_list_item_active .sc_services_item_number {
	color: {$colors['alter_dark']};
}
.sc_services.sc_services_spot .sc_services_item .sc_services_item_icon {
	color: {$colors['text_dark']};
}
.sc_services.sc_services_spot .sc_services_item:hover .sc_services_item_icon {
	color: {$colors['text_link3']};
}

/* Skills (Counters) */
.sc_skills_counter .sc_skills_icon {
	color:{$colors['text_dark']};
}
.sc_skills .sc_skills_total {
	color:{$colors['text_dark']};
}
.sc_skills.color_style_link2 .sc_skills_total {
	color:{$colors['text_link2']};
}
.sc_skills.color_style_link3 .sc_skills_total {
	color:{$colors['text_link3']};
}
.sc_skills.color_style_dark .sc_skills_total {
	color:{$colors['text_dark']};
}
.sc_skills .sc_skills_item_title,
.sc_skills .sc_skills_legend_title,
.sc_skills .sc_skills_legend_value {
	color:{$colors['text_dark']};
}
.sc_skills_counter .sc_skills_column + .sc_skills_column:before {
	background-color: {$colors['bd_color']};
}

/* Socials */
.socials_wrap .social_item .social_icon {
	background-color: transparent;
}
.socials_wrap .social_item .social_icon,
.socials_wrap .social_item .social_icon i {
	color: {$colors['text_link']};
}
.socials_wrap .social_item:hover .social_icon {
	background-color: transparent;
}
.socials_wrap .social_item:hover .social_icon,
.socials_wrap .social_item:hover .social_icon i {
	color: {$colors['text_hover']};
}
.sidebar_inner .socials_wrap .social_item .social_icon {
	background-color: {$colors['alter_bg_hover']};
}
.sidebar_inner .socials_wrap .social_item:hover .social_icon,
.sidebar_inner .socials_wrap .social_item:hover .social_icon i {
	color: {$colors['inverse_link']};
}
.sidebar_inner .socials_wrap .social_item:hover .social_icon {
	background-color: {$colors['alter_hover']};
}
.scheme_self.sidebar .socials_wrap .social_item .social_icon {
	color: {$colors['text']};
	background-color: transparent;
}
.scheme_self.footer_wrap .socials_wrap .social_item .social_icon {
	color: {$colors['extra_link3']};
	background-color: transparent;
}
.scheme_self.sidebar .socials_wrap .social_item:hover .social_icon {
	color: {$colors['text_hover']};
	background-color: transparent;
}
.scheme_self.footer_wrap .socials_wrap .social_item:hover .social_icon {
	color: {$colors['inverse_hover']};
	background-color: transparent;
}
.scheme_self.sidebar .sc_layouts_row_type_compact .socials_wrap .social_item .social_icon,
.scheme_self.footer_wrap .sc_layouts_row_type_compact .socials_wrap .social_item .social_icon {
	color: {$colors['text_dark']};
	background-color: transparent;
}
.scheme_self.sidebar .sc_layouts_row_type_compact .socials_wrap .social_item:hover .social_icon,
.scheme_self.footer_wrap .sc_layouts_row_type_compact .socials_wrap .social_item:hover .social_icon {
	color: {$colors['text_link']};
	background-color: transparent;
}

/* Super Title */
.sc_supertitle_no_icon {
	background-color: {$colors['text_link']};	
}

/* Testimonials */
.sc_testimonials_item_content {
	color: {$colors['text']};
}
.sc_testimonials_item_content:before {
	color: {$colors['text_link']};
}
.sc_testimonials_item_author_title {
	color: {$colors['text_dark']};
}
.color_style_link2 .sc_testimonials_item_content:before,
.color_style_link2 .sc_testimonials_item_author_title {
	color: {$colors['text_link2']};
}
.color_style_link3 .sc_testimonials_item_content:before,
.color_style_link3 .sc_testimonials_item_author_title {
	color: {$colors['text_link3']};
}
.color_style_dark .sc_testimonials_item_content:before,
.color_style_dark .sc_testimonials_item_author_title {
	color: {$colors['text_dark']};
}
.sc_testimonials_item_author_subtitle {
	color: {$colors['text_light']};
}
.sc_testimonials_simple .sc_testimonials_item_author_data:before  {
	background-color: {$colors['text_light']};
}
.sc_testimonials_simple [class*="column"] .sc_testimonials_item_author_data {
	border-color: {$colors['text_light']};
}
.slider-slide .sc_testimonials_item .sc_testimonials_item_content:before {
	color: {$colors['input_light']};
}
.sc_testimonials .sc_testimonials_slider .sc_item_columns_3 .swiper-slide-active + .slider-slide .sc_testimonials_item .sc_testimonials_item_content:before {
	color: {$colors['text_link']};
}


.sc_testimonials_simple .sc_testimonials_item {
	background-color: {$colors['bg_color']};
}
.sc_testimonials_simple .sc_testimonials_item .sc_testimonials_item_content:before {
	color: {$colors['input_light']};
}

.sc_testimonials .sc_testimonials_slider .sc_item_columns_3 .swiper-slide-active + .slider-slide .sc_testimonials_item .sc_testimonials_item_content {
	box-shadow: 0 0 43px 0 {$colors['inverse_bd_color_006']};
}

/* Team */
.sc_team_default .sc_team_item {
	color: {$colors['alter_text']};
	background-color: {$colors['alter_bg_color']};
}
.sc_team .sc_team_item_thumb .sc_team_item_title a:hover {
	color: {$colors['alter_link']};
}
.sc_team.color_style_link2 .sc_team_item_thumb .sc_team_item_title a:hover {
	color: {$colors['alter_link2']};
}
.sc_team.color_style_link3 .sc_team_item_thumb .sc_team_item_title a:hover {
	color: {$colors['alter_link3']};
}
.sc_team_default .sc_team_item_subtitle {
	color: {$colors['alter_link']};
}
.sc_team_default.color_style_link2 .sc_team_item_subtitle {
	color: {$colors['alter_link2']};
}
.sc_team_default.color_style_link3 .sc_team_item_subtitle {
	color: {$colors['alter_link3']};
}
.sc_team_default.color_style_dark .sc_team_item_subtitle {
	color: {$colors['alter_dark']};
}
.sc_team_default .sc_team_item_socials .social_item .social_icon,
.team_member_page .team_member_socials .social_item .social_icon {
	color: {$colors['text_link']};
}
.sc_team_default.color_style_link2 .sc_team_item_socials .social_item .social_icon {
	background-color: {$colors['alter_link2']};
}
.sc_team_default.color_style_link3 .sc_team_item_socials .social_item .social_icon {
	background-color: {$colors['alter_link3']};
}
.sc_team_default.color_style_dark .sc_team_item_socials .social_item .social_icon {
	background-color: {$colors['alter_dark']};
}
.sc_team_default .sc_team_item_socials .social_item:hover .social_icon,
.team_member_page .team_member_socials .social_item:hover .social_icon {
	color: {$colors['text_hover']};
}
.sc_team_default.color_style_link2 .sc_team_item_socials .social_item:hover .social_icon {
	background-color: {$colors['alter_hover2']};
}
.sc_team_default.color_style_link3 .sc_team_item_socials .social_item:hover .social_icon {
	background-color: {$colors['alter_hover3']};
}
.sc_team_default.color_style_dark .sc_team_item_socials .social_item:hover .social_icon {
	background-color: {$colors['alter_link']};
}
.sc_team .sc_team_item_thumb .sc_team_item_socials .social_item .social_icon {
	color: {$colors['text_dark']};
	background-color: {$colors['bg_color']} !important;
}
.sc_team .sc_team_item_thumb .sc_team_item_socials .social_item:hover .social_icon {
	color: {$colors['text_link']};
	background-color: {$colors['bg_color']} !important;
}

.sc_team .sc_team_item_subtitle {
	color: {$colors['text_light']};
}
.team_member_page .team_member_featured .team_member_avatar {
	border-color: {$colors['bd_color']};
}
.sc_team_short .sc_team_item_thumb {
	border-color: {$colors['text_link']};
}
.sc_team_short.color_style_link2 .sc_team_item_thumb {
	border-color: {$colors['text_link2']};
}
.sc_team_short.color_style_link3 .sc_team_item_thumb {
	border-color: {$colors['text_link3']};
}
.sc_team_short.color_style_dark .sc_team_item_thumb {
	border-color: {$colors['text_dark']};
}
.sc_team.slider_container .swiper-pagination-bullet {
	border-color: {$colors['text_light']};
}



/* CPT Sport
--------------------------------------------------- */

.sport_page_list {
	border-color: {$colors['bd_color']};
}
.sport_page_list li+li {
	border-color: {$colors['bd_color']};
}
.sport_page_list li:nth-child(2n+1) {
	background-color: {$colors['alter_bg_color']};
	color: {$colors['alter_text']};
}


/* Utils
--------------------------------------------------- */

/* Scroll to top */
.trx_addons_scroll_to_top,
.trx_addons_cv .trx_addons_scroll_to_top {
	color: {$colors['inverse_link']};
	border-color: {$colors['text_link']};
	background-color: {$colors['text_link']};
}
.trx_addons_scroll_to_top:hover,
.trx_addons_cv .trx_addons_scroll_to_top:hover {
	color: {$colors['inverse_hover']};
	border-color: {$colors['text_link_blend']};
	background-color: {$colors['text_link_blend']};
}

/* Scroll progress */
.scroll_progress_wrap .scroll_progress_status {
	background-color: {$colors['text_link']};
}

/* Login and Register */
.sc_layouts_popup, .scheme_self.sc_layouts_popup,
.sc_layouts_panel, .scheme_self.sc_layouts_panel,
.trx_addons_popup, .scheme_self.trx_addons_popup {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['alter_bd_color']};
	color: {$colors['alter_text']};
}
.trx_addons_popup button.mfp-close {
	background-color: {$colors['alter_bg_hover']};
	border-color: {$colors['alter_bd_hover']};
	color:{$colors['alter_text']};
}
.trx_addons_popup button.mfp-close:hover {
	background-color: {$colors['alter_dark']};
	color: {$colors['alter_bg_color']};
}
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title {
	background-color:{$colors['alter_bg_hover']};
	border-color: {$colors['alter_bd_hover']};
}
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title.ui-tabs-active {
	background-color:{$colors['alter_bg_color']};
	border-bottom-color: transparent;
}
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title a,
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title a > i {
	color:{$colors['alter_text']};
}
.trx_addons_popup li.trx_addons_tabs_title a:hover,
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title a:hover > i {
	color:{$colors['alter_link']};
}
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title[data-disabled="true"] a,
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title[data-disabled="true"] a > i,
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title[data-disabled="true"] a:hover,
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title[data-disabled="true"] a:hover > i {
	color:{$colors['alter_light']};
}
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title.ui-tabs-active a,
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title.ui-tabs-active a > i,
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title.ui-tabs-active a:hover,
.trx_addons_popup .trx_addons_tabs_titles li.trx_addons_tabs_title.ui-tabs-active a:hover > i {
	color:{$colors['alter_dark']};
}

/* Profiler */
.trx_addons_profiler {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['alter_bd_hover']};
}
.trx_addons_profiler_title {
	color: {$colors['alter_dark']};
}
.trx_addons_profiler table td,
.trx_addons_profiler table th {
	border-color: {$colors['alter_bd_color']};
}
.trx_addons_profiler table td {
	color: {$colors['alter_text']};
}
.trx_addons_profiler table th {
	background-color: {$colors['alter_bg_hover']};
	color: {$colors['alter_dark']};
}




/* Themes Market */
.sc_edd_add_to_cart_default,
.sc_edd_details {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['alter_bd_hover']};
	color: {$colors['alter_text']};
}
.sc_edd_add_to_cart_default a,
.sc_edd_details a {
	color: {$colors['alter_link']};
}
.sc_edd_add_to_cart_default a:hover,
.sc_edd_details a:hover {
	color: {$colors['alter_hover']};
}
.edd_price_options ul > li > label > input[type="checkbox"] + span:before {
	border-color: {$colors['alter_bd_color']};
}
.single-download .edd_download_purchase_form .trx_addons_edd_purchase_subtotal {
	border-color: {$colors['alter_bd_color']};
}



/* CV */
.trx_addons_cv,
.trx_addons_cv_body_wrap {
	color: {$colors['alter_text']};
	background-color:{$colors['alter_bg_color']};
}
.trx_addons_cv a {
	color: {$colors['alter_link']};
}
.trx_addons_cv a:hover {
	color: {$colors['alter_hover']};
}

.trx_addons_cv_header {
	background-color: {$colors['bg_color']};
}
.trx_addons_cv_header_image img {
	border-color: {$colors['text_dark']};
}
.trx_addons_cv_header .trx_addons_cv_header_letter,
.trx_addons_cv_header .trx_addons_cv_header_text {
	color: {$colors['text_dark']};
}
.trx_addons_cv_header .trx_addons_cv_header_socials .social_item > .social_icon {
	color: {$colors['text_dark_07']};	
}
.trx_addons_cv_header .trx_addons_cv_header_socials .social_item:hover > .social_icon {
	color: {$colors['text_dark']};	
}

.trx_addons_cv_header_letter,
.trx_addons_cv_header_text,
.trx_addons_cv_header_socials .social_item > .social_icon {
	text-shadow: 1px 1px 6px {$colors['bg_color']};
}

.trx_addons_cv_tint_dark .trx_addons_cv_header_letter,
.trx_addons_cv_tint_dark .trx_addons_cv_header_text,
.trx_addons_cv_tint_dark .trx_addons_cv_header_socials .social_item > .social_icon {
	color: {$colors['bg_color']};	
	text-shadow: 1px 1px 3px {$colors['text_dark']};
}
.trx_addons_cv_tint_dark .trx_addons_cv_header_socials .social_item:hover > .social_icon {
	color: {$colors['text_hover']};	
}

.trx_addons_cv_navi_buttons .trx_addons_cv_navi_buttons_area .trx_addons_cv_navi_buttons_item {
	color: {$colors['alter_light']};
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['bg_color']};
}
.trx_addons_cv_navi_buttons .trx_addons_cv_navi_buttons_area .trx_addons_cv_navi_buttons_item_active,
.trx_addons_cv_navi_buttons .trx_addons_cv_navi_buttons_area .trx_addons_cv_navi_buttons_item:hover {
	color: {$colors['alter_dark']};
	border-color: {$colors['alter_bg_color']};
}


.trx_addons_cv .trx_addons_cv_section_title,
.trx_addons_cv .trx_addons_cv_section_title a {
	color: {$colors['alter_dark']};
}
.trx_addons_cv_section_title.ui-state-active {
	border-color: {$colors['alter_dark']};
}
.trx_addons_cv_section_content .trx_addons_tabs .trx_addons_tabs_titles li > a {
	color: {$colors['alter_light']};
}
.trx_addons_cv_section_content .trx_addons_tabs .trx_addons_tabs_titles li.ui-state-active > a,
.trx_addons_cv_section_content .trx_addons_tabs .trx_addons_tabs_titles li > a:hover {
	color: {$colors['alter_dark']};
}
.trx_addons_cv_section .trx_addons_pagination > * {
	color:{$colors['alter_text']};
}
.trx_addons_cv_section .trx_addons_pagination > a:hover {
	color: {$colors['alter_dark']};
}
.trx_addons_pagination > span.active {
	color: {$colors['alter_dark']};
	border-color: {$colors['alter_dark']};
}
.trx_addons_cv_breadcrumbs .trx_addons_cv_breadcrumbs_item {
	color: {$colors['alter_light']};
}
.trx_addons_cv_breadcrumbs a.trx_addons_cv_breadcrumbs_item:hover {
	color: {$colors['alter_dark']};
}
.trx_addons_cv_single .trx_addons_cv_single_title {
	color: {$colors['alter_dark']};
}
.trx_addons_cv_single .trx_addons_cv_single_subtitle {
	color: {$colors['alter_light']};
}

.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_2 .trx_addons_cv_resume_column:nth-child(2n+2) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_3 .trx_addons_cv_resume_column:nth-child(3n+2) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_3 .trx_addons_cv_resume_column:nth-child(3n+3) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_4 .trx_addons_cv_resume_column:nth-child(4n+2) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_4 .trx_addons_cv_resume_column:nth-child(4n+3) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_4 .trx_addons_cv_resume_column:nth-child(4n+4) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_2 .trx_addons_cv_resume_column:nth-child(2n+3) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_2 .trx_addons_cv_resume_column:nth-child(2n+4) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_3 .trx_addons_cv_resume_column:nth-child(3n+4) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_3 .trx_addons_cv_resume_column:nth-child(3n+5) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_3 .trx_addons_cv_resume_column:nth-child(3n+6) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_4 .trx_addons_cv_resume_column:nth-child(4n+5) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_4 .trx_addons_cv_resume_column:nth-child(4n+6) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_4 .trx_addons_cv_resume_column:nth-child(4n+7) .trx_addons_cv_resume_item,
.trx_addons_tabs_content_delimiter .trx_addons_cv_resume_columns_4 .trx_addons_cv_resume_column:nth-child(4n+8) .trx_addons_cv_resume_item {
	border-color: {$colors['alter_bd_color']};
}
.trx_addons_cv_resume_item_meta {
	color: {$colors['alter_dark']};
}
.trx_addons_cv_resume_item .trx_addons_cv_resume_item_title,
.trx_addons_cv_resume_item .trx_addons_cv_resume_item_title a {
	color: {$colors['alter_dark']};
}
.trx_addons_cv_resume_item .trx_addons_cv_resume_item_title a:hover {
	color: {$colors['alter_link']};
}
.trx_addons_cv_resume_item_subtitle {
	color: {$colors['alter_light']};
}
.trx_addons_cv_resume_style_skills .trx_addons_cv_resume_item_skills {
	color: {$colors['alter_dark']};
}
.trx_addons_cv_resume_style_skills .trx_addons_cv_resume_item_skill:after {
	border-color: {$colors['alter_dark']};
}
.trx_addons_cv_resume_style_education .trx_addons_cv_resume_item_number {
	color: {$colors['alter_light']};
}
.trx_addons_cv_resume_style_services .trx_addons_cv_resume_item_icon {
	color: {$colors['alter_dark']};
}
.trx_addons_cv_resume_style_services .trx_addons_cv_resume_item_icon:hover,
.trx_addons_cv_resume_style_services .trx_addons_cv_resume_item_text a:hover {
	color: {$colors['text_hover']};
}
.trx_addons_cv_resume_style_services .trx_addons_cv_resume_item_title > a:hover:after {
	border-color: {$colors['text_hover']};
}
.trx_addons_cv_resume_style_services .trx_addons_cv_resume_item_title > a:after {
	border-top-color: {$colors['alter_dark']};
}
.trx_addons_cv_resume_style_services .trx_addons_cv_resume_item_text a {
	color: {$colors['alter_dark']};
}

.trx_addons_cv_portfolio_item .trx_addons_cv_portfolio_item_title,
.trx_addons_cv_portfolio_item .trx_addons_cv_portfolio_item_title a {
	color: {$colors['alter_dark']};
}

.trx_addons_cv_testimonials_item .trx_addons_cv_testimonials_item_title,
.trx_addons_cv_testimonials_item .trx_addons_cv_testimonials_item_title a {
	color: {$colors['alter_dark']};
}

.trx_addons_cv_certificates_item .trx_addons_cv_certificates_item_title,
.trx_addons_cv_certificates_item .trx_addons_cv_certificates_item_title a {
	color: {$colors['alter_dark']};
}

/* Contact form */
.trx_addons_cv .trx_addons_contact_form .trx_addons_contact_form_title {
	color: {$colors['alter_dark']};
}
.trx_addons_cv .trx_addons_contact_form_field_title {
	color: {$colors['alter_dark']};
}
.trx_addons_contact_form .trx_addons_contact_form_field input[type="text"],
.trx_addons_contact_form .trx_addons_contact_form_field textarea {
	border-color: {$colors['alter_bd_color']};
	color: {$colors['alter_text']};
}
.trx_addons_contact_form .trx_addons_contact_form_field input[type="text"]:focus,
.trx_addons_contact_form .trx_addons_contact_form_field textarea:focus {
	background-color: {$colors['alter_bg_hover']};
	color: {$colors['alter_dark']};
}
.trx_addons_contact_form_field button {
	background-color: {$colors['alter_dark']};
	border-color: {$colors['alter_dark']};
	color: {$colors['bg_color']};
}
.trx_addons_contact_form_field button:hover {
	color: {$colors['alter_dark']};
}
.trx_addons_contact_form_info_icon {
	color: {$colors['alter_light']};
}
.trx_addons_contact_form_info_area {
	color: {$colors['alter_dark']};
}
.trx_addons_contact_form_info_item_phone .trx_addons_contact_form_info_data {
	color: {$colors['alter_dark']} !important;
}

/* Page About Me */
.trx_addons_cv_about_page .trx_addons_cv_single_title {
	color: {$colors['alter_dark']};
}


/* Additional attributes for Variations */
.trx_addons_attrib_item.trx_addons_attrib_button,
.trx_addons_attrib_item.trx_addons_attrib_image,
.trx_addons_attrib_item.trx_addons_attrib_color {
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color']};
}
.trx_addons_attrib_item.trx_addons_attrib_button:hover,
.trx_addons_attrib_item.trx_addons_attrib_image:hover,
.trx_addons_attrib_item.trx_addons_attrib_color:hover {
	border-color: {$colors['alter_bd_hover']};
	background-color: {$colors['alter_bg_hover']};
}
.trx_addons_attrib_item.trx_addons_attrib_selected {
	border-color: {$colors['alter_link']} !important;
	background-color: {$colors['alter_bg_hover']};
}
.trx_addons_attrib_item.trx_addons_attrib_disabled span:before,
.trx_addons_attrib_item.trx_addons_attrib_disabled span:after {
	background-color: {$colors['alter_hover']};
}


/* Range slider */
.trx_addons_range_slider_label_min {
	color: {$colors['alter_text']};
}
.trx_addons_range_slider_label_max {
	color: {$colors['alter_text']};
}
div.ui-slider {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['alter_bd_color']};
}
div.ui-slider .ui-slider-handle {
	border-color: {$colors['alter_bd_hover']};
	background-color: {$colors['alter_bg_hover']};
}
div.ui-slider .ui-slider-range {
	background-color: {$colors['alter_bg_hover']};
}


CSS;
		}

		return $css;
	}
}
