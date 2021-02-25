<?php
defined('ABSPATH') || exit;

class My_Plugin_Settings_Page {

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
	 * The plugin options.
	 * Used in field callbacks.
	 *
	 * @var    string
	 * @access private
	 * @since  1.0.0
	 * @return mixed
	 */
	private $options;

	/**
	 * Initialize class.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct() {
		$this->version = '1.0.0';
		$this->prefix = 'my_plugin';

		add_action('admin_menu', [$this, 'add_plugin_page'], 100);
		add_action('admin_init', [$this, 'page_init']);
	}

	/**
	 * Adds options subpage to Settings.
	 * You can add top-level pages using add_options_page().
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function add_plugin_page() {

		add_submenu_page(
			// The slug name for the parent menu (or the file name
			// of a standard WordPress admin page)
			'options-general.php',
			// Page Title
			'Plugin Settings',
			// Menu Title
			'Plugin Settings',
			// Capability needed to access this page
			'manage_options',
			// Menu Slug - Used by WP to idenify this page
			$this->prefix,
			// Callback that renders page
			[$this, 'page_render']
		);
	}

	/**
	 * Renders the options page.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function page_render() {
		$this->options = get_option("{$this->prefix}_option");
		?>
		<div class="wrap">
			<h2>Plugin Options</h2>
			<form method="post" action="options.php">
			<?php
				// Output nonce, action, and option_page fields.
				// Use the name of the appropriate options group.
				settings_fields("{$this->prefix}_options_group");
				// Prints settings section.
				// Use the slug name of the page whose settings sections you want to output.
				// This should match the page name used in add_settings_section().
				do_settings_sections($this->prefix);
				// Submit button
				submit_button('Save');
			?>
			</form>
		</div>
		<?php
	}

	/**
	 * Initializes options page, registers and adds settings.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function page_init() {

		/**
		 * Registers a setting and its sanitization callback.
		 * Defines the actual option the setting fields will be stored in.
		 */
		register_setting(
			// A name for the options group
			"{$this->prefix}_options_group",
			// A name for your option
			"{$this->prefix}_option",
			// Callback function that sanitizes the option's value
			[$this, 'sanitize']
		);

		/**
		 * Adds a section of settings.
		 * Use as many as you need.
		 */
		add_settings_section(
			// String for use in the 'id' attribute of tags
			'plugin_settings_section_1',
			// Title of the section
			'Plugin Settings Section 1',
			// Function that renders the section with content
			[$this, 'print_section_1_info'],
			// The menu page on which to display this section
			$this->prefix
		);

		/**
		 * Adds a single setting field (an option in the wp_options table).
		 */
		add_settings_field(
			// String for use in the 'id' attribute of tags
			'my_setting',
			// Title of the field
			'My Setting',
			// Function that fills the field with the desired inputs
			// as part of the larger form
			[$this, 'my_setting_callback'],
			// The menu page on which to display this field
			$this->prefix,
			// The section of the settings page in which to show the box
			'plugin_settings_section_1'
		);
	}

	/**
	 * Sanitizes each setting field as needed.
	 *
	 * @access public
	 * @since  1.0.0
	 * @param  array $input Contains all settings fields as array keys
	 * @return array Sanitized field input.
	 */
	public function sanitize($input) {
		$new_input = [];

		if (isset($input['my_setting'])) {
			$new_input['my_setting'] = sanitize_text_field($input['my_setting']);
		}

		return $new_input;
	}

	/**
	 * Prints section text.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function print_section_1_info() {
		print 'This is description text for the section 1.';
	}

	/**
	 * Gets the settings and print their values.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function my_setting_callback() {

		if (isset($this->options['my_setting'])) {
			$my_setting = esc_attr($this->options['my_setting']);
		} else {
			$my_setting = '';
		}

		$output = "<input style='width: 100%;' type='text' id='my_setting' name='{$this->prefix}_option[my_setting]' value='{$my_setting}' placeholder='Enter setting value'/>";
		$output .= '<p class="description">A description for the field (optional).</p>';

		echo $output;
	}
}

if (is_admin()) {
	new My_Plugin_Settings_Page();
}
