<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'register_ambisn');

function register_ambisn(){
    
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'wc_admail';
    
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;
    
    $wc_activated = in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));
    
    $bisn_icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZwoJdmVyc2lvbj0iMS4xIgoJeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIgoJeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiCgl4PSIwJSIgeT0iMCUiCgl3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIgoJdmlld0JveD0iMCAwIDIwLjAgMjAuMCIKCWVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwLjAgMjAuMCIKCXhtbDpzcGFjZT0icHJlc2VydmUiPgoJPHBhdGgKCQlmaWxsPSIjMDAwMDAwIgoJCXN0cm9rZT0iI0ZGRkZGRiIKCQlmaWxsLW9wYWNpdHk9IjAuMDAwIgoJCXN0cm9rZS1vcGFjaXR5PSIxLjAwMCIKCQlmaWxsLXJ1bGU9Im5vbnplcm8iCgkJc3Ryb2tlLXdpZHRoPSIwLjE5OTk5OTk5IgoJCXN0cm9rZS1saW5lam9pbj0ibWl0ZXIiCgkJc3Ryb2tlLWxpbmVjYXA9InNxdWFyZSIKCQlkPSJNNC4xOSwwLjUyTDE1Ljg2LDAuNTJBMy41OSAzLjU5IDAgMCAxIDE5LjQ1LDQuMTFMMTkuNDUsMTUuOTZBMy41OSAzLjU5IDAgMCAxIDE1Ljg2LDE5LjU2TDQuMTksMTkuNTZBMy41OSAzLjU5IDAgMCAxIDAuNjAsMTUuOTZMMC42MCw0LjExQTMuNTkgMy41OSAwIDAgMSA0LjE5LDAuNTJ6Ii8+Cgk8cGF0aAoJCWZpbGw9IiNGRkZGRkYiCgkJc3Ryb2tlPSIjRkZGRkZGIgoJCWZpbGwtb3BhY2l0eT0iMC4xMjIiCgkJc3Ryb2tlLW9wYWNpdHk9IjEuMDAwIgoJCWZpbGwtcnVsZT0ibm9uemVybyIKCQlzdHJva2Utd2lkdGg9IjAuOTYxODYwNjYiCgkJc3Ryb2tlLWxpbmVqb2luPSJtaXRlciIKCQlzdHJva2UtbGluZWNhcD0ic3F1YXJlIgoJCWQ9Ik05LjI5LDEwLjA1QzguMjUsNy41OSw3LjIxLDUuMTIsOC40OSw0Ljk4QzkuNzcsNC44NSwxMy4zNyw3LjA0LDE1LjE3LDguMzhDMTYuOTYsOS43MywxNi45NiwxMC4yMiwxNS4xNywxMS41OEMxMy4zNywxMi45NSw5Ljc3LDE1LjE4LDguNDksMTUuMDdDNy4yMSwxNC45Niw4LjI1LDEyLjUxLDkuMjksMTAuMDV6Ii8+Cgk8cGF0aAoJCWZpbGw9IiMwMDAwMDAiCgkJc3Ryb2tlPSIjRkZGRkZGIgoJCWZpbGwtb3BhY2l0eT0iMC43MzciCgkJc3Ryb2tlLW9wYWNpdHk9IjAuNzQ5IgoJCWZpbGwtcnVsZT0ibm9uemVybyIKCQlzdHJva2Utd2lkdGg9IjAuOTYxODYwNjYiCgkJc3Ryb2tlLWxpbmVqb2luPSJtaXRlciIKCQlzdHJva2UtbGluZWNhcD0icm91bmQiCgkJZD0iTTkuMzAsMTAuMDBMMTEuNjUsMTAuMDMiLz4KCTxwYXRoCgkJZmlsbD0iIzAwMDAwMCIKCQlzdHJva2U9IiNGRkZGRkYiCgkJZmlsbC1vcGFjaXR5PSIwLjczNyIKCQlzdHJva2Utb3BhY2l0eT0iMC43NDkiCgkJZmlsbC1ydWxlPSJub256ZXJvIgoJCXN0cm9rZS13aWR0aD0iMC45NjE4NjA2NiIKCQlzdHJva2UtbGluZWpvaW49Im1pdGVyIgoJCXN0cm9rZS1saW5lY2FwPSJyb3VuZCIKCQlkPSJNNC4yMSw3LjU1TDYuMjQsNy41NSIvPgoJPHBhdGgKCQlmaWxsPSIjMDAwMDAwIgoJCXN0cm9rZT0iI0ZGRkZGRiIKCQlmaWxsLW9wYWNpdHk9IjAuNzM3IgoJCXN0cm9rZS1vcGFjaXR5PSIwLjc0OSIKCQlmaWxsLXJ1bGU9Im5vbnplcm8iCgkJc3Ryb2tlLXdpZHRoPSIwLjk2MTg2MDY2IgoJCXN0cm9rZS1saW5lam9pbj0ibWl0ZXIiCgkJc3Ryb2tlLWxpbmVjYXA9InJvdW5kIgoJCWQ9Ik01LjA2LDEwLjA1TDcuMDksMTAuMDUiLz4KCTxwYXRoCgkJZmlsbD0iIzAwMDAwMCIKCQlzdHJva2U9IiNGRkZGRkYiCgkJZmlsbC1vcGFjaXR5PSIwLjczNyIKCQlzdHJva2Utb3BhY2l0eT0iMC43NDkiCgkJZmlsbC1ydWxlPSJub256ZXJvIgoJCXN0cm9rZS13aWR0aD0iMC45NjE4NjA2NiIKCQlzdHJva2UtbGluZWpvaW49Im1pdGVyIgoJCXN0cm9rZS1saW5lY2FwPSJyb3VuZCIKCQlkPSJNNC4yMSwxMi4zN0w2LjI0LDEyLjM3Ii8+Cjwvc3ZnPg==';
    
    if(!$table_exists){
        
        add_menu_page( 'AdMail', 'AdMail', 'manage_options', 'ambisn_error', 'ambisn_fallback_callback',  $bisn_icon, 55.1);
        
    }
    elseif($wc_activated){
        
        $admail = new AmbisnSubscriptions;
    
        $subscritions_items = $admail->get_filtered_subscriptions('instock');
        
        $notification_count = count($subscritions_items);
        
        if($notification_count > 100){
            
            $notification_count = '100+';
            
        }
        
        $main_menu = $notification_count ? sprintf('AdMail <span class="awaiting-mod">%d</span>', $notification_count) : 'AdMail';
        
        add_menu_page( 'AdMail', 'AdMail', 'manage_options', 'ambisn', 'ambisn_callback',  $bisn_icon, 55.1);
        add_submenu_page('ambisn', 'Collected Emails', 'Collected Emails', 'manage_options', 'ambisn_collected_email', 'ambisn_collected_emails_callback' );
        add_submenu_page('', 'AdMail', 'AdMail', 'manage_options', 'ambisn_error', 'ambisn_fallback_callback' );        
        add_submenu_page('ambisn_nd', 'Sent', 'Sent', 'manage_options', 'ambisn_tab_sent', 'ambisn_tab_sent_callback' );
        add_submenu_page('ambisn_nd', 'Out of stock ptoducts', 'Out of stock ptoducts', 'manage_options', 'ambisn_tab_ofs', 'ambisn_tab_ofs_callback' );
        add_submenu_page('ambisn_nd', 'Available', 'Available', 'manage_options', 'ambisn_tab_waiting', 'ambisn_tab_available_callback' );
        add_submenu_page('ambisn_nd', 'Trashed', 'Trashed', 'manage_options', 'ambisn_tab_trashed', 'ambisn_tab_trashed_callback' );
        add_submenu_page('ambisn', 'Settings', 'Settings', 'manage_options', 'ambisn_settings', 'ambisn_settings_callback' );
        if(!in_array('admail-pro/index.php', apply_filters( 'active_plugins', get_option('active_plugins')))){
           add_submenu_page('ambisn', 'Get Pro', 'Get Pro - Free trial', 'manage_options', 'ambisn_get_pro', 'ambisn_get_pro_callback' );
        }
    }
    else{
        add_menu_page( 'AdMail', 'AdMail', 'manage_options', 'ambisn_error', 'ambisn_fallback_callback',  $bisn_icon, 55.1);
        add_submenu_page('', 'AdMail', 'AdMail', 'manage_options', 'ambisn_error', 'ambisn_fallback_callback' );        
        add_submenu_page('', 'Sent', 'Sent', 'manage_options', 'ambisn_tab_sent', 'ambisn_fallback_callback' );
        add_submenu_page('', 'Out of stock ptoducts', 'Out of stock ptoducts', 'manage_options', 'ambisn_tab_ofs', 'ambisn_fallback_callback' );
        add_submenu_page('', 'Available', 'Available', 'manage_options', 'ambisn_tab_waiting', 'ambisn_fallback_callback' );
        add_submenu_page('', 'Trashed', 'Trashed', 'manage_options', 'ambisn_tab_trashed', 'ambisn_fallback_callback' );
        add_submenu_page('', 'settings', 'Settings', 'manage_options', 'ambisn_settings', 'ambisn_fallback_callback' );
        add_submenu_page('', 'All product', 'All Products', 'manage_options', 'ambisn_all_products', 'ambisn_fallback_callback' );
    }
    //add_action('admin_enqueue_scripts', 'ambisn_admin_scripts');
}

