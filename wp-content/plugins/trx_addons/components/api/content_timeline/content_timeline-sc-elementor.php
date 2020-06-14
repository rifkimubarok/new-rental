<?php
/**
 * Plugin support: Content Timeline (Elementor support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Elementor Widget
if (!function_exists('trx_addons_sc_content_timeline_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_content_timeline_add_in_elementor' );
	function trx_addons_sc_content_timeline_add_in_elementor() {

		if (!trx_addons_exists_content_timeline() || !class_exists('TRX_Addons_Elementor_Widget')) return;
		
		class TRX_Addons_Elementor_Widget_Content_Timeline extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_content_timeline';
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
				return __( 'Content Timeline', 'trx_addons' );
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
				return 'eicon-time-line';
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
					'section_sc_content_timeline',
					[
						'label' => __( 'Content Timeline', 'trx_addons' ),
					]
				);

				$timelines = trx_addons_get_list_content_timelines();
				$id = (int) trx_addons_array_get_first($timelines);

				$this->add_control(
					'timeline_id',
					[
						'label' => __( 'Timeline', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $timelines,
						'default' => ''.$id 	// Convert to string
					]
				);
				
				$this->end_controls_section();
			}

			// Return widget's layout
			public function render() {
				if (shortcode_exists('content_timeline')) {
					$atts = $this->sc_prepare_atts($this->get_settings(), $this->get_sc_name());
					trx_addons_show_layout(do_shortcode(sprintf('[content_timeline id="%s"]', $atts['timeline_id'])));
				} else
					$this->shortcode_not_exists('content_timeline', 'Content Timeline');
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Content_Timeline() );
	}
}
