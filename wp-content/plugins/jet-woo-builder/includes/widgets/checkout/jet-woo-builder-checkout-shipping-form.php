<?php
/**
 * Class: Jet_Woo_Builder_Checkout_Shipping_Form
 * Name: Checkout Shipping Form
 * Slug: jet-checkout-shipping-form
 */

namespace Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Checkout_Shipping_Form extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-checkout-shipping-form';
	}

	public function get_title() {
		return esc_html__( 'Checkout Shipping Form', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-checkout-shipping-form';
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
			'jet-woo-builder/jet-checkout-shipping-form/css-scheme',
			[
				'heading' => '.woocommerce-shipping-fields #ship-to-different-address',
				'label'   => '.shipping_address .woocommerce-shipping-fields__field-wrapper .form-row label',
				'input'   => '.shipping_address .woocommerce-shipping-fields__field-wrapper .form-row .woocommerce-input-wrapper > *',
			]
		);

		$this->start_controls_section(
			'checkout_shipping_form_general_section',
			[
				'label' => __( 'General', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );

		$this->add_control(
			'checkout_shipping_form_enable_custom_title',
			[
				'label' => __( 'Enable Custom Title', 'jet-woo-builder' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'checkout_shipping_form_title_text',
			[
				'label'       => __( 'Custom Title', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Ship to a different address?', 'jet-woo-builder' ),
				'placeholder' => __( 'Type your title here', 'jet-woo-builder' ),
				'condition'   => [
					'checkout_shipping_form_enable_custom_title' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_shipping_manage_fields_section',
			array(
				'label' => esc_html__( 'Manage Fields', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		jet_woo_builder_common_controls()->register_checkout_forms_manage_fields_controls( $this );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_shipping_heading_styles',
			[
				'label' => __( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'checkout_shipping_heading_typography',
				'label'    => __( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['heading'] . ',{{WRAPPER}} ' . $css_scheme['heading'] . ' label',
			]
		);

		$this->add_control(
			'checkout_shipping_heading_color',
			[
				'label'     => __( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['heading'] . ' label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'checkout_shipping_heading_margin',
			[
				'label'      => __( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['heading'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'checkout_shipping_heading_align',
			[
				'label'     => __( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['heading'] => 'text-align: {{VALUE}}',
				],
				'classes'   => 'elementor-control-align',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_shipping_label_styles',
			array(
				'label' => esc_html__( 'Label', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_label_style_controls( $this, 'checkout_shipping', $css_scheme['label'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_shipping_input_styles',
			array(
				'label' => esc_html__( 'Input', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_input_style_controls( $this, 'checkout_shipping', $css_scheme['input'] );

		$this->end_controls_section();

	}

	protected function render() {

		$settings   = $this->get_settings_for_display();
		$field_list = $settings['field_list'];

		$items = [];

		if ( 'yes' === $settings['modify_field'] ) {
			if ( isset( $field_list ) ) {
				$priority = 10;

				foreach ( $field_list as $key => $field ) {
					$field_key = 'shipping_' . $field['field_key'];

					$items[ $field_key ] = [
						'label'       => $field['field_label'],
						'required'    => 'yes' === $field['field_required'],
						'class'       => [ $field['field_class'] ],
						'default'     => $field['field_default_value'],
						'placeholder' => $field['field_placeholder'],
						'validate'    => $field['field_validation'],
						'priority'    => $priority + 10,
					];

					$priority += 10;
				}
			}

			if ( ! empty( get_option( 'jet_woo_builder_wc_fields_shipping' ) ) || get_option( 'jet_woo_builder_wc_fields_shipping' ) ) {
				update_option( 'jet_woo_builder_wc_fields_shipping', $items );
			} else {
				add_option( 'jet_woo_builder_wc_fields_shipping', $items );
			}
		} else {
			delete_option( 'jet_woo_builder_wc_fields_shipping' );
		}

		$this->__context = 'render';

		$this->__open_wrap();

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();

	}

}
