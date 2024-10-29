<?php

if (!defined('ABSPATH')) {
    exit;
}

function ambisn_set_session_cookie() {
    
    if (!isset($_COOKIE['ambisn_sessionid'])) {
        
        $session_id = uniqid();
        
        if(!headers_sent()){
        
            setcookie('ambisn_sessionid', $session_id, time() + (86400 * 3), '/');
        
        }
        
    } else {
        
        $session_id = sanitize_key($_COOKIE['ambisn_sessionid']);
        
    }
    
    return $session_id;
}

add_action('template_redirect', 'ambisn_set_session_cookie');


define('AMBISN_SESSION_ID', ambisn_set_session_cookie());


function ambisn_print_subscription_form(){
    
    if(ambisn_get_setting('guests') === '0' && !is_user_logged_in()){
        
        return;
        
    }
    
    global $product;
    
    if($product){
        
        if($product->get_type() === 'variable' && ambisn_get_setting('s-variation') === '1'){
            
            $variations = $product->get_available_variations();

            foreach ($variations as $variation) {

                if ($variation['is_in_stock']) {
            
                    return;
            
                }
        
            }
            
        }
        
        $product_id = $product->get_id();
        
        ambisn_define_subscriptions_language($product_id);
        
        $subscription_form = new AmbisnSubscriptionForm;
        
        $subscription_form->print_subscription_form($product_id);
        
    }
}


function ambisn_save_dynamic_strings(){
    
    ob_start();
    
    echo '<?php';
    
    ?>
    
    $setting_strings_array = array(
        'form_text' => __('<?php echo esc_attr(ambisn_get_setting('form_text')) ; ?>','ambisn'),
        'form_subscribed_text' => __('<?php echo esc_attr(ambisn_get_setting('form_subscribed_text')) ; ?>','ambisn'),
        'form_previously_subscribed_notice' => __('<?php echo esc_attr(ambisn_get_setting('form_previously_subscribed_notice')) ; ?>','ambisn'),
        'button_text' => __('<?php echo esc_attr(ambisn_get_setting('button_text')) ; ?>','ambisn'),
        'unsubscribe_text' => __('<?php echo esc_attr(ambisn_get_setting('unsubscribe_text')) ; ?>','ambisn'),
        'subscribed_btn_text' => __('<?php echo esc_attr(ambisn_get_setting('subscribed_btn_text')) ; ?>','ambisn'),
        'store_name' => __('<?php echo esc_attr(ambisn_get_setting('store_name')) ; ?>','ambisn'),
        'subscription_form_title' => __('<?php echo esc_attr(ambisn_get_setting('form_text')) ; ?>','ambisn'),
        'ps_tab_empty_notice' => __('<?php echo esc_attr(ambisn_get_setting('ps_tab_empty_notice')) ; ?>','ambisn'),
        'sf_consent_notice' => __('<?php echo esc_attr(ambisn_get_setting('sf_consent_notice')) ; ?>','ambisn'),
        'sf_consent_error_message' => __('<?php echo esc_attr(ambisn_get_setting('sf_consent_error_message')) ; ?>','ambisn'),
        'conf_email_subject' => __('<?php echo esc_attr(ambisn_get_setting('conf_email_subject')) ; ?>','ambisn'),
        'conf_email_heading' => __('<?php echo esc_attr(ambisn_get_setting('conf_email_heading')) ; ?>','ambisn'),
        'conf_email_subheading' => __('<?php echo esc_attr(ambisn_get_setting('conf_email_subheading')) ; ?>','ambisn'),
        'conf_email_footer' => __('<?php echo esc_attr(ambisn_get_setting('conf_email_footer')) ; ?>','ambisn'),
        'email_subject' => __('<?php echo esc_attr(ambisn_get_setting('email_subject')) ; ?>','ambisn'),
        'email_heading' => __('<?php echo esc_attr(ambisn_get_setting('email_heading')) ; ?>','ambisn'),
        'email_subheading' => __('<?php echo esc_attr(ambisn_get_setting('email_subheading')) ; ?>','ambisn'),
        'email_button_text' => __('<?php echo esc_attr(ambisn_get_setting('email_button_text')) ; ?>','ambisn'),
        'email_footer' => __('<?php echo esc_attr(ambisn_get_setting('email_footer')) ; ?>','ambisn'),
    );
    
    <?php

    $file_contents = ob_get_clean();

    file_put_contents(AMBISN_PATH.'includes/dynamic/setting_strings.php', $file_contents);
}

ambisn_save_dynamic_strings();

function ambisn_get_translated($setting){
    
    include(AMBISN_PATH.'includes/dynamic/setting_strings.php');
    
    $translated_string = "";
        
    if(isset($setting_strings_array) && is_array($setting_strings_array)){
        
        if(isset($setting_strings_array[$setting])){
            
            $translated_string =  $setting_strings_array[$setting];
            
        }else{
        
            $translated_string = ambisn_get_setting($setting);
            
        }
            
    }else{
            
        $translated_string = ambisn_get_setting($setting);
            
    }
        
    return $translated_string;
    
}


function ambisn_dynamic_css() {
    
    include_once(AMBISN_PATH.'includes/dynamic/styles.php');
    
}
add_action('wp_head', 'ambisn_dynamic_css');

