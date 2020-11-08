<?php
/**
 * Plugin Name
 *
 * @package           Wocommerce addon extension
 * @author            Ronak J Vanpariya
 * @copyright         Ronak J Vanpariya
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Wocommerce addon extension
 * Plugin URI:        https://github.com/vanpariyar/woocommerce-addon-extension
 * Description:       Wocommerce addon extension.
 * Version:           0.1
 * Requires at least: 5.0
 * Requires PHP:      5.0
 * Author:            Ronak J Vanpariya
 * Author URI:        https://vanpariyar.github.io
 * Text Domain:       wpwooaddon
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt 
 * 
 Wocommerce addon extension is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version. 
 Wocommerce addon extension is distributed in the hope that it will be useful,but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 
 You should have received a copy of the GNU General Public License along with Wocommerce addon extension. If not, see  * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo __('Hi there!  I\'m just a plugin, not much I can do when called directly.', 'wpwooaddon');
	exit;
}

/* Plugin Constants */
if (!defined('WP_WOOCOMMERCE_ADDON_EXTENSION_URL')) {
    define('WP_WOOCOMMERCE_ADDON_EXTENSION_URL', plugin_dir_url(__FILE__));
}

if (!defined('WP_WOOCOMMERCE_ADDON_EXTENSION_FILE_PATH')) {
    define('WP_WOOCOMMERCE_ADDON_EXTENSION_FILE_PATH', plugin_dir_path(__FILE__));
}

class Wp_Wocommerce_Addon_Extension {
    
    function __construct(){
        add_action('plugins_loaded', array( $this,'check_some_other_plugin'), 10 );
        add_action( 'woocommerce_register_form', array( $this,'misha_add_register_form_field'), 10 );
        add_action( 'woocommerce_register_post', array( $this,'misha_validate_fields'), 10, 3 );  
        add_action( 'woocommerce_created_customer', array( $this,'misha_save_register_fields') );
        add_action( 'woocommerce_edit_account_form', array( $this,'misha_add_field_edit_account_form') );
        add_action( 'woocommerce_save_account_details', array( $this,'misha_save_account_details') );
        add_filter('woocommerce_save_account_details_required_fields', array( $this,'misha_make_field_required'));
    } 
    
    public function check_some_other_plugin() {

		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			add_action( 'admin_notices', function() {				
				echo '<div class="error"><p><strong>' . esc_html__( 'Woocommerce Addons plugin require Woocommerce Plugin installed / activated', 'wpwooaddon' ) . '</strong></p></div>';
			} );
			return;
		}
    }

    function misha_add_register_form_field(){
    
        woocommerce_form_field(
            'country_to_visit',
            array(
                'type'        => 'text',
                'required'    => true, // just adds an "*"
                'label'       => 'Country you want to visit the most'
            ),
            ( isset($_POST['country_to_visit']) ? $_POST['country_to_visit'] : '' )
        );
        woocommerce_form_field(
            'country_to_visit',
            array(
                'type'        => 'text',
                'required'    => true, // just adds an "*"
                'label'       => 'Country you want to visit the most'
            ),
            ( isset($_POST['country_to_visit']) ? $_POST['country_to_visit'] : '' )
        );
        woocommerce_form_field(
            'country_to_visit',
            array(
                'type'        => 'text',
                'required'    => true, // just adds an "*"
                'label'       => 'Country you want to visit the most'
            ),
            ( isset($_POST['country_to_visit']) ? $_POST['country_to_visit'] : '' )
        );
    
    }
 
    function misha_validate_fields( $username, $email, $errors ) {
    
        if ( empty( $_POST['country_to_visit'] ) ) {
            $errors->add( 'country_to_visit_error', 'We really want to know!' );
        }
    
    }
 
    function misha_save_register_fields( $customer_id ){
    
        if ( isset( $_POST['country_to_visit'] ) ) {
            update_user_meta( $customer_id, 'country_to_visit', wc_clean( $_POST['country_to_visit'] ) );
        }
    
    }

    
    // or add_action( 'woocommerce_edit_account_form_start', 'misha_add_field_edit_account_form' );
    function misha_add_field_edit_account_form() {
    
        woocommerce_form_field(
            'country_to_visit',
            array(
                'type'        => 'text',
                'required'    => true, // remember, this doesn't make the field required, just adds an "*"
                'label'       => 'Country you want to visit the most',
                'description' => 'Maybe it is Norway or New Zealand or...?',
            ),
            get_user_meta( get_current_user_id(), 'country_to_visit', true ) // get the data
        );
    
    }
    
    /**
     * Step 2. Save field value
     */
    
    function misha_save_account_details( $user_id ) {
    
        update_user_meta( $user_id, 'country_to_visit', sanitize_text_field( $_POST['country_to_visit'] ) );
    
    }
    
    /**
     * Step 3. Make it required
     */
    
    function misha_make_field_required( $required_fields ){
    
        $required_fields['country_to_visit'] = 'Country you want to visit the most';
        return $required_fields;
    
    }

}

$wp_wocommerce_addon_extension = new Wp_Wocommerce_Addon_Extension();