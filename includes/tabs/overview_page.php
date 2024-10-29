<?php

if (!defined('ABSPATH')) {
    exit;
}

$admail = new AmbisnSubscriptions;

if(ambisn_empty_data()){
    
    $subscribersCount = rand(70, 999);
        
    $sentCount = rand(70, 999);
        
    $collectedEmailsCount = rand(70, 999);    
    
}else{
    
    $subscribersCount = array_sum(ambisn_get_data('subscribers_count','all'));
        
    $sentCount = array_sum(ambisn_get_data('notification_sent','all'));
        
    $collectedEmailsCount = count($admail->get_emails());
    
}

?>
<div class="overview-container">
    <?php 
    if(ambisn_empty_data()){
        
        ?>
        
        <div class="preview-notice">
            <svg fill="#ff9800" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>notice</title> <path d="M15.5 3.5c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM15.5 23.875c-0.829 0-1.5-0.672-1.5-1.5s0.671-1.5 1.5-1.5c0.828 0 1.5 0.672 1.5 1.5s-0.672 1.5-1.5 1.5zM17 17.375c0 0.828-0.672 1.5-1.5 1.5-0.829 0-1.5-0.672-1.5-1.5v-7c0-0.829 0.671-1.5 1.5-1.5 0.828 0 1.5 0.671 1.5 1.5v7z"></path> </g></svg>
            <h3>We're currently showing mock data until real subscription data is available.</h3>
        </div>
        
        <?php
    }
    ?>
    <div class="section-container most-wanted-container">
        <div class="sec-heading">
            <h1>Most Wanted Products</h1>
            <a class="all-products view" href="admin.php?page=ambisn_all_products">View all</a>
        </div>
        <div class="products">
        <?php 
        
        $limit = 3;
        include_once(AMBISN_PATH.'includes/blocks/most_wanted_products.php');
        
        ?>
        </div>
    </div>
    <div class="section-container">
        <div class="statistics">
            <div class="collected">
                <div class="info">
                    <img width="20px" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/inbox1.svg">
                    <p class="number"><?php echo esc_html($collectedEmailsCount); ?></p>
                    <p class="title">Collected Emails</p>
                </div>
                <div class="chart">
                    <?php echo wp_kses_post($admail->get_chart_html('collected_emails')); ?>
                </div>
            </div>
            <div class="sent">
                <div class="info">
                    <img width="20px" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/sent1.svg">
                    <p class="number"><?php echo esc_html($sentCount); ?></p>
                    <p class="title">Emails Sent</p>
                </div>
                <div class="chart">
                    <?php echo wp_kses_post($admail->get_chart_html('notification_sent')); ?>
                </div>
            </div>
            <div class="subscription">
                <div class="info">
                    <img width="20px" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/subscription1.svg">
                    <p class="number"><?php echo esc_html($subscribersCount); ?></p>
                    <p class="title">Subscription</p>
                </div>
                <div class="chart">
                    <?php echo wp_kses_post($admail->get_chart_html('subscribers_count')); ?>
                </div>
            </div>
        </div>
    </div>
</div>