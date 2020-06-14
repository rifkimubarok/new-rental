<?php
/**
 * ThemeREX Shortcodes
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Define list with shortcodes
if (!function_exists('trx_addons_sc_setup')) {
	add_action( 'after_setup_theme', 'trx_addons_sc_setup', 2 );
	function trx_addons_sc_setup() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['sc_list'] = apply_filters('trx_addons_sc_list', array(
			'action' => array(
							'title' => __('Actions', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
								'simple' => esc_html__('Simple', 'trx_addons'),
								'event' => esc_html__('Event', 'trx_addons')
							)
						),
			'anchor' => array(
							'title' => __('Anchor', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons')
							)
						),
			'accordionposts' => array(
						'title' => __('Accordion of posts', 'trx_addons'),
						'layouts_sc' => array(
							'default' => esc_html__('Default', 'trx_addons')
						)
					),
			'blogger' => array(
							'title' => __('Blogger', 'trx_addons'),
							'layouts_sc' => array(

								'default' => esc_html__('Default', 'trx_addons'),
								'wide' => esc_html__('Wide', 'trx_addons'),
								'list' => esc_html__('List', 'trx_addons'),
								'news' => esc_html__('News', 'trx_addons'),
/*
								'default' => trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'blogger/type-default.png'),
								'list' => trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'blogger/type-list.png'),
*/
							),
							// Templates for each shortcode's layout:
							// Zones: 'featured' - info inside (over) the featured image
							//                     Over positions: 'tl|tc|tr'
							//                                     'ml|mc|mr'
							//                                     'bl|bc|br'
							//        'content'  - info after (under) the featured image
							//        'header'   - info before (above) the post body (featured image and content)
							//        'footer'   - info after (below) the post body (featured image and content)
							// Components: 'title'    - post's title
							//             'excerpt'  - post's content (depends from post format)
							//             'readmore' - button (link) to the single post (with theme-specific styles)
							//             'meta'     - post's meta (categories, date, author, views, comments, likes, rating, edit)
							//             'meta_xxx' - separate post's meta item from the list above
							'templates' => array(
								// Templates for layout "Default"
								'default' => array(
									'classic' => array(
										'title'  => __('Classic Grid', 'trx_addons'),
										'layout' => array(
											'featured' => array(
											),
											'content' => array(
												'meta_categories', 'title', 'meta', 'excerpt', 'readmore'
											)
										)
									),
									'classic_2' => array(
										'title'  => __('Classic with cats over image', 'trx_addons'),
										'layout' => array(
											'featured' => array(
												'bl' => array(
													'meta_categories'
												),
											),
											'content' => array(
												'title', 'meta', 'excerpt', 'readmore'
											)
										)
									),
									'classic_3' => array(
										'title'  => __('Classic with header above', 'trx_addons'),
										'layout' => array(
											'header' => array(
												'title', 'meta'
											),
											'featured' => array(
												'bl' => array(
													'meta_views'
												),
											),
											'content' => array(
												'excerpt', 'readmore'
											)
										)
									),
									'over_centered' => array(
										'title'  => __('Info over image', 'trx_addons'),
										'layout' => array(
											'featured' => array(
												'br' => array(
													'meta_date'
												),
												'mc' => array(
													'meta_categories', 'title', 'meta'
												),
												'tr' => array(
													'price'
												),
											),
										)
									),
									'over_bottom' => array(
										'title'  => __('Info over image (bottom)', 'trx_addons'),
										'layout' => array(
											'featured' => array(
												'bc' => array(
													'meta_categories', 'title', 'meta'
												),
												'tr' => array(
													'price'
												),
											),
										)
									),
								),
								// Templates for layout "Wide"
								'wide' => array(
									'default' => array(
										'title'  => __('Default', 'trx_addons'),
										'layout' => array(
											'header' => array(
												'title', 'meta'
											),
											'featured' => array(
											),
											'content' => array(
												'excerpt'
											)
										)
									),
								),
								// Templates for layout "List"
								'list' => array(
									'simple' => array(
										'title'  => __('Simple', 'trx_addons'),
										'layout' => array(
											'content' => array(
												'meta_categories', 'title', 'meta'
											)
										)
									),
									'with_image' => array(
										'title'  => __('With image', 'trx_addons'),
										'layout' => array(
											'featured' => array(
											),
											'content' => array(
												'meta_categories', 'title', 'meta'
											)
										)
									),
								),
								// Templates for layout "News"
								'news' => array(
									'announce' => array(
										'title' => __('Announce', 'trx_addons'),
										'grid'  => array(
											// One post
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
												)
											),
											// Two posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
												)
											),
											// Three posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
												)
											),
											// Four posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
												)
											),
											// Five posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
												)
											),
											/*
											// Six posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
												)
											),
											// Seven posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
												)
											),
											// Eight posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
													array(
														'template' => 'default/over_centered',
														'args' => array( 'image_ratio' => '16:9', 'columns' => 1 )
													),
												)
											),
											*/
										)
									),
									'magazine' => array(
										'title' => __('Magazine', 'trx_addons'),
										'grid'  => array(
											// One post
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/classic'
													),
												)
											),
											// Two posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/classic',
														'args' => array( 'image_position' => 'top' )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
												)
											),
											// Three posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/classic',
														'args' => array( 'image_position' => 'top' )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
												)
											),
											// Four posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/classic',
														'args' => array( 'image_position' => 'top' )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
												)
											),
											// Five posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/classic',
														'args' => array( 'image_position' => 'top' )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
												)
											),
											// Six posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/classic',
														'args' => array( 'image_position' => 'top' )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
												)
											),
											// Seven posts
											array(
												'grid-layout' => array(
													array(
														'template' => 'default/classic',
														'args' => array( 'image_position' => 'top' )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
													array(
														'template' => 'list/with_image',
														'args' => array( 'image_position' => 'left', 'image_width' => 33 )
													),
												)
											),
										)
									)
								)
							),
						),
			'button' => array(
							'title' => __('Button', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
								'bordered' => esc_html__('Bordered', 'trx_addons'),
								'simple' => esc_html__('Simple', 'trx_addons')
							),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'content' => array(
							'title' => __('Content', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
							),
							// Always enabled!!!
							'std' => 1,
							'hidden' => true
						),
			'countdown' => array(
							'title' => __('Countdown', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
								'circle' => esc_html__('Circle', 'trx_addons')
							)
						),
			'form' => array(
							'title' => __('Forms', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
								'modern' => esc_html__('Modern', 'trx_addons'),
								'detailed' => esc_html__('Detailed', 'trx_addons')
							),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'googlemap' => array(
							'title' => __('Google map', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
								'detailed' => esc_html__('Detailed', 'trx_addons')
							),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'icons' => array(
							'title' => __('Icons', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
								'modern' => esc_html__('Modern', 'trx_addons')
							)
						),
			'price' => array(
							'title' => __('Price block', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
							)
						),
			'promo' => array(
							'title' => __('Promo', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
								'modern' => esc_html__('Modern', 'trx_addons'),
								'blockquote' => esc_html__('Blockquote', 'trx_addons')
							)
						),
			'skills' => array(
							'title' => __('Skills', 'trx_addons'),
							'layouts_sc' => array(
								'pie' => esc_html__('Pie', 'trx_addons'),
								'counter' => esc_html__('Counter', 'trx_addons')
							)
						),
			'supertitle' => array(
							'title' => __('Super title', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons')
							)
						),
			'socials' => array(
							'title' => __('Socials', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Only icons', 'trx_addons'),
								'names' => esc_html__('Only names', 'trx_addons'),
								'icons_names' => esc_html__('Icon + name', 'trx_addons')
							),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'table' => array(
							'title' => __('Table', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
							)
						),
			'title' => array(
							'title' => __('Title', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
								'shadow' => esc_html__('Shadow', 'trx_addons'),
								'accent' => esc_html__('Accent', 'trx_addons'),
								'gradient' => esc_html__('Gradient', 'trx_addons'),
							),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'yandexmap' => array(
							'title' => __('Yandex map', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
								'detailed' => esc_html__('Detailed', 'trx_addons')
							),
							// Always enabled!!!
							'hidden' => false
						),
			)
		);
	}
}

// Include files with shortcodes
if (!function_exists('trx_addons_sc_load')) {
	add_action( 'after_setup_theme', 'trx_addons_sc_load', 6 );
	function trx_addons_sc_load() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		global $TRX_ADDONS_STORAGE;
		if (is_array($TRX_ADDONS_STORAGE['sc_list']) && count($TRX_ADDONS_STORAGE['sc_list']) > 0) {
			foreach ($TRX_ADDONS_STORAGE['sc_list'] as $sc=>$params) {
				if (trx_addons_components_is_allowed('sc', $sc)
					&& ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_SHORTCODES . "{$sc}/{$sc}.php")) != '') { 
					include_once $fdir;
				}
			}
		}
	}
}

