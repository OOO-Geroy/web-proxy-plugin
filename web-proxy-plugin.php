<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/OOO-Geroy/web-proxy-plugin
 * @since             1.0.0
 * @package           web-proxy
 *
 * Plugin Name:       Web Proxy Configuration
 * Plugin URI:        https://github.com/OOO-Geroy/web-proxy-plugin
 * Description:       The plugin provides an interface for managing a web proxy https://webproxy.vpntester.net/
 * Version:           1.0.0
 * Author:            Evgeny Tsvigun
 * Author URI:        https://github.com/Delave-las-Kure
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       web-proxy
 * Domain Path:       /languages/
 * Requires PHP: 5.3.6
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WEB_PROXY_VERSION', '1.0.0');

/**
 * Plugin folder path
 */
define('WEB_PROXY_FOLDER',  plugin_dir_path(__FILE__));
define('WEB_PROXY_URL', plugin_dir_url(__FILE__));
define('WEB_PROXY_API_NAMESPACE', 'webproxy/v1');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-web-proxy-activator.php
 */
function activate_web_proxy()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-web-proxy-activator.php';
	Web_Proxy_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-web-proxy-deactivator.php
 */
function deactivate_web_proxy()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-web-proxy-deactivator.php';
	Web_Proxy_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_web_proxy');
register_deactivation_hook(__FILE__, 'deactivate_web_proxy');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-web-proxy.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_web_proxy()
{

	$plugin = new Web_Proxy();
	$plugin->run();
}
run_web_proxy();
