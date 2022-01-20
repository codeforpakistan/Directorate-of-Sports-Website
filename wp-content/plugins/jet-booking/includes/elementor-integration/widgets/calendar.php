<?php
namespace JET_ABAF\Elementor_Integration\Widgets;

use JET_ABAF\Render\Calendar as Calendar_Renderer;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Calendar extends \Elementor\Widget_Base {

	public function get_name() {
		return 'jet-booking-calendar';
	}

	public function get_title() {
		return esc_html__( 'Booking Availability Calendar', 'jet-booking' );
	}

	public function get_icon() {
		return 'jet-engine-icon-listing-calendar';
	}

	public function get_categories() {
		return array( 'jet-listing-elements' );
	}

	public function get_help_url() {
		return 'https://crocoblock.com/knowledge-base/article-category/jetbooking/';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'Content', 'jet-booking' ),
			)
		);

		$this->add_control(
			'select_dates',
			array(
				'label'       => esc_html__( 'Allow to select dates', 'jet-booking' ),
				'description' => esc_html__( 'Find booking form on the page and set selected dates into check in/out field(s)', 'jet-booking' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'yes',
			)
		);

		$this->add_control(
			'scroll_to_form',
			array(
				'label'       => esc_html__( 'Scroll to the form', 'jet-booking' ),
				'description' => esc_html__( 'Scroll page to the start of the booking form on dates select', 'jet-booking' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => '',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_calendar_style',
			array(
				'label'      => esc_html__( 'General', 'jet-booking' ),
				'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => esc_html__( 'Months container padding', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					$this->css_selector( ' .date-picker-wrapper' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_control(
			'container_bg_color',
			array(
				'label' => esc_html__( 'Months container background', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' .date-picker-wrapper' ) => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'gap_color',
			array(
				'label' => esc_html__( 'Months gap line color', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#C9C9C9',
				'selectors' => array(
					$this->css_selector( ' .date-picker-wrapper .gap:before' ) => 'border-left-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'month_tables_heading',
			array(
				'label' => esc_html__( 'Month tables', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'table_padding',
			array(
				'label'      => esc_html__( 'Month table padding', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					$this->css_selector( ' .month1' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					$this->css_selector( ' .month2' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'table_bg_color',
			array(
				'label' => esc_html__( 'Month table background', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' .month1' ) => 'background-color: {{VALUE}}',
					$this->css_selector( ' .month2' ) => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'           => 'table_border',
				'label'          => esc_html__( 'Border', 'jet-booking' ),
				'placeholder'    => '1px',
				'selector'       => $this->css_selector( ' .month1' ) . ', ' . $this->css_selector( ' .month2' ),
			)
		);

		$this->add_responsive_control(
			'table_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					$this->css_selector( ' .month1' ) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					$this->css_selector( ' .month2' ) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'table_box_shadow',
				'selector' =>  $this->css_selector( ' .month1' ) . ', ' . $this->css_selector( ' .month2' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_style',
			array(
				'label'      => esc_html__( 'Headers', 'jet-booking' ),
				'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'month_names_heading',
			array(
				'label' => esc_html__( 'Month names', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'month_names_typography',
				'selector' => '{{WRAPPER}} thead .caption .month-name .month-element, {{WRAPPER}} thead .caption .month-name .month-element',
			)
		);

		$this->add_control(
			'month_names_color',
			array(
				'label' => esc_html__( 'Color', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' thead .caption .month-name' ) => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'month_names_bg_color',
			array(
				'label' => esc_html__( 'Background', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( '  thead .caption .month-name' ) => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'month_names_padding',
			array(
				'label'      => esc_html__( 'Cells Padding', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					$this->css_selector( ' thead .caption .month-name' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'           => 'month_names_border',
				'label'          => esc_html__( 'Border', 'jet-booking' ),
				'placeholder'    => '1px',
				'selector'       => $this->css_selector( ' thead .caption .month-name' ),
			)
		);

		$this->add_control(
			'month_switcher_heading',
			array(
				'label' => esc_html__( 'Month switcher', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_month_switcher_style' );

		$this->start_controls_tab(
			'month_switcher_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-booking' ),
			)
		);

		$this->add_control(
			'month_switcher_color',
			array(
				'label'  => esc_html__( 'Text Color', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' thead .caption .prev' ) => 'color: {{VALUE}}',
					$this->css_selector( ' thead .caption .next' ) => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'month_switcher_bg_color',
			array(
				'label'  => esc_html__( 'Background', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' thead .caption .prev' ) => 'background-color: {{VALUE}}',
					$this->css_selector( ' thead .caption .next' ) => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'month_switcher_font_size',
			array(
				'label'      => esc_html__( 'Font size', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 30,
						'max' => 200,
					),
				),
				'selectors'  => array(
					$this->css_selector( ' thead .caption .prev' ) => 'font-size: {{SIZE}}{{UNIT}}',
					$this->css_selector( ' thead .caption .next' ) => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'month_switcher_size',
			array(
				'label'      => esc_html__( 'Box size', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 30,
						'max' => 200,
					),
				),
				'selectors'  => array(
					$this->css_selector( ' thead .caption .prev' ) => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					$this->css_selector( ' thead .caption .next' ) => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					$this->css_selector( ' thead .caption > div:first-child' ) => 'flex: 0 0 {{SIZE}}{{UNIT}}',
					$this->css_selector( ' thead .caption > div:last-child' ) => 'flex: 0 0 {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'           => 'month_switcher_border',
				'label'          => esc_html__( 'Border', 'jet-booking' ),
				'placeholder'    => '1px',
				'selector'       => $this->css_selector( ' thead .caption .prev' ) . ', ' . $this->css_selector( ' thead .caption .next' ),
			)
		);

		$this->add_responsive_control(
			'month_switcher_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					$this->css_selector( ' thead .caption .prev' ) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					$this->css_selector( ' thead .caption .next' ) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'month_switcher_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-booking' ),
			)
		);

		$this->add_control(
			'month_switcher_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' thead .caption .prev:hover' ) => 'color: {{VALUE}}',
					$this->css_selector( ' thead .caption .next:hover' ) => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'month_switcher_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' thead .caption .prev:hover' ) => 'background-color: {{VALUE}}',
					$this->css_selector( ' thead .caption .next:hover' ) => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'month_switcher_border_color_hover',
			array(
				'label' => esc_html__( 'Border Color', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'month_switcher_border_border!' => '',
				),
				'selectors' => array(
					$this->css_selector( ' thead .caption .prev:hover' ) => 'border-color: {{VALUE}}',
					$this->css_selector( ' thead .caption .next:hover' ) => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'week_days_heading',
			array(
				'label' => esc_html__( 'Week days', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'week_days_typography',
				'selector'  => $this->css_selector( ' thead .week-name' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'week_days_color',
			array(
				'label' => esc_html__( 'Color', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' thead .week-name' ) => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'week_days_bg_color',
			array(
				'label' => esc_html__( 'Background', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' thead .week-name' ) => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'week_days_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					$this->css_selector( ' thead .week-name th' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'           => 'week_days_border',
				'label'          => esc_html__( 'Border', 'jet-booking' ),
				'placeholder'    => '1px',
				'selector'       => $this->css_selector( ' thead .week-name th' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_days_style',
			array(
				'label'      => esc_html__( 'Days', 'jet-booking' ),
				'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'calendar_days_typography',
				'selector'  => $this->css_selector( ' tbody .day' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'calendar_days_color',
			array(
				'label' => esc_html__( 'Color', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody .day.toMonth.valid' ) => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'calendar_days_cell_bg_color',
			array(
				'label' => __( 'Cell Background', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody td' ) => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'calendar_days_day_bg_color',
			array(
				'label' => __( 'Day Background', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody .day' ) => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'calendar_days_cell_padding',
			array(
				'label'      => __( 'Cell Padding', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					$this->css_selector( ' tbody td' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'calendar_days_day_padding',
			array(
				'label'      => __( 'Day Padding', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					$this->css_selector( ' tbody .day' ) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'           => 'calendar_days_cell_border',
				'label'          => __( 'Cell Border', 'jet-booking' ),
				'placeholder'    => '1px',
				'selector'       => $this->css_selector( ' tbody td' ),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'           => 'calendar_days_day_border',
				'label'          => __( 'Day Border', 'jet-booking' ),
				'placeholder'    => '1px',
				'selector'       => $this->css_selector( ' tbody .day' ),
			)
		);

		$this->add_responsive_control(
			'calendar_days_border_radius',
			array(
				'label'      => __( 'Border Radius', 'jet-booking' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					$this->css_selector( ' tbody .day' ) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_days_style' );

		$this->start_controls_tab(
			'calendar_days_inactive',
			array(
				'label' => __( 'Inactive', 'jet-booking' ),
			)
		);

		$this->add_control(
			'calendar_days_inactive_color',
			array(
				'label'  => __( 'Text Color', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody div.day.invalid' ) => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'calendar_days_inactive_bg_color',
			array(
				'label'  => __( 'Background', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody div.day.invalid' ) => 'background-color: {{VALUE}}',
				),
			)
		);


		$this->add_control(
			'calendar_days_inactive_border_color',
			array(
				'label' => __( 'Border Color', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'calendar_days_day_border_border!' => '',
				),
				'selectors' => array(
					$this->css_selector( ' tbody div.day.invalid' ) => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'calendar_days_today',
			array(
				'label' => __( 'Today', 'jet-booking' ),
			)
		);

		$this->add_control(
			'calendar_days_today_color',
			array(
				'label'  => __( 'Text Color', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody .day.real-today:not(.invalid)' ) => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'calendar_days_today_bg_color',
			array(
				'label'  => __( 'Background', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody .day.real-today:not(.invalid)' ) => 'background-color: {{VALUE}}',
				),
			)
		);


		$this->add_control(
			'calendar_days_today_border_color',
			array(
				'label' => __( 'Border Color', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'calendar_days_day_border_border!' => '',
				),
				'selectors' => array(
					$this->css_selector( ' tbody .day.real-today:not(.invalid)' ) => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'calendar_days_edges',
			array(
				'label' => __( 'Start/End', 'jet-booking' ),
			)
		);

		$this->add_control(
			'calendar_days_edges_color',
			array(
				'label'  => __( 'Text Color', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody div.day.first-date-selected' ) => 'color: {{VALUE}} !important;',
					$this->css_selector( ' tbody div.day.last-date-selected' ) => 'color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'calendar_days_edges_bg_color',
			array(
				'label'  => __( 'Background', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody div.day.first-date-selected' ) => 'background-color: {{VALUE}} !important;',
					$this->css_selector( ' tbody div.day.last-date-selected' ) => 'background-color: {{VALUE}} !important;',
				),
			)
		);


		$this->add_control(
			'calendar_days_edges_border_color',
			array(
				'label' => __( 'Border Color', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'calendar_days_day_border_border!' => '',
				),
				'selectors' => array(
					$this->css_selector( ' tbody div.day.first-date-selected' ) => 'border-color: {{VALUE}} !important;',
					$this->css_selector( ' tbody div.day.last-date-selected' ) => 'border-color: {{VALUE}} !important;',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'calendar_days_trace',
			array(
				'label' => __( 'Trace', 'jet-booking' ),
			)
		);

		$this->add_control(
			'calendar_days_trace_color',
			array(
				'label'  => __( 'Text Color', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody div.valid.day.checked' ) => 'color: {{VALUE}}',
					$this->css_selector( ' tbody div.valid.day.hovering' ) => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'calendar_days_trace_bg_color',
			array(
				'label'  => __( 'Background', 'jet-booking' ),
				'type'   => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					$this->css_selector( ' tbody div.valid.day.checked' ) => 'background-color: {{VALUE}}',
					$this->css_selector( ' tbody div.valid.day.hovering' ) => 'background-color: {{VALUE}}',
				),
			)
		);


		$this->add_control(
			'calendar_days_trace_border_color',
			array(
				'label' => __( 'Border Color', 'jet-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => array(
					'calendar_days_day_border_border!' => '',
				),
				'selectors' => array(
					$this->css_selector( ' tbody div.day.checked' ) => 'border-color: {{VALUE}}',
					$this->css_selector( ' tbody div.day.hovering' ) => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Returns CSS selector for nested element
	 *
	 * @param  [type] $el [description]
	 * @return [type]     [description]
	 */
	public function css_selector( $el = null ) {
		return sprintf( '{{WRAPPER}} .%1$s%2$s', $this->get_name(), $el );
	}

	protected function render() {
		$renderer = new Calendar_Renderer( $this->get_settings() );
		$renderer->render();
	}

}