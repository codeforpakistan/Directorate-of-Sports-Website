<?php
namespace Jet_Reviews\Endpoints;

use Jet_Reviews\Comments\Data as Comments_Data;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Posts class
 */
class Delete_Comment extends Base {

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
		return 'delete-comment';
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

		$comment_id = isset( $args['id'] ) && ! empty( $args['id'] ) ? $args['id'] : false;

		if ( ! $comment_id ) {
			return rest_ensure_response( array(
				'success' => false,
				'message' => __( 'Error', 'jet-reviews' ),
			) );
		}

		$deleted_comments = Comments_Data::get_instance()->delete_comment_by_id( $comment_id );

		if ( false === $deleted_comments ) {
			return rest_ensure_response( array(
				'success' => false,
				'message' => __( 'Error', 'jet-reviews' ),
			) );
		}

		$comments_query = Comments_Data::get_instance()->get_admin_comments_list_by_page( 0, 20 );

		return rest_ensure_response( array(
			'success' => true,
			'message' => __( 'Comment have been deleted', 'jet-reviews' ),
			'data'    => array(
				'page_list'   => $comments_query['page_list'],
				'total_count' => $comments_query['total_count'],
			),
		) );
	}

}