function ambisn_print_popup_sform_btn(){
    
    if(ambisn_get_setting('guests') === '0' && !is_user_logged_in()){
        
        return;
        
    }    
    
    global $product;
    
    if($product){
        
        $ofs_variations_json = array();
        
        $product_type = $product->get_type();
        
        if($product_type === 'simple' && $product->is_in_stock()){
            
            
            return;
            
        }
        
        if(!$product->is_in_stock() && get_option('woocommerce_hide_out_of_stock_items') === 'yes'){
        
            $product_type = 'simple';
        
        }
        
        if($product_type === 'variable' && ambisn_get_setting('s-variation') === '1'){
            
            $variations = $product->get_available_variations();

            foreach ($variations as $variation) {

                if ($variation['is_in_stock']) {
            
                    return;
            
                }
        
            }
            
        }        
        
        $product_id = $product->get_id();
        
        $visibilty = "visible";

        if ($product_type == 'variable') {
            
            $visibilty = "";
                
            $out_of_stock_variations = array();

            $variations = $product->get_available_variations();

            foreach ($variations as $variation) {
        
                $variation_id = $variation['variation_id'];

                $is_out_of_stock = !$variation['is_in_stock'];

                if ($is_out_of_stock) {
            
                    $out_of_stock_variations[] = $variation_id;
            
                }
        
            }

            $ofs_variations_json = json_encode($out_of_stock_variations);
        }else{
            
            $ofs_variations_json = json_encode(array());
            
        }
        
        $email = '';
        
        if (is_user_logged_in()) {
            
            $current_user = wp_get_current_user();
            
            $email = $current_user->user_email;
            
        }

        if(empty($email)){
    
            if(isset($_COOKIE["nmuseremail"])){
        
                $email = sanitize_email($_COOKIE["nmuseremail"]);
        
            }
        }
        
        include_once (AMBISN_PATH.'includes/blocks/subscription_form_popup_btn.php');
        
    }
}

 
function ambisn_subscription_form_positioned(){
    
    global $product;
    
    $popup_set = ambisn_get_setting('popup');
    
    $excluded_cats = explode(',',ambisn_get_setting('exclude_categories'));
    
    if(!is_array($excluded_cats)){
        
        $excluded_cats = array();
        
    }
    
    $excluded_p_types = explode(',',ambisn_get_setting('exclude_product_type'));
    
    if(!is_array($excluded_p_types)){
        
        $excluded_p_types = array();
        
    }
    
    $exclude_tag_ids = explode(',',ambisn_get_setting('exclude_tag_names'));
    
    if(!is_array($exclude_tag_ids)){
        
        $exclude_tag_names = array();
        
    }else{
        
        $exclude_tag_names = array();
        
        foreach($exclude_tag_ids as $tag_id){
            
            $tag = get_term( $tag_id, 'product_tag' );
            
            if ( ! empty( $tag ) && ! is_wp_error( $tag ) ) {
                
                $exclude_tag_names[] = $tag->name;
    
            }
        }
    }
    
    if($product){
        
        $current_product_categories = get_terms( array(
            'taxonomy' => 'product_cat',
            'object_ids' => $product->get_id(),
            'fields' => 'slugs',
        ) );
        
        $intersect_cats = array_intersect($excluded_cats,$current_product_categories);
        
        if(count($intersect_cats) > 0){
            
            return;
            
        }
        
        $product_tags = get_the_terms( $product->get_id(), 'product_tag' );
        
        $product_tag_names = array();
        
        if ( ! empty( $product_tags ) && ! is_wp_error( $product_tags ) ) {
            
            foreach ( $product_tags as $product_tag ) {
                
                $product_tag_names[] = $product_tag->name;
                
            }
            
        }
        
        $intersect_tags = array_intersect($exclude_tag_names, $product_tag_names);
        
        if(count($intersect_tags) > 0){
            
            return;
            
        }
        
        $admin_url = admin_url();
        wp_enqueue_script( 'ambisn_scripts', AMBISN_URL. 'assets/js/scripts.js' , array('jquery'), date("h:i:s") );
        wp_localize_script( 'ambisn_scripts', 'ambisn_script_vars', array('admin_url' => $admin_url));
        
        $product_type = $product->get_type();
        
        if(in_array($product_type, $excluded_p_types)){
            
            return;
            
        }
        
        if ($product_type === 'grouped') {
            
            add_filter('woocommerce_grouped_product_list_column_label', 'ambisn_susbscription_form_grouped', 10, 2);
          
        }else{

            if ($product_type === 'simple') {
            
                $form_hook = 'woocommerce_simple_add_to_cart';
                
                $button_hook = 'woocommerce_simple_add_to_cart';
            
                $priority = 31;
            
            } elseif ($product_type === 'variable') {
                
                if(!$product->is_in_stock() && get_option('woocommerce_hide_out_of_stock_items') === 'yes'){
                    
                    $form_hook = 'woocommerce_after_variations_form';
                    
                    $button_hook = 'woocommerce_after_variations_form';
                    
                }else{
            
                    $form_hook = 'woocommerce_before_add_to_cart_button';
                    
                    $button_hook = 'woocommerce_after_add_to_cart_button';
                
                }
            
                $priority = 31;
            
            } elseif ($product_type === 'external') {
            
                $form_hook = 'woocommerce_simple_add_to_cart';
                
                $button_hook = 'woocommerce_after_add_to_cart_button';
            
                $priority = 31;             
            
            } else {
            
                $form_hook = 'woocommerce_simple_add_to_cart';
                
                $button_hook = 'woocommerce_after_add_to_cart_button';
            
                $priority = 31;            
            
            }
            
            add_action( $form_hook, 'ambisn_print_subscription_form', $priority);
            
            if($popup_set == 1){
                
                add_action( $button_hook, 'ambisn_print_popup_sform_btn', $priority);
                
            }
        
        }
        
    }    
    
}
add_action('woocommerce_single_product_summary','ambisn_subscription_form_positioned');


function ambisn_susbscription_form_grouped($value, $child){
    
    global $product;
    
    $product_id = $product->get_id();
    
    $popup_set = ambisn_get_setting('popup');
    
	if(!$product->is_in_stock()){

	    ob_start();
            
        ambisn_print_subscription_form();
            
        if($popup_set == 1){    
           
           ambisn_print_popup_sform_btn($product_id);
           
        }
            
        $inner_content = ob_get_clean();
        
	    $value = $value.$inner_content;
	    
	}
	
	return $value;
}

// END ADDING

function ambisn_empty_data(){
    
    $admail = new AmbisnSubscriptions;

    $admail_products = $admail->get_products();
    
    if(!is_array($admail_products) || count($admail_products) === 0){
        
        return true;
        
    }else{
        
        return false;
        
    }
}


function ambisn_get_setting($setting){
    
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'wc_admail';
    
    $sql = "SELECT `value` FROM `$table_name` WHERE `option_name` = 'admail_settings' ";
    
    $value = unserialize($wpdb->get_col($sql)[0]);
    
    if (isset($value[$setting])) {
        
        return $value[$setting];
        
    }

    return false;
}


function ambisn_update_setting($setting , $value){
    
    global $wpdb;     
    
    $table_name = $wpdb->prefix . 'wc_admail';
    
    $sql = "SELECT `value` FROM `$table_name` WHERE `option_name` = 'admail_settings' ";
    
    $data = unserialize($wpdb->get_col($sql)[0]);
    
    $data[$setting] = $value;
    
    $data = array('value' => serialize($data), 'option_type' => 'setting');
    
    $where = array('option_name' => 'admail_settings');
    
    $wpdb->update( "$table_name", $data, $where );
    
}

