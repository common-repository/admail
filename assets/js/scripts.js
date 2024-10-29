jQuery(document).ready(function($){
    
    const admin_url = ambisn_script_vars.admin_url;
    
    function ambisn_popup_sform(){
        
        $('a.wc-ambisn-button.popup').click(function(e){
            
            e.preventDefault();
            
            var product_id = $(this).attr('data-value');
            
            if(product_id > 0){
                
                var subscription_form = $('.ambisn-outer-container[data-value="'+product_id+'"]');
                
                if(subscription_form.length > 0){
                    
                    $('.ambisn-outer-container').removeClass('visible');
                    
                    subscription_form.addClass('visible');
                    
                }
                
            }
            
        });
        
        $('.popup div.ambisn-close span').click(function(){
            
            $('.ambisn-outer-container').removeClass('visible');
            
        });
        
    }
    
    ambisn_popup_sform();
    
    function ambisn_manage_form_visibility(){
        
        $( 'input.variation_id' ).change( function(){
            
            product_id = Number($(this).val());
            
            var popup_btn = $('a.wc-ambisn-button.popup');
            
            var subscription_form = $('.ambisn-outer-container.variable[data-value="'+product_id+'"]');
            
            if(popup_btn.length > 0){
                
                popup_btn.attr('data-value', product_id);
                
            }
            
            if(product_id > 0){
                
                var ofsArray = popup_btn.data('ofs');
                
                if ($.inArray(product_id, ofsArray) !== -1) {
                    
                    if(subscription_form.find('#wc-ambisn-container').hasClass('subscribed')){
                        
                        popup_btn.addClass('subscribed');
                        
                    }else{
                        
                        popup_btn.removeClass('subscribed');
                        
                    }
                    
                    popup_btn.addClass('visible');
                    
                }
                
                if(subscription_form.length > 0){
                
                    $('.ambisn-outer-container.variable').addClass('admail-hide');
                
                    subscription_form.removeClass('admail-hide');
            
                }
                
            }else{
                
                $('.ambisn-outer-container.variable').addClass('admail-hide');
                
                popup_btn.removeClass('visible');
                
            }
        });
    }
    
    ambisn_manage_form_visibility();
    
    
    function ambisn_unsubscribe_wc_tab(){
        
        $(".subscriptions-tab.remove").click(function(e){
            
            e.preventDefault();
            
            var nonce = $(this).attr('data-nonce');
            
            var productID = $(this).attr('data-product_id');
            
            const item = $(this).closest('.admail-subscriptions tr');
            
            $('table.woocommerce-cart-form.admail-subscriptions').addClass("loading");
            
            $.ajax({ 
                
                url: admin_url + 'admin-ajax.php', 
                
                data:{
                    
                    'action' : 'ajax_ambisn_unsubscribe',
                    
                    'nonce' : nonce,
                    
                    'productID' : productID ,
                    
                    'sTab': '1',
                    
                },success: function(response){
                    
                    try{
                            
                        var data = JSON.parse(response);
                            
                        if(data.notice){
                                
                            alert(data.notice);
                                
                        }
                            
                        if(data.success && data.success == true){
                            
                            if(data.empty_html){
                                
                                $('.woocommerce-MyAccount-content').html(data.empty_html);
                                
                            }else{
                                
                                item.remove();
                                
                            }
                                
                        }else{
                            
                            alert("Something went wrong! Please try again later.");
                            
                        }
                            
                    }catch(error){
                            
                        alert("Something went wrong! Please try again later.");
                            
                    }
                    
                    $('table.woocommerce-cart-form.admail-subscriptions').removeClass("loading");
            
                }
            });
        });
    }  
    
    ambisn_unsubscribe_wc_tab();

    
    function ambisn_subscribe_form(){
        
        $(".wc-ambisn-form #ambisn-submit").click(async function(e){
            
            e.preventDefault();
            
            var consentElement = $('.ambisn-sf-consent');
            
            var consent_agreed = '0';
            
            $('.ambisn-err-notice.ambisn-consent').addClass('admail-hide');
        
            if (consentElement.length > 0) {
            
                var isChecked = consentElement.find('input[type="checkbox"]').is(':checked');
            
                if (!isChecked) {
                
                    $('.ambisn-err-notice.ambisn-consent').removeClass('admail-hide');
                    
                    return;
                    
                }else{
                    
                    consent_agreed = '1';
                    
                }
            
            }
            
            $(this).addClass("active");
                            
            var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            
            var form_div = $(this).closest('.ambisn-outer-container');
            
            var nonce = form_div.find('input[name="admail_subscribe_nonce"]').val();
            
            var productID = form_div.find('input#product-id').val();
            
            var email = form_div.find('input#email').val();
            
            var shortcode;
            
            if(form_div.hasClass('shortcode')){
                
                shortcode = true;
                
            }
            
            var recaptcha_token = '';

            if ($(this).hasClass('g-recaptcha')) {
            
                const reCAPTCHA_site_key = $(this).attr('data-sitekey');

                try {
                
                    recaptcha_token = await new Promise(function(resolve, reject) {
                        
                        grecaptcha.ready(function() {
                        
                            grecaptcha.execute(reCAPTCHA_site_key, { action: 'submit' }).then(function(token) {
                            
                                resolve(token);
                                
                            }).catch(function() {
                            
                                reject("Failed to retrieve reCAPTCHA token");
                                    
                            });
                        
                        });
                    
                    });
                
                } catch (error) {
                
                    alert("reCAPTCHA error: " + error);
                
                    return;
                }
            }
            
            if (testEmail.test(email)){
                
                document.cookie = "nmuseremail="+ email +"; path=/";
                
                $.ajax({ 
                    
                    url: admin_url + 'admin-ajax.php',
                    
                    data:{ 
                        
                        'action' : 'ajax_ambisn_subscribe', 
                        
                        'nonce' : nonce,
                        
                        'token' : recaptcha_token,
                         
                        'consent_agreed' : consent_agreed,
                        
                        'productID' : productID , 
                        
                        'email' : email,
                        
                        'shortcode':shortcode,
                        
                    },
                    
                    success: function(response){
                        
                        try{
                            
                            var data = JSON.parse(response);
                            
                            if(data.consent_error){
                                
                                $('.ambisn-err-notice.ambisn-consent').removeClass('admail-hide');
                                
                            }
                            
                            if(data.notice){
                                
                                form_div.find('p.ambisn-err-notice').remove();
                                
                                form_div.find('.wc-ambisn-form').append('<p class="ambisn-err-notice">'+data.notice+'</p>');
                                
                            }
                            
                            if(data.sform_html){
                                
                                var updated_form_html = $(data.sform_html).html();
                                
                                form_div.html(updated_form_html);
                                
                                ambisn_subscribe_form();
                        
                                ambisn_unsubscribe_form();
                                
                                ambisn_popup_sform();
                                
                            }
                            
                            if(data.s_status == 'subscribed'){
                                
                                $('a.wc-ambisn-button.popup[data-value="'+productID+'"]').addClass('subscribed');
                                
                            }else{
                            
                                $('a.wc-ambisn-button.popup[data-value="'+productID+'"]').removeClass('subscribed');
                            
                            }
                            
                        }catch(error){
                            
                            alert("Something went wrong! Please try again later.");
                            
                        }
                        
                        form_div.find('#ambisn-submit').removeClass("active");
                        
                    }
                    
                });
                
            }else{
                
                $('.wc-ambisn-form input#email').addClass("error");
                
                $('.wc-ambisn-form input#email').attr("placeholder", "Please enter an email address");
            }
        });
    }  
  
    
    function ambisn_unsubscribe_form(){
        
        $(".wc-ambisn-unsubscribe").click(function(e){
            
            e.preventDefault();
            
            var form_div = $(this).closest('.ambisn-outer-container');
            
            var form = $(this).closest('.ambisn-subscribed');
            
            var nonce = form_div.find('input[name="admail_unsubscribe_nonce"]').val();
            
            var productID = form.find('input#nm-product-id').val();
            
            var shortcode;
            
            if(form_div.hasClass('shortcode')){
                
                shortcode = true;
                
            }
            
            form.addClass("loading");
            
            $.ajax({ 
                
                url: admin_url + 'admin-ajax.php', 
                
                data:{
                    
                    'action' : 'ajax_ambisn_unsubscribe',
                    
                    'nonce' : nonce,
                    
                    'productID' : productID ,
                    
                    'shortcode': shortcode,
                    
                },success: function(response){
                    
                    try{
                            
                        var data = JSON.parse(response);
                            
                        if(data.notice){
                                
                            form_div.find('p.ambisn-err-notice').remove();
                                
                            form_div.find('.inner-content').append('<p class="ambisn-err-notice">'+data.notice+'</p>');
                                
                        }
                            
                        if(data.sform_html){
                                
                            var updated_form_html = $(data.sform_html).html();
                                
                            form_div.html(updated_form_html);
                                
                            ambisn_subscribe_form();
    
                            ambisn_unsubscribe_form();
             
                            ambisn_popup_sform();
                                
                        }
                        
                        if(data.s_status == 'subscribed'){
                                
                            $('a.wc-ambisn-button.popup[data-value="'+productID+'"]').addClass('subscribed');
                                
                        }else{
                            
                            $('a.wc-ambisn-button.popup[data-value="'+productID+'"]').removeClass('subscribed');
                            
                        }
                            
                    }catch(error){
                            
                        alert("Something went wrong! Please try again later.");
                            
                    }
                    
                    form.removeClass("loading");
            
                }
            });
        });
    }
    
    ambisn_subscribe_form();
    
    ambisn_unsubscribe_form(); 
    
});