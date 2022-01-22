<?php
/**
 * @author Muhannad Al-Risi
 */

if(!defined('THAWANI_PLUGIN_DIR')) {
    die('not defined');
    // replace  this with notification  
}else  { 
    require_once THAWANI_PLUGIN_DIR.'thawani-for-woocommerce/src/WC_Gateway_ThawaniGateway.php';
    require_once THAWANI_PLUGIN_DIR.'thawani-for-woocommerce/src/RestAPI.php';


    class GetThawaniResponse extends Thawani\WC_Gateway_ThawaniGateway { 

        private $api; 
        public function __construct(){ 
            $this->init();
            $secret_key = $this->get_option('secret_key');
            $publishable_key = $this->get_option('publishable_key');
            $environment = $this->get_option('environment');

            $this->api = new Thawani\RestAPI( $secret_key , $publishable_key, $environment);

            add_action( 'admin_menu', [$this, 'add_menu']);
        }

        public function get_session_json(){
            $session = $_POST['thawani_session'];
        }


        public function add_menu() { 
            add_menu_page(
                __('Get Response', "get_thawani_response"),
                __('Get Thawani Response', "get_thawani_response"),
                'manage_woocommerce',
                'get_thawani_response',
                [$this, 'response_template'],
                // THAWANI_GW_ICON,
                null,
                11
            );
        }

        public function response_template(){ 
            require_once THAWANI_RESPONSE_DIR.'template/index.php';
        }

        public function enqueue_tailwind_css($hook){
            if($hook === 'toplevel_page_get_thawani_response')  {
                wp_enqueue_style( 'get-thawani-response', plugin_dir_url(__DIR__) .'assets/style.css' );
            }
        }

    }

// end of if
}