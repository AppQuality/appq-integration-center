<?php


/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bitbucket.org/appqdevel/appq-integration-center
 * @since             1.0.0
 * @package           AppQ_Integration_Center
 *
 * @wordpress-plugin
 * Plugin Name:       Integration Center
 * Plugin URI:        https://bitbucket.org/appqdevel/appq-integration-center
 * Description:       Integrate AppQuality Campaigns with most used BugTracking services
 * Version:           1.0.0
 * Author:            Davide Bizzi
 * Author URI:        https://bitbucket.org/%7B1c7dab51-4872-4f3e-96ac-11f21c44fd4b%7D/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       appq-integration-center
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('APPQ_INTEGRATION_CENTERVERSION', '1.1.0');

/**
 * Currently plugin url.
 */
define('APPQ_INTEGRATION_CENTERURL', plugin_dir_url( __FILE__ ));
define('APPQ_INTEGRATION_CENTER_PATH', plugin_dir_path( __FILE__ ));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-appq-integration-center-activator.php
 */
function activate_appq_integration_center()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-appq-integration-center-activator.php';
	AppQ_Integration_Center_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-appq-integration-center-deactivator.php
 */
function deactivate_appq_integration_center()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-appq-integration-center-deactivator.php';
	AppQ_Integration_Center_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_appq_integration_center');
register_deactivation_hook(__FILE__, 'deactivate_appq_integration_center');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-appq-integration-center.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_appq_integration_center()
{
	$plugin = new AppQ_Integration_Center();
	$plugin->run();
}
run_appq_integration_center();
do_action('appq_integration_center_run');
