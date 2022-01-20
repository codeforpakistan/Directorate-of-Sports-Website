<?php
namespace JET_ABAF;

/**
 * ICal management class
 */
class iCal {

	/**
	 * Trigger to get iCal file
	 * @var string
	 */
	private $trigger   = '_get_ical';
	private $hash      = null;
	private $domain    = null;
	private $ical_meta = '_import_ical';

	/**
	 * Setup class
	 */
	public function __construct() {

		$this->hash = md5( $this->get_domain() );

		if ( ! empty( $_GET[ $this->trigger ] ) && $this->hash === $_GET[ $this->trigger ] && ! empty( $_GET['_id'] ) ) {
			$this->get_calendar_file();
		}

		add_action( 'jet-booking/settings/on-ajax-save', array( $this, 'maybe_schedule_synch' ) );
		add_action( 'jet-booking/cron/synch-calendars', array( $this, 'cron_synch_calendars' ) );

	}

	/**
	 * [maybe_schedule_synch description]
	 * @return [type] [description]
	 */
	public function maybe_schedule_synch() {

		if ( Plugin::instance()->settings->get( 'ical_synch' ) ) {
			$this->reschedule_synch();
		} else {
			$this->unschedule_synch();
		}

	}

	/**
	 * Schedule calendar synchronizing for given post ID and unit ID
	 *
	 * @param  [type] $post_id [description]
	 * @param  [type] $unit_id [description]
	 * @return [type]          [description]
	 */
	public function schedule_synch() {

		if ( ! wp_next_scheduled( 'jet-booking/cron/synch-calendars' ) ) {

			$interval = Plugin::instance()->settings->get( 'synch_interval' );

			if ( ! $interval ) {
				$interval = 'daily';
			}

			$from_h = Plugin::instance()->settings->get( 'synch_interval_hours' );
			$from_m = Plugin::instance()->settings->get( 'synch_interval_mins' );

			if ( ! $from_h || ! $from_m ) {
				$time = time();
			} else {
				$time = strtotime( 'today ' . $from_h . ':' . $from_m );
			}

			wp_schedule_event( $time, $interval, 'jet-booking/cron/synch-calendars' );

		}

	}

