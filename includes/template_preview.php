<?php

if (!defined('ABSPATH')) {
    exit;
}

$random_product = wc_get_products(array(
    'orderby' => 'rand',
    'limit' => 1,
    'status' => 'publish'
));

if (!empty($random_product) && has_post_thumbnail($random_product[0]->get_id())) {
    $product_id = $random_product[0]->get_id();
    $parent_id = $random_product[0]->get_parent_id();  // If this is a variation, get the parent ID
    $image = wp_get_attachment_url($random_product[0]->get_image_id());
    $product_url = get_permalink($product_id);
    $name = $random_product[0]->get_name();
    if(ambisn_get_setting('email_qty') == '1'){
        if($random_product[0]->get_stock_quantity() != ''){
            
            $qty_html = __('Quantity','ambisn').': '.$random_product[0]->get_stock_quantity();
            
        }else{
            
            $qty_html = '';
            
        }
        
    }
    if(ambisn_get_setting('email_price') == '1'){
        $price_html = __('Price','ambisn').': '.$random_product[0]->get_price_html();
    }
    
} else {
    // Static data as fallback
    $product_id = '1234';
    $parent_id = '2342';
    $image = AMBISN_URL.'assets/images/no_image.png';
    $product_url = '#';
    $name = 'Product Name';
    if(ambisn_get_setting('email_qty') == '1'){
        $qty_html = __('Quantity','ambisn').": 40";
    }
    if(ambisn_get_setting('email_price') == '1'){
        $price_html = __('Price','ambisn').": $ 70";
    }    
}


    $site = site_url();
    $store_name = ambisn_get_setting('store_name');
    $email_heading = ambisn_get_translated('email_heading');
    $email_subheading = ambisn_get_translated('email_subheading');
    $button_text = ambisn_get_translated('email_button_text');
    $footer = ambisn_get_translated('email_footer');
    $social_media_links = unserialize(ambisn_get_setting('social_icons'));
    $theme_color = ambisn_get_setting('email_theme_color');
    if(empty($theme_color)){
        $theme_color = '#333333';
    }    
    
    $logo = ambisn_get_setting('store_logo');
    if(empty($logo)){
       $logo = esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] );
        if(empty($logo)){
            $logo = AMBISN_URL.'assets/images/wp-logo.png';
        }
    }

$template_file = ambisn_get_setting('email_template');

if(empty($template_file)){
    $template_file = 'default';
}
include_once (AMBISN_PATH.'includes/mail_templates/ambisn_template_'.$template_file.'.php');
