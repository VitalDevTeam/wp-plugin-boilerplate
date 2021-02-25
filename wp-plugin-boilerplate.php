<?php
/*
	Plugin Name:
	Plugin URI:
	Description:
	Version: 1.0.0
	Requires at least: 5.2
	Requires PHP: 7.0
	Author: Vital
	Author URI: https://vtldesign.com
	Text Domain: vital
*/

if (! defined('ABSPATH')) {
	exit;
}

class Plugin_Name {

	/**
	 * The plugin version number.
	 * @var    string
	 * @access public
	 * @since  1.0.0
	 */
	public $version;

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
	 * The plugin prefix.
	 *
	 * @var    string
	 * @access private
	 * @since  1.0.0
	 */
	private $prefix;

	/**
	 * Initialize plugin.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct() {

		$this->version = '1.0.0';
		$this->plugin_path = plugin_dir_path(__FILE__);
		$this->plugin_url = plugin_dir_url(__FILE__);
		$this->prefix = 'plugin_boilerplate';

		require $this->plugin_path . 'admin.php';

		register_activation_hook($this->plugin_path, [$this, 'activate']);
		register_deactivation_hook($this->plugin_path, [$this, 'deactivate']);

		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'add_action_link']);
	}

	/**
	 * Add link to settings on Plugins page.
	 *
	 * @access private
	 * @since  1.0.0
	 * @return array The array of action links.
	 */
	public function add_action_link($links) {
		$custom_link = [
			'<a href="' . admin_url('options-general.php?page=PLUGIN_SETTINGS_PAGE') . '">Settings</a>',
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
	public function activate() {
	}

	/**
	 * Runs plugin deactivation tasks.
	 * Use uninstall.php for tasks that should only happen on uninstall.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function deactivate() {
	}

	/**
	 * Enqueue JavaScripts
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_scripts() {

		wp_enqueue_script(
			"{$this->prefix}_js",
			$this->plugin_url . '/js/main.js',
			['jquery'],
			$this->version,
			true
		);
	}

	/**
	 * Enqueue stylesheets
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_styles() {
	}

	/**
	 * Enqueue admin JavaScripts
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_admin_scripts() {
	}

	/**
	 * Enqueue admin stylesheets
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_admin_styles() {
	}
}

new Plugin_Name();
