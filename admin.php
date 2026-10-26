<?php
defined('ABSPATH') || exit;

class My_Plugin_Settings_Page {

	/**
	 * The plugin prefix.
	 *
	 * @var    string
	 * @access private
	 * @since  1.0.0
	 */
	private $prefix = 'my_plugin';

	/**
	 * Capability needed to view the page and save its settings.
	 *
	 * @var    string
	 * @access private
	 * @since  1.0.0
	 */
	private $capability = 'manage_options';

	/**
	 * The settings page hook suffix, returned by add_submenu_page().
	 *
	 * @var    string|false
	 * @access private
	 * @since  1.0.0
	 */
	private $page_hook = false;

	/**
	 * Initialize class.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct() {
		// Registered on init, not admin_init, so the sanitize callback and
		// default apply to every update_option() and get_option() call,
		// including cron, REST, WP-CLI, and front-end requests.
		add_action('init', [$this, 'register_settings']);
		add_action('admin_menu', [$this, 'add_plugin_page'], 100);
		add_action('admin_init', [$this, 'page_init']);
		add_action('admin_enqueue_scripts', [$this, 'enqueuer']);

		// options.php checks this filter, not the page capability, before saving.
		add_filter("option_page_capability_{$this->prefix}_options_group", [$this, 'get_capability']);
	}

	/**
	 * Enqueue admin styles and scripts.
	 *
	 * @access public
	 * @since  1.0.0
	 * @param  string $hook_suffix The current admin page.
	 * @return void
	 */
	public function enqueuer($hook_suffix) {

		// Only load our files on this settings page.
		if ($hook_suffix !== $this->page_hook) {
			return;
		}

		// wp_enqueue_style(
		// 	'my_plugin_style',
		// 	MY_PLUGIN_URL . 'assets/my-plugin.css',
		// 	[],
		// 	MY_PLUGIN_VERSION
		// );

		// wp_enqueue_script(
		// 	'my_plugin_script',
		// 	MY_PLUGIN_URL . 'assets/my-plugin.js',
		// 	[],
		// 	MY_PLUGIN_VERSION,
		// 	['in_footer' => true]
		// );
	}

	/**
	 * Adds options subpage to Settings.
	 * add_options_page() is a shortcut for this exact call.
	 * You can add top-level pages using add_menu_page(). If you do,
	 * call settings_errors() at the top of page_render(). WordPress only
	 * prints save notices automatically for pages under Settings.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function add_plugin_page() {

		$this->page_hook = add_submenu_page(
			// The slug name for the parent menu (or the file name
			// of a standard WordPress admin page)
			'options-general.php',
			// Page Title
			__('Plugin Settings', 'wp-plugin-boilerplate'),
			// Menu Title
			__('Plugin Settings', 'wp-plugin-boilerplate'),
			// Capability needed to access this page
			$this->capability,
			// Menu Slug - Used by WP to identify this page
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
		?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
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
				submit_button(__('Save', 'wp-plugin-boilerplate'));
			?>
			</form>
		</div>
		<?php
	}

	/**
	 * Returns the capability needed to save the settings.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return string
	 */
	public function get_capability() {
		return $this->capability;
	}

	/**
	 * Registers settings.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function register_settings() {

		/**
		 * Registers a setting and its sanitization callback.
		 * Defines the actual option the setting fields will be stored in.
		 * If you rename the option, update uninstall.php to match.
		 */
		register_setting(
			// A name for the options group
			"{$this->prefix}_options_group",
			// A name for your option
			"{$this->prefix}_option",
			[
				'type'              => 'array',
				// Callback function that sanitizes the option's value
				'sanitize_callback' => [$this, 'sanitize'],
				'default'           => [],
				'show_in_rest'      => false,
			]
		);
	}

	/**
	 * Initializes options page, adds sections and fields.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function page_init() {

		/**
		 * Adds a section of settings.
		 * Use as many as you need.
		 */
		add_settings_section(
			// String for use in the 'id' attribute of tags
			'plugin_settings_section_1',
			// Title of the section
			__('Plugin Settings Section 1', 'wp-plugin-boilerplate'),
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
			__('My Setting', 'wp-plugin-boilerplate'),
			// Function that fills the field with the desired inputs
			// as part of the larger form
			[$this, 'my_setting_callback'],
			// The menu page on which to display this field
			$this->prefix,
			// The section of the settings page in which to show the box
			'plugin_settings_section_1',
			// Wraps the field title in a <label for="my_setting">
			['label_for' => 'my_setting']
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
		echo '<p>' . esc_html__('This is description text for the section 1.', 'wp-plugin-boilerplate') . '</p>';
	}

	/**
	 * Prints the setting field.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function my_setting_callback() {
		$options = get_option("{$this->prefix}_option");
		$my_setting = $options['my_setting'] ?? '';

		// Stored data isn't guaranteed to have passed through sanitize().
		if (!is_string($my_setting)) {
			$my_setting = '';
		}
		?>
		<input
			type="text"
			class="large-text"
			id="my_setting"
			name="<?php echo esc_attr("{$this->prefix}_option[my_setting]"); ?>"
			value="<?php echo esc_attr($my_setting); ?>"
			placeholder="<?php esc_attr_e('Enter setting value', 'wp-plugin-boilerplate'); ?>"
		/>
		<p class="description"><?php esc_html_e('A description for the field (optional).', 'wp-plugin-boilerplate'); ?></p>
		<?php
	}
}

// Not wrapped in is_admin(): the setting is registered on every request.
new My_Plugin_Settings_Page();
