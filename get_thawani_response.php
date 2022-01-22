<?php
/**
 * Plugin Name:     Get_thawani_response
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Get thawani response to send it back to the Thawani Team Support
 * Author:          Muhannad Al-Risi
 * Author URI:      https://alrisi.net
 * Text Domain:     get_thawani_response
 * Domain Path:     /languages
 * Version:         0.1.0-rc
 *
 * @package         Get_thawani_response
 */


define('THAWANI_PLUGIN_DIR' , plugin_dir_path( __DIR__ )); 
define('THAWANI_RESPONSE_DIR' , plugin_dir_path( __FILE__ )); 
function get_thawnai_creds() { 

}

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
