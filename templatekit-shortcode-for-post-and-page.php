<?php
/**
* Plugin Name: Templatekit Shortcode For Post And Page
* Plugin URI: https://codepopular.com
* Description: TemplateKit is a WordPress shortcode plugin. With this plugin you can make template with a shortcode and place it anywhere in the website.
* Version: 1.0.0
* Author: codepopular
* Author URI: https://www.codepopular.com
* Text Domain: templatekit-shortcode-for-post-and-page
* License: GPL/GNU.
* Domain Path: /languages
* WP Requirement & Test
* Requires at least: 4.0
* Tested up to: 5.9
* Requires PHP: 5.6
*/

define('TEMPLATE_KIT_PLUGIN_FILE', __FILE__);
define('TEMPLATE_KIT_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('TEMPLATE_KIT_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('TEMPLATE_KIT_PLUGIN_URL', trailingslashit(plugins_url('/', __FILE__)));
define('TEMPLATE_KIT_PLUGIN_VERSION', '1.0.0');

/**----------------------------------------------------------------*/
/* Include all file
/*-----------------------------------------------------------------*/

/**
 *
 */
include_once(dirname( __FILE__ ). '/inc/Template_Kit_Loader.php');

if ( function_exists( 'template_kit_wp_shortcode_run' ) ) {
    template_kit_wp_shortcode_run();
}

