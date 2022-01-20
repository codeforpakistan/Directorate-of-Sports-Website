<?php
/**
 * Class: Jet_Woo_Builder_Cart_Cross_Sells
 * Name: Cart Cross Sells
 * Slug: jet-cart-cross-sells
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Cart_Cross_Sells extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-cart-cross-sells';
	}

	public function get_title() {
		return esc_html__( 'Cart Cross Sells', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-cart-cross-sells';
	}

	public function get_jet_help_url() {
		return 'https://crocoblock.com/knowledge-base/articles/jetwoobuilder-how-to-create-a-cart-page-template/';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'cart' );
	}

	protected function register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-cart-cross-sells/css-scheme',
			array(
				'heading' => '.cross-sells > h2',
				'card'    => 'ul.products li.product .product-content',
				'thumb'   => 'ul.products li.product img',
				'title'   => 'ul.products li.product .woocommerce-loop-product__title',
				'rating'  => 'ul.products li.product .star-rating',
				'price'   => 'ul.products li.product .price',
				'button'  => 'ul.products li.product .button',
				'badge'   => 'ul.products li.product span.onsale',
			)
		);

		$this->start_controls_section(
			'cross_sell_settings_section',
			array(
				'label' => esc_html__( 'General', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		jet_woo_builder_common_controls()->register_wc_style_warning( $this );

		$this->add_control(
			'cross_sell_products_columns',
			array(
				'label'   => esc_html__( 'Columns', 'jet-woo-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 12,
			)
		);

		$this->add_control(
			'cross_sell_products_orderby',
			array(
				'label'   => esc_html__( 'Order by', 'jet-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'rand',
				'options' => array(
					'rand'       => esc_html__( 'Random', 'jet-woo-builder' ),
					'date'       => esc_html__( 'Publish Date', 'jet-woo-builder' ),
					'modified'   => esc_html__( 'Modified Date', 'jet-woo-builder' ),
					'title'      => esc_html__( 'Alphabetic', 'jet-woo-builder' ),
					'popularity' => esc_html__( 'Popularity', 'jet-woo-builder' ),
					'rating'     => esc_html__( 'Rate', 'jet-woo-builder' ),
					'price'      => esc_html__( 'Price', 'jet-woo-builder' ),
				),
			)
		);

		$this->add_control(
			'cross_sell_products_order',
			array(
				'label'   => esc_html__( 'Order', 'jet-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => jet_woo_builder_tools()->order_arr(),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cross_sells_heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'cross_sells', $css_scheme['heading'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'cross_sells_card_styles',
			array(
				'label' => esc_html__( 'Card', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'cross_sells_card_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['card'] . ', {{WRAPPER}} ul.products li.product .product-inner',
			)
		);

		$this->add_responsive_control(
			'cross_sells_card_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['card']                => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ul.products li.product .product-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'cross_sells_card_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['card'] . ', {{WRAPPER}} ul.products li.product .product-inner',
			)
		);

		$this->add_responsive_control(
			'cross_sells_card_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['card']                => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ul.products li.product .product-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cross_sells_thumb_styles',
			array(
				'label' => esc_html__( 'Thumbnail', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'cross_sells_thumb_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['thumb'],
			)
		);

		$this->add_responsive_control(
			'cross_sells_thumb_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cross_sells_thumb_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cross_sells_thumb_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cross_sells_title_styles',
			array(
				'label' => esc_html__( 'Title', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cross_sells_title_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'] . ' a , {{WRAPPER}} ul.products li.product .title a, {{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->start_controls_tabs( 'cross_sells_title_color_style_tabs' );

		$this->start_controls_tab(
			'cross_sells_title_normal_color_tab',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'cross_sells_title_normal_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] . ' a'  => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['title']         => 'color: {{VALUE}}',
					'{{WRAPPER}} ul.products li.product .title a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cross_sells_title_hover_color_tab',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'cross_sells_title_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] . ' a:hover'  => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['title'] . ':hover'    => 'color: {{VALUE}}',
					'{{WRAPPER}} ul.products li.product .title a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'cross_sells_title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title']       => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ul.products li.product .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'cross_sells_title_align',
			array(
				'label'     => esc_html__( 'Text Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types( true ),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title']       => 'text-align: {{VALUE}}',
					'{{WRAPPER}} ul.products li.product .title' => 'text-align: {{VALUE}}',
				),
				'classes'   => 'elementor-control-align',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cross_sells_rating_styles',
			array(
				'label'      => esc_html__( 'Rating', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'cross_sells_rating_font_size',
			array(
				'label'      => esc_html__( 'Font Size (px)', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'cross_sells_rating_color_style_tabs' );

		$this->start_controls_tab(
			'cross_sells_rating_all_color_tab',
			array(
				'label' => esc_html__( 'All', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'cross_sells_rating_all_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] . '::before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cross_sells_rating_rated_color_tab',
			array(
				'label' => esc_html__( 'Rated', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'cross_sells_rating_rated_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' > span:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'cross_sells_rating_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cross_sells_price_styles',
			array(
				'label'      => esc_html__( 'Price', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cross_sells_price_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['price'],
			)
		);

		$this->add_control(
			'cross_sells_price_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price']              => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['price'] . ' .amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'cross_sells_price_styles_tabs' );

		$this->start_controls_tab(
			'cross_sells_price_regular_tab',
			array(
				'label' => esc_html__( 'Regular', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'cross_sells_price_regular_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del'         => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del .amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cross_sells_price_regular_decoration',
			array(
				'label'     => esc_html__( 'Text Decoration', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'line-through',
				'options'   => jet_woo_builder_tools()->get_available_text_decoration_types(),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del'         => 'text-decoration: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del .amount' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'cross_sells_price_regular_size',
			array(
				'label'     => esc_html__( 'Size', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del'         => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del .amount' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'cross_sells_price_regular_weight',
			array(
				'label'     => esc_html__( 'Font Weight', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '400',
				'options'   => jet_woo_builder_tools()->get_available_font_weight_types(),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del' => 'font-weight: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cross_sells_price_sale_tab',
			array(
				'label' => esc_html__( 'Sale', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'cross_sells_price_sale_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins'         => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins .amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cross_sells_price_sale_decoration',
			array(
				'label'     => esc_html__( 'Text Decoration', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => jet_woo_builder_tools()->get_available_text_decoration_types(),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'cross_sells_price_sale_size',
			array(
				'label'     => esc_html__( 'Size', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'cross_sells_price_sale_weight',
			array(
				'label'     => esc_html__( 'Font Weight', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '400',
				'options'   => jet_woo_builder_tools()->get_available_font_weight_types(),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'font-weight: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'cross_sells_price_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'cross_sells_price_align',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => jet_woo_builder_tools()->get_available_h_align_types(),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'text-align: {{VALUE}}',
				),
				'classes'   => 'elementor-control-align',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cross_sells_button_styles',
			array(
				'label' => esc_html__( 'Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'cross_sells', $css_scheme['button'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'cross_sells_badges_styles',
			array(
				'label' => esc_html__( 'Badges', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cross_sells_badges_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_control(
			'cross_sells_badges_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'cross_sells_badges_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_responsive_control(
			'cross_sells_badges_min_width',
			array(
				'label'       => esc_html__( 'Min Width', 'jet-woo-builder' ),
				'label_block' => true,
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 300,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cross_sells_badges_min_height',
			array(
				'label'       => esc_html__( 'Min Height', 'jet-woo-builder' ),
				'label_block' => true,
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 300,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cross_sells_badges_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