function ambisn_get_data($key, $date = 'all') {
    
    global $wpdb;

    $table_name = $wpdb->prefix . 'wc_admail';

    if ($date == 'all') {
        
        $sql = "SELECT `value` FROM `$table_name` WHERE `option_name` = 'subscriptions'";
        
        $data = $wpdb->get_col($sql);
        
        $values = array();
        
        foreach ($data as $item) {
            
            $unserialized_item = unserialize($item);
            
            if (isset($unserialized_item[$key])) {
                
                $values[] = $unserialized_item[$key];
                
            }
        }
        return $values;
        
    } else {
        
        if (strpos($date, ' ') !== false) {
            
            $date = date('Y-m-d', strtotime($date));
        }
        
        $sql = "SELECT `value` FROM `$table_name` WHERE `option_name` = 'subscriptions' AND `date` = '$date'";
        
        $result = $wpdb->get_col($sql);
        
        if (!empty($result)) {
            
            $data = unserialize($result[0]);
            
            if (isset($data[$key])) {
                
                return $data[$key];
                
            }
        }
        return null;
    }
}

function ambisn_update_data($data, $value){
    
    global $wpdb;
    
    $date = date('Y-m-d');
    
    $table_name = $wpdb->prefix . 'wc_admail';
    
    $sql = "SELECT `value` FROM `$table_name` WHERE `option_name` = 'subscriptions' AND `date` = '$date'";
    
    $existing_row = $wpdb->get_row($sql);

    if ($existing_row) {

        $data_array = unserialize($existing_row->value);
        
        $data_array[$data] = $value;

        $data = array('value' => serialize($data_array), 'option_type' => 'data');
        
        $where = array('option_name' => 'subscriptions', 'date' => $date);

        $wpdb->update($table_name, $data, $where);
        
    } else {

        $data_array = serialize(array($data => $value));
      
        $wpdb->insert($table_name, array('date' => $date, 'option_name' => 'subscriptions', 'value' => $data_array, 'option_type' => 'data'));  
    }
}





function ambisn_collected_emails($value , $date){
    
    $emails = ambisn_get_data('emails', $date);
    
    if($date == 'all'){
        
        $emails = implode(',' , array_filter($emails));
        
    }
    
    $emailsArray = explode(',' , $emails);
    
    if(empty($emails)){
        
        $emailsArray = Array();
        
    }
    
    switch($value){
        
        case 'count':
            
           $result = count($emailsArray);
           
        break;
        
        case 'emails':
            
           $result = $emailsArray;
           
        break;
    }
    
    return $result;
}


add_action('template_redirect','ambisn_do_init');
function ambisn_do_init(){
    global $current_user;
    global $product;
    
    if(isset($_POST['ambisn-submit'])){
        add_filter('body_class', 'ambisn_success_submission_class');
        add_action('wp_head', 'ambisn_hide_wc_notice');
    	$email = sanitize_email($_POST['ambisn_email']);
    	$product_id = absint($_POST['ambisn_product_id']);
    	global $nmemailErr;
        
        if(ambisn_subscription_exists($email, $product_id)){
    	   $nmemailErr =  '<p class="ambisn_err_notice">'.ambisn_get_setting('form_previously_subscribed_notice').'</p>';
    	}
        
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) || !is_int( $product_id)) {
            $nmemailErr = '<p class="ambisn_err_notice">* Invalid email format</p>';
        }
        else{
            $status = "enabled";
            $usersData = get_post_meta($product_id, 'wc_admail_data', true);
            update_post_meta($product_id, 'wc_admail', true);
            ambisn_submit($product_id, $email, $status, $usersData);
        }
    }

    if(isset($_POST['ambisn-unsubscribe'])){
    	$product_id = absint($_POST['ambisn_product_id']);
        ambisn_unsubscribe_form($product_id, AMBISN_SESSION_ID);
        add_filter('body_class', 'ambisn_success_submission_class');
        add_action('wp_head', 'ambisn_hide_wc_notice');
    }
  
}

function ambisn_success_submission_class($classes){
    $classes[] = 'nm-submitted';
    return $classes;
}
function ambisn_hide_wc_notice(){
    echo '<style>.nm-submitted .woocommerce-notices-wrapper{display:none !important;}</style>';
}

function ambisn_unsubscribe_form($product_id, $session_id){
    
    global $current_user;
    
    $email = $current_user->user_email;
    
    $productSubscribers = get_post_meta($product_id, 'wc_admail_data', true);
    
    $date = date('Y-m-d');
        
    if(is_array($productSubscribers)){
            
        if( empty($email) || !isset($productSubscribers[$email])){
            
            foreach(array_keys($productSubscribers) as $email_item){
                
                if(isset($productSubscribers[$email_item]['sessionID']) && $productSubscribers[$email_item]['sessionID'] == AMBISN_SESSION_ID){
                    
                    $email = $email_item;
                    
                    break;
                
                } 
            
            }
                
        }

        $subscriptionCount = intval(get_post_meta($product_id, 'wc_admail_count', true));
        
        $subscribersCount = intval(ambisn_get_data('subscribers_count', $date));
        
        unset($productSubscribers[$email]);
        
        $updatedSubscribersCount = $subscribersCount - 1;
        
        if($updatedSubscribersCount < 0){
            
            $updatedSubscribersCount = 0;
            
        }
        update_post_meta($product_id, 'wc_admail_data', $productSubscribers);
        
        ambisn_update_data('subscribers_count', $updatedSubscribersCount );
        
        update_post_meta($product_id, 'wc_admail_count', $updatedSubscribersCount);        
        
    }
}

//Generate subscription form (simple and variable products) 

function ambisn_subscription_form($type){
    global $product;
    $product_id = $product->get_id();
    $variations_id = $product->get_children();
    $popup_set = ambisn_get_setting('popup');
    $popup_class = '';
    if($popup_set == 1){
        $popup_class = 'popup';
    }
    if($type == "simple"){
        if(!$product->is_in_stock()){
            ?> 
            <div class="ambisn-variation-notice ng <?php echo $popup_class; ?>" variation="<?php echo $product_id;?>">
                <?php echo ambisn_subscription_form_front($product_id, ''); ?>
            </div>
            <?php
        }        
    }
    if($type == "variable"){
        if($product->is_type('variable')){
            $variations = $product->get_available_variations();
            $at_least_one_in_stock = false;

            foreach ( $variations as $variation ) {
                $variation_obj = wc_get_product( $variation['variation_id'] );
                if ( $variation_obj->is_in_stock() ) {
                    $at_least_one_in_stock = true;
                    break;
                }
            }
            $s_variation = ambisn_get_setting('s-variation');
            if($at_least_one_in_stock && ($s_variation == 1)){
                
            }else{
                foreach($variations_id as $variation_id){
                    $variation = wc_get_product($variation_id);
                    if(!$variation->is_in_stock()){
                        ?> 
                        <div class="ambisn-variation-notice ng <?php echo $popup_class; ?>" variation="<?php echo $variation_id ;?>" style="display:none;">
                            <?php echo ambisn_subscription_form_front($variation_id, ''); ?>
                        </div>
                        <?php
                    }
                }                
            }
        }    
    }    
}
    
