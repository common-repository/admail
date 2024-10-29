<?php 

if(isset($preview) && $preview){
    
    $random_product = wc_get_products(array(
        'orderby' => 'rand',
        'limit' => 1,
        'status' => 'publish'
    ));

    if (!empty($random_product) && has_post_thumbnail($random_product[0]->get_id())) {
        $product_id = $random_product[0]->get_id();
        $parent_id = $random_product[0]->get_parent_id(); 
        $image = wp_get_attachment_url($random_product[0]->get_image_id());
        $product_url = get_permalink($product_id);
        $name = $random_product[0]->get_name();
    
    } else {
    // Static data as fallback
        $product_id = '1234';
        $parent_id = '2342';
        $image = AMBISN_URL.'assets/images/no_image.png';
        $product_url = '#';
        $name = 'Product Name';
    }

}else{
    if(isset($product_id)){
        $product = wc_get_product( $product_id );
        $parent_id = $product->get_parent_id();
        if($parent_id == '0'){
            $image = wp_get_attachment_url( $product->get_image_id());
            $product_url = $product->get_permalink();
            $name = $product->get_title();
        }
        else{
            $variation = wc_get_product($product_id);
            $product_url = $variation->get_permalink();
             $name = $variation->get_name();
            $product_id.= ' -variation-';
            $image = wp_get_attachment_url( $variation->get_image_id()); 
        }
    }else{
        return;
    }
}
    
$theme_color = ambisn_get_setting('email_theme_color');
if(empty($theme_color)){
    $theme_color = '#333333';
}

$logo = ambisn_get_setting('store_logo');
if(empty($logo)){
   $logo = esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] );
    if(empty($logo)){
        $logo = AMBISN_URL.'assets/images/wp-logo.png';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html(ambisn_get_translated('conf_email_subject')); ?></title>
    <style>
    </style>
</head>
<body style="text-align: center, font-family: Arial, sans-serif;">
    <table style="background-color:#F6F6F6; width:100%;" align="center" border="0" cellpadding="0" cellspacing="0">
        <tbody style="text-align: center;">
            <tr>
                <td>
                    <table style="max-width: 500px; margin: 0 auto; background-color:#fff;" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody style="text-align: center;">
        <tr>
            <td style="padding:20px;">
                <img width="70" src="<?php echo esc_url($logo); ?>">
            </td>
        </tr>
        <tr>
            <td style="padding:20px; color:#fff; background-color:<?php echo esc_attr($theme_color); ?>;">
                <h1 style="color:#fff; font-size:18px; margin:unset">
                    <?php echo esc_html(ambisn_get_translated('conf_email_heading')); ?>
                </h1>
            </td>
        </tr>
        <tr>
            <td style="padding:20px 20px 0 20px;">    
                <p style="font-size:15px;"><?php echo esc_html(ambisn_get_translated('conf_email_subheading')); ?></p>
            </td>
        </tr>
        <tr>
            <td style="padding:20px;">    
                <img width="200" src="<?php echo esc_url($image); ?>">
                <a href="<?php echo esc_url($product_url); ?>" style="color:#444; font-size:15px;display:block; padding:10px;"><?php echo esc_html($name); ?></a>
            </td>
        </tr>        
        <tr>
            <td style="padding:10px; color:#fff; background-color:<?php echo esc_attr($theme_color); ?>90;">
                <p style="color:#fff; font-size:14px; margin:unset;">
                    <?php echo esc_html(ambisn_get_translated('conf_email_footer')); ?>
                </p>
            </td>
        </tr>        
        </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</body>

