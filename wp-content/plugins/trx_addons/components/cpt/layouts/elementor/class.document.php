<?php
/**
 * ThemeREX Addons Layouts: Elementor Document class
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.51
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

if (class_exists('Elementor\Core\Base\Document') && !class_exists('TRX_Addons_Elementor_Layouts_Document')) {
	class TRX_Addons_Elementor_Layouts_Document extends Elementor\Core\Base\Document {

		/**
		 * @access public
		 */
		public function get_name() {
			return TRX_ADDONS_CPT_LAYOUTS_PT;
		}

		/**
		 * @access public
		 * @static
		 */
		public static function get_title() {
			return __( 'ThemeREX Addons Layout', 'trx_addons' );
		}

		/**
		 * [_register_controls description]
		 * @return [type] [description]
		 */
		protected function _register_controls() {

			parent::_register_controls();

			$this->start_controls_section(
				'trx_layout_style',
				[
					'label' => __( 'Layout Container', 'trx_addons' ),
					'tab'   => Elementor\Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'layout_width',
				[
					'label' => esc_html__( 'Width', 'trx_addons' ),
					'description' => esc_html__( "Width of the editor area. Attention! This option does not affect the actual width of the content, and is used only for ease of editing", 'trx_addons' ),
					'type'  => Elementor\Controls_Manager::SLIDER,
					'size_units' => [
						'px', '%'
					],
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 2000,
						],
						'%' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'default' => [
						'size' => '',
						'unit' => 'px',
					],
					'selectors' => [
						'.trx-addons-layout--edit-mode .trx-addons-layout__inner' => 'max-width: {{SIZE}}{{UNIT}};',	//#elementor.elementor-edit-mode .elementor-inner,
					],
				]
			);

			$this->end_controls_section();
		}
	}
}
