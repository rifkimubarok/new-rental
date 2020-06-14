<?php
/**
 * Plugin support: WooCommerce
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if plugin installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_addons_exists_woocommerce' ) ) {
	function trx_addons_exists_woocommerce() {
		return class_exists('Woocommerce');
	}
}
*/

// Return true, if current page is any woocommerce page
if ( !function_exists( 'trx_addons_is_woocommerce_page' ) ) {
	function trx_addons_is_woocommerce_page() {
		$rez = false;
		if (trx_addons_exists_woocommerce())
			$rez = is_woocommerce() || is_shop() || is_product() || is_product_category() || is_product_tag() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page();
		return $rez;
	}
}


// Return taxonomy for current post type (this post_type have 2+ taxonomies)
if ( !function_exists( 'trx_addons_woocommerce_post_type_taxonomy' ) ) {
	add_filter( 'trx_addons_filter_post_type_taxonomy',	'trx_addons_woocommerce_post_type_taxonomy', 10, 2 );
	function trx_addons_woocommerce_post_type_taxonomy($tax='', $post_type='') {
		if ($post_type == 'product')
			$tax = 'product_cat';
		return $tax;
	}
}

// Return link to main shop page for the breadcrumbs
if ( !function_exists( 'trx_addons_woocommerce_get_blog_all_posts_link' ) ) {
	add_filter('trx_addons_filter_get_blog_all_posts_link', 'trx_addons_woocommerce_get_blog_all_posts_link', 10, 2);
	function trx_addons_woocommerce_get_blog_all_posts_link($link='', $args=array()) {
		if (empty($link) && trx_addons_is_woocommerce_page() && !is_shop()) {
			if (($url = trx_addons_woocommerce_get_shop_page_link()) != '') {
				$id = trx_addons_woocommerce_get_shop_page_id();
				$link = '<a href="'.esc_url($url).'">'.($id ? get_the_title($id) : esc_html__('Shop', 'trx_addons')).'</a>';
			}
		}
		return $link;
	}
}

// Return shop page ID
if ( !function_exists( 'trx_addons_woocommerce_get_shop_page_id' ) ) {
	function trx_addons_woocommerce_get_shop_page_id() {
		return get_option('woocommerce_shop_page_id');
	}
}

// Return shop page link
if ( !function_exists( 'trx_addons_woocommerce_get_shop_page_link' ) ) {
	function trx_addons_woocommerce_get_shop_page_link() {
		$url = '';
		$id = trx_addons_woocommerce_get_shop_page_id();
		if ($id) $url = get_permalink($id);
		return $url;
	}
}

// Return current page title
if ( !function_exists( 'trx_addons_woocommerce_get_blog_title' ) ) {
	add_filter( 'trx_addons_filter_get_blog_title', 'trx_addons_woocommerce_get_blog_title');
	function trx_addons_woocommerce_get_blog_title($title='') {
		if (trx_addons_exists_woocommerce() && trx_addons_is_woocommerce_page() && is_shop()) {
			$id = trx_addons_woocommerce_get_shop_page_id();
			$title = $id ? get_the_title($id) : esc_html__('Shop', 'trx_addons');
		}
		return $title;
	}
}
	
// Add item to the current user menu
if ( !function_exists( 'trx_addons_woocommerce_login_menu_settings' ) ) {
	add_action("trx_addons_action_login_menu_settings", 'trx_addons_woocommerce_login_menu_settings');
	function trx_addons_woocommerce_login_menu_settings() {
		if (trx_addons_exists_woocommerce()) {
			$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
			if ( !empty( $myaccount_page_id ) ) {
				?><li class="menu-item trx_addons_icon-edit"><a href="<?php echo esc_url(get_permalink( $myaccount_page_id )); ?>"><span><?php esc_html_e('My account', 'trx_addons'); ?></span></a></li><?php
			}
		}
	}
}


