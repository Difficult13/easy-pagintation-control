<?php

/**
 * The plugin bootstrap file
 *
 * @link
 * @since             1.0.0
 * @package           Easy Pagination Control
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Pagination Control
 * Plugin URI:
 * Description:       A lightweight and easy-to-configure plugin for quickly configuring the number of objects on the archives, categories, tags, taxonomies, home, and front page
 * Version:           1.0.0
 * Author:            Ivan Barinov
 * Author URI:
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       easy-pagination-control
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EPC_VERSION', '1.0.0' );

function activate_easy_pagination_control() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-easy-pagination-control-activator.php';
    Easy_Pagination_Control_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_easy_pagination_control' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-easy-pagination-control.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {
    $basename = plugin_basename(__FILE__);
	$plugin = new Easy_Pagination_Control($basename);
	$plugin->run();

}
run_plugin_name();
