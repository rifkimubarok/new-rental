<?php
/**
 * Widget: WooCommerce Search (Advanced search form) (Elementor support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Elementor Widget
if (!function_exists('trx_addons_sc_widget_woocommerce_search_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_woocommerce_search_add_in_elementor' );
	function trx_addons_sc_widget_woocommerce_search_add_in_elementor() {

		if (!trx_addons_exists_woocommerce() || !class_exists('TRX_Addons_Elementor_Widget')) return;
		
		class TRX_Addons_Elementor_Widget_Woocommerce_Search extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_widget_woocommerce_search';
			}

			/**
			 * Retrieve widget title.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget title.
			 */
			public function get_title() {
				return __( 'Woocommerce Search', 'trx_addons' );
			}

			/**
			 * Retrieve widget icon.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget icon.
			 */
			public function get_icon() {
				return 'eicon-search';
			}

			/**
			 * Retrieve the list of categories the widget belongs to.
			 *
			 * Used to determine where to display the widget in the editor.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return array Widget categories.
			 */
			public function get_categories() {
				return ['trx_addons-support'];
			}

			/**
			 * Register widget controls.
			 *
			 * Adds different input fields to allow the user to change and customize the widget settings.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _register_controls() {
				$this->start_controls_section(
					'section_sc_woocommerce_search',
					[
						'label' => __( 'Woocommerce Search', 'trx_addons' ),
					]
				);

				$this->add_control(
					'title',
					[
						'label' => __( 'Widget title', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Title", 'trx_addons' ),
						'default' => ''
					]
				);
				
				$this->add_control(
					'fields',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::REPEATER,
						'default' => apply_filters('trx_addons_sc_param_group_value', [
							[
								'text' => '',
								'filter' => ''
							]
						], 'trx_widget_woocommerce_search'),
						'fields' => apply_filters('trx_addons_sc_param_group_params', array_merge(
							[
								[
									'name' => 'text',
									'label' => __( 'Field text', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Text", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'filter',
									'label' => __( 'Field filter', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::SELECT,
									'options' => trx_addons_get_list_woocommerce_search_filters(),
									'default' => 'none'
								]
							]),
							'trx_widget_woocommerce_search'),
						'title_field' => '{{{ text }}} -> {{{ filter }}}',
					]
				);

				$this->add_control(
					'last_text',
					[
						'label' => __( 'Last text', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Last text", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'button_text',
					[
						'label' => __( 'Button text', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Text of the button after all filters", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Last text", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Woocommerce_Search() );
	}
}


// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_widget_woocommerce_search_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_widget_woocommerce_search_black_list' );
	function trx_addons_widget_woocommerce_search_black_list($list) {
		$list[] = 'trx_addons_widget_woocommerce_search';
		return $list;
	}
}
