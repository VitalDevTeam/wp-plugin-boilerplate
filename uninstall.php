<?php
defined('WP_UNINSTALL_PLUGIN') || exit;

// Let's be kind and keep WordPress's database free of orphaned data.
// Remove our options from the database when the plugin is uninstalled!
delete_option('my_plugin_option');
