<?php
namespace JET_ABAF\Dashboard;

use JET_ABAF\Plugin;

/**
 * Dashboard interface manager
 */
class Manager {

	private $pages        = array();
	private $current_page = false;

	/**
	 * [__construct description]
	 * @param array $pages [description]
	 */
	public function __construct( $pages = array() ) {

		foreach ( $pages as $page ) {

			$this->pages[ $page->slug() ] = $page;

			if ( $page->is_setup_page() ) {
				Plugin::instance()->setup->register_setup_page( $page );
			}

			if ( $page->is_settings_page() ) {
				Plugin::instance()->setup->register_setup_success_page( $page );
			}

		}

		add_action( 'admin_menu', array( $this, 'register_pages' ) );

		if ( $this->is_dashboard_page() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
			$page = ! empty( $_GET['page'] ) ? esc_attr( $_GET['page'] ) : false;
			$this->current_page = $this->pages[ $page ];
		}

	}

	/**
	 * Check if is dashboard page
	 *
	 * @return boolean [description]
	 */
	public function is_dashboard_page() {

		$page = ! empty( $_GET['page'] ) ? esc_attr( $_GET['page'] ) : false;

		if ( ! $page ) {
			return false;
		} else {
			return isset( $this->pages[ $page ] );
		}

	}

	/**
	 * Check if passed page is currently dispalyed
	 *
	 * @return boolean [description]
	 */
	public function is_page_now( $page ) {

		if ( ! $this->is_dashboard_page() ) {
			return false;
		}

		return ( $page->slug() === $this->current_page->slug() );

	}

	/**
	 * Dashboard assets
	 *
	 * @param  [type] $hook [description]
	 * @return [type]       [description]
	 */
	public function assets( $hook ) {

		if ( ! function_exists( 'jet_engine' ) ) {
			return;
		}

		$ui_data = jet_engine()->framework->get_included_module_data( 'cherry-x-vue-ui.php' );
		$ui      = new \CX_Vue_UI( $ui_data );

		$ui->enqueue_assets();

		$this->current_page->enqueue_script( 'jet-abaf-dashboard-common', 'admin/common.js' );

		$this->current_page->assets();

		$config = $this->current_page->page_config();

		if ( $config->is_set() ) {
			wp_localize_script( $config->get( 'handle' ), 'JetABAFConfig', $config->get( 'config' ) );
		}

		add_action( 'admin_footer', array( $this, 'render_vue_templates' ) );

	}

	/**
	 * Render vue templates set for current apge
	 *
	 * @return [type] [description]
	 */
	public function render_vue_templates() {
		$this->current_page->render_vue_template( 'go-to-setup', 'common' );
		$this->current_page->render_vue_templates();
	}

	/**
	 * Register appointments
	 * @return [type] [description]
	 */
	public function register_pages() {

		$parent = false;

		foreach ( $this->pages as $page ) {

			if ( $page->is_hidden() ) {
				continue;
			}

			if ( ! $parent ) {

				$parent = $page->slug();

				add_menu_page(
					$page->title(),
					$page->title(),
					'manage_options',
					$page->slug(),
					array( $page, 'render' ),
					'dashicons-tickets-alt'
				);

			} else {

				add_submenu_page(
					$parent,
					$page->title(),
					$page->title(),
					'manage_options',
					$page->slug(),
					array( $page, 'render' )
				);

			}
		}

	}

}
