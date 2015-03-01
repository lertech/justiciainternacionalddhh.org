<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div class="col-md-12 no-padding-right">
<?php if ( comments_open() ) : ?>
	<div id="comments" class="comments-area  margin-top-bottom-2 white-bg">
<?php if ( have_comments() ) : 	?>
    <h2 class="comments-title">
		<?php
			printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'freemium' ),
				number_format_i18n( get_comments_number() ), get_the_title() );
		?>
	</h2>
    <ol class="comment-list">
    <?php	
	wp_list_comments( array( 'callback' => 'freemium_comment', 'style' => 'ol', 'short_ping' => true, 'avatar_size'=> 70 ) ); ?>
    </ol>
       <?php paginate_comments_links(); ?>     
	<?php endif; // have_comments() ?>
	<?php comment_form(); ?>
</div>
<?php endif; ?>
</div><!-- #comments -->
