<?php 
add_action( 'widgets_init', 'freemium_post_comment_tag_widget' );
function freemium_post_comment_tag_widget() {
	register_widget( 'freemium_post_comment_tag_widget' );
}
class freemium_post_comment_tag_widget extends WP_Widget {
	function freemium_post_comment_tag_widget() {
		$freemium_widget_ops = array( 'classname' => 'post_comment_tag', 'description' => __('A widget for Posts, Comments and Tags.', 'freemium') );
		
		$freemium_control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'post-comment-tag-widget' );
		
		$this->WP_Widget( 'post-comment-tag-widget', __('Posts Comments and Tags', 'freemium'), $freemium_widget_ops, $freemium_control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		//Our variables from the widget settings.
		$freemium_title = apply_filters('widget_title', $instance['title'] );
		$freemium_show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;
		echo $before_widget;
		// Display the widget title 
		if ( $freemium_title ) { ?>

<div class="clearfix"></div>
<div class="col-md-12 white-bg no-padding widget-post-comment-tag">
  <ul class="nav panel-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab"><?php _e('POSTS','freemium') ?></a></li>
    <li><a href="#tab2" data-toggle="tab"><?php _e('COMMENTS','freemium') ?></a></li>
    <li><a href="#tab3" data-toggle="tab"><?php _e('TAGS','freemium') ?></a></li>
  </ul>
  <div class="separator-bold"></div>
  <div class="panel-body">
    <div class="tab-content">
      <div class="tab-pane active" id="tab1">
        <ul class="main-post">
          <?php
								  $freemium_args = array('posts_per_page'   => 5,
												'orderby'          => 'post_date',
												'order'            => 'DESC',
												'post_type'        => 'post',
												'post_status'      => 'publish'
											);
								$freemium_single_post = new WP_Query( $freemium_args );
							   
								while ( $freemium_single_post->have_posts() ) { $freemium_single_post->the_post();
						?>
          <li>
            <?php $freemium_feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
									
								if($freemium_feat_image!="") { ?>
            <div class="col-md-4 col-xs-4 no-padding"> <a href="<?php the_permalink();?>" title="Post Page"> <img src="<?php echo $freemium_feat_image; ?>" class="img-circle" /></a></div>
            <?php }
								 
								 else{ 
								?>
            <div class="col-md-4 col-xs-4 no-padding"> <a href="<?php the_permalink();?>" title="Post Page"> <img src="<?php echo get_template_directory_uri(); ?>/images/img-not-available.jpg" class="img-circle" /> </a></div>
            <?php } ?>
            <div class="col-md-8 margin-top-1 custom-widget-content">
              <p class="clearfix"><a class="widget-custom-post-title" href="<?php the_permalink();?>" title="Post Page">
                <?php the_title(); ?>
                </a></p>
              <p class="text-left clearfix">
                <?php the_time(get_option( 'date_format' )); ?>
              </p>
            </div>
          </li>
          <?php  } ?>
        </ul>
      </div>
      <div class="tab-pane" id="tab2">
        <?php 
				$freemium_post_comment = get_comments( apply_filters( 'widget_comments_args', array( 'number' => 30, 'status' => 'approve', 'post_status' => 'publish' ) ) ); 
				echo '<ul id="recentcomments">';
				foreach ( (array) $freemium_post_comment as $freemium_comment) {
					echo'<li class="recentcomments"> admin on <a href="' . esc_url( get_comment_link($freemium_comment->comment_ID) ) . '">' . get_the_title($freemium_comment->comment_post_ID) . '</a></li>';
					}
				echo'</ul>';
				?>
      </div>
      <div class="tab-pane" id="tab3">
        <?php 
					echo '<div class="tagcloud">';
						wp_tag_cloud( apply_filters('widget_tag_cloud_args', array('taxonomy' => 'post_tag') ) );
					echo "</div>\n"; 
				?>
      </div>
    </div>
  </div>
</div>
<?php }
			echo $after_widget;
	}
	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$freemium_instance = $old_instance;
		//Strip tags from title and name to remove HTML 
		$freemium_instance['title'] = strip_tags( $new_instance['title'] );
		$freemium_instance['show_info'] = $new_instance['show_info'];
		return $freemium_instance;
	}
	
	function form( $instance ) {
		//Set up some default widget settings.
		$freemium_defaults = array( 'title' => __('post_comment_tag', 'post_comment_tag'), 'name' => __('Posts Comments and Tags', 'post_comment_tag'), 'show_info' => true );
		$instance = wp_parse_args( (array) $instance, $freemium_defaults ); ?>
<?php echo 'Posts Comments and Tag'; ?>
<p>
  <input type="hidden" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php _e('Posts Comments Tags','freemium') ?>"  />
</p>
<?php
	}
}
?>
