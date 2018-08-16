<?php

namespace Exchange_rates_adce;
use Exchange_rates_adce\Setup;

class Main{
    public static function admin_widget_menu($links){
        $mylinks = array(
        '<a href="' . admin_url( 'admin.php?page=exchange-rates-adce' ) . '">Settings</a>',
        );
       return array_merge( $links, $mylinks );
    }
    
    public static function settings_page(){
        global $wpdb;
        $prefix = $wpdb->prefix; 
        $kp_tablename = $prefix."adce_config";  
        
        $tab_checked=1;
        
        //handler settings POST
        if(isset($_POST['pair']) && is_string((string)$_POST['pair'])){
            $result = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='para'");
             $wpdb->insert($kp_tablename, array(
                                'param_name' => 'para',
                                'param_value' => sanitize_text_field($_POST['pair']),
                            )); 
            $last_id=  $wpdb->insert_id;
            $wpdb->update($kp_tablename, array('param_order'=>$last_id), array(
                                'id' => sanitize_text_field($last_id)
                            )); 
            $tab_checked=1;
        }
        
        //addtranslate
        if(isset($_POST['translate']) && is_string((string)$_POST['translate'])){
             $wpdb->insert($kp_tablename, array(
                                'param_name' => 'table_column1',
                                'param_value' => sanitize_text_field($_POST['table_column1']),
                            )); 
             $wpdb->insert($kp_tablename, array(
                                'param_name' => 'table_column2',
                                'param_value' => sanitize_text_field($_POST['table_column2']),
                            )); 
            $wpdb->insert($kp_tablename, array(
                                'param_name' => 'table_refresh',
                                'param_value' => sanitize_text_field($_POST['table_refresh']),
               )); 
             $tab_checked=2;
        }
        
        //gettraslate
        $current_table_column1 = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='table_column1' ORDER BY id DESC LIMIT 1");
        $current_table_column2 = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='table_column2' ORDER BY id DESC LIMIT 1");
        $current_wdiget_refresh = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='table_refresh' ORDER BY id DESC LIMIT 1");
        
        ?>
        <br />
        <h1>Settings</h1>
        
<div class="tabset">
  <!-- Tab 1 -->
  <input type="radio" name="tabset" id="tab1" <?php if($tab_checked==1){echo 'checked';} ?>>
  <label for="tab1">Settings</label>
  <!-- Tab 2 -->
  <input type="radio" name="tabset" id="tab2" <?php if($tab_checked==2){echo 'checked';} ?>>
  <label for="tab2">Translate</label>
  <!-- Tab 3 -->
  <input type="radio" name="tabset" id="tab3" <?php if($tab_checked==3){echo 'checked';} ?>>
  <label for="tab3">FAQ</label>

  
  <div class="tab-panels">
    <section id="tab-content1" class="tab-panel">

        Add a new currency pair<br />
        <form method="post">
            <select name="pair">
                <?php

                $klucz =  $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='klucz' ORDER BY id DESC LIMIT 1");
                $response = wp_remote_get(ADCE_API_URL.'index.php?page=getcurrencylist&strona='.$_SERVER['HTTP_HOST'].'&klucz='.$klucz[0]->param_value,  array( 'timeout' => 30 ));
                    foreach(json_decode($response['body']) as $value){
                        echo '<option value="'.$value.'">'.substr($value,0,3).' / '.substr($value,3).'</option>';
                    }
                ?>
            </select>
            <input type="submit" value="Add" />
        </form>
        <h1>Added pairs</h1>
        <div id="added-pairs"></div>
        
  </section>
    <section id="tab-content2" class="tab-panel">
        <form method="post">
            <table><tbody>
            <tr><td><b>Currency pair </b></td><td><input type="text" name="table_column1" placeholder="Currency pair" value="<?php echo $current_table_column1[0]->param_value; ?>" /></td></tr>
            <tr><td><b>Rate </b></td><td><input type="text" name="table_column2" placeholder="Rate" value="<?php echo $current_table_column2[0]->param_value; ?>" /></td></tr>
            <tr><td><b>Refresh in </b></td><td><input type="text" name="table_refresh" placeholder="Refresh in" value="<?php echo $current_wdiget_refresh[0]->param_value; ?>" /></td></tr>
            </tbody></table>
            <input type="hidden" name="translate" value="1" />
            <input type="submit" value="Update" />
        </form>
    </section>
    <section id="tab-content3" class="tab-panel">
        Soon
    </section>
  </div>
  
</div>
        

        <?php

    }
    
    public static function adce_shortcode(){
        global $wpdb;
        $prefix = $wpdb->prefix; 
        $kp_tablename = $prefix."adce_config";
        //gettraslate
        $current_table_column1 = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='table_column1' ORDER BY id DESC LIMIT 1");
        $current_table_column2 = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='table_column2' ORDER BY id DESC LIMIT 1");
        $current_table_refresh = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='table_refresh' ORDER BY id DESC LIMIT 1");
        ?>
        <table class="adce_currency_table">
            <thead>
                <tr><th><?php if(strlen($current_table_column1[0]->param_value)>0) {echo $current_table_column1[0]->param_value;}else{echo 'Currency pair';} ?></th><th><?php if(strlen($current_table_column2[0]->param_value)>0) {echo $current_table_column2[0]->param_value;}else{echo 'Rate';} ?></th></tr>
            </thead>
            <tbody>
                <?php
                    $result = $wpdb->get_results("SELECT * FROM $kp_tablename WHERE param_name='para' ORDER BY param_order");
                    
                    $i=0;
                    foreach($result as $value){
                                echo '<tr><td>'.Setup::getFlag($value->param_value,0).' '.substr($value->param_value,0,3).' / '.Setup::getFlag($value->param_value,1).' '.substr($value->param_value,3).'</td><td class="pair-'.$i.'"></td></tr>';
                                $i++;
                            }
                ?>
                <tr><td><?php if(strlen($current_table_refresh[0]->param_value)>0) {echo $current_table_refresh[0]->param_value;}else{echo 'Refresh in';} ?> <span id="table_counter">120</span></td><td class="adce_links"><?php echo Setup::footer(); ?></td></tr>
            </tbody>
        </table>
        <?php
    }
    
}
