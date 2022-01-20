<?php
namespace JET_ABAF\Dashboard\Pages;

use JET_ABAF\Dashboard\Helpers\Page_Config;
use JET_ABAF\Plugin;

/**
 * Base dashboard page
 */
class Settings extends Base {

	/**
	 * Page slug
	 * @return string
	 */
	public function slug() {
		return 'jet-abaf-settings';
	}

	/**
	 * Page title
	 * @return string
	 */
	public function title() {
		return esc_html__( 'Settings', 'jet-booking' );
	}

	/**
	 * Is settings page
	 *
	 * @return boolean [description]
	 */
	public function is_settings_page() {
		return true;
	}

	/**
	 * Page render funciton
	 * @return void
	 */
	public function render() {
		?>
		<style type="text/css">
			.cx-vui-component--schedule-time .cx-vui-component__control {
				display: flex;
				align-items: center;
			}
			.cx-vui-component--schedule-time .cx-vui-select {
				width: 55px;
			}
			.jet-schedule-delimiter {
				padding: 0 5px;
			}
		</style>
		<div class="wrap"><div id="jet-abaf-settings-page"></div></div>
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
				'post_types' => \Jet_Engine_Tools::get_post_types_for_js( array(
					'value' => '',
					'label' => esc_html__( 'Select...', 'jet-booking' ),
				) ),
				'settings' => Plugin::instance()->settings->get_all(),
				'cron_schedules' => $this->get_cron_schedules(),
				'db_tables_exists' => Plugin::instance()->db->tables_exists(),
			)
		);
	}

	/**
	 * Returns registered cron intervals
	 *
	 * @return [type] [description]
	 */
	public function get_cron_schedules() {

		$schedules       = wp_get_schedules();
		$result          = array();
		$found_intervals = array();

		usort( $schedules, function( $a, $b ) {

			if ( $a['interval'] == $b['interval'] ) {
				return 0;
			}

			return ( $a['interval'] < $b['interval'] ) ? -1 : 1;

		} );

		foreach ( $schedules as $name => $int ) {
			if ( ! in_array( $int['interval'], $found_intervals ) ) {

				$diff = human_time_diff( 0, $int['interval'] );

				$result[] = array(
					'value' => $name,
					'label' => $int['display'] . ' (' . $diff . ')',
				);

				$found_intervals[] = $int['interval'];
			}
		}

		return $result;

	}

	/**
	 * Page specific assets
	 *
	 * @return [type] [description]
	 */
	public function assets() {
		$this->enqueue_script( $this->slug(), 'admin/settings.js' );
	}

	/**
	 * Page components templates
	 *
	 * @return [type] [description]
	 */
	public function vue_templates() {
		return array(
			'settings',
			'settings-general',
			'settings-labels',
			'settings-advanced',
		);
	}

}