	/**
	 * Unschedule calendars synchronizing
	 *
	 * @return [type] [description]
	 */
	public function unschedule_synch() {

		$timestamp = wp_next_scheduled( 'jet-booking/cron/synch-calendars' );

		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, 'jet-booking/cron/synch-calendars' );
		}

	}

	/**
	 * Reshedule calendars synch
	 *
	 * @return [type] [description]
	 */
	public function reschedule_synch() {
		$this->unschedule_synch();
		$this->schedule_synch();
	}

	/**
	 * Synhronize calendars on cron hook
	 *
	 * @return [type] [description]
	 */
	public function cron_synch_calendars() {
		$calendars = $this->get_calendars();
		foreach ( $calendars as $calendar ) {
			$log = $this->synch( $calendar['post_id'], $calendar['unit_id'] );
		}
	}

	/**
	 * Returns current domain
	 *
	 * @return [type] [description]
	 */
	public function get_domain() {

		if ( $this->domain ) {
			return $this->domain;
		}

		$find         = array( 'http://', 'https://' );
		$replace      = '';
		$this->domain = str_replace( $find, $replace, home_url() );

		return $this->domain;

	}

	/**
	 * Synchronize calendars
	 * @return [type] [description]
	 */
	public function synch( $post_id = 0, $unit_id = false ) {

		$log = array();

		if ( ! $post_id ) {
			$log[] = __( 'Post ID not found', 'jet-booking' );
			return $log;
		}

		if ( ! $unit_id ) {
			$unit_id = 'default';
		}

		$import = get_post_meta( $post_id, $this->ical_meta, true );

		if ( ! $import ) {
			$import = array();
		}

		if ( empty( $import[ $unit_id ] ) ) {
			$log[] = __( 'External calendars is not found for this item', 'jet-booking' );
			return $log;
		}

		foreach ( $import[ $unit_id ] as $url ) {

			$response = wp_remote_get( $url );
			$label = '<b>' . $url . ':</b><br> ';

			if ( is_wp_error( $response ) ) {
				$log[] = $label . __( 'Can`t access caledar', 'jet-booking' ) . ', ' . $response->get_error_message();
				continue;
			}

			$body = wp_remote_retrieve_body( $response );

			if ( ! $body ) {
				$log[] = $label . __( 'Empty response from calendar', 'jet-booking' );
				continue;
			}

			$log[] = $label . $this->import_calendar( $body, $post_id, $unit_id );

		}

		return $log;

	}

	/**
	 * Import calendar data
	 *
	 * @param  [type] $data [description]
	 * @param  [type] $url  [description]
	 * @return [type]       [description]
	 */
	public function import_calendar( $data = null, $post_id = null, $unit_id = null ) {

		$this->load_deps();
		$calendar_object = new \ZCiCal( $data );

		if ( ! $calendar_object->countEvents() || ! $calendar_object->tree->child ) {
			return __( 'Bookings not found', 'jet-booking' );
		}

		$inserted = array();
		$skipped  = array();

		foreach ( $calendar_object->tree->child as $node ) {

			if ( 'VEVENT' !== $node->getName() ) {
				continue;
			}

			$import_node = array(
				'apartment_id' => $post_id,
				'status'       => 'pending',
			);

			if ( 'default' !== $unit_id ) {
				$import_node['apartment_unit'] = $unit_id;
			}

			$import_id = false;

			foreach ( $node->data as $key => $value ) {

				switch ( $key ) {
					case 'DTSTART':
						$in_date = $value->getValues();
						$import_node['check_in_date'] = \ZDateHelper::fromiCaltoUnixDateTime( $in_date );
						break;

					case 'DTEND':
						$out_date = $value->getValues();
						$import_node['check_out_date'] = \ZDateHelper::fromiCaltoUnixDateTime( $out_date );
						break;

					case 'UID':
						$import_node['import_id'] = $import_id = untrailingslashit( $value->getValues() );
						break;

				}

			}

			$import_node = apply_filters( 'jet-booking/ical/import/node', $import_node, $node, $calendar_object );

			if ( Plugin::instance()->db->is_booking_dates_available( $import_node ) ) {
				$inserted[] = Plugin::instance()->db->insert_booking( $import_node );
			} else {
				$skipped[] = $import_id;
			}

		}

		return '<i>' . esc_html__( 'Inserted bookings: ', 'jet-booking' ) . '</i>' . count( $inserted ) . esc_html__( ' units', 'jet-booking' ) . '<br><i>' . esc_html__( 'Skipped bookings: ', 'jet-booking' ) . '</i>' . count( $skipped ) . esc_html__( ' units', 'jet-booking' ) ;

	}

	/**
	 * Get calendar export file
	 *
	 * @return [type] [description]
	 */
	public function get_calendar_file() {

		$post_id = ! empty( $_GET['_id'] ) ? absint( $_GET['_id'] ) : null;
		$uid     = ! empty( $_GET['_uid'] ) ? absint( $_GET['_uid'] ) : null;

		if ( ! $post_id ) {
			esc_html_e( 'Invalid request data', 'jet-booking' );
			die();
		}

		$post = get_post( $post_id );

		if ( ! $post ) {
			esc_html_e( 'Invalid request data', 'jet-booking' );
			die();
		}

		$this->load_deps();

		$datestamp = \ZCiCal::fromUnixDateTime() . 'Z';
		$calendar  = new \ZCiCal();

		$filename = 'calendar-export--' . $post->post_name;

		if ( $uid ) {
			$filename .= '-' . $uid;
		}

		$filename .= '.ics';

		$bookings = $this->get_bookings( $post_id, $uid );

		if ( ! empty( $bookings ) ) {
			foreach ( $bookings as $booking ) {
				$this->add_booking( $booking, $calendar, $datestamp );
			}
		}

		header( 'Content-type: text/calendar; charset=utf-8' );
		header( 'Content-Disposition: inline; filename=' . $filename );

		echo $calendar->export();

		die();

	}

	/**
	 * Add new booking into existing calendar
	 *
	 * @param [type] $booking  [description]
	 * @param [type] $calendar [description]
	 */
	public function add_booking( $booking, $calendar, $datestamp ) {

		$summary     = $description = $this->get_booking_summary( $booking );
		$hash_string = $booking['check_in_date'] . $booking['check_out_date'] . $booking['booking_id'];
		$uid         = md5( $hash_string ) . '@' . $this->get_domain();

		$event = new \ZCiCalNode( 'VEVENT', $calendar->curnode );

		$check_out_ts = $booking['check_out_date'];
		$period       = Plugin::instance()->settings->get( 'booking_period' );

		if ( ! $period || 'per_nights' === $period ) {
			$per_nights = true;
		} else {
			$per_nights = false;
		}

		if ( ! $per_nights ) {
			$check_out_ts = $check_out_ts + DAY_IN_SECONDS;
		}

		$check_in_date  = date( 'Y-m-d', $booking['check_in_date'] );
		$check_out_date = date( 'Y-m-d', $check_out_ts );

		$event->addNode( new \ZCiCalDataNode( 'UID:' . $uid ) );
		$event->addNode( new \ZCiCalDataNode( 'DTSTART;VALUE=DATE:' . \ZCiCal::fromSqlDateTime( $check_in_date ) ) );
		$event->addNode( new \ZCiCalDataNode( 'DTEND;VALUE=DATE:' . \ZCiCal::fromSqlDateTime( $check_out_date ) ) );
		$event->addNode( new \ZCiCalDataNode( 'DTSTAMP:' . $datestamp ) );
		$event->addNode( new \ZCiCalDataNode( 'SUMMARY:' . $summary ) );
		$event->addNode( new \ZCiCalDataNode( 'DESCRIPTION:' . $description ) );

		do_action_ref_array( 'jet-abaf/ical/export-booking', array( &$booking, &$calendar ) );

	}

	/**
	 * Returns booking summary
	 *
	 * @return [type] [description]
	 */
	public function get_booking_summary( $booking ) {

		$summary = null;
		$format  = __( 'Booking #%1$d', 'jet-booking' );

		if ( ! empty( $booking['order_id'] ) ) {
			$summary = sprintf( $format, $booking['order_id'] );
		} else {
			$db_col = Plugin::instance()->settings->get( 'related_post_type_column' );

			if ( $db_col && ! empty( $booking[ $db_col ] ) ) {
				$summary = sprintf( $format, $booking[ $db_col ] );
			} else {
				$summary = __( 'Booking Item', 'jet-booking' );
			}

		}

		return apply_filters( 'jet-abaf/ical/export-booking-summary', $summary, $booking );

	}

	/**
	 * Returns all valid bookings
	 *
	 * @return [type] [description]
	 */
	public function get_bookings( $post_id, $unit_id = false ) {

		$query = array(
			'apartment_id' => $post_id,
			'status'       => Plugin::instance()->statuses->valid_statuses(),
		);

		if ( $unit_id ) {
			$query['apartment_unit'] = $unit_id;
		}

		return Plugin::instance()->db->query( $query );

	}

	/**
	 * Load dependencies
	 *
	 * @return [type] [description]
	 */
	public function load_deps() {

		if ( defined( '_ZAPCAL' ) ) {
			return;
		}

		require_once JET_ABAF_PATH . 'includes/vendor/icalendar/zapcallib.php';

	}

	/**
	 * Returns export URL
	 *
	 * @param  [type] $post_id [description]
	 * @param  [type] $unit_id [description]
	 * @return [type]          [description]
	 */
	public function get_export_url( $post_id = 0, $unit_id = 0 ) {
		return add_query_arg(
			array(
				$this->trigger => $this->hash,
				'_id'          => $post_id,
				'_uid'         => $unit_id,
			),
			home_url( '/' )
		);
	}

	/**
	 * Strore external calendar URL to synch
	 *
	 * @param  array   $urls    [description]
	 * @param  integer $post_id [description]
	 * @param  boolean $unit_id [description]
	 * @return [type]           [description]
	 */
	public function update_import_urls( $urls = array(), $post_id = 0, $unit_id = false ) {

		if ( ! $post_id ) {
			return;
		}

		$existing = get_post_meta( $post_id, $this->ical_meta, true );

		if ( ! $existing ) {
			$existing = array();
		}

		if ( ! $unit_id ) {
			$unit_id = 'default';
		}

		$existing[ $unit_id ] = $urls;

		update_post_meta( $post_id, $this->ical_meta, $existing );

	}

	/**
	 * Returns all URLs for calendars
	 *
	 * @return [type] [description]
	 */
	public function get_calendars() {

		$post_type = Plugin::instance()->settings->get( 'apartment_post_type' );

		if ( ! $post_type ) {
			return array();
		}

		$posts = get_posts( array(
			'post_type' => $post_type,
			'numberposts' => -1,
		) );

		if ( ! $posts ) {
			return array();
		}

		$result = array();

		foreach ( $posts as $post ) {

			$import = get_post_meta( $post->ID, $this->ical_meta, true );

			if ( ! $import ) {
				$import = array();
			}

			$item = array(
				'post_id'    => $post->ID,
				'title'      => $post->post_title,
				'unit_id'    => false,
				'unit_title' => '',
				'import_url' => isset( $import['default'] ) ? $import['default'] : false,
				'export_url' => $this->get_export_url( $post->ID, false ),
			);

			$units = Plugin::instance()->db->get_apartment_units( $post->ID );

			if ( empty( $units ) ) {
				$result[] = $item;
			} else {
				foreach ( $units as $unit ) {

					$unit_item               = $item;
					$uid                     = $unit['unit_id'];
					$unit_item['unit_id']    = $uid;
					$unit_item['unit_title'] = $unit['unit_title'];
					$unit_item['import_url'] = isset( $import[ $uid ] ) ? $import[ $uid ] : false;
					$unit_item['export_url'] = $this->get_export_url( $post->ID, $uid );

					$result[] = $unit_item;
				}
			}

		}

		return $result;

	}

}
