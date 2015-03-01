<?php
/**
 * The single post template file
*/
get_header();
?>
<section class="section-main">
	<div class="container no-padding">
    	<div class="col-md-8 no-padding imgset freemium-post">
			 <?php while ( have_posts() ) : the_post(); ?>
            <div class="col-md-12 no-padding-right margin-bottom-3">
          	<div id="post-<?php the_ID(); ?>" <?php post_class("col-md-12 white-bg no-padding single-content"); ?> >
                    <div class="col-md-12 single-bottom-padding clearfix">
                       <h1><?php the_title(); ?></h1>
                    </div>
                    <div class="col-md-12">
                        <?php freemium_entry_meta(); ?>
                        <div class="clear-fix"></div>
                        <div class="freemium-tags"><?php the_tags(); ?></div>
                    </div>
                    <div class="col-md-12 margin-top-2 text-justify clearfix">
                    <?php $freemium_feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); if($freemium_feat_image!="") { ?>
                    <img src="<?php echo $freemium_feat_image; ?>" alt="Banner" class="img-responsive img-responsive-freemium" />
                    <?php } ?>
                    <?php the_content();
						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'freemium' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
					 ?>
                    </div>
          </div>
          </div>
          	<div class="col-md-12 freemium-single-pagination no-padding-right margin-top-bottom-3">
                <nav class="default-pagination freemium-pagination">
                    <span class="default-pagination-next"><?php previous_post_link(); ?></span>
                    <span class="default-pagination-previous"><?php next_post_link(); ?></span>
                </nav><!-- .nav-single -->
            </div>
          	<?php comments_template('', true); ?>	
            
			<?php endwhile; ?>
            
        </div>
		<?php get_sidebar(); ?>    
    </div>
</section>
<?php get_footer(); ?>
