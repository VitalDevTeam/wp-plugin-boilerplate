# WordPress Plugin Boilerplate

A simple boilerplate for a simple WordPress plugin.

## Starting a new plugin

Find and replace each placeholder, matching case:

| Placeholder | Where | Replace with |
| --- | --- | --- |
| `wp-plugin-boilerplate` | Plugin folder, main file name, `Text Domain:` header, and the text domain in every `__()`/`esc_html__()` call | Your plugin slug, e.g. `acme-events`. The text domain must match the folder name or WordPress won't auto-load translations. |
| `Plugin Boilerplate` | `Plugin Name:` header | Your plugin's display name |
| `MY_PLUGIN_` | Constants in the main file and `admin.php` | e.g. `ACME_EVENTS_` |
| `My_Plugin_` | Class name in `admin.php` | e.g. `Acme_Events_` |
| `my_plugin` | `$prefix` in `admin.php`, option name in `uninstall.php` | e.g. `acme_events` |

Skipping a row breaks things. Two plugins with the same constants or class can't both load, and two plugins with the same option name share settings, so uninstalling one deletes the other's.

Then:

- Fill in `Description:` and `Plugin URI:` in the main file header.
- Set `Version:` and `MY_PLUGIN_VERSION` to the same value.
- Check `uninstall.php` deletes every option the plugin creates. It runs without the plugin loaded, so option names have to be written out there.
