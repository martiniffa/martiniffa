<?php  
/* 
Plugin Name: Currency exchange rates table
Version: 1.1.5
Description: Table of currency exchange rates on the basis of data provided by Tjenestetorget. Important! On the weekends Forex market does not work so dynamically, so exchange rates may not change value.
Author: Tjenestetorget
Author URI: https://okonomitips.com
Plugin URI: https://okonomitips.com
*/  

	
//Version controll
global $wp_version;  

define('ADCE_VERSION','1.1.5');
$exit_msg = ' 
Min WordPress version to 3.4.';  

if (version_compare($wp_version, "3.4", "<"))  
{  
 exit($exit_msg);  
}  	

//load hooks
require_once("hooks.php");

?>