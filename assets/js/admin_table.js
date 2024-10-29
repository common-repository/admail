jQuery(document).ready(function($){
    
    const admin_url = ambisn_script_vars.admin_url;
    
    $(".ambisn-tab .filter a").click(function() {
          var btnValue = $(this).attr('value');
          var tabLink = ambisn_script_vars.plugin_url + 'includes/tabs/'+btnValue+'.php';
          $('.ambisn').load(ambisn_script_vars.plugin_url + 'includes/tabs/out_of_stock.php');
    });
    
    function ambisn_tab_actions(){
        
        $('table.ambisn td input[type=checkbox]').click(function() {
            
             $(this).toggleClass('checked');
             
        });

        $('.ambisn-table-wrapper .items-per-page').change(function() {
            var selectedValue = $(this).val();
            var activeTab = $('.ambisn-tab').attr('value');
            $('.ambisn-table-wrapper').addClass('loading');
            $.ajax({ 
                url: admin_url + 'admin-ajax.php', 
                data:{ 'action' : 'ambisn_update_items_per_page','value': selectedValue, 'tab' : activeTab}, 
                success: function(response){
                    $('.ambisn-table-wrapper').replaceWith(response).removeClass('loading');
                    ambisn_tab_actions();
                    ambisn_load_table_pagination_rows();
                    ambisn_search_product();
                }
            });            
        });
        $('.ambisn-table-wrapper .emails-per-page').change(function() {
            var selectedValue = $(this).val();
            $('.ambisn-table-wrapper').addClass('loading');
            $.ajax({ 
                url: admin_url + 'admin-ajax.php', 
                data:{ 'action' : 'ambisn_update_emails_per_page','value': selectedValue}, 
                success: function(response){
                    $('.ambisn-table-wrapper').html(response);
                    $('.ambisn-table-wrapper').removeClass('loading');
                    ambisn_tab_actions();
                    ambisn_load_table_pagination_rows();
                    ambisn_search_product();
                }
            });            
        });        

        $('table.ambisn th.check input[type=checkbox]').click(function() {
            $(this).toggleClass('checked');
            if ($(this).hasClass("checked")){
              $('table.ambisn td input[type=checkbox]').addClass('checked');
              $('table.ambisn td input[type=checkbox]').prop('checked', true);
            }else{
            $('table.ambisn td input[type=checkbox]').removeClass('checked');
            $('table.ambisn td input[type=checkbox]').prop('checked', false);
            }
        });
    
        $(".ambisn-tab .actions a").off('click').on('click',function(){
            
            $('.ambisn-tab .action-notice').addClass("active");
            
            var action = $(this).attr('value');
            
            var dataArray = [];
            
            var $j_object = $(".ambisn-tab table.ambisn td input.checked");
        
            $j_object.each( function(){
                
                var productID = $(this).attr('value');
                
                var email = $(this).attr('email');

                var itemData = {
                    
                    productID: productID,
                    
                    email: email,
                    
                    action: action,
                    
                };

                dataArray.push(itemData);
                
            });
      
            $.ajax({ 
                
                url: admin_url + 'admin-ajax.php', 
                
                data:{ 
                    
                    'action' : 'ambisn_manage_subscription', 
                    
                    'dataArray' : JSON.stringify(dataArray),
                    
                },success: function(response){
                    
                    ambisn_load_tab_content();
                    
                    $('.action-notice').text("Done").toggleClass("active done");
                    
                    setTimeout(function () {$('.action-notice').removeClass("done").text("Processing ...");}, 3000);
                }
            });
        });
    }
    ambisn_tab_actions();
    
    function ambisn_load_table_pagination_rows(){
        
        $('.ambisn-table-pignation a').click(function(){
            
            var clickedElement = $(this);
            
            var selectedPage = $(this).attr('value'); 
            
            var currentTab = $('.ambisn-tab').attr('value'); 
            
            $('.ambisn-table-wrapper').addClass('loading');
            
            $.ajax({
                url: admin_url + 'admin-ajax.php',
                data:{
                    'action': 'ambisn_load_table_pagination_rows', 'selectedPage': selectedPage, 'tab': currentTab,
                },
                success: function(response){
                    
                    $('.ambisn-table-wrapper tbody.ambisn-table').html(response);
                    
                    $('.ambisn-table-wrapper').removeClass('loading');
                    
                    $('.ambisn-table-pignation a').removeClass('active');
                    
                    clickedElement.addClass('active');
                    
                    ambisn_tab_actions();
                }
            });
        });
    }
    ambisn_load_table_pagination_rows();
    
    function ambisn_load_tab_content(){
        
        var activeTab = $('.ambisn-tab').attr('value');
        
        $('.ambisn-table-wrapper').addClass('loading');
        
        $.ajax({ 
            
            url: admin_url + 'admin-ajax.php', 
            
            data:{ 'action' : 'ambisn_load_tab_content', 'tab' : activeTab}, 
            
            success: function(response){
                
                try{
                    
                    var data = JSON.parse(response);
                    
                    if(data.table){
                     
                        $('.ambisn-table-wrapper').replaceWith(data.table);   
                        
                    }
                    
                    $('.ambisn-tab .filter').replaceWith(data.filter);
                    
                    $('.ambisn-table-wrapper').removeClass('loading');
                    
                    $('.ambisn-table-pignation').removeClass('hidden');
                    
                    ambisn_tab_actions();
                    
                    ambisn_load_table_pagination_rows();
                    
                    ambisn_search_product();
                    
                }catch(error){
                    
                    alert('An error occurred during data processing.');
        
                    console.error(error);
                    
                }
            },error: function(xhr, status, error) {
    
                if (status === 'error') {

                    if (error === 'timeout') {

                        alert('AJAX request timed out. Please check your internet connection and try again.');
                        
                    } else {

                        alert('An error occurred due to a network issue. Please check your internet connection and try again.');
                        
                    }
                } else {

                    alert('AJAX request failed! Please try again.\nStatus: ' + status + '\nError: ' + error);
                    
                }
    
                console.error('AJAX Error - Status: ' + status + ', Error: ' + error);
    
                if (xhr.responseText) {
                    
                    console.error('Response Text: ' + xhr.responseText);
                    
                }
            }

        });        
    }
    
    function ambisn_search_product(){
        
        $(".ambisn-table-wrapper .actions .right input.product-name").off("keyup").on("keyup",function () {
            
            var inputName = $(this).val();
            
            var currentTab = $('.ambisn-tab').attr('value'); 
            
            if (inputName.length > 2) {
                
                $('.ambisn-table-wrapper').addClass('loading');
                
                $.ajax({
                    
                    url : admin_url + 'admin-ajax.php',
                    
                    data:{
                        
                        'action': 'ambisn_search_product', 'inputName' : inputName, 'tab': currentTab,
                        
                    },success: function(response){
                        
                        try{
                            
                            var data = JSON.parse(response);
                            
                            if(data.table){
                                
                                $('.ambisn-table-wrapper table.ambisn').removeClass('admail-hide');
                                
                                $('.ambisn-table-wrapper .actions .left').removeClass('admail-hide');
                                
                                $('.ambisn-table-wrapper tbody.ambisn-table').html(data.table);
                                
                            }else if(data.empty){
                                
                                $('.ambisn-table-wrapper table.ambisn').addClass('admail-hide');
                                
                                $('.ambisn-table-wrapper .actions .left').addClass('admail-hide');
                                
                                $('.ambisn .ambisn-table-wrapper .no_results').remove();
                                
                                $('.ambisn-table-wrapper').append(data.empty);
                                
                            }
                            
                            if(data.alert){
                                
                                alert(data.alert);
                                
                            }
                            
                            
                        }catch(error){
                            
                            alert('Something went wrong while trying to proccess received data!');
                            
                        }
                        
                        $('.ambisn-table-wrapper').removeClass('loading');
                        
                        $('.ambisn-table-pignation').addClass('hidden');
                        
                        ambisn_search_product();
                    }
                });
                
            }else if(inputName.length == 0){
                
                ambisn_load_tab_content();
            }
        });    
    }
    ambisn_search_product();
});