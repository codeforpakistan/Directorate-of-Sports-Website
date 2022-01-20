<?php
/**
 * Class: Jet_Woo_Builder_MyAccount_Order
 * Name: My Account Order
 * Slug: jet-myaccount-order
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_MyAccount_Order extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-myaccount-order';
	}

	public function get_title() {
		return esc_html__( 'My Account Order', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-my-account-order';
	}

	public function get_jet_help_url() {
		return 'https://crocoblock.com/knowledge-base/articles/jetwoobuilder-how-to-create-my-account-page-template/';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'myaccount' );
	}

	protected function register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-woo-builder-myaccount-order/css-scheme',
			array(
				'heading'           => '.woocommerce-orders-table .woocommerce-orders-table__header',
				'cell'              => '.woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell',
				'button'            => '.woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a.woocommerce-button',
				'navigation_button' => '.jet-woo-account-orders-content + .woocommerce-pagination--without-numbers a.woocommerce-button',
			)
		);

		$this->start_controls_section(
			'myaccount_heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'myaccount_heading_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['heading'],
			)
		);

		$this->add_control(
			'myaccount_heading_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['heading'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'myaccount_heading_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['heading'],
			)
		);

		$this->add_responsive_control(
			'myaccount_heading_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['heading'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'myaccount_heading_align',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['heading'] => 'text-align: {{VALUE}}',
				),
				'classes'   => 'elementor-control-align',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'myaccount_cell_styles',
			array(
				'label' => esc_html__( 'Cells', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'myaccount_cell_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['cell'],
			)
		);

		$this->add_control(
			'myaccount_cell_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'myaccount_cell_order_color',
			array(
				'label'     => esc_html__( 'Order Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] . ' a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'myaccount_cell_order_hover_color',
			array(
				'label'     => esc_html__( 'Order Hover Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		jet_woo_builder_common_controls()->register_table_cell_style_controls( $this, 'myaccount_order', $css_scheme['cell'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'myaccount_order_button_styles',
			array(
				'label' => esc_html__( 'Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'myaccount_order', $css_scheme['button'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'myaccount_order_navigation_button_styles',
			array(
				'label' => esc_html__( 'Navigation Buttons', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'myaccount_order_navigation_button_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '.jet-woo-builder-elementor ' . $css_scheme['navigation_button'],
			)
		);

		$this->add_responsive_control(
			'myaccount_order_navigation_button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.jet-woo-builder-elementor ' . $css_scheme['navigation_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'myaccount_order_navigation_button_style_tabs' );

		$this->start_controls_tab(
			'myaccount_order_navigation_button_normal_styles',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'myaccount_order_navigation_button_normal_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.jet-woo-builder-elementor ' . $css_scheme['navigation_button'] => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'myaccount_order_navigation_button_normal_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '.jet-woo-builder-elementor ' . $css_scheme['navigation_button'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'myaccount_order_navigation_button_normal_border',
				'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
				'selector' => '.jet-woo-builder-elementor ' . $css_scheme['navigation_button'],
			)
		);

		$this->add_responsive_control(
			'myaccount_order_navigation_button_normal_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.jet-woo-builder-elementor ' . $css_scheme['navigation_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'myaccount_order_navigation_button_hover_styles',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'myaccount_order_navigation_button_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.jet-woo-builder-elementor ' . $css_scheme['navigation_button'] . ':hover' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'myaccount_order_navigation_button_hover_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '.jet-woo-builder-elementor ' . $css_scheme['navigation_button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'myaccount_order_navigation_button_hover_border',
				'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
				'selector' => '.jet-woo-builder-elementor ' . $css_scheme['navigation_button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'myaccount_order_navigation_button_hover_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.jet-woo-builder-elementor ' . $css_scheme['navigation_button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'myaccount_order_navigation_button_align',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'selectors' => array(
					'.jet-woo-builder-elementor .jet-woo-account-orders-content + .woocommerce-pagination--without-numbers' => 'text-align: {{VALUE}};',
				),
				'separator' => 'before',
				'classes'   => 'elementor-control-align',
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
