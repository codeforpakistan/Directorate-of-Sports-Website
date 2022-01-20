<?php
/**
 * JetWooBuilder Assets class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Builder_Assets' ) ) {

	/**
	 * Define Jet_Woo_Builder_Assets class
	 */
	class Jet_Woo_Builder_Assets {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Contain plugin localize data.
		 *
		 * @var array
		 */
		public $localize_data = array();

		/**
		 * Constructor for the class
		 */
		public function init() {

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'elementor/frontend/after_enqueue_scripts', array(
				'WC_Frontend_Scripts',
				'localize_printed_scripts',
			), 5 );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

			if ( filter_var( jet_woo_builder_settings()->get( 'enable_custom_templates_styles' ), FILTER_VALIDATE_BOOLEAN ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'template_styles' ) );
				add_action( 'elementor/editor/before_enqueue_styles', array( $this, 'template_styles' ) );
			}

		}

		/**
		 * Enqueue admin-facing stylesheet.
		 */
		public function enqueue_admin_assets() {

			$screen = get_current_screen();

			if ( 'woocommerce_page_wc-settings' === $screen->base ) {
				wp_enqueue_style(
					'jet-woo-builder-admin',
					jet_woo_builder()->plugin_url( 'assets/css/admin.css' ),
					false,
					jet_woo_builder()->get_version()
				);
			}

		}

		/**
		 * Enqueue public-facing stylesheets.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function enqueue_styles() {

			$font_path   = WC()->plugin_url() . '/assets/fonts/';
			$inline_font = '@font-face {
			font-family: "WooCommerce";
			src: url("' . $font_path . 'WooCommerce.eot");
			src: url("' . $font_path . 'WooCommerce.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'WooCommerce.woff") format("woff"),
				url("' . $font_path . 'WooCommerce.ttf") format("truetype"),
				url("' . $font_path . 'WooCommerce.svg#WooCommerce") format("svg");
			font-weight: normal;
			font-style: normal;
			}';

			$deps = [];

			wp_enqueue_style(
				'jet-woo-builder',
				jet_woo_builder()->plugin_url( 'assets/css/jet-woo-builder.css' ),
				apply_filters( 'jet-woo-builder/frontend/styles-dependencies', $deps ),
				jet_woo_builder()->get_version()
			);

			wp_enqueue_style(
				'jet-woo-builder-frontend',
				jet_woo_builder()->plugin_url( 'assets/css/lib/jetwoobuilder-frontend-font/css/jetwoobuilder-frontend-font.css' ),
				false,
				jet_woo_builder()->get_version()
			);

			wp_add_inline_style(
				'jet-woo-builder',
				$inline_font
			);

		}

		/**
		 * Enqueue custom templates stylesheet
		 */
		public function template_styles() {

			wp_enqueue_style(
				'jet-woo-builder-template-styles',
				jet_woo_builder()->plugin_url( 'assets/css/template-styles.css' ),
				array(),
				jet_woo_builder()->get_version()
			);

		}

		/**
		 * Enqueue plugin scripts only with elementor scripts
		 */
		public function enqueue_scripts() {

			$deps = [
				'jquery',
				'elementor-frontend',
			];

			wp_enqueue_script(
				'jet-woo-builder',
				jet_woo_builder()->plugin_url( 'assets/js/jet-woo-builder' . $this->suffix() . '.js' ),
				apply_filters( 'jet-woo-builder/frontend/script-dependencies', $deps ),
				jet_woo_builder()->get_version(),
				true
			);

			global $wp_query;

			$this->localize_data = array(
				'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'products' => json_encode( $wp_query->query_vars ),
			);

			wp_localize_script(
				'jet-woo-builder',
				'jetWooBuilderData',
				apply_filters( 'jet-woo-builder/frontend/localize-data', $this->localize_data )
			);

		}

		/**
		 * Returns minified suffix for plugin scripts
		 *
		 * @return string
		 */
		public function suffix() {
			return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		}

		/**
		 * Returns the instance.
		 *
		 * @return object
		 * @since  1.0.0
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;

		}
		
	}

}

/**
 * Returns instance of Jet_Woo_Builder_Assets
 *
 * @return object
 */
function jet_woo_builder_assets() {
	return Jet_Woo_Builder_Assets::get_instance();
}
