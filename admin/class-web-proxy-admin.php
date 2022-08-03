<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Web_Proxy
 * @subpackage Web_Proxy/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the tmp mail, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Web_Proxy
 * @subpackage Web_Proxy/admin
 * @author     Your Name <email@example.com>
 */
class Web_Proxy_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $web_proxy    The ID of this plugin.
	 */
	private $web_proxy;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $web_proxy       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($web_proxy, $version)
	{

		$this->web_proxy = $web_proxy;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Web_Proxy_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Web_Proxy_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->web_proxy, plugin_dir_url(__FILE__) . 'css/web-proxy-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Web_Proxy_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Web_Proxy_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->web_proxy, plugin_dir_url(__FILE__) . 'js/web-proxy-admin.js', array('jquery'), $this->version, false);
	}


	function add_menu_pages()
	{
		add_menu_page('Temp Mail Service', 'Temp Mail Service', 'manage_options', 'temp-mail', [$this, 'add_info_page'], '', 50);
		add_submenu_page('temp-mail', 'API Settings', 'Settings', 'manage_options', 'temp-mail-settings', [$this, 'tms_option_page']);
	}

	function tms_option_page()
	{

?>
		<form action='options.php' method='post'>

			<h1>Temp Mail Service</h1>

			<?php
			settings_fields('tms_plugin');
			do_settings_sections('tms_plugin');
			submit_button();
			?>

		</form>
	<?php

	}

	function settings_init()
	{

		register_setting('tms_plugin', 'tms_settings');

		add_settings_section(
			'tms_plugin_section',
			__('Settings', 'web-proxy-service'),
			[$this, 'tms_settings_section_callback'],
			'tms_plugin'
		);

		add_settings_field(
			'tms_api_domain_field',
			__('API Domain', 'web-proxy-service'),
			[$this, 'tms_api_domain_field_render'],
			'tms_plugin',
			'tms_plugin_section'
		);
	}

	function tms_api_domain_field_render()
	{

		$options = get_option('tms_settings');
	?>
		<input type='text' name='tms_settings[tms_api_domain_field]' placeholder="example.com" value='<?= isset($options['tms_api_domain_field'])? $options['tms_api_domain_field'] : ''; ?>'>
	<?php

	}
	function tms_settings_section_callback()
	{

		echo __('', 'web-proxy-service');
	}


	function add_info_page()
	{
	?>
		<div class="wrap">
			<h2><?php echo get_admin_page_title() ?></h2>
			<h3><?= __('Shortcodes', 'web-proxy-service') ?>:</h3>
			<p><strong>[web_proxy]</strong> - <?= __('Add this shortcode to any page to show temporary mail interface.', 'web-proxy-service') ?></p>
		</div>
<?php

	}
}