function ambisn_fallback_callback() {
    
    include_once (AMBISN_PATH.'includes/blocks/fallback_content.php');
    
}


function ambisn_callback(){
    ?>
    <div class="ambisn ambisn-tab overview">
        <div class="ales-div-header"><h3>AdMail</h3></div>
        <div class="ajax-load"><div>
        <?php 
        include_once (AMBISN_PATH.'includes/blocks/tabs_filter.php');
        include_once (AMBISN_PATH.'includes/tabs/overview_page.php');
        ?>
    </div>
    <?php
    
}

function ambisn_settings_callback(){
    ?>
    <div class="ambisn ambisn-tab settings">
        <div class="ales-div-header"><h3>Settings</h3></div>
        <div class="ajax-load"></div>
        <?php 
        include_once (AMBISN_PATH.'includes/blocks/tabs_filter.php');
        include_once (AMBISN_PATH.'includes/settings_page.php');
        ?>
    </div>
    <?php
}

function ambisn_tab_sent_callback(){
    
    echo '<div class="ambisn ambisn-tab sent" value="sent">';
    
    ambisn_tabsPage('sent');
    
    echo '</div>';
    
}

function ambisn_tab_ofs_callback(){
    
    echo '<div class="ambisn ambisn-tab ofs" value="ofs">';
    
    ambisn_tabsPage('ofs');
    
    echo '</div>';
    
}

