<?php
/**
 * Plugin Name:     Get Thawani Response
 * Plugin URI:      https://github.com/PhazeRoOman/get_thawani_response
 * Description:     Helper plugin to get Thawani Pay JSON response
 * Author:          PhazeRo
 * Author URI:      https://phaze.ro
 * Text Domain:     get_thawani_response
 * Domain Path:     /languages
 * Version:         0.1.1
 *
 * @package         Get_thawani_response
 */

// import  plugin -> to add plugins functions
include_once ABSPATH . 'wp-admin/includes/plugin.php';

define('THAWANI_PLUGIN_DIR' , plugin_dir_path( __DIR__ )); 
define('THAWANI_RESPONSE_DIR' , plugin_dir_path( __FILE__ )); 

function load_thawnai_response() {
    $is_loaded  = is_plugin_active( 'thawani-for-woocommerce/thawani-for-woocommerce.php' );
    if(!$is_loaded) {
        // do nothing when the plugin is not loaded 
        return false; 
    }

    require_once 'src/lib.php';

    new GetThawaniResponse();
}

add_action( 'init', 'load_thawnai_response');
