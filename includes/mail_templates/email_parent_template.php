<?php
    
function ambisn_mail_template($product_id){
    
    $product = wc_get_product( $product_id );
    $parent_id = $product->get_parent_id();
    if($parent_id == '0'){
        $image = wp_get_attachment_url( $product->get_image_id());
        $product_url = $product->get_permalink();
        $name = $product->get_title();
    }
    else{
        $variation = wc_get_product($product_id);
        $product_url = $variation->get_permalink();
         $name = $variation->get_name();
        $product_id.= ' -variation-';
        $image = wp_get_attachment_url( $variation->get_image_id()); 
    }
    $site = site_url();
    $store_name = ambisn_get_setting('store_name');
    $email_heading = ambisn_get_translated('email_heading');
    $email_subheading = ambisn_get_translated('email_subheading');
    $button_text = ambisn_get_translated('email_button_text');
    $footer = ambisn_get_translated('email_footer');
    $theme_color = ambisn_get_setting('email_theme_color');
    $social_media_links = unserialize(ambisn_get_setting('social_icons'));
    if(empty($theme_color)){
        $theme_color = '#333333';
    }
    
    $qty = $product->get_stock_quantity();
    if(ambisn_get_setting('email_qty') == '1' && !empty($qty)){
        $qty_html = __('Quantity','ambisn').': '.$qty;
    }
    if(ambisn_get_setting('email_price') == '1'){
        $price = $product->get_price_html();
        $price_html = __('Price','ambisn').': '.$price;
    }

    $logo = ambisn_get_setting('store_logo');
    if(empty($logo)){
        $logo = esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] ); 
        if(empty($logo)){
            $logo = AMBISN_URL.'assets/images/wp-logo.png';
        }
    }
    $image = wp_get_attachment_url( $product->get_image_id());
    if(empty($image)){
        $image = AMBISN_URL.'assets/images/no_image.png';
    }
    
    $template_file = ambisn_get_setting('email_template');

    ob_start();
    
    include(AMBISN_PATH.'includes/mail_templates/ambisn_template_'.$template_file.'.php');

    return ob_get_clean();
}