function ambisn_susbscription_form(){
    global $product;
    
    $excluded_categories = explode(',',ambisn_get_setting('exclude_categories'));
    $product_categories = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'slugs' ) );
    
    $categories_match = array_intersect( $excluded_categories, $product_categories );
    
    if(empty($categories_match)){
    $guestsSet = ambisn_get_setting('guests');
    $popup_set = ambisn_get_setting('popup');
    $ajaxify_submission = ambisn_get_setting('ajaxify_submission');
    $catVisibilty = get_option('woocommerce_hide_out_of_stock_items');
    $admin_url = admin_url();
    wp_enqueue_script( 'ambisn_scripts', AMBISN_URL. 'assets/js/scripts.js' , array('jquery'), date("h:i:s") );
    wp_localize_script( 'admin_scripts', 'ambisn_script_vars', array('admin_url' => $admin_url));
    
    if($guestsSet == '1' || is_user_logged_in()){
        
        require_once(AMBISN_PATH.'includes/subscription_form.php');
        if($ajaxify_submission == '1'){
            wp_enqueue_script( 'ambisn_ajax_submission_script', AMBISN_URL. 'assets/js/ajax_submission_form.js' , array('jquery'), date("h:i:s") );
            wp_localize_script( 'ambisn_ajax_submission_script', 'ambisn_script_vars', array('plugin_url' => AMBISN_URL));
        }
        
        //Show form on simple products
        
        if($product->is_type('simple') && !$product->is_in_stock()){
            add_action( 'woocommerce_simple_add_to_cart', 'ambisn_subscription_form_simple', 31);
            if($popup_set == 1){
                add_action( 'woocommerce_simple_add_to_cart', 'ambisn_popup_button', 31);
            }
        }
        
        //Show form on variable products
        
        if($product->is_type('variable')){
            $variations_id = $product->get_children();
            $var_instock = 0;
            $var_ofs = 0;
            foreach ($variations_id as $variation_id){
                $variation = wc_get_product($variation_id);  
                if ($variation->is_in_stock()) {
                    $var_instock++;
                }else{
                    $var_ofs++;
                }
            }
            
            if(($var_instock == 0) && $catVisibilty == 'yes'){
                add_action( 'woocommerce_after_add_to_cart_form', 'ambisn_subscription_form_simple', 21);
                if($popup_set == 1){
                    add_action( 'woocommerce_after_add_to_cart_form', 'ambisn_popup_button', 31);
                }
            }
            
            else{
                if(count($variations_id) == "0"){
                    add_action( 'woocommerce_after_variations_form', 'ambisn_subscription_form_simple', 20);
                    if($popup_set == 1){
                        add_action( 'woocommerce_after_variations_form', 'ambisn_popup_button');
                    }
                }
                elseif($var_ofs > 0){
                    add_action( 'woocommerce_single_variation', 'ambisn_subscription_form_variable', 10 );
                    if($popup_set == 1){
                        add_action( 'woocommerce_after_add_to_cart_button', 'ambisn_popup_button');
                    }
                }                
                
            }
        }
    }
    }
}

function is_ambisn_subscribed($email = '', $product_id){
    
    $productSubscribers = get_post_meta($product_id, 'wc_admail_data', true);
    
    if(!is_array($productSubscribers)){
        
        $productSubscribers = array();
        
    }
    
    $subscriber_emails = array_keys($productSubscribers);
    
    if(!$email){
        
        foreach($subscriber_emails as $email_item){
            
            if($productSubscribers[$email_item]['sessionID'] == AMBISN_SESSION_ID){
                
                $email = $email_item;
                
                break;
                
            }
            
        }
        
    }
    
    if (isset($productSubscribers[$email]['sessionID']) && $productSubscribers[$email]['sessionID'] == AMBISN_SESSION_ID) {
        
        if($productSubscribers[$email]['status'] == 'enabled'){
            
            return true;
            
        }
    
    }
    
    if(is_user_logged_in()){
        
        global $current_user;
        
        $regiEmail = $current_user->user_email;
        
        if(!empty($regiEmail)){
            
            if (isset($productSubscribers[$regiEmail])){
                
                if($productSubscribers[$regiEmail]['status'] == 'enabled'){
                    
                    return true;
                    
                }
                
            }
            
        }
    }
    
    return false;
}

function ambisn_subscription_exists($email, $product_id){
    
    $productSubscribers = get_post_meta($product_id, 'wc_admail_data', true);
    
    if(!is_array($productSubscribers)){
        
        $productSubscribers = array();
        
    } 
    
    if(array_key_exists($email, $productSubscribers) && $productSubscribers[$email]['status'] == 'enabled'){
        
        return true;
    }
    
    return false;
}

//Submit subscription - Ajax

