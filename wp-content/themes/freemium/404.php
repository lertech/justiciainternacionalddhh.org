<?php
/**
 * The 404 template file
 * 
*/
get_header(); 
?>
<section class="section-main">
  <div class="container no-padding">
        <header>
			<div class="jumbotron">
				<h1><?php _e('Epic 404 - Article Not Found','freemium') ?></h1>
				<p><?php _e('This is embarrassing. We could not find what you were looking for.','freemium') ?></p>
                <section class="post_content">
                   	<p><?php _e('Whatever you were looking for was not found, but maybe try looking again or search using the form below.','freemium') ?></p>
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="<?php echo site_url(); ?>" class="search-form" method="get" role="search">
                            <label>
                               <input type="search" name="s" value=""  placeholder="<?php _e('Search..','freemium'); ?>class="search-field">
                            </label>
                            <input type="submit" value="<?php _e('Search','freemium'); ?>" class="search-submit">
                            </form>								
                        </div>
                	</div>
				</section>
			</div>
		</header>	
  </div>
</section>
<?php
	get_footer();
?>
