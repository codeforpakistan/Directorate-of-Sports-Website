<?php
namespace JET_ABAF;

/**
 * Database manager class
 */
class Google_Calendar {

	public $query_var = 'jet_abaf_add_to_calendar';

	public function __construct() {

		if ( ! empty( $_GET[ $this->query_var ] ) ) {
			add_action( 'init', array( $this, 'redirect_to_calendar' ) );
		}

		add_filter( 'jet-engine/listings/dynamic-link/custom-url', array( $this, 'set_url_for_render' ), 10, 2 );
		add_action( 'jet-abaf/form/notification/success', array( $this, 'set_default_cookie' ), 20 );
		add_action( 'jet-booking/wc-integration/process-order', array( $this, 'set_wc_cookie' ), 10, 3 );

	}

	public function set_url_for_render( $url, $settings ) {

		if ( ! empty( $settings['dynamic_link_source'] ) && $this->query_var === $settings['dynamic_link_source'] ) {
			return $this->get_internal_link();
		} else {
			return $url;
		}

	}

	public function get_secure_key() {

		$key = get_option( $this->query_var );

		if ( ! $key ) {
			$key = time() % 100000;
			update_option( $this->query_var, $key, false );
		}

		return $key;

	}

	public function set_wc_cookie( $order_id, $order, $cart_item ) {

		$data_key     = Plugin::instance()->wc->data_key;
		$booking_data = ! empty( $cart_item[ $data_key ] ) ? $cart_item[ $data_key ] : false;

		if ( ! $booking_data ) {
			return;
		}

		$this->set_default_cookie( $booking_data );

	}

	public function set_default_cookie( $booking ) {

		$booking_id = ! empty( $booking['booking_id'] ) ? $booking['booking_id'] : false;

		if ( ! $booking_id ) {
			return;
		}

		$expire = time() + YEAR_IN_SECONDS;
		$secure = ( false !== strstr( get_option( 'home' ), 'https:' ) && is_ssl() );

		setcookie(
			$this->query_var,
			$booking_id,
			$expire,
			COOKIEPATH ? COOKIEPATH : '/',
			COOKIE_DOMAIN,
			$secure,
			true
		);

	}

	public function get_id_from_cookies() {
		return isset( $_COOKIE[ $this->query_var ] ) ? $_COOKIE[ $this->query_var ] : false;
	}

	public function redirect_to_calendar() {

		$booking_id = absint( $_GET[ $this->query_var ] );

		if ( ! $booking_id ) {
			wp_die( esc_html__( 'Booking ID not found in the request', 'jet-booking' ), esc_html__( 'Error', 'jet-booking' ) );
		}

		$booking_id = $this->get_booking_id_from_secure_id( $booking_id );

		if ( ! $booking_id ) {
			wp_die( esc_html__( 'Booking ID not found in the request', 'jet-booking' ), esc_html__( 'Error', 'jet-booking' ) );
		}

		$booking = Plugin::instance()->db->get_booking_by( 'booking_id', $booking_id );

		if ( ! $booking ) {
			wp_die( esc_html__( 'Booking not found in the database', 'jet-booking' ), esc_html__( 'Error', 'jet-booking' ) );
		}

		$url = $this->get_calendar_url_by_booking( $booking );

		if ( ! $url ) {
			wp_die( esc_html__( 'Can`t build add to calendar URL', 'jet-booking' ), esc_html__( 'Error', 'jet-booking' ) );
		}

		wp_redirect( $url );
		die();

	}

	public function get_calendar_url_by_booking( $booking ) {

		$args = array(
			'action'   => 'TEMPLATE',
			'text'     => '',
			'dates'    => '',
			'details'  => '',
			'location' => '',
		);

		$args['text'] = urlencode( sprintf(
			'%1$s %2$s: %3$s',
			esc_html__( 'Your booking at', 'jet-booking' ),
			get_option( 'blogname' ),
			get_the_title( $booking['apartment_id'] )
		) );

		$args['dates'] = sprintf(
			'%1$sT120000Z/%2$sT120000Z',
			date( 'Ymd', $booking['check_in_date'] ),
			date( 'Ymd', $booking['check_out_date'] )
		);

		$args = apply_filters( 'jet-booking/google-calendar-url/args', $args, $booking );

		return add_query_arg( array_filter( $args ), 'https://calendar.google.com/calendar/render' );

	}

	public function get_booking_id_from_secure_id( $secure_id ) {

		$secure_id  = absint( $secure_id );
		$booking_id = apply_filters( 'jet-booking/google-calendar-url/booking-id', false, $secure_id, $this );

		if ( ! $booking_id ) {
			$key        = $this->get_secure_key();
			$booking_id = $secure_id - $key;
		}

		return $booking_id;

	}

	public function secure_id( $booking_id ) {

		$secured_id = apply_filters( 'jet-booking/google-calendar-url/secure-id', false, $booking_id, $this );

		if ( ! $secured_id ) {
			$key        = $this->get_secure_key();
			$secured_id = $key + absint( $booking_id );
		}

		return $secured_id;

	}

	public function get_internal_link( $booking_id = false ) {

		if ( ! $booking_id ) {
			$booking    = Plugin::instance()->db->queried_booking;
			$booking_id = $booking['booking_id'];
		}

		if ( ! $booking_id ) {
			$booking_id = $this->get_id_from_cookies();
		}

		if ( ! $booking_id ) {
			return false;
		}

		$booking_id = $this->secure_id( $booking_id );

		return add_query_arg( array( $this->query_var => $booking_id ), home_url( '/' ) );

	}

}