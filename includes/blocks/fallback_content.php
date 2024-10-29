<?php

if (!defined('ABSPATH')) {
    exit;
}   
   
global $wpdb;
    
$table_name = $wpdb->prefix . 'wc_admail';
    
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;
    
$wc_activated = in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));

if ($table_exists && $wc_activated) {
        
    $redirect_url = admin_url('admin.php?page=ambisn');
        
    wp_redirect($redirect_url);
    
    exit;
        
} else {
        
    ?>
    <div class="admail-error-page">
        <img width='70' src='<?php echo esc_url(AMBISN_URL . 'assets/images/ambisn.svg'); ?>'>
        <h3>OOPS, SOMETHING WENT WRONG</h3>
        <?php
            
        if (!$table_exists) {
                
            ?>
            <p>We encountered an issue while trying to find the necessary resources for AdMail to function correctly.</p>
            <form method="post" action="">
                <button type="submit" name="reset_admail_data">Reset AdMail Data</button>
            </form>
            <p><em>Note: Resetting AdMail data will restore the settings and collected data to their default values.</em></p>
            <?php
            
        } else {
            
            echo "And we think it's WooCommerce not being active.";
        }
        
    echo '</div>';
}