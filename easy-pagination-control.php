<?php

namespace Difficult13\EasyPaginationControl;

use Difficult13\EasyPaginationControl\Includes\EasyPaginationControl;
use Difficult13\EasyPaginationControl\Includes\EasyPaginationControlActivator;


/**
 * The plugin bootstrap file
 *
 * @link
 * @since             1.0.0
 * @package           Easy_Pagination_Control
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Pagination Control
 * Plugin URI:        https://github.com/Difficult13/easy-pagintation-control
 * Description:       Легкий и простой в настройке плагин для быстрой настройки количества объектов в архивах, категориях, тегах, таксономиях, страницах записей и главной странице
 * Version:           1.0.1
 * Author:            Ivan Barinov
 * Author URI:        https://github.com/Difficult13
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       easy-pagination-control
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

esc_html__('Легкий и простой в настройке плагин для быстрой настройки количества объектов в архивах, категориях, тегах, таксономиях, страницах записей и главной странице', 'easy-pagination-control');

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EPC_VERSION', '1.0.1' );

function activatePlugin() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-easy-pagination-control-activator.php';
    EasyPaginationControlActivator::activate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\\activatePlugin' );

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
function runPlugin() {
    $basename = plugin_basename(__FILE__);
	$plugin = new EasyPaginationControl($basename);
	$plugin->run();
}
runPlugin();
