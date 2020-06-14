<?php
/**
 * Plugin support: Booked Appointments (Elementor support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Params for Booked Appointments
if (!function_exists('trx_addons_sc_booked_add_in_elementor_ba')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_booked_add_in_elementor_ba' );
	function trx_addons_sc_booked_add_in_elementor_ba() {

		if (!trx_addons_exists_booked() || !class_exists('TRX_Addons_Elementor_Widget')) return;
		
		class TRX_Addons_Elementor_Widget_Booked_Appontments extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_booked_appointments';
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
				return __( 'Booked Appointments', 'trx_addons' );
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
				return 'eicon-checkbox';
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

			// Return widget's layout
			public function render() {
				if (shortcode_exists('booked-appointments')) {
					trx_addons_show_layout(do_shortcode('[booked-appointments]'));
				} else {
					$this->shortcode_not_exists('booked-appointments', 'Booked Appointment');
				}
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Booked_Appontments() );
	}
}


// Params for Booked Profile
if (!function_exists('trx_addons_sc_booked_add_in_elementor_bp')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_booked_add_in_elementor_bp' );
	function trx_addons_sc_booked_add_in_elementor_bp() {

		if (!trx_addons_exists_booked() || !class_exists('TRX_Addons_Elementor_Widget')) return;
		
		class TRX_Addons_Elementor_Widget_Booked_Profile extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_booked_profile';
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
				return __( 'Booked Profile', 'trx_addons' );
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
				return 'eicon-lock-user';
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

			// Return widget's layout
			public function render() {
				if (shortcode_exists('booked-profile')) {
					trx_addons_show_layout(do_shortcode('[booked-profile]'));
				} else {
					$this->shortcode_not_exists('booked-profile', 'Booked Profile');
				}
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Booked_Profile() );
	}
}


// Params for Booked Calendar
if (!function_exists('trx_addons_sc_booked_add_in_elementor_bc')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_booked_add_in_elementor_bc' );
	function trx_addons_sc_booked_add_in_elementor_bc() {

		if (!trx_addons_exists_booked() || !class_exists('TRX_Addons_Elementor_Widget')) return;
		
		class TRX_Addons_Elementor_Widget_Booked_Calendar extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_booked_calendar';
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
				return __( 'Booked Calendar', 'trx_addons' );
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
				return 'eicon-apps';
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
					'section_sc_booked',
					[
						'label' => __( 'ThemeREX Booked Calendar', 'trx_addons' ),
					]
				);

				$this->add_control(
					'style',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => [
									'calendar' => esc_html__('Calendar', 'trx_addons'),
									'list' => esc_html__('List', 'trx_addons')
									],
						'default' => 'calendar'
					]
				);

				$this->add_control(
					'calendar',
					[
						'label' => __( 'Calendar', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Select calendar -', 'trx_addons')), trx_addons_get_list_terms(false, 'booked_custom_calendars')),
						'default' => '0'
					]
				);

				$this->add_control(
					'month',
					[
						'label' => __( 'Month', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Current month -', 'trx_addons')), trx_addons_get_list_months()),
						'default' => '0'
					]
				);

				$this->add_control(
					'year',
					[
						'label' => __( 'Year', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_array_merge(array(0 => esc_html__('- Current year -', 'trx_addons')), trx_addons_get_list_range(date('Y'), date('Y')+25)),
						'default' => '0'
					]
				);
				
				$this->end_controls_section();
			}

			// Return widget's layout
			public function render() {
				if (shortcode_exists('booked-calendar')) {
					$atts = $this->sc_prepare_atts($this->get_settings(), $this->get_sc_name());
					trx_addons_show_layout(do_shortcode(sprintf('[booked-calendar style="%1$s" calendar="%2$s" month="%3$s" year="%4$s"]',
																$atts['style'],
																$atts['calendar'],
																$atts['month'],
																$atts['year']
																)));
				} else {
					$this->shortcode_not_exists('booked-calendar', 'Booked Calendar');
				}
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Booked_Calendar() );
	}
}
