<?php
namespace JET_ABAF;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * @property Engine_Plugin engine_plugin
 * @property WC_Integration wc
 * @property DB db
 * @property Settings settings
 * @property Statuses statuses
 * @property Session session
 *
 * Class Plugin
 * @package JET_ABAF
 */
class Plugin {

	/**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {

			self::$instance = new self();

		}

		return self::$instance;

	}

	/**
	 * Register autoloader.
	 */
	private function register_autoloader() {
		require JET_ABAF_PATH . 'includes/autoloader.php';
		Autoloader::run();
	}

	/**
	 * Initialize plugin parts
	 *
	 * @return void
	 */
	public function init_components() {
		$this->db             = new DB();
		$this->engine_plugin  = new Engine_Plugin();
		$this->filters_plugin = new Filters_Plugin();
		$this->settings       = new Settings();
		$this->booking_meta   = new Dashboard\Booking_Meta();
		$this->order_meta     = new Dashboard\Order_Meta();
		$this->setup          = new Set_Up();
		$this->statuses       = new Statuses();
		$this->wc             = new WC_Integration();
		$this->elementor      = new Elementor_Integration\Manager();
		$this->session        = new Session();
		$this->rest_api       = new Rest_API\Manager();
		$this->google_cal     = new Google_Calendar();
		$this->dashboard      = new Dashboard\Manager( array(
			new Dashboard\Pages\Bookings(),
			new Dashboard\Pages\Settings(),
			new Dashboard\Pages\Calendars(),
			new Dashboard\Pages\Set_Up(),
		) );

		new Formbuilder_Plugin\Jfb_Plugin();

		if ( Plugin::instance()->settings->get( 'ical_synch' ) ) {
			$this->ical = new iCal();
		}

		if ( is_admin() ) {

			new Upgrade();

			new Updater\Plugin( array(
				'version' => JET_ABAF_VERSION,
				'slug'    => 'jet-booking',
			) );

			new Updater\Changelog( array(
				'name'     => 'JetBooking',
				'slug'     => 'jet-booking',
				'version'  => JET_ABAF_VERSION,
				'author'   => '<a href="https://crocoblock.com/">Crocoblock</a>',
				'homepage' => 'https://crocoblock.com/plugins/jetbooking/',
				'banners'  => array(
					'high' => JET_ABAF_URL . 'assets/images/banner.png',
					'low'  => JET_ABAF_URL . 'assets/images/banner.png',
				),
			) );
		}

	}

	/**
	 * Returns path to template file.
	 *
	 * @return string|bool
	 */
	public function get_template( $name = null ) {

		$template_path = apply_filters( 'jet-abaf/template-path', 'jet-booking' );
		$template      = locate_template( $template_path . $name );

		if ( ! $template ) {
			$template = JET_ABAF_PATH . 'templates/' . $name;
		}

		if ( file_exists( $template ) ) {
			return $template;
		} else {
			return false;
		}

	}

	/**
	 * Plugin constructor.
	 */
	private function __construct() {

		if ( ! function_exists( 'jet_engine' ) ) {

			add_action( 'admin_notices', function() {
				$class = 'notice notice-error';
				$message = __( '<b>WARNING!</b> <b>Jet Booking</b> plugin requires <b>Jet Engine</b> plugin to work properly!', 'jet-booking' );
				printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), wp_kses_post( $message ) );
			} );

			return;
		}

		$this->register_autoloader();

		add_action( 'after_setup_theme', array( $this, 'init_components' ), 0 );
	}

}

Plugin::instance();
