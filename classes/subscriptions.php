<?php

if (!defined('ABSPATH')) {
    exit;
}
    
class AmbisnSubscriptions{

    public function get_products($email = '') {
        
        $product_ids = array();
        
        $args = array(
            'meta_key' => 'wc_admail',
            'meta_value' => '1',
            'limit' => -1,
        );
        
        if (function_exists('wc_get_products') && is_array(wc_get_products($args))) {

            $products = wc_get_products($args);
            
            foreach($products as $product){
                
                $product_id = $product->get_id();
                
                $productSubscribers = array();
                
                if(isset(get_post_meta($product_id, 'wc_admail_data')[0])){
                    
                    $productSubscribers = get_post_meta($product_id, 'wc_admail_data')[0];
                    
                }
                
                
                
                $subscribersCount = 0;
                
                if(is_array($productSubscribers)){
                    
                    $subscribersCount = count($productSubscribers);   
                    
                }
                
                if($product->is_type('variable')){
                    
                    $subscribersCountParent = get_post_meta($product_id, 'wc_admail_count', true);
                    
                    $ambisn_enabled = get_post_meta($product_id, 'wc_admail', true);
                    
                    if($subscribersCountParent > 0 ){
                        
                        $product_ids[] = $product_id;
                        
                    }
                    if($ambisn_enabled == 1){
                        
                        $variation_ids = $product->get_children();
                        
                        foreach($variation_ids as $variation_id){
                            
                            $variationSubscribers = array();
                            
                            if(isset(get_post_meta($variation_id, 'wc_admail_data')[0])){
                                
                                $variationSubscribers = get_post_meta($variation_id, 'wc_admail_data')[0];   
                                
                            }
                            
                            $subscribersCount = 0;
                
                            if(is_array($variationSubscribers)){
                    
                                $subscribersCount = count($variationSubscribers);   
                    
                            }                            
                            
                            if($subscribersCount > 0 ){
                                
                                $product_ids[] = $variation_id;
                                
                            }
                        }
                    }
                }
                else{
                    
                    if($subscribersCount > 0 ){
                        
                        $product_ids[] = $product_id;
                        
                    }
                }                
                
            }
            
            if($email != ''){
                
                $email_product_ids = array();
                
                foreach($product_ids as $product_id){
                    
                    $productSubscribers = array();
                
                    if(isset(get_post_meta($product_id, 'wc_admail_data')[0])){
                    
                        $productSubscribers = get_post_meta($product_id, 'wc_admail_data')[0];
                    
                    }
            
                    if(is_array($productSubscribers)){
                
                        $product_emails = array_keys($productSubscribers );
                        
                        if(in_array($email, $product_emails)){
                            
                            $email_product_ids[] = $product_id;
                            
                        }
                
                    }
                    
                    
                }
                
                return array_unique($email_product_ids);
                
            }
            
        }
        
        return $product_ids;

    }
    
    public function get_subscriptions($product_id = "") {
        
        $subscriptions = array();
        
        $ambisn_product_ids = $this->get_products();
        
        if ($product_id !== "") {
            
            $product = wc_get_product($product_id);

            if ($product) {
                
                $ambisn_product_ids = array($product);
                
            }
        }
        
        if(!is_array($ambisn_product_ids)){
            
            $ambisn_product_ids = array();
            
        }        
        
        foreach($ambisn_product_ids as $product_id){
            
            $productSubscribers = get_post_meta($product_id, 'wc_admail_data');
            
            if(is_array($productSubscribers)){
                
                foreach($productSubscribers as $subscriber){
                    
                    foreach($subscriber as $email=>$data){
                        
                        if(is_user_logged_in()){
                    
                            $current_user = wp_get_current_user();
                    
                            $user_email = $current_user->user_email;

                            if(isset($user_email) && ($user_email != "")){
                        
                                $session_id = ambisn_set_session_cookie();
                            
                                if($data['sessionID'] == $session_id){
                            
                                    $subscriptions[$user_email][] = $product_id;
                            
                                }

                            }
                    
                        }                        
                        
                        if(isset($subscriptions[$email])){
                            
                            if(is_array($subscriptions[$email]) && !in_array($product_id, $subscriptions[$email])){
                                
                                $subscriptions[$email][] = $product_id;
                            
                            }
                            
                        }else{
                            
                            $subscriptions[$email] = array($product_id);
                            
                        }
                            
                    }
                    
                }
                
            }
            
        }
        
        return $subscriptions;

    }
    
    public function get_subscription_data($email, $product_id){
        
        $productSubscribers = get_post_meta($product_id, 'wc_admail_data');
        
        $subscription_data = array();
        
        if(array_key_exists($email, $productSubscribers[0])){
            
            $subscription_data = $productSubscribers[0][$email];
            
            if(!is_array($subscription_data)){
                
                $subscription_data = array();
                
            }
            
        }
        
        return $subscription_data;
        
    }
    
