<?php
namespace Jet_Reviews\Compatibility;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Compatibility Manager
 */
class Woocommerce {

	/**
	 * [__construct description]
	 */
	public function __construct() {

		if ( ! class_exists( 'WooCommerce' ) ) {
			return false;
		}

		add_action( 'jet-reviews/user/verifications/register', array( $this, 'add_verification' ) );
	}

	/**
	 * [add_verification description]
	 */
	public function add_verification( $user_manager ) {

		require_once jet_reviews()->plugin_path( 'includes/user/verifications/base.php' );

		$default = array(
			'\Jet_Reviews\User\Verifications\Product_Customer' => jet_reviews()->plugin_path( 'includes/compatibility/plugins/woocommerce/verifications/product-customer.php' ),
			'\Jet_Reviews\User\Verifications\Shop_Manager'     => jet_reviews()->plugin_path( 'includes/compatibility/plugins/woocommerce/verifications/shop-manager.php' ),
		);

		foreach ( $default as $class => $file ) {
			require $file;

			$user_manager->register_verification( $class );
		}
	}

}
