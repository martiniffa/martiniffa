<div class="top-bar">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <?php if ( get_theme_mod('vw_startup_short_line','') != "" ) {?>
          <p><?php echo esc_html( get_theme_mod('vw_startup_short_line',__('For Financial Peace of mind you can trust Fintech.','vw-startup')) ); ?></p>
        <?php }?>
      </div>
      <div class="col-md-5">
        <?php dynamic_sidebar('social-icon'); ?>
      </div>
      <div class="search-box col-md-1 col-sm-1">
        <span><i class="fas fa-search"></i></span>
      </div>
    </div>
    <div class="serach_outer">
      <div class="closepop"><i class="far fa-window-close"></i></div>
      <div class="serach_inner">
        <?php get_search_form(); ?>
      </div>
    </div>
  </div>
</div>