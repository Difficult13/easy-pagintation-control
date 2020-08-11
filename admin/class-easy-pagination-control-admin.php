<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Easy Pagination Control
 * @subpackage Easy Pagination Control/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy Pagination Control
 * @subpackage Easy Pagination Control/admin
 * @author     Ivan Barinov <vanbrin@ya.ru>
 */
class Easy_Pagination_Control_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
     * The option's name of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $option_name    The current version of this plugin.
     */
    private $option_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->option_name = 'epc_options';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-pagination-control-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easy-pagination-control-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Register View for the admin area.
     *
     * @since    1.0.0
     */
    public function add_control_page() {

        add_submenu_page( 'tools.php', 'Easy Pagination Control', 'Easy Pagination Control', 'manage_options', 'easy-pagination-control', array($this, 'get_view_control_page') );

    }

    /**
     * Callback View for the admin area.
     *
     * @since    1.0.0
     */
    public function get_view_control_page() {

        $data = $this->get_formatted_types_array($this->get_post_types(), $this->get_taxonomies(), $this->get_current_options());

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/easy-pagination-control-admin-display.php';

    }

    /**
     * Get Taxonomies
     *
     * @since    1.0.0
     * @return    array    The array with Taxonomies
     */
    private function get_taxonomies() {
        $args = [
            'public' => true,
            '_builtin' => false
        ];
        return get_taxonomies( $args, 'objects' );

    }

    /**
     * Get Post Types
     *
     * @since    1.0.0
     * @return    array    The array with Post Types
     */
    private function get_post_types() {
        $args = [
            'public' => true,
            '_builtin' => false
        ];
        return get_post_types( $args, 'objects' );

    }

    /**
     * Get Current options
     *
     * @since    1.0.0
     * @return    array    The array with current options
     */
    private function get_current_options() {
        return get_option($this->option_name);

    }

    /**
     * Update Current Options
     *
     * @since    1.0.0
     */
    public function update_current_options() {

        if (isset($_POST['result']) && !empty($_POST['result'])){
            $result = [
                'builtin' => [],
                'taxonomies' => [],
                'post_types' => [],
            ];

            foreach ($_POST['result'] as $section_name => $section){
                if (isset($result[$section_name])){
                    foreach ($section as $entity_name => $entity_count){
                        $result[$section_name]['entities'][esc_sql($entity_name)] = esc_sql($entity_count);
                    }
                }

            }
            update_option($this->option_name, $result);
            echo '1';
        }
        die();
    }

    /**
     * Get Post Types
     *
     * @since    1.0.0
     * @return    array    The formatted array for template
     */
    private function get_formatted_types_array($post_types = [], $taxonomies = [], $current_options = []) {

        $main_options_title = __('Встроенные типы', 'easy-pagination-control');
        $front_page_title = __('Главная страница', 'easy-pagination-control');
        $home_title = __('Страница с последними записями', 'easy-pagination-control');
        $category_title = __('Страница категорий', 'easy-pagination-control');
        $tag_title = __('Страница меток', 'easy-pagination-control');

        $archive_title = __('Пользовательские типы записей', 'easy-pagination-control');
        $tax_title = __('Пользовательские таксономии', 'easy-pagination-control');


        $default_template = [
            'builtin' => [
                'type_name' => $main_options_title,
                'entities' => [
                    'builtin1' => [
                        'name' => $front_page_title,
                        'count' => 0
                    ],
                    'builtin2' =>[
                        'name' => $home_title,
                        'count' => 0
                    ],
                    'builtin3' => [
                        'name' => $category_title,
                        'count' => 0
                    ],
                    'builtin4' => [
                        'name' => $tag_title,
                        'count' => 0
                    ],
                ]
            ],
            'taxonomies' => [
                'type_name' => $tax_title,
                'entities' => []
            ],
            'post_types' => [
                'type_name' => $archive_title,
                'entities' => []
            ],
        ];

        $result = $default_template;

        foreach ($taxonomies as $tax){
            $result['taxonomies']['entities'][$tax->name] = [
                'name' => $tax->label,
                'count' => 0
            ];
        }

        foreach ($post_types as $post_type){
            $result['post_types']['entities'][$post_type->name] = [
                'name' => $post_type->label,
                'count' => 0
            ];
        }

        if (!empty($current_options)){
            foreach ($current_options as $section_name => $section){
                foreach ($section['entities'] as $entity_slug => $entity_count){
                    if (isset($result[$section_name]['entities'][$entity_slug])){
                        $result[$section_name]['entities'][$entity_slug]['count'] = $entity_count;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * Control pagination with pre_get_posts hook
     *
     * @since    1.0.0
     */
    public function control_pagination($query) {
        if (!empty($options = $this->get_current_options())){
            if ( !is_admin() && $query->is_main_query() ) {

                if ($query->is_front_page()){
                    if (isset($options['builtin']['entities']['builtin1']) && (int)$options['builtin']['entities']['builtin1'] !== 0 ){
                        $query->set( 'posts_per_page', (int)$options['builtin']['entities']['builtin1'] );
                    }
                }

                if ($query->is_home() && !$query->is_front_page()){
                    if (isset($options['builtin']['entities']['builtin2']) && (int)$options['builtin']['entities']['builtin2'] !== 0 ){
                        $query->set( 'posts_per_page', (int)$options['builtin']['entities']['builtin2'] );
                    }
                }

                if ($query->is_category()){
                    if (isset($options['builtin']['entities']['builtin3']) && (int)$options['builtin']['entities']['builtin3'] !== 0 ){
                        $query->set( 'posts_per_page', (int)$options['builtin']['entities']['builtin3'] );
                    }
                }

                if ($query->is_tag()){
                    if (isset($options['builtin']['entities']['builtin4']) && (int)$options['builtin']['entities']['builtin4'] !== 0 ){
                        $query->set( 'posts_per_page', (int)$options['builtin']['entities']['builtin4'] );
                    }
                }

                if ($query->is_tax()){
                    if (isset($options['taxonomies']['entities'][key($query->query_vars)]) && (int)$options['taxonomies']['entities'][key($query->query_vars)] !== 0 ){
                        $query->set( 'posts_per_page', (int)$options['taxonomies']['entities'][key($query->query_vars)] );
                    }
                }

                if ($query->is_archive() && !$query->is_category() && !$query->is_tag() && !$query->is_tax()){
                    if (isset($options['post_types']['entities'][$query->query_vars['post_type']]) && (int)$options['post_types']['entities'][$query->query_vars['post_type']] !== 0 ){
                        $query->set( 'posts_per_page', (int)$options['post_types']['entities'][$query->query_vars['post_type']] );
                    }
                }
            }
        }
    }
}