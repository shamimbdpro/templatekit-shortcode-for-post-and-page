<?php
use Elementor\Plugin;

/**
 * Class TemplateKit Shortcode
 */
class Template_Kit_Admin
{

    /**
     * @var null
     */
    private static $instance = null;

    /**
     * @return Template_Kit_Admin|null
     */
    public static function get_instance() {
        if ( ! self::$instance)
            self::$instance = new self();
        return self::$instance;
    }

    /**
     * Initialize global hooks.
     */
    public function init() {

        add_action('init', array( $this, 'template_kit_shortcode_create_post_type' ));
        add_action('elementor/init', [ $this, 'template_kit_add_elementor_support' ]);

        add_action("init", [ $this, 'template_kit_shortcode_render' ]);

        add_action("add_meta_boxes", [ $this, 'template_kit_add_meta_boxes' ]);


       // echo "<pre>"; print_r(get_post_types()); exit();

    }



    /**
     * Register Custom Post
     * 
     * Register post type for template shortcode which allow to get shortcode each created item.
     *
     * @return void
     */
    public function template_kit_shortcode_create_post_type() {

        $labels = array(
            'name'                  => _x('Template Kit', 'Post Type General Name', 'templatekit-shortcode-for-post-and-page'),
            'singular_name'         => _x('Template Kit', 'Post Type Singular Name', 'templatekit-shortcode-for-post-and-page'),
            'menu_name'             => __('Template Kit', 'templatekit-shortcode-for-post-and-page'),
            'name_admin_bar'        => __('Template Kit', 'templatekit-shortcode-for-post-and-page'),
            'archives'              => __('List Archives', 'templatekit-shortcode-for-post-and-page'),
            'parent_item_colon'     => __('Parent List:', 'templatekit-shortcode-for-post-and-page'),
            'all_items'             => __('All Templates', 'templatekit-shortcode-for-post-and-page'),
            'add_new_item'          => __('Add New Template', 'templatekit-shortcode-for-post-and-page'),
            'add_new'               => __('Add New', 'templatekit-shortcode-for-post-and-page'),
            'new_item'              => __('New Template', 'templatekit-shortcode-for-post-and-page'),
            'edit_item'             => __('Edit Template', 'templatekit-shortcode-for-post-and-page'),
            'update_item'           => __('Update Template', 'templatekit-shortcode-for-post-and-page'),
            'view_item'             => __('View Template', 'templatekit-shortcode-for-post-and-page'),
            'search_items'          => __('Search Template', 'templatekit-shortcode-for-post-and-page'),
            'not_found'             => __('Not found', 'templatekit-shortcode-for-post-and-page'),
            'not_found_in_trash'    => __('Not found in Trash', 'templatekit-shortcode-for-post-and-page'),
        );

        $args = array(
            'label'                 => __('Post List', 'templatekit-shortcode-for-post-and-page'),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'public'                => true,
            'rewrite'               => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_nav_menus'     => false,
            'exclude_from_search'   => true,
            'capability_type'       => 'post',
            'hierarchical'          => false,
            'menu-icon'             => 'dashicons-layout',
        );

        register_post_type('template_kit', $args);
    }



    public function template_kit_shortcode_render(){

        $post_types_objects = get_post_types(
            [
                'public' => true,
            ], 'objects'
        );

        foreach ( $post_types_objects as $name ) {

            if ( 'template_kit' === $name->name || 'post' === $name->name || 'page' === $name->name || 'elementor_library' === $name->name ) {

                if ( 'template_kit' !== $name->name ) {
                    add_shortcode('template_kit_' . $name->name, [ $this, 'template_kit_render_shortcode' ]);
                } else {
                    add_shortcode($name->name, [ $this, 'template_kit_render_shortcode' ]);
                }

                add_filter('manage_' . $name->name . '_posts_columns', array( $this, 'template_kit_shortcode_column_title' ));
                add_action('manage_' . $name->name . '_posts_custom_column', array( $this, 'template_kit_shortcode_column_content' ), 10, 2);

            }
        }

    }


    /**
     * Add elementor support.
     * 
     * Add elementor support for template post type.
     *
     * @return void
     */
    public function template_kit_add_elementor_support() {

        add_post_type_support('template_kit', 'elementor');
    }


    /**
     * Custom post type column.
     *
     * Add column in custom post type.
     *
     * @param string $defaults
     * @return void
     */
    public  function template_kit_shortcode_column_title( $defaults ) {
        $defaults['template-kit-shortcode']  = 'Shortcode';
        return $defaults;
    }

    /**
     * Custom column content
     *
     * Add content for cusotm column in shortcode.
     *
     * @param string $column_name
     * @param int $post_ID
     * @return void
     */
    public function template_kit_shortcode_column_content( $column_name, $post_ID ) {

        $post_type = get_post_type();
        if ( 'template-kit-shortcode' == $column_name ) {
            if ( 'template_kit' !== $post_type ) {
                echo esc_html('[template_kit_'.$post_type.' id="' . $post_ID . '"]');
            }else {
                echo esc_html('['.$post_type.' id="' . $post_ID . '"]');
            }
        }

    }



    /**
     * Render shortcode content
     *
     * Get page content by applying shortcode.
     *
     * @param [type] $atts
     * @return void
     */
    public function template_kit_render_shortcode( $atts ) {

        // Enable support for WPML & Polylang
        $language_support = apply_filters('template_kit_multilingual_support', false);

        if ( empty($atts['id']) ) {
            return;
        }

        $post_id = $atts['id'];


        if ( $language_support ) {
            $post_id = apply_filters('wpml_object_id', $post_id, 'template_kit_multilingual_support');
        }

        $response = null;

        if ( class_exists('Elementor\Plugin') && Plugin::$instance->documents->get($post_id)->is_built_with_elementor() ) {

            $response = Plugin::instance()->frontend->get_builder_content_for_display($post_id);

        } else {

            $post = get_post($post_id); // specific post
            $the_content = apply_filters('the_content', $post->post_content);

            if ( ! empty($the_content) ) {
                $response = $the_content;
            }
}

        return $response;

    }


    /**
     * Add shortcode box inside the page.
     * 
     * Shortcode for inside the page so that user can get PHP or normal shortcode.
     *
     * @return void
     */
    public function template_kit_add_meta_boxes(){
        add_meta_box(
            'template-kit-shortcode-box',
            'TemplateKit Shortcode',
            [ $this, 'template_kit_add_meta_boxes_content' ],
            'template_kit',
            'side',
            'high'
        );
    }


    /**
     * Shortcode box content
     * 
     * Add content for shortcode box inside the custom post type pages.
     *
     * @param object $post
     * @return void
     */
    function template_kit_add_meta_boxes_content( $post ) {  ?>
        <h4 style="margin-bottom:5px;">Shortcode</h4>
        <input type='text' class='widefat' value='[template_kit id="<?php echo esc_attr($post->ID); ?>"]' readonly="">
    
        <h4 style="margin-bottom:5px;">PHP Code</h4>
        <input type='text' class='widefat' value="&lt;?php echo do_shortcode('[template_kit id=&quot;<?php echo esc_attr($post->ID); ?>&quot;]'); ?&gt;" readonly="">
        <?php
    }


}

Template_Kit_Admin::get_instance()->init();
