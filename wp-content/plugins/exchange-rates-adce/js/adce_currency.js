var adce_currency_history=[];
jQuery(document).ready(function($) {
    adce_currency();
    jQuery.ajaxSetup({ cache: false });
}); 

function adce_currency_countdown() {
        var i_table1 = document.getElementById('table_counter');
        i_table1.innerHTML = parseInt(i_table1.innerHTML)-1;
            if (i_table1.innerHTML < 1) {
                adce_currency();
                i_table1.innerHTML=120;
                }

    }
        setInterval(adce_currency_countdown,1000);


function adce_currency(){
    
    var data = {  
        action: 'adce_getcurrency'
    };
    
    jQuery.post( adce_currencyParams.admin_ajax_url, data, function( response ) {
        json = jQuery.parseJSON(response);
        jQuery.each( json, function( key, val ) {
            //arrows
            if(adce_currency_history[key] < parseFloat(val.cena)){
                arrow = '<i class="fa fa-arrow-up" aria-hidden="true" style="color:green;"></i>';
            }else if(adce_currency_history[key] > parseFloat(val.cena)){
                arrow = '<i class="fa fa-arrow-down" aria-hidden="true" style="color:red;"></i>';
            }else{
                arrow = '<i class="fa fa-arrow-right" aria-hidden="true" style="color:orange;"></i>';
            }   
            adce_currency_history[key]=parseFloat(val.cena);
            jQuery('.pair-'+key).html(arrow+' '+val.cena);

        });
    });
}