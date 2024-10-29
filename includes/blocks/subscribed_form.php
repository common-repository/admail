<?php

if (!defined('ABSPATH')) {
    exit;
}

$nonce = wp_create_nonce('admail_unsubscribe_nonce');

$popup_set = ambisn_get_setting('popup');

$popup_close = '';

$popup_close_class = '';

if(!isset($shortcode)){
    
    $shortcode = false;
    
}
    
if($popup_set == 1 && $shortcode === false){
    
    $popup_close = '<div class="ambisn-close"><span>×</span></div>';
    
    $popup_close_class = 'popup';
    
}

if(!isset($status)){
    
    $status = 'unsubscribed';
    
}
?>

<div id="wc-ambisn-container" class="<?php echo esc_attr($popup_close_class.' '.$status); ?>">
    <?php echo wp_kses_post($popup_close); ?>
    <div class="inner-content">
        <div class="ambisn-subscribed <?php echo esc_attr($popup_close_class); ?>">
            <div class="icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_iconCarrier">
                        <path d="M12.0009 5C13.4331 5 14.8066 5.50571 15.8193 6.40589C16.832 7.30606 17.4009 8.52696 17.4009 9.8C17.4009 11.7691 17.846 13.2436 18.4232 14.3279C19.1606 15.7133 19.5293 16.406 19.5088 16.5642C19.4849 16.7489 19.4544 16.7997 19.3026 16.9075C19.1725 17 18.5254 17 17.2311 17H6.77066C5.47638 17 4.82925 17 4.69916 16.9075C4.54741 16.7997 4.51692 16.7489 4.493 16.5642C4.47249 16.406 4.8412 15.7133 5.57863 14.3279C6.1558 13.2436 6.60089 11.7691 6.60089 9.8C6.60089 8.52696 7.16982 7.30606 8.18251 6.40589C9.19521 5.50571 10.5687 5 12.0009 5ZM12.0009 5V3M9.35489 20C10.0611 20.6233 10.9888 21.0016 12.0049 21.0016C13.0209 21.0016 13.9486 20.6233 14.6549 20" stroke="<?php echo esc_attr(ambisn_get_setting('button_text_color')); ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                    </g>
                </svg>
            </div>
            <div>
            <?php echo wp_kses_post(ambisn_get_translated('form_subscribed_text')); 
            if(ambisn_get_setting('unsubscribe') == 1){
                ?>
                <input type="hidden" name="admail_unsubscribe_nonce" value="<?php echo esc_attr($nonce); ?>" />
                <input type='text' id='nm-product-id' name='ambisn-product-id' value='<?php echo esc_attr($product_id);?>' hidden>
                <input type="submit" name="ambisn-unsubscribe" class="wc-ambisn-unsubscribe product" id="ambisn-unsubscribe" value="<?php echo esc_html(ambisn_get_translated('unsubscribe_text'));?>">
                <span class="spinner"></span>
                <?php
                }
            ?>
            </div>
        </div>
    </div>
</div>