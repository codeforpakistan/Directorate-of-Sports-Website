<?php
namespace JET_ABAF\Rest_API;

use JET_ABAF\Plugin;

class Endpoint_Delete_Booking extends \Jet_Engine_Base_API_Endpoint {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'delete-booking';
	}

	/**
	 * API callback
	 *
	 * @return void
	 */
	public function callback( $request ) {

		$params     = $request->get_params();
		$booking_id = ! empty( $params['id'] ) ? absint( $params['id'] ) : 0;

		if ( ! $booking_id ) {
			return rest_ensure_response( array(
				'success' => false,
				'data'    => __( 'Booking ID is not found in request', 'jet-booking' ),
			) );
		}

		Plugin::instance()->db->delete_booking( array(
			'booking_id' => $booking_id,
		) );

		return rest_ensure_response( array(
			'success' => true,
		) );

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
	 * Returns endpoint request method - GET/POST/PUT/DELETE
	 *
	 * @return string
	 */
	public function get_method() {
		return 'DELETE';
	}

	/**
	 * Get query param. Regex with query parameters
	 *
	 * @return string
	 */
	public function get_query_params() {
		return '(?P<id>[\d]+)';
	}

}