<?php
/*
 * Plugin Name: WooCommerce ibtil Payment Gateway
 * Plugin URI: 
 * Description: funny gateway on lms - ibtil, it is like redirect gateway because site couldn't access directly to the bank gateway. it just ike  
 * Author: Shirin Niki
 * Author URI: 
 * Version: 1.0.1
 */


/*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
add_filter( 'woocommerce_payment_gateways', 'ibtil_add_gateway_class' );
function ibtil_add_gateway_class( $gateways ) {
	$gateways[] = 'WC_IBTIL_Gateway'; // your class name is here
	return $gateways;
}
 
/*
 * Plugins_loaded action hook
 */
add_action( 'plugins_loaded', 'ibtil_init_gateway_class' );
function ibtil_init_gateway_class() {
 
	class WC_IBTIL_Gateway extends WC_Payment_Gateway {

 		public function __construct() {
            $this->id = 'ibtil'; // payment gateway plugin ID
            $this->icon = ''; // URL of the icon that will be displayed on checkout page near your gateway name
            $this->has_fields = true; // in case you need a custom credit card form
            $this->method_title = 'ibtil Gateway';
            $this->method_description = 'Description of ibtil payment gateway'; // will be displayed on the options page
         
            // gateways can support subscriptions, refunds, saved payment methods,
            // but this is a simple payments
            $this->supports = array(
                'products'
            );
         
            // Method with all the options fields
            $this->init_form_fields();
         
            // Load the settings.
            $this->init_settings();
            $this->title = $this->get_option( 'title' );
            $this->description = $this->get_option( 'description' );
            $this->enabled = $this->get_option( 'enabled' );
			//for enabling test mmode
            //$this->testmode = 'yes' === $this->get_option( 'testmode' );
			//get private code and ....
            // $this->private_key = $this->testmode ? $this->get_option( 'test_private_key' ) : $this->get_option( 'private_key' );
            // $this->publishable_key = $this->testmode ? $this->get_option( 'test_publishable_key' ) : $this->get_option( 'publishable_key' );
         
            // This action hook saves the settings
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
         
            // We need custom JavaScript to obtain a token
            add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );
         
            // You can also register a webhook here
            // add_action( 'woocommerce_api_{webhook name}', array( $this, 'webhook' ) );
 
 		}
 
		/**
 		 * Plugin options, we deal with it in Step 3 too
 		 */
 		public function init_form_fields(){
 
            $this->form_fields = array(
                'enabled' => array(
                    'title'       => 'Enable/Disable',
                    'label'       => 'Enable ibtil Gateway',
                    'type'        => 'checkbox',
                    'description' => '',
                    'default'     => 'no'
                ),
                'title' => array(
                    'title'       => 'Title',
                    'type'        => 'text',
                    'description' => 'This controls the title which the user sees during checkout.',
                    'default'     => 'Credit Card',
                    'desc_tip'    => true,
                ),
                'description' => array(
                    'title'       => 'Description',
                    'type'        => 'textarea',
                    'description' => 'This controls the description which the user sees during checkout.',
                    'default'     => 'Pay with your credit card via our super-cool payment gateway.',
                ),
            );
 
	 	}
 
		/**
		 * You will need it if you want your custom credit card form,
		 */
		public function payment_fields() {
 
		}
 
		/*
		 * Custom CSS and JS
		 */
	 	public function payment_scripts() {
 
		
 
	 	}
 
		/*
 		 * Fields validation
		 */
		public function validate_fields() {
 
		
 
		}
 
		/*
		 *  processing the payments is here.
		 */
		public function process_payment( $order_id ) {
                // global $woocommerce; 
     		
 
	 	}
 
		/*
		 * In case you need a webhook
		 */
		public function webhook() {
 
		
 
	 	}
 	}
}
