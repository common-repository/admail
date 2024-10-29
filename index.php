<?php

if (!defined('ABSPATH')) {
    exit;
}
/**
 * Plugin Name: AdMail
 * Plugin URI:  https://plugins.aleswebs.com
 * Description: Give your customers the option to subscribe for WooCommerce out-of-stock products and receive an email notification when the product is restocked.
 * Version:     1.6.7
 * Author:      Ales
 * Author URI:  https://aleswebs.com
 * Text Domain: ambisn
 * License: GPLv3 or later
 * Requires at least: 5.9
 * Requires PHP: 7.2
 * Tested up to: 6.6
 * 
 * AdMail is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * AdMail is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */
 
 define('AMBISN_FILE', __FILE__);
 define('AMBISN_NAME', 'default');
 define('AMBISN_URL', plugin_dir_url(__FILE__));
 define('AMBISN_PATH', plugin_dir_path(__FILE__));
 define('AMBISN_TEMPLATE_DIR', AMBISN_PATH . '/templates/');
 
 
 require_once(AMBISN_PATH . 'classes/subscriptions.php');
 require_once(AMBISN_PATH . 'classes/subscription_form.php');

function admail_include_files() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'wc_admail';
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;
    if($table_exists){
        require_once(AMBISN_PATH . 'includes/functions.php');
    }
    require_once(AMBISN_PATH . 'init.php');
    
    if (is_admin()) {
        require_once(AMBISN_PATH . 'includes/admin.php');
        require_once(AMBISN_PATH . 'includes/dev-functions.php');
    }
}
add_action('init', 'admail_include_files',99);

function ambisn_admin_enqueue_scripts($hook) {
    
    $admin_url = admin_url();
    
    if (strpos($hook, 'ambisn') !== false) {
        wp_enqueue_style( 'ambisn_wp_styles', AMBISN_URL. 'assets/css/wp_styles.css' , false, date("h:i:s"), 'all' );
        wp_enqueue_style( 'ambisn_admin_styles', AMBISN_URL. 'assets/css/admin.css' , false, date("h:i:s"), 'all' );
        wp_enqueue_style( 'overview_styles', AMBISN_URL. 'assets/css/admin_overview.css' , false, date("h:i:s"), 'all' );
        wp_enqueue_script( 'admin_table_script', AMBISN_URL. 'assets/js/admin_table.js' , array('jquery'), date("h:i:s") );
        wp_enqueue_script( 'admin_scripts', AMBISN_URL. 'assets/js/admin_scripts.js' , array('jquery'), date("h:i:s") );
        wp_localize_script( 'admin_table_script', 'ambisn_script_vars', array('plugin_url' => AMBISN_URL));
        wp_localize_script( 'admin_scripts', 'ambisn_script_vars', array('admin_url' => $admin_url));
    }
}
 add_action( 'admin_enqueue_scripts', 'ambisn_admin_enqueue_scripts' );
 
 function ambisn_front_end_enqueue_scripts(){
     wp_enqueue_style( 'ambisn_styles', AMBISN_URL. 'assets/css/styles.css' , false, date("h:i:s"), 'all' );
 }
 add_action( 'wp_enqueue_scripts', 'ambisn_front_end_enqueue_scripts' );


add_action( 'admin_enqueue_scripts', 'enqueue_settings_scripts' );
function enqueue_settings_scripts( $hook_suffix ) {
    if ( $hook_suffix === 'admail_page_ambisn_settings' ) {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'admin_settings_script', AMBISN_URL. 'assets/js/settings.js' , array('jquery'), date("h:i:s") );
        wp_enqueue_script('jquery');
        wp_enqueue_media();
    }
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'ambisn_add_action_links' );
function ambisn_add_action_links ( $actions ) {
   $mylinks = array('<a href="' . admin_url( 'admin.php?page=ambisn_settings' ) . '">Settings</a>');
   if(!in_array('admail-pro/index.php', apply_filters( 'active_plugins', get_option('active_plugins')))){
       $mylinks[] = '<a style="color:#7350ff; font-weight:700;" href="https://plugins.aleswebs.com/">Get AdMail Pro free license</a>';
   }
   $actions = array_merge( $actions, $mylinks );
   return $actions;
}

function ambisn_on_activation(){
    require_once (AMBISN_PATH.'includes/on_plugin_activate.php');
    ambisn_run_on_activation();
}
add_action( 'init', 'ambisn_on_activation' );
