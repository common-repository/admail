<?php

if (!defined('ABSPATH')) {
    exit;
}

function ambisn_run_on_activation() {
    $site = site_url();
    $logo_array = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
    if(is_array($logo_array)){
        $logo = esc_url($logo_array[0]);
    }else{
        $logo = AMBISN_URL.'assets/images/wp-logo.png';
    }
    $site_title = get_bloginfo('name');

    $ambisn_settings = array(
        'guests'=>'1',
        'unsubscribe'=>'1',
        'email_field'=>'1',
        'auto_submission'=>'0',
        'popup'=>'0',
        'ajaxify_submission'=>'1',
        'prevent_dupl_subscriptions'=>'1',
        'form_text'=>'Be the first to know once this product is back in stock',
        'form_subscribed_text'=>'Your subscription request has been received!',
        'form_previously_subscribed_notice'=>'A previous subscription with this email found!',
        'form_bg_color' => '#fff',
        'btn_icon'=>'1',
        'button_text'=>'SUBSCRIBE',
        'button_bg_color'=>'#fd6e4f',
        'button_text_color'=>'#fff',
        'button_border_radius'=>'0px',
        'unsubscribe_text'=>'Unsubscribe?',
        'subscribed_btn_text'=>'Subscribed',
        'sf_consent' => '0',
        'sf_consent_notice' => 'I agree to the Terms and Conditions.',
        'sf_consent_pp_url' => get_privacy_policy_url(),
        'sf_consent_error_message' => 'You must agree to the Terms and Conditions to subscribe.',
        'ps_tab'=>'0',
        'ps_tab_empty_notice' => 'You have no active subscriptions for out-of-stock products yet.',
        'recaptcha_tree' => '0',
        'store_logo'=> $logo,
        'store_name'=>$site_title,
        'store_email'=>'info',
        'no_reply'=>'0',
        'email_price'=>'1',
        'email_qty'=>'1',
        'email_subject'=>'The product you subscribed for is back in stock!',
        'email_heading'=>'YOU ARE IN LUCK!',
        'email_subheading'=>'The sold out product you liked is back in stock.',
        'email_button_text'=> 'Add to cart',
        'email_footer' => 'Sent with love by '.$site_title,
        'email_template'=>'default',
        'store_confirmation_email' => '0',
        'store_conf_email_recipient' => get_option('admin_email'),
        'conf_email_subject'    => 'Product Subscription Confirmation',
        'conf_email_heading'    => 'Thank you for subscribing to our product',
        'conf_email_subheading' => 'You will receive an email notification once the product is back in stock.',
        'conf_email_footer'     => 'Thank you for choosing us as your preferred store.',
    );
    
    global $wpdb;
    $wpdb->hide_errors();
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $table_name = $wpdb->prefix . 'wc_admail';
    $charset_collate = $wpdb->get_charset_collate();

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !== $table_name) {
        $sql = "CREATE TABLE `$table_name` (
            ID INT NOT NULL AUTO_INCREMENT,
            option_name TEXT,
            option_type TEXT,
            value LONGTEXT,
            date DATE,
            PRIMARY KEY (ID)
        ) $charset_collate;";

        $db_delta_result = dbDelta($sql);
        $wpdb->insert($table_name, array('option_name' => 'admail_settings', 'value' => serialize($ambisn_settings), 'option_type' => 'setting'));
        return $db_delta_result;
        
    }else{
        $columns = $wpdb->get_results("DESCRIBE $table_name");
        $column_names = wp_list_pluck($columns, 'Field');

        if (!in_array('option_name', $column_names)) {
            if (in_array('option', $column_names)) {
                $rename_query = "ALTER TABLE $table_name CHANGE option option_name TEXT";
                $result = $wpdb->query($rename_query);
            }
        }       
        $sql = "SELECT `value` FROM `$table_name` WHERE `option_name` = 'admail_settings' AND `option_type` = 'setting'";
        $existing_settings = $wpdb->get_var($sql);
        $existing_settings = unserialize($existing_settings);
        $updated_settings = array_merge($ambisn_settings, $existing_settings);
        $wpdb->update($table_name, array('value' => serialize($updated_settings)), array('option_name' => 'admail_settings', 'option_type' => 'setting'));
    }
}