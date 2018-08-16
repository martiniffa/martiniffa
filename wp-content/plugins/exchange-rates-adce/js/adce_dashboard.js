jQuery(document).ready(function($) {
    jQuery.ajaxSetup({ cache: false, timeout: 20000 });
    adce_getoptions();
   
}); 



function adce_getoptions(arg1,arg2){
    
    var data = {  
        action: 'adce_get_options',
        param1: arg1,
        param2: arg2
    };
    
    jQuery.post( adce_currencyParams.admin_ajax_url, data, function( response ) {
        jQuery('#added-pairs').html(response);
        adce_options_links();
    });
    
}


function adce_options_links(){

    //move down
    jQuery('.movedown-adce-option').click(function(){
       adce_getoptions('movedown',jQuery(this).data('adce-option'));
    });
    //move up
    jQuery('.moveup-adce-option').click(function(){
       adce_getoptions('moveup',jQuery(this).data('adce-option'));
    });
    //remove
    jQuery('.remove-adce-option').click(function(){
       adce_getoptions('remove',jQuery(this).data('adce-option'));
    });
    
}