    public function get_filtered_subscriptions($filter = ''){
        
        $subscriptions = $this->get_subscriptions();
        
        $modified_subscriptions = array();

        foreach($subscriptions as $email=>$product_ids){
    
            foreach($product_ids as $product_id){
        
                $subscription_item = array();
                
                $subscription_item['email'] = $email;
                
                if(isset($this->get_subscription_data($email, $product_id)['lang'])){
                    
                    $subscription_item['lang'] = $this->get_subscription_data($email, $product_id)['lang'];
                    
                }
                
                $subscription_item['product_id'] = $product_id;
                
                $subscription_item['date'] = $this->get_subscription_data($email, $product_id)['date'];
                
                $modified_subscriptions[] = $subscription_item;
        
            }
    
        }
        
        usort($modified_subscriptions, function ($a, $b) {
    
            return strtotime($b['date']) - strtotime($a['date']);
    
        });
        
        if($filter === ""){
            
            return $modified_subscriptions;
            
        }
        
        $subscription_items = array();
        
        foreach($modified_subscriptions as $subscription_item){
            
            $product_id = $subscription_item['product_id'];
            
            $email = $subscription_item['email'];
            
            $date = $subscription_item['date'];
            
            $status = $this->get_subscription_data($email, $product_id)['status'];
            
            $product = wc_get_product($product_id);
            
            if($product){
                
                if($filter == 'single-user-subscriptions' && is_user_logged_in()){
                    
                        $current_user = wp_get_current_user();
                    
                        $user_email = $current_user->user_email;

                        if(isset($user_email) && ($user_email != "") && ($user_email == $email)){
                            
                            $subscription_item['status'] = $status;
                        
                            $subscription_items[] = $subscription_item;

                        }
                    
                }
                
                elseif($status == 'enabled'){
                    
                    if($product->is_in_stock() && $filter == "instock"){
                        
                        $subscription_items[] = $subscription_item;
                    
                    }elseif(!$product->is_in_stock() && $filter == "ofs"){
                        
                        $subscription_items[] = $subscription_item;
                        
                    }
                
                }elseif($status == $filter){
                    
                    $subscription_items[] = $subscription_item;
                    
                }
                
            }
        
        }
        
        return $subscription_items;
        
    }

    public function get_emails($date = "all"){
        
        if($date == "all"){
            
            $email_lists = ambisn_get_data('emails', $date);
            
        }else{
            
            $email_lists = array(ambisn_get_data('emails', $date));
            
        }
        
        $emails = array();
        
        if(is_array($email_lists)){
            
            foreach($email_lists as $list){
            
                $list_emails = array_filter(explode(',',$list));
                
                $emails = array_merge($emails, $list_emails);
            
            }
        }
        
        return $emails;
        
    }    
    
    
    
    public function get_chart_html($column){
    
        $dateRange = ambisn_dateRange(7);
    
        $values = array();
    
        foreach ($dateRange as $date) {
        
            $date = $date->format('Y-m-d');
        
            if ($column == 'collected_emails') {
                
                if(ambisn_empty_data()){
                    
                    $values[] = rand(0, 99);
                    
                }else{
                    
                    $emails = $this->get_emails($date);
                    
                    $values[] = count($emails);
                    
                }
            
               
            
            } else {
                
                if(ambisn_empty_data()){
                    
                    $values[] = rand(0, 99);
                    
                }else{
            
                    $value = intval(ambisn_get_data($column, $date));
            
                    if(empty($value)){
                
                        $value = 0;
                
                    }
                    $values[] = $value;
                
                }
            }
        
        }
        
        $maxValue = max($values);
        
        $chartIndex = ($maxValue != 0) ? 100 / $maxValue : 0;
        
        ob_start();
    
        foreach ($dateRange as $date) {
        
            $dayName = $date->format('D');
        
            $date = $date->format('Y-m-d');
            
            if ($column == 'collected_emails') {
                
                if(ambisn_empty_data()){
                    
                    $value = rand(0, 99);
                    
                }else{
            
                    $value = count($this->get_emails($date));
                
                }
            
            } else {
                
                if(ambisn_empty_data()){
            
                    $value = rand(0, 99);
                
                }else{
                    
                    $value = ambisn_get_data($column, $date);
                    
                }
            
            }
        
            if (empty($value)) {
            
                $value = '0';
            
            }
        
            $chartHeight = $value * $chartIndex;
        
            ?>
            
            <div class="chart-element-container">
                <div style="height:<?php echo esc_attr($chartHeight); ?>%;" class="chart-element"><span><?php echo esc_html($value); ?></span></div>
                <span><?php echo esc_html($dayName); ?></span>
            </div>
            
            <?php
        }
        
        return ob_get_clean();
    
    }    
   
}
