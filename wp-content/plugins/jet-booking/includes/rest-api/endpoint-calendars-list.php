<?php
namespace JET_ABAF\Rest_API;

use JET_ABAF\Plugin;

class Endpoint_Calendars_List extends \Jet_Engine_Base_API_Endpoint {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'calendars-list';
	}

	/**
	 * API callback
	 *
	 * @return void
	 */
	public function callback( $request ) {

		$calendars = Plugin::instance()->ical->get_calendars();

		return rest_ensure_response( array(
			'success' => true,
			'data'    => $calendars,
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
		return 'GET';
	}

}
