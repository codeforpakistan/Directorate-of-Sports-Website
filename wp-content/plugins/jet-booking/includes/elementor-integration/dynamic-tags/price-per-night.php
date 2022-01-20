<?php
namespace JET_ABAF\Elementor_Integration\Dynamic_Tags;

use JET_ABAF\Advanced_Price_Rates;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Price_Per_Night extends \Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'jet-price-per-night';
	}

	public function get_title() {
		return esc_html__( 'Jet Booking: Price per day/night', 'jet-booking' );
	}

	public function get_group() {
		return \Jet_Engine_Dynamic_Tags_Module::JET_GROUP;
	}

	public function get_categories() {
		return array(
			\Jet_Engine_Dynamic_Tags_Module::TEXT_CATEGORY,
			\Jet_Engine_Dynamic_Tags_Module::NUMBER_CATEGORY,
			\Jet_Engine_Dynamic_Tags_Module::POST_META_CATEGORY,
		);
	}

	public function is_settings_required() {
		return true;
	}

	protected function _register_controls() {

		$this->add_control(
			'show_price',
			array(
				'label'   => esc_html__( 'Show price', 'jet-booking' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default' => esc_html__( 'Default', 'jet-booking' ),
					'min'     => esc_html__( 'Min price', 'jet-booking' ),
					'max'     => __( 'Max price', 'jet-booking' ),
					'range'   => __( 'Prices range', 'jet-booking' ),
				),
			)
		);

		$this->add_control(
			'change_dynamically',
			array(
				'label'       => __( 'Change Dynamically', 'jet-booking' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'description' => __( 'Change price dynamically on check-in check-out dates select. Will work correctly only whe appropriate form presetnted on the page', 'jet-booking' ),
			)
		);

		$this->add_control(
			'currency_sign',
			array(
				'label'   => __( 'Currency sign', 'jet-booking' ),
				'default' => '$',
				'type'    => \Elementor\Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'currency_sign_position',
			array(
				'label'   => __( 'Currency sign position', 'jet-booking' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'before',
				'options' => array(
					'before' => __( 'Before price', 'jet-booking' ),
					'after'  => __( 'After price', 'jet-booking' ),
				),
			)
		);

	}

	public function render() {

		$show_price         = $this->get_settings( 'show_price' );
		$change_dynamically = $this->get_settings( 'change_dynamically' );
		$change_dynamically = filter_var( $change_dynamically, FILTER_VALIDATE_BOOLEAN );
		$currency_sign      = $this->get_settings( 'currency_sign' );
		$currency_sign_pos  = $this->get_settings( 'currency_sign_position' );
		$advanced_pricing   =  new Advanced_Price_Rates( get_the_ID() );

		echo $advanced_pricing->get_price_for_display( array(
			'show_price'             => $show_price,
			'change_dynamically'     => $change_dynamically,
			'currency_sign'          => $currency_sign,
			'currency_sign_position' => $currency_sign_pos,
		) );
		
	}

}