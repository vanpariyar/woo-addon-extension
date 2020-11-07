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
    } 
    
    public function check_some_other_plugin() {

		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			add_action( 'admin_notices', function() {				
				echo '<div class="error"><p><strong>' . esc_html__( 'Woocommerce Addons plugin require Woocommerce Plugin installed / activated', 'wpwooaddon' ) . '</strong></p></div>';
			} );
			return;
		}
    }

}
