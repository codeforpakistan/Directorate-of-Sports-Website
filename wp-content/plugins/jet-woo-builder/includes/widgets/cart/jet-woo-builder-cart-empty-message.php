<?php
/**
 * Class: Jet_Woo_Builder_Cart_Empty_Message
 * Name: Cart Empty Message
 * Slug: jet-cart-empty-message
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Cart_Empty_Message extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-cart-empty-message';
	}

	public function get_title() {
		return esc_html__( 'Cart Empty Message', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-cart-empty-message';
	}

	public function get_jet_help_url() {
		return 'https://crocoblock.com/knowledge-base/articles/jetwoobuilder-how-to-create-a-cart-page-template/';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'cart' );
	}

	protected function register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-cart-empty-message/css-scheme',
			[
				'message' => '.cart-empty.woocommerce-info',
			]
		);

		$this->start_controls_section(
			'cart_empty_message_general_section',
			[
				'label' => __( 'General', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );

		$this->add_control(
			'cart_empty_enable_custom_message',
			[
				'label' => __( 'Enable Custom Message', 'jet-woo-builder' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'cart_empty_message_text',
			[
				'label'       => __( 'Message', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your custom message here.', 'jet-woo-builder' ),
				'condition'   => [
					'cart_empty_enable_custom_message' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'empty_message_styles',
			array(
				'label' => esc_html__( 'Style', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'empty_message_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['message'],
			)
		);

		$this->add_control(
			'empty_message_color',
			array(
				'label'     => esc_html__( 'Message Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['message'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'empty_message_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['message'] . ':before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'empty_message_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['message'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'empty_message_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['message'],
			)
		);

		$this->add_responsive_control(
			'empty_message_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['message'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'empty_message_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['message'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'empty_message_align',
			array(
				'label'     => esc_html__( 'Text Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types( true ),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['message'] => 'text-align: {{VALUE}}',
				),
				'classes'   => 'elementor-control-align',
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		add_filter( 'wc_empty_cart_message', array( $this, 'custom_empty_cart_message' ), 1 );

		$this->__open_wrap();

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();

		remove_filter( 'wc_empty_cart_message', array( $this, 'custom_empty_cart_message' ), 1 );

	}

	/**
	 * Change default empty cart message.
	 *
	 * @param $message
	 *
	 * @return mixed
	 */
	public function custom_empty_cart_message( $message ) {

		$settings = $this->get_settings_for_display();

		$empty_message = isset( $settings['cart_empty_message_text'] ) ? $settings['cart_empty_message_text'] : '';

		if ( ! empty( $empty_message ) ) {
			$message = esc_html__( $empty_message, 'jet-woo-builder' );
		}

		return $message;

	}

}
