<?php

namespace Difficult13\EasyPaginationControl\Includes;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.1.0
 * @package    Easy_Pagination_Control
 * @subpackage Easy_Pagination_Control/includes
 * @author     Ivan Barinov <vanbrin@ya.ru>
 */
class EasyPaginationControlDeactivator {

	public static function deactivate() {
        unregister_setting('reading', 'epc_options');
	}

}
