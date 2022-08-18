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

		//wp_enqueue_style($this->web_proxy, plugin_dir_url(__FILE__) . 'css/web-proxy-admin.css', array(), $this->version, 'all');
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

		//wp_enqueue_script($this->web_proxy, plugin_dir_url(__FILE__) . 'js/web-proxy-admin.js', array('jquery'), $this->version, false);
	}


	function add_menu_pages()
	{
		add_menu_page('Web Proxy Settings', 'Web Proxy', 'manage_options', 'web-proxy-plugin', '', 'dashicons-admin-site-alt3', 50);
	}

	function add_acf_opt_page()
	{
		if (function_exists('acf_add_options_page')) {

			// Register options page.
			$option_page = acf_add_options_page(array(
				'page_title'    => __('Web Proxy Options'),
				'menu_title'    => __('Options'),
				'menu_slug'     => 'web-proxy-plugin-options',
				'capability'    => 'edit_posts',
				'redirect'      => false,
				'parent_slug'   => 'web-proxy-plugin'
			));
		}
	}
}
