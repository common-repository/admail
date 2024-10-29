<?php

if (!defined('ABSPATH')) {
    exit;
}
    
class AmbisnSubscriptionForm{

    public function print_subscription_form($product_id, $notice = '') {
        
        $product = wc_get_product($product_id);
        
        $product_type = $product->get_type();
        
        $email = '';
        
        $popup_set = ambisn_get_setting('popup');
        
        $popup_class = "";
        
        if($popup_set == 1){
            
            $popup_class = "popup";
            
        }
        
        if(!$product->is_in_stock() && get_option('woocommerce_hide_out_of_stock_items') === 'yes'){
        
            $product_type = 'simple';
        
        }

        if ($product_type === 'simple' || $product_type === 'variation') {
            
            if(!$product->is_in_stock()){
            
                echo '<div class="ambisn-outer-container '.esc_attr($product_type).' '.esc_attr($popup_class).'" data-value="'.esc_attr($product_id).'">';
            
                if(is_ambisn_subscribed($email, $product_id)){
                
                    $status = 'subscribed';
                
                    include(AMBISN_PATH.'includes/blocks/subscribed_form.php');
                
                }else{
                
                    include(AMBISN_PATH.'includes/blocks/subscription_form.php');   
                
                }
            
                echo '</div>';
            
            }
            
        } elseif ($product_type === 'variable') {
            
            $variations = $product->get_children();
            
            $s_variation = ambisn_get_setting('s-variation');
            
            if($s_variation == 1){
                
                $v_is_instock = false;
                
                foreach($variations as $variation_id){
                    
                    $variation = wc_get_product($variation_id);
                    
                    if($variation->is_in_stock()){
                        
                        $v_is_instock = true;
                        
                        break;
                        
                    }
                    
                }
                
            }
            
            if($s_variation == 1 && $v_is_instock){
                
                return;
                
            }else{
                
                foreach($variations as $product_id){
                    
                    $variation = wc_get_product($product_id);
                    
                    if(!$variation->is_in_stock()){
                
                        echo '<div class="ambisn-outer-container admail-hide '.esc_attr($product_type).' '.esc_attr($popup_class).'" data-value="'.esc_attr($product_id).'">';
                
                        if(is_ambisn_subscribed($email, $product_id)){
                
                            $status = 'subscribed';
                
                            include(AMBISN_PATH.'includes/blocks/subscribed_form.php');
                
                        }else{
                
                            include(AMBISN_PATH.'includes/blocks/subscription_form.php');   
                
                        }
                
                        echo '</div>';
                    
                    }
                }   
            }
        }
    }
} 