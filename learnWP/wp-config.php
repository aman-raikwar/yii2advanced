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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'learnwp');

/** MySQL database username */
define('DB_USER', 'devrahul');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'jY}~s-v{j[Wabibk<M2]lYYdS#^w}2Hez$OD@T{S2( D![OaztYSpFZ$4a]uD4G]');
define('SECURE_AUTH_KEY',  '3jLVZY6S25Y*PzeGHG6%,*SU*=OBW<Wl<eK/N;J 554BxYf& ?Qb#FWz+g%LVILn');
define('LOGGED_IN_KEY',    '5d}!%:(eF6am-K?3oP>EV2>%Iv#:kdw:N&7ReIB0xjVSIgrmx9JN0zp6r<Y@!&@A');
define('NONCE_KEY',        '9S{H+YLm_u5|<0_s0@<a%e7UWgi)h`Zj2@%#=#:x[F7c_Y8!H~vN~*(8MC2C+e2W');
define('AUTH_SALT',        '#-=?|h_E37FJtz5%{6#esb7?Mr3QrNB!Nw3@y%@DdD%kE%@]#C0.z{dhi1(p(yG9');
define('SECURE_AUTH_SALT', 'Mc%~}<o? ?}EEi8sCIj@#1A&#Y~|(^mPn7FC@~X[FZV|(|*^wo?0mioHvXBxX^Ic');
define('LOGGED_IN_SALT',   'oCwsk&@$hDP-CkY8u/2?*?_2jG)fUWrr8wgP0u0xU]v$UX|vSf}_=l?X@meT M)R');
define('NONCE_SALT',       '$@-vG[X|Cv4.bL:f$:)GLOL-qHyz#^dbHsr9IGii;~w<fUe 0sfQH!`E(1sp9T4S');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
