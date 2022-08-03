<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Web_Proxy
 * @subpackage Web_Proxy/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the tmp mail, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Web_Proxy
 * @subpackage Web_Proxy/public
 * @author     Your Name <email@example.com>
 */
class Web_Proxy_Public
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
	 * @param      string    $web_proxy       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($web_proxy, $version)
	{

		$this->web_proxy = $web_proxy;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function register_styles()
	{
	}

	/**
	 * Enqueue the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{;
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function register_scripts()
	{
	}

	/**
	 * Enqueue the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
	}

	/**
	 * Inline script for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function inline_scripts()
	{
	}
}
