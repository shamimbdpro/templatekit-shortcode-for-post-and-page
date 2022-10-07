<?php

/**
 * Class Uta_helpers
 */
class Uta_helpers{

    private static $instance = null;
    public static function get_instance() {
        if ( ! self::$instance )
            self::$instance = new self();
        return self::$instance;
    }

    /**
     * Initialize global hooks.
     */
    public function init(){
        // Add plugin option name in admin top bar.
        add_action('admin_bar_menu', [ $this, 'template_kit_admin_top_bar_option' ], 2000);
    }


    /**
     * Unlimited theme addons admin top bar option.
     * @return void.
     */
    public function template_kit_admin_top_bar_option() {
        global $wp_admin_bar;
        $menu_id = 'templatekit';
        $wp_admin_bar->add_menu(array(
			'id' => $menu_id,
			'title' => __('TemplateKit', 'templatekit-shortcode-for-post-and-page'),
			'href' => admin_url() .'/edit.php?post_type=template_kit',
		));
    }


}

Uta_helpers::get_instance()->init();


