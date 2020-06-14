<?php
/**
 * The template to display shortcode's filters header (title, subtitle and tabs)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.54
 */

extract(get_query_var('trx_addons_args_sc_show_filters'));

$sc_blogger_filters_ajax = true;
$sc_blogger_filters_id = 'blogger_filters';
$args['sc'] = 'sc_blogger';

if (!empty($args['filters_title']) || !empty($args['filters_subtitle']) || count($tabs) > 0 ) {
	?><div class="sc_item_filters sc_blogger_filters sc_blogger_tabs sc_blogger_tabs_ajax<?php
		echo ' sc_item_filters_align_'.esc_attr($args['filters_title_align']);
	?>" data-params="<?php echo esc_attr(serialize($args)); ?>"><?php
		if (!empty($args['filters_title']) || !empty($args['filters_subtitle']) || ($args['filters_title_align'] == 'left' && count($tabs) > 0) ) {
			?><div class="sc_item_filters_header"><?php
				if (!empty($args['filters_title'])) {
					?><h3 class="sc_item_filters_title"><?php echo esc_html($args['filters_title']); ?></h3><?php
				}
				if (!empty($args['filters_subtitle'])) {
					?><h5 class="sc_item_filters_subtitle"><?php echo esc_html($args['filters_subtitle']); ?></h5><?php
				}
			?></div><?php
		}
		if (count($tabs) > 0) {
			?>
			<ul class="sc_item_filters_tabs"><?php
				// Add "All" tab
				if (!empty($args['filters_all'])) {
					$sc_bloggertitle = empty($args['filters_all_text']) ? esc_html__('All','trx_addons') : $args['filters_all_text'];
					$sc_bloggerid = 'all';
					?><li><a href="<?php echo esc_url(trx_addons_get_hash_link(sprintf('#%s_%s_content', $sc_blogger_filters_id, $sc_bloggerid))); ?>"
						class="sc_item_filters_all<?php echo($args['filters_active'] == $sc_bloggerid ? ' active' : ''); ?>"
						data-tab="<?php echo esc_attr($sc_bloggerid); ?>"
						data-page="1"><?php
							echo($sc_bloggertitle);
					?></a></li><?php
				}
				foreach ($tabs as $sc_bloggerid => $sc_bloggertitle) {
					?><li><a href="<?php echo esc_url(trx_addons_get_hash_link(sprintf('#%s_%s_content', $sc_blogger_filters_id, $sc_bloggerid))); ?>"
						<?php echo ($args['filters_active'] == $sc_bloggerid ? ' class="active"' : '' );?>
						data-tab="<?php echo esc_attr($sc_bloggerid); ?>"
						data-page="1"><?php
							echo trx_addons_sc_blogger_remove_terms_counter($sc_bloggertitle);
					?></a></li><?php
				}
				?>
			</ul><?php
		} else if ( !empty($args['filters_more_text']) && (!empty($args['filters_title']) || !empty($args['filters_subtitle'])) ) {
			$link = (int) $args['cat'] > 0 && ! empty( $args['taxonomy'] )
						? get_term_link( (int)$args['cat'], $args['taxonomy'] )
						: ( !empty( $args['post_type'] )
							? get_post_type_archive_link( $args['post_type'] )
							: home_url( '/' )
							);
			?><div class="sc_item_filters_tabs sc_item_filters_more_link_wrap">
				<a href="<?php echo esc_url( $link ); ?>" class="sc_item_filters_more_link sc_button sc_button_simple"><?php
					echo esc_html($args['filters_more_text']);
				?></a>
			</div><?php
		}
		?>
	</div><?php
}
