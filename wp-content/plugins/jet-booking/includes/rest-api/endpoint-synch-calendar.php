<?php
namespace JET_ABAF\Rest_API;

use JET_ABAF\Plugin;

class Endpoint_Synch_Calendar extends \Jet_Engine_Base_API_Endpoint {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'synch-calendar';
	}

	/**
	 * API callback
	 *
	 * @return void
	 */
	public function callback( $request ) {

		$params  = $request->get_params();
		$item    = ! empty( $params['item'] ) ? $params['item'] : array();
		$post_id = ! empty( $item['post_id'] ) ? absint( $item['post_id'] ) : false;
		$unit_id = ! empty( $item['unit_id'] ) ? absint( $item['unit_id'] ) : false;

		if ( ! $post_id ) {
			return rest_ensure_response( array(
				'success' => false,
				'data'    => esc_html__( 'Post ID not found in the request', 'jet-booking' ),
			) );
		}

		$log = Plugin::instance()->ical->synch( $post_id, $unit_id );

		return rest_ensure_response( array(
			'success' => true,
			'result'  => $this->log_to_html( $log ),
		) );

	}

	/**
	 * Convert log to HTML
	 *
	 * @return [type] [description]
	 */
	public function log_to_html( $log = array() ) {

		$res = '';

		foreach ( $log as $item ) {
			$res .= sprintf( '<li>%s</li>', $item );
		}

		return sprintf( '<ul>%s</ul>', $res );

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

}