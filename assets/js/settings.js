jQuery(document).ready(function($){
    
    const admin_url = ambisn_script_vars.admin_url;
    
    $('.ambisn-color-picker').wpColorPicker();
    
    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var setting = $(this).attr('data-setting');
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $("input."+setting).val(image_url);
            $("img."+setting).attr("src",image_url);
        });
    });
    
  $('.setting.social-icons').on('click', '.add-social-icon', function(e) {
    e.preventDefault();
    var image_element = $(this);
    var target_value = image_element.closest('.item').find('.img-link');

    var image = wp.media({
      title: 'Upload Image',
      multiple: false
    }).open()
    .on('select', function(e) {
      var uploaded_image = image.state().get('selection').first();
      var image_url = uploaded_image.toJSON().url;
      target_value.val(image_url);
      image_element.attr('src', image_url);
    });
  });

  $('.setting.social-icons').on('click', '.done', function() {
    var elementItem = $(this).closest('.item.waiting');
    var url_link = elementItem.find('.social-icon-link').val();
    var img_url = elementItem.find('.img-link').val();

    if (url_link.length === 0 || img_url.length === 0) {
      alert("Please select an icon image and its link.");
    } else {
      $(this).addClass('hidden');
      elementItem.find('.remove').removeClass('hidden');
      elementItem.removeClass('waiting').addClass('added');
      $('.setting.social-icons .add').removeClass('hidden');
    }
  });

  $('.setting.social-icons').on('click', '.remove', function() {
    $(this).closest('.item').remove();
  });

  $('.setting.social-icons .add').click(function() {
    var duplicatedElement = $('.setting.social-icons .item.hidden').clone();
    $(this).before(duplicatedElement);
    $(this).addClass('hidden');
    duplicatedElement.removeClass('hidden').addClass('waiting');
  });
    
    $("input.color").keyup(function(){
        var Color = $(this).val();
        $(this).css("border-color", Color);
    });
    
    $("div#toggle-button input.checkbox").click(function(){
        if($(this).prop('checked') == true){ $(this).val('1');}
        else{$(this).val('0');}
    });
    
    $('.ambisn .settings-sidebar .item .ambisn-review-stars span').hover(function(){
        $(this).prevAll().andSelf().addClass('focus');
        $(this).nextAll().removeClass('focus');
        $('.ambisn .settings-sidebar .item .ambisn-review-stars').removeClass('conf');
        
    });
    
    $('.ambisn .settings-sidebar .item .ambisn-review-stars').click(function(e){
        
        var rating = $(this).find('span.focus').length;
        
        if(parseInt(rating) < 5){
            
            e.preventDefault();
            
            $('.feedback-popup').removeClass('admail-hide');
            $('.feedback-popup .stars span').removeClass('selected');
            $('.feedback-popup .stars span[value='+rating+']').addClass('selected');
            $('.feedback-popup .feedback').removeClass('hidden');
            $('.feedback-popup .bottom').addClass('admail-hide');
            
        }
    });
        
    $(".settings-sidebar div.item svg").click(function(e){
        e.stopPropagation();
        const parent = $(this).closest('.settings-sidebar div.item');
        parent.toggleClass('enabled disabled');
    });
    
    $(".settings-sidebar div.item.disabled").click(function(){
        $(this).addClass('enabled').removeClass('disabled');
    });
    
    $('.ambisn .items-wrapper.uniselect .single-item').click(function(){
        $(this).closest('.items-wrapper.uniselect').find(' .single-item').removeClass('active');
        $(this).addClass('active');
        var value = $(this).attr('value');
        $(this).closest('.element-settings').find('input').attr('value', value);
    });
    
    $('.ambisn .items-wrapper.multiselect .single-item').click(function(){
        $(this).toggleClass('active');
        var value = $(this).closest('.items-wrapper').find('.single-item.active').map(function(){
          return $(this).attr('value');
        }).get().join(',');
        $(this).closest('.element-settings').find('input').attr('value', value);
    });    
    
