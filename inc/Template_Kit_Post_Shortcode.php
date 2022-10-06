<?php
use Elementor\Plugin;

class Template_Kit_Post_Shortcode{

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

        add_action('manage_post_posts_columns', array( $this, 'template_kit_shortcode_post_column_title' ));
        add_action('manage_post_posts_custom_column', array( $this, 'template_kit_shortcode_post_column_content' ), 10, 2);
        add_shortcode("template-kit-post", [ $this, 'template_kit_post_render_shortcode' ]);
    }



    /**
     * Shortcode Column added for post.
     *
     * Add column in page post type.
     *
     * @param string $defaults
     * @return void
     */
    public  function template_kit_shortcode_post_column_title( $defaults ) {
        $defaults['template-kit-post-shortcode']  = 'Shortcode';
        return $defaults;
    }


    /**
     * Post shortcode column content
     *
     * Add content for post column in shortcode.
     *
     * @param string $column_name
     * @param int $post_ID
     * @return void
     */
    public function template_kit_shortcode_post_column_content( $column_name, $post_ID ) {

        if ( 'template-kit-post-shortcode' == $column_name ) {
            echo esc_html('[template-kit-post id="' . $post_ID . '"]');
        }
    }



    /**
     * Render Post shortcode content
     *
     * Get page content by applying shortcode.
     *
     * @param [type] $atts
     * @return void
     */
    public function template_kit_post_render_shortcode( $atts ) {

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


}

Template_Kit_Post_Shortcode::get_instance()->init();


?>