<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package VW Startup
 */
?>
<div  id="footer" class="copyright-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-1');?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-2');?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-3');?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-4');?>
            </div>
        </div>
    </div>
</div>

<div id="footer-2" class="inner">
  	<div class="copyright">
        <p><?php echo esc_html(get_theme_mod('vw_startup_footer_text',__('Startup WordPress Theme By','vw-startup'))); ?> <?php vw_startup_credit(); ?></p>
  	</div>
  	<div class="clear"></div>
</div>

<?php wp_footer(); ?>
</body>
</html>