$('.nm-save-settings').click(function(e) {
  e.preventDefault();

  var allSettings = {};
  $(".setting input").each(function() {
    var attr = $(this).attr('setting');
    var value = $(this).val();
    if ($(this).hasClass('empty_allowed') || (typeof attr !== 'undefined' && attr !== false && value !== '')) {
      allSettings[attr] = value;
    }
  });

  var socialIcons = [];
  $('.element-settings .item.added').each(function() {
    var imgLink = $(this).find('.img-link').val();
    var socialLink = $(this).find('.social-icon-link').val();

    var iconData = {
      image_url: imgLink,
      link: socialLink
    };

    socialIcons.push(iconData);
  });

  allSettings.social_icons = socialIcons;

  $(this).css("display", "none");
  $('.ambisn-tab .action-notice').addClass("active");

  $.ajax({
    url: admin_url + 'admin-ajax.php',
    data: {
      'action': 'ajax_ambisn_settings',
      'settingsData': JSON.stringify(allSettings)
    },
    success: function(response) {
        
        try{
                            
            var data = JSON.parse(response);
            
                if(data.ctp_html){
                                
                $('.ambisn.preview-container.conf-template').html(data.ctp_html);                
            }
                            
            if(data.tp_html){
                                
                $('.ambisn.preview-container.bise-template').html(data.tp_html);                
            }
                            
        }catch(error){
                            
            alert("Something went wrong! Please try again later.");
                            
        }
        
        $('.action-notice').text("Saved");
        
        $('.action-notice').removeClass("active");
        
        $('.action-notice').addClass("done");
        
        setTimeout(function() {
            
            $('.action-notice').removeClass("done");
            
            $('.action-notice').text("Saving ...");
            
            $('a.nm-save-settings').css("display", "block");
            
        }, 3000);
    }
    
  });
  
});
   
   $('.feedback-popup .feedback .submit-improve').click(function(e){
        e.preventDefault();
        var uniqid = $('.feedback-popup .container .feedback .uniqid').val();
        var stars = $('.feedback-popup .container .stars>.selected').attr('value');
        var msg = $('.feedback-popup .container .feedback textarea').val();
        var textareaValue = $('.feedback-popup .container .feedback textarea').val().trim();
        if (textareaValue === '') {
            alert("Please provide your suggestion before submitting.");
            return false;
        }
        if ($('.feedback-popup .feedback .receive-updates').is(':checked')) {
            var email = $('.feedback-popup .feedback .email').val();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }
        }else{
            var email = 'null';
        }
        $('.feedback-popup a.suggest').addClass('loading');
       $.ajax({
           url : admin_url + 'admin-ajax.php',
           data:{
                'action': 'ajax_dev_form_submission',
                'uniqid': uniqid , 
                'rating' : stars, 
                'content' : msg, 
                'email' : email,
           },success: function(response){
                $('.feedback-popup a.suggest').removeClass('loading');
                $('.feedback-popup .container').html(response);
                setTimeout(function(){
                    $('.feedback-popup').remove();
                }, 3000);
           }
       });
   });
   
    $('.feedback-popup .feedback .receive-updates').change(function() {
        if ($(this).is(':checked')) {
            $('.feedback-popup .feedback .email').addClass('include');
        } else {
            $('.feedback-popup .feedback .email').removeClass('include');
        }
    });
   
   $('.feedback-popup a.later').click(function(e){
       e.preventDefault();
       $(this).addClass('loading');
       $.ajax({
           url : admin_url + 'admin-ajax.php',
           data:{
                'action': 'ambisn_snooze_feedback_popup',
           },success: function(response){
               $('.feedback-popup a.later').removeClass('loading');
               $('.feedback-popup').addClass('admail-hide');
           }
       });
   });
   
   $('.feedback-popup .container .stars>span').click(function(){
       $('.feedback-popup .container .stars>span ').removeClass('selected');
       $(this).addClass('selected');
       var starValue = $(this).attr('value');
       if(starValue < 5){
           $('.feedback-popup .container .feedback').removeClass('hidden');
           $('.feedback-popup .container .bottom a.action').removeClass('focus');
       }else{
           $('.feedback-popup .container .feedback').addClass('hidden');
           $('.feedback-popup .container .bottom a.action').addClass('focus');
       }
   });
    
    $('.feedback-popup .container a.suggest').click(function(e){
        e.preventDefault();
        $('.feedback-popup .container .feedback').removeClass('hidden');
        $('.feedback-popup .container .bottom a.action').removeClass('focus');
   }); 
    
});