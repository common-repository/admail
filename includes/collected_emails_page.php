<?php

if (!defined('ABSPATH')) {
    exit;
}

$admail = new AmbisnSubscriptions;
$emails = $admail->get_emails();
$total_count = count($emails);

if ($total_count > 0) {
    ?>
    <div class="ambisn-table-wrapper collected-emails">
        <div class="ambisn-tab" value="emails">
            <div class="action-notice">Processing ...</div>
            <div class="actions-script"></div>
            <div class="actions">
                <div class="left">
                    <form method="post" action="">
                        <input class="ambisn-download" type="submit" name="ambisn_download_emails" value="Download emails as CSV">
                    </form>
                </div>
                <div class="right">
                    <div class="items-limit">
                        Emails per page
                        <?php
                        $limit = get_option('ambisn_table_emails_per_page');
                        if (!intval($limit)) {
                            update_option('ambisn_table_emails_per_page', '10');
                            $limit = '50';
                        }
                        ${'limit' . $limit} = 'selected';
                        ?>
                        <select class="emails-per-page" name="emails-per-page">
                            <option value="10" <?php echo isset($limit10) ? esc_attr($limit10) : ''; ?>>10</option>
                            <option value="50" <?php echo isset($limit50) ? esc_attr($limit50) : ''; ?>>50</option>
                            <option value="100" <?php echo isset($limit100) ? esc_attr($limit100) : ''; ?>>100</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <table class="ambisn">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Subscribed for</th>
                </tr>
            </thead>
            <tbody class="ambisn-table">
                <?php
                ambisn_collected_emails_table($limit, 1);
                ?>
            </tbody>
        </table>
        <?php
        if ($total_count > $limit) {
            echo '<div class="ambisn-table-pignation">';
            ambisn_table_pagination($total_count, $limit, 1);
            echo '</div>';
        }
        ?>
    </div>
    <?php
} else {
    
    ambisn_emptyResults();
    
}