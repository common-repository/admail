<?php 

if(isset($preview) && $preview){
    $product = '1234';
    $parent_id = '2342';
    $image = AMBISN_URL.'assets/images/no_image.png';
    $product_url = '#';
    $name = 'Product Name';
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Subscription Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
        p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>

<table class="container">
    <tr>
        <td style="padding: 20px;">
            <h1>Hello,</h1>

            <table>
                <tr>
                    <td style="padding:20px; color:#fff; background-color:<?php echo esc_attr($theme_color); ?>;">
                        <h1 style="text-align:center; color:#fff; font-size:18px; margin:unset">You have a new subscription on your store!</h1>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br><strong>Subscriber's email:</strong> <a href="mail-to:<?php echo esc_html($user_email); ?>" style="text-decoration: none; color: #0073aa;"><?php echo esc_html($user_email); ?></a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; padding:20px;">    
                        <img width="200" src="<?php echo esc_url($image); ?>">
                        <a href="<?php echo esc_url($product_url); ?>" style="color:#444; font-size:15px;display:block; padding:10px;"><?php echo esc_html($name); ?></a>
                    </td>
                </tr> 
                <tr>
                    <td style="padding:10px; color:#fff; background-color:<?php echo esc_attr($theme_color); ?>90;">
                        <p style="text-align:center; color:#fff; font-size:14px; margin:unset;">
                            Sent by AdMail
                        </p>
                    </td>
                </tr> 
            </table>
        </td>
    </tr>
</table>

</body>
</html>