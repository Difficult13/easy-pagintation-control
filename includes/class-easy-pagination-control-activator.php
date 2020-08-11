<?php

namespace Difficult13\EasyPaginationControl\Includes;

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
class EasyPaginationControlActivator {

	/**
	 * Set default options
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        add_option('epc_options', []);
	}

}
