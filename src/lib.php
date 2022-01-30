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
        protected $get_response_ID = 'thawani_response';


        public function __construct(){ 
            $this->init();
            $secret_key = $this->get_option('secret_key');
            $publishable_key = $this->get_option('publishable_key');
            $environment = $this->get_option('environment');

            $this->api = new Thawani\RestAPI( $secret_key , $publishable_key, $environment);

            add_action( 'admin_menu', [$this, 'add_menu']);

            add_action( 'admin_enqueue_scripts', [$this, 'enqueue_tailwind_css']);
            add_action('wp_ajax_'.$this->get_response_ID.'_get_session' , [$this, 'get_session_details']);
        }

        public function get_session_details() {
            $session = $_POST['session'];

            if(empty($session)) { 
                wp_send_json( [
                    'error' => __('You can not send empty session' , '')
                ], 400);
            }

            $response  = $this->api->get_session($session);

            $http_response_code = wp_remote_retrieve_response_code( $response );

            if($http_response_code != 200) { 
                wp_send_json( [
                    'error' => true,
                    'data' => $response['body']
                ], 400);
            }

            wp_send_json( json_decode($response['body']) , 200 );
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
                wp_enqueue_script( 'get-thawani-response-script', plugin_dir_url(__DIR__) .'assets/script.js' , [], '0.1.0', true );
            }
        }

    }

// end of if
}
