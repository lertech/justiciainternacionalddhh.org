<?php
/*
* Template Name: Home Page
*/
get_header();
$freemium_options = get_option( 'faster_theme_options' );
?>
<section> 
  <div class="col-md-12 no-padding" id="sliderhome">
    <?php for($freemium_loop=1 ; $freemium_loop <5 ; $freemium_loop++):?>
    <?php if(!empty($freemium_options['slider-img-'.$freemium_loop])){ ?>
    <div class="home-banner">
      <?php if(!empty($freemium_options['slidelink-'.$freemium_loop])) {?>
      <a href="<?php echo esc_url($freemium_options['slidelink-'.$freemium_loop]);?>" target="_blank"> <img src="<?php echo esc_url($freemium_options['slider-img-'.$freemium_loop]); ?>" alt="" />  </a>
      <?php } else { ?>
      <img src="<?php echo esc_url($freemium_options['slider-img-'.$freemium_loop]); ?>" alt="" class="img-responsive" />
      <?php } ?>
      <div class="banner-text">
        <h1><?php if(!empty($freemium_options['slidetitle-'.$freemium_loop])) { echo wp_filter_nohtml_kses($freemium_options['slidetitle-'.$freemium_loop]); } ?></h1>
        <h4><?php if(!empty($freemium_options['slidetext-'.$freemium_loop])) { echo wp_filter_nohtml_kses($freemium_options['slidetext-'.$freemium_loop]); } ?></h4>
      </div>
    </div>
    <?php } ?>
    <?php endfor;?>
  </div>
  <div class="clearfix"></div>
  <div class="container freemimum-container">
    <div class="row first-row clearfix">
      <?php
			 for($freemium_l=1; $freemium_l <=4 ;$freemium_l++ ):
		 ?>
      <div class="col-md-3 resp-grid-50 col-sm-6 ">
        <div class="first-row-box padding-right clearfix"> 
          <?php if(!empty( $freemium_options['section-icon-'.$freemium_l])) { ?><img class="icon-home-img" src="<?php echo esc_url($freemium_options['section-icon-'.$freemium_l]); ?>" /><?php } ?> 
          	<span><?php if(!empty($freemium_options['sectiontitle-'.$freemium_l])) { echo wp_filter_nohtml_kses($freemium_options['sectiontitle-'.$freemium_l]); } ?></span>
          <p><?php if(!empty($freemium_options['sectiondesc-'.$freemium_l])) { echo wp_filter_nohtml_kses($freemium_options['sectiondesc-'.$freemium_l]); } ?></p>
        </div>
      </div>
      <?php
	 endfor;
?>
    </div>
  </div>
  <?php if(!empty($freemium_options['post-category'])){ ?>
  <div class="col-md-12 no-padding">
    <?php     
	$freemium_args = array(
			   'cat'  => $freemium_options['post-category'],
			);		
            $freemium_post = new WP_Query( $freemium_args );
           ?>
    <?php  if ( $freemium_post->have_posts() ) { ?>
    <div id="freemimum-gellery">
      <?php
		while ( $freemium_post->have_posts() ) {
		$freemium_post->the_post();
		$freemium_feature_img_url = wp_get_attachment_link(get_post_thumbnail_id(get_the_id()),'home-thumbnail-image');
	  ?>
      <div class="item">
        <div class="grid">
          <figure class="effect-image">
            <?php if(get_post_thumbnail_id(get_the_ID())) { ?>
            <?php echo $freemium_feature_img_url; ?>
            <?php } ?>
            <figcaption>
              <p><a href="<?php echo get_permalink(); ?>"><i class="fa fa-search-plus"></i></a></p>
            </figcaption>
          </figure>
        </div>
      </div>
      <?php  } ?>
    </div>
    <?php 
            }	 
        ?>
  </div>
  <?php } ?>
  <div class="clearfix"></div>
  <!--respon start-->
  <div class="container freemimum-container">
    <div class="col-md-12 no-padding-lr section-respon clearfix">
      <div class="col-md-6 col-sm-6 col-xs-12 no-padding-lr">
        <div class="respon-content"> 
			<?php if(!empty($freemium_options['subscribe-points'])) { echo $freemium_options['subscribe-points']; } ?> </div>
      </div>
      <div class="col-md-6 no-padding-lr col-sm-6 col-xs-12">
        <div class="respon-left"> <?php if(!empty($freemium_options['area-img'])) { ?><img src="<?php echo esc_url($freemium_options['area-img']); ?>" class="img-responsive" alt="" /><?php } ?></div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-12 section-update">
    <div class="container freemimum-container">
      <?php
			 for($freemium_p=1; $freemium_p <= 4 ;$freemium_p++ ):
			 if(!empty($freemium_options['rankingnumber-'.$freemium_p])):
		 ?>
      <div class="col-md-3 resp-grid-50 col-sm-6">
        <div class="update-circle"> <span><?php echo wp_filter_nohtml_kses($freemium_options['rankingnumber'.$freemium_p]); ?></span>
          <p><?php if(!empty($freemium_options['rankingtitle'.$freemium_p])){ echo wp_filter_nohtml_kses($freemium_options['rankingtitle'.$freemium_p]); } ?></p>
        </div>
      </div>
      <?php
	 endif;
	 endfor;
?>
    </div>
  </div>
</section>
<?php get_footer(); ?>