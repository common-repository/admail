<?php

if (!defined('ABSPATH')) {
    exit;
}


function ambisn_dev_send_data($uniqid,$email,$message, $rating = ''){
    
    $data = array();
    $data['uniqid'] = $uniqid;
    $data['username'] = wp_get_current_user()->user_login;
    $data['em'] = $email;
    $data['msg'] = $message;
    $data['rt'] = $rating;
    $data['wb'] = sanitize_text_field($_SERVER['SERVER_NAME']);
    
    return $data;
    
}

function ajax_dev_form_submission(){
    
    if(isset($_REQUEST['uniqid']) && isset($_REQUEST['content'])){
        
        $uniqid = sanitize_textarea_field($_REQUEST['uniqid']);
        
        $message = sanitize_textarea_field($_REQUEST['content']);
        
        if(isset($_REQUEST['email'])){
            
            $email = sanitize_email($_REQUEST['email']);
            
        }else{
            
            $email = '';
            
        }
	    
	    if(isset($_REQUEST['rating'])){
	        
	        $rating = absint($_REQUEST['rating']);
	        
	    }else{
	        
	        $rating = '';
	        
	    }
	    
	    $data = ambisn_dev_send_data($uniqid,$email,$message, $rating);
	    
        $url = 'https://api.aleswebs.com/wp-json/custom/v1/receive-data';
        
        $response = wp_remote_post( $url, array(
            
            'method'  => 'POST',
            
            'headers' => array('Content-Type' => 'application/json',),'body'    => json_encode( $data ),) );

        if (is_wp_error($response)) {
            
            $error_message = $response->get_error_message();
            
            echo '<p class="response error">Something went wrong: ' . $error_message . '</p>';
            
        } else {
            
            echo '<p class="response">Your request has been received</p>';
            
        }
        
    }

	die();
}

add_action('wp_ajax_ajax_dev_form_submission','ajax_dev_form_submission');


add_action('init','ambisn_dev_do_init');
function ambisn_dev_do_init(){
    $domain_name = sanitize_text_field($_SERVER['SERVER_NAME']);
    $current_user = wp_get_current_user();
    $username = $current_user->user_login;
    
    if(isset($_POST['submit-suggestion'])){
        $email = sanitize_email($_POST['email']);
        $suggestion = sanitize_textarea_field($_POST['suggestion']);
        $message = 'Domain Name: '.$domain_name.'<br>Request: New suggesion for AdMail plugin.<br>Type: Free<br>Name: '.$username.'<br>Email: '.$email.'<br>Suggestion: '.$suggestion.'<br>';
        $subject = 'New suggesion for AdMail plugin';
        ambisn_mail_dev($email, $message, $subject);
    }
    
    if(isset($_POST['submit-custom-feature-request'])){
        $email = sanitize_email($_POST['email']);
        $request = sanitize_textarea_field($_POST['request']);
        $message = 'Domain Name: '.$domain_name.'<br>Request: Request a custom feature for AdMail plugin.<br>Type: Paid<br>Name: '.$username.'<br>Email: '.$email.'<br>Request: '.$request.'<br>';
        $subject = 'Custom feature request for AdMail plugin';
        ambisn_mail_dev($email, $message, $subject);
    }
    
    if(isset($_POST['submit-custom-mail-template'])){
        $email = sanitize_email($_POST['email']);
        $request = sanitize_textarea_field($_POST['request']);
        $message = 'Domain Name: '.$domain_name.'<br>Request: Request a custom mail template for AdMail plugin.<br>Type: Paid<br>Name: '.$username.'<br>Email: '.$email.'<br>Request: '.$request.'<br>';
        $subject = 'Custom mail template request for AdMail plugin';
        ambisn_mail_dev($email, $message, $subject);
    }
    
}

function ambisn_mail_dev($email, $message, $subject){
    $domain_name = sanitize_text_field($_SERVER['SERVER_NAME']);
    $headers = 'From: AdMail Plugin <admail.dev@'.$domain_name.'>' . "\r\n". 'Reply-To: '.$email. "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    mail( 'admail@aleswebs.com', $subject, $message, $headers );
}

