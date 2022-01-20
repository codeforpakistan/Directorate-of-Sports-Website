<?php
namespace JET_ABAF;

/**
 * Database manager class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define DB class
 */
class DB {

	/**
	 * Check if booking DB table already exists
	 *
	 * @var bool
	 */
	private $bookings_table_exists = null;

	/**
	 * Check if units DB table already exists
	 *
	 * @var bool
	 */
	private $units_table_exists = null;

	/**
	 * Stores latest queried result to use it
	 *
	 * @var null
	 */
	public $latest_result = null;

	/**
	 * Stores latest inserted booking item
	 *
	 * @var array
	 */
	public $inserted_booking = false;

	/**
	 * 
	 */
	public $queried_booking = false;

	/**
	 * Constructor for the class
	 */
	public function __construct() {

		if ( ! empty( $_GET['jet_abaf_install_table'] ) ) {
			add_action( 'init', array( $this, 'install_table' ) );
		}

	}

	/**
	 * Check if booking table alredy exists
	 *
	 * @return boolean [description]
	 */
	public function is_bookings_table_exists() {

		if ( null !== $this->bookings_table_exists ) {
			return $this->bookings_table_exists;
		}

		$table = self::bookings_table();

		if ( $table === self::wpdb()->get_var( "SHOW TABLES LIKE '$table'" ) ) {
			$this->bookings_table_exists = true;
		} else {
			$this->bookings_table_exists = false;
		}

		return $this->bookings_table_exists;
	}

	/**
	 * Check if booking table alredy exists
	 *
	 * @return boolean [description]
	 */
	public function is_units_table_exists() {

		if ( null !== $this->units_table_exists ) {
			return $this->units_table_exists;
		}

		$table = self::units_table();

		if ( $table === self::wpdb()->get_var( "SHOW TABLES LIKE '$table'" ) ) {
			$this->units_table_exists = true;
		} else {
			$this->units_table_exists = false;
		}

		return $this->units_table_exists;

	}

	/**
	 * Check if all required DB tables are exists
	 *
	 * @return [type] [description]
	 */
	public function tables_exists() {
		return $this->is_bookings_table_exists() && $this->is_units_table_exists();
	}

