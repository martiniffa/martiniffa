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
define('DB_NAME', 'martinffa');

/** MySQL database username */
define('DB_USER', 'root');

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
define('AUTH_KEY',         'qFmKxq8fncW)Q:H->xyyDK6jV>{FW36?;=C puJZ8s3Q-P>DzPW!?!^olu:xO@T}');
define('SECURE_AUTH_KEY',  'od:8w~]LSq!o~ER@4K/8N>hB?*t$95/,Mz<oeQO<-Wa+-1?e7booj`Hkj;-`3}[m');
define('LOGGED_IN_KEY',    '=$O0%>S1shn ^>$r`BE@:@rOa.NDAhgGP 7T<N#pS.4PXHm<KVv6UHkU4Sz[:02]');
define('NONCE_KEY',        '%gQ298jvxgV(wL8cUclX.q&a|m>{EI5<FDz70QP[$C{(y^O6VcYcJLT:w j5?>No');
define('AUTH_SALT',        'SQy{o!U|rH}0KV;~g[BlD?YTh(Q-!vOx$Wx8vx,2l^HEfJTB|f7(,t=dW4f;(RMt');
define('SECURE_AUTH_SALT', '?zN&;-,m0`Nyn>gx9KuV*J<sD+cKR8<gP?_;<hb<EJ3TL^TC1Y@i3x3ly6?]n>iq');
define('LOGGED_IN_SALT',   'DxiNy[w1+1;GLLKb?Aba9kZ%&G~ya09!J]ox,Wvm3x$~{34$rfUX.yy#Z3D`tjw}');
define('NONCE_SALT',       '=+7V/lzwVM@Uj%&Q4(!tc7 s_:]=QpEb?Dv-s4[I1t,wkM|#]JQQU?&=E$Cri@I1');

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
