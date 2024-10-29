<?php

if (!defined('ABSPATH')) {
    exit;
}

$nonce = wp_create_nonce('admail_subscribe_nonce');

$sf_consent = ambisn_get_setting('sf_consent');

$sf_consent_terms_url = ambisn_get_setting('sf_consent_pp_url');

$sf_consent_notice = ambisn_get_setting('sf_consent_notice');

$f_visibility = '';

if(is_user_logged_in()){
    
    $current_user = wp_get_current_user();

    $email = $current_user->user_email;
    
    if(ambisn_get_setting('email_field') == '0'){
        
        $f_visibility = 'hidden';
        
    }

}else{
    
    $email = '';
    
}

if(empty($email)){
    
    if(isset($_COOKIE["nmuseremail"])){
        
        $email = sanitize_email($_COOKIE["nmuseremail"]);
        
    }
}

$recatptcha_tree = ambisn_get_setting('recaptcha_tree');

$recaptcha_tree_site_key = ambisn_get_setting('recaptcha_tree_site_key');

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
?>

<div id="wc-ambisn-container" class="<?php echo esc_attr($popup_close_class); ?>">
    
    <?php 
    
    echo wp_kses_post($popup_close); 
    
    ?>
    
    <div class="inner-content">
        <div class="wc-ambisn-form <?php echo esc_attr($popup_close_class); ?>">
            <h5><?php echo wp_kses_post(ambisn_get_translated('form_text')); ?></h5>
            <div class="subscription-form">
                <input type="hidden" name="admail_subscribe_nonce" value="<?php echo esc_attr($nonce); ?>" />
                <input type="hidden" name="ambisn_product_id" id="product-id" value="<?php echo esc_attr($product_id); ?>">
                <input name="ambisn_email" id="email" value="<?php echo esc_attr($email); ?>" placeholder="E-mail" <?php echo esc_attr($f_visibility); ?>></span>
                
                <?php if(isset($recatptcha_tree) && $recatptcha_tree == 1 && isset($recaptcha_tree_site_key) && $recaptcha_tree_site_key != ''){ ?>
                
                <button data-sitekey="<?php echo esc_attr($recaptcha_tree_site_key); ?>" data-callback='onSubmit' data-action='submit' type="submit" name="ambisn-submit" class='g-recaptcha wc-ambisn-button product-<?php echo esc_attr($product_id); ?>' id="ambisn-submit" value="<?php echo esc_attr(ambisn_get_translated('button_text')); ?>"><?php echo esc_attr(ambisn_get_translated('button_text')); ?></button>
  
                <?php } else{ ?>
                
                <button type="submit" name="ambisn-submit" class='wc-ambisn-button product-<?php echo esc_attr($product_id); ?>' id="ambisn-submit" value="<?php echo esc_attr(ambisn_get_translated('button_text')); ?>"><?php echo esc_attr(ambisn_get_translated('button_text')); ?></button>
                
                <?php } ?>
            
            </div>
            
            <?php
            
            if(isset($notice) && !empty($notice)){
                
                echo '<p class="ambisn-err-notice">'.wp_kses_post($notice).'</p>';

            }
            
            if ($sf_consent == '1') {
    
                $consent_notice = ambisn_get_translated('sf_consent_notice');

                $consent_notice = preg_replace_callback('/\{(.+?)\}/', function ($matches) use ($sf_consent_terms_url) {
        
                    $link_text = $matches[1];
        
                    return '<a href="' . esc_url($sf_consent_terms_url) . '" target="_blank">' . esc_html($link_text) .'</a>';
        
                }, $consent_notice);

                echo '<div class="ambisn-sf-consent"><input type="checkbox">' . wp_kses_post($consent_notice) . '</div>';
            }

            
            echo '<p class="ambisn-err-notice ambisn-consent admail-hide">'.ambisn_get_translated('sf_consent_error_message').'</p>'; 
            
            if(isset($recatptcha_tree) && $recatptcha_tree == 1){
                
                ?>
                
                <script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr($recaptcha_tree_site_key); ?>"></script>
                
                <?php
                
            }
            ?>
            
        </div>
    </div>
</div>