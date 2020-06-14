<?php
/**
 * Shortcode: Price block (Elementor support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}



// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_price_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_price_add_in_elementor' );
	function trx_addons_sc_price_add_in_elementor() {
		
		if (!class_exists('TRX_Addons_Elementor_Widget')) return;	

		class TRX_Addons_Elementor_Widget_Price extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_price';
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
				return __( 'Price', 'trx_addons' );
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
				return 'eicon-price-table';
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
					'section_sc_price',
					[
						'label' => __( 'Price', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'price'), 'trx_sc_price'),
						'default' => 'default',
					]
				);
				
				$this->add_responsive_control(
					'columns',
					[
						'label' => __( 'Columns', 'trx_addons' ),
						'description' => wp_kses_data( __("Specify the number of columns. If left empty or assigned the value '0' - auto detect by the number of items.", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 0
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 12
							]
						]
					]
				);
				
				$this->add_control(
					'prices',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::REPEATER,
						'default' => apply_filters('trx_addons_sc_param_group_value', [
							[
								'title' => esc_html__( 'Light', 'trx_addons' ),
								'subtitle' => $this->get_default_subtitle(),
								'description' => $this->get_default_description(),
								'details' => '',
								'link' => ['url' => '#'],
								'link_text' => esc_html__('Get this plan', 'trx_addons'),
								'label' => '',
								'price' => '99.99',
								'before_price' => '$',
								'after_price' => '',
								'image' => ['url' => ''],
								'bg_color' => '#aa0000',
								'bg_image' => ['url' => ''],
								'icon' => 'icon-star-empty'
							],
							[
								'title' => esc_html__( 'Premium', 'trx_addons' ),
								'subtitle' => $this->get_default_subtitle(),
								'description' => $this->get_default_description(),
								'details' => '',
								'link' => ['url' => '#'],
								'link_text' => esc_html__('Get this plan', 'trx_addons'),
								'label' => '',
								'price' => '199.99',
								'before_price' => '$',
								'after_price' => '',
								'image' => ['url' => ''],
								'bg_color' => '#0000aa',
								'bg_image' => ['url' => ''],
								'icon' => 'icon-heart-empty'
							],
							[
								'title' => esc_html__( 'Unlimited', 'trx_addons' ),
								'subtitle' => $this->get_default_subtitle(),
								'description' => $this->get_default_description(),
								'details' => '',
								'link' => ['url' => '#'],
								'link_text' => esc_html__('Get this plan', 'trx_addons'),
								'label' => '',
								'price' => '399.99',
								'before_price' => '$',
								'after_price' => '',
								'image' => ['url' => ''],
								'bg_color' => '#00aa00',
								'bg_image' => ['url' => ''],
								'icon' => 'icon-clock-empty'
							],
						], 'trx_sc_price'),
						'fields' => apply_filters('trx_addons_sc_param_group_params', array_merge(
							[
								[
									'name' => 'title',
									'label' => __( 'Title', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'label_block' => true,
									'placeholder' => __( "Item's title", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'subtitle',
									'label' => __( 'Subtitle', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'label_block' => true,
									'placeholder' => __( "Item's subtitle", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'label',
									'label' => __( "Label", 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'description' => __( 'If not empty, a colored band with this text is shown at the top corner of the price block.', 'trx_addons' ),
									'placeholder' => __( "Label's text", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'description',
									'label' => __( 'Description', 'trx_addons' ),
									'label_block' => true,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Short description of this item", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'before_price',
									'label' => __( "Before price", 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Before price", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'price',
									'label' => __( "Price", 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Price value", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'after_price',
									'label' => __( "After price", 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "After price", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'details',
									'label' => __( 'Details', 'trx_addons' ),
									'label_block' => true,
									'type' => \Elementor\Controls_Manager::WYSIWYG,
									'default' => '',
									'separator' => 'none'
								],
								[
									'name' => 'link',
									'label' => __( 'Link', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::URL,
									'default' => ['url' => ''],
									'placeholder' => __( '//your-link.com', 'trx_addons' ),
								],
								[
									'name' => 'link_text',
									'label' => __( "Link's text", 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Link's text", 'trx_addons' ),
									'default' => ''
								]
							],
							$this->get_icon_param(),
							[
								[
									'name' => 'image',
									'label' => __( 'Image', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::MEDIA,
									'default' => [
										'url' => '',
									],
								],
								[
									'name' => 'bg_color',
									'label' => __( 'Background Color', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::COLOR,
									'default' => '',
									'scheme' => [
										'type' => \Elementor\Scheme_Color::get_type(),
										'value' => \Elementor\Scheme_Color::COLOR_2,
									],
								],
								[
									'name' => 'bg_image',
									'label' => __( 'Background Image', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::MEDIA,
									'default' => [
										'url' => '',
									],
								]
							]),
							'trx_sc_price'),
						'title_field' => '{{{ title }}}',
					]
				);

				$this->end_controls_section();

				$this->add_slider_param();
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "price/tpe.price.php",
										'trx_addons_args_sc_price',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Price() );
	}
}


// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_sc_price_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_sc_price_black_list' );
	function trx_addons_sc_price_black_list($list) {
		$list[] = 'TRX_Addons_SOW_Widget_Price';
		return $list;
	}
}
