<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once(AMBISN_PATH . 'classes/admin_settings.php');

$admail_settings = new Admail_Settings;

?>
<div class="settings-container ambisn-settings">
    <div class="action-notice">Saving ...</div>
    <div class="section-container">
        <div class="sec-heading">
            
            <h1>General settings</h1>
            
            <?php 
            
            $admail_settings->print_setting_html('guests','toggle','Enable for guests','Show the subscription form for unregistred users');

            $admail_settings->print_setting_html('unsubscribe','toggle','Allow users to unsubscribe',"Add an unsubscribe link to the 'subscribed' notice");
            
            $admail_settings->print_setting_html('email_field','toggle','Show Email field for registred users','If disabled, the E-mail used during registration will be used.');

            $admail_settings->print_setting_html('auto_submission','toggle','Auto Submit Notice','Automatically submit notifications once a product is back in stock.');

            $admail_settings->print_setting_html('popup','toggle','Pop-up Subscription Form','Display the subscription form on a pop-up.');

            //$admail_settings->print_setting_html('ajaxify_submission','toggle','Ajax Form Submission','Enable seamless subscription submissions without page reloads.');
            
            //Exclude by product type
            
            $product_types = array('simple'=>'Simple', 'variable'=>'Variable', 'grouped'=>'Grouped');

            $admail_settings->print_setting_html('exclude_product_type','multiselect','Exclude by product type','', $product_types);        
            
            //Exclude by categories
            
            $categories = array();
            
            $product_categories = get_terms( array('taxonomy' => 'product_cat'));
            
            foreach ( $product_categories as $product_category ) {
                
                $categories[$product_category->slug] = $product_category->name;
                
            }

            $admail_settings->print_setting_html('exclude_categories','multiselect','Exclude products by categories','', $categories);
            
            //Exclude by tag names
            
            $product_tag_names = get_terms( array(
                'taxonomy'   => 'product_tag',
                'hide_empty' => false,
                'fields'     => 'all',
            ) );
            
            $tag_id_name_array = array();
            
            if ( ! empty( $product_tag_names ) && ! is_wp_error( $product_tag_names ) ) {
                
                foreach ( $product_tag_names as $tag ) {
                    
                    $tag_id_name_array[$tag->term_id] = $tag->name;
                    
                }
            }

            $admail_settings->print_setting_html('exclude_tag_names','multiselect','Exclude products by tag names','', $tag_id_name_array);            
            
            $admail_settings->print_setting_html('s-variation','toggle','Hide subscription form on variation availability','Hide the subscription form if at least one variation is in stock.');
            
            $admail_settings->print_setting_html('prevent_dupl_subscriptions','toggle','Prevent Duplicate Subscriptions','Recommended when working with duplicated or translated products to avoid multiple subscriptions for the same product across different versions.');

            ?>
        </div>
        
        <div class="sec-heading">
            
            <h1>Subscription Form</h1>
            <div class="setting content">
                <div class="label">
                    <h3>Subscription form shortcode</h3>
                    <p>Add this shortcode to any WooCommerce product page where you want the subscription form to appear.</p>
                </div>
                <div class="content">
                    <h3>[admail_subscription_form]</h3>
                </div>                
            </div>            
            <div class="setting flex form">
                <div class="element-container form">
                    <h3>Form</h3>
                    <div class="element-settings">
                        <div class="text">
                            <?php 
                            
                            $admail_settings->print_setting_html('form_text','input','','Form Text');
                            
                            $admail_settings->print_setting_html('form_subscribed_text','input','','Subscribed - Text');
                            
                            $admail_settings->print_setting_html('form_previously_subscribed_notice','input','','Previously subscribed - Notice');
                            
                            ?>                            
                        </div>
                        <div class="background color">
                            <?php 
                            
                            $admail_settings->print_setting_html('form_bg_color','color','','Background Color');
                            
                            ?>                            
                        </div>
                    </div>
                </div>
                <div class="element-container submit-button">
                    <h3>Button</h3>
                    <div class="element-settings">
                        <div class="btn-icon">
                            <?php 
                            
                            $admail_settings->print_setting_html('btn_icon','toggle','Icon Visibility','When enabled, the button will be displayed with an icon.');
                            
                            ?>
                        </div>
                    </div>    
                    <div class="element-settings">
                        <div class="text">
                            <?php 
                            
                            $admail_settings->print_setting_html('button_text','input','','Button Text');
                            
                            ?>
                        </div>
                        <div class="color">
                            <?php 
                            
                            $admail_settings->print_setting_html('button_text_color','color','','Text Color');
                            
                            ?>
                        </div>
                        <div id="button-border-radius" class="border-radius">
                            <?php 
                            
                            $admail_settings->print_setting_html('button_border_radius','input','','Border Radius');
                            
                            ?>                            
                        </div>                        
                        <div class="background color">
                            <?php 
                            
                            $admail_settings->print_setting_html('button_bg_color','color','','Background Color');
                            
                            ?>                            
                        </div>
                    </div>
                </div>
                <div class="element-container submit-button">
                    <h3>Subscribed texts</h3>
                    <div class="element-settings">
                        <div class="text">
                            <?php 
                            
                            $admail_settings->print_setting_html('unsubscribe_text','input','','Link Text');
                            
                            ?>  
                        </div>
                        <div class="text">
                            <?php 
                            
                            $admail_settings->print_setting_html('subscribed_btn_text','input','','Popup "subscribed" button text');
                            
                            ?>  
                        </div>                        
                    </div>
                </div>

            </div>
        </div>
        
        <div class="sec-heading">
            
            <h1>Subscription Form Consent</h1>

            <div class="element-container form">
                <?php 
            
                $admail_settings->print_setting_html('sf_consent','toggle','Enable "I Agree to Terms" Checkbox','');
            
                ?>
                <div class="element-settings">
                    <div class="text">
                    <?php 
                            
                    $admail_settings->print_setting_html('sf_consent_notice','input','Customize the text that appears next to the checkbox','Wrap text in `{}` to create a clickable link to "Terms and Conditions" page.');

                    $admail_settings->print_setting_html('sf_consent_pp_url','input','"Terms and Conditions" page','');
                    
                    $admail_settings->print_setting_html('sf_consent_error_message', 'input', 'Consent Error Message', '');
                            
                    ?>                            
                    </div>
                    
                </div>
            </div>
            
        </div>           
        
        <div class="sec-heading">
            
            <h1>Manage Product Subscriptions Page</h1>

            <div class="element-container form">
                <?php 
            
                $admail_settings->print_setting_html('ps_tab','toggle','Enable My Account "Product Subscriptions" Tab','');
            
                ?>
                <div class="element-settings">
                    <div class="text">
                    <?php 
                            
                    $admail_settings->print_setting_html('ps_tab_empty_notice','input','','Empty Subscriptions Notice');
                            
                    ?>                            
                    </div>
                    
                </div>
            </div>
            
            <div class="setting content">
                <div class="label">
                    <h3>Shortcode for Product Subscriptions Page</h3>
                    <p>Use the shortcode below to display the product subscriptions content on any page of your site.</p>
                </div>
                <div class="content">
                    <h3>[admail_product_subscriptions_page]</h3>
                </div>                
            </div> 
            
        </div>        
        
        <div class="sec-heading">
            
            <h1>reCAPTCHA settings</h1>

            <div class="element-container form">
                <?php 
            
                $admail_settings->print_setting_html('recaptcha_tree','toggle','Enable reCAPTCHA v3','Enhance security and prevent spam submissions by enabling reCAPTCHA.');
            
                ?>
                <div class="element-settings">
                    <div class="text">
                    <?php 
                            
                    $admail_settings->print_setting_html('recaptcha_tree_site_key','input','','reCAPTCHA Site Key');
                            
                    ?>                            
                    </div>
                    
                    <div class="text">
                    <?php 
                            
                    $admail_settings->print_setting_html('recaptcha_tree_secret_key','input','','reCAPTCHA Secret Key');
                            
                    ?>                            
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="sec-heading">
            <h1>Store Info</h1>
            <div class="store-settings">
                
                <?php 
                    
                $admail_settings->print_setting_html('store_logo','image','','');
                            
                ?>
                
                <div class="setting">
                    
                    <?php 
                            
                    $admail_settings->print_setting_html('store_name','input','','');
                            
                    ?>
                    
                    <div id="store-email" class="email"><input onkeypress="this.style.width = ((this.value.length + 1) * 8) + 'px';" placeholder="marketing" <?php echo 'name = "store_email" setting = "store_email"  value = "'.ambisn_get_setting('store_email').'"'; ?>><span><b>@</b><?php echo wp_kses_post($_SERVER['SERVER_NAME']);?></span></div>

                </div>
            </div>
            <p>Those information will be used on submitted emails</p>
        </div>
        
        <div class="sec-heading">
            
            <h1>Store Owner Notification</h1>

            <div class="element-container form">
                <?php 
            
                $admail_settings->print_setting_html('store_confirmation_email','toggle','Enable Store Owner Notification','Receive an email notification when a user subscribes.');
            
                ?>
                <div class="element-settings">
                    <div class="text">
                    <?php 
                            
                    $admail_settings->print_setting_html('store_conf_email_recipient','input','','Email Recipient');
                            
                    ?>                            
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-heading">
            <h1>Customers confirmation Emails settings</h1>
            <?php 
            
            $admail_settings->print_setting_html('confirmation_email','toggle','Enable subscription confirmation Email','');
            
            $admail_settings->print_setting_html('conf_no_reply','toggle','Enable "No reply" option','');
                    
            ?>
            <div class="setting email-content">
                <div class="element-container form">
                    <h3>E-mail content</h3>
                    <div class="element-settings">
                        <div class="text">
                            <?php 
                            
                            $admail_settings->print_setting_html('conf_email_subject','input','','Subject');
                            
                            $admail_settings->print_setting_html('conf_email_heading','input','','Heading');
                            
                            $admail_settings->print_setting_html('conf_email_subheading','input','','Subheadingt');
                            
                            $admail_settings->print_setting_html('conf_email_footer','input','','Footer');
                            
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="preview-template">
                <div class="title">
                    <h3>Template Preview</h3>
                    <p>Please save to update the preview</p>
                </div>
                <div class="ambisn preview-container conf-template">
                    
                    <?php
                    
                    $preview = true;
                    include_once (AMBISN_PATH.'includes/mail_templates/conf_email_template.php');
                    
                    ?>
                    
                </div>
            </div>
        </div>        
        <div class="sec-heading">
            <h1>Emails settings</h1>
            <?php 
            
            $admail_settings->print_setting_html('no_reply','toggle','Enable "No reply" option','');
            
            $admail_settings->print_setting_html('email_price','toggle','Include the product price','');
            
            $admail_settings->print_setting_html('email_qty','toggle','Include the available quantity','');
                    
            ?>
            <div class="setting email-content">
                <div class="element-container form">
                    <h3>E-mail content</h3>
                    <div class="element-settings">
                        <div class="text">
                            <?php 
                            
                            $admail_settings->print_setting_html('email_subject','input','','Subject');
                            
                            $admail_settings->print_setting_html('email_heading','input','','Heading');
                            
                            $admail_settings->print_setting_html('email_subheading','input','','Subheadingt');
                            
                            $admail_settings->print_setting_html('email_button_text','input','','Button text');
                            
                            $admail_settings->print_setting_html('email_footer','input','','Footer');
                            
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="setting social-icons">
                <div class="element-container form">
                    <h3>Social icons</h3>
                    <p>We recommend using PNG format.</p>
                    <div class="element-settings">
                    <?php 
                    $social_media_links = unserialize(ambisn_get_setting('social_icons'));
                    if(!is_array($social_media_links)){
                        $social_media_links = array();
                    }
                    if(count($social_media_links) == 0){
                        $add_class="hidden";
                        ?>
                        <div class="item waiting">
                            <img class="add-social-icon" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/add.png" width="30">
                            <input name="img-link" class="img-link" value="" hidden>
                            <input name="social-icon-link" class="social-icon-link" placeholder="Social icon link" value="">
                            <div class="done"><img width="20" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/done.svg"></div>
                            <div class="remove hidden"><img width="20" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/remove.svg"></div>
                        </div>
                        <?php
                    }
                    else{
                        $add_class="";
                        foreach($social_media_links as $item){
                        ?>
                        <div class="item added">
                            <img class="add-social-icon" src="<?php echo $item['image_url']; ?>" width="30">
                            <input name="img-link" class="img-link" value="<?php echo $item['image_url']; ?>" hidden>
                            <input name="social-icon-link" class="social-icon-link" placeholder="Social icon link" value="<?php echo $item['link']; ?>">
                            <div class="done hidden"><img width="20" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/done.svg"></div>
                            <div class="remove"><img width="20" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/remove.svg"></div>
                        </div>                
                        <?php
                        }
                    }
                    ?>
                        <div class="item hidden">
                            <img class="add-social-icon" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/add.png" width="30">
                            <input name="img-link" class="img-link" value="" hidden>
                            <input name="social-icon-link" class="social-icon-link" placeholder="Social icon link" value="">
                            <div class="done"><img width="20" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/done.svg"></div>
                            <div class="remove hidden"><img width="20" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/remove.svg"></div>
                        </div>                       
                        <div class="add <?php echo $add_class; ?>">
                            <span>+ Add new</span>
                        </div>                    
                    </div>
                </div>
            </div>            
        </div>
        <div class="sec-heading">
            <h1>E-mail Template</h1>
            <div class="setting template-settings">
                <?php 
                
                $email_templates = array();
                
                $directory = AMBISN_PATH . 'includes/mail_templates';
                
                $files = array_diff(scandir($directory), array('..', '.'));
                
                foreach ($files as $file) {
                    
                    $file = pathinfo($file, PATHINFO_FILENAME);
                    if (str_contains($file, 'ambisn_template')) {
                        $file = str_replace('ambisn_template_', '', $file);
                        $email_templates[$file] = $file;
                    }
                }
                
                $admail_settings->print_setting_html('email_template','uniselect','Available Templates','', $email_templates);
                
                $admail_settings->print_setting_html('email_theme_color','color','Template theme color','');
                            
                ?>
            </div>
            <div class="preview-template">
                <div class="title">
                    <h3>Template Preview</h3>
                    <p>Please save to update the preview</p>
                </div>
                <div class="ambisn preview-container bise-template">
                    
                    <?php
                    
                    include_once (AMBISN_PATH.'includes/template_preview.php');
                    
                    ?>
                    
                </div>
            </div>
        </div>
        <a class="nm-save-settings" href="#">Save</a>
    </div>
    
    <?php 
    
    include_once(AMBISN_PATH.'includes/blocks/settings_sidebar.php');
    
    ?>
</div>