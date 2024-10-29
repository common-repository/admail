<?php

if (!defined('ABSPATH')) {
    exit;
}

$admail = new AmbisnSubscriptions;
    
?>
<div class="filter">
    <div>
        <a class="overview" href="admin.php?page=ambisn" value="all">Overview</a>
        <a class="instock" href="admin.php?page=ambisn_tab_waiting" value="waiting">In Queue <?php echo '<span class="count">'.esc_html(count($admail->get_filtered_subscriptions('instock'))).'</span>'; ?></a>
        <a class="ofs" href="admin.php?page=ambisn_tab_ofs" value="out_of_stock">Sold Out <?php echo '<span class="count">'.esc_html(count($admail->get_filtered_subscriptions('ofs'))).'</span>'; ?> </a>
    </div>
    <div>
        <a class="sent" href="admin.php?page=ambisn_tab_sent" value="sent">Sent <?php echo '<span class="count">'.count($admail->get_filtered_subscriptions('sent')).'</span>'; ?></a>
        <a class="trashed" href="admin.php?page=ambisn_tab_trashed" value="trashed">Trashed <?php echo '<span class="count">'.esc_attr(count($admail->get_filtered_subscriptions('trashed'))).'</span>'; ?></a>   
        <a class="settings" href="admin.php?page=ambisn_settings" value="settings"><img width="20px" src="<?php echo esc_attr(AMBISN_URL); ?>assets/images/settings.svg"><p>Settings</p></a>   
    </div>
 </div>