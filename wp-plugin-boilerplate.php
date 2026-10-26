<?php
/**
 * Plugin Name: Plugin Boilerplate
 * Plugin URI:
 * Description:
 * Version: 1.0.0
 * Requires at least: 6.9
 * Requires PHP: 8.1
 * Author: Vital
 * Author URI: https://vitaldesign.com
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-plugin-boilerplate
 * Update URI: false
 */

defined('ABSPATH') || exit;

// Keep in sync with the Version header above.
define('MY_PLUGIN_VERSION', '1.0.0');
// Resolved here so included files can live in subdirectories.
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MY_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once MY_PLUGIN_PATH . 'admin.php';

// Activation and deactivation hooks must be registered from this file.
// They also run under WP-CLI and bulk activation, so don't check nonces
// or referers in the callbacks.
// register_activation_hook(__FILE__, 'my_plugin_activate');
// register_deactivation_hook(__FILE__, 'my_plugin_deactivate');
