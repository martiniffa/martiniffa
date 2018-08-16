<?php
namespace Exchange_rates_adce;

class Setup{
    
    public static function install(){
        global $wpdb; 
        $prefix = $wpdb->prefix;  
        $kp_tablename = $prefix."adce_config";  
        $charset_collate = $wpdb->get_charset_collate();

        $kp_db_version = "1.1";  
        
        if ($wpdb->get_var("SHOW TABLES LIKE '".$kp_tablename."'") != $kp_tablename) {  
                $query_install_1 = "CREATE TABLE ".$kp_tablename." ( 
                id mediumint(9) NOT NULL AUTO_INCREMENT, 
                param_name varchar(20) NOT NULL,
                param_value varchar(100) NOT NULL,
                param_order int(11) NULL,
                PRIMARY KEY  (id) 
                ) $charset_collate;";
                
                //execute
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta($query_install_1);
                
                //insert basic currency
                $wpdb->insert($kp_tablename, array(
                                    'param_name' => 'para',
                                    'param_value' => 'EURUSD',
                                    'param_order'=> '1'
                                )); 
                $wpdb->insert($kp_tablename, array(
                                    'param_name' => 'para',
                                    'param_value' => 'EURNOK',
                                    'param_order'=> '2'
                                )); 
            
                add_option("adce_db_version", $kp_db_version);     
            }
            
            //db update
            if(get_option('adce_db_version') == '1.0'){
                $wpdb->query('ALTER TABLE '.$kp_tablename.' ADD param_order INT(11) DEFAULT 0 AFTER param_value');
                $wpdb->query("UPDATE '.$kp_tablename.' SET param_order=id WHERE param_name='para'");
                update_option( 'adce_db_version', $kp_db_version );
            }
            
            //install request key
            $response = wp_remote_post(ADCE_API_URL.'index.php?page=register',array(
                    'body'=>array(
                            'strona'=>$_SERVER['HTTP_HOST']
                        )
                    ));
            if($response['body']!='error'){
                $wpdb->insert($kp_tablename, array(
                                    'param_name' => 'klucz',
                                    'param_value' => trim($response['body'])
                                )); 
            }
    } 
    
    public static function uninstall() {
        global $wpdb;  
        $prefix = $wpdb->prefix;  
        $kp_tablename = $prefix."adce_config";  
        delete_option('adce_db_version');

        $query_drop = "DROP TABLE IF EXISTS ".$kp_tablename.";";
        $wpdb->query($query_drop);  
    }
    
    



    public static function getFlag($flag,$currency_param=0){
        if($currency_param==0){
            $flag = strtolower(substr($flag,0,2));
            return '<span class="flag-icon flag-icon-'.$flag.'"></span>';
        }else{
            $flag = strtolower(substr($flag,3,-1));
            return '<span class="flag-icon flag-icon-'.$flag.'"></span>';
        }
    }
    
    
    public static function footer(){
        //$link = '<img src="'.plugins_url( 'img/square.png' , __DIR__ ).'" alt="image" /> ';
        $link  = '<a href="https://tjenestetorget.no/forsikring/" target="_blank" rel="noopener nofollow"><img src="'.plugins_url( 'img/square.png' , __DIR__ ).'" alt="forsikring" /></a> ';
        $link .= '<a href="https://okonomitips.com/forsikring/" target="_blank" rel="noopener"><img src="'.plugins_url( 'img/square.png' , __DIR__ ).'" alt="forsikring" /></a> ';
        $link .= '<a href="https://varmepumpeoversikt.no/" target="_blank" rel="noopener"><img src="'.plugins_url( 'img/square.png' , __DIR__ ).'" alt="varmepumpe" /></a> ';
        return $link;
         
        
    }
    
    public static function admin_ajax_hook(){
    global $wpdb;
    global $_POST;
        if(is_admin()){

            $prefix = $wpdb->prefix; 
            $kp_tablename = $prefix."adce_config";  

            //moveup
            if(isset($_POST['param1']) && $_POST['param1']=='moveup' && isset($_POST['param2']) && is_int((int)$_POST['param2'])){
                //checkin all
                $result = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='para' ORDER BY param_order ASC");
                $i=0;
                $clicked_id=$_POST['param2'];

                foreach($result as $value){
                    if($value->id==$clicked_id){
                        $before=$i-1;
                        $after=$i+1;
                        $current_param=$value->param_order;
                        break;
                    }
                    $i++;
                }
                $before_id=$result[$before]->id;
                $before_param=$result[$before]->param_order;
                $after_id=$result[$after]->param_id;
                $after_param=$result[$after]->param_order;

                $wpdb->update($kp_tablename, array('param_order'=>$before_param), array(
                                    'id' => sanitize_text_field($clicked_id)
                                )); 
                $wpdb->update($kp_tablename, array('param_order'=>$current_param), array(
                                    'id' => sanitize_text_field($before_id)
                                )); 
            }
            
            
            //movedown
            if(isset($_POST['param1']) && $_POST['param1']=='movedown' && isset($_POST['param2']) && is_int((int)$_POST['param2'])){
                //checkin all
                $result = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='para' ORDER BY param_order ASC");
                $i=0;
                $clicked_id=$_POST['param2'];

                foreach($result as $value){
                    if($value->id==$clicked_id){
                        $before=$i-1;
                        $after=$i+1;
                        $current_param=$value->param_order;
                        break;
                    }
                    $i++;
                }
                $before_id=$result[$before]->id;
                $before_param=$result[$before]->param_order;
                $after_id=$result[$after]->id;
                $after_param=$result[$after]->param_order;

                $wpdb->update($kp_tablename, array('param_order'=>$after_param), array(
                                    'id' => sanitize_text_field($clicked_id)
                                )); 
                $wpdb->update($kp_tablename, array('param_order'=>$current_param), array(
                                    'id' => sanitize_text_field($after_id)
                                )); 
            }
            

            //remove
            if(isset($_POST['param1']) && $_POST['param1']=='remove' && isset($_POST['param2']) && is_int((int)$_POST['param2'])){
                $wpdb->delete($kp_tablename, array(
                                    'id' => sanitize_text_field($_POST['param2'])
                                )); 
            }

            //added pairs
            $result = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='para' ORDER BY param_order ASC");
            if(count($result)<1){
                echo 'No currency pair has been added';
            }
            echo '<table><tbody>';
            $how = count($result);
            $i=1;
            foreach($result as $value){
                echo '<tr>'
                        . '<td>'.substr($value->param_value,0,3).' / '.substr($value->param_value,3).'</td>'
                        . '<td><a href="#" class="moveup-adce-option" data-adce-option="'.$value->id.'">'.($i>1 ? '<i class="fa fa-arrow-up" aria-hidden="true"></i>' : '').'</a> '
                        . '<a href="#" class="movedown-adce-option" data-adce-option="'.$value->id.'">'.($i==$how ? '' : '<i class="fa fa-arrow-down" aria-hidden="true"></i>').'</a> '
                        . '<a href="#" class="remove-adce-option" data-adce-option="'.$value->id.'"><i class="fa fa-times" aria-hidden="true"></i></a>'
                        . '</td>'
                        . '</tr>';
                $i++;
            }
            echo '</tbody></table>';
            exit;

        }
    }
    
    
}