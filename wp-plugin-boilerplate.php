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

// Another plugin built from this boilerplate already uses these names.
// Loading this one too would fatal on the duplicate class, so bail with
// a notice instead.
if (defined('MY_PLUGIN_VERSION')) {
	add_action('admin_notices', function () {
		printf(
			'<div class="notice notice-error"><p>%s</p></div>',
			esc_html(sprintf(
				/* translators: %s: plugin file path */
				__('%s was not loaded because another active plugin uses the same MY_PLUGIN_ names. Rename the placeholders listed in its readme.md.', 'wp-plugin-boilerplate'),
				plugin_basename(__FILE__)
			))
		);
	});
	return;
}

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
