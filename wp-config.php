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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'vivid-spaces' );

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
define( 'AUTH_KEY',         'jY_v-uJ?0mSp~85yo(JLe3<v8!g*+#yq1)F) O=S6Mq>3!XR.P~?v@Hq6;g^6f{o' );
define( 'SECURE_AUTH_KEY',  '7C2ID/e*+%~,_ ZbI>gNN2fr(:+ljO|(XST5l4>Qiw,MhGuJU-kS|{.!,t~%vwwt' );
define( 'LOGGED_IN_KEY',    'VLJg] 4|F&0FsEnN/&JNtcLJ()g./dZ*tuCPpxc0UQ.Z|u:q`lqYvp86$m^n{l=7' );
define( 'NONCE_KEY',        '-VvFZ +=MN#7bg!w+Eg#^zR_zC|*TaaL!kuiDvFRK&{p!ca-}N/$=k&juM}rUCK?' );
define( 'AUTH_SALT',        'vln{{ijX-,<Y)RMKk5oNC-wG$I:6<s/mau|6E[*ohCCy0HRC`{POE&Q.6 ]PDZ)`' );
define( 'SECURE_AUTH_SALT', 'QpfuSTifisHUY>eQ(v/JBH>M;lu+o8~pD5ARigY:aap X+HL=@+NaA^se*P!3)a(' );
define( 'LOGGED_IN_SALT',   'BSPFt!}/ rR.;l7TGauY7kI9{B=#P`u; )}B5L%{sVr[i76yy0,lkJT+u9l5Z tc' );
define( 'NONCE_SALT',       'VIK?<d.vpADnb[3p/&,U;2(c4~ljnNk9[P5Ta9}`r/F@}{fm:(Mi]z*O(O?HRCHL' );

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
