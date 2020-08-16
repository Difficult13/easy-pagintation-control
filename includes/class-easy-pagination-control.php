<?php

namespace Difficult13\EasyPaginationControl\Includes;

use Difficult13\EasyPaginationControl\Includes\EasyPaginationControlLoader;
use Difficult13\EasyPaginationControl\Includes\EasyPaginationControlI18n;
use Difficult13\EasyPaginationControl\Admin\EasyPaginationControlAdmin;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Easy_Pagination_Control
 * @subpackage Easy_Pagination_Control/includes
 * @author     Ivan Barinov <vanbrin@ya.ru>
 */
class EasyPaginationControl {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      EasyPaginationControlLoader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

    /**
     * The basename of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $basename    The basename of the plugin.
     */
    protected $basename;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($basename) {
		if ( defined( 'EPC_VERSION' ) ) {
			$this->version = EPC_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'easy-pagination-control';
        $this->basename = $basename;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - EasyPagination_ControlLoader. Orchestrates the hooks of the plugin.
	 * - EasyPagination_ControlI18n. Defines internationalization functionality.
	 * - EasyPaginationControlAdmin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-easy-pagination-control-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-easy-pagination-control-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-easy-pagination-control-admin.php';


		$this->loader = new EasyPaginationControlLoader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Easy_Pagination_Control_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new EasyPaginationControlI18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new EasyPaginationControlAdmin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_filter( 'plugin_action_links_'.$this->basename, $this, 'add_settings_link' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_control_page' );
        $this->loader->add_action( 'wp_ajax_epc_post', $plugin_admin, 'update_current_options' );

        $this->loader->add_action( 'pre_get_posts', $plugin_admin, 'control_pagination' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    EasyPaginationControlLoader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

    /**
     * Add settings link under title
     *
     * @since     1.0.0
     */
    public function add_settings_link( $links ) {
        $settings = array(
            '<a target="_blank" href="/wp-admin/tools.php?page=easy-pagination-control">'.esc_html__('Settings', 'easy-pagination-control').'</a>'
        );
        return array_merge( $links, $settings );
    }

}
