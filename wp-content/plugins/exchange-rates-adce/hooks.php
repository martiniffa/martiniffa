<?php
//manulay load class
require_once(__DIR__."/__class/setup.php");
require_once(__DIR__."/__class/header.php");
require_once(__DIR__."/__class/main.php");
require_once(__DIR__."/__class/widget.php");

use Exchange_rates_adce\Setup;
use Exchange_rates_adce\Header;
use Exchange_rates_adce\Main;

//define("ADCE_API_URL","http://localhost/api-waluty/web/");
define("ADCE_API_URL","http://altaica2.ssd-linuxpl.com/waluty/");

//db config
function exchange_rates_adce_install () {
        Setup::install();
    } 
register_activation_hook(__DIR__.'/exchange-rates-adce.php', 'exchange_rates_adce_install');
    
function exchange_rates_adce_delete(){
    Setup::uninstall();
    }	
register_uninstall_hook(__DIR__.'/exchange-rates-adce.php', 'exchange_rates_adce_delete' );

function  exchange_rates_adce_update_db_check() {
    global $kp_db_version;
    if (get_option('adce_db_version') == '1.0') {
        Setup::install();
    }
}
add_action( 'plugins_loaded', 'exchange_rates_adce_update_db_check' );


//add menu
function exchange_rates_adce_menu(){
    Header::adce_admin_menu();
}
add_action('admin_menu', 'exchange_rates_adce_menu');

//style header init
function exchange_rates_adce_styles(){
    Header::adce_styles(plugins_url( 'css/style.css' , __FILE__ ),plugins_url( 'css/font-awesome.min.css' , __FILE__ ),plugins_url( 'css/flag-icon.min.css' , __FILE__ ));
}
add_action( 'wp_enqueue_scripts', 'exchange_rates_adce_styles' );
add_action('admin_head', 'exchange_rates_adce_styles');


//script header init 2
function exchange_rates_adce_header(){
    Header::adce_wp_head();
}
add_action('wp_enqueue_scripts', 'exchange_rates_adce_header');

function exchange_rates_adce_header_admin(){
    Header::adce_wp_head_admin();
}
add_action('admin_enqueue_scripts', 'exchange_rates_adce_header_admin');


//settings link
function exchange_rates_adce_setting_link ( $links ) {
    return Main::admin_widget_menu($links);
}
add_filter( 'plugin_action_links_' . 'exchange-rates-adce/exchange-rates-adce.php', 'exchange_rates_adce_setting_link' );


//setting page
function exchange_rates_adce_show()
{
    Main::settings_page();
}

//wideg init
function exchange_rates_adce_currency_table() {
	register_widget( 'ADCE_Widget' );
}
add_action( 'widgets_init', 'exchange_rates_adce_currency_table' );


//shortcode
function exchange_rates_adce_shortcode(){
    Main::adce_shortcode();
}
add_shortcode('adce_currency_table', 'exchange_rates_adce_shortcode');	


function exchange_rates_adce_ajax(){
    global $wpdb;
    $prefix = $wpdb->prefix; 
    $kp_tablename = $prefix."adce_config";
    $result = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='para'");
    $klucz =  $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='klucz' ORDER BY id DESC LIMIT 1");
    $i=0;
    $array=array();
    //create currecncy pari
    foreach($result as $value){
        $array[$i]=$value->param_value;
        $i++;
    }
    $response = wp_remote_get(ADCE_API_URL.'index.php?page=getcurrency&strona='.$_SERVER['HTTP_HOST'].'&klucz='.$klucz[0]->param_value.'&waluty='.implode(",",$array));
    echo $response['body'];
    exit;
}

add_action('wp_ajax_adce_getcurrency', 'exchange_rates_adce_ajax');
add_action('wp_ajax_nopriv_adce_getcurrency', 'exchange_rates_adce_ajax');

function exchange_rates_adce_ajax_settings(){
    Setup::admin_ajax_hook();
}

add_action('wp_ajax_adce_get_options', 'exchange_rates_adce_ajax_settings');
add_action('wp_ajax_nopriv_adce_get_options', 'exchange_rates_adce_ajax_settings');