function ajax_ambisn_subscribe(){
    
    $response = array();
    
    $popup_set = ambisn_get_setting('popup');
    
    $recaptcha_tree = ambisn_get_setting('recaptcha_tree');

    $recaptcha_tree_site_key = ambisn_get_setting('recaptcha_tree_site_key');
    
    $recaptcha_tree_secret_key = ambisn_get_setting('recaptcha_tree_secret_key');
    
    $sf_consent = ambisn_get_setting('sf_consent');
    
    if(isset($sf_consent) && $sf_consent == '1'){
        
        if(!isset($_REQUEST['consent_agreed']) || $_REQUEST['consent_agreed'] != '1'){
            
            $response['consent_error'] = true;
            
            echo json_encode($response);
            
            die;
            
        }
        
    }
    
    if(isset($recaptcha_tree) && $recaptcha_tree == '1'){
        
        if(!isset($_REQUEST['token']) || $_REQUEST['token'] == '' || !isset($recaptcha_tree_secret_key)){
            
            $response['notice'] = __("reCAPTCHA verification failed. Please try again.",'ambisn');
            
            echo json_encode($response);
            
            die;
            
        }else{
            
            $recaptcha_token = $_REQUEST['token'];
            
            $recaptcha_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_tree_secret_key}&response={$recaptcha_token}");
            
            $response_keys = json_decode($recaptcha_response, true);
            
            $recaptcha_success = $response_keys['success'];
            
            if(!$recaptcha_success){
                
                $response['notice'] = __("reCAPTCHA verification failed. Please try again.",'ambisn');
                
                $response['error'] = $response_keys;
                
                echo json_encode($response);
                
                die;
                
            }
            
        }
        
    }
    
    if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'admail_subscribe_nonce')) {
        
        $response['notice'] = __("Nonce verification failed. Please try again.","ambisn");
        
        echo json_encode($response);
        
        die;
        
    }elseif(isset($_REQUEST['email']) && isset($_REQUEST['productID'])){
        
	    $email = sanitize_email($_REQUEST['email']);
	    
	    $product_id = absint($_REQUEST['productID']);
	    
	    $product = wc_get_product($product_id);
	    
	    $notice = '';
	    
	    if($product){
	        
	        $_SESSION['nmuseremail'] = sanitize_email($email);
	    
	        if(ambisn_subscription_exists($email, $product_id)){
	        
	            $notice = ambisn_get_translated('form_previously_subscribed_notice');
	        
	        }elseif(filter_var($email, FILTER_VALIDATE_EMAIL) && is_int($product_id)) {
	            
	            $parent_id = $product->get_parent_id();
	        
                if($parent_id !== '0'){
                
                    update_post_meta($parent_id, 'wc_admail', true); 
                  
                }
                
                update_post_meta($product_id, 'wc_admail', true);
                
                $usersData = get_post_meta($product_id, 'wc_admail_data', true);
                
                ambisn_submit($product_id, $email, 'enabled', $usersData);
                    
                if(ambisn_get_setting('confirmation_email') == 1){
                        
                    ambisn_subscription_confirmation_email($product_id, $email);
                        
                }
                
                if(ambisn_get_setting('store_confirmation_email') == 1){
                        
                    ambisn_store_subscription_confirmation_email($product_id, $email);
                        
                }                
	            
            }
            
            if(isset($_REQUEST['shortcode']) && sanitize_text_field($_REQUEST['shortcode']) === 'true'){
                
                ob_start();
                
                echo '<div class="ambisn-outer-container shortcode" data-value="'.esc_attr($product_id).'">';
            
                if(is_ambisn_subscribed($email, $product_id)){
                
                    $status = 'subscribed';
                    
                    $shortcode = true;
                
                    include(AMBISN_PATH.'includes/blocks/subscribed_form.php');
                    
                }else{
                    
                    $shortcode = true;
                
                    include(AMBISN_PATH.'includes/blocks/subscription_form.php');   
                
                }
            
                echo '</div>';
                
                $response["sform_html"] = ob_get_clean();
                
            }else{
            
                $subscription_form = new AmbisnSubscriptionForm;
            
                ob_start();
                
                $subscription_form->print_subscription_form($product_id , $notice);  
            
                $response["sform_html"] = ob_get_clean();
            
            }
	        
	    }
	    
	    if($popup_set == 1){
        
            $response['popup'] = true;
            
            if(is_ambisn_subscribed($email, $product_id)){
                
                $response['s_status'] = 'subscribed';
                
            }else{
                
                $response['s_status'] = 'unsubscribed';
                
            }
        
        }
        
	    echo json_encode($response);
	    
	    die();
    }
}

add_action('wp_ajax_ajax_ambisn_subscribe','ajax_ambisn_subscribe');
add_action('wp_ajax_nopriv_ajax_ambisn_subscribe','ajax_ambisn_subscribe');

//Subscription confirmation Email

function ambisn_subscription_confirmation_email($product_id, $email){
    
    global $post;
    
    $product = wc_get_product($product_id);
    
    if($product){
    
        $domain_name = sanitize_text_field($_SERVER['SERVER_NAME']);
    
        $no_reply = ambisn_get_setting('conf_no_reply');
    
        $store_email = ambisn_get_setting("store_email");
        
        if($no_reply == '1'){
            
            $from = 'no-reply';
            
        }
    
        elseif(empty($store_email)){
            
            $from = 'marketing';
            
        }else{
            
            $from = $store_email;
            
        }
        
        $subject = ambisn_get_translated("conf_email_subject");
    
        if(empty($subject)){
            
            $subject = 'The product you subscribed for is back in stock';
            
        }
        
        ob_start();
                    
        include_once (AMBISN_PATH.'includes/mail_templates/conf_email_template.php');
                    
        $message =  ob_get_clean();
        
        $headers = 'From: ' . ambisn_get_setting("store_name") . ' <' . $from . '@' . $domain_name . '>' . "\r\n";
        
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    
        $headers .= 'MIME-Version: 1.0' . "\r\n";

        wp_mail($email, $subject, $message, $headers);
    } 
}

//Store subscription confirmation email

function ambisn_store_subscription_confirmation_email($product_id, $user_email){
    global $post;
    
    $product = wc_get_product($product_id);
    
    $email = sanitize_email(ambisn_get_setting('store_conf_email_recipient'));
    
    if($product && !empty($email) && is_email($email)){
        
        $domain_name = sanitize_text_field($_SERVER['SERVER_NAME']);
        
        $from = 'no-reply';
        
        $subject = 'AdMail - New Subscription Alert';
        
        ob_start();
                    
        include_once (AMBISN_PATH.'includes/mail_templates/store_conf_email_template.php');
                    
        $message =  ob_get_clean();
        
        $headers = 'From: ' . ambisn_get_setting("store_name") . ' <' . $from . '@' . $domain_name . '>' . "\r\n";
        
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";

        wp_mail($email, $subject, $message, $headers);
    } 
}

//Unsubscribe - Ajax

