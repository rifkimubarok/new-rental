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
define( 'DB_NAME', 'c0_rental_new' );

/** MySQL database username */
define( 'DB_USER', 'c0_rental' );

/** MySQL database password */
define( 'DB_PASSWORD', 'rental123!@#' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'o0k268qv0oetcs2wuai67zgi1tz6jposfwkt97veasjfb9yahrt0huhpci7vobuk' );
define( 'SECURE_AUTH_KEY',  'vkcl4fs1cyhnxp3bftcswlevjp3c2newllwjvs4iql9x8czgmfpejsdc2gxcmgj7' );
define( 'LOGGED_IN_KEY',    'jkxlllnzucfiryxm5gb4aqovfvpfw0mvt82ipdlxkb38gxpjz8emdlaa9zickm1e' );
define( 'NONCE_KEY',        'z0twsmtgykvklsuogrpskczacep7gkzjjczexaofxjhgrz5is4zkdwjjxhvcczdv' );
define( 'AUTH_SALT',        '8firmdox5pvjc5v7er0vxkfjwimsgxmfghhykg0euxpxq5bxmuilldz36yjg9rwe' );
define( 'SECURE_AUTH_SALT', 'e8yy4hzl6twnf45paa8c4id7qcba3ehwe1v3mmtdpea4us5ob4fxpirw3iejbo1l' );
define( 'LOGGED_IN_SALT',   '8ojplfegby94vjl5zs61mkw4fjtkonei6xu7chc0rxh3k1j1ymi1k2ahkcagvbp3' );
define( 'NONCE_SALT',       'qvtenavvtzlkioo2hijqfmjx6zmjunuzlzdvsgk3ragcdghykovtvrd6h5sd2lxv' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpzt_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
