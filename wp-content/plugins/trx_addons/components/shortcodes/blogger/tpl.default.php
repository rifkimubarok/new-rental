<?php
/**
 * The style "default" of the Blogger
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_blogger');

$templates = trx_addons_components_get_allowed_templates('sc', 'blogger');
$template  = isset($templates[$args['type']][$args['template_'.$args['type']]])
				? $templates[$args['type']][$args['template_'.$args['type']]]
				: $templates['default']['classic'];

$posts_in_grid = isset($template['grid']) ? count($template['grid']) : 0;

$query_args = array(
// Attention! Parameter 'suppress_filters' is damage WPML-queries!
//	'suppress_filters' => true,
	'post_status' => 'publish',
	'ignore_sticky_posts' => true
);

// Posts per page
if (empty($args['ids'])) {
	$query_args['posts_per_page'] = $args['count'];
	if ( !trx_addons_is_off($args['pagination']) && $args['page'] > 1 ) {
		$query_args['paged'] = $args['page'];
	} else {
		$query_args['offset'] = $args['offset'];
	}
}

// Post type
$query_args = trx_addons_query_add_posts_and_cats($query_args, $args['ids'], $args['post_type']);

// Sort order
$query_args = trx_addons_query_add_sort_order($query_args, $args['orderby'], $args['order']);

// Filters
$tabs = trx_addons_sc_get_filters_tabs('sc_blogger', $args);
if (count($tabs) > 0 && !empty($args['filters_active']) && $args['filters_active'] != 'all') {
	$query_args = trx_addons_query_add_posts_and_cats($query_args, '', '', $args['filters_active'], $args['filters_taxonomy']);
} else {
	$query_args = trx_addons_query_add_posts_and_cats($query_args, '', '', $args['cat'], $args['taxonomy']);
}

// Get posts
$query = new WP_Query( $query_args );
if ( $query->found_posts > 0 || count($tabs) > 0 ) {
	$posts_count = ($args['count'] > $query->found_posts) ? $query->found_posts : $args['count'];
	if ($args['columns'] < 1) $args['columns'] = $posts_count;
	$args['columns'] = $posts_in_grid > 0 ? max(1, min(3, (int) $args['columns'])) : max(1, min(12, (int) $args['columns']));
	if (!empty($args['columns_tablet'])) $args['columns_tablet'] = $posts_in_grid > 0 ? max(1, min(3, (int) $args['columns_tablet'])) : max(1, min(12, (int) $args['columns_tablet']));
	if (!empty($args['columns_mobile'])) $args['columns_mobile'] = $posts_in_grid > 0 ? max(1, min(3, (int) $args['columns_mobile'])) : max(1, min(12, (int) $args['columns_mobile']));
	$args['slider'] = $args['slider'] > 0 && ($posts_in_grid > 0 ? $posts_count > $posts_in_grid : $posts_count > $args['columns']);
	$args['slides_space'] = max(0, (int) $args['slides_space']);
	if (empty($args['template_' . $args['type']])) {
		$args['template_' . $args['type']] = 'default';
	}
	?><div <?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?>
		class="sc_blogger sc_blogger_<?php
			echo esc_attr($args['type']);
			echo ' sc_blogger_' . esc_attr($args['type']) . '_' . esc_attr($args['template_' . $args['type']]);
			if ( ! empty($args['class']) ) echo ' '.esc_attr($args['class']); 
			?>"<?php
		if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
		?>><?php

		// Show titles
		trx_addons_sc_show_titles('sc_blogger', $args);
		
		// Show filters
		trx_addons_sc_show_filters('sc_blogger', $args, $tabs);

		// Shortcode's wrapper
		if ($args['slider']) {
			$args['slides_min_width'] = 220;
			trx_addons_sc_show_slider_wrap_start('sc_blogger', $args);
		} else if ($posts_in_grid == 0 && $args['columns'] > 1 && empty($args['posts_container'])) {
			if ($args['image_ratio'] == 'masonry') {
				do_action( 'trx_addons_action_load_masonry_scripts' );
				?><div class="sc_blogger_masonry_wrap sc_item_masonry sc_item_posts_container masonry_wrap masonry_<?php echo esc_attr($args['columns']); ?>"><?php
			} else {
				?><div class="sc_blogger_columns_wrap sc_item_columns sc_item_posts_container <?php
					echo esc_attr(trx_addons_get_columns_wrap_class());
					if ($args['type'] != 'plain') {
						echo ' columns_padding_bottom'
							. esc_attr( trx_addons_add_columns_in_single_row( $args['columns'], $query ) );
					}
				?>"><?php
			}
		} else {
			?><div class="sc_blogger_content sc_item_content sc_item_posts_container<?php if (!empty($args['posts_container'])) echo ' '.esc_attr($args['posts_container']); ?>"><?php
		}	
		$args['item_number'] = 0;
		$posts_rest = $posts_count;
		while ( $query->have_posts() ) { $query->the_post();
			$args['item_number']++;
			$args_orig = $args;		// Save original shortcode's agruments
			if ( $posts_in_grid > 0 ) {
				if (($args['item_number'] - 1) % $posts_in_grid == 0 ) {
					$posts_rest = $posts_count - $args['item_number'] + 1;
				}
				$grid_num = min( $posts_rest, $posts_in_grid );
				$grid_subnum = ($args['item_number'] - 1) % $posts_in_grid;
				$grid_layout = explode('/', str_replace(' ', '', $template['grid'][$grid_num-1]['grid-layout'][$grid_subnum]['template']));
				$args['grid'] = $posts_in_grid;
				$args['type'] = $grid_layout[0];
				$args['template_'.$grid_layout[0]] = $grid_layout[1];
				if ( !empty($template['grid'][$grid_num-1]['grid-layout'][$grid_subnum]['args']) ) {
					$args = array_merge( $args, $template['grid'][$grid_num-1]['grid-layout'][$grid_subnum]['args'] );
				}
				if (($args['item_number'] - 1) % $posts_in_grid == 0 ) {
					if ($args['item_number'] > 1) {
						?></div><?php
						if ( $args['slider'] ) {
							?></div><?php
						}
					}
					if ( $args['slider'] ) {
						?><div class="slider-slide swiper-slide"><?php
					}
					?><div class="sc_blogger_grid_wrap sc_blogger_grid_<?php
						echo esc_attr( $grid_num );
						if ($args['columns'] > 1) {
						 	echo ' sc_blogger_grid_columns_' . esc_attr( $args['columns'] );
						}
					?>"><?php
				}
			}
			if ( !apply_filters('trx_addons_filter_sc_blogger_template', false, $args) ) {
				$args['item_number'] += !trx_addons_is_off($args['pagination']) && $args['page'] > 1 ? ( $args['page'] - 1 ) * $args['count'] : 0;
				trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'blogger/tpl.'.trx_addons_esc($args['type']).'-item.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'blogger/tpl.default-item.php'
											),
											'trx_addons_args_sc_blogger', 
											$args
										);
			}
			$args = $args_orig;		// Restore original shortcode's arguments
		}

		wp_reset_postdata();

		if ( $posts_in_grid > 0 ) {
			?></div><?php
			if ($args['slider']) {
				?></div><?php
			}
		}

		?></div><?php

		if ($args['slider']) {
			trx_addons_sc_show_slider_wrap_end('sc_blogger', $args);
		}

		trx_addons_sc_show_pagination('sc_blogger', $args, $query);

		trx_addons_sc_show_links('sc_blogger', $args);

	?></div><?php
}
