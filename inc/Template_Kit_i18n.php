<?php

class Template_Kit_I18n
{

    /**
     * Initialize Text Domain.
     */
    function __construct(){
        add_action( 'plugins_loaded', [ $this, 'load_plugin_text_domain' ] );
    }


    /**
     * Load text domain.
     * @return void
     */
    public function load_plugin_text_domain() {
        load_plugin_textdomain(
            'templatekit-wp-shortcode',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }
}

new Template_Kit_I18n();
