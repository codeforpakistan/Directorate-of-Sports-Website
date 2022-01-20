<?php
namespace JET_ABAF\Dashboard\Pages;

use JET_ABAF\Dashboard\Helpers\Page_Config;
use JET_ABAF\Plugin;

/**
 * Base dashboard page
 */
class Calendars extends Base {

	/**
	 * Page slug
	 *
	 * @return string
	 */
	public function slug() {
		return 'jet-abaf-calendars';
	}

	/**
	 * Page title
	 *
	 * @return string
	 */
	public function title() {
		return esc_html__( 'Calendars', 'jet-booking' );
	}

	/**
	 * Page render funciton
	 *
	 * @return void
	 */
	public function render() {
		?>
		<style type="text/css">
			.cell--post_title {
				flex: 0 0 12%;
			}
			.cell--unit_title {
				flex: 0 0 12%;
			}
			.cell--export_url {
				flex: 0 0 30%;
				display: flex;
				justify-content: space-between;
				align-items: center;
			}
			.cell--import_url {
				flex: 0 0 46%;
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
			.cx-vue-list-table code {
				max-width: 100%;
				word-break: break-word;
			}
		</style>
		<div id="jet-abaf-ical-page"></div>
		<?php
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
				'api' => Plugin::instance()->rest_api->get_urls( false ),
			)
		);
	}

	/**
	 * Page specific assets
	 *
	 * @return [type] [description]
	 */
	public function assets() {
		$this->enqueue_script( $this->slug(), 'admin/calendars.js' );
	}

	/**
	 * Set to true to hide page from admin menu
	 * @return boolean [description]
	 */
	public function is_hidden() {
		return ! Plugin::instance()->settings->get( 'ical_synch' );
	}

	/**
	 * Page components templates
	 *
	 * @return [type] [description]
	 */
	public function vue_templates() {
		return array(
			'calendars',
			'calendars-list',
		);
	}

}