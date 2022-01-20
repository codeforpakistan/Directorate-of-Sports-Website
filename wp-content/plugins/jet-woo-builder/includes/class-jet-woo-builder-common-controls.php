<?php
/**
 * JetWooBuilder Elementor common controls class
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Builder_Common_Controls' ) ) {

	/**
	 * Define Jet_Woo_Builder_Parser class
	 */
	class Jet_Woo_Builder_Common_Controls {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.7.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Init common controls.
		 */
		public function __construct() {
		}

		/**
		 * Register WooCommerce style warning message
		 *
		 * @param $obj
		 */
		public function register_wc_style_warning( $obj ) {
			$obj->add_control(
				'wc_style_warning',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( 'The style and view of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'jet-woo-builder' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		/**
		 * Register button widgets style controls
		 *
		 * @since 1.7.0
		 *
		 * @param $id
		 * @param $css_scheme
		 *
		 * @param $obj
		 */
		public function register_button_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_button_typography',
					'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_responsive_control(
				$id . '_button_padding',
				array(
					'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->start_controls_tabs( $id . '_button_style_tabs' );

			$obj->start_controls_tab(
				$id . '_button_normal_styles',
				array(
					'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
				)
			);

			$obj->add_control(
				$id . '_button_normal_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme => 'color: {{VALUE}} !important',
					),
				)
			);

			$obj->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => $id . '_button_background',
					'label'          => __( 'Background', 'jet-woo-builder' ),
					'types'          => [ 'classic', 'gradient' ],
					'exclude'        => [ 'image' ],
					'selector'       => '{{WRAPPER}} ' . $css_scheme,
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color'      => [
							'global' => [
								'default' => Global_Colors::COLOR_ACCENT,
							],
						],
					],
				]
			);

			$obj->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => $id . '_button_normal_border',
					'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_responsive_control(
				$id . '_button_normal_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->start_controls_tab(
				$id . '_button_hover_styles',
				array(
					'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
				)
			);

			$obj->add_control(
				$id . '_button_hover_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme . ':hover' => 'color: {{VALUE}} !important',
					),
				)
			);

			$obj->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => $id . '_button_background_hover',
					'label'          => __( 'Background', 'jet-woo-builder' ),
					'types'          => [ 'classic', 'gradient' ],
					'exclude'        => [ 'image' ],
					'selector'       => '{{WRAPPER}} ' . $css_scheme . ':hover, {{WRAPPER}} ' . $css_scheme . ':focus',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
					],
				]
			);

			$obj->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => $id . '_button_hover_border',
					'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme . ':hover',
				)
			);

			$obj->add_responsive_control(
				$id . '_button_hover_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->end_controls_tabs();

		}

		/**
		 * Register heading widgets style controls
		 *
		 * @since 1.7.0
		 *
		 * @param $id
		 * @param $css_scheme
		 *
		 * @param $obj
		 */
		public function register_heading_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_heading_typography',
					'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_control(
				$id . '_heading_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_heading_margin',
				array(
					'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_heading_align',
				[
					'label'     => __( 'Alignment', 'jet-woo-builder' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
					'selectors' => [
						'{{WRAPPER}} ' . $css_scheme => 'text-align: {{VALUE}}',
					],
					'classes'   => 'elementor-control-align',
				]
			);

		}

		/**
		 * Register input widgets style controls
		 *
		 * @since 1.7.0
		 *
		 * @param $id
		 * @param $css_scheme
		 *
		 * @param $obj
		 */
		public function register_input_style_controls( $obj = null, $id = '', $css_scheme = '', $margin = true ) {

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_input_typography',
					'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_control(
				$id . '_input_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme                                                     => 'color: {{VALUE}}',
						'{{WRAPPER}} .select2-container .select2-selection .select2-selection__rendered' => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'     => $id . '_input_background',
					'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme . ', {{WRAPPER}} .select2-container .select2-selection',
				)
			);

			$obj->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => $id . '_input_border',
					'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_responsive_control(
				$id . '_input_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme                        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .select2-container .select2-selection' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			if ( $margin ) {
				$obj->add_responsive_control(
					$id . '_input_margin',
					array(
						'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
							'{{WRAPPER}} ' . $css_scheme => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);
			}

			$obj->add_responsive_control(
				$id . '_input_padding',
				array(
					'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme                                                  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .select2-container .select2-selection .select2-selection__arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		}

		/**
		 * Register label widgets style controls
		 *
		 * @since 1.7.0
		 *
		 * @param $id
		 * @param $css_scheme
		 *
		 * @param $obj
		 */
		public function register_label_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_label_typography',
					'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_control(
				$id . '_label_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_control(
				$id . '_label_required_color',
				array(
					'label'     => esc_html__( 'Required Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme . ' abbr'      => 'color: {{VALUE}}',
						'{{WRAPPER}} ' . $css_scheme . ' .required' => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_label_margin',
				array(
					'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_label_align',
				array(
					'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'    => array(
							'title' => esc_html__( 'Left', 'jet-woo-builder' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => esc_html__( 'Center', 'jet-woo-builder' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'   => array(
							'title' => esc_html__( 'Right', 'jet-woo-builder' ),
							'icon'  => 'eicon-text-align-right',
						),
						'justify' => array(
							'title' => esc_html__( 'Justified', 'jet-woo-builder' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme => 'text-align: {{VALUE}}',
					),
					'classes'   => 'elementor-control-align',
				)
			);

		}

		/**
		 * Register form widgets style controls
		 *
		 * @since 1.7.0
		 *
		 * @param $id
		 * @param $css_scheme
		 *
		 * @param $obj
		 */
		public function register_form_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_form_typography',
					'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme . ' p',
				)
			);

			$obj->add_control(
				$id . '_form_text_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme . ' p' => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'     => $id . '_form_background',
					'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => $id . '_form_border',
					'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_responsive_control(
				$id . '_form_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_form_margin',
				array(
					'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_form_padding',
				array(
					'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		}

		/**
		 * Register table cell widgets style controls
		 *
		 * @since 1.7.0
		 *
		 * @param $id
		 * @param $css_scheme
		 *
		 * @param $obj
		 */
		public function register_table_cell_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'     => $id . '_cell_background',
					'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => $id . '_cell_border',
					'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_responsive_control(
				$id . '_cell_padding',
				array(
					'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_cell_align',
				array(
					'label'     => __( 'Alignment', 'jet-woo-builder' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'    => array(
							'title' => esc_html__( 'Left', 'jet-woo-builder' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => esc_html__( 'Center', 'jet-woo-builder' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'   => array(
							'title' => esc_html__( 'Right', 'jet-woo-builder' ),
							'icon'  => 'eicon-text-align-right',
						),
						'justify' => array(
							'title' => esc_html__( 'Justified', 'jet-woo-builder' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme => 'text-align: {{VALUE}}',
					),
					'classes'   => 'elementor-control-align',
				)
			);

		}

		/**
		 * Register controls for managing checkout forms fields.
		 *
		 * @param $obj
		 */
		public function register_checkout_forms_manage_fields_controls( $obj ) {

			$obj->add_control(
				'modify_field',
				[
					'label' => esc_html__( 'Modify Fields', 'jet-woo-builder' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'field_key',
				[
					'label'   => esc_html__( 'Field name', 'jet-woo-builder' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'first_name',
					'options' => [
						'first_name' => esc_html__( 'First Name', 'jet-woo-builder' ),
						'last_name'  => esc_html__( 'Last Name', 'jet-woo-builder' ),
						'company'    => esc_html__( 'Company', 'jet-woo-builder' ),
						'country'    => esc_html__( 'Country', 'jet-woo-builder' ),
						'address_1'  => esc_html__( 'Street address', 'jet-woo-builder' ),
						'address_2'  => esc_html__( 'Apartment address', 'jet-woo-builder' ),
						'city'       => esc_html__( 'Town / City', 'jet-woo-builder' ),
						'state'      => esc_html__( 'District', 'jet-woo-builder' ),
						'postcode'   => esc_html__( 'Postcode / ZIP', 'jet-woo-builder' ),
						'phone'      => esc_html__( 'Phone', 'jet-woo-builder' ),
						'email'      => esc_html__( 'Email', 'jet-woo-builder' ),
					],
				]
			);

			$repeater->add_control(
				'field_label',
				[
					'label' => esc_html__( 'Label', 'jet-woo-builder' ),
					'type'  => Controls_Manager::TEXT,
				]
			);

			$repeater->add_control(
				'field_placeholder',
				[
					'label' => esc_html__( 'Placeholder', 'jet-woo-builder' ),
					'type'  => Controls_Manager::TEXT,
				]
			);

			$repeater->add_control(
				'field_default_value',
				[
					'label' => esc_html__( 'Default Value', 'jet-woo-builder' ),
					'type'  => Controls_Manager::TEXT,
				]
			);

			$repeater->add_control(
				'field_validation',
				[
					'label'       => esc_html__( 'Validation', 'jet-woo-builder' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'options'     => [
						'email'    => esc_html__( 'Email', 'jet-woo-builder' ),
						'phone'    => esc_html__( 'Phone', 'jet-woo-builder' ),
						'postcode' => esc_html__( 'Postcode', 'jet-woo-builder' ),
						'state'    => esc_html__( 'State', 'jet-woo-builder' ),
						'number'   => esc_html__( 'Number', 'jet-woo-builder' ),
					],
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'field_class',
				[
					'label'   => esc_html__( 'Class', 'jet-woo-builder' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'form-row-wide',
					'options' => [
						'form-row-first' => esc_html( 'form-row-first' ),
						'form-row-last'  => esc_html( 'form-row-last' ),
						'form-row-wide'  => esc_html( 'form-row-wide' ),
					],
				]
			);

			$repeater->add_control(
				'field_required',
				[
					'label' => esc_html__( 'Required', 'jet-woo-builder' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);


			$obj->add_control(
				'field_list',
				[
					'label'       => esc_html__( 'Field List', 'jet-woo-builder' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'condition'   => [
						'modify_field' => 'yes',
					],
					'default'     => [
						[
							'field_key'           => 'first_name',
							'field_label'         => esc_html__( 'First Name', 'jet-woo-builder' ),
							'field_placeholder'   => '',
							'field_default_value' => '',
							'field_validation'    => '',
							'field_class'         => 'form-row-first',
							'field_required'      => 'yes',
						],
						[
							'field_key'           => 'last_name',
							'field_label'         => esc_html__( 'Last Name', 'jet-woo-builder' ),
							'field_placeholder'   => '',
							'field_default_value' => '',
							'field_validation'    => '',
							'field_class'         => 'form-row-last',
							'field_required'      => 'yes',
						],
						[
							'field_key'           => 'company',
							'field_label'         => esc_html__( 'Company name', 'jet-woo-builder' ),
							'field_placeholder'   => '',
							'field_default_value' => '',
							'field_validation'    => '',
							'field_class'         => 'form-row-wide',
							'field_required'      => '',
						],
						[
							'field_key'           => 'country',
							'field_label'         => esc_html__( 'Country', 'jet-woo-builder' ),
							'field_placeholder'   => '',
							'field_default_value' => '',
							'field_validation'    => '',
							'field_class'         => 'form-row-wide address-field update_totals_on_change',
							'field_required'      => 'yes',
						],
						[
							'field_key'           => 'address_1',
							'field_label'         => esc_html__( 'Street address', 'jet-woo-builder' ),
							'field_placeholder'   => '',
							'field_default_value' => '',
							'field_validation'    => '',
							'field_class'         => 'form-row-wide address-field',
							'field_required'      => 'yes',
						],
						[
							'field_key'           => 'address_2',
							'field_label'         => esc_html__( 'Apartment address', 'jet-woo-builder' ),
							'field_placeholder'   => esc_html__( 'Apartment, suite, unit etc. (optional)', 'jet-woo-builder' ),
							'field_default_value' => '',
							'field_validation'    => '',
							'field_class'         => 'form-row-wide address-field',
							'field_required'      => '',
						],
						[
							'field_key'           => 'city',
							'field_label'         => esc_html__( 'Town / City', 'jet-woo-builder' ),
							'field_placeholder'   => '',
							'field_default_value' => '',
							'field_validation'    => '',
							'field_class'         => 'form-row-wide address-field',
							'field_required'      => 'yes',
						],
						[
							'field_key'           => 'state',
							'field_label'         => esc_html__( 'State / County', 'jet-woo-builder' ),
							'field_placeholder'   => '',
							'field_default_value' => '',
							'field_validation'    => [ 'state' ],
							'field_class'         => 'form-row-wide address-field',
							'field_required'      => '',
						],
						[
							'field_key'           => 'postcode',
							'field_label'         => esc_html__( 'Postcode / ZIP', 'jet-woo-builder' ),
							'field_placeholder'   => '',
							'field_default_value' => '',
							'field_validation'    => [ 'postcode' ],
							'field_class'         => 'form-row-wide address-field',
							'field_required'      => 'yes',
						],
						[
							'field_key'           => 'phone',
							'field_label'         => esc_html__( 'Phone', 'jet-woo-builder' ),
							'field_placeholder'   => '',
							'field_default_value' => '',
							'field_validation'    => [ 'phone' ],
							'field_class'         => 'form-row-wide',
							'field_required'      => 'yes',
						],
						[
							'field_key'           => 'email',
							'field_label'         => esc_html__( 'Email address', 'jet-woo-builder' ),
							'field_placeholder'   => '',
							'field_default_value' => '',
							'field_validation'    => [ 'email' ],
							'field_class'         => 'form-row-wide',
							'field_required'      => 'yes',
						],
					],
					'title_field' => '{{{ field_label }}}',
				]
			);

		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.7.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;

		}

	}

}

/**
 * Returns instance of Jet_Woo_Builder_Common_Controls
 *
 * @since 1.7.0
 * @return object
 */
function jet_woo_builder_common_controls() {
	return Jet_Woo_Builder_Common_Controls::get_instance();
}