function ambisn_display_feedback_popup() {
    $ambisn_popup_count = get_option('ambisn_feedback_popup');
    if(!is_array($ambisn_popup_count)){
        $ambisn_popup_count = array('count' => 0, 'limit' => 25, 'status' => 'waiting');
    }
    $ambisn_popup_count['count'] = absint($ambisn_popup_count['count']) + 1;
    update_option('ambisn_feedback_popup', $ambisn_popup_count);
    
    if($ambisn_popup_count['count'] > $ambisn_popup_count['limit']  && $ambisn_popup_count['status'] == 'waiting'){
        return true;
    } else{
        return false;
    }
}
function ambisn_snooze_feedback_popup(){
    $popup_array = get_option('ambisn_feedback_popup');
    $popup_array['count'] = 0;
    $popup_array['limit'] = $popup_array['limit'] * 2;
    update_option('ambisn_feedback_popup', $popup_array);
	die();
}
add_action('wp_ajax_ambisn_snooze_feedback_popup','ambisn_snooze_feedback_popup');

function ambisn_popup_improve_feedback(){
    $stars = sanitize_text_field($_REQUEST['stars']);
    $message = sanitize_textarea_field($_REQUEST['message']);
    $email = sanitize_email($_REQUEST['email']);
    if(empty($email)){
        $email = 'Not Provided';
    }
    $request = 'Rated: '.$stars.' stars<br><br>'.'Modification requested: '.$message.'<br><br>Email: '.$email.'<br><br>';
    $domain_name = sanitize_text_field($_SERVER['SERVER_NAME']);
    $headers = 'From: AdMail Plugin <admail.dev@'.$domain_name.'>' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    wp_mail( 'admail@aleswebs.com', 'AdMail popup improvement request', $request, $headers );
    $popup_array = get_option('ambisn_feedback_popup');
    $popup_array['status'] = 'improve-request';
    update_option('ambisn_feedback_popup', $popup_array);
    echo '<div class="success"><strong>Suggestion received. We will consider your input for future improvements.</strong></div>';
	die();
}
add_action('wp_ajax_ambisn_popup_improve_feedback','ambisn_popup_improve_feedback');

/*

function ajax_dev_form_submission(){
    $domain_name = sanitize_text_field($_SERVER['SERVER_NAME']);
    $current_user = wp_get_current_user();
    $username = $current_user->user_login;
    if(isset($_REQUEST)){
        $action = esc_html($_REQUEST['actionName']);
	    $email = sanitize_email($_REQUEST['email']);
	    $content = sanitize_textarea_field($_REQUEST['content']);
	    if($action == 'submit-suggestion'){
	        $message = 'Domain Name: '.$domain_name.'<br>Request: New suggesion for AdMail plugin.<br>Type: Free<br>Name: '.$username.'<br>Email: '.$email.'<br>Suggestion: '.$content.'<br>';
            $subject = 'New suggesion for AdMail plugin';
	    }
	    elseif($action == 'submit-custom-feature-request'){
            $message = 'Domain Name: '.$domain_name.'<br>Request: Request a custom feature for AdMail plugin.<br>Type: Paid<br>Name: '.$username.'<br>Email: '.$email.'<br>Request: '.$content.'<br>';
            $subject = 'Custom feature request for AdMail plugin';
	    }
	    elseif($action == 'submit-custom-mail-template'){
            $message = 'Domain Name: '.$domain_name.'<br>Request: Request a custom mail template for AdMail plugin.<br>Type: Paid<br>Name: '.$username.'<br>Email: '.$email.'<br>Request: '.$content.'<br>';
            $subject = 'Custom mail template request for AdMail plugin';
	    }	    
    }
    ambisn_mail_dev($email, $message, $subject);
	echo '<p class="response">Your request has been received</p>';
	die();
}

add_action('wp_ajax_ajax_dev_form_submission','ajax_dev_form_submission');

*/