// Add 'Shortcodes' block in the ThemeREX Addons Components
if (!function_exists('trx_addons_sc_components')) {
	add_filter( 'trx_addons_filter_components_blocks', 'trx_addons_sc_components');
	function trx_addons_sc_components($blocks=array()) {
		$blocks['sc'] = __('Shortcodes', 'trx_addons');
		return $blocks;
	}
}

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_load_scripts_front');
	function trx_addons_sc_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'shortcodes.css'), array(), null );
			wp_enqueue_script( 'trx_addons-sc', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'shortcodes.js'), array('jquery'), null, true );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_sc_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_load_responsive_styles', 2000);
	function trx_addons_sc_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'shortcodes.responsive.css'), array(), null );
		}
	}
}

// Merge shortcode's specific styles to the single stylesheet
if ( !function_exists( 'trx_addons_sc_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_merge_styles');
	function trx_addons_sc_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'shortcodes.css';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_merge_styles_responsive');
	function trx_addons_sc_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'shortcodes.responsive.css';
		return $list;
	}
}

	
// Merge shortcode's specific scripts to the single file
if ( !function_exists( 'trx_addons_sc_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_merge_scripts');
	function trx_addons_sc_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'shortcodes.js';
		return $list;
	}
}


// Add common atts like 'id', 'cls'', 'css', title params, etc. to the shortcode's atts
if (!function_exists('trx_addons_sc_common_atts')) {
	function trx_addons_sc_common_atts($common, $atts) {
		if (!is_array($common)) {
			$common = explode(',', $common);
		}
		if ( in_array('id', $common) ) {
			$atts = array_merge($atts, array(
				"id" => "",
				"class" => "",
				"className" => "",	// Alter name for 'class' in Gutenberg
				"css" => ""
			));
		}
		if ( in_array('title', $common) ) {
			$atts = array_merge($atts, array(
				"title" => "",
				"title_align" => "left",
				"title_style" => "default",
				"title_tag" => '',
				"title_color" => '',
				"title_color2" => '',
				"gradient_direction" => '',
				"subtitle" => "",
				"subtitle_align" => "none",
				"subtitle_position" => trx_addons_get_setting('subtitle_above_title') ? 'above' : 'below',
				"description" => "",
				"link" => '',
				"link_style" => 'default',
				"link_image" => '',
				"link_text" => esc_html__('Learn more', 'trx_addons'),
				"new_window" => 0,
				"typed" => 0,
				"typed_strings" => '',
				"typed_loop" => 1,
				"typed_cursor" => 1,
				"typed_cursor_char" => '|',
				"typed_color" => '',
				"typed_speed" => 6,
				"typed_delay" => 1
			));
		}
		if ( in_array('slider', $common) ) {
			$atts = array_merge($atts, array(
				"slider" => 0,
				"slider_pagination" => "none",
				"slider_pagination_type" => "bullets",
				"slider_pagination_thumbs" => 0,
				"slider_controls" => "none",
				"slides_space" => 0,
				"slides_centered" => 0,
				"slides_overflow" => 0,
				"slider_mouse_wheel" => 0,
				"slider_autoplay" => 1,
			));
		}
		if ( in_array('query', $common) ) {
			$atts = array_merge($atts, array(
				"cat" => "",
				"columns" => "",
				"columns_tablet" => "",
				"columns_mobile" => "",
				"count" => 3,
				"offset" => 0,
				"orderby" => '',
				"order" => '',
				"ids" => '',
			));
		}
		if ( in_array('icon', $common) ) {
			$atts = array_merge($atts, array(
				"icon_type" => '',
				"icon_fontawesome" => "",
				"icon_openiconic" => "",
				"icon_typicons" => "",
				"icon_entypo" => "",
				"icon_linecons" => "",
				"icon" => "",
			));
		}
		if ( in_array('hide', $common) ) {
			$atts = array_merge($atts, array(
				"hide_on_wide" => "0",
				"hide_on_desktop" => "0",
				"hide_on_notebook" => "0",
				"hide_on_tablet" => "0",
				"hide_on_mobile" => "0",
				"hide_on_frontpage" => "0",
				"hide_on_singular" => "0",
				"hide_on_other" => "0",
			));
		}
		return $atts;
	}
}


