<?php
if (! defined('ABSPATH')) {
	exit;
}

class Plugin_Name_Settings {

	/**
	 * Initialize class.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct() {

		if (function_exists('acf')) {
			add_action('init', [$this, 'settings']);
		}
	}

	/**
	 * Adds settings page and fields.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function settings() {

		acf_add_options_page([
			'page_title'      => 'Plugin Name',
			'menu_title'      => 'Plugin Name',
			'menu_slug'       => 'plugin-settings-slug',
			'parent_slug'     => 'options-general.php',
			'update_button'   => 'Save',
			'updated_message' => 'Settings Saved.',
			'capability'      => 'edit_posts',
			'redirect'        => false,
		]);

		acf_add_local_field_group([
			'key'                   => 'group_vtl_settings',
			'title'                 => 'Plugin Name Settings',
			'fields'                => [],
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'plugin-settings-slug',
					],
				],
			],
			'style'                 => 'seamless',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => 1,
		]);

	}
}

$plugin_settings_page = new Plugin_Name_Settings();
