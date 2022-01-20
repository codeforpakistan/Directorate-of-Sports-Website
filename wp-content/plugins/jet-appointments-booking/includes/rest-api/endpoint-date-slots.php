<?php
namespace JET_APB\Rest_API;

use JET_APB\Plugin;
use JET_APB\Time_Types;
use JET_APB\Time_Slots;

class Endpoint_Date_Slots extends \Jet_Engine_Base_API_Endpoint {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'appointment-date-slots';
	}

	/**
	 * API callback
	 *
	 * @return void
	 */
	public function callback( $request ) {
		$params  = $request->get_params();
		$service = ! empty( $params['service'] ) ? absint( $params['service'] ) : 0 ;
		$date    = ! empty( $params['date'] ) ? absint( $params['date'] ) : 0 ;
		
		if ( ! $service || ! $date ) {
			return rest_ensure_response( array(
				'success' => false,
			) );
		}
		
		$result =  Time_Types::render_frontend_view( [
			'service'        => $service,
			'provider'       => ! empty( $params['provider'] ) ? absint( $params['provider'] ) : 0,
			'date'           => $date,
			'time'           => ! empty( $params['timestamp'] ) ? absint( $params['timestamp'] ) : 0,
			'selected_slots' => ! empty( $params['selected_slots'] ) ? json_decode( $params['selected_slots'] ) : [] ,
			'admin'          => ! empty( $params['admin'] ) ? filter_var( $params['admin'], FILTER_VALIDATE_BOOLEAN ) : false,
		]);

		return rest_ensure_response( array(
			'success' => true,
			'data'    => $result,
		) );
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
	 * Returns arguments config
	 *
	 * @return array
	 */
	public function get_args() {
		return array(
			'date' => array(
				'default'  => '',
				'required' => true,
			),
			'service' => array(
				'default'  => '',
				'required' => true,
			),
			'provider' => array(
				'default'  => '',
				'required' => false,
			),
			'timestamp' => array(
				'default'  => '',
				'required' => false,
			),
		);
	}

}