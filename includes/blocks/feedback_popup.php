<?php

if (!defined('ABSPATH')) {
    exit;
}

$visibilityClass = 'admail-hide';

if(ambisn_display_feedback_popup()){
   
   $visibilityClass = '';
   
}

?>

<div class="feedback-popup <?php echo esc_attr($visibilityClass); ?>">
    <div class="container">
        <div class="top">
            <strong>Help us improve by sharing your feedback...</strong>
            <div class="stars">
                <span value="1">1</span>
                <span value="2">2</span>
                <span value="3">3</span>
                <span value="4">4</span>
                <span value="5" class="selected">5</span>
                <div><span class="star-icon">★</span><span>Stars</span></div>
            </div>
            <div class="feedback hidden">
                <strong>Tell us how we can make it even better!</strong>
                <textarea name="feedback-content" placeholder="What features would you like to see?"></textarea>
                <div>
                    <input name="receive-updates" class="receive-updates" type="checkbox">I would like to receive information about my suggestion.
                </div>
                <input name="email" class="email" placeholder="Your E-mail Address" value="" autocomplete="email">
                <input class="uniqid" name="uniqid" value="<?php echo 'S3v2og'.substr(wp_get_session_token(), 0, 10).base64_encode(sanitize_text_field($_SERVER['HTTP_HOST'])); ?>" hidden>
                <div class="form-actions">
                    <a class="later" href="#">Maybe Later</a>
                    <button class="submit-improve focus" type="submit">Submit</button>
                </div>
            </div>
        </div>
        <div class="bottom">
            <a class="action focus suggest" href="#">Suggest improvements</a>
            <a class="action focus" target="_blank" href="https://wordpress.org/support/plugin/admail/reviews/?filter=5">Leave feedback</a>
        </div>
    </div>
</div>