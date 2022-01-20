<?php
/**
 * Class: Jet_Woo_Builder_ThankYou_Order
 * Name: Thank You Order
 * Slug: jet-thankyou-order
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_ThankYou_Order extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-thankyou-order';
	}

	public function get_title() {
		return esc_html__( 'Thank You Order', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-thank-you-order';
	}

	public function get_jet_help_url() {
		return 'https://crocoblock.com/knowledge-base/articles/jetwoobuilder-how-to-create-a-thank-you-page-template/';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'thankyou' );
	}

	protected function register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-thankyou-order/css-scheme',
			array(
				'message'  => '.woocommerce-thankyou-order-received',
				'overview' => 'ul.order_details li',
				'details'  => 'ul.order_details li strong',
			)
		);

		$this->start_controls_section(
			'thankyou_order_content',
			array(
				'label' => esc_html__( 'General', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );

		$this->add_control(
			'thankyou_message_text',
			array(
				'label'   => esc_html__( 'Thank You Message', 'jet-woo-builder' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Thank you. Your order has been received.', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'thankyou_order_table_order_heading',
			array(
				'label'       => esc_html__( 'Order Heading', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Order number:', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type order number heading here', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'thankyou_order_table_date_heading',
			array(
				'label'       => esc_html__( 'Date Heading', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Date:', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type date heading here', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'thankyou_order_table_email_heading',
			array(
				'label'       => esc_html__( 'Email Heading', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Email:', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type email heading here', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'thankyou_order_table_total_heading',
			array(
				'label'       => esc_html__( 'Total Heading', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Total:', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type total heading here', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'thankyou_order_table_payment_method_heading',
			array(
				'label'       => esc_html__( 'Payment Heading', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Payment method:', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type payment heading here', 'jet-woo-builder' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_message_styles',
			array(
				'label' => esc_html__( 'Message', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'thankyou_message', $css_scheme['message'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_overview_styles',
			array(
				'label' => esc_html__( 'Overview', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'thankyou_overview_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['overview'],
			)
		);

		$this->add_control(
			'thankyou_overview_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['overview'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'thankyou_overview_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['overview'],
			)
		);

		$this->add_responsive_control(
			'thankyou_overview_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['overview'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'thankyou_overview_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['overview'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'thankyou_overview_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['overview'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'thankyou_overview_align',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['overview'] => 'text-align: {{VALUE}}',
				),
				'classes'   => 'elementor-control-align',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_details_styles',
			array(
				'label' => esc_html__( 'Details', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'thankyou_details', $css_scheme['details'] );

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();

	}

}
