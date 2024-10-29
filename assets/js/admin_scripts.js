jQuery(document).ready(function($) {
    
    const admin_url = ambisn_script_vars.admin_url;
    
    function ambisn_load_most_wanted_products(){
        $('.most-wanted-container .all-products').click(function(e){
            e.preventDefault();
            var thisElement = $(this);
            if(thisElement.hasClass('view')){
                $('.most-wanted-container').addClass('loading');
                $.ajax({
                    url: admin_url + 'admin-ajax.php',
                    data: {
                        'action': 'ambisn_load_most_wanted_products',
                    },
                    success: function(response) {
                      $('.most-wanted-container .products').html(response);
                      $('.most-wanted-container').removeClass('loading');
                      thisElement.toggleClass('hide view');
                      thisElement.text('Hide');
                    },
                    error: function(xhr, status, error) {
                      console.error(error);
                      $('.most-wanted-container').removeClass('loading');
                      thisElement.toggleClass('hide view');
                    }
                });
            }
            else{
                var parentElement = $('.most-wanted-container .products');
                var childElements = parentElement.children();
                if (childElements.length > 3) {
                  childElements.slice(3).remove();
                }
                thisElement.toggleClass('hide view');
                thisElement.text('Show all');
            }

        });
    }
   
    function ajax_dev_form_submission() {
        $('.settings-sidebar form input[type="submit"]').click(function(e) {
            e.preventDefault();
            var clickedButton = $(this);
            var actionName = $(this).attr('name');
            var uniqid = $(this).closest('form').find('.uniqid').val();
            var email = $(this).closest('form').find('.email').val();
            var content = $(this).closest('form').find('.content').val();

            var emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;

            if (email.trim() === '' || !email.match(emailRegex)) {
                alert('Please enter a valid email address!');
                return false;
            }

            if (content.trim() === '') {
                alert('Please enter details about your request!');
                return false;
            }
            
            $(this).attr('value', 'Sending');
            $(this).addClass("loading");

            $.ajax({
                url: admin_url + 'admin-ajax.php',
                data: {
                    'action': 'ajax_dev_form_submission',
                    'actionName': actionName,
                    'uniqid': uniqid,
                    'email': email,
                    'content': content
                },
                success: function(response) {
                    clickedButton.attr('value', 'Submitted');
                    clickedButton.closest('form').replaceWith(response);
                }
            });
        });
    }
    ambisn_load_most_wanted_products();
    ajax_dev_form_submission();
});