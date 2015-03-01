<?php
/*
 * The template for displaying the footer
 */
$freemium_options = get_option( 'faster_theme_options' );
?> 
<footer class="footer-main clearfix">
  <div class="container freemium-footer-content">
    <div class="col-md-12 div-md-12">
      <div class="col-md-3 col-sm-6 footer-column1 col-sm-6">
        <?php if ( is_active_sidebar( 'footer_area_1' ) ) : dynamic_sidebar('footer_area_1'); endif; ?>
      </div>
      <div class="col-md-3 col-sm-6 footer-column2 clearfix">
        <?php if ( is_active_sidebar( 'footer_area_2' ) ) : dynamic_sidebar('footer_area_2'); endif; ?>
      </div>
      <div class="col-md-3 col-sm-6 footer-column3 clearfix">
        <?php if ( is_active_sidebar( 'footer_area_3' ) ) : dynamic_sidebar('footer_area_3'); endif; ?>
      </div>
      <div class="col-md-3 col-sm-6 footer-column3">
        <?php  if(!empty($freemium_options['fburl']) || !empty($freemium_options['twitter']) || !empty($freemium_options['linkedin']) || !empty($freemium_options['googleplus']) || !empty($freemium_options['address']) || !empty($freemium_options['phone']) || !empty($freemium_options['fax']) || !empty($freemium_options['email']) || !empty($freemium_options['web']))  { ?>
        <h4 class="li-title"><?php _e('Contact Info','freemium') ?></h4>
        <?php if(!empty($freemium_options['address'])) { ?>
        <p><?php echo $freemium_options['address'] ?></p>
        <?php } ?>
        <?php if(!empty($freemium_options['phone'])) { ?>
        <p><?php _e('Phone :','freemium') ?> <?php echo $freemium_options['phone'] ?></p>
        <?php } ?>
        <?php if(!empty($freemium_options['fax'])) { ?>
        <p><?php _e('Fax : ','freemium') ?><?php echo $freemium_options['fax'] ?></p>
        <?php } ?>
        <?php if(!empty($freemium_options['email'])) { ?>
        <p><?php _e('Email :','freemium') ?> <a href="<?php echo $freemium_options['email'] ?>"><?php echo $freemium_options['email'] ?></a></p>
        <?php } ?>
        <?php if(!empty($freemium_options['web'])) { ?>
        <p><?php _e('Web :','freemium') ?> <a href="<?php echo $freemium_options['web'] ?>"><?php echo $freemium_options['web'] ?></a></p>
        <?php } ?>
        <div class="social-icon">
          <ul>
            <?php if(!empty($freemium_options['fburl'])) { ?>
            <li><a href="<?php echo $freemium_options['fburl'] ?>"><i class="fa fa-facebook-square twitt"></i></a></li>
            <?php } ?>
            <?php if(!empty($freemium_options['twitter'])) { ?>
            <li><a href="<?php echo $freemium_options['twitter'] ?>"><i class="fa fa-twitter-square linkin"></i></a></li>
            <?php } ?>
            <?php if(!empty($freemium_options['linkedin'])) { ?>
            <li><a href="<?php echo $freemium_options['linkedin'] ?>"><i class="fa fa-linkedin-square"></i> </a></li>
            <?php } ?>
            <?php if(!empty($freemium_options['googleplus'])) { ?>
            <li><a href="<?php echo $freemium_options['googleplus'] ?>"><i class="fa fa-google-plus-square"></i></a></li>
            <?php } ?>
          </ul>
        </div>
        <?php   } ?>
      </div>
    </div>
  </div>
  <div class="col-md-12 no-padding-lr footer-bootm">
    <div class="container jobile-container">
      <p>
        <?php
		   if(!empty($freemium_options['footertext'])){
			  echo wp_filter_nohtml_kses($freemium_options['footertext']).'. '; 
			}						
			?>
	<?php _e('Powered by','freemium'); ?> <a href='http://wordpress.org' target='_blank'><?php _e('WordPress','freemium'); ?></a>
    <?php _e('and','freemium'); ?><a href='http://fasterthemes.com/wordpress-themes/freemium' target='_blank'>
    <?php _e('Freemium','freemium'); ?></a>	
      </p>
    </div>
  </div>
</footer>


  <?php  wp_footer();  ?>
</body>
</html>
