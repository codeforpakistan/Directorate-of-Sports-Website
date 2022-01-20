<?php
namespace JET_ABAF\Rest_API;

use JET_ABAF\Plugin;

class Endpoint_Bookings_List extends \Jet_Engine_Base_API_Endpoint {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'bookings-list';
	}

	/**
	 * API callback
	 *
	 * @return void
	 */
	public function callback( $request ) {

		$params   = $request->get_params();
		$offset   = ! empty( $params['offset'] ) ? absint( $params['offset'] ) : 0;
		$per_page = ! empty( $params['per_page'] ) ? absint( $params['per_page'] ) : 50;
		$query    = ! empty( $params['query'] ) ? json_decode( $params['query'], true ) : array();

		if ( ! empty( $query ) && is_array( $query ) ) {
			$query = array_filter( $query );
		} else {
			$query = array();
		}

		$bookings = Plugin::instance()->db->query(
			$query,
			null,
			$per_page,
			$offset,
			array(
				'orderby' => 'booking_id',
				'order'   => 'DESC',
			)
		);

		if ( empty( $bookings ) ) {
			$bookings = array();
		}

		return rest_ensure_response( array(
			'success' => true,
			'data'    => $this->format_dates( $bookings ),
			'total'   => Plugin::instance()->db->count( $query ),
		) );

	}

	public function format_dates( $bookings = array() ) {

		$date_format = get_option( 'date_format', 'F j, Y' );

		return array_map( function( $booking ) use ( $date_format ) {

			$booking['check_in_date']  = date_i18n( $date_format, $booking['check_in_date'] );
			$booking['check_out_date'] = date_i18n( $date_format, $booking['check_out_date'] );
			$booking['status']         = ( ! empty( $booking['status'] ) ) ? $booking['status'] : 'pending';

			return $booking;

		}, $bookings );
	}

	/**
	 * Check user access to current end-popint
	 *
	 * @return bool
	 */
	public function permission_callback( $request ) {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Returns endpoint request method - GET/POST/PUT/DELTE
	 *
	 * @return string
	 */
	public function get_method() {
		return 'GET';
	}

	/**
	 * Returns arguments config
	 *
	 * @return array
	 */
	public function get_args() {
		return array(
			'offset' => array(
				'default'  => 0,
				'required' => false,
			),
			'per_page' => array(
				'default'  => 50,
				'required' => false,
			),
		);
	}

}
