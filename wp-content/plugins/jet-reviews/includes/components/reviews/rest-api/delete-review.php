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
class Delete_Review extends Base {

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
		return 'delete-review';
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
		);
	}

	/**
	 * [callback description]
	 * @param  [type]   $request [description]
	 * @return function          [description]
	 */
	public function callback( $request ) {

		$args = $request->get_params();

		$post_id = isset( $args['post_id'] ) && ! empty( $args['post_id'] ) ? $args['post_id'] : false;
		$review_id = isset( $args['id'] ) && ! empty( $args['id'] ) ? $args['id'] : false;

		if ( ! $review_id ) {
			return rest_ensure_response( array(
				'success' => false,
				'message' => __( 'Error', 'jet-reviews' ),
			) );
		}

		jet_reviews()->user_manager->delete_user_approval_review( $review_id );

		$delete_review = Reviews_Data::get_instance()->delete_review_by_id( $review_id );

		if ( 0 === $delete_review ) {
			return rest_ensure_response( array(
				'success' => false,
				'message' => __( 'The review has not been deleted', 'jet-reviews' ),
			) );
		}

		return rest_ensure_response( array(
			'success'  => true,
			'message' => __( 'The review have been deleted', 'jet-reviews' ),
		) );
	}

}
