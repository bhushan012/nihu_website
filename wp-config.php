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
define( 'DB_NAME', 'nihu_site_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         '$eIN`9WLy0RH/!BMX@j6*7tyQ|U&v?;h0q?T.sqlLP@*V8b:F_ nR79/~9*euUWu' );
define( 'SECURE_AUTH_KEY',  'E/4G8w:o8JWd0@]`}/|+K4_`>{$qg:5QQDnda|K#~_]VA.{fn!Z:n2<+Cb-1MW(T' );
define( 'LOGGED_IN_KEY',    '4^b2CY7bUnsF.H6QD=|prr_()P=$m]q~y,SsX)VbF?aZ-_,er=S!W^Q.bvz/V?I=' );
define( 'NONCE_KEY',        '::]/5@ #|ji,OD241rnhl,=@0X}MFZ]Zni1<Qa<lm,[-(|Wd)5}Zw1A)j +hCG2S' );
define( 'AUTH_SALT',        '8N?d6*bw.S$rYK&<@8guY,i+Ei|PRje43*)9asFcf6+~7on[CQ4PdpJ[X])+(U#w' );
define( 'SECURE_AUTH_SALT', ')&@@aDHW@3~y=5gk8kgps~Xhfqp!>-;3j;C_+w`pN]Xdz|EvQ5*&VO27t:OT}Ym.' );
define( 'LOGGED_IN_SALT',   'ILDd1&yLj[D@=Zs(|SK=uPnk8ZlXlLbC-`~`;xVXf{H]xt]C#leOw:r$%4Fa,&aw' );
define( 'NONCE_SALT',       '~VHr~N6;.32q{)8|r5}eJKsopWtmLdy60D(5Lf5!T/ikWbpkCU{w?+DGtsgUj9Rz' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ns_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
