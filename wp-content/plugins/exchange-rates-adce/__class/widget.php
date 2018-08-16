<?php
/**
 * Widget class
 */
use Exchange_rates_adce\Setup;

class ADCE_Widget extends \WP_Widget {

	function __construct() {
            // Instantiate the parent object
		parent::__construct( false, 'Currency Exchange' );
	}

	function widget( $args, $instance ) {
            global $wpdb;
            $prefix = $wpdb->prefix; 
            $title = apply_filters( 'widget_title', $instance['title'] );
            echo $args['before_widget'];
            echo '<div class="widget-wrapper">';
            if ( ! empty( $title ) ){
                echo $args['before_title'] . $title . $args['after_title'];
            }
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
            echo $args['after_widget'];        
            // Widget output
	}

	function update( $new_instance, $old_instance ) {
            // Save widget options
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
                return $instance;
	}

	function form( $instance ) {
               if ( isset( $instance[ 'title' ] ) ) {
                $title = $instance[ 'title' ];
            }
            else {
                //title
                $title = __( 'Currency', 'adce_currency' );
            }
            // Widget admin form
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <?php 
	}
        
}


//widget end