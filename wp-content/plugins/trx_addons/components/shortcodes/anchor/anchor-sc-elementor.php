<?php
/**
 * Shortcode: Anchor (Elementor support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_anchor_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_anchor_add_in_elementor' );
	function trx_addons_sc_anchor_add_in_elementor() {
		
		if (!class_exists('TRX_Addons_Elementor_Widget')) return;	

		class TRX_Addons_Elementor_Widget_Anchor extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_anchor';
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
				return __( 'Anchor', 'trx_addons' );
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
				return 'eicon-anchor';
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
					'section_sc_anchor',
					[
						'label' => __( 'Anchor', 'trx_addons' ),
					]
				);

				$this->add_control(
					'anchor_id',
					[
						'label' => __( "Anchor's ID", 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'label_block' => false,
						'placeholder' => __( "Anchor's ID", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'title',
					[
						'label' => __( 'Title', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'label_block' => false,
						'placeholder' => __( "Title", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'url',
					[
						'label' => __( 'URL', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::URL,
						'label_block' => false,
						'placeholder' => __( '//your-link.com', 'trx_addons' ),
					]
				);

				$this->add_icon_param();

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
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_SHORTCODES . "anchor/tpe.anchor.php",
										'trx_addons_args_sc_anchor',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Anchor() );
	}
}

// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_sc_anchor_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_sc_anchor_black_list' );
	function trx_addons_sc_anchor_black_list($list) {
		$list[] = 'TRX_Addons_SOW_Widget_Anchor';
		return $list;
	}
}
