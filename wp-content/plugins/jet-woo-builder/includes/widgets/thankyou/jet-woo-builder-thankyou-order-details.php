<?php
/**
 * Class: Jet_Woo_Builder_ThankYou_Order_Details
 * Name: Thank You Order Details
 * Slug: jet-thankyou-order-details
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_ThankYou_Order_Details extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-thankyou-order-details';
	}

	public function get_title() {
		return esc_html__( 'Thank You Order Details', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-thank-you-order-details';
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
			'jet-woo-builder/jet-thankyou-order-details/css-scheme',
			array(
				'heading'       => '.woocommerce-order-details .woocommerce-order-details__title',
				'table_heading' => '.woocommerce-order-details .woocommerce-table.order_details tr th',
				'table_content' => '.woocommerce-order-details .woocommerce-table.shop_table.order_details tr td',
			)
		);

		$this->start_controls_section(
			'thankyou_details_heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );
		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'thankyou_details', $css_scheme['heading'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_details_table_heading_styles',
			array(
				'label' => esc_html__( 'Table Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'thankyou_details_table_heading_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_heading'],
			)
		);

		$this->add_control(
			'thankyou_details_table_heading_color',
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
				'name'     => 'thankyou_details_table_heading_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_heading'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'thankyou_details_table_heading_border',
				'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_heading'],
			)
		);

		$this->add_responsive_control(
			'thankyou_details_table_heading_padding',
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
			'thankyou_details_table_heading_align',
			array(
				'label'     => esc_html__( 'Text Alignment', 'jet-woo-builder' ),
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
			'thankyou_details_cell_styles',
			array(
				'label' => esc_html__( 'Table Cells', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'thankyou_details_cell_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_content'],
			)
		);

		$this->add_control(
			'thankyou_details_cell_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['table_content']                        => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['table_content'] . ' .product-quantity' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'thankyou_details_cell_link_color',
			array(
				'label'     => esc_html__( 'Content Link Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['table_content'] . ' a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'thankyou_details_cell_link_hover_color',
			array(
				'label'     => esc_html__( 'Content Link Hover Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['table_content'] . ' a:hover' => 'color: {{VALUE}}',
				),
				'separator' => 'after',
			)
		);

		jet_woo_builder_common_controls()->register_table_cell_style_controls( $this, 'thankyou_details', $css_scheme['table_content'] );

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();

	}

}
