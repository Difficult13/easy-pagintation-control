<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Easy_Pagination_Control
 * @subpackage Easy_Pagination_Control/includes
 * @author     Ivan Barinov <vanbrin@ya.ru>
 */
class Easy_Pagination_Control_Activator {

	/**
	 * Set default options
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        add_option('epc_options', []);
	}

}
