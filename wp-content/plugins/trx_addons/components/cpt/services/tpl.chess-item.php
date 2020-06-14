<?php
/**
 * The style "chess" of the Services item
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.13
 */

$args = get_query_var('trx_addons_args_sc_services');
if (empty($args['id'])) $args['id'] = 'sc_services_'.str_replace('.', '', mt_rand());

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
if (!is_array($meta)) $meta = array();
$meta['price'] = apply_filters( 'trx_addons_filter_custom_meta_value', !empty($meta['price']) ? $meta['price'] : '', 'price' );

$link = empty($args['no_links'])
			? (!empty($meta['link']) ? $meta['link'] : get_permalink())
			: '';

if (!empty($args['slider'])) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'], !empty($args['columns_tablet']) ? $args['columns_tablet'] : '', !empty($args['columns_mobile']) ? $args['columns_mobile'] : '')); ?> "><?php
}
?>
<div data-post-id="<?php the_ID(); ?>" <?php post_class( apply_filters( 'trx_addons_filter_services_item_class',
			'sc_services_item'
			. (empty($post_link) ? ' no_links' : '')
			. (isset($args['hide_excerpt']) && $args['hide_excerpt'] ? ' without_content' : ' with_content'),
			$args )
			);
	trx_addons_add_blog_animation('services', $args);
	if (!empty($args['popup'])) {
		?> data-post_id="<?php echo esc_attr(get_the_ID()); ?>"<?php
		?> data-post_type="<?php echo esc_attr(TRX_ADDONS_CPT_SERVICES_PT); ?>"<?php
	}
?>><?php
	do_action( 'trx_addons_action_services_item_start', $args );
	trx_addons_get_template_part('templates/tpl.featured.php',
									'trx_addons_args_featured',
									apply_filters('trx_addons_filter_args_featured', array(
												'class' => 'sc_services_item_header',
												'show_no_image' => true,
												'no_links' => empty($link),
												'link' => $link,
												'thumb_bg' => true,
												'thumb_size' => apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('masonry-big'), 'services-chess')
												),
												'services-chess'
												)
								);
	do_action( 'trx_addons_action_services_item_after_featured', $args );
	?>
	<div class="sc_services_item_content">
		<?php
		do_action( 'trx_addons_action_services_item_content_start', $args );
		$title_tag = 'h6';
		if ($args['columns'] == 1) $title_tag = 'h4';
		?>
		<<?php echo esc_attr($title_tag); ?> class="sc_services_item_title<?php if (!empty($meta['price'])) echo ' with_price'; ?>"><?php
			if (!empty($link)) {
				?><a href="<?php echo esc_url($link); ?>"<?php if (!empty($meta['link'])) echo ' target="_blank"'; ?>><?php
			}
			the_title();
			// Price
			if (!empty($meta['price'])) {
				?><div class="sc_services_item_price"><?php trx_addons_show_layout($meta['price']); ?></div><?php
			}
			if (!empty($link)) {
				?></a><?php
			}
		?></<?php echo esc_attr($title_tag); ?>>
		<?php do_action( 'trx_addons_action_services_item_after_title', $args ); ?>
		<div class="sc_services_item_subtitle"><?php
			$terms = trx_addons_get_post_terms(', ', get_the_ID(), trx_addons_get_post_type_taxonomy());
			if (empty($link)) $terms = trx_addons_links_to_span($terms);
			trx_addons_show_layout($terms);
		?></div>
		<?php do_action( 'trx_addons_action_services_item_after_subtitle', $args ); ?>
		<?php if (!isset($args['hide_excerpt']) || $args['hide_excerpt']==0) { ?>
			<div class="sc_services_item_text"><?php the_excerpt(); ?></div>
		<?php } ?>
		<?php do_action( 'trx_addons_action_services_item_content_end', $args ); ?>
	</div>
</div>
<?php
if (!empty($args['slider']) || $args['columns'] > 1) {
	?></div><?php
}
