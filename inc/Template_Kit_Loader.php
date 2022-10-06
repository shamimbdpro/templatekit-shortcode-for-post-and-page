<?php

/**
 * Class Template_Kit_Loader
 */
class Template_Kit_Shortcode_Loader{
    // Autoload dependency.
    public function __construct(){
        $this->load_dependency();
    }

    /**
     * Load all Plugin File.
     */
    public function load_dependency(){
        include_once(dirname( __FILE__ ). '/Template_Kit_i18n.php');
        include_once(dirname( __FILE__ ). '/Template_Kit_Helpers.php');
        include_once(dirname( __FILE__ ). '/Template_Kit_Admin.php');
    }
}

/**
 * Initialize load class .
 */
function template_kit_wp_shortcode_run(){
    if ( class_exists( 'Template_Kit_Shortcode_Loader' ) ) {
        new Template_Kit_Shortcode_Loader();
    }
}

