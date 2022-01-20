<?php
/**
 * Class: Jet_Woo_Builder_MyAccount_Downloads
 * Name: My Account Downloads
 * Slug: jet-myaccount-downloads
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_MyAccount_Downloads extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-myaccount-downloads';
	}

	public function get_title() {
		return esc_html__( 'My Account Downloads', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-my-account-downloads';
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
			'jet-woo-builder/jet-myaccount-downloads/css-scheme',
			array(
				'heading' => '.elementor-jet-myaccount-downloads .woocommerce-table.woocommerce-table--order-downloads thead th',
				'cell'    => '.elementor-jet-myaccount-downloads .woocommerce-table.woocommerce-table--order-downloads tbody tr td',
				'button'  => '.elementor-jet-myaccount-downloads .woocommerce-table.woocommerce-table--order-downloads .download-file a.woocommerce-MyAccount-downloads-file',
			)
		);

		$this->start_controls_section(
			'myaccount_downloads_heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'myaccount_downloads_heading_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['heading'],
			)
		);

		$this->add_control(
			'myaccount_downloads_heading_color',
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
				'name'        => 'myaccount_downloads_heading_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['heading'],
			)
		);

		$this->add_responsive_control(
			'myaccount_downloads_heading_padding',
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
			'myaccount_downloads_heading_align',
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
			'myaccount_downloads_cell_styles',
			array(
				'label' => esc_html__( 'Cells', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'myaccount_downloads_cell_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['cell'],
			)
		);

		$this->add_control(
			'myaccount_downloads_cell_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'myaccount_downloads_cell_order_color',
			array(
				'label'     => esc_html__( 'Link Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] . ' a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'myaccount_downloads_cell_order_hover_color',
			array(
				'label'     => esc_html__( 'Link Hover Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		jet_woo_builder_common_controls()->register_table_cell_style_controls( $this, 'myaccount_downloads_order', $css_scheme['cell'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'myaccount_downloads_order_button_styles',
			array(
				'label' => esc_html__( 'Download Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'myaccount_downloads_order', $css_scheme['button'] );

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();

	}
}
