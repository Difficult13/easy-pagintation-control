<?php

namespace Difficult13\EasyPaginationControl\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy_Pagination_Control
 * @subpackage Easy_Pagination_Control/admin
 * @author     Ivan Barinov <vanbrin@ya.ru>
 */
class EasyPaginationControlAdmin {

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
     * The default settings of plugin
     *
     * @since    1.1.0
     * @access   private
     * @var      array
     */
	private $default_settings;


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

        $this->default_settings = [
            'plugin-title' => __('Easy Pagination Control', 'easy-pagination-control'),
		    'sections' => [
                'builtin'  => __('Built-in types', 'easy-pagination-control'),
                'taxonomies' => __('Taxonomies', 'easy-pagination-control'),
                'post_types' => __('Post types', 'easy-pagination-control')
            ],
            'builtin' => [
                'front-page' => __('Front Page', 'easy-pagination-control'),
                'home' => __('Home', 'easy-pagination-control'),
                'categories' => __('Categories', 'easy-pagination-control'),
                'tags' => __('Tags', 'easy-pagination-control'),
                'search' => __('Search Page', 'easy-pagination-control'),
            ]
        ];
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
        return get_option('epc_options');

    }

    /**
     * Get posts per page for current page type
     *
     * @since    1.0.5
     *
     * @param $query
     * @param $options
     * @return integer
     */
    private function get_posts_per_page( $query, $options ) {

        if ($this->is_front_page($query)){
            if (isset($options['builtin']['front-page'])){
                return (int)$options['builtin']['front-page'];
            }
        }

        if ($query->is_home() && !$this->is_front_page($query)){
            if (isset($options['builtin']['home'])){
                return (int)$options['builtin']['home'];
            }
        }

        if ($query->is_category()){
            if (isset($options['builtin']['categories'])){
                return (int)$options['builtin']['categories'];
            }
        }

        if ($query->is_tag()){
            if (isset($options['builtin']['tags'])){
                return (int)$options['builtin']['tags'];
            }
        }

        if ($query->is_search()){
            if (isset($options['builtin']['search'])){
                return (int)$options['builtin']['search'];
            }
        }

        if ($query->is_tax()){
            if ( !empty($query->tax_query) && isset($options['taxonomies'][key($query->tax_query->queried_terms)])){
                return (int)$options['taxonomies'][key($query->tax_query->queried_terms)];
            }
        }

        if ($query->is_post_type_archive()){
            if (isset($options['post_types'][$query->query_vars['post_type']])){
                return (int)$options['post_types'][$query->query_vars['post_type']];
            }
        }

        return 0;
    }

    /**
     * Check front page with fix
     *
     * @since    1.1.1
     *
     * @param $query
     * @return boolean
     */
    private function is_front_page( $query ) {
        if ( 'posts' === get_option( 'show_on_front' ) && $query->is_home() ) {
            return true;
        } elseif ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' )
            && $query->get( 'page_id' ) === get_option( 'page_on_front' )
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Register plugin's options
     *
     * @since    1.1.0
     */
    public function register_options() {
        register_setting( 'reading', 'epc_options', [
            'sanitize_callback' => [$this, 'sanitize_options']
        ]);

        $current_options = $this->get_current_options();

        add_settings_section(
            'epc_options_title_section',
            esc_html($this->default_settings['plugin-title']),
            [$this, 'display_title_section'],
            'reading'
        );

        add_settings_section(
            'epc_options_builtin_section',
            esc_html($this->default_settings['sections']['builtin']),
            '',
            'reading'
        );

        foreach ($this->default_settings['builtin'] as $entitySlug => $entityName){
            add_settings_field('epc_option_' . $entitySlug, $entityName, [$this, 'display_input_field'], 'reading', 'epc_options_builtin_section', [
                'id' => 'epc_option_' . $entitySlug,
                'name' => 'epc_options[builtin][' . $entitySlug . ']',
                'value' => !isset( $current_options['builtin'][$entitySlug] ) ? 0 : absint($current_options['builtin'][$entitySlug]),
                'label_for' => 'epc_option_' . $entitySlug
            ]);
        }

        $taxonomies = $this->get_taxonomies();
        if (!empty($taxonomies)){
            add_settings_section(
                'epc_options_tax_section',
                $this->default_settings['sections']['taxonomies'],
                '',
                'reading'
            );
            foreach ($taxonomies as $taxonomy){
                add_settings_field('epc_option_' . $taxonomy->name, $taxonomy->label . "<br>({$taxonomy->name})", [$this, 'display_input_field'], 'reading', 'epc_options_tax_section', [
                    'id' => 'epc_option_' . $taxonomy->name,
                    'name' => 'epc_options[taxonomies][' . $taxonomy->name . ']',
                    'value' => !isset( $current_options['taxonomies'][$taxonomy->name] ) ? 0 : absint($current_options['taxonomies'][$taxonomy->name]),
                    'label_for' => 'epc_option_' . $taxonomy->name
                ]);
            }
        }

        $post_types = $this->get_post_types();
        if (!empty($post_types)){
            add_settings_section(
                'epc_options_post_types_section',
                $this->default_settings['sections']['post_types'],
                '',
                'reading'
            );
            foreach ($post_types as $posttype){
                add_settings_field('epc_option_' . $posttype->name, $posttype->label, [$this, 'display_input_field'], 'reading', 'epc_options_post_types_section', [
                    'id' => 'epc_option_' . $posttype->name,
                    'name' => 'epc_options[post_types][' . $posttype->name . ']',
                    'value' => !isset( $current_options['post_types'][$posttype->name] ) ? 0 : absint($current_options['post_types'][$posttype->name]),
                    'label_for' => 'epc_option_' . $posttype->name
                ]);
            }
        }
    }

    /**
     * Sanitize callback for options
     *
     * @since    1.1.0
     */
    public function sanitize_options( $options ) {
        foreach ($options as &$entity){
            foreach ($entity as &$count){
                $count = absint($count);
            }
            unset($count);
        }
        unset($entity);
        return $options;
    }

    /**
     * Sanitize callback for customizer
     *
     * @since    1.1.0
     */
    public function sanitize_customizer( $setting ) {
        $setting = absint($setting);
        return $setting;
    }

    /**
     * Display input field
     *
     * @since    1.1.0
     */
    public function display_input_field( $args ) {
        require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/easy-pagination-control-admin-display-input-field.php';
    }

    /**
     * Display title section
     *
     * @since    1.1.0
     */
    public function display_title_section() {
        require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/easy-pagination-control-admin-display-title-section.php';
    }

    /**
     * Control pagination with pre_get_posts hook
     *
     * @since    1.0.0
     */
    public function control_pagination($query) {
        if ( !empty($options = $this->get_current_options()) && !is_admin() && $query->is_main_query() ) {
            $post_per_page = $this->get_posts_per_page($query, $options);
            if (!empty($post_per_page)){
                $query->set( 'posts_per_page', $post_per_page );
            }
        }
    }

    /**
     * Allows you to give the correct number of elements on the page when using get_option('posts_per_page')
     *
     * @since    1.0.5
     */
    public function posts_per_page_interception( $value ) {
        global $wp_query;
        if ( !empty($options = $this->get_current_options()) && !is_admin() && !empty($wp_query->query_vars) ) {
            $post_per_page = $this->get_posts_per_page($wp_query, $options);
            if (!empty($post_per_page)){
                return $post_per_page;
            }
        }
        return $value;
    }

    /**
     * Register Customizer options
     *
     * @since    1.1.0
     */
    public function register_customizer_options( \WP_Customize_Manager $wp_customize ) {

        $wp_customize->add_panel('epc-customizer-panel', [
            'title' => esc_html__('Easy Pagination Control', 'easy-pagination-control'),
            'priority' => 250,
        ]);

        $wp_customize->add_section('epc-customizer-builtin', [
            'title' => $this->default_settings['sections']['builtin'],
            'priority' => 1,
            'panel' => 'epc-customizer-panel'
        ]);

        $current_options = $this->get_current_options();

        foreach ($this->default_settings['builtin'] as $entitySlug => $entityName){
            $wp_customize->add_setting( 'epc_options[builtin][' . $entitySlug . ']', array(
                'type'                 => 'option',
                'default'              => 0,
                'sanitize_callback'    => [$this, 'sanitize_customizer'],
            ) );

            $wp_customize->add_control( 'epc_options[builtin][' . $entitySlug . ']', [
                'section'   => 'epc-customizer-builtin',
                'label'     => $entityName,
                'type'      => 'number'
            ]);
        }

        $taxonomies = $this->get_taxonomies();
        if (!empty($taxonomies)){

            $wp_customize->add_section('epc-customizer-taxonomies', [
                'title' => $this->default_settings['sections']['taxonomies'],
                'priority' => 2,
                'panel' => 'epc-customizer-panel'
            ]);

            foreach ($taxonomies as $taxonomy){
                $wp_customize->add_setting( 'epc_options[taxonomies][' . $taxonomy->name . ']', array(
                    'type'                 => 'option',
                    'default'              => 0,
                    'sanitize_callback'    => [$this, 'sanitize_customizer'],
                ) );

                $wp_customize->add_control( 'epc_options[taxonomies][' . $taxonomy->name . ']', [
                    'section'   => 'epc-customizer-taxonomies',
                    'label'     => $taxonomy->label,
                    'type'      => 'number'
                ]);
            }
        }

        $post_types = $this->get_post_types();
        if (!empty($post_types)){

            $wp_customize->add_section('epc-customizer-post_types', [
                'title' => $this->default_settings['sections']['post_types'],
                'priority' => 3,
                'panel' => 'epc-customizer-panel'
            ]);

            foreach ($post_types as $post_type){

                $wp_customize->add_setting( 'epc_options[post_types][' . $post_type->name . ']', array(
                    'type'                 => 'option',
                    'default'              => 0,
                    'sanitize_callback'    => [$this, 'sanitize_customizer'],
                ) );

                $wp_customize->add_control( 'epc_options[post_types][' . $post_type->name . ']', [
                    'section'   => 'epc-customizer-post_types',
                    'label'     => $post_type->label,
                    'type'      => 'number'
                ]);
            }
        }



    }

    /**
     * Add settings link under title
     *
     * @since     1.0.0
     */
    public function add_settings_link( $links ) {

        $settings = array(
            '<a target="_blank" href="' . esc_url(admin_url( '/options-reading.php' )) . '">'.esc_html__('Settings', 'easy-pagination-control').'</a>'
        );
        return array_merge( $links, $settings );
    }


    /**
     * Get posts_per_page for any entity
     *
     * @since     1.1.2
     */
    public static function get_posts_per_page_for_entity( $entity ) {

        $allowed_builtin = [
            'front-page',
            'home',
            'categories',
            'tags',
            'search'
        ];

        $args = [
            'public' => true,
            '_builtin' => false
        ];
        $allowed_taxonomies = get_taxonomies( $args, 'objects' );

        $args = [
            'public' => true,
            '_builtin' => false
        ];
        $allowed_post_types = get_post_types( $args, 'objects' );


        if (
            !in_array($entity, $allowed_builtin)
            &&
            !key_exists($entity, $allowed_post_types)
            &&
            !key_exists($entity, $allowed_taxonomies)
        ) return false;

        $current_options = get_option('epc_options');

        if (empty($current_options)) return false;



        foreach ( $current_options as $section){
            foreach ($section as $section_entity => $posts_per_page){

                if ($section_entity === $entity){
                    if ($posts_per_page == 0){
                        return (int) get_option('posts_per_page');
                    }else {
                        return (int) $posts_per_page;
                    }
                }
            }
        }

        return (int) get_option('posts_per_page');
    }
}