function ambisn_tab_available_callback(){
    
    echo '<div class="ambisn ambisn-tab instock" value="instock">';
    
    ambisn_tabsPage('instock');
    
    echo '</div>';
    
}

function ambisn_tab_trashed_callback(){
    
    echo '<div class="ambisn ambisn-tab trashed" value="trashed">';
    
    ambisn_tabsPage('trashed');
    
    echo '</div>';
    
}

function ambisn_tabsPage($tab){
    
    echo '<div class="ales-div-header"><h3>Manage Subscriptions</h3></div>';
    
    echo '<div class="ajax-load"></div>';

    include_once (AMBISN_PATH.'includes/blocks/tabs_filter.php');
    
    $admail = new AmbisnSubscriptions;
    
    $subscritions_items = $admail->get_filtered_subscriptions($tab);
    
    $count = count($subscritions_items);
    
    if($count > 0){
        
        ambisn_generateTable($tab, 5);
        
    }else{
        
        ambisn_emptyResults();
        
    }
}

if (isset($_POST['reset_admail_data'])) {
    $site = site_url();
    $logo = esc_url(wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0]);
    if(empty($logo)){
        $logo = AMBISN_URL.'assets/images/wp-logo.png';
    }    
    $site_title = get_bloginfo('name');

    $ambisn_settings = array(
        'guests'=>'1',
        'unsubscribe'=>'1',
        'email_field'=>'1',
        'auto_submission'=>'0',
        'popup'=>'0',
        'ajaxify_submission'=>'1',
        'form_text'=>'Be the first to know once this product is back in stock',
        'form_subscribed_text'=>'Your subscription request has been received!',
        'form_previously_subscribed_notice'=>'A previous subscription with this email found!',
        'button_text'=>'SUBSCRIBE',
        'button_bg_color'=>'#fd6e4f',
        'button_text_color'=>'#fff',
        'button_border_radius'=>'0px',
        'unsubscribe_text'=>'Unsubscribe?',
        'store_logo'=> $logo,
        'store_name'=>$site_title,
        'store_email'=>'info',
        'no_reply'=>'0',
        'email_price'=>'1',
        'email_qty'=>'1',
        'email_subject'=>'The product you subscribed for is back in stock!',
        'email_heading'=>'YOU ARE IN LUCK!',
        'email_subheading'=>'The sold out product you liked is back in stock.',
        'email_footer' => 'Sent with love by '.$site_title,
        'email_template'=>'default',
    );
    
    global $wpdb;
    $wpdb->hide_errors();
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $table_name = $wpdb->prefix . 'wc_admail';
    $charset_collate = $wpdb->get_charset_collate();

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !== $table_name) {
        $sql = "CREATE TABLE `$table_name` (
            ID INT NOT NULL AUTO_INCREMENT,
            option_name TEXT,
            option_type TEXT,
            value TEXT,
            date DATE,
            PRIMARY KEY (ID)
        ) $charset_collate;";

        $db_delta_result = dbDelta($sql);
        $wpdb->insert($table_name, array('option_name' => 'admail_settings', 'value' => serialize($ambisn_settings), 'option_type' => 'setting'));
        return $db_delta_result;
        
    }else{
        $sql = "SELECT `value` FROM `$table_name` WHERE `option_name` = 'admail_settings' AND `option_type` = 'setting'";
        $existing_settings = $wpdb->get_var($sql);
        $existing_settings = unserialize($existing_settings);
        $updated_settings = array_merge($ambisn_settings, $existing_settings);
        $wpdb->update($table_name, array('value' => serialize($updated_settings)), array('option_name' => 'admail_settings', 'option_type' => 'setting'));
    }
}

