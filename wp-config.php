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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'F%q(c=B6|fA/h7A9a%&9f)y6mx,lYx`.[[wu?(8(ajTm..-62 +`iB%>V6<cy.&$' );
define( 'SECURE_AUTH_KEY',   'm.5yidt_)~XmEfh@Vzv*?j:X~p<P:Ld-V2X%a(]h+z0nr55Xj@b_mMP7.H$[arr[' );
define( 'LOGGED_IN_KEY',     '>JVQP]sAVGSw]||dc`O>%uR_Q4:wJLMZI#y|-0ly:v3<.B[>+!dY:& nCKL_}baz' );
define( 'NONCE_KEY',         'Ws%ot!5Scv]<rATihc@.>$;o4:wa_Q2:3L>mMCU4E^PK}moJpLd,<MH&h=D6K<m~' );
define( 'AUTH_SALT',         '*s&KEaKf9>/_bW,@rvjJH6B[F]mh{I:OW>Du3Ue0a<isM>>60af) _5L+`C,xi7Y' );
define( 'SECURE_AUTH_SALT',  'xZ`zwtyiTGJ#@U5,bj88M[LzIum6LsA_Vi%mi|BqsP$c(*$vXby*LM?M_9:yB$Ob' );
define( 'LOGGED_IN_SALT',    ')6~Clo>AH(}I!Ql/$ER]p<FKJ[M%Dl=A lkM&uWZ%mlNYp>0{D|!O*&f6De +FJZ' );
define( 'NONCE_SALT',        '<j{LE.tYB{-_vl<Ms*Wo;3k#0QfqJlYH3kDtjCTm,}G[I,}jc(&pRDJpP3d>OdPK' );
define( 'WP_CACHE_KEY_SALT', 'F)z!WhqVT7[kM:D{+@m 6M7qj3J`7jZ5bVqK`sTw2m8uH-J2X8oI;u1l8R$F?T+;' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
// if ( ! defined( 'WP_DEBUG' ) ) {
// 	define( 'WP_DEBUG', false );
// }

/* That's all, stop editing! Happy publishing. */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
