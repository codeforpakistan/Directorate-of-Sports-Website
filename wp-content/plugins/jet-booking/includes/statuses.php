<?php
namespace JET_ABAF;

/**
 * Statuses class
 */
class Statuses {

	private $statuses = array();

	/**
	 * Install statuses
	 */
	public function __construct() {
		$this->statuses = array(
			'created'    => _x( 'Created', 'Order status', 'jet-booking' ),
			'pending'    => _x( 'Pending payment', 'Order status', 'jet-booking' ),
			'processing' => _x( 'Processing', 'Order status', 'jet-booking' ),
			'on-hold'    => _x( 'On hold', 'Order status', 'jet-booking' ),
			'completed'  => _x( 'Completed', 'Order status', 'jet-booking' ),
			'cancelled'  => _x( 'Cancelled', 'Order status', 'jet-booking' ),
			'refunded'   => _x( 'Refunded', 'Order status', 'jet-booking' ),
			'failed'     => _x( 'Failed', 'Order status', 'jet-booking' ),
		);
	}

	public function get_schema() {
		return array(
			'valid'       => $this->valid_statuses(),
			'in_progress' => $this->in_progress_statuses(),
			'finished'    => $this->finished_statuses(),
			'invalid'     => $this->invalid_statuses(),
		);
	}

	/**
	 * Returns valid statuses
	 * If appointment has this status - appontment slot is set as not-allowed
	 *
	 * @return [type] [description]
	 */
	public function valid_statuses() {
		return array(
			'pending',
			'processing',
			'completed',
			'on-hold',
		);
	}

	/**
	 * Returns valid but not finalized statuses
	 *
	 * @return [type] [description]
	 */
	public function in_progress_statuses() {
		return array(
			'pending',
			'processing',
			'on-hold',
		);
	}

	/**
	 * Returns valid and finished statuses
	 * @return [type] [description]
	 */
	public function finished_statuses() {
		return array_values( array_diff( $this->valid_statuses(), $this->in_progress_statuses() ) );
	}

	/**
	 * Returns invalid statuses
	 * If appointment has this status - appontment slot is set as not-allowed
	 *
	 * @return [type] [description]
	 */
	public function invalid_statuses() {
		return array(
			'cancelled',
			'refunded',
			'failed',
		);
	}

	/**
	 * Temporary status for WC and Payment orders
	 *
	 * @return [type] [description]
	 */
	public function temporary_status() {
		return 'created';
	}

	/**
	 * Get all statuses
	 * @return [type] [description]
	 */
	public function get_statuses() {
		return $this->statuses;
	}

	/**
	 * Get all statuses
	 * @return [type] [description]
	 */
	public function get_statuses_ids() {
		return array_keys( $this->statuses );
	}

}