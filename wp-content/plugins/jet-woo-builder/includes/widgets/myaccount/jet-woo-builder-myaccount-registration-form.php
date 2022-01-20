<?php
/**
 * Class: Jet_Woo_Builder_MyAccount_Registration_Form
 * Name: My Account Registration Form
 * Slug: jet-myaccount-registration-form
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_MyAccount_Registration_Form extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-myaccount-registration-form';
	}

	public function get_title() {
		return esc_html__( 'My Account Registration Form', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-my-account-registration-form';
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
			'jet-woo-builder/jet-woo-builder-myaccount-registration-form/css-scheme',
			array(
				'heading' => '.elementor-jet-myaccount-registration-form h2',
				'form'    => '.elementor-jet-myaccount-registration-form form.woocommerce-form-register',
				'label'   => '.elementor-jet-myaccount-registration-form form.woocommerce-form-register .form-row label',
				'input'   => '.elementor-jet-myaccount-registration-form form.woocommerce-form-register input.input-text',
				'button'  => '.elementor-jet-myaccount-registration-form button',
				'privacy' => '.elementor-jet-myaccount-registration-form form .woocommerce-privacy-policy-text p',
			)
		);

		$this->start_controls_section(
			'myaccount_registration_heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );
		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'myaccount_registration', $css_scheme['heading'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'myaccount_registration_form_styles',
			array(
				'label' => esc_html__( 'Form', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_form_style_controls( $this, 'myaccount_registration', $css_scheme['form'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'myaccount_registration_label_styles',
			array(
				'label' => esc_html__( 'Label', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_label_style_controls( $this, 'myaccount_registration', $css_scheme['label'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'myaccount_registration_input_styles',
			array(
				'label' => esc_html__( 'Input', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_input_style_controls( $this, 'myaccount_registration', $css_scheme['input'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'myaccount_registration_button_styles',
			array(
				'label' => esc_html__( 'Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'myaccount_registration', $css_scheme['button'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'myaccount_registration_privacy_styles',
			array(
				'label' => esc_html__( 'Privacy Policy', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'myaccount_registration_privacy_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['privacy'],
			)
		);

		$this->add_control(
			'myaccount_registration_privacy_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['privacy'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'myaccount_registration_privacy_link_color',
			array(
				'label'     => esc_html__( 'Link Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['privacy'] . ' a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'myaccount_registration_privacy_link_hover_color',
			array(
				'label'     => esc_html__( 'Link Hover Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['privacy'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'myaccount_registration_privacy_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['privacy'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
