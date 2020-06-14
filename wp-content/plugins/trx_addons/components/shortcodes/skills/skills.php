<?php
/**
 * Shortcode: Skills
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_skills_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_skills_load_scripts_front');
	function trx_addons_sc_skills_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))){
			wp_enqueue_style( 'trx_addons-sc_skills', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.css'), array(), null );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_sc_skills_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_skills_load_responsive_styles', 2000);
	function trx_addons_sc_skills_load_responsive_styles() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-sc_skills-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.responsive.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_skills_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_skills_merge_styles');
	function trx_addons_sc_skills_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.css';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_skills_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_skills_merge_styles_responsive');
	function trx_addons_sc_skills_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.responsive.css';
		return $list;
	}
}

	
// Merge skills specific scripts into single file
if ( !function_exists( 'trx_addons_sc_skills_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_skills_merge_scripts');
	function trx_addons_sc_skills_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.js';
		return $list;
	}
}


// Load shortcode's specific scripts if current mode is Preview in the PageBuilder
if ( !function_exists( 'trx_addons_sc_skills_load_scripts' ) ) {
	add_action("trx_addons_action_pagebuilder_preview_scripts", 'trx_addons_sc_skills_load_scripts', 10, 1);
	function trx_addons_sc_skills_load_scripts($editor='') {
		wp_enqueue_script( 'trx_addons-chart', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/chart.min.js'), array('jquery'), null, true );
		if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && $editor!='gutenberg') {
			wp_enqueue_style( 'trx_addons-sc_skills', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.css'), array(), null );
			wp_enqueue_script( 'trx_addons-sc_skills', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.js'), array('jquery'), null, true );
		}
	}
}



// trx_sc_skills
//-------------------------------------------------------------
/*
[trx_sc_skills id="unique_id" type="pie" cutout="99" values="encoded json data"]
*/
if ( !function_exists( 'trx_addons_sc_skills' ) ) {
	function trx_addons_sc_skills($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_sc_skills', $atts, trx_addons_sc_common_atts('id,title', array(
			// Individual params
			"type" => "counter",
			"cutout" => 0,
			"compact" => 0,
			"max" => 100,
			"color" => '',
			"bg_color" => '',
			"back_color" => '',		// Alter param name for VC (it broke bg_color)
			"border_color" => '',
			"columns" => "",
			"values" => "",
			))
		);

		if (function_exists('vc_param_group_parse_atts') && !is_array($atts['values']))
			$atts['values'] = (array) vc_param_group_parse_atts($atts['values']);

		$output = '';

		if (is_array($atts['values']) && count($atts['values']) > 0) {

			if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
				wp_enqueue_script( 'trx_addons-sc_skills', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills.js'), array('jquery'), null, true );
			}
	
			if (empty($atts['bg_color'])) $atts['bg_color'] = $atts['back_color'];
	
			$atts['cutout'] = min(100, max(0, (int) $atts['cutout']));
	
			$max = 0;
			foreach ($atts['values'] as $k=>$v) {
				if (preg_match('/([+\-\.0-9]+)(.*)/', $v['value'], $matches)) {
					$atts['values'][$k]['value'] = (float)$matches[1];
					$atts['values'][$k]['units'] = $matches[2];
				} else
					$atts['values'][$k]['value'] = (float)str_replace('%', '', $v['value']);
				if ($max < $atts['values'][$k]['value']) $max = $atts['values'][$k]['value'];
			}
			if (empty($atts['max']))
				$atts['max'] = $max;
			else {
				if (preg_match('/([+\-\.0-9]+)(.*)/', $atts['max'], $matches)) {
					$atts['max'] = (float)$matches[1];
				} else
					$atts['max'] = str_replace('%', '', $atts['max']);
			}
	
			$atts['compact'] = $atts['compact']<1 ? 0 : 1;
			$atts['columns'] = $atts['compact']==0 
									? ($atts['columns'] < 1 
										? count($atts['values']) 
										: min($atts['columns'], count($atts['values']))
										)
									: 1;
			if (!empty($atts['columns_tablet']) && $atts['compact']==0) $atts['columns_tablet'] = max(1, min(count($atts['values']), (int) $atts['columns_tablet']));
			if (!empty($atts['columns_mobile']) && $atts['compact']==0) $atts['columns_mobile'] = max(1, min(count($atts['values']), (int) $atts['columns_mobile']));
	
			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/tpl.counter.php'
											),
											'trx_addons_args_sc_skills', 
											$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_skills', $atts, $content);
	}
}


// Add shortcode [trx_sc_skills]
if (!function_exists('trx_addons_sc_skills_add_shortcode')) {
	function trx_addons_sc_skills_add_shortcode() {
		add_shortcode("trx_sc_skills", "trx_addons_sc_skills");
	}
	add_action('init', 'trx_addons_sc_skills_add_shortcode', 20);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_SHORTCODES . 'skills/skills-sc-vc.php';
}
