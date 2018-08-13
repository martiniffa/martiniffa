<div class="toggle"><a class="toggleMenu" href="#"><?php esc_html_e('Menu','vw-startup'); ?></a></div>  
<div id="header" class="menubar">
  <div class="container">
    <div class="row bg-home">      
      <div class="col-lg-9 col-md-9 nav">
        <?php wp_nav_menu( array('theme_location'  => 'primary') ); ?>
      </div>
      <div class="col-lg-3 col-md-3 req-button">
        <?php if ( get_theme_mod('vw_startup_button_text','') != "" ) {?>
          <a href="<?php echo esc_url( get_theme_mod('vw_startup_button_link',__('#','vw-startup')) ); ?>"><?php echo esc_html( get_theme_mod('vw_startup_button_text',__('REQUEST A QUOTE ','vw-startup')) ); ?></a>
        <?php }?>
      </div>
    </div>
  </div>
</div>