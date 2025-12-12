<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ukroa' );

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
define( 'AUTH_KEY',         '~GEb4$*vch)zTr^11`>~vH{i],KLkoS|aabKOn|b2Rp5DimMTnMfW9+6V eLn>:9' );
define( 'SECURE_AUTH_KEY',  'yOl{sXuOv#!Z4N=QkM,Q/g% y5JpXYSvBWV2M0ds]M!mAa=BKN|GAH6v2xa7u@fr' );
define( 'LOGGED_IN_KEY',    '^l;M8{hWQz7)%6wcJKE[iIvvz7y:P+<BXIFB(Uw,-QJwx/P~s1fJ*)%&ra+a=&Gw' );
define( 'NONCE_KEY',        'ohv2D TX?(xV4kY,xD[UNW#]d$ PVF9d{`bCZLCfSPHw*&DEOU4z|NVN_TD%+dCO' );
define( 'AUTH_SALT',        'GQB6)O&#b@(c-0*x!Q8 JZF5-n]$ l|twqblQ2*Hn0NbW5]@VX3KSEkt8gU(&+Zm' );
define( 'SECURE_AUTH_SALT', '{]T!3Ppko$TepL%dA#3%-:(iKol_Zhy3tE%9jgtEMiiu#K;ROnqRuSEE?7YdFAY+' );
define( 'LOGGED_IN_SALT',   'b8vcuX05Y]I:)03KUta#}/.)pT[(!>YZz#8@f&tWCrh:{GuBT[@+Hs{9Ndhd W(n' );
define( 'NONCE_SALT',       'ViyM5M2(|YyGZme.HS%3c5zBPh:f>SJZcS1`>bVkx-#6n8s8QLq4=lW/81M[:Xz2' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
