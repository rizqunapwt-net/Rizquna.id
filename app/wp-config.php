<?php
/**
 * WordPress Configuration - Rizquna.id
 * PHP 8.2 + MariaDB
 * 
 * Environment: Detects local (Docker) vs production automatically.
 * - Local:      http://localhost:8088
 * - Production: https://rizquna.id
 */

// === Environment Detection ===
$is_local = (
    php_sapi_name() === 'cli' ||
    (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) ||
    (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] === 'localhost') ||
    getenv('DB_HOST') === 'db'  // Docker service name
);

if ($is_local) {
    // --- LOCAL DEVELOPMENT ---
    $_SERVER['HTTPS'] = 'off';
    define('FORCE_SSL_ADMIN', false);
    define('FORCE_SSL_LOGIN', false);
    define('WP_SITEURL', 'http://localhost:8088');
    define('WP_HOME',    'http://localhost:8088');
    @ini_set('session.cookie_secure', false);
} else {
    // --- PRODUCTION (rizquna.id) ---
    define('FORCE_SSL_ADMIN', true);
    define('WP_SITEURL', 'https://rizquna.id');
    define('WP_HOME',    'https://rizquna.id');
    @ini_set('session.cookie_secure', true);
}

// === Security ===
@ini_set('session.cookie_httponly', true);
@ini_set('session.use_only_cookies', true);

// === Auto Updates ===
define('WP_AUTO_UPDATE_CORE', 'minor');

// === Database Settings ===
define('DB_NAME',     getenv('DB_NAME')     ?: 'u9443309_wp827');
define('DB_USER',     getenv('DB_USER')     ?: 'u9443309_wp827');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'wordpress_password');
define('DB_HOST',     getenv('DB_HOST')     ?: 'db');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// === Authentication Keys and Salts ===
define('AUTH_KEY',         '8wtflhjpslfbu1qz0yzukpenhocaxbcihhuhnadkp2sdul0zhze1koobjywjrgx2');
define('SECURE_AUTH_KEY',  'xdve4swzdskzt58vtajk2xldhrcbshr032mrc09ugmwkflmwcdrvrftwjwrfk3wk');
define('LOGGED_IN_KEY',    'iicdfvczo25jdytxdhzcdytgb93k6ppvr3gdfgvhduhnzg5g2z9ydd0mmsh7elax');
define('NONCE_KEY',        'guaqpaq6gfacmsgd2jka9tm03plrzfxgc50mayeet9bzi3nqswb206iykor3cy8n');
define('AUTH_SALT',        'yjlegi6ntzujapltkulsftgh3tzpkcvruo4ps1wgqbezydsmlgshohkqbd0fjex7');
define('SECURE_AUTH_SALT', 'vdtze6i0czgqtk5zeapcloeugumz5hqeatvpyoylj9gnmux93nnlzfuyeybf8rzx');
define('LOGGED_IN_SALT',   'owh3bpwebvxzpctotmu94bvgrmpjnmnbwbacn2n1vzmx4rfcymzje9e3nhpf6npp');
define('NONCE_SALT',       'egajc26knobtiqae7uop8qutapibegdqdz5bfxco4mmlqjtdcz0cmjf4kbn9zwac');

// === Database Table Prefix ===
$table_prefix = 'wp_';

// === Performance & Memory ===
define('WP_MEMORY_LIMIT', '512M');
define('WP_MAX_MEMORY_LIMIT', '512M');
define('WP_POST_REVISIONS', 5);
define('AUTOSAVE_INTERVAL', 120);
define('EMPTY_TRASH_DAYS', 15);

// === Debugging ===
define('WP_DEBUG', $is_local ? true : false);
define('WP_DEBUG_LOG', $is_local ? true : false);
define('WP_DEBUG_DISPLAY', false);

// === File System ===
define('FS_METHOD', 'direct');
define('DISALLOW_FILE_EDIT', $is_local ? false : true);

/* That's all, stop editing! Happy publishing. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}
require_once(ABSPATH . 'wp-settings.php');
