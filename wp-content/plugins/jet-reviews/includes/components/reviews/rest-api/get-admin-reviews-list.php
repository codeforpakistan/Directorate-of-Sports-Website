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
class Get_Admin_Reviews_List extends Base {

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
		return 'get-admin-reviews-list';
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
			'page_size' => array(
				'default'    => 20,
				'required'   => false,
			),
			'title' => array(
				'default'    => '',
				'required'   => false,
			),
			'post_type' => array(
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
		$page_size = isset( $args['page_size'] ) ? $args['page_size'] : 20;
		$title = isset( $args['title'] ) ? $args['title'] : '';
		$post_type = isset( $args['post_type'] ) ? $args['post_type'] : '';

		$reviews_query = Reviews_Data::get_instance()->get_admin_reviews_list_by_page( $page, $page_size, $title, $post_type );

		if ( ! $reviews_query ) {
			return rest_ensure_response( array(
				'success' => false,
				'message' => __( 'Error', 'jet-reviews' ),
			) );
		}

		return rest_ensure_response( array(
			'success'  => true,
			'message' => __( 'Success', 'jet-reviews' ),
			'data'    => array(
				'page_list' => $reviews_query['page_list'],
				'total_count' => $reviews_query['total_count'],
			),
		) );
	}

}
