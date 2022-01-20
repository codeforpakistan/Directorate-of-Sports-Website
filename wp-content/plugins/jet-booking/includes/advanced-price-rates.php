<?php
namespace JET_ABAF;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Advanced price rates class
 */
class Advanced_Price_Rates {

	private $post_id       = null;
	private $default_price = null;
	private $key           = '_pricing_rates';
	private $rates         = false;

	public function __construct( $post_id ) {
		$this->post_id = $post_id;
	}

	/**
	 * Returns default price
	 */
	public function get_default_price() {

		if ( null === $this->default_price ) {
			$this->default_price = floatval( get_post_meta( $this->post_id, '_apartment_price', true ) );
		}

		return $this->default_price;
	}

	/**
	 * Returns advanced price rates for current post
	 */
	public function get_rates() {

		if ( false === $this->rates ) {

			$pricing_rates = get_post_meta( $this->post_id, $this->key, true );

			if ( ! $pricing_rates ) {
				$pricing_rates = array();
			}

			usort( $pricing_rates, function( $a, $b ) {

				$a_duration = floatval( $a['duration'] );
				$b_duration = floatval( $b['duration'] );

				if ( $a_duration == $b_duration ) {
					return 0;
				}

				return ( $a_duration < $b_duration ) ? -1 : 1;

			} );

			$this->rates = $pricing_rates;
		}

		return $this->rates;

	}

	/**
	 * Get price value for display
	 */
	public function get_price_for_display( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'show_price'             => 'default',
			'change_dynamically'     => true,
			'currency_sign'          => '$',
			'currency_sign_position' => 'before',
		) );

		switch ( $args['show_price'] ) {

			case 'min':
				$price = $this->get_min_price( $args['currency_sign'], $args['currency_sign_position'] );
				break;

			case 'max':
				$price = $this->get_max_price( $args['currency_sign'], $args['currency_sign_position'] );
				break;

			case 'range':
				$price = $this->get_min_max_range( $args['currency_sign'], $args['currency_sign_position'] );
				break;

			default:
				$price = $this->formatted_price( $this->get_default_price(), $args['currency_sign'], $args['currency_sign_position'] );
				break;
		}

		return sprintf(
			'<span data-price-change="%1$s" data-post="%2$s" data-currency="%3$s" data-currency-position="%4$s">%5$s</span>',
			( $args['change_dynamically'] ? 1 : 0 ),
			$this->post_id,
			$args['currency_sign'],
			$args['currency_sign_position'],
			$price
		);

	}

	/**
	 * Returns minimal price value
	 */
	public function get_min_price_value() {

		$rates = $this->get_rates();
		$price = $this->get_default_price();

		if ( empty( $rates ) ) {
			return $price;
		}

		foreach ( $rates as $rate ) {
			$value = floatval( $rate['value'] );
			if ( $value < $price ) {
				$price = $value;
			}
		}

		return $price;

	}

	/**
	 * Returns minimal price value
	 */
	public function get_max_price_value() {

		$rates = $this->get_rates();
		$price = $this->get_default_price();

		if ( empty( $rates ) ) {
			return $price;
		}

		foreach ( $rates as $rate ) {
			$value = floatval( $rate['value'] );
			if ( $value > $price ) {
				$price = $value;
			}
		}

		return $price;

	}

	/**
	 * Return formatted price string
	 */
	public function formatted_price( $value, $currency, $currency_position ) {

		if ( ! $currency ) {
			return $value;
		}

		if ( 'before' === $currency_position ) {
			$format = '%1$s%2$s';
		} else {
			$format = '%2$s%1$s';
		}

		return sprintf( $format, $currency, $value );

	}

	/**
	 * Returns formatted min price value
	 */
	public function get_min_price( $currency, $currency_position ) {
		return $this->formatted_price( $this->get_min_price_value(), $currency, $currency_position );
	}

	/**
	 * Returns formatted max price value
	 */
	public function get_max_price( $currency, $currency_position ) {
		return $this->formatted_price( $this->get_max_price_value(), $currency, $currency_position );
	}

	/**
	 * Returns formatted min/max price values range
	 */
	public function get_min_max_range( $currency, $currency_position ) {

		$min = $this->get_min_price_value();
		$max = $this->get_max_price_value();

		if ( $min === $max ) {
			return $this->formatted_price( $min, $currency, $currency_position );
		} else {
			return sprintf(
				'%1$s - %2$s',
				$this->formatted_price( $min, $currency, $currency_position ),
				$this->formatted_price( $max, $currency, $currency_position )
			);
		}

	}

}
