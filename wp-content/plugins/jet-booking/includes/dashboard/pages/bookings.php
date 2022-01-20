<?php
namespace JET_ABAF\Dashboard\Pages;

use JET_ABAF\Dashboard\Helpers\Page_Config;
use JET_ABAF\Plugin;

/**
 * Base dashboard page
 */
class Bookings extends Base {

	/**
	 * Page slug
	 *
	 * @return string
	 */
	public function slug() {
		return 'jet-abaf-bookings';
	}

	/**
	 * Page title
	 *
	 * @return string
	 */
	public function title() {
		return esc_html__( 'Bookings', 'jet-booking' );
	}

	/**
	 * Return  page config object
	 *
	 * @return [type] [description]
	 */
	public function page_config() {
		return new Page_Config(
			$this->slug(),
			array(
				'api'          => Plugin::instance()->rest_api->get_urls( false ),
				'bookings'     => $this->get_bookings(),
				'statuses'     => Plugin::instance()->statuses->get_schema(),
				'all_statuses' => Plugin::instance()->statuses->get_statuses(),
				'edit_link'    => add_query_arg( array(
					'post'   => '%id%',
					'action' => 'edit',
				), admin_url( 'post.php' ) ),
			)
		);
	}

	/**
	 * Returns all registered booikngs list
	 *
	 * @return [type] [description]
	 */
	public function get_bookings() {

		$post_type = Plugin::instance()->settings->get( 'apartment_post_type' );

		if ( ! $post_type ) {
			return array();
		}

		$posts = get_posts( array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
		) );

		if ( ! $posts ) {
			return array();
		}

		return wp_list_pluck( $posts, 'post_title', 'ID' );

	}

	/**
	 * Page render funciton
	 *
	 * @return void
	 */
	public function render() {
		?>
		<style type="text/css">
			.cell--id {
				flex: 0 0 4%;
			}
			.cell--booking_id {
				flex: 0 0 5%;
			}
			.cell--apartment_id,
			.cell--apartment_unit,
			.cell--check_in_date,
			.cell--check_out_date,
			.cell--order_id {
				flex: 0 0 12%;
			}
			.cell--status {
				flex: 0 0 30%;
				display: flex;
				justify-content: space-between;
				align-items: center;
			}
			.jet-abaf-actions button {
				margin: 0 0 0 10px;
			}
			.jet-abaf-details p {
				font-size: 15px;
				line-height: 23px;
				padding: 0;
				margin: 0;
				display: flex;
				align-items: center;
				padding: 0 0 10px;
			}
			.jet-abaf-details select,
			.jet-abaf-details input {
				max-width: 100%;
				width: 100%;
			}
			.jet-abaf-details b {
				color: #23282d;
				width: 50%;
				flex: 0 0 50%;
			}
			.jet-abaf-details .notice {
				margin: 0;
			}
			.jet-abaf-loading {
				opacity: .6;
			}
			.jet-abaf-bookings-error {
				font-size: 15px;
				line-height: 23px;
				color: #c92c2c;
				padding: 0 0 10px;
			}
		</style>
		<div id="jet-abaf-bookings-page"></div>
		<?php
	}

	/**
	 * Page specific assets
	 *
	 * @return [type] [description]
	 */
	public function assets() {
		$this->enqueue_script( $this->slug(), 'admin/bookings.js' );
	}

	/**
	 * Page components templates
	 *
	 * @return [type] [description]
	 */
	public function vue_templates() {
		return array(
			'bookings',
			'bookings-list',
		);
	}

}