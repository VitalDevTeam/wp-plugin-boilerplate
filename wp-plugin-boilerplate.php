<?php
defined('ABSPATH') || exit;
/*
	Plugin Name: My Plugin
	Plugin URI:
	Description:
	Version: 1.0.0
	Requires at least: 5.2
	Requires PHP: 7.0
	Author: Vital
	Author URI: https://vtldesign.com
	Text Domain: my-plugin
*/

register_activation_hook(__FILE__, ['My_Plugin', 'activate']);
register_deactivation_hook(__FILE__, ['My_Plugin', 'deactivate']);

add_action('plugins_loaded', ['My_Plugin', 'init']);

class My_Plugin {

	/**
	 * The class instance.
	 * @var    object
	 * @access private
	 * @since  1.0.0
	 */
	protected static $instance;

	/**
	 * The main plugin directory path.
	 *
	 * @var    string
	 * @access private
	 * @since  1.0.0
	 */
	private $plugin_path;

	/**
	 * The main plugin directory URL.
	 *
	 * @var    string
	 * @access private
	 * @since  1.0.0
	 */
	private $plugin_url;

	/**
	 * The plugin version number.
	 * @var    string
	 * @access public
	 * @since  1.0.0
	 */
	public $version;

	/**
	 * The plugin prefix.
	 *
	 * @var    string
	 * @access private
	 * @since  1.0.0
	 */
	private $prefix;

	/**
	 * Initialize class.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public static function init() {
		is_null(self::$instance) && self::$instance = new self;
		return self::$instance;
	}

	/**
	 * Initialize plugin.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct() {
		$this->plugin_path = plugin_dir_path(__FILE__);
		$this->plugin_url = plugin_dir_url(__FILE__);
		$this->version = '1.0.0';
		$this->prefix = 'my_plugin';

		require $this->plugin_path . 'admin.php';

		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'add_action_link']);
	}

	/**
	 * Enqueue JavaScripts.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_scripts() {

		// EXAMPLE
		// wp_enqueue_script(
		// 	"{$this->prefix}_js",
		// 	$this->plugin_url . '/js/main.js',
		// 	['jquery'],
		// 	$this->version,
		// 	true
		// );
	}

	/**
	 * Enqueue stylesheets.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_styles() {
	}

	/**
	 * Enqueue admin JavaScripts.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_admin_scripts() {
	}

	/**
	 * Enqueue admin stylesheets.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_admin_styles() {
	}

	/**
	 * Adds link to settings on Plugins page.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return array The array of action links.
	 */
	public function add_action_link($links) {
		$custom_link = [
			'<a href="' . admin_url('options-general.php?page=MY_PLUGIN_SETTINGS_PAGE') . '">Settings</a>',
		];

		return array_merge($custom_link, $links);
	}

	/**
	 * Runs plugin activation tasks.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public static function activate() {
		if (!current_user_can('activate_plugins')) {
			return;
		}

		$plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
		check_admin_referer("activate-plugin_{$plugin}");
	}

	/**
	 * Runs plugin deactivation tasks.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public static function deactivate() {
		if (!current_user_can('activate_plugins')) {
			return;
		}

		$plugin = isset($_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
		check_admin_referer("deactivate-plugin_{$plugin}");
	}
}
