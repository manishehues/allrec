<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'allrec');

/** Database username */
define('DB_USER', 'root');

/** Database password */

define('DB_PASSWORD', '');


/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '0meI>Nxv$0Q65]RdT~-w6W%d>t;65XLGqmx!{)jE}B*]cs ;0OT8%OC[fI/o:2vK');
define('SECURE_AUTH_KEY',  ';:~J,u1SqE<hs_DSdNZ/]F>:P5-U6xoOv:%H$PK67yr*+L-kHP?o6n5#xHc>{vYI');
define('LOGGED_IN_KEY',    'DbcjtWMy_6GaZ4<sGS%ag82!!d$aD~CcIUY(|H=Af8%$:wCjEXqo3~CD D@w::A^');
define('NONCE_KEY',        'fUmcY(<ZI5E?m(<CB7c1(E/lC.@J(<rrHMIkgF@iP)l>qK5]RV2rwgI:6tYe6p<q');
define('AUTH_SALT',        'q5#[BAi&024^3hi{48oNV7QOafY;&stY#CwX@V-5ukZ/xv7_k$<Dt80+e#fXDO-o');
define('SECURE_AUTH_SALT', 'pHzd6Swu%8Z9<[$-W}[2qNhed!Y<(4+q4/v^78ruc+MJ>4j*rXwsLx)Zt|%C%`iw');
define('LOGGED_IN_SALT',   'w!=dbqnl-AFg %(e<aou@5;tWsyvXc!Hxy]FYZ?e4e/3e_RYCzEdRPYlVxG[xtq ');
define('NONCE_SALT',       '43LK.|$iMoHV1C1K}g@{jF9X^{=_1/Infd$]Z7LA2QPz_6{lYNSWQIbJ/U^Leejn');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

// Enable WP_DEBUG mode
define('WP_DEBUG', false);

// Enable Debug logging to the /wp-content/debug.log file
define('WP_DEBUG_LOG', false);

// Disable display of errors and warnings
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define('SCRIPT_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