function ajax_ambisn_ajax_unsubscribe(){
    
    $response = array();
    
    $popup_set = ambisn_get_setting('popup');
    
    if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'admail_unsubscribe_nonce')) {
        
        $response['notice'] = "Nonce verification failed. Please try again.";
        
        echo json_encode($response);
        
        die;
        
    }elseif(isset($_REQUEST['productID'])){
        
        $product_id = absint($_REQUEST['productID']);
        
        if(is_int($product_id)) {
            
            $product = wc_get_product($product_id);
            
            $email = '';
            
            if($product){
                
                ambisn_unsubscribe_form($product_id, AMBISN_SESSION_ID);
                
                if(isset($_REQUEST['shortcode']) && sanitize_text_field($_REQUEST['shortcode']) === 'true'){
                
                    ob_start();
                
                    echo '<div class="ambisn-outer-container shortcode" data-value="'.esc_attr($product_id).'">';
            
                    if(is_ambisn_subscribed($email, $product_id)){
                
                        $status = 'subscribed';
                    
                        $shortcode = true;
                
                        include(AMBISN_PATH.'includes/blocks/subscribed_form.php');
                    
                    }else{
                    
                        $shortcode = true;
                    
                        include(AMBISN_PATH.'includes/blocks/subscription_form.php');   
                
                    }
            
                    echo '</div>';
                
                    $response["sform_html"] = ob_get_clean();
                
                }elseif(isset($_REQUEST['sTab']) && $_REQUEST['sTab'] == '1'){
                    
                    $response['success'] = true;
                    
                    $admail = new AmbisnSubscriptions;

                    $subscriptions = $admail->get_filtered_subscriptions('single-user-subscriptions');
                    
                    if(empty($subscriptions)){
                        
                        ob_start();
                        
                        include_once(AMBISN_PATH.'includes/tabs/frontend_wc_subscriptions_tab.php');
                        
                        $response['empty_html'] = ob_get_clean();
                        
                    }
                    
                }else{
                
                    $subscription_form = new AmbisnSubscriptionForm;
                
                    ob_start();
                
                    $subscription_form->print_subscription_form($product_id , '');  
            
                    $response["sform_html"] = ob_get_clean();
                }
                
            }
        }
        
        if($popup_set == 1){
        
            $response['popup'] = true;
            
            if(is_ambisn_subscribed($email, $product_id)){
                
                $response['s_status'] = 'subscribed';
                
            }else{
                
                $response['s_status'] = 'unsubscribed';
                
            }
        
        }
        
        echo json_encode($response);
        
        die();
    }
}
add_action('wp_ajax_ajax_ambisn_unsubscribe','ajax_ambisn_ajax_unsubscribe');
add_action('wp_ajax_nopriv_ajax_ambisn_unsubscribe','ajax_ambisn_ajax_unsubscribe');


//function to update database

function ambisn_submit($product_id, $email, $status, $usersData){
    
    $date = date('Y-m-d H:i:s');
    
    if (isset(get_post_meta($product_id, 'wc_admail_data')[0])){
        
        $productSubscriptions = get_post_meta($product_id, 'wc_admail_data')[0];
        
    }else{
        
        $productSubscriptions = array();
        
    }
    
    if(!is_ambisn_subscribed($email, $product_id)){
        
        $newItem = array();
        
        $newItem = array('status'=>'enabled','sessionID'=>AMBISN_SESSION_ID, 'lang' => get_locale() ,'date' => $date,);
    
        if(!is_array($productSubscriptions)){
            
            $productSubscriptions = array();
            
        }
        
        $productSubscriptions[$email] = $newItem;
        
        update_post_meta($product_id, 'wc_admail_data', $productSubscriptions);
        
        $subscriptionCount = intval(get_post_meta($product_id, 'wc_admail_count', true));
        
        $subscribersCount = intval(ambisn_get_data('subscribers_count', $date));
        
        if (!is_int($subscribersCount)) {
            
            $subscribersCount = 0;
            
        }
        if (!is_int($subscriptionCount)) {
            
            $subscriptionCount = 0;
            
        }         
        ambisn_update_data('subscribers_count', $subscribersCount + 1 );
        
        update_post_meta($product_id, 'wc_admail_count', $subscriptionCount + 1);
    }
    
    //Collect Emails By Product
    
    $subscribers = get_post_meta($product_id, 'wc_admail_subscribers', true);
    
    if(!is_array($subscribers)){
        
        $subscribers = array();
    }    
    if (!in_array($email, array_keys($subscribers))){
        
       $subscribers[$email] = AMBISN_SESSION_ID;
       
       update_post_meta($product_id, 'wc_admail_subscribers', $subscribers);
       
    }
    
    //Collect Emails By Date and update subscribers count
    
    $collectedEmails = ambisn_collected_emails('emails', 'all');
    
    if(!in_array($email, $collectedEmails)){
        
        $todaysEmails = ambisn_collected_emails('emails', $date);
        
        $todaysEmails[] = $email;
        
        $updatedEmails = implode(',',Array_filter($todaysEmails));
        
        ambisn_update_data('emails', $updatedEmails);
        
    }
}


//Prepare ajax data for action

function ambisn_ajax_subscription($action, $dataArray){
    
    foreach($dataArray as $dataItem){
        
        $action = $dataItem['action'];
        
        $product_id = $dataItem['productID'];
        
        $email = $dataItem['email'];
        
        $productSubscribers = get_post_meta($product_id, 'wc_admail_data', true);
        
	     if($action == "delete"){
	              
	        unset($productSubscribers[$email]);
	             
	        update_post_meta( $product_id, 'wc_admail_data', $productSubscribers);
	             
	        if(empty(get_post_meta( $product_id, 'wc_admail_data', true ))){
	                 
	           delete_post_meta( $product_id, 'wc_admail'); 
	                
	        }
	        
	     }elseif($action == "sent"){
	              
	         ambisn_mail($email , $product_id);
	            
	     }else{
	              
	        if (isset($productSubscribers[$email]['status'])){
                        
                $productSubscribers[$email]['status'] = $action;
                        
            }
            
            update_post_meta($product_id, 'wc_admail_data', $productSubscribers);
        
        }
    }    
     
}

//Manage subscription - Ajax

function ambisn_ajax_manage_subscription($action){
    
	if(isset($_REQUEST['dataArray'])){
	    
	    $data_array = json_decode(wp_unslash($_REQUEST['dataArray']), true);
	    
	    if(is_array($data_array)){
	        
	        ambisn_ajax_subscription($action, $data_array);
	        
	    }
	}
	
	die();
}

add_action('wp_ajax_ambisn_manage_subscription','ambisn_ajax_manage_subscription');


//Save Settings with Ajax

function ambisn_save_settings($action){
    
    $response = array();
    
	if(isset($_REQUEST)){
	    
	    $settings = json_decode(stripslashes(sanitize_text_field($_REQUEST['settingsData'])), true);
	  
	    foreach($settings as $attr=>$value){
	      
	        if($attr == 'social_icons'){
	          
	          if(!is_array($value)){
	              
	              $value = array();
	              
	          }
	          
	          $value = serialize($value);
	          
	       }
	      
	        ambisn_update_setting($attr , $value);
	    }
	    ob_start();
	    
	    $preview = true;
	    
        include_once (AMBISN_PATH.'includes/mail_templates/conf_email_template.php');
        
        $response['ctp_html'] = ob_get_clean();	    
        
	    ob_start();
	    
        include_once (AMBISN_PATH.'includes/template_preview.php');
        
        $response['tp_html'] = ob_get_clean();
        
        echo json_encode($response);
        
        $display_wc_subscriptions_tab = ambisn_get_setting('ps_tab');
        
        if($display_wc_subscriptions_tab == '1'){
    
            add_rewrite_endpoint('product-subscriptions', EP_ROOT | EP_PAGES);
        
        }
        
        flush_rewrite_rules();
	  
        die();
	}
}

