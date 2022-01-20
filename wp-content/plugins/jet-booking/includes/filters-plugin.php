<?php
namespace JET_ABAF;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plug-in code into JetSmartFilters
 */
class Filters_Plugin {

	public function __construct() {
		
		add_filter(
			'jet-smart-filters/query/final-query',
			array( $this, 'set_booking_params' )
		);

		add_action( 
			'jet-smart-filters/post-type/filter-notes-after',
			array( $this, 'add_booking_notes' ) 
		);
	}

	public function add_booking_notes() {
		echo '<p><b>' . esc_html__( 'JetBooking:', 'jet-booking' ) . '</b></p>';
		echo '<ul>';
			printf( '<li><b>checkin_checkout</b>: %s</li>', esc_html__( 'filter available instances by checkin/checkout dates (allowed only for Date Range filter);', 'jet-booking' ) );
		echo '</ul>';
	}

	/**
	 * Check if booking var presented in query - unset it and add apartments unavailable for this period into query
	 */
	public function set_booking_params( $query ) {

		if ( empty( $query['meta_query'] ) ) {
			return $query;
		}

		foreach ( $query['meta_query'] as $index => $meta_query ) {

			if ( 'chekin_checkout' === $meta_query['key'] || 'checkin_checkout' === $meta_query['key'] ) {

				$from = $meta_query['value'][0];
				$to   = $meta_query['value'][1];

				unset( $query['meta_query'][ $index ] );

				Plugin::instance()->session->set( 'searched_dates', $from . ' - ' . $to );

				$exclude = $this->get_unavailable_apartments( $from, $to );

				if ( $exclude ) {
					$query['post__not_in'] = $exclude;
				}

			}
		}

		return $query;

	}

	public function get_unavailable_apartments( $from, $to ) {
		return Plugin::instance()->db->get_booked_apartments( $from, $to );
	}

}