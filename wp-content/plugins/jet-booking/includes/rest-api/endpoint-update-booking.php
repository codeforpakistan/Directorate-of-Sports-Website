<?php
namespace JET_ABAF\Rest_API;

use JET_ABAF\Plugin;

class Endpoint_Update_Booking extends \Jet_Engine_Base_API_Endpoint {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'update-booking';
	}

	/**
	 * API callback
	 *
	 * @return void
	 */
	public function callback( $request ) {

		$params  = $request->get_params();
		$item_id = ! empty( $params['id'] ) ? absint( $params['id'] ) : 0;
		$item    = ! empty( $params['item'] ) ? $params['item'] : array();

		$not_allowed = array(
			'booking_id',
			'apartment_unit',
			'order_id',
		);

		if ( empty( $item['check_in_date'] ) || empty( $item['check_out_date'] ) ) {
			return rest_ensure_response( array(
				'success' => false,
				'data'    => esc_html__( 'Incorrect item data', 'jet-booking' ),
			) );
		}

		foreach ( $not_allowed as $key ) {
			if ( isset( $item[ $key ] ) ) {
				unset( $item[ $key ] );
			}
		}

		if ( empty( $item ) ) {
			return rest_ensure_response( array(
				'success' => false,
				'data'    => esc_html__( 'No data to update', 'jet-booking' ),
			) );
		}

		$item['check_in_date']  = strtotime( $item['check_in_date'] );
		$item['check_out_date'] = strtotime( $item['check_out_date'] );

		$is_available = Plugin::instance()->db->check_availability_on_update(
			$item_id,
			$item['apartment_id'],
			$item['check_in_date'],
			$item['check_out_date']
		);

		$column = Plugin::instance()->settings->get( 'related_post_type_column' );

		if ( ! $is_available ) {

			ob_start();

			esc_html_e( 'New dates are not available.' ) . '<br>';

			if ( Plugin::instance()->db->latest_result ) {

				esc_html_e( 'Overlapping bookings: ' );

				foreach ( Plugin::instance()->db->latest_result as $ob ) {

					$result = array();

					if ( absint( $ob['booking_id'] ) !== $item_id && ! empty( $ob[ $column ] ) ) {
						$result[] = sprintf(
							'<a href="%1$s" target="_blank">#%2$s</a>',
							get_edit_post_link( $ob[ $column ] ),
							$ob[ $column ]
						);
					}

					echo implode( ', ', $result );

				}

			}

			return rest_ensure_response( array(
				'success'              => false,
				'overlapping_bookings' => true,
				'html'                 => ob_get_clean(),
				'data'                 => esc_html__( 'Can`t update this item', 'jet-booking' ),
			) );

		}

		Plugin::instance()->db->update_booking( $item_id, $item );

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
	 * Returns endpoint request method - GET/POST/PUT/DELTE
	 *
	 * @return string
	 */
	public function get_method() {
		return 'POST';
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