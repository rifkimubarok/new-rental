<?php
/**
 * Widget: Twitter (Elementor support)
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
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_twitter_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_twitter_add_in_elementor' );
	function trx_addons_sc_widget_twitter_add_in_elementor() {
		
		if (!class_exists('TRX_Addons_Elementor_Widget')) return;	

		class TRX_Addons_Elementor_Widget_Twitter extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_widget_twitter';
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
				return __( 'Widget: Twitter', 'trx_addons' );
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
				return 'eicon-twitter-feed';
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
				return ['trx_addons-widgets'];
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
					'section_sc_twitter_account',
					[
						'label' => __( 'Twitter API Keys', 'trx_addons' ),
						'description' => wp_kses_data( __("To get API keys you need to create an application in your Twitter account", 'trx_addons') ),
					]
				);

				$this->add_control(
					'username',
					[
						'label' => __( 'Twitter Username', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Username", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'consumer_key',
					[
						'label' => __( 'Consumer Key', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Consumer Key", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'consumer_secret',
					[
						'label' => __( 'Consumer Secret', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Consumer Secret", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'token_key',
					[
						'label' => __( 'Token Key', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Token Key", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'token_secret',
					[
						'label' => __( 'Token Secret', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Token Secret", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->end_controls_section();

				$this->start_controls_section(
					'section_sc_twitter',
					[
						'label' => __( 'ThemeREX Twitter', 'trx_addons' ),
						'tab' => \Elementor\Controls_Manager::TAB_LAYOUT
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('widgets', 'twitter'), 'trx_widget_twitter'),
						'default' => 'list'
					]
				);
				
				$this->add_control(
					'title',
					[
						'label' => __( 'Title', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Widget title", 'trx_addons' ),
						'default' => ''
					]
				);
				
				$this->add_control(
					'count',
					[
						'label' => __( 'Count', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 2
						],
						'range' => [
							'px' => [
								'min' => 1,
								'max' => 30
							]
						]
					]
				);
				
				$this->add_responsive_control(
					'columns',
					[
						'label' => __( 'Columns', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 1
						],
						'range' => [
							'px' => [
								'min' => 1,
								'max' => 12
							]
						],
						'condition' => [
							'type' => [ 'default' ]
						]
					]
				);

				$this->add_control(
					'follow',
					[
						'label' => __( 'Show Follow Us', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'default' => '1',
						'return_value' => '1'
					]
				);

				$this->add_control(
					'bg_image',
					[
						'label' => __( 'Background Image', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => '',
						],
					]
				);

				$this->add_slider_param('', [
					'slider' => [
									'condition' => ['type' => 'default']
								]
					]);

				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Twitter() );
	}
}


// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_widget_twitter_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_widget_twitter_black_list' );
	function trx_addons_widget_twitter_black_list($list) {
		$list[] = 'trx_addons_widget_twitter';
		return $list;
	}
}
