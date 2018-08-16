<?php
namespace Exchange_rates_adce;

/**
 * Header class
 */
class Header{
    
    public static function adce_admin_menu(){
        add_menu_page( 'Exchange rates ADCE', 'Exchange rates', 'manage_options', 'exchange-rates-adce','exchange_rates_adce_show');
    }
    
    public static function adce_styles($url_style,$url_awesome,$url_flags){
        wp_enqueue_style( 'adce-style', $url_style, array(), ADCE_VERSION);
        wp_enqueue_style( 'adce-style-font-awesome', $url_awesome );
        wp_enqueue_style( 'adce-style-flags', $url_flags );
    }
    
       
    public static function adce_wp_head() {
        wp_register_script( 'adce_currency', plugins_url('exchange-rates-adce').'/js/adce_currency.js',array('jquery'), false );
        wp_enqueue_script('adce_currency');
        wp_localize_script( 'adce_currency', 'adce_currencyParams', array('admin_ajax_url'=>admin_url('admin-ajax.php')) );
    }
    
    public static function adce_wp_head_admin() {
        wp_register_script( 'adce_dashboard', plugins_url('exchange-rates-adce').'/js/adce_dashboard.js',array('jquery'), false );
        wp_enqueue_script('adce_dashboard');
        wp_localize_script( 'adce_dashboard', 'adce_currencyParams', array('admin_ajax_url'=>admin_url('admin-ajax.php')) );
    }
    
    
}

