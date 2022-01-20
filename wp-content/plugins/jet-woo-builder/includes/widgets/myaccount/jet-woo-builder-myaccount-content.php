<?php
/**
 * Class: Jet_Woo_Builder_MyAccount_Content
 * Name: My Account Content
 * Slug: jet-myaccount-content
 */

namespace Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_MyAccount_Content extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-myaccount-content';
	}

	public function get_title() {
		return esc_html__( 'My Account Content', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-my-account-content';
	}

	public function get_jet_help_url() {
		return 'https://crocoblock.com/knowledge-base/articles/jetwoobuilder-how-to-create-my-account-page-template/';
	}

	public function get_categories() {
		return [ 'jet-woo-builder' ];
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'myaccount' );
	}

	protected function register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-woo-builder-myaccount-content-endpoints/css-scheme',
			[
				'forms_heading'               => '.elementor-jet-myaccount-content  h3',
				'forms_labels'                => '.elementor-jet-myaccount-content form:not(.woocommerce-EditAccountForm) .form-row label',
				'forms_buttons'               => '.elementor-jet-myaccount-content form:not(.woocommerce-EditAccountForm) .button',
				'forms_inputs'                => '.elementor-jet-myaccount-content form:not(.woocommerce-EditAccountForm) .form-row .woocommerce-input-wrapper > *:not(.woocommerce-password-strength):not(.woocommerce-password-hint):not(.show-password-input)',
				'order_details_status'        => '.elementor-jet-myaccount-content mark',
				'downloads_header'            => '.elementor-jet-myaccount-content .woocommerce-order-downloads .woocommerce-order-downloads__title',
				'downloads_heading'           => '.elementor-jet-myaccount-content > :not(.jet-woo-account-downloads-content) .woocommerce-table.woocommerce-table--order-downloads thead th',
				'downloads_cell'              => '.elementor-jet-myaccount-content > :not(.jet-woo-account-downloads-content) .woocommerce-table.woocommerce-table--order-downloads tbody tr td',
				'downloads_button'            => '.elementor-jet-myaccount-content > :not(.jet-woo-account-downloads-content) .woocommerce-table.woocommerce-table--order-downloads .download-file a.woocommerce-MyAccount-downloads-file',
				'order_details_heading'       => '.elementor-jet-myaccount-content .woocommerce-order-details .woocommerce-order-details__title',
				'order_details_table_heading' => '.elementor-jet-myaccount-content .woocommerce-order-details .woocommerce-table.order_details tr th',
				'order_details_table_content' => '.elementor-jet-myaccount-content .woocommerce-order-details .woocommerce-table.shop_table.order_details tr td',
				'order_details_button'        => '.elementor-jet-myaccount-content .woocommerce-order-details .order-again .button',
				'address_heading'             => '.elementor-jet-myaccount-content .woocommerce-customer-details .woocommerce-column__title',
				'address_content'             => '.elementor-jet-myaccount-content .woocommerce-customer-details address',
			]
		);

		$this->start_controls_section(
			'my_account_content',
			[
				'label' => esc_html__( 'Content', 'jet-woo-builder' ),
			]
		);

		$this->add_control(
			'my_account_content_info',
			[
				'raw'             => esc_html__( 'Use this widget for display My Account Page Endpoints.', 'jet-woo-builder' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->end_controls_section();

		// Address form header controls
		$this->start_controls_section(
			'my_account_addresses_forms_heading_styles',
			[
				'label' => esc_html__( 'Addresses Forms Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'my_account_addresses_forms', $css_scheme['forms_heading'] );

		$this->end_controls_section();

		// Address form labels controls
		$this->start_controls_section(
			'my_account_addresses_forms_labels_styles',
			[
				'label' => esc_html__( 'Addresses Forms Labels', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		jet_woo_builder_common_controls()->register_label_style_controls( $this, 'my_account_addresses_labels', $css_scheme['forms_labels'] );

		$this->end_controls_section();

		// Address form input controls
		$this->start_controls_section(
			'my_account_addresses_forms_inputs_styles',
			[
				'label' => esc_html__( 'Addresses Forms Inputs', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		jet_woo_builder_common_controls()->register_input_style_controls( $this, 'my_account_addresses_inputs', $css_scheme['forms_inputs'] );

		$this->end_controls_section();

		// Address form buttons controls
		$this->start_controls_section(
			'my_account_addresses_forms_buttons_styles',
			[
				'label' => esc_html__( 'Addresses Forms Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'my_account_addresses_buttons', $css_scheme['forms_buttons'] );

		$this->end_controls_section();

		// View order endpoint status controls
		$this->start_controls_section(
			'my_account_order_details_status_styles',
			[
				'label' => esc_html__( 'View Order Status', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'my_account_order_details_status_color',
			[
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['order_details_status'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'my_account_order_details_status_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['order_details_status'],
			]
		);

		$this->end_controls_section();

		// View order endpoint downloads table header controls
		$this->start_controls_section(
			'my_account_order_details_downloads_header_styles',
			[
				'label' => esc_html__( 'View Order Downloads Header', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'my_account_order_details_downloads_header', $css_scheme['downloads_header'] );

		$this->end_controls_section();

		// View order endpoint downloads table heading controls
		$this->start_controls_section(
			'my_account_order_details_downloads_heading_styles',
			[
				'label' => esc_html__( 'View Order Downloads Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'my_account_order_details_downloads_heading_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['downloads_heading'],
			]
		);

		$this->add_control(
			'my_account_order_details_downloads_heading_color',
			[
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['downloads_heading'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'my_account_order_details_downloads_heading_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['downloads_heading'],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'my_account_order_details_downloads_heading_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['downloads_heading'],
			]
		);

		$this->add_responsive_control(
			'my_account_order_details_downloads_heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['downloads_heading'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'my_account_order_details_downloads_heading_align',
			[
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['downloads_heading'] => 'text-align: {{VALUE}}',
				],
				'classes'   => 'elementor-control-align',
			]
		);

		$this->end_controls_section();

		// View order endpoint downloads table cells controls
		$this->start_controls_section(
			'my_account_order_details_downloads_cell_styles',
			[
				'label' => esc_html__( 'View Order Downloads Cell', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'my_account_order_details_downloads_cell_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['downloads_cell'],
			]
		);

		$this->add_control(
			'my_account_order_details_downloads_cell_color',
			[
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['downloads_cell'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'my_account_order_details_downloads_cell_order_color',
			[
				'label'     => esc_html__( 'Link Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['downloads_cell'] . ' a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'my_account_order_details_downloads_cell_order_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['downloads_cell'] . ' a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		jet_woo_builder_common_controls()->register_table_cell_style_controls( $this, 'my_account_order_details_downloads', $css_scheme['downloads_cell'] );

		$this->end_controls_section();

		// View order endpoint downloads table buttons controls
		$this->start_controls_section(
			'my_account_order_details_downloads_button_styles',
			[
				'label' => esc_html__( 'View Order Downloads Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'my_account_order_details_downloads', $css_scheme['downloads_button'] );

		$this->end_controls_section();

		// View order endpoint order table header controls
		$this->start_controls_section(
			'my_account_order_details_heading_styles',
			[
				'label' => esc_html__( 'View Order Table Header', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'my_account_order_details', $css_scheme['order_details_heading'] );

		$this->end_controls_section();

		// View order endpoint order table heading controls
		$this->start_controls_section(
			'my_account_order_details_table_heading_styles',
			[
				'label' => esc_html__( 'View Order Table Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'my_account_order_details_table_heading_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['order_details_table_heading'],
			]
		);

		$this->add_control(
			'my_account_order_details_table_heading_color',
			[
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['order_details_table_heading'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'my_account_order_details_table_heading_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['order_details_table_heading'],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'my_account_order_details_table_heading_border',
				'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['order_details_table_heading'],
			]
		);

		$this->add_responsive_control(
			'my_account_order_details_table_heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['order_details_table_heading'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'my_account_order_details_table_heading_align',
			[
				'label'     => esc_html__( 'Text Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['order_details_table_heading'] => 'text-align: {{VALUE}}',
				],
				'classes'   => 'elementor-control-align',
			]
		);

		$this->end_controls_section();

		// View order endpoint order table cells controls
		$this->start_controls_section(
			'my_account_order_details_cell_styles',
			[
				'label' => esc_html__( 'View Order Table Cells', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'my_account_order_details_cell_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['order_details_table_content'],
			]
		);

		$this->add_control(
			'my_account_order_details_cell_color',
			[
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['order_details_table_content']                        => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['order_details_table_content'] . ' .product-quantity' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'my_account_order_details_cell_link_color',
			[
				'label'     => esc_html__( 'Content Link Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['order_details_table_content'] . ' a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'my_account_order_details_cell_link_hover_color',
			[
				'label'     => esc_html__( 'Content Link Hover Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['order_details_table_content'] . ' a:hover' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		jet_woo_builder_common_controls()->register_table_cell_style_controls( $this, 'my_account_order_details', $css_scheme['order_details_table_content'] );

		$this->end_controls_section();

		// View order endpoint order table buttons controls
		$this->start_controls_section(
			'my_account_order_details_action_button_styles',
			[
				'label' => esc_html__( 'View Order Action Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'my_account_order_details_action', $css_scheme['order_details_button'] );

		$this->add_responsive_control(
			'my_account_order_details_action_button_align',
			[
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'selectors' => [
					'{{WRAPPER}} .elementor-jet-myaccount-content .woocommerce-order-details .order-again' => 'text-align: {{VALUE}}',
				],
				'classes'   => 'elementor-control-align',
			]
		);

		$this->end_controls_section();

		// View order endpoint addresses headers controls
		$this->start_controls_section(
			'my_account_order_details_address_heading_styles',
			[
				'label' => esc_html__( 'View Order Address Headers', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'my_account_order_details_address', $css_scheme['address_heading'] );

		$this->end_controls_section();

		// View order endpoint addresses content controls
		$this->start_controls_section(
			'my_account_order_details_address_content_styles',
			[
				'label' => esc_html__( 'View Order Address Content', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'my_account_order_details_address_content_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['address_content'],
			]
		);

		$this->add_control(
			'my_account_order_details_address_content_color',
			[
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['address_content'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'my_account_order_details_address_content_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['address_content'],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'my_account_order_details_address_content_border',
				'label'     => esc_html__( 'Border', 'jet-woo-builder' ),
				'selector'  => '{{WRAPPER}} ' . $css_scheme['address_content'],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'my_account_order_details_address_content_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['address_content'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);

		$this->add_responsive_control(
			'my_account_order_details_address_content_margin',
			[
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['address_content'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'my_account_order_details_address_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['address_content'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'my_account_order_details_address_content_align',
			[
				'label'     => esc_html__( 'Text Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['address_content'] => 'text-align: {{VALUE}}',
				],
				'classes'   => 'elementor-control-align',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		do_action( 'woocommerce_account_content' );

		$this->__close_wrap();

	}
}