	/**
	 * Try to recreate DB table by request
	 *
	 * @return void
	 */
	public function install_table() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$this->create_bookings_table();
		$this->create_units_table();

	}

	/**
	 * Returns WPDB instance
	 * @return [type] [description]
	 */
	public static function wpdb() {
		global $wpdb;
		return $wpdb;
	}

	/**
	 * Returns table name
	 * @return [type] [description]
	 */
	public static function bookings_table() {
		return self::wpdb()->prefix . 'jet_apartment_bookings';
	}

	/**
	 * Returns table name
	 * @return [type] [description]
	 */
	public static function units_table() {
		return self::wpdb()->prefix . 'jet_apartment_units';
	}

	/**
	 * Insert booking
	 *
	 * @param  array  $booking [description]
	 * @return [type]          [description]
	 */
	public function insert_booking( $booking = array() ) {

		$default_fields = array(
			'apartment_id',
			'apartment_unit',
			'check_in_date',
			'check_out_date',
		);

		$fields   = array_merge( $default_fields, $this->get_additional_db_columns() );
		$format   = array_fill( 0, count( $fields ), '%s' );
		$defaults = array_fill( 0, count( $fields ), '' );
		$defaults = array_combine( $fields, $defaults );
		$booking  = wp_parse_args( $booking, $defaults );

		$booking['check_in_date']  = $booking['check_in_date'] + 1;
		$booking['apartment_unit'] = $booking['apartment_unit'];

		if ( ! $this->is_booking_dates_available( $booking ) ) {
			return false;
		}

		$inserted = self::wpdb()->insert( self::bookings_table(), $booking, $format );

		if ( $inserted ) {
			$this->inserted_booking = $booking;
			return self::wpdb()->insert_id;
		} else {
			return false;
		}

	}

	/**
	 * Check if current booking dates is available
	 *
	 * @param  [type]  $booking [description]
	 * @return boolean          [description]
	 */
	public function is_booking_dates_available( $booking ) {

		$bookings_table = self::bookings_table();
		$apartment_id   = $booking['apartment_id'];
		$unit_id        = false;
		$from           = $booking['check_in_date'];
		$to             = $booking['check_out_date'];

		if ( ! empty( $booking['apartment_unit'] ) ) {
			$unit_id = $booking['apartment_unit'];
		}

		// Increase $from to 1 to avoid overlapping check-in and cak-out dates
		$from++;

		$query = "
			SELECT *
			FROM $bookings_table
			WHERE (
				( `check_in_date` >= $from AND `check_in_date` <= $to )
				OR ( `check_out_date` >= $from AND `check_out_date` <= $to )
				OR ( `check_in_date` < $from AND `check_out_date` >= $to )
			) AND `apartment_id` = $apartment_id";

		if ( $unit_id ) {
			$query .= " AND `apartment_unit` = $unit_id";
		}

		$query .= ";";

		$booked = self::wpdb()->get_results( $query, ARRAY_A );

		if ( empty( $booked ) ) {
			return true;
		} else {

			$skip_statuses   = Plugin::instance()->statuses->invalid_statuses();
			$skip_statuses[] = Plugin::instance()->statuses->temporary_status();

			foreach ( $booked as $index => $booking ) {
				if ( ! empty( $booking['status'] ) && in_array( $booking['status'], $skip_statuses ) ) {
					unset( $booked[ $index ] );
				}
			}

			if ( empty( $booked ) ) {
				return true;
			} else {
				return false;
			}

		}
	}

	/**
	 * Get availbale unit for passed dates
	 *
	 * @return [type]       [description]
	 */
	public function get_available_unit( $booking ) {

		$bookings_table = self::bookings_table();
		$units_table    = self::units_table();
		$apartment_id   = $booking['apartment_id'];
		$from           = $booking['check_in_date'];
		$to             = $booking['check_out_date'];

		$booked_units = self::wpdb()->get_results( "
			SELECT *
			FROM `{$bookings_table}`
			WHERE `apartment_id` = $apartment_id
			AND (
				( `check_in_date` >= $from AND `check_in_date` <= $to )
				OR ( `check_out_date` >= $from AND `check_out_date` <= $to )
				OR ( `check_in_date` < $from AND `check_out_date` >= $to )
			)
		", ARRAY_A );


		$all_units = $this->get_apartment_units( $apartment_id );

		if ( empty( $all_units ) ) {
			return null;
		}

		if ( empty( $booked_units ) ) {
			return $all_units[0]['unit_id'];
		}

		$skip_statuses   = Plugin::instance()->statuses->invalid_statuses();
		$skip_statuses[] = Plugin::instance()->statuses->temporary_status();

		foreach ( $all_units as $unit ) {

			$found = false;

			foreach ( $booked_units as $booked_unit ) {

				if ( ! isset( $booked_unit['status'] ) || ! in_array( $booked_unit['status'], $skip_statuses ) ) {
					if ( absint( $unit['unit_id'] ) === absint( $booked_unit['apartment_unit'] ) ) {
						$found = true;
					}
				}

			}

			if ( ! $found ) {
				return $unit['unit_id'];
			}

		}

		return null;

	}

	/**
	 * Update booking information in database
	 *
	 * @param  integer $booking_id [description]
	 * @param  array   $data       [description]
	 * @return [type]              [description]
	 */
	public function update_booking( $booking_id = 0, $data = array() ) {

		if ( ! empty( $data['check_in_date'] ) ) {
			$data['check_in_date']++;
		}

		self::wpdb()->update(
			self::bookings_table(),
			$data,
			array( 'booking_id' => $booking_id )
		);

	}

	/**
	 * Delete booking by passed parameters
	 *
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	public function delete_booking( $where = array() ) {
		self::wpdb()->delete( self::bookings_table(), $where );
	}

	/**
	 * Delete unit by passed parameters
	 *
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	public function delete_unit( $where = array() ) {
		self::wpdb()->delete( self::units_table(), $where );
	}

	/**
	 * Update unit
	 * @return [type] [description]
	 */
	public function update_unit( $unit_id, $data ) {
		self::wpdb()->update(
			self::units_table(),
			$data,
			array( 'unit_id' => $unit_id )
		);
	}

	/**
	 * Get future bookings for apartment ID (or all future bookings if apartment ID is not passed)
	 *
	 * @param  [type] $apartment_id [description]
	 * @return [type]               [description]
	 */
	public function get_future_bookings( $apartment_id = null ) {

		$table = self::bookings_table();
		$now   = strtotime('now 00:00');
		$query = "SELECT * FROM $table WHERE `check_out_date` > $now";

		if ( $apartment_id ) {
			$apartment_id = absint( $apartment_id );
			$query       .= " AND `apartment_id` = $apartment_id";
		}

		$query .= ";";

		return self::wpdb()->get_results( $query, ARRAY_A );

	}

	/**
	 * Returns all available units for apartment
	 * @return [type] [description]
	 */
	public function get_apartment_units( $apartment_id ) {
		return $this->query(
			array(
				'apartment_id' => $apartment_id,
			),
			self::units_table()
		);
	}

	/**
	 * Returns all available units for apartment
	 * @return [type] [description]
	 */
	public function get_apartment_unit( $apartment_id, $unit_id ) {
		return $this->query(
			array(
				'apartment_id' => $apartment_id,
				'unit_id'      => $unit_id,
			),
			self::units_table()
		);
	}

	/**
	 * Returns appointment detail by order id
	 *
	 * @return [type] [description]
	 */
	public function get_booking_by( $field = 'booking_id', $value = null ) {

		$booking = $this->query(
			array( $field => $value ),
			self::bookings_table()
		);

		if ( empty( $booking ) ) {
			return false;
		}

		$booking = $booking[0];

		return $booking;

	}

	/**
	 * Get already booked apartments
	 *
	 * @param  [type] $from [description]
	 * @param  [type] $to   [description]
	 * @return [type]       [description]
	 */
	public function get_booked_apartments( $from, $to ) {

		$table       = self::bookings_table();
		$units_table = self::units_table();

		// Increase $from to 1 to avoid overlapping check-in and cak-out dates
		$from++;

		$booked = self::wpdb()->get_results( "
			SELECT apartment_id AS `apartment_id`, count( * ) AS `units`
			FROM $table
			WHERE `check_in_date` BETWEEN $from AND $to
			OR `check_out_date` BETWEEN $from AND $to
			OR ( `check_in_date` <= $from AND `check_out_date` >= $to )
			GROUP BY apartment_id;
		", ARRAY_A );

		if ( empty( $booked ) ) {
			return array();
		}

		$available = self::wpdb()->get_results( "
			SELECT apartment_id AS `apartment_id`, count( * ) AS `units`
			FROM $units_table
			GROUP BY apartment_id;
		", ARRAY_A );

		if ( ! empty( $available ) ) {
			$tmp = array();
			foreach ( $available as $row ) {
				$tmp[ $row['apartment_id'] ] = $row['units'];
			}
			$available = $tmp;
		} else {
			$available = array();
		}

		$result = array();

		foreach ( $booked as $apartment ) {

			$ap_id = $apartment['apartment_id'];

			if ( empty( $available[ $ap_id ] ) ) {
				$result[] = $apartment['apartment_id'];
			} else {

				$booked          = absint( $apartment['units'] );
				$available_units = absint( $available[ $ap_id ] );

				if ( $booked >= $available_units ) {
					$result[] = $apartment['apartment_id'];
				}

			}
		}

		return $result;

	}

	/**
	 * Check if is apartment id form updated booking record is available for new dates
	 *
	 * @return [type] [description]
	 */
	public function check_availability_on_update( $booking_id = 0, $apartment_id = 0, $from = 0, $to = 0 ) {

		$table = self::bookings_table();
		$units_table = self::units_table();

		// Increase $from to 1 to avoid overlapping check-in and cak-out dates
		$from++;

		$booked = self::wpdb()->get_results( "
			SELECT *
			FROM $table
			WHERE (
				`check_in_date` BETWEEN $from AND $to
				OR `check_out_date` BETWEEN $from AND $to
				OR ( `check_in_date` < $from AND `check_out_date` >= $to )
			) AND `apartment_id` = $apartment_id;
		", ARRAY_A );

		if ( empty( $booked ) ) {
			return true;
		}

		$this->latest_result = $booked;
		$booking_id          = absint( $booking_id );
		$count               = 0;

		foreach ( $booked as $booking ) {
			if ( absint( $booking['booking_id'] ) === $booking_id ) {
				continue;
			}

			$count++;

		}

		$available = self::wpdb()->get_results( "
			SELECT apartment_id AS `apartment_id`, count( * ) AS `units`
			FROM $units_table
			WHERE `apartment_id` = $apartment_id
			GROUP BY apartment_id;
		", ARRAY_A );

		if ( empty( $available ) && 0 < $count ) {
			return false;
		}

		if ( empty( $available ) && 0 === $count ) {
			return true;
		}

		if ( $count >= absint( $available[0]['units'] ) ) {
			return false;
		} else {
			return true;
		}

	}

	/**
	 * Returns additional DB fields
	 *
	 * @return [type] [description]
	 */
	public function get_additional_db_columns() {
		return apply_filters( 'jet-abaf/db/additional-db-columns', array() );
	}

	/**
	 * Create database table for tracked information
	 *
	 * @return void
	 */
	public function create_bookings_table( $delete_if_exists = false ) {

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		}

		$table = self::bookings_table();

		if ( $delete_if_exists && $this->is_bookings_table_exists() ) {
			self::wpdb()->query( "DROP TABLE $table;" );
		}

		$charset_collate    = self::wpdb()->get_charset_collate();
		$columns_schema     = 'booking_id bigint(20) NOT NULL AUTO_INCREMENT,';
		$columns_schema    .= 'status text,';
		$columns_schema    .= 'apartment_id bigint(20),';
		$columns_schema    .= 'apartment_unit bigint(20),';
		$additional_columns = $this->get_additional_db_columns();
		$additional_columns = array_unique( $additional_columns );

		if ( is_array( $additional_columns ) && ! empty( $additional_columns ) ) {
			foreach ( $additional_columns as $column ) {
				$columns_schema .= $column . ' text,';
			}
		}

		$columns_schema .= 'check_in_date bigint(20),';
		$columns_schema .= 'check_out_date bigint(20),';
		$columns_schema .= 'import_id text,';

		$sql = "CREATE TABLE $table (
			$columns_schema
			PRIMARY KEY (booking_id)
		) $charset_collate;";

		dbDelta( $sql );

	}

	/**
	 * Create DB table for apartment units
	 *
	 * @return [type] [description]
	 */
	public function create_units_table( $delete_if_exists = false ) {

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		}

		$table = self::units_table();

		if ( $delete_if_exists && $this->is_units_table_exists() ) {
			self::wpdb()->query( "DROP TABLE $table;" );
		}

		$charset_collate = self::wpdb()->get_charset_collate();

		$sql = "CREATE TABLE $table (
			unit_id bigint(20) NOT NULL AUTO_INCREMENT,
			apartment_id bigint(20),
			unit_title text,
			notes text,
			PRIMARY KEY (unit_id)
		) $charset_collate;";

		dbDelta( $sql );

	}

	/**
	 * Insert new columns into existing bookings table
	 *
	 * @param  [type] $columns [description]
	 * @return [type]          [description]
	 */
	public function insert_table_columns( $columns = array() ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$table          = self::bookings_table();
		$columns_schema = '';

		foreach ( $columns as $column ) {
			$columns_schema .= 'ADD ' . $column . ' text, ';
		}

		$columns_schema = rtrim( $columns_schema, ', ' );

		$sql = "ALTER TABLE $table
			$columns_schema;";

		self::wpdb()->query( $sql );

	}

	/**
	 * Delete columns into existing bookings table
	 *
	 * @param  [type] $columns [description]
	 * @return [type]          [description]
	 */
	public function delete_table_columns( $columns ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$table          = self::bookings_table();
		$columns_schema = '';

		foreach ( $columns as $column ) {
			$columns_schema .= 'DROP COLUMN ' . $column . ', ';
		}

		$columns_schema = rtrim( $columns_schema, ', ' );

		$sql = "ALTER TABLE $table
			$columns_schema;";

		self::wpdb()->query( $sql );

	}

	/**
	 * Returns default DB fields list
	 * @return [type] [description]
	 */
	public function get_default_fields() {
		return array(
			'booking_id',
			'status',
			'apartment_id',
			'apartment_unit',
			'check_in_date',
			'check_out_date',
		);
	}

	/**
	 * Update database with new columns
	 *
	 * @param  [type] $new_columns [description]
	 * @return [type]              [description]
	 */
	public function update_columns_diff( $new_columns = array() ) {

		$table           = self::bookings_table();
		$default_columns = $this->get_default_fields();

		$columns          = self::wpdb()->get_results( "SHOW COLUMNS FROM $table", ARRAY_A );
		$existing_columns = array();

		if ( empty( $columns ) ) {
			return false;
		}

		foreach ( $columns as $column ) {
			if ( ! in_array( $column['Field'], $default_columns ) ) {
				$existing_columns[] = $column['Field'];
			}
		}

		if ( empty( $new_columns ) && empty( $existing_columns ) ) {
			return;
		}

		$to_delete = array_diff( $existing_columns, $new_columns );
		$to_add    = array_diff( $new_columns, $existing_columns );

		if ( ! empty( $to_delete ) ) {
			$this->delete_table_columns( $to_delete );
		}

		if ( ! empty( $to_add ) ) {
			$this->insert_table_columns( $to_add );
		}

	}

	/**
	 * Add nested query arguments
	 *
	 * @param  [type]  $key    [description]
	 * @param  [type]  $value  [description]
	 * @param  boolean $format [description]
	 * @return [type]          [description]
	 */
	public function get_sub_query( $key, $value, $format = false ) {

		$query = '';
		$glue  = '';

		if ( ! $format ) {

			if ( false !== strpos( $key, '!' ) ) {
				$format = '`%1$s` != \'%2$s\'';
				$key    = ltrim( $key, '!' );
			} else {
				$format = '`%1$s` = \'%2$s\'';
			}

		}

		foreach ( $value as $child ) {
			$query .= $glue;
			$query .= sprintf( $format, esc_sql( $key ), esc_sql( $child ) );
			$glue   = ' OR ';
		}

		return $query;

	}

	/**
	 * Add where arguments to query
	 *
	 * @param array  $args [description]
	 * @param string $rel  [description]
	 */
	public function add_where_args( $args = array(), $rel = 'AND' ) {

		$query      = '';
		$multi_args = false;

		if ( ! empty( $args ) ) {

			$query  .= ' WHERE ';
			$glue    = '';
			$search  = array();
			$props   = array();

			if ( count( $args ) > 1 ) {
				$multi_args = true;
			}

			foreach ( $args as $key => $value ) {

				$format = '`%1$s` = \'%2$s\'';

				$query .= $glue;

				if ( false !== strpos( $key, '!' ) ) {
					$key    = ltrim( $key, '!' );
					$format = '`%1$s` != \'%2$s\'';
				} elseif ( false !== strpos( $key, '>' ) ) {
					$key    = rtrim( $key, '>' );
					$format = '`%1$s` > %2$d';
				} elseif ( false !== strpos( $key, '<' ) ) {
					$key    = rtrim( $key, '<' );
					$format = '`%1$s` < %2$d';
				}

				if ( is_array( $value ) ) {
					$query .= sprintf( '( %s )', $this->get_sub_query( $key, $value, $format ) );
				} else {
					$query .= sprintf( $format, esc_sql( $key ), esc_sql( $value ) );
				}

				$glue = ' ' . $rel . ' ';

			}

		}

		return $query;

	}

	/**
	 * Check if booking DB column is exists
	 *
	 * @return [type] [description]
	 */
	public function column_exists( $column ) {

		$table = self::bookings_table();
		return self::wpdb()->query( "SHOW COLUMNS FROM `$table` LIKE '$column'" );

	}

	/**
	 * Add order arguments to query
	 *
	 * @param array $args [description]
	 */
	public function add_order_args( $order = array() ) {

		$query = '';

		if ( ! empty( $order['orderby'] ) ) {

			$orderby = $order['orderby'];
			$order   = ! empty( $order['order'] ) ? $order['order'] : 'desc';
			$order   = strtoupper( $order );
			$query  .= " ORDER BY $orderby $order";

		}

		return $query;

	}

	/**
	 * Return count of queried items
	 *
	 * @return [type] [description]
	 */
	public function count( $args = array(), $rel = 'AND' ) {

		$table = self::bookings_table();

		$query = "SELECT count(*) FROM $table";

		if ( ! $rel ) {
			$rel = 'AND';
		}

		if ( isset( $args['after'] ) ) {
			$after = $args['after'];
			unset( $args['after'] );
			$args['ID>'] = $after;
		}

		if ( isset( $args['before'] ) ) {
			$before = $args['before'];
			unset( $args['before'] );
			$args['ID<'] = $before;
		}

		$query .= $this->add_where_args( $args, $rel );

		return self::wpdb()->get_var( $query );

	}

	/**
	 * Check if booking already exists
	 *
	 * @param  string $by_field [description]
	 * @param  [type] $value    [description]
	 * @return [type]           [description]
	 */
	public function booking_exists( $by_field = 'ID', $value = null ) {
		$count = $this->count( array( $by_field => $value ) );

		return ! empty( $count );
	}

	/**
	 * Query data from db table
	 *
	 * @return [type] [description]
	 */
	public function query( $args = array(), $table = null, $limit = 0, $offset = 0, $order = array(), $rel = 'AND' ) {

		if ( ! $table ) {
			$table = self::bookings_table();
		}

		$query = "SELECT * FROM $table";

		if ( ! $rel ) {
			$rel = 'AND';
		}

		if ( isset( $args['after'] ) ) {
			$after = $args['after'];
			unset( $args['after'] );
			$args['ID>'] = $after;
		}

		if ( isset( $args['before'] ) ) {
			$before = $args['before'];
			unset( $args['before'] );
			$args['ID<'] = $before;
		}

		$query .= $this->add_where_args( $args, $rel );
		$query .= $this->add_order_args( $order );

		if ( intval( $limit ) > 0 ) {
			$limit  = absint( $limit );
			$offset = absint( $offset );
			$query .= " LIMIT $offset, $limit";
		}

		$raw = self::wpdb()->get_results( $query, ARRAY_A );

		return $raw;

	}

}
