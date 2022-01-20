<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Je7fVQQws5hCskfSi0hDa7DvpF/e3rJ5lwFKswhpCCDwpK913yPn0UGMFrr7XpDAybqv1ioFgL3w7E/ZXLG+Xw==');
define('SECURE_AUTH_KEY',  '4AocUoHuyXVINfzteF1TrzxUBStZOVDk3lLft/bvKxRT3a1nGfReUweft1nLFNEv383r/fE7+mc5ypLOrPP/Dw==');
define('LOGGED_IN_KEY',    '0d7rBD0hTipIaImxN8SfifrOoeOEFSaA88NgSa9apXRc+gZytvCyd2JTN2JqaMEZKjQmBZgjhUFGqXeE16HBuw==');
define('NONCE_KEY',        'WXJ5WuNvdb4ZvcpYA0D096gEq1XbFMVBJDO38TJ1ro2DRKp1U20G48+X47/Z+Zpgm75MXxBUniyS19N3b+22BA==');
define('AUTH_SALT',        'NFNemHIm7/DtMtqcYXSIJ2v7/Wc6lw5nUDAnb2qyS6DaOF7pWtUMubsB321CrUUrp22Dih/3H4y4+Jugfj/xTg==');
define('SECURE_AUTH_SALT', 'zIWI4rSJJTxOf8PGk/TdvQ65RBaz0jQUWvSNhLHFAz+dpVdZjVlGojILbQA7YgzpVv8BT+KrMWL0jh+pm1ONmA==');
define('LOGGED_IN_SALT',   'OaOC2PJHUj+uu+hoqBSePHeJbhxLLT3cYSqgeQkrV1EAmVDKmyV4/SdM/jnuw9I/83YHGvPDKCAgQxVZyYLqqQ==');
define('NONCE_SALT',       '1UYiwrigtHDNU4q4TaFi/LmRv6BuRd+JCYOsNH/GKGbJ12VQjTSzZPiR+P1gkuFTxGiDPIFIV0SzjqMIJNbyuA==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
