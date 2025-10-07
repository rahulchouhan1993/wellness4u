<?php

/** Enable W3 Total Cache Edge Mode */
define('W3TC_EDGE_MODE', true); // Added by W3 Total Cache

/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
// [System edited file at 2023-03-28T12:19:23.115268248Z ]
// define('DB_NAME', 'blog');
define( 'DB_NAME','zy9e01v60pjb6ujb_blog');

/** MySQL database username */
// [System edited file at 2023-03-28T12:19:23.115316836Z ]
// define('DB_USER', 'yscr_bbpD2r');
define( 'DB_USER','zy9e01v60pjb6ujb_yscrbbpD2r');

/** MySQL database password */
define('DB_PASSWORD', 'C4nCovQgq25x5w');

/** MySQL hostname */
define('DB_HOST', 'mysql');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'JDuumozHSXdxN78XDsLhNtdiH1KhDq66a9gi1S5PiAUb5KnneuGKGwW7lnn2MDJJ');
define('SECURE_AUTH_KEY',  '49E53guS9hoPtipbCwajX8QjbM3BDTvkskMOQexsnLEE0KIedDMvGIjNbxsz83vH');
define('LOGGED_IN_KEY',    'GqKE5AE0S2GDjNL90YdlhwPksCqAsoI4C1kVzP1d2u6VJXVkakfX7Fxc52k4l7cS');
define('NONCE_KEY',        'hJQc5UM7EOYr7l85ppgnASMjJuPzfSXPOHR3iru0Ibxbvb9s91HqvALCWwcAy9Q2');
define('AUTH_SALT',        'T1WL7fWeoBhfUQu1MRjnRhLk1mdy4ndzYonaY3XKnTYsfmmy8HcQTvX3Q147Ldxd');
define('SECURE_AUTH_SALT', 'wk3l7z7l8mz1KmQWakmpbFKlieAxSRsjb7UhHCrx2AqJ1zzE5qEjkscrKvVBYhco');
define('LOGGED_IN_SALT',   '7D9S9TfqT9ROyRdUzKprs2Jmz6XwFkF5lNqoqeUiGjR1KMMM477LInqRE0N8cjSz');
define('NONCE_SALT',       'JUfs9epxDTaCmnzQWdstLqInQVlvuOUOxuXv7Po5l0jiw0XS3Nze9kEiywDEnnxI');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'asb_';

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
