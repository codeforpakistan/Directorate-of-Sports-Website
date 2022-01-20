<?php
/**
 * Class: Jet_Woo_Builder_Checkout_Order_Review
 * Name: Checkout Order Review
 * Slug: jet-checkout-order-review
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Checkout_Order_Review extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-checkout-order-review';
	}

	public function get_title() {
		return esc_html__( 'Checkout Order Review', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-checkout-order-review';
	}

	public function get_jet_help_url() {
		return 'https://crocoblock.com/knowledge-base/articles/jetwoobuilder-how-to-create-a-checkout-page-template/';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'checkout' );
	}

	protected function register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-checkout-order-review/css-scheme',
			array(
				'heading'            => '.elementor-widget-container .elementor-jet-checkout-order-review h3#order_review_heading',
				'product_price'      => '.woocommerce-checkout-review-order-table td.product-total .amount',
				'product_price_sign' => '.woocommerce-checkout-review-order-table td.product-total .amount .woocommerce-Price-currencySymbol',
				'total_price'        => '.woocommerce-checkout-review-order-table tfoot .woocommerce-Price-amount.amount',
				'total_price_sign'   => '.woocommerce-checkout-review-order-table tfoot .woocommerce-Price-amount.amount .woocommerce-Price-currencySymbol',
				'table_heading'      => '#order_review .shop_table.woocommerce-checkout-review-order-table th',
				'cell'               => '.woocommerce-checkout-review-order-table td',
			)
		);

		$this->start_controls_section(
			'checkout_order_review_heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );
		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'checkout_order_review', $css_scheme['heading'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_order_review_table_heading_styles',
			array(
				'label' => esc_html__( 'Table Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'checkout_order_review_table_heading_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_heading'],
			)
		);

		$this->add_control(
			'checkout_order_review_table_heading_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['table_heading'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'checkout_order_review_table_heading_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} .woocommerce-checkout-review-order-table th',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'checkout_order_review_table_heading_border',
				'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_heading'],
			)
		);

		$this->add_responsive_control(
			'checkout_order_review_table_heading_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['table_heading'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'checkout_order_review_table_heading_align',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['table_heading'] => 'text-align: {{VALUE}}',
				),
				'classes'   => 'elementor-control-align',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_order_review_cell_styles',
			array(
				'label' => esc_html__( 'Table Cells', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'checkout_order_review_cell_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['cell'],
			)
		);

		$this->add_control(
			'checkout_order_review_cell_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'checkout_order_review_cell_link_color',
			[
				'label'     => __( 'Link Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['cell'] . ' a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'checkout_order_review_cell_link_hover_color',
			[
				'label'     => __( 'Link Hover Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['cell'] . ' a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		jet_woo_builder_common_controls()->register_table_cell_style_controls( $this, 'checkout_order_review', $css_scheme['cell'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_order_review_price_styles',
			array(
				'label' => esc_html__( 'Prices', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'checkout_order_review_price_typography',
				'label'    => esc_html__( 'Product Price Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['product_price'],
			)
		);

		$this->add_control(
			'checkout_order_review_product_price_color',
			array(
				'label'     => esc_html__( 'Product Price Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['product_price'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'checkout_order_review_product_price_sign_typography',
				'label'    => esc_html__( 'Product Price Sign Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['product_price_sign'],
			)
		);

		$this->add_control(
			'checkout_order_review_product_price_sign_color',
			array(
				'label'     => esc_html__( 'Product Price Sign Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['product_price_sign'] => 'color: {{VALUE}}',
				),
				'separator' => 'after',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'checkout_order_review_total_price_typography',
				'label'    => esc_html__( 'Total/Subtotal Price Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['total_price'],
			)
		);

		$this->add_control(
			'checkout_order_review_total_price_color',
			array(
				'label'     => esc_html__( 'Total/Subtotal Price Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['total_price'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'checkout_order_review_total_price_sign_typography',
				'label'    => esc_html__( 'Total/Subtotal Price Sign Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['total_price_sign'],
			)
		);

		$this->add_control(
			'checkout_order_review_total_price_sign_color',
			array(
				'label'     => esc_html__( 'Total/Subtotal Price Sign Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['total_price_sign'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();

	}
}