// Return value of the custom field for the custom blog items
if ( !function_exists( 'trx_addons_woocommerce_custom_meta_value' ) ) {
	add_filter( 'trx_addons_filter_custom_meta_value', 'trx_addons_woocommerce_custom_meta_value', 10, 2 );
	function trx_addons_woocommerce_custom_meta_value($value, $key) {
		if (get_post_type() == 'product' && trx_addons_exists_woocommerce()) {
			global $product;
			if (is_object($product)) {
				if ($key == 'price') {
					$value = $product->get_price_html();
				} else if (in_array($key, array('rating', 'rating_text', 'rating_icons', 'rating_stars')) && get_option( 'woocommerce_enable_review_rating' ) !== 'no' ) {
					$value = $key == 'rating_text'
								? $product->get_average_rating()
								: wc_get_rating_html( $product->get_average_rating() );
				}
			}
		}
		return $value;
	}
}


// Return layout of the button 'Add to cart' for the custom blog items
if ( !function_exists( 'trx_addons_woocommerce_blog_item_button' ) ) {
	add_filter( 'trx_addons_filter_blog_item_button', 'trx_addons_woocommerce_blog_item_button', 10, 2 );
	function trx_addons_woocommerce_blog_item_button($output, $args) {
		if ( !empty($args['button_link']) && $args['button_link'] == 'cart' && trx_addons_exists_woocommerce() && get_post_type() == 'product' ) {
			$ajax = 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' );
			if ( $ajax ) {
				wp_enqueue_script( 'wc-add-to-cart' );
			}
			ob_start();
			woocommerce_template_loop_add_to_cart(array(
				'class' => 'sc_button button add_to_cart_button' . ($ajax ? ' ajax_add_to_cart' : '')
			));
			$output = ob_get_contents();
			ob_end_clean();
		}
		return $output;
	}
}

// Return layout of the button 'Add to cart' for the custom blog items
if ( !function_exists( 'trx_addons_woocommerce_blog_item_button_class' ) ) {
	add_filter( 'trx_addons_filter_blog_item_button_class', 'trx_addons_woocommerce_blog_item_button_class', 10, 2 );
	function trx_addons_woocommerce_blog_item_button_class($class, $args) {
		if ( !empty($args['button_link']) && $args['button_link'] == 'cart' && trx_addons_exists_woocommerce() && get_post_type() == 'product' ) {
			$class .= ' woocommerce';
		}
		return $class;
	}
}



// Load required scripts and styles
//------------------------------------------------------------------------

// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_woocommerce_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_woocommerce_load_scripts_front', 11);
	function trx_addons_woocommerce_load_scripts_front() {
		if (trx_addons_exists_woocommerce() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-woocommerce', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce.css'), array(), null );
			wp_enqueue_script( 'trx_addons-woocommerce', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce.js'), array('jquery'), null, true );
		}
	}
}

// Load responsive styles for the frontend
if ( !function_exists( 'trx_addons_woocommerce_load_responsive_styles' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_woocommerce_load_responsive_styles', 2000);
	function trx_addons_woocommerce_load_responsive_styles() {
		if ( trx_addons_exists_woocommerce() && trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-woocommerce-responsive', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce.responsive.css'), array(), null );
		}
	}
}
	
// Merge specific styles into single stylesheet
if ( !function_exists( 'trx_addons_woocommerce_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_woocommerce_merge_styles');
	function trx_addons_woocommerce_merge_styles($list) {
		if (trx_addons_exists_woocommerce())
			$list[] = TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce.css';
		return $list;
	}
}

// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_woocommerce_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_woocommerce_merge_styles_responsive');
	function trx_addons_woocommerce_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce.responsive.css';
		return $list;
	}
}

// Merge specific scripts into single file
if ( !function_exists( 'trx_addons_woocommerce_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_woocommerce_merge_scripts', 11);
	function trx_addons_woocommerce_merge_scripts($list) {
		if (trx_addons_exists_woocommerce())
			$list[] = TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce.js';
		return $list;
	}
}


// Load WooCommerce Extended Attributes
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce-extended-attributes.php';

// Load WooCommerce Search Widget
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'woocommerce/widget.woocommerce_search.php';

// Add Elementor's support
if ( trx_addons_exists_woocommerce() && trx_addons_exists_elementor() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce-sc-elementor.php';
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_woocommerce() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'woocommerce/woocommerce-demo-ocdi.php';
}
