<?php

if (!defined('ABSPATH')) {
    exit;
}
    
class Admail_Settings{

    public function print_setting_html($setting,$type,$title,$subtitle="", $data_array="") {
            
            $value = ambisn_get_setting($setting);
            
            ob_start();
            
            if($type == 'toggle'){
                
                if($value ==  '1'){ 
                    
                    echo 'name = "'.$setting.'" setting = "'.$setting.'"  value = "'.$value.'" checked="yes"';
                    
                }else{
                    
                    echo 'name = "'.$setting.'" setting = "'.$setting.'"  value = "'.$value.'"';
                    
                }
                
            }elseif($type == 'image'){
                
                echo 'name = "'.$setting.'" setting = "'.$setting.'"  value = "'.$value.'"';
                
            }elseif($type == 'color'){
                
                echo 'name = "'.$setting.'" style="border-color:'.$value.' !important;" setting = "'.$setting.'" value = "'.$value.'"';
                
            }elseif($type == 'uniselect' || $type == 'multiselect'){
                
                echo 'name = "'.$setting.'" setting = "'.$setting.'"  value = "'.$value.'"';
                
            }elseif($type == 'input'){
                
                echo 'name = "'.$setting.'" setting = "'.$setting.'"  value = "'.$value.'"';
                
            }
            
            $setting_value = ob_get_clean();
            
           ?>
            <div class="setting <?php echo esc_attr($setting); ?>">
                
                <div class="label">
                
                    <?php 
                    if($title != ""){
                        
                        echo '<h3>'.esc_html($title).'</h3>';
                    
                    }
                    if($subtitle != ""){
                    
                        echo '<p>'.esc_html($subtitle).'</p>';
                    
                    }                
                    ?>
                
                </div>
            
                <?php 
            
                if($type == "toggle"){
                
                    ?>
                
                    <div class="toggle-button r" id="toggle-button">
                        <input type="checkbox" class="checkbox" <?php echo wp_kses_post($setting_value); ?>/>
                        <div class="knobs">
                            <span></span>
                        </div>
                        <div class="layer"></div>
                    </div>
                
                    <?php
                
                }elseif($type == "uniselect"){
                    
                    if(is_array($data_array)){
                        
                        echo '<div class="element-settings full">';
                        
                            echo '<div class="items-wrapper uniselect">';
                        
                            foreach ( $data_array as $key=>$name ) {
                            
                                if($key == $value){
                                
                                    $class= 'active';
                                
                                }else{
                                
                                    $class='';
                                
                                }
                                ?>
                                <div class="single-item <?php echo esc_attr($class); ?>" value="<?php echo esc_attr($key); ?>">
                                    <?php echo wp_kses_post($name); ?>
                                </div>
                                <?php
                            }
                        
                            echo '</div>';
                            
                            echo '<input class="empty_allowed" '.wp_kses_post($setting_value).' hidden="">';
                        
                        echo '</div>';
                        
                    }
                    
                }elseif($type == "multiselect"){
                    
                    $saved_array = explode(',', $value);
                    
                    if(is_array($data_array) && is_array($saved_array)){
                        
                        echo '<div class="element-settings full">';
                        
                            echo '<div class="items-wrapper multiselect">';
                        
                            foreach ( $data_array as $key=>$name ) {
                            
                                if(in_array($key, $saved_array)){
                                
                                    $class= 'active';
                                
                                }else{
                                
                                    $class='';
                                
                                }
                                ?>
                                <div class="single-item <?php echo esc_attr($class); ?>" value="<?php echo esc_attr($key); ?>">
                                    <?php echo wp_kses_post($name); ?>
                                </div>
                                <?php
                            }
                        
                            echo '</div>';
                            
                            echo '<input class="empty_allowed" '.wp_kses_post($setting_value).' hidden="">';
                        
                        echo '</div>';
                        
                    }
                    
                }elseif($type == "input"){
                        
                    echo '<input '.wp_kses_post($setting_value).'>';
                        
                }elseif($type == "color"){
                        
                    echo '<input class="color ambisn-color-picker" '.wp_kses_post($setting_value).'>';
                        
                }elseif($type == "image"){
                    
                    echo '<input class="'.esc_attr($setting).'" '.wp_kses_post($setting_value).' hidden>';
                    
                    echo '<img id="upload-btn" data-setting="'.esc_attr($setting).'" class="'.esc_attr($setting).'" width="60px" src="'.esc_url($value).'">';
                    
                }
            
            ?>
            
        </div>
        
        <?php
        
    }
} 
