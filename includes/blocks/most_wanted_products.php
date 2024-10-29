<?php

if (!defined('ABSPATH')) {
    exit;
}

$admail = new AmbisnSubscriptions;

$admail_products = $admail->get_products();

if(!is_array($admail_products)){
    
    $admail_products = array();
    
}

$subscription_counts = array();

foreach($admail_products as $product_id){
    
    $subscriptions = get_post_meta($product_id, 'wc_admail_data')[0];
    
    $count = get_post_meta($product_id, 'wc_admail_count', true);
    
    if($count > 0){
        
        $subscription_counts[$product_id] = $count;
        
    }
    
}

arsort($subscription_counts);

if(!isset($limit)){
    
    $limit = 3;
    
}

$order = 0;

if( ambisn_empty_data() ){
    
    $random_products = wc_get_products(array(
        'orderby' => 'rand',
        'limit' => 3,
        'status' => 'publish'
    ));
    
    $count_numbers = array(76,45,30);
    $count = 0;
    if ($random_products) {
        $result_array = array();
        foreach ($random_products as $product) {
            $result_array[$product->get_id()] = $count_numbers[$count];
            $count++;
        }
        $subscription_counts = $result_array;
    }else{
        $subscription_counts = array();
    }
    
}

foreach(array_slice($subscription_counts, 0, $limit, true) as $product_id => $count){
    
    $product = wc_get_product($product_id);
    
    if($product){
        
        $is_variation = false;
        
        if($product->get_parent_id() != 0){
            
            $is_variation = true;
            
        }
        
        $url = $product->get_permalink();
        
        $image = wp_get_attachment_url( $product->get_image_id());
        
        if(empty($image)){
            
            $image = AMBISN_URL.'assets/images/no_image.png';
            
        }        
        
        $label = '';
        
        $count_text = $count.'<span> subscribers</span>';
        
        if($count === 1){
            
            $count.'<span> subscriber</span>';
            
        }
        
        if($is_variation){
            
            $name = $product->get_name();
            
            $label = ' -variation-';
            
        }else{
            
            $name = $product->get_title();
            
        }
        
        $stock_status = 'In stock';
        
        if (!$product->is_in_stock()){
            
            $stock_status = 'Out of stock';  
            
        }
        
        $order++;
        
        ?>
        <div class="ambisn-most-wanted order<?php echo esc_attr($order); ?>">
            <h3>#<?php echo esc_html($order); ?></h3>
            <img width="60px" src="<?php echo esc_url($image); ?>">
            <div class="product">
                <h3><?php echo esc_html($name); ?></h3>
                <p>ID: <?php echo esc_html($product_id.$label); ?></p>
            </div>
            <p><?php echo wp_kses_post($count_text); ?></p>
            <p class="stock-status"><?php echo esc_html($stock_status); ?></p>
            <a href="<?php echo esc_url($url); ?>">View</a>
        </div>
        <?php        
        
    }
            
}