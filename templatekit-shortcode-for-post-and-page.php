<?php
/**
* Plugin Name: Templatekit Shortcode For Post And Page
* Plugin URI: https://codepopular.com
* Description: TemplateKit is a WordPress shortcode plugin. With this plugin you can make template with a shortcode and place it anywhere in the website.
* Version: 1.0.1
* Author: codepopular
* Author URI: https://www.codepopular.com
* Text Domain: templatekit-shortcode-for-post-and-page
* License: GPL/GNU.
* Domain Path: /languages
* WP Requirement & Test
* Requires at least: 5.0
* Tested up to: 6.0
* Requires PHP: 5.6
*/

define('TEMPLATE_KIT_PLUGIN_FILE', __FILE__);
define('TEMPLATE_KIT_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('TEMPLATE_KIT_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('TEMPLATE_KIT_PLUGIN_URL', trailingslashit(plugins_url('/', __FILE__)));
define('TEMPLATE_KIT_PLUGIN_VERSION', '1.0.1');

/**----------------------------------------------------------------*/
/* Include all file
/*-----------------------------------------------------------------*/

require __DIR__ . '/vendor/autoload.php';
include_once(dirname( __FILE__ ). '/inc/Template_Kit_Loader.php');

if ( function_exists( 'template_kit_wp_shortcode_run' ) ) {
    template_kit_wp_shortcode_run();
}


/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_templatekit_shortcode_for_post_and_page() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
        require_once __DIR__ . '/appsero/src/Client.php';
    }

    $client = new Appsero\Client( '01fa1020-45a2-4a06-be8a-0079196703e8', 'Templatekit Shortcode For Post And Page', __FILE__ );

    // Active insights
    $client->insights()->init();

}

appsero_init_tracker_templatekit_shortcode_for_post_and_page();
