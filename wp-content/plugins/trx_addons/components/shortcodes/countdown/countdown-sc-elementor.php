<?php
/**
 * Shortcode: Countdown (Elementor support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4.3
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}



// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_countdown_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_countdown_add_in_elementor' );
	function trx_addons_sc_countdown_add_in_elementor() {
		
		if (!class_exists('TRX_Addons_Elementor_Widget')) return;	

		class TRX_Addons_Elementor_Widget_Countdown extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_countdown';
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
				return __( 'Countdown', 'trx_addons' );
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
				return 'eicon-countdown';
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
				return ['trx_addons-elements'];
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
					'section_sc_countdown',
					[
						'label' => __( 'Countdown', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'countdown'), 'trx_sc_countdown'),
						'default' => 'default',
					]
				);

				$this->add_control(
					'align',
					[
						'label' => __( 'Alignment', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_aligns(),
						'default' => 'none'
					]
				);

				$this->add_control(
					'date_time',
					[
						'label' => __( 'Date & Time', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::DATE_TIME,
						'options' => trx_addons_get_list_sc_aligns(),
						'default' => date('Y-m-d H:i:s')
					]
				);

				$this->add_control(
					'count_to',
					[
						'label' => __( 'Count to', 'trx_addons' ),
						'label_block' => false,
						'description' => __( 'If checked - date above is a finish date, else - is a start date', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'From', 'trx_addons' ),
						'label_on' => __( 'To', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->end_controls_section();

				$this->add_title_param();
			}

			/**
			 * Render widget's template for the editor.
			 *
			 * Written as a Backbone JavaScript template and used to generate the live preview.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _content_template() {
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "countdown/tpe.countdown.php",
										'trx_addons_args_sc_countdown',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Countdown() );
	}
}

// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_sc_countdown_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_sc_countdown_black_list' );
	function trx_addons_sc_countdown_black_list($list) {
		$list[] = 'TRX_Addons_SOW_Widget_Countdown';
		return $list;
	}
}
