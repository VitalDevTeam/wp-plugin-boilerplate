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

## Files

| File | What it does |
| --- | --- |
| `wp-plugin-boilerplate.php` | Main plugin file. WordPress reads the header and loads this file; everything else is loaded from here. |
| `admin.php` | A settings page under Settings, with one example text field. |
| `uninstall.php` | Deletes the plugin's options when it's deleted from the Plugins screen. |
| `index.php` | Empty. Stops the server listing the folder's contents if directory indexes are on. |

## Customizing

**Main file.** Add `require_once MY_PLUGIN_PATH . 'your-file.php';` for each new file. Use `MY_PLUGIN_PATH` and `MY_PLUGIN_URL` for paths and URLs so files still work from subfolders. To run code on activation or deactivation, uncomment the hooks at the bottom and define the callbacks.

**Settings page** (`admin.php`):

- **Add a field:** add an `add_settings_field()` call in `page_init()`, a callback that renders it, and a line in `sanitize()` that cleans it. Unsanitized fields are dropped on save.
- **Add a section:** add an `add_settings_section()` call in `page_init()` and point fields at its ID.
- **Move the page:** change the first argument of `add_submenu_page()` (e.g. `tools.php`), or use `add_menu_page()` for a top-level menu. A top-level page needs `settings_errors()` at the top of `page_render()` to show save notices.
- **Change who can use it:** set `$capability`. It controls both viewing the page and saving.
- **Add CSS or JS:** uncomment the calls in `enqueuer()` and add the files under `assets/`. They only load on this page.

**Uninstall** (`uninstall.php`): add a `delete_option()` line for every option the plugin creates.

## Removing what you don't need

- **No settings page:** delete `admin.php` and its `require_once` line in the main file.
- **No stored options:** delete `uninstall.php`.
- **No activation hooks:** delete the commented block at the bottom of the main file.
- **Not hosted on a server with directory indexes:** `index.php` can go, but it costs nothing to keep.
