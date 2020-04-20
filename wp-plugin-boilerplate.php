<?php
/*
	Plugin Name:
	Plugin URI:
	Description:
	Version: 1.0
	Author: Vital
	Author URI: https://vtldesign.com
	Text Domain: vital
	License: GPLv2

	Copyright 2020  VITAL  (email : hello@vtldesign.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (! defined('ABSPATH')) {
	exit;
}

class Plugin_Name {

	private $plugin_path;
	private $plugin_url;

	/**
	 * Initialize plugin
	 */
	public function __construct() {

		$this->plugin_path    = plugin_dir_path(__FILE__);
		$this->plugin_url     = plugin_dir_url(__FILE__);

		require $this->plugin_path . 'admin.php';

		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'add_action_link']);

	}

	/**
	 * Add link to settings on Plugins page
	 */
	public function add_action_link($links) {
		$custom_link = [
			'<a href="' . admin_url('options-general.php?page=PLUGIN_SETTINGS_PAGE') . '">Settings</a>',
		];
		return array_merge($custom_link, $links);
	}

	/**
	 * Enqueue JavaScripts
	 */
	public function enqueue_scripts() {
	}

	/**
	 * Enqueue stylesheets
	 */
	public function enqueue_styles() {
	}

	/**
	 * Enqueue admin JavaScripts
	 */
	public function enqueue_admin_scripts() {
	}

	/**
	 * Enqueue admin stylesheets
	 */
	public function enqueue_admin_styles() {
	}

}

new Plugin_Name();
