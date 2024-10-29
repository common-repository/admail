<style>
.wc-ambisn-button{
    color:<?php echo esc_attr(ambisn_get_setting('button_text_color')); ?>;
    background-color:<?php echo esc_attr(ambisn_get_setting('button_bg_color')); ?>;
    border-radius:<?php echo esc_attr(ambisn_get_setting('button_border_radius')); ?>;
}
.wc-ambisn-button.subscribed svg {
    fill: <?php echo esc_attr(ambisn_get_setting('button_text_color')); ?>;;
}
.ambisn-subscribed .icon{
    background-color:<?php echo esc_attr(ambisn_get_setting('button_bg_color')); ?>;
}
div#wc-ambisn-container.subscribed {
    border-left-color: <?php echo esc_attr(ambisn_get_setting('button_bg_color')); ?>;
}

div#wc-ambisn-container{
    background-color: <?php echo esc_attr(ambisn_get_setting('form_bg_color')); ?>;
}

.wc-ambisn-form input#email{
    border-radius:<?php echo esc_attr(ambisn_get_setting('button_border_radius')); ?>;
}
button#ambisn-submit.active::after{
    border-color: <?php echo esc_attr(ambisn_get_setting('button_text_color')); ?>;
}
</style>

