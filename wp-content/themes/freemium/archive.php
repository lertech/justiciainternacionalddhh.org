<?php
/* 
* The Archive template file
*/ 
get_header(); 
?>   
<section class="section-main">
	<div class="container no-padding">
    	<div class="col-md-8 no-padding imgset freemium-post">
        <div class="col-md-12 no-padding-right margin-bottom-3">
        	 <div class="col-md-12 white-bg search-freemium">
        		<h1><?php	_e('Archives','freemium'); echo " : ". get_the_date('M-Y');	 ?></h1>
			</div>
        </div>            
			 <?php  if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
            <div class="col-md-12 no-padding-right margin-bottom-3">
          <div class="col-md-12 white-bg no-padding">
                <div class="col-md-12 clearfix">
                   <h1> <a href="<?php echo the_permalink();?>"> <?php the_title(); ?> </a> </h1>
                </div>
                <div class="col-md-12">
					<?php freemium_entry_meta(); ?>
                    <div class="clear-fix"></div>
                    <div class="freemium-tags"><?php the_tags(); ?></div>
                </div>
                <div class="col-md-12 margin-top-2 text-justify">
                <?php $freemium_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); if($freemium_feat_image!="") { ?>
        		<img src="<?php echo $freemium_feat_image; ?>" alt="Banner" class="img-responsive img-responsive-freemium" />
				<?php } ?>
				<?php the_excerpt(); ?>
                </div>
            	<div class="col-md-12 no-padding">
            	<div class="cont-reading"> <a href="<?php echo the_permalink();?>" class="whitecolor"><?php _e('CONTINUE READING','freemium') ?></a> </div>
          	</div>
          </div>
        </div>			
			<?php endwhile; endif; ?>
     
		<!--Pagination Start-->
        <?php if ( function_exists( 'faster_pagination' )){	?>
            <?php faster_pagination();?>
        <?php }else { ?>
        <?php if(get_option('posts_per_page ') < $wp_query->found_posts) { ?>
        <div class="col-md-12 no-padding-left margin-top-bottom-3">
                <nav class="default-pagination freemium-pagination">
                    <span class="default-pagination-next"><?php previous_posts_link(); ?></span>
                    <span class="default-pagination-previous"><?php next_posts_link(); ?></span>
                </nav>
        </div>
        <?php } ?>
        <?php }//is plugin active ?>
		<!--Pagination End-->

        </div>
		<?php get_sidebar(); ?>    
    </div>
</section>
<?php
	get_footer();
?>
