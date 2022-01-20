<?php
/**
 * Class: Jet_Woo_Builder_Products_Loop
 * Name: Products Loop
 * Slug: jet-woo-builder-products-loop
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Products_Loop extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-woo-builder-products-loop';
	}

	public function get_title() {
		return esc_html__( 'Products Loop', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-shop-loop';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_jet_help_url() {
		return 'https://crocoblock.com/knowledge-base/articles/jetwoobuilder-how-to-create-and-set-a-shop-page-template/';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'shop' );
	}

	protected function register_controls() {

		$templates    = jet_woo_builder_post_type()->get_templates_query_args( 'archive' );
		$admin_url    = admin_url( 'admin.php' );
		$notification = sprintf(
			'<p>%s <a href="%s" target="_blank">%s</a>.</p>',
			esc_html__( 'Make sure to Enable Custom Archive Product functionality before using', 'jet-woo-builder' ),
			esc_url( $admin_url . '?page=wc-settings&tab=jet-woo-builder-settings' ),
			esc_html__( 'here', 'jet-woo-builder' )
		);

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-woo-builder-products-loop/css-scheme',
			array(
				'switcher'              => '.jet-woo-builder-products-loop .jet-woo-switcher-controls-wrapper',
				'buttons'               => '.jet-woo-builder-products-loop .jet-woo-switcher-btn',
				'active_button'         => '.jet-woo-builder-products-loop .jet-woo-switcher-btn.active',
				'main_button'           => '.jet-woo-builder-products-loop .jet-woo-switcher-btn-main',
				'secondary_button'      => '.jet-woo-builder-products-loop .jet-woo-switcher-btn-secondary',
				'switcher_icon'         => '.jet-woo-builder-products-loop .jet-woo-switcher-btn .jet-woo-switcher-btn__icon',
				'switcher_icon_hover'   => '.jet-woo-builder-products-loop .jet-woo-switcher-btn:hover .jet-woo-switcher-btn__icon',
				'switcher_icon_active'  => '.jet-woo-builder-products-loop .jet-woo-switcher-btn.active .jet-woo-switcher-btn__icon',
				'switcher_label'        => '.jet-woo-builder-products-loop .jet-woo-switcher-btn .jet-woo-switcher-btn__label',
				'switcher_label_hover'  => '.jet-woo-builder-products-loop .jet-woo-switcher-btn:hover .jet-woo-switcher-btn__label',
				'switcher_label_active' => '.jet-woo-builder-products-loop .jet-woo-switcher-btn.active .jet-woo-switcher-btn__label',
			)
		);

		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'custom_templates_notification',
			array(
				'raw'             => $notification,
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->add_control(
			'archive_item_layout',
			array(
				'label'       => esc_html__( 'Select Archive item template:', 'jet-woo-builder' ),
				'label_block' => true,
				'type'        => 'jet-query',
				'query_type'  => 'post',
				'query'       => $templates,
				'edit_button' => array(
					'active' => true,
					'label'  => __( 'Edit Template', 'jet-woo-builder' ),
				),
				'separator'   => 'after',
			)
		);

		$this->add_control(
			'switcher_enable',
			array(
				'label'        => esc_html__( 'Enable layout switcher.', 'jet-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'main_layout_heading',
			array(
				'label'     => esc_html__( 'Main Layout', 'jet-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'switcher_enable' => 'yes',
				),
			)
		);

		$this->add_control(
			'main_layout',
			array(
				'label'       => esc_html__( 'Select template:', 'jet-woo-builder' ),
				'label_block' => true,
				'type'        => 'jet-query',
				'query_type'  => 'post',
				'query'       => $templates,
				'edit_button' => array(
					'active' => true,
					'label'  => __( 'Edit Template', 'jet-woo-builder' ),
				),
				'condition'   => array(
					'switcher_enable' => 'yes',
				),
			)
		);

		$this->__add_advanced_icon_control(
			'main_layout_switcher_icon',
			array(
				'label'       => esc_html__( 'Main layout icon', 'jet-woo-builder' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => 'fa fa-th',
				'fa5_default' => array(
					'value'   => 'fas fa-th',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'switcher_enable' => 'yes',
				),
			)
		);

		$this->add_control(
			'main_layout_switcher_label',
			array(
				'label'     => esc_html__( 'Main layout label', 'jet-woo-builder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Main', 'jet-woo-builder' ),
				'condition' => array(
					'switcher_enable' => 'yes',
				),
			)
		);

		$this->add_control(
			'secondary_layout_heading',
			array(
				'label'     => esc_html__( 'Secondary Layout', 'jet-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'switcher_enable' => 'yes',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'secondary_layout',
			array(
				'label'       => esc_html__( 'Select template:', 'jet-woo-builder' ),
				'label_block' => true,
				'type'        => 'jet-query',
				'query_type'  => 'post',
				'query'       => $templates,
				'edit_button' => array(
					'active' => true,
					'label'  => __( 'Edit Template', 'jet-woo-builder' ),
				),
				'condition'   => array(
					'switcher_enable' => 'yes',
				),
			)
		);

		$this->__add_advanced_icon_control(
			'secondary_layout_switcher_icon',
			array(
				'label'       => esc_html__( 'Secondary layout icon', 'jet-woo-builder' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => 'fa fa-th-list',
				'fa5_default' => array(
					'value'   => 'fas fa-th-list',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'switcher_enable' => 'yes',
				),
			)
		);

		$this->add_control(
			'secondary_layout_switcher_label',
			array(
				'label'     => esc_html__( 'Secondary layout label', 'jet-woo-builder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Secondary', 'jet-woo-builder' ),
				'condition' => array(
					'switcher_enable' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_switcher_general_style',
			array(
				'label'     => esc_html__( 'General', 'jet-woo-builder' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'switcher_enable' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'flex-end',
				'options'   => jet_woo_builder_tools()->get_available_flex_h_align_types(),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['switcher'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'switcher_background',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['switcher'],
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'switcher_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['switcher'],
				'separator'   => 'before',
			)
		);

		$this->add_responsive_control(
			'switcher_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['switcher'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'switcher_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['switcher'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_switcher_controls_style',
			array(
				'label'     => esc_html__( 'Controls', 'jet-woo-builder' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'switcher_enable' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_distance',
			array(
				'label'      => esc_html__( 'Distance Between Buttons', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['switcher'] => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'switcher_buttons_custom_size',
			array(
				'label'        => esc_html__( 'Custom Size', 'jet-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_custom_width',
			array(
				'label'      => esc_html__( 'Custom Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 40,
						'max' => 1000,
					),
					'em' => array(
						'min' => 1,
						'max' => 20,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['buttons'] => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'switcher_buttons_custom_size' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_custom_height',
			array(
				'label'      => esc_html__( 'Custom Height', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
					'em' => array(
						'min' => 1,
						'max' => 20,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['buttons'] => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'switcher_buttons_custom_size' => 'yes',
				),
				'separator'  => 'after',
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_content_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => jet_woo_builder_tools()->get_available_flex_h_align_types(),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['buttons'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['buttons'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_switcher_buttons_styles' );

		$this->start_controls_tab(
			'tab_switcher_buttons_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'switcher_buttons_normal_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['buttons'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'switcher_buttons_normal_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['buttons'],
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_normal_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['buttons'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'switcher_buttons_normal_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['buttons'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_switcher_buttons_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'switcher_buttons_hover_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['buttons'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'switcher_buttons_hover_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['buttons'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['buttons'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'switcher_buttons_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['buttons'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_switcher_buttons_active',
			array(
				'label' => esc_html__( 'Active', 'jet-woo-builder' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'switcher_buttons_active_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['active_button'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'switcher_buttons_active_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['active_button'],
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_active_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['active_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'switcher_buttons_active_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['active_button'],
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'switcher_buttons_label_heading',
			array(
				'label'     => esc_html__( 'Label', 'jet-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'switcher_buttons_label_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['switcher_label'],
			)
		);

		$this->start_controls_tabs( 'tabs_switcher_buttons_label_color' );

		$this->start_controls_tab(
			'tab_switcher_buttons_label_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'switcher_buttons_normal_label_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_switcher_buttons_label_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'switcher_buttons_hover_label_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_label_hover'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_switcher_buttons_label_color_active',
			array(
				'label' => esc_html__( 'Active', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'switcher_buttons_active_label_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_label_active'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'switcher_buttons_icon_heading',
			array(
				'label'     => esc_html__( 'Icon', 'jet-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_icon_font_size',
			array(
				'label'      => esc_html__( 'Font Size', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon'] => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_icon_box_width',
			array(
				'label'      => esc_html__( 'Icon Box Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_icon_box_height',
			array(
				'label'      => esc_html__( 'Icon Box Height', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon'] => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_icon_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['buttons'] => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_switcher_buttons_icon_box_styles' );

		$this->start_controls_tab(
			'tab_switcher_buttons_icon_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'switcher_buttons_normal_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'switcher_buttons_normal_icon_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'switcher_buttons_normal_icon_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['switcher_icon'],
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_normal_icon_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_switcher_buttons_icon_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'switcher_buttons_hover_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon_hover'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'switcher_buttons_hover_icon_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon_hover'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'switcher_buttons_hover_icon_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['switcher_icon_hover'],
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_hover_icon_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon_hover'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_switcher_buttons_icon_active',
			array(
				'label' => esc_html__( 'Active', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'switcher_buttons_active_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon_active'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'switcher_buttons_active_icon_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon_active'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'switcher_buttons_active_icon_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['switcher_icon_active'],
			)
		);

		$this->add_responsive_control(
			'switcher_buttons_active_icon_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['switcher_icon_active'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	public static function products_loop() {
		if ( jet_woo_builder_integration()->in_elementor() || is_product_taxonomy() || is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
			if ( woocommerce_product_loop() ) {
				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();

						do_action( 'woocommerce_shop_loop' );

						wc_get_template_part( 'content', 'product' );
					}
				}

				woocommerce_product_loop_end();

				wp_reset_postdata();
			} else {
				do_action( 'woocommerce_no_products_found' );
			}
		}
	}

	protected function render() {

		$this->__context = 'render';
		$settings        = $this->get_settings();
		$switcher_enable = filter_var( $settings['switcher_enable'], FILTER_VALIDATE_BOOLEAN );
		$display_type    = woocommerce_get_loop_display_mode();

		$this->__open_wrap();

		if ( 'yes' === jet_woo_builder_shop_settings()->get( 'custom_archive_page' ) ) {
			add_filter( 'jet-woo-builder/custom-archive-template', array( $this, 'get_default_custom_template' ) );
		}

		if ( $switcher_enable ) {
			add_filter( 'jet-woo-builder/jet-products-loop/switcher-option-enable', array( $this, 'get_switcher_option_status' ) );
		} else {
			unset( $_COOKIE['jet_woo_builder_layout'] );
		}

		if ( $switcher_enable && 'products' === $display_type ) {
			include $this->__get_global_template( 'index' );
		} else {
			echo '<div class="jet-woo-products-wrapper">';
			self::products_loop();
			echo '</div>';
		}

		$this->__close_wrap();

	}

	/**
	 * Define default archive item template
	 * if admin settings is empty or override if set.
	 *
	 * @param $custom_template
	 *
	 * @return mixed
	 */
	public function get_default_custom_template( $custom_template ) {

		$settings        = $this->get_settings();
		$switcher_enable = filter_var( $settings['switcher_enable'], FILTER_VALIDATE_BOOLEAN );
		$loop            = jet_woo_builder_integration_woocommerce()->get_current_loop();

		if ( 'archive' !== $loop ) {
			return $custom_template;
		}

		if ( $switcher_enable && ! empty( $settings['main_layout'] ) ) {
			$custom_template = $settings['main_layout'];
		} elseif ( ! empty( $settings['archive_item_layout'] ) ) {
			$custom_template = $settings['archive_item_layout'];
		} elseif ( 'default' !== jet_woo_builder_shop_settings()->get( 'archive_template' ) ) {
			$custom_template = jet_woo_builder_shop_settings()->get( 'archive_template' );
		} else {
			$custom_template = null;
		}

		return $custom_template;

	}

	/**
	 * Define if switcher is active.
	 *
	 * @param $switcher_enable
	 *
	 * @return bool
	 */
	public function get_switcher_option_status( $switcher_enable ) {

		$settings = $this->get_settings();

		if ( ! empty( $settings['switcher_enable'] ) ) {
			$switcher_enable = filter_var( $settings['switcher_enable'], FILTER_VALIDATE_BOOLEAN );
		}

		return $switcher_enable;

	}

}
