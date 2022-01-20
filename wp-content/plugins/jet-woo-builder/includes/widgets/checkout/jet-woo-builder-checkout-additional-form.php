<?php
/**
 * Class: Jet_Woo_Builder_Checkout_Additional_Form
 * Name: Checkout Additional Form
 * Slug: jet-checkout-additional-form
 */

namespace Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Checkout_Additional_Form extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-checkout-additional-form';
	}

	public function get_title() {
		return esc_html__( 'Checkout Additional Form', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-checkout-additional-form';
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
			'jet-woo-builder/jet-checkout-additional-form/css-scheme',
			array(
				'heading'  => '.woocommerce-additional-fields > h3',
				'label'    => '.woocommerce-additional-fields .form-row label',
				'textarea' => '.woocommerce-additional-fields textarea',
			)
		);

		$this->start_controls_section(
			'checkout_additional_form_content',
			array(
				'label' => esc_html__( 'General', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );

		$this->add_control(
			'checkout_additional_form_custom_labels',
			[
				'label' => __( 'Enable Custom Textarea Labels', 'jet-woo-builder' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'checkout_additional_form_title_text',
			[
				'label'       => esc_html__( 'Heading', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Additional information', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type your heading here', 'jet-woo-builder' ),
			]
		);

		$this->add_control(
			'checkout_additional_form_label_text',
			[
				'label'       => esc_html__( 'Label', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Order notes', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type your label here', 'jet-woo-builder' ),
				'condition'   => [
					'checkout_additional_form_custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'checkout_additional_form_placeholder_text',
			[
				'label'       => esc_html__( 'Placeholder', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Notes about your order, e.g. special notes for delivery.', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type your placeholder here', 'jet-woo-builder' ),
				'condition'   => [
					'checkout_additional_form_custom_labels' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_additional_heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'checkout_additional', $css_scheme['heading'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_additional_label_styles',
			array(
				'label' => esc_html__( 'Label', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_label_style_controls( $this, 'checkout_additional', $css_scheme['label'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_additional_textarea_styles',
			array(
				'label' => esc_html__( 'Input', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'checkout_additional_input_min_height',
			[
				'label'      => esc_html__( 'Input Minimal Height', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
				],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 300,
					],
				],
				'default'    => [
					'size' => 150,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['textarea'] => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		jet_woo_builder_common_controls()->register_input_style_controls( $this, 'checkout_additional', $css_scheme['textarea'] );

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();

	}

}
