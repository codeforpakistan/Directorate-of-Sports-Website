<?php
namespace JET_ABAF;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Session manager
 */
class Session {

	public $key = 'jet_booking';

	public function __construct() {}

	/**
	 * Set session value
	 */
	public function set( $key, $value ) {

		if ( ! session_id() ) {
			session_start();
		}
		
		if ( empty( $_SESSION[ $this->key ] ) ) {
			$_SESSION[ $this->key ] = array();
		}

		$_SESSION[ $this->key ][ $key ] = $value;

	}

	/**
	 * Get session value
	 */
	public function get( $key, $default = false ) {
		
		if ( empty( $_SESSION[ $this->key ] ) ) {
			$_SESSION[ $this->key ] = array();
		}

		return isset( $_SESSION[ $this->key ][ $key ] ) ? $_SESSION[ $this->key ][ $key ] : $default;

	}

}
