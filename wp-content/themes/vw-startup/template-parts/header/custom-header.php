<div class="container">
  <div class="row">
    <div class="logo col-lg-4 col-md-4">
      <?php if( has_custom_logo() ){ vw_startup_the_custom_logo();
        }else{ ?>
        <h1 class="text-sm-center text-md-left"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        <?php $description = get_bloginfo( 'description', 'display' );
        if ( $description || is_customize_preview() ) : ?>
          <p class="site-description"><?php echo esc_html($description); ?></p>
      <?php endif; } ?>
    </div>
    <div class="col-lg-8 col-md-8 contact-info">
      <div class="row">
        <div class="col-lg-4 col-md-4"> 
          <div class="row">
            <?php if ( get_theme_mod('vw_startup_location','') != "" ) {?>
              <div class="col-md-2 p-0">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div class="col-md-8">
                <p><?php echo esc_html( get_theme_mod('vw_startup_location',__('123 Dummy Address Street, USA','vw-startup')) ); ?></p>
              </div>
            <?php }?>
          </div>
        </div>
        <div class="col-lg-4 col-md-4"> 
          <div class="row">
            <?php if ( get_theme_mod('vw_startup_call','') != "" ) {?>
              <div class="col-md-2 p-0">
                <i class="fas fa-phone-volume"></i>
              </div>
              <div class="col-md-8">
                <p><?php echo esc_html( get_theme_mod('vw_startup_call',__('+00-123-456-789 , +00-987-654-321','vw-startup')) ); ?></p>
              </div>
            <?php }?>
          </div>
        </div>
        <div class="col-lg-4 col-md-4"> 
          <div class="row">
            <?php if ( get_theme_mod('vw_startup_email','') != "" ) {?>
              <div class="col-md-2 p-0">
                <i class="fas fa-envelope-open"></i>
              </div>
              <div class="col-md-8">
                <p><?php echo esc_html( get_theme_mod('vw_startup_email',__('example@abc.com , support@xyz.com','vw-startup')) ); ?></p>
              </div>
            <?php }?>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>











<?php if ( get_theme_mod('vw_hair_salon_location_text','') != "" ) {?>
  <div class="col-md-2 p-0">
    <i class="fas fa-map-marker-alt"></i>
  </div>
  <div class="col-md-8">
    <?php if ( get_theme_mod('vw_hair_salon_location_text','') != "" ) {?>
      <p class="bold-font"><?php echo esc_html( get_theme_mod('vw_hair_salon_location_text',__('Your address goes here','vw-startup')) ); ?></p>
    <?php }?>
  </div>
<?php }?>