<?php
	/**
	 * Plugin Name: JetBooking
	 * Plugin URI:  https://crocoblock.com/plugins/jetbooking/
	 * Description: Allows creating a booking functionality for your residence with an availability check, which means your site visitor can select a certain period (check-in and check-out dates) he wants to rent this housing for.
	 * Version:     2.3.5
	 * Author:      Crocoblock
	 * Author URI:  https://crocoblock.com/
	 * Text Domain: jet-booking
	 * License:     GPL-3.0+
	 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
	 * Domain Path: /languages
	 */

// If this file is called directly, abort.
	if (!defined('WPINC')) {
		die();
	}

	add_action('plugins_loaded', 'jet_abaf_init');

	function jet_abaf_init() {
		define('JET_ABAF_VERSION', '2.3.5');
		define('JET_ABAF__FILE__', __FILE__);
		define('JET_ABAF_PLUGIN_BASE', plugin_basename(JET_ABAF__FILE__));
		define('JET_ABAF_PATH', plugin_dir_path(JET_ABAF__FILE__));
		define('JET_ABAF_URL', plugins_url('/', JET_ABAF__FILE__));

		require JET_ABAF_PATH . 'includes/plugin.php';
	}

	add_action( 'plugins_loaded', 'jet_abaf_lang' );

	function jet_abaf_lang() {
		load_plugin_textdomain('jet-booking', false, dirname(plugin_basename(__FILE__)) . '/languages');
	}

	function jet_abaf() {
		return JET_ABAF\Plugin::instance();
	}

	/**
	 * Unregister cron jobs on deactivation
	 */
	register_deactivation_hook(__FILE__, function() {

		$timestamp = wp_next_scheduled('jet-booking/cron/synch-calendars');

		if ($timestamp) {
			wp_unschedule_event($timestamp, 'jet-booking/cron/synch-calendars');
		}

	});
