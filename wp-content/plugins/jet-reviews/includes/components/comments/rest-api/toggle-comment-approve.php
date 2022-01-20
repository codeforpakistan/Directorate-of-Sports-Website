<?php
namespace Jet_Reviews\Endpoints;

use Jet_Reviews\Reviews\Data as Reviews_Data;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define Posts class
 */
class Toggle_Comment_Approve extends Base {

	/**
	 * [get_method description]
	 * @return [type] [description]
	 */
	public function get_method() {
		return 'POST';
	}

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'toggle-comment-approve';
	}

	/**
	 * Returns arguments config
	 *
	 * @return [type] [description]
	 */
	public function get_args() {

		return array(
			'id' => array(
				'default'    => '',
				'required'   => false,
			),
			'approved' => array(
				'default'    => '',
				'required'   => false,
			),
		);
	}

	/**
	 * [callback description]
	 * @param  [type]   $request [description]
	 * @return function          [description]
	 */
	public function callback( $request ) {

		$args = $request->get_params();

		$id = isset( $args['id'] ) ? $args['id'] : false;
		$approved = isset( $args['approved'] ) ? $args['approved'] : false;

		$table_name = jet_reviews()->db->tables( 'review_comments', 'name' );

		$prepared_data = array(
			'approved' => filter_var( $approved, FILTER_VALIDATE_BOOLEAN ) ? 0 : 1,
		);

		$query = jet_reviews()->db->wpdb()->update(
			$table_name,
			$prepared_data,
			array(
				'id' => $id,
			)
		);

		if ( false === $query || 0 === $query ) {
			return rest_ensure_response( array(
				'success' => false,
				'message' => __( 'Error', 'jet-reviews' ),
			) );
		}

		return rest_ensure_response( array(
			'success' => true,
			'message' => __( 'Success', 'jet-reviews' ),
		) );
	}
}
