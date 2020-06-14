<?php
/**
 * Shortcode: Single Post Meta (Elementor support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.49
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}
	



// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_layouts_meta_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_layouts_meta_add_in_elementor' );
	function trx_addons_sc_layouts_meta_add_in_elementor() {
		
		if (!class_exists('TRX_Addons_Elementor_Widget')) return;	

		class TRX_Addons_Elementor_Widget_Layouts_Meta extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_layouts_meta';
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
				return __( 'Layouts: Single Post Meta', 'trx_addons' );
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
				return 'eicon-type-tool';
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
				return ['trx_addons-layouts'];
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

				$components = apply_filters('trx_addons_filter_get_list_meta_parts', array());

				$this->start_controls_section(
					'section_sc_layouts_meta',
					[
						'label' => __( 'Single Post Meta', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_get_list_sc_layouts_meta(), 'trx_sc_layouts_meta'),
						'default' => 'default',
					]
				);

				$this->add_control(
					'components',
					[
						'label' => __( 'Choose components', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __('Display specified post meta elements', 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SELECT2,
						'options' => $components,
						'multiple' => true,
						'default' => trx_addons_array_get_first($components),
					]
				);

				$this->add_control(
					'share_type',
					[
						'label' => __( 'Share style', 'trx_addons' ),
						'description' => wp_kses_data( __('Style of the share list', 'trx_addons') ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_share_types(),
						'default' => 'drop'
					]
				);

				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Layouts_Meta() );
	}
}


// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_sc_layouts_meta_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_sc_layouts_meta_black_list' );
	function trx_addons_sc_layouts_meta_black_list($list) {
		$list[] = 'TRX_Addons_SOW_Widget_Layouts_Meta';
		return $list;
	}
}
