<?php

namespace Difficult13\EasyPaginationControl\Includes;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Easy_Pagination_Control
 * @subpackage Easy_Pagination_Control/includes
 * @author     Ivan Barinov <vanbrin@ya.ru>
 */
class EasyPaginationControlI18n {


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'easy-pagination-control',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }



}
