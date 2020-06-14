<?php
/**
 * Widget: Custom links (Elementor support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0.46
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}



// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_custom_links_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_custom_links_add_in_elementor' );
	function trx_addons_sc_widget_custom_links_add_in_elementor() {
		
		if (!class_exists('TRX_Addons_Elementor_Widget')) return;	

		class TRX_Addons_Elementor_Widget_Custom_Links extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_widget_custom_links';
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
				return __( 'Widget: Custom Links', 'trx_addons' );
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
				return 'eicon-toggle';
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
					'section_sc_custom_links',
					[
						'label' => __( 'Widget: Custom Links', 'trx_addons' ),
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
					'icons_animation',
					[
						'label' => __( 'Icons animation', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Toggle on if you want to animate icons. Attention! Animation is enabled only if there is an .SVG  icon in your theme with the same name as the selected icon.", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);
				
				$this->add_control(
					'links',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::REPEATER,
						'default' => apply_filters('trx_addons_sc_param_group_value', [
							[
								'title' => __( 'First link', 'trx_addons' ),
								'description' => $this->get_default_description(),
								'url' => ['url' => '#', 'is_external' => ''],
								'image' => ['url' => ''],
								'icon' => 'icon-star-empty',
								'caption' => '',
								'color' => '',
								'label' => '',
								'label_bg_color' => '',
								'label_on_hover' => '',
							],
							[
								'title' => __( 'Second link', 'trx_addons' ),
								'description' => $this->get_default_description(),
								'url' => ['url' => '#', 'is_external' => ''],
								'image' => ['url' => ''],
								'icon' => 'icon-heart-empty',
								'caption' => '',
								'color' => '',
								'label' => '',
								'label_bg_color' => '',
								'label_on_hover' => '',
							],
							[
								'title' => __( 'Third link', 'trx_addons' ),
								'description' => $this->get_default_description(),
								'url' => ['url' => '#', 'is_external' => ''],
								'image' => ['url' => ''],
								'icon' => 'icon-clock-empty',
								'caption' => '',
								'color' => '',
								'label' => '',
								'label_bg_color' => '',
								'label_on_hover' => '',
							]
						], 'trx_widget_custom_links'),
						'fields' => apply_filters('trx_addons_sc_param_group_params', array_merge(
							[
								[
									'name' => 'title',
									'label' => __( 'Title', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Link's title", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'url',
									'label' => __( 'Link URL', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::URL,
									'placeholder' => __( '//your-link.com', 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'caption',
									'label' => __( 'Button caption', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Caption", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'image',
									'label' => __( 'Image', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::MEDIA,
									'default' => [
										'url' => '',
									],
								]
							],
							$this->get_icon_param(),
							[
								[
									'name' => 'description',
									'label' => __( 'Description', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::TEXTAREA,
									'placeholder' => __( "Short description of this item", 'trx_addons' ),
									'default' => '',
									'separator' => 'none',
									'rows' => 10,
									'show_label' => false,
								],
								[
									'name' => 'color',
									'label' => __( 'Link color', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::COLOR,
									'default' => '',
									'scheme' => [
										'type' => \Elementor\Scheme_Color::get_type(),
										'value' => \Elementor\Scheme_Color::COLOR_1,
									],
								],
								[
									'name' => 'label',
									'label' => __( 'Label', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Label", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'label_bg_color',
									'label' => __( 'Label bg Color', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::COLOR,
									'default' => '',
									'scheme' => [
										'type' => \Elementor\Scheme_Color::get_type(),
										'value' => \Elementor\Scheme_Color::COLOR_2,
									],
								],
								[
									'name' => 'label_on_hover',
									'label' => __( 'Show label on hover', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::SWITCHER,
									'label_off' => __( 'Off', 'trx_addons' ),
									'label_on' => __( 'On', 'trx_addons' ),
									'return_value' => '1'
								],
							]),
							'trx_widget_custom_links'),
						'title_field' => '{{{ title }}}',
					]
				);

				$this->end_controls_section();
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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . "custom_links/tpe.custom_links.php",
										'trx_addons_args_widget_custom_links',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Custom_Links() );
	}
}


// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_widget_custom_links_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_widget_custom_links_black_list' );
	function trx_addons_widget_custom_links_black_list($list) {
		$list[] = 'trx_addons_widget_custom_links';
		return $list;
	}
}