add_action('wp_ajax_ajax_ambisn_settings','ambisn_save_settings');

//Send emails

function ambisn_mail($email, $product_id){
    
    global $post;
    
    $product = wc_get_product($product_id);
    
    if($product->is_in_stock()){
        
        $usersData = get_post_meta($product_id, 'wc_admail_data', true);
        
        $lang_switched = false;
        
        if(isset($usersData[$email]['lang'])){
            
            $usersLang = $usersData[$email]['lang'];
            
            if($usersLang != '' && $usersLang != get_locale()){
                
                $language_code = $usersData[$email]['lang'];
            
                switch_to_locale($language_code);
            
                $lang_switched = true;
                
            }
            
        }
        
        require_once (AMBISN_PATH.'includes/mail_templates/email_parent_template.php');
        
        $domain_name = sanitize_text_field($_SERVER['SERVER_NAME']);
        
        $no_reply = ambisn_get_setting('no_reply');
        
        $store_email = ambisn_get_setting("store_email");
        
        if($no_reply == '1'){
            
            $from = 'no-reply';
            
        }elseif(empty($store_email)){
            
            $from = 'marketing';
            
        }else{
            
            $from = $store_email;
            
        }
        
        $subject = ambisn_get_translated("email_subject");
        
        if(empty($subject)){
            
            $subject = 'The product you subscribed for is back in stock';
            
        }
        
        $message =  ambisn_mail_template($product_id);
        
        $headers = 'From: ' . ambisn_get_setting("store_name") . ' <' . $from . '@' . $domain_name . '>' . "\r\n";
        
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        
        $headers .= 'MIME-Version: 1.0' . "\r\n";

        wp_mail($email, $subject, $message, $headers);
        
        
        if($lang_switched){
            
            restore_previous_locale();
            
        }
        
        $usersData[$email]['status'] = 'sent';
        
        update_post_meta($product_id, 'wc_admail_data', $usersData);
        
        $notificationSent = ambisn_get_data('notification_sent', date('Y-m-d')) + 1;
        
        ambisn_update_data('notification_sent', $notificationSent);
        
    }
    
}

//Check if auto submission setting is enabled

if(ambisn_get_setting('auto_submission') == "1"){
    
    add_action( 'woocommerce_update_product', 'ambisn_auto_send_notices', 10, 1 );
    
    function ambisn_auto_send_notices($product_id) {
        
        $product = wc_get_product($product_id);
        
        $product_ids = array();
        
        $product_ids[] = $product_id;
        
        if($product->is_type('variable')){
            
            $variations_id = $product->get_children();
            
            foreach($variations_id as $variation_id){
                
                $product_ids[]= $variation_id;
                
            }
        }
        
        foreach($product_ids as $product_id){
            
            $subscribers = get_post_meta($product_id, 'wc_admail_data', true);
            
            foreach($subscribers as $email=>$data){
                
                if( $data['status']== 'enabled'){
                    
                    ambisn_mail($email, $product_id);
                    
                }
            }
        }
    }
}

//Create date range

function ambisn_dateRange($nbDays){
    
    $begin = new DateTime();
    
    $begin->sub(new DateInterval('P'.$nbDays.'D'));
    
    $end = new DateTime('tomorrow');

    $interval = new DateInterval('P1D');
    
    $dateRange = new DatePeriod($begin, $interval, $end);

    $range = [];
    
    return $dateRange;
    
    foreach ($dateRange as $date) {
        
        $date = $date->format('Y-m-d');
        
    }
}


function ambisn_get_products(){
    $args = array(
        'meta_key' => 'wc_admail',
        'meta_value' => '1',
        //'order' => 'DESC',
        'limit' => -1,
    );
    $mwproducts = wc_get_products($args);
    $ambisn_products = array();
    foreach($mwproducts as $product){
        $product_id = $product->get_id();
        $subscribersCount = get_post_meta($product_id, 'wc_admail_count', true);
        if($product->is_type('variable')){
            $subscribersCountParent = get_post_meta($product_id, 'wc_admail_count', true);
            $ambisn_enabled = get_post_meta($product_id, 'wc_admail', true);
            if($subscribersCountParent > 0 ){
                $ambisn_products[$product_id]= $subscribersCountParent;
            }
            if($ambisn_enabled == 1){
                $variations_id = $product->get_children();
                foreach($variations_id as $variation_id){
                    $subscribersCount = get_post_meta($variation_id, 'wc_admail_count', true);
                    if($subscribersCount > 0 ){
                        $ambisn_products[$variation_id]= $subscribersCount;
                    }
                }
            }
        }
        else{
            if($subscribersCount > 0 ){
                $ambisn_products[$product_id]= $subscribersCount; 
            }
        }
    }
    arsort($ambisn_products);
    return $ambisn_products;
}


function ambisn_get_subscriptions($filter){
    $ambisn_products = ambisn_get_products();
    $ambisn_product_ids = array_keys($ambisn_products);
    $subscriptions_data = array();
                
    foreach($ambisn_product_ids as $product_id){
        $productSubscribers = get_post_meta($product_id, 'wc_admail_data');
        $filtredData = array();
        $product = wc_get_product($product_id);
        foreach($productSubscribers as $subscriber){
            foreach($subscriber as $email=>$data){
                if($data['status'] == 'enabled' && $product->is_in_stock() && $filter == 'instock'){
                    $filtredData[$email] = 'instock';
                }
                elseif($data['status'] == 'enabled' && !$product->is_in_stock() && $filter == 'ofs'){
                    $filtredData[$email] = 'ofs';
                }
                elseif($data['status'] == $filter){
                    $filtredData[$email] = $data['status'];
                }                
            }
        }
        $subscriptions_data[$product_id] = $filtredData;
    }
    return $subscriptions_data;
}

function ambisn_get_products_by_email($email_input){
    $ambisn_products = ambisn_get_products();
    $ambisn_product_ids = array_keys($ambisn_products);
    $products_by_email = array();            
    foreach($ambisn_product_ids as $product_id){
        $productSubscribers = get_post_meta($product_id, 'wc_admail_data');
        foreach($productSubscribers as $subscriber){
            foreach($subscriber as $email=>$data){
                if($email == $email_input){
                    $products_by_email[] = $product_id;
                }
            }
        }
    }
    return $products_by_email;
}

