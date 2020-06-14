<?php
/**
 * The style "default" of the Anchor
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_anchor');
$atts = array(
	'class'			=> "sc_anchor sc_anchor_{$args['type']}",
	'data-vc-icon'	=> $args['icon'],
	'data-url'		=> $args['url']
);
?><a id="sc_anchor_<?php echo esc_attr($args['id']); ?>"
	title="<?php echo esc_attr($args['title']); ?>" <?php
	foreach ($atts as $k=>$v)
		echo " {$k}=\"{$v}\"";
?>></a>