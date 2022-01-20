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
class Get_Admin_Comments_List extends Base {

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
		return 'get-admin-comments-list';
	}

	/**
	 * Returns arguments config
	 *
	 * @return [type] [description]
	 */
	public function get_args() {

		return array(
			'page' => array(
				'default'    => 0,
				'required'   => false,
			),
			'pageSize' => array(
				'default'    => 20,
				'required'   => false,
			),
			'search' => array(
				'default'    => '',
				'required'   => false,
			),
			'reviewId' => array(
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

		$page = isset( $args['page'] ) ? $args['page'] : 0;
		$page_size = isset( $args['pageSize'] ) ? $args['pageSize'] : 20;
		$review_id = isset( $args['reviewId'] ) ? $args['reviewId'] : '';
		$search = isset( $args['search'] ) ? $args['search'] : '';

		$comments_query = Comments_Data::get_instance()->get_admin_comments_list_by_page( $page, $page_size, $review_id, $search );

		if ( ! $comments_query ) {
			return rest_ensure_response( array(
				'success' => false,
				'message' => __( 'Error', 'jet-reviews' ),
			) );
		}

		return rest_ensure_response( array(
			'success'  => true,
			'message' => __( 'Success', 'jet-reviews' ),
			'data'    => array(
				'page_list'   => $comments_query['page_list'],
				'total_count' => $comments_query['total_count'],
			),
		) );
	}

}
