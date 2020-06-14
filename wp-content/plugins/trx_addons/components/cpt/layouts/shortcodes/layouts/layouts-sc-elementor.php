<?php
/**
 * Shortcode: Display any previously created layout (Elementor support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.06
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_layouts_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_layouts_add_in_elementor' );
	function trx_addons_sc_layouts_add_in_elementor() {
		
		if (!class_exists('TRX_Addons_Elementor_Layouts_Widget')) return;	

		class TRX_Addons_Elementor_Widget_Layouts extends TRX_Addons_Elementor_Layouts_Widget {

			/**
			 * Widget base constructor.
			 *
			 * Initializing the widget base class.
			 *
			 * @since 1.6.44
			 * @access public
			 *
			 * @param array      $data Widget data. Default is an empty array.
			 * @param array|null $args Optional. Widget default arguments. Default is null.
			 */
			public function __construct( $data = [], $args = null ) {
				parent::__construct( $data, $args );
				$this->add_plain_params([
					'size' => 'size+unit',
				]);
			}
			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_layouts';
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
				return __( 'Layouts', 'trx_addons' );
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
				return 'fa fa-object-group';
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
				// If open params in Elementor Editor
				$params = $this->get_sc_params();
				// Prepare lists
				$layouts = trx_addons_array_merge(	array(
														0 => __('- Use content -', 'trx_addons')
														),
													trx_addons_get_list_posts(false, array(
																'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
																'meta_key' => 'trx_addons_layout_type',
																'meta_value' => 'custom',
																'not_selected' => false
																)));
				$default = 0;	//trx_addons_array_get_first($layouts);
				$layout = !empty($params['layout']) ? $params['layout'] : $default;

				$this->start_controls_section(
					'section_sc_layouts',
					[
						'label' => __( 'Layouts', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Type', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_get_list_sc_layouts_type(), 'trx_sc_layouts'),
						'default' => 'default'
					]
				);

				$this->add_control(
					'layout', 
					[
						'label' => __("Layout", 'trx_addons'),
						'label_block' => false,
						'description' => wp_kses_post( __("Select any previously created layout to insert to this page", 'trx_addons')
														. '<br>'
														. sprintf('<a href="%1$s" class="trx_addons_post_editor'.(intval($layout)==0 ? ' trx_addons_hidden' : '').'" target="_blank">%2$s</a>',
																	admin_url( sprintf( "post.php?post=%d&amp;action=elementor", $layout ) ),
																	__("Open selected layout in a new tab to edit", 'trx_addons')
																)
													),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $layouts,
						'default' => $default
					]
				);

				$this->add_control(
					'position', 
					[
						'label' => __("Panel position", 'trx_addons'),
						'label_block' => false,
						'description' => wp_kses_data( __("Dock the panel to the specified side of the window", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_layouts_panel_positions(),
						'default' => 'right',
						'condition' => ['type' => 'panel']
					]
				);
				
				$this->add_control(
					'size',
					[
						'label' => __( 'Size', 'trx_addons' ),
						'description' => wp_kses_data( __("Size (width or height) of the panel", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 300,
							'unit' => 'px'
						],
						'range' => [
							'%' => [
								'min' => 5,
								'max' => 100
							],
							'px' => [
								'min' => 50,
								'max' => 1920
							]
						],
						'size_units' => ['%', 'px'],
						'condition' => ['type' => 'panel']
					]
				);

				$this->add_control(
					'modal',
					[
						'label' => __( 'Modal', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Disable clicks on the rest window area", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1',
						'condition' => ['type' => 'panel']
					]
				);

				$this->add_control(
					'show_on_load', 
					[
						'label' => __("Show on load", 'trx_addons'),
						'label_block' => false,
						'description' => wp_kses_data( __("Display this popup (panel) when the page is loaded", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_layouts_show_on_load(),
						'default' => 'none',
						'condition' => [
							'type' => ['popup', 'panel']
						]
					]
				);

				$this->add_control(
					'popup_id',
					[
						'label' => __( "Popup (panel) ID", 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Popup (panel) ID is required!", 'trx_addons' ),
						'default' => '',
						'condition' => [
							'type' => ['popup', 'panel']
						]
					]
				);

				$this->add_control(
					'content',
					[
						'label' => __( 'Content', 'trx_addons' ),
						'label_block' => true,
						"description" => wp_kses_data( __("Alternative content to be used instead of the selected layout", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'default' => '',
						'separator' => 'none',
						'condition' => [
							'layout' => array( 0, '0' )
						]
					]
				);
				
				$this->end_controls_section();
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Layouts() );
	}
}

// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_sc_layouts_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_sc_layouts_black_list' );
	function trx_addons_sc_layouts_black_list($list) {
		$list[] = 'TRX_Addons_SOW_Widget_Layouts';
		return $list;
	}
}