function ambisn_search_product() {
    
    $response = array();
    
    if(isset($_REQUEST['inputName']) && isset($_REQUEST['tab'])){
        
        $inputName = sanitize_text_field($_REQUEST['inputName']);
        
        $tab = sanitize_text_field($_REQUEST['tab']);
        
        $args = array(
        
            'limit' => 100,
            's' => $inputName,
        );

        $wc_products = wc_get_products($args);
    
        if ($wc_products && is_array($wc_products)) {

            $product_ids = array();

            foreach ($wc_products as $product) {

                $product_ids[] = $product->get_id();

                if ($product->is_type('variable')) {

                    $variation_ids = $product->get_children();
                
                    $product_ids = array_merge($product_ids, $variation_ids);
                
                }
            }

            $product_ids = array_unique($product_ids);
        
            $subscritions_items = ambisn_get_subscriptions_by_product($tab, $product_ids);
        
            if(count($subscritions_items) > 0 ){
                
                ob_start();
            
                ambisn_table_rows($subscritions_items, 1000, 1, $tab);
                
                $response['table'] = ob_get_clean();
            
            }else{
                
                ob_start();
            
                ambisn_emptyResults();
                
                $response['empty'] = ob_get_clean();
            
            }
        
        }else{
            
            ob_start();
            
            ambisn_emptyResults();
                
            $response['empty'] = ob_get_clean();
            
        }
        
    }else{
        
        $response['alert'] = 'Something went wrong. Please try again later!';
        
    }
    
    echo json_encode($response);
    die();
}

add_action('wp_ajax_ambisn_search_product', 'ambisn_search_product');

function admail_subscription_form(){
    
    global $product;
    
    if($product && !$product->is_in_stock()){
        
        $product_id = $product->get_id();
        
        $email = '';
        
        if(!$product->is_in_stock()){
            
            echo '<div class="ambisn-outer-container shortcode" data-value="'.esc_attr($product_id).'">';
            
            if(is_ambisn_subscribed($email, $product_id)){
                
                $status = 'subscribed';
                
                $shortcode = true;
                
                include(AMBISN_PATH.'includes/blocks/subscribed_form.php');
                
            }else{
                
                $shortcode = true;
                
                include(AMBISN_PATH.'includes/blocks/subscription_form.php');   
                
            }
            
            echo '</div>';
            
        }
    }
}

add_shortcode('admail_subscription_form','admail_subscription_form');



function ambisn_product_subscriptions_query_vars($vars) {
    
    $vars[] = 'product-subscriptions';
    
    return $vars;
    
}

function ambisn_add_product_subscriptions_link_my_account($items) {
    
    $new_items = array_slice($items, 0, 2, true);
    
    $new_items['product-subscriptions'] = __('Product Subscriptions', 'ambisn');
    
    $new_items = array_merge($new_items, array_slice($items, 2, null, true));
    
    return $new_items;
}

function ambisn_product_subscriptions_content() {
    
    include(AMBISN_PATH.'includes/tabs/frontend_wc_subscriptions_tab.php');
    
}

function ambisn_manage_product_subscriptions_tab() {
    
    $display_tab = ambisn_get_setting('ps_tab');

    if ($display_tab == '1') {
        
        add_filter('query_vars', 'ambisn_product_subscriptions_query_vars', 0);
        add_filter('woocommerce_account_menu_items', 'ambisn_add_product_subscriptions_link_my_account');
        add_action('woocommerce_account_product-subscriptions_endpoint', 'ambisn_product_subscriptions_content');
        
    }
}
ambisn_manage_product_subscriptions_tab();

function admail_product_subscriptions_page(){
    
    echo '<div class="woocommerce-MyAccount-content">';
    
    include(AMBISN_PATH.'includes/tabs/frontend_wc_subscriptions_tab.php');
    
    echo '</div>';
    
}
add_shortcode('admail_product_subscriptions_page','admail_product_subscriptions_page');

function ambisn_handle_product_meta_on_insert( $post_id, $post, $update ) {
    
    $prevent_dupl_subscriptions = ambisn_get_setting('prevent_dupl_subscriptions');
    
    if($prevent_dupl_subscriptions == '0'){
        
        return;
        
    }
    
    if ( 'product' !== $post->post_type ) {
        
        return;
        
    }

    $admail_data = get_post_meta( $post_id, 'wc_admail_data', true );

    if ( !empty($admail_data) ) {
        
        $admail_data_serialized = serialize( $admail_data );

        $existing_products = get_posts( array(
            'post_type'  => 'product',
            'meta_key'   => 'wc_admail_data',
            'meta_value' => $admail_data_serialized,
            'post__not_in' => array( $post_id ),
            'fields'     => 'ids',
            'posts_per_page' => -1
        ) );

        if ( !empty($existing_products) ) {
            
            delete_post_meta( $post_id, 'wc_admail' );
            
            delete_post_meta( $post_id, 'wc_admail_data' );
            
            delete_post_meta( $post_id, 'wc_admail_count' );
            
        }
    }
}

add_action( 'wp_insert_post', 'ambisn_handle_product_meta_on_insert', 10, 3 );

function ambisn_define_subscriptions_language($product_id) {

    $admail_data = get_post_meta($product_id, 'wc_admail_data', true);
    
    $product = wc_get_product($product_id);
    
    $products_to_be_fixed = array();
    
    if (!empty($admail_data)) {
    
        $products_to_be_fixed[] = $product_id;
    
    }
            
    if ($product && 'variable' === $product->get_type()) {
        
        $variation_ids = array_map(function($variation) { 
            
            return $variation['variation_id']; 
            
        },$product->get_available_variations());

        foreach ($variation_ids as $variation_id) {
            
            $variation_meta = get_post_meta($variation_id, 'wc_admail_data', true);

            if (!empty($variation_meta)) {
                
                $products_to_be_fixed[] = $variation_id;
                
            }
        }
    } 

    $fixed_products = get_option('ambisn_lang_fixed_products', array());

    if (!in_array($product_id, $fixed_products)) {
            
        foreach($products_to_be_fixed as $to_fix_product_id) {
            
            $this_product_data = get_post_meta($to_fix_product_id, 'wc_admail_data', true);
            
            $update_meta = false;

            foreach ($this_product_data as &$single_subscription) {
                
                if (empty($single_subscription['lang'])) {
                    
                    $single_subscription['lang'] = get_locale();
                    
                    $update_meta = true;
                    
                }
            }

            if ($update_meta) {
                
                update_post_meta($to_fix_product_id, 'wc_admail_data', $this_product_data);
                
            }
        }
        
        $fixed_products[] = $product_id;
        
        update_option('ambisn_lang_fixed_products', $fixed_products);
                    
    }
        
}

