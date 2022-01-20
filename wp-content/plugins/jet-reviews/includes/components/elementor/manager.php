<?php
namespace Jet_Reviews\Elementor;

class Manager {

	/**
	 * [$dynamic_tags description]
	 * @var [type]
	 */
	public $dynamic_tags;

	/**
	 * Check if processing elementor widget
	 *
	 * @var boolean
	 */
	private $is_elementor_ajax = false;

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->load_files();

		add_action( 'elementor/init', array( $this, 'init_components' ) );

		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_addons' ), 10 );

		add_action( 'wp_ajax_elementor_render_widget', array( $this, 'set_elementor_ajax' ), 10, -1 );
	}

	/**
	 * [load_files description]
	 * @return [type] [description]
	 */
	public function load_files() {
		require jet_reviews()->plugin_path( 'includes/components/elementor/dynamic-tags/module.php' );
	}

	/**
	 * Check if we currently in Elementor mode
	 *
	 * @return void
	 */
	public function in_elementor() {

		$result = false;

		if ( wp_doing_ajax() ) {
			$result = $this->is_elementor_ajax;
		} elseif ( \Elementor\Plugin::instance()->editor->is_edit_mode()
			|| \Elementor\Plugin::instance()->preview->is_preview_mode() ) {
			$result = true;
		}

		/**
		 * Allow to filter result before return
		 *
		 * @var bool $result
		 */
		return apply_filters( 'jet-reviews/in-elementor', $result );
	}

	/**
	 * Initialize elementor-related components
	 * @return [type] [description]
	 */
	public function init_components() {
		$this->dynamic_tags = new Dynamic_Tags\Module();
	}

	/**
	 * Register cherry category for elementor if not exists
	 *
	 * @return void
	 */
	public function register_category() {

		$elements_manager = \Elementor\Plugin::instance()->elements_manager;
		$cherry_cat       = 'cherry';

		$elements_manager->add_category(
			$cherry_cat,
			array(
				'title' => esc_html__( 'JetElements', 'jet-reviews' ),
				'icon'  => 'font',
			),
			1
		);
	}

	/**
	 * Register plugin addons
	 *
	 * @param  object $widgets_manager Elementor widgets manager instance.
	 * @return void
	 */
	public function register_addons( $widgets_manager ) {

		require jet_reviews()->plugin_path( 'includes/components/base/base-elementor-widget.php' );

		foreach ( glob( jet_reviews()->plugin_path( 'includes/components/elementor/widgets/' ) . '*.php' ) as $file ) {
			$slug = basename( $file, '.php' );

			$this->register_addon( $file, $widgets_manager );
		}
	}

	/**
	 * Register addon by file name
	 *
	 * @param  string $file            File name.
	 * @param  object $widgets_manager Widgets manager instance.
	 * @return void
	 */
	public function register_addon( $file, $widgets_manager ) {

		$base  = basename( str_replace( '.php', '', $file ) );
		$class = ucwords( str_replace( '-', ' ', $base ) );
		$class = str_replace( ' ', '_', $class );
		$class = sprintf( '\Elementor\%s', $class );

		require $file;

		if ( class_exists( $class ) ) {
			$widgets_manager->register_widget_type( new $class );
		}
	}

	/**
	 * Set $this->is_elementor_ajax to true on Elementor AJAX processing
	 *
	 * @return  void
	 */
	public function set_elementor_ajax() {
		$this->is_elementor_ajax = true;
	}
}
