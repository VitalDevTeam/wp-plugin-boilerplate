<?php
defined('WP_UNINSTALL_PLUGIN') || exit;

// Let's be kind and keep WordPress's database free of orphaned data.
// Remove our options from the database when the plugin is uninstalled!
// The plugin isn't loaded during uninstall, so this name must match
// "{$prefix}_option" in admin.php.
// On multisite this only clears the current site. Loop over get_sites()
// with switch_to_blog() if the plugin stores options per site.
delete_option('my_plugin_option');
