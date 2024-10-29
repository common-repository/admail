<?php

if (!defined('ABSPATH')) {
    exit;
}

$admail = new AmbisnSubscriptions;

$subscriptions = $admail->get_filtered_subscriptions('single-user-subscriptions');

if(empty($subscriptions)){
    
    echo '<div class="woocommerce-info">';
    
    	echo wp_kses_post(ambisn_get_translated('ps_tab_empty_notice'));
    	
    	$shop_page_url = wc_get_page_permalink( 'shop' );
    	
    	if(!empty($shop_page_url)){
    	    
    	   echo '<a class="button wc-forward" href="'.esc_url($shop_page_url).'">'.__('Browse products','ambisn').'</a>';
    	        	
    	}
    	
    echo '</div>';
    
}else{
    
    $admin_url = admin_url();
    
    wp_enqueue_script( 'ambisn_scripts', AMBISN_URL. 'assets/js/scripts.js' , array('jquery'), date("h:i:s") );
    
    wp_localize_script( 'ambisn_scripts', 'ambisn_script_vars', array('admin_url' => $admin_url));
    
    ?>
    
<table class="woocommerce-cart-form admail-subscriptions">
    <thead>
        <tr>
            <th class="product-thumbnail"><?php echo esc_attr(__('Thumbnail','ambisn')); ?></th>
            <th class="product-name"><?php echo esc_attr(__('Product Name','ambisn')); ?></th>
            <th class="product-status"><?php echo esc_attr(__('Status','ambisn')); ?></th>
            <th class="product-remove"><?php echo esc_attr(__('Remove','ambisn')); ?></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
        
        foreach($subscriptions as $subscription){
            
            if(isset($subscription['product_id'])){
                
                $product_id = $subscription['product_id'];
                
                $product = wc_get_product( $product_id );
                
                $parent_id = $product->get_parent_id();
                
                if($parent_id == '0'){
                    
                    $image = wp_get_attachment_url( $product->get_image_id());
                    
                    $product_url = $product->get_permalink();
                    
                    $name = $product->get_title();
                    
                }else{
                    
                    $variation = wc_get_product($product_id);
                    
                    $product_url = $variation->get_permalink();
                    
                    $name = $variation->get_name();
                    
                    $product_id.= ' -variation-';
                    
                    $image = wp_get_attachment_url( $variation->get_image_id()); 
                }
                if(isset($subscription['status']) && $subscription['status'] == 'sent'){
                    
                    $status = __('Email sent','ambisn');
                    
                }elseif($product->is_in_stock()){
                    
                    $status = __('Available','ambisn');
                    
                }else{
                    
                    $status = __('Out of stock','ambisn');
                }
                ?>
                
                <tr>
                    <td class="product-thumbnail">
                        <a href="<?php echo esc_url($product_url); ?>">
                            <img src="<?php echo esc_url($image); ?>" alt="Product Thumbnail" width="100" height="100">
                        </a>
                    </td>
                    <td class="product-name">
                        <a href="<?php echo esc_url($product_url); ?>"><?php echo esc_attr($name); ?></a>
                    </td>
                    <td class="product-status">
                        <?php echo esc_attr($status); ?>
                    </td>                    
                    <td class="product-remove">
                        <a href="#" class="subscriptions-tab remove" aria-label="Remove this item" data-nonce="<?php echo esc_attr(wp_create_nonce('admail_unsubscribe_nonce')); ?>" data-product_id="<?php echo esc_attr($product_id); ?>">&times;</a>
                    </td>
                </tr>
                
                <?php
                
            }
            
        }        
        ?>
    </tbody>
</table>

    
    
    <?php
    
}

