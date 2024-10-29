<?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="settings-sidebar">
        <a href="https://wordpress.org/support/plugin/admail/reviews/?filter=5" target="_blank" class="item leave-review">
            <h3>Leave a good review</h3>
            <p>We value your opinion. It's the perfect way to show gratitude to the developers.</p>
            <div class="ambisn-review-stars conf" >
                <span class="focus">★</span>
                <span class="focus">★</span>
                <span class="focus">★</span>
                <span class="focus">★</span>
                <span class="focus">★</span>
            </div>
        </a>
        <div class="item suggest-feature disabled">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><polyline points="48 24 32 40 16 24"></polyline></g></svg>
            <h3>Suggest a new feature</h3>
            <p>Help us improve by sharing feature suggestions.</p>
            <form method="post">
              <input class="email" type="email" id="email" name="email" placeholder="E-mail" value="" autocomplete="email"  required>
              <textarea class="content" id="suggestion" name="suggestion" rows="3" placeholder="Suggestion" value=""  required></textarea>
              <input class="uniqid" name="uniqid" value="<?php echo 'S3v2sm'.substr(wp_get_session_token(), 0, 10).base64_encode(sanitize_text_field($_SERVER['HTTP_HOST'])); ?>" hidden>
              <input name="submit-suggestion" type="submit" value="Submit">
            </form>
        </div>
        <div class="item request-feature disabled">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><polyline points="48 24 32 40 16 24"></polyline></g></svg>
            <div class="mention paid">
                <span>Paid service</span>
            </div>
            <h3>Request a custom feature</h3>
            <p>Customization at your fingertips: Request personalized feature.</p>
            <form method="post">
              <input class="email" type="email" id="email" name="email" placeholder="E-mail" value="" autocomplete="email" required>
              <textarea class="content" id="request" name="request" rows="3" placeholder="Details about your request" value=""  required></textarea>
              <input class="uniqid" name="uniqid" value="<?php echo 'S3v2qn'.substr(wp_get_session_token(), 0, 10).base64_encode(sanitize_text_field($_SERVER['HTTP_HOST'])); ?>" hidden>
              <input name="submit-custom-feature-request" type="submit" value="Submit">
            </form>
        </div>
        <div class="item request-mail-template disabled">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><polyline points="48 24 32 40 16 24"></polyline></g></svg>
            <div class="mention paid">
                <span>Paid service</span>
            </div>
            <h3>Request a custom mail template</h3>
            <p>Make your Emails stand out: Request a custom mail template.</p>
            <form method="post">
              <input class="email" type="email" id="email" name="email" placeholder="E-mail" value="" autocomplete="email" required>
              <textarea class="content" id="request" name="request" rows="3" value=""  placeholder="Details about your request" required></textarea>
              <input class="uniqid" name="uniqid" value="<?php echo 'S3v2lv'.substr(wp_get_session_token(), 0, 10).base64_encode(sanitize_text_field($_SERVER['HTTP_HOST'])); ?>" hidden>
              <input type="submit" value="Submit" name="submit-custom-mail-template">
            </form>
        </div>        
    </div>
<?php 

include_once(AMBISN_PATH.'includes/blocks/feedback_popup.php');

?>