if (isset($_POST['ambisn_download_emails'])) {
    $emailArray = ambisn_collected_emails('emails', 'all');

    $csvFileName = 'AdMail_Emails.csv';
    $csvFilePath = fopen($csvFileName, 'w');

    foreach ($emailArray as $email) {
        fputcsv($csvFilePath, array($email));
    }

    fclose($csvFilePath);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $csvFileName . '"');

    readfile($csvFileName);

    unlink($csvFileName);
    
    exit;
}



function ambisn_collected_emails_callback(){
    ?>
    <div class="ambisn ambisn-tab" value="emails">
        <div class="ales-div-header"><h3>Collected Emails</h3>
        <?php 
        if(!in_array('admail-pro/index.php', apply_filters( 'active_plugins', get_option('active_plugins')))){
           ?>
            <a class="send-promo" href="https://plugins.aleswebs.com/" target="_blank" value="enabled">Send promotional emails
                <img width="15px" src="<?php echo esc_url(AMBISN_URL); ?>assets/images/lock.png">
            </a>           
           <?php
        }
        ?> 
        </div>
        <div class="ajax-load">
            <div>
        <style>a.esc_html(settings){background-color: #7350ff !important;color: #fff !important;}</style>
        <?php 
        include_once (AMBISN_PATH.'includes/collected_emails_page.php');
        ?>
    </div>
    <?php    
}





function ambisn_tabsActions($tab){
    ?>
    <div class="action-notice">Processing ...</div>
    <div class="actions-script"></div>
    <div class="actions">
        <div class="left">
    <?php
        switch($tab){
        case "all":
        case "instock":
            ?>
            <a class="send-notice" value="sent">Send Notice</a>
            <a class="trashed" value="trashed">Move to trash</a>  
            <?php
        break;
        case "sent":
            ?>
            <a class="trashed" value="trashed">Move to trash</a> 
            <a class="enabled" value="enabled">Restore</a> 
            <?php
        break;            
        case "ofs":
            ?>
            <a class="trashed" value="trashed">Move to trash</a>  
            <?php
        break;
        case "trashed":
            ?>
            <a class="delete" value="delete">Delete</a>
            <a class="enabled" value="enabled">Restore</a>
            <?php
        break;
    ?>
    <?php
    }
    ?>
        </div>
    <div class="right">
        <div class="search-product">
            <input name="product-name" class="product-name" placeholder="Filter by product" value="">
        </div>
        <div class="items-limit">
            Items per page
            <?php 
            $limit = get_option('ambisn_table_items_per_page');
            ${'limit' . $limit} = 'selected';
            ?>
            <select class="items-per-page" name="items-per-page">
                <option value="10" <?php echo isset($limit10) ? esc_attr($limit10) : ''; ?>>10</option>
                <option value="50" <?php echo isset($limit50) ? esc_attr($limit50) : ''; ?>>50</option>
                <option value="100" <?php echo isset($limit100) ? esc_attr($limit100) : ''; ?>>100</option>
            </select>
        </div>
    </div>
    
    </div>
  <?php
}

function ambisn_table_pagination($totalcount, $limit, $page){
    $total_pages = ceil($totalcount / $limit);
    $pagination_html = '';
    for ($i = 1; $i <= $total_pages; $i++) {
        if($i == $page){
            $pagination_html .= '<a class="active" value="'.$i.'">' . $i . '</a>';
        }
        else{
            $pagination_html .= '<a value="'.$i.'">' . $i . '</a>';
        }
    }
    echo $pagination_html;
}

function ambisn_allProducts(){
    ?>
    <div class="sec-heading">
        <h1>Most Wanted Products</h1>
    </div>
    <?php 
        $products = ambisn_get_products();
        $order = 0;
        foreach($products as $product_id => $subscribersCount){
            $product = wc_get_product($product_id);
            $product_availability = $product->is_in_stock( );
            $parent_id = $product->get_parent_id();
            if($parent_id == '0'){
                $image = wp_get_attachment_url( $product->get_image_id());
                $url = $product->get_permalink();
                $name = $product->get_title();
                $label = '';
            }
            else{
                $variation = wc_get_product($product_id);
                $url = $variation->get_permalink();
                $name = $variation->get_name();
                $label = ' -variation-';
                $image = wp_get_attachment_url( $variation->get_image_id()); 
            }
            if(empty($image)){
                $image = AMBISN_URL.'assets/images/no_image.png';
            }
            $url = $product->get_permalink();
            if ($product->is_in_stock()){
               $stock_status = 'In Stock';    
            }
            else{
                $stock_status = 'Out of stock';
            }
            if($subscribersCount > 1){
                $countText = $subscribersCount.'<span> subscribers</span>';
            }else{
                $countText = $subscribersCount.'<span> subscriber</span>';
            }
            $order++;
            ?>
            <div class="ambisn-most-wanted order<?php echo esc_attr($order); ?>">
                <h3>#<?php echo esc_html($order); ?></h3>
                <img width="60px" src="<?php echo esc_url($image); ?>">
                <div class="product">
                    <h3><?php echo esc_html($name); ?></h3>
                    <p>ID: <?php echo esc_attr($product_id).esc_html($label); ?></p>
                </div>
                <p><?php echo wp_kses_post($countText); ?></p>
                <p class="stock-status"><?php echo esc_html($stock_status); ?></p>
                <a href="<?php echo esc_url($url); ?>">View</a>
            </div>
            <?php
        }
}

function ambisn_generateTable($tab, $limit, $page = 1){
    
    $admail = new AmbisnSubscriptions;
    
    $subscritions_items = $admail->get_filtered_subscriptions($tab);
    
    $limit = esc_attr(get_option('ambisn_table_items_per_page'));
    
    if(empty($limit)){
        
        $limit = 50;
        
    }
    
    ?>
    <div class="ambisn-table-wrapper">
        
        <?php ambisn_tabsActions($tab); ?>
        
        <table class="ambisn">
            <thead>
                <tr>
                    <th class="check"><input id="cb-select" type="checkbox" name="post[]" value=""></th>
                    <th >Product</th>
                    <th>Customer's Email</th>
                    <th>Subscribed on</th>
                    <th class="out-of-stock">Stock Status</th>
                </tr>
            </thead>
            <tbody class="ambisn-table">
            <?php
            ambisn_table_rows($subscritions_items, $limit, $page, $tab);
            ?>
            </tbody>
        </table>
        <?php
        $total_count = count($subscritions_items);
        if($total_count > $limit){
            echo '<div class="ambisn-table-pignation">';
            ambisn_table_pagination($total_count , $limit, $page);
            echo '</div>';
        }
        ?>
    </div>
<?php
}
function ambisn_get_subscriptions_items($tab){
    $subscriptions = ambisn_get_subscriptions($tab);
    $subscritions_items = array();
    foreach($subscriptions as $product_id => $product_data){
        foreach($product_data as $email => $status){
            $subscritions_items[] = array('id'=>$product_id, 'email'=> $email, 'status'=>$status);
        }
    }
    return $subscritions_items;
}

function ambisn_get_subscriptions_by_product($tab, $product_ids) {
    
    $admail = new AmbisnSubscriptions;
    
    $subscritions_items = $admail->get_filtered_subscriptions($tab);
    
    $filtered_items = array();
    
    foreach($subscritions_items as $item){
        
        $product_id = $item['product_id'];
        
        if(in_array($product_id, $product_ids)){
            
            $filtered_items[] = $item;
        }
        
    }
    
    return $filtered_items;
}

function ambisn_collected_emails_table($limit,$page){
    
    $admail = new AmbisnSubscriptions;

    $emails = $admail->get_emails();
    
    $start = ($page * $limit) - $limit;
    
    foreach( array_slice($emails, $start, $limit, true) as $collected_email){
        ?> 
        <tr>
            <td>
                <p class="email"><?php echo esc_html($collected_email); ?></p>
            </td>
            <td>
                <?php 
                
                $product_ids = $admail->get_products($collected_email); 
                
                if(count($product_ids) == '0'){
                    
                    echo '<p>The subscription has been canceled or deleted.</p>';
                    
                }foreach($product_ids as $product_id){
                    
                    $product = wc_get_product($product_id);
                    
                    if($product){
                        
                        $is_variation = false;
                        
                        $parent_id = $product->get_parent_id();
                        
                        if($parent_id != '0'){
                            
                            $is_variation = true;
                            
                        }
                        
                        $image = wp_get_attachment_url( $product->get_image_id());
                        
                        if(empty($image)){
            
                            $image = AMBISN_URL.'assets/images/no_image.png';
            
                        } 
                        
                        $url = $product->get_permalink();
                        
                        ?>
                        <a style="display:inline;" href="<?php echo esc_url($url); ?>">
                            <img width="60px" src="<?php echo esc_url($image); ?>">
                        </a>
                        <?php
                        
                    }

                }
                ?>
            </td>
        </tr>
        <?php        
    }
}

function ambisn_table_rows($subscritions_items, $limit, $page, $tab){
    
    $start = ($page * $limit) - $limit;
    
    foreach( array_slice($subscritions_items, $start, $limit, true) as $item){
        
        $product_id = $item['product_id'];
        
        $product = wc_get_product($product_id);
        
        if($product){
        
            $product_availability = $product->is_in_stock( );
            
            $is_variation = false;
            
            if($product->get_parent_id() != '0'){
                
                $is_variation = true;
                
            }
            
            $label = '';
            
            $image = wp_get_attachment_url( $product->get_image_id());
            
            $url = $product->get_permalink();
            
            if($is_variation){
                
                $name = $product->get_name();
                
                $label = ' -variation-';
                
            }else{
                
                $name = $product->get_title();
                
            }
        
            if(empty($image)){
            
                $image = AMBISN_URL.'assets/images/no_image.png';
            
            }
            
            $email = $item['email'];
        
            $date = $item['date'];
            
            if(isset($item['lang']) && $item['lang'] != ''){
                
                $lang = $item['lang'];
                
                $lang_html = '<span class="lang">'.esc_html($lang).'</span>';
                
            }else{
                
                $lang = '-';
                
                $lang_html = '<span class="lang">Language undefined</span>';
                
            }
            

        
            $dateFormat = get_option('date_format');
        
            $timeFormat = get_option('time_format');

            if (strpos($date, ' ') !== false) {
            
                   $formattedDate = date($dateFormat . ' ' . $timeFormat, strtotime($date));
               
            } else {
            
                $formattedDate = date($dateFormat, strtotime($date));
            
            }

        $time_difference = ambisn_getTimeDifference($date);
        
        if(email_exists($email)){
            $user = get_user_by('email',$email);
            $username = $user->display_name;
            $userHTML = '<div class="user registred"><p>'.$username.'<span>Registred</span></p></div>';
        }
        else{
            $userHTML = '<div class="user guest"></div>';
        }
        if ($product->is_in_stock()){
           $stock_status = 'In Stock'; 
           $avail_class = "in-stock";
        }
        else{
            $stock_status = 'Out of stock';
            $avail_class = "out-of-stock"; 
        }
        ?>   
        <tr>
           <td><input name="cb-select<?php echo esc_attr($item['product_id']); ?>" class="cb-select<?php echo esc_attr($item['product_id']); ?>" type="checkbox" email="<?php echo esc_attr($item['email']); ?>" value="<?php echo esc_attr($item['product_id']); ?>"></td>
           <td class="product"><img width="60px" src="<?php echo esc_url($image); ?>"><div><a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_html($name); ?></a><p><?php echo esc_html('ID: '.$product_id.$label); ?></p></div></td>
           <td><p class="email"><?php echo esc_html($email); ?></p><?php echo wp_kses_post($userHTML);?></td>
           <td>
            <p class="date"><?php echo esc_html($formattedDate); ?></p>
            <div class="lang-days">
                <p>
                    <span class="in_days"><?php echo esc_html($time_difference); ?></span>
                    <span><?php echo wp_kses_post($lang_html); ?></span>
                </p>
            </div>
           
           </td>
           <td class="<?php echo esc_attr($avail_class); ?>"><span><?php echo esc_html($stock_status); ?></span></td>
        </tr>
        <?php
        }
    }
}

function ambisn_getTimeDifference($date){
    
    $from = strtotime($date);
    $today = time();
    $difference = $today - $from;

    if (empty($date)) {
        return '';
    }

    if ($difference < 60) {
        return $difference . ' second' . ($difference != 1 ? 's' : '') . ' ago';
    } elseif ($difference < 3600) {
        $minutes = floor($difference / 60);
        return $minutes . ' minute' . ($minutes != 1 ? 's' : '') . ' ago';
    } elseif ($difference < 86400) {
        $hours = floor($difference / 3600);
        return $hours . ' hour' . ($hours != 1 ? 's' : '') . ' ago';
    } else {
        $days = floor($difference / 86400);
        return $days . ' day' . ($days != 1 ? 's' : '') . ' ago';
    }
}

function ambisn_load_most_wanted_products(){
    
    ob_start();
    
    $limit = 100;
    
    include_once(AMBISN_PATH.'includes/blocks/most_wanted_products.php');
    
    echo ob_get_clean();
    
    die();
}
add_action('wp_ajax_ambisn_load_most_wanted_products','ambisn_load_most_wanted_products');

function ambisn_update_items_per_page(){
    
    if(isset($_REQUEST)){
        
	    $tab = sanitize_text_field($_REQUEST['tab']);
	    $value = sanitize_text_field($_REQUEST['value']);
	    update_option('ambisn_table_items_per_page', $value);
	    
	    $admail = new AmbisnSubscriptions;
    
        $subscritions_items = $admail->get_filtered_subscriptions($tab);
	    $count = count($subscritions_items);
        if($count > 0){
            ambisn_generateTable($tab, 5);
        }
        else{
            ambisn_emptyResults();
        }
        die();
    }
}
add_action('wp_ajax_ambisn_update_items_per_page','ambisn_update_items_per_page');

function ambisn_update_emails_per_page(){
    
    if(isset($_REQUEST)){
        
	    $value = sanitize_text_field($_REQUEST['value']);
	    
	    update_option('ambisn_table_emails_per_page', $value);
	    
        if($value > 0){
            
            include_once (AMBISN_PATH.'includes/collected_emails_page.php');
            
        }
        
    }
    
    die();
    
}
add_action('wp_ajax_ambisn_update_emails_per_page','ambisn_update_emails_per_page');

function ambisn_load_table_pagination_rows(){
    
    if(isset($_REQUEST)){
        
        $page = sanitize_text_field($_REQUEST['selectedPage']);
        
        $tab = sanitize_text_field($_REQUEST['tab']);
        
        if(empty($limit)){
            
            $limit = 50;
            
        }
        if($tab == 'emails'){
            
            $limit = esc_attr(get_option('ambisn_table_emails_per_page'));
            
            $emails = ambisn_collected_emails('emails', 'all');
            
            ambisn_collected_emails_table($limit,$page);
            
        }else{
            
            $admail = new AmbisnSubscriptions;
    
            $subscritions_items = $admail->get_filtered_subscriptions($tab);
            
            $limit = esc_attr(get_option('ambisn_table_items_per_page'));
            
            ambisn_table_rows($subscritions_items, $limit, $page, $tab);
            
        }
        die();
    }
}
add_action('wp_ajax_ambisn_load_table_pagination_rows','ambisn_load_table_pagination_rows');

function ambisn_load_tab_content(){
    
    $response = array();
    
	if(isset($_REQUEST['tab'])){
	    
	    $tab = sanitize_text_field($_REQUEST['tab']);
	    
	    $admail = new AmbisnSubscriptions;
    
        $subscritions_items = $admail->get_filtered_subscriptions($tab);
	    
        $count = count($subscritions_items);
        
        ob_start();
        
        include_once (AMBISN_PATH.'includes/blocks/tabs_filter.php');
        
        $response['filter'] = ob_get_clean();
        
        ob_start();
        
        if($count > 0){
            
            ambisn_generateTable($tab, 5);
            
        }else{
            
            ambisn_emptyResults();
            
        }
        
        $response['table'] = ob_get_clean();
        
        echo json_encode($response);
	}
	
	die();
}
add_action('wp_ajax_ambisn_load_tab_content','ambisn_load_tab_content');


function ambisn_emptyResults(){
    ?>
    <div class="no_results">
    <svg viewBox="0 0 32 32" enable-background="new 0 0 32 32" id="_x3C_Layer_x3E_" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="search_x2C__magnifier_x2C__magnifying_x2C__emoji_x2C__happy"> <g id="XMLID_1949_"> <g id="XMLID_2132_"> <path d="M12,14.521h2c0,0.55-0.45,1-1,1S12,15.07,12,14.521z" fill="#263238" id="XMLID_2137_"></path> <path d="M17.5,13c0.27,0,0.5,0.23,0.5,0.5S17.77,14,17.5,14S17,13.77,17,13.5S17.23,13,17.5,13z " fill="#263238" id="XMLID_2134_"></path> <path d="M8.5,13C8.77,13,9,13.23,9,13.5S8.77,14,8.5,14S8,13.77,8,13.5S8.23,13,8.5,13z" fill="#263238" id="XMLID_2133_"></path> </g> </g> <g id="XMLID_1838_"> <g id="XMLID_4088_"> <line fill="none" id="XMLID_4094_" stroke="#455A64" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="23.43" x2="21.214" y1="23.401" y2="21.186"></line> <path d=" M29.914,27.086l-3.5-3.5c-0.756-0.756-2.072-0.756-2.828,0C23.208,23.964,23,24.466,23,25s0.208,1.036,0.586,1.414l3.5,3.5 c0.378,0.378,0.88,0.586,1.414,0.586s1.036-0.208,1.414-0.586S30.5,29.034,30.5,28.5S30.292,27.464,29.914,27.086z" fill="none" id="XMLID_4093_" stroke="#455A64" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <circle cx="13" cy="13" fill="none" id="XMLID_4092_" r="11.5" stroke="#455A64" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></circle> <path d=" M12,14.521h2c0,0.55-0.45,1-1,1S12,15.07,12,14.521z" fill="none" id="XMLID_4091_" stroke="#455A64" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M17.5,13c0.27,0,0.5,0.23,0.5,0.5S17.77,14,17.5,14S17,13.77,17,13.5S17.23,13,17.5,13z" fill="none" id="XMLID_4090_" stroke="#455A64" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M8.5,13C8.77,13,9,13.23,9,13.5S8.77,14,8.5,14S8,13.77,8,13.5S8.23,13,8.5,13z" fill="none" id="XMLID_4089_" stroke="#455A64" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> </g> <g id="XMLID_3004_"> <line fill="none" id="XMLID_4087_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="23.43" x2="21.214" y1="23.401" y2="21.186"></line> <path d=" M29.914,27.086l-3.5-3.5c-0.756-0.756-2.072-0.756-2.828,0C23.208,23.964,23,24.466,23,25s0.208,1.036,0.586,1.414l3.5,3.5 c0.378,0.378,0.88,0.586,1.414,0.586s1.036-0.208,1.414-0.586S30.5,29.034,30.5,28.5S30.292,27.464,29.914,27.086z" fill="none" id="XMLID_3009_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <circle cx="13" cy="13" fill="none" id="XMLID_3008_" r="11.5" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></circle> <path d=" M12,14.521h2c0,0.55-0.45,1-1,1S12,15.07,12,14.521z" fill="none" id="XMLID_3007_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M17.5,13c0.27,0,0.5,0.23,0.5,0.5S17.77,14,17.5,14S17,13.77,17,13.5S17.23,13,17.5,13z" fill="none" id="XMLID_3006_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M8.5,13C8.77,13,9,13.23,9,13.5S8.77,14,8.5,14S8,13.77,8,13.5S8.23,13,8.5,13z" fill="none" id="XMLID_3005_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> </g> </g> </g> </g></svg><h1>Nothing Here!</h1>
     </div>
    <?php
}

function ambisn_hide_wp_notices() {
    
    global $parent_file;
    
    if($parent_file == 'ambisn' || $parent_file == 'ambisn_nd'){
        
        echo '<style>#wpbody-content > .notice, #wpbody-content > .error { display: none !important; }</style>';
        
    }
}
add_action( 'current_screen', 'ambisn_hide_wp_notices' );

function ambisn_get_pro_callback(){
    
    wp_redirect('https://plugins.aleswebs.com/');
    
    exit;
}