// Prepare Id, custom CSS and other parameters in the shortcode's atts
if (!function_exists('trx_addons_sc_prepare_atts')) {
	function trx_addons_sc_prepare_atts($sc, $atts, $defa) {
		// Push shortcode name to the stack
		trx_addons_sc_stack_push($sc);
		// Add 'xxx_extra' to the default params (its original Elementor's params)
		if (is_array($atts)) {
			foreach($atts as $k=>$v) {
				if (substr($k, -6) == '_extra' && !isset($defa[$k])) $defa[$k] = $v;
			}
		}
		// Merge atts with default values
		$atts = trx_addons_html_decode(shortcode_atts(apply_filters('trx_addons_sc_atts', $defa, $sc), $atts));
		// Unsafe item description
		if (!empty($atts['description']) && function_exists('vc_value_from_safe'))
			$atts['description'] = trim( vc_value_from_safe( $atts['description'] ) );
		// Generate id (if empty)
		if (empty($atts['id'])) {
			$atts['id'] = str_replace('trx_', '', $sc) . '_' . str_replace('.', '', mt_rand());
		}
		// Add custom CSS class
		if (!empty($atts['css'])
			&& (trx_addons_sc_stack_check('show_layout_vc') || strpos($atts['css'], '.vc_custom_') !== false)
			&& defined('VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG')
			&& function_exists('vc_shortcode_custom_css_class')
		) {
			$atts['class'] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
											(!empty($atts['class']) ? $atts['class'] . ' ' : '') . vc_shortcode_custom_css_class( $atts['css'], ' ' ),
											$sc,
											$atts);
			$atts['css'] = '';
		}
		// Copy className to class
		if (!empty($atts['className'])) {
			$atts['class'] = (!empty($atts['class']) ? $atts['class'] . ' ' : '') . $atts['className'];
		}
 		return apply_filters('trx_addons_filter_sc_prepare_atts', $atts, $sc);
	}
}

// After all handlers are finished - pop sc from the stack
if (!function_exists('trx_addons_sc_output_finish')) {
	add_filter('trx_addons_sc_output', 'trx_addons_sc_output_finish', 9999, 4);
	function trx_addons_sc_output_finish($output='', $sc='', $atts='', $content='') {
		trx_addons_sc_stack_pop($sc);
		return $output;
	}
}

// Push shortcode name to the stack
if (!function_exists('trx_addons_sc_stack_push')) {
	function trx_addons_sc_stack_push($sc) {
		global $TRX_ADDONS_STORAGE;
		array_push($TRX_ADDONS_STORAGE['sc_stack'], $sc);
	}
}

// Pop shortcode name from the stack
if (!function_exists('trx_addons_sc_stack_pop')) {
	function trx_addons_sc_stack_pop() {
		global $TRX_ADDONS_STORAGE;
		return array_pop($TRX_ADDONS_STORAGE['sc_stack']);
	}
}

// Check if shortcode name is in the stack
if (!function_exists('trx_addons_sc_stack_check')) {
	function trx_addons_sc_stack_check($sc=false) {
		global $TRX_ADDONS_STORAGE;
		return is_array( $TRX_ADDONS_STORAGE['sc_stack'] )
				? ( ! empty( $sc )
					? in_array( $sc, $TRX_ADDONS_STORAGE['sc_stack'] )
					: count( $TRX_ADDONS_STORAGE['sc_stack'] ) > 0
					)
				: false;
	}
}


// Shortcodes parts
//---------------------------------------

// Enqueue iconed fonts
if (!function_exists('trx_addons_load_icons')) {
	function trx_addons_load_icons($list='') {
		if (!empty($list) && function_exists('vc_icon_element_fonts_enqueue')) {
			$list = explode(',', $list);
			foreach ($list as $icon_type)
				vc_icon_element_fonts_enqueue($icon_type);
		}
	}
}

// Display title, subtitle and description for some shortcodes
if (!function_exists('trx_addons_sc_show_titles')) {
	function trx_addons_sc_show_titles($sc, $args, $size='') {
		trx_addons_get_template_part('templates/tpl.sc_titles.php',
										'trx_addons_args_sc_show_titles',
										compact('sc', 'args', 'size')
									);
	}
}

// Return tabs for the filters header for some shortcodes
// Attention! Array $args passed by reference because it can be modified in this function
if (!function_exists('trx_addons_sc_get_filters_tabs')) {
	function trx_addons_sc_get_filters_tabs($sc, &$args) {
		$tabs = array();
		if ( !empty($args['show_filters']) ) {
			if (!empty($args['filters_ids']) && count($args['filters_ids']) > 0) {
				foreach ($args['filters_ids'] as $ids_filter) {
					$term = get_term_by( $ids_filter > 0 ? 'id' : 'name', $ids_filter, $args['filters_taxonomy'] );
					if ($term) {
						$tabs[$term->term_id] = apply_filters('trx_addons_extended_taxonomy_name', $term->name, $term);
					}
				}
			} else {
				$only_children = $args['filters_taxonomy'] == $args['taxonomy'];	// && !empty($args['cat'])
				$tabs = $args['filters_taxonomy'] == 'category' && !$only_children
					? trx_addons_get_list_categories()
					: trx_addons_get_list_terms(false, $args['filters_taxonomy'], $only_children ? array('parent' => $args['cat']) : array());
			}

			if (count($tabs) > 0) {
				if (empty($args['filters_active'])) {
					$args['filters_active'] = !empty($args['filters_all']) ? 0 : trx_addons_array_get_first($tabs);
				}
			}
		}
		return $tabs;
	}
}

// Display filters header (title, subtitle and tabs) for some shortcodes
if (!function_exists('trx_addons_sc_show_filters')) {
	function trx_addons_sc_show_filters($sc, $args, $tabs) {
		trx_addons_get_template_part('templates/tpl.sc_filters.php',
										'trx_addons_args_sc_show_filters',
										compact('sc', 'args', 'tabs')
									);
	}
}

// Display pagination buttons for some shortcodes
if (!function_exists('trx_addons_sc_show_pagination')) {
	function trx_addons_sc_show_pagination($sc, $args, $query) {
		trx_addons_get_template_part('templates/tpl.sc_pagination.php',
										'trx_addons_args_sc_pagination',
										compact('sc', 'args', 'query')
									);
	}
}

// Display link button or image for some shortcodes
if (!function_exists('trx_addons_sc_show_links')) {
	function trx_addons_sc_show_links($sc, $args) {
		trx_addons_get_template_part('templates/tpl.sc_links.php',
										'trx_addons_args_sc_show_links',
										compact('sc', 'args')
									);
	}
}

// Show post meta block: post date, author, categories, views, comments, likes, rating, etc.
if ( !function_exists('trx_addons_sc_show_post_meta') ) {
	function trx_addons_sc_show_post_meta($sc, $args=array()) {
		$args = array_merge(array(
			'components' => '',	//categories,tags,date,author,views,comments,likes,rating,share,edit
			'share_type' => 'drop',
			'seo' => false,
			'date_format' => '',
			'theme_specific' => true,
			'class' => '',
			'echo' => true
			), $args);
		if (($meta = apply_filters('trx_addons_filter_post_meta', '', array_merge($args, array('sc'=>$sc, 'echo'=>false)))) != '') {
			if (!empty($args['echo'])) trx_addons_show_layout($meta);
			else return $meta;
		} else {
			if (empty($args['echo'])) ob_start();
			trx_addons_get_template_part('templates/tpl.sc_post_meta.php',
											'trx_addons_args_sc_show_post_meta',
											compact('sc', 'args')
										);
			if (empty($args['echo'])) {
				$meta = ob_get_contents();
				ob_end_clean();
				return $meta;
			}
		}
	}
}

// Display begin of the slider layout for some shortcodes
if (!function_exists('trx_addons_sc_show_slider_wrap_start')) {
	function trx_addons_sc_show_slider_wrap_start($sc, $args) {
		trx_addons_get_template_part('templates/tpl.sc_slider_start.php',
										'trx_addons_args_sc_show_slider_wrap',
										apply_filters('trx_addons_filter_sc_show_slider_args', compact('sc', 'args'))
									);
	}
}

// Display end of the slider layout for some shortcodes
if (!function_exists('trx_addons_sc_show_slider_wrap_end')) {
	function trx_addons_sc_show_slider_wrap_end($sc, $args) {
		trx_addons_get_template_part('templates/tpl.sc_slider_end.php',
										'trx_addons_args_sc_show_slider_wrap', 
										apply_filters('trx_addons_filter_sc_show_slider_args', compact('sc', 'args'))
									);
	}
}


// AJAX Pagination in the shortcodes
//------------------------------------------
if ( !function_exists( 'trx_addons_ajax_sc_pagination' ) ) {
	add_action('wp_ajax_trx_addons_item_pagination',		'trx_addons_ajax_sc_pagination');
	add_action('wp_ajax_nopriv_trx_addons_item_pagination',	'trx_addons_ajax_sc_pagination');
	function trx_addons_ajax_sc_pagination() {

		if ( !wp_verify_nonce( trx_addons_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
	
		$response = array('error'=>'', 'data'=>'', 'css' => '');

		$params = trx_addons_unserialize(wp_unslash($_POST['params']));
		$params['page'] = $_POST['page'];
		if (!empty($_POST['filters_active'])) {
			$params['filters_active'] = $_POST['filters_active'];
		}

		$func_name = 'trx_addons_' . $params['sc'];

		if ( (
				trx_addons_components_is_allowed('sc', str_replace('sc_', '', $params['sc']))
				||
				trx_addons_components_is_allowed('cpt', str_replace('sc_', '', $params['sc']))
				||
				trx_addons_components_is_allowed('widgets', str_replace('sc_widget_', '', $params['sc']))
			)
			&& function_exists($func_name)
		) {
			$response['data'] = call_user_func($func_name, $params);
			$response['css'] = apply_filters('trx_addons_filter_inline_css', trx_addons_get_inline_css());
		} else {
			$response['error'] = esc_html__('Unknown shortcode!', 'trx_addons');
		}

		echo json_encode($response);
		die();
	}
}


// Add Gutenberg support
if ( trx_addons_exists_gutenberg() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'shortcodes-gutenberg.php';
}
