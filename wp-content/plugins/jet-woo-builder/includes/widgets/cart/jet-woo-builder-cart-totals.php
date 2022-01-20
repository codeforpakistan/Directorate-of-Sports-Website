<?php
/**
 * Class: Jet_Woo_Builder_Cart_Totals
 * Name: Cart Totals
 * Slug: jet-cart-totals
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Cart_Totals extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-cart-totals';
	}

	public function get_title() {
		return esc_html__( 'Cart Totals', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-cart-totals';
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
			'jet-woo-builder/jet-cart-totals/css-scheme',
			array(
				'heading'              => '.cart_totals h2',
				'table_heading'        => '.cart_totals .shop_table tr th',
				'table_heading_mobile' => '.cart_totals .shop_table_responsive tr td::before',
				'cell'                 => '.cart_totals .shop_table tr td',
				'subtotal_price'       => '.cart_totals .shop_table tr.cart-subtotal td .amount',
				'subtotal_price_sign'  => '.cart_totals .shop_table tr.cart-subtotal td .amount .woocommerce-Price-currencySymbol',
				'total_price'          => '.cart_totals .shop_table tr.order-total td .amount',
				'total_price_sign'     => '.cart_totals .shop_table tr.order-total td .amount .woocommerce-Price-currencySymbol',
				'button'               => '.wc-proceed-to-checkout .button.checkout-button',
			)
		);

		$this->start_controls_section(
			'cart_total_heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );
		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'cart_total', $css_scheme['heading'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'total_table_heading_styles',
			array(
				'label' => esc_html__( 'Table Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'total_table_heading_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_heading'] . ',{{WRAPPER}} ' . $css_scheme['table_heading_mobile'],
			)
		);

		$this->add_control(
			'total_table_heading_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['table_heading']        => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['table_heading_mobile'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'total_table_heading_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} .shop_table tbody th',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'total_table_heading_border',
				'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_heading'],
			)
		);

		$this->add_responsive_control(
			'total_table_heading_padding',
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
			'total_table_heading_align',
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

		$this->add_responsive_control(
			'total_table_heading_width',
			[
				'label'      => __( 'Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', ],
				'range'      => [
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_heading'] => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'total_table_cell_styles',
			array(
				'label' => esc_html__( 'Table Cells', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'total_table_cell_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['cell'],
			)
		);

		$this->add_control(
			'total_table_cell_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'total_table_cell_link_color',
			array(
				'label'     => esc_html__( 'Link Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] . ' a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'total_table_cell_link_hover_color',
			array(
				'label'     => esc_html__( 'Link Hover Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		jet_woo_builder_common_controls()->register_table_cell_style_controls( $this, 'total_table', $css_scheme['cell'] );

		$this->add_responsive_control(
			'total_table_cell_width',
			[
				'label'      => __( 'Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', ],
				'range'      => [
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['cell'] => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_table_price_styles',
			array(
				'label' => esc_html__( 'Prices', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'total_subtotal_price_color',
			array(
				'label'     => esc_html__( 'Price Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['subtotal_price'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'total_subtotal_price_typography',
				'label'    => esc_html__( 'Price Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['subtotal_price'],
			)
		);

		$this->add_control(
			'total_subtotal_price_sign_color',
			array(
				'label'     => esc_html__( 'Price Sign Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['subtotal_price_sign'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'total_subtotal_price_sign_typography',
				'label'    => esc_html__( 'Price Sign Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['subtotal_price_sign'],
			)
		);

		$this->add_control(
			'total_order_total_price_color',
			array(
				'label'     => esc_html__( 'Total Price Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['total_price'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'total_order_total_price_typography',
				'label'    => esc_html__( 'Total Price Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['total_price'],
			)
		);

		$this->add_control(
			'total_order_total_price_sign_color',
			array(
				'label'     => esc_html__( 'Total Price Sign Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['total_price_sign'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'total_order_total_price_sign_typography',
				'label'    => esc_html__( 'Total Price Sign Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['total_price_sign'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'total_cart_button_styles',
			array(
				'label' => esc_html__( 'Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'total_cart_button',
			[
				'label'      => __( 'Button Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', ],
				'range'      => [
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['button'] => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'total_cart', $css_scheme['button'] );

		$this->add_responsive_control(
			'total_cart_button_align',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'selectors' => array(
					'{{WRAPPER}} .wc-proceed-to-checkout' => 'text-align: {{VALUE}}',
				),
				'separator' => 'before',
				'classes'   => 'elementor-control-align',
			)
		);

		$this->add_responsive_control(
			'total_cart_button_margin',
			[
				'label'      => __( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .cart_totals .wc-proceed-to-checkout' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
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
