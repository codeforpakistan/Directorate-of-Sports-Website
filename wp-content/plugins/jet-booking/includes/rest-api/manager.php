<?php
namespace JET_ABAF\Rest_API;

use JET_ABAF\Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Manager {

	/**
	 * Register hooks
	 */
	public function __construct() {
		add_action( 'jet-engine/rest-api/init-endpoints', array( $this, 'init_rest' ) );
	}

	/**
	 * Initialize Rest API endpoints
	 *
	 * @return [type] [description]
	 */
	public function init_rest( $api_manager ) {

		$api_manager->register_endpoint( new Endpoint_Bookings_List() );
		$api_manager->register_endpoint( new Endpoint_Delete_Booking() );
		$api_manager->register_endpoint( new Endpoint_Update_Booking() );

		if ( Plugin::instance()->settings->get( 'ical_synch' ) ) {
			$api_manager->register_endpoint( new Endpoint_Calendars_List() );
			$api_manager->register_endpoint( new Endpoint_Update_Calendar() );
			$api_manager->register_endpoint( new Endpoint_Synch_Calendar() );
		}

	}

	/**
	 * Returns all registered Rest URLs
	 * @return array
	 */
	public function get_urls( $full = true ) {

		$res = array(
			'bookings_list'  => jet_engine()->api->get_route( 'bookings-list', $full ),
			'delete_booking' => jet_engine()->api->get_route( 'delete-booking', $full ),
			'update_booking' => jet_engine()->api->get_route( 'update-booking', $full ),
		);

		if ( Plugin::instance()->settings->get( 'ical_synch' ) ) {
			$res['calendars_list']  = jet_engine()->api->get_route( 'calendars-list', $full );
			$res['update_calendar'] = jet_engine()->api->get_route( 'update-calendar', $full );
			$res['synch_calendar']  = jet_engine()->api->get_route( 'synch-calendar', $full );
		}

		return $res;

	}

}

