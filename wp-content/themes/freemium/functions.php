<?php
/**
 * Freemium functions
 */
if ( ! function_exists( 'freemium_setup' ) ) :
function freemium_setup() {
	global $content_width;
	if ( ! isset( $content_width ) ) {
	$content_width = 900;
	}
	/*
	 * Make freemium available for translation.
	 */
	load_theme_textdomain( 'freemium');

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', freemium_font_url() ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'freemium-full-width', 1038, 576, true );
	add_image_size( 'home-thumbnail-image', 340, 340, true );
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Main menu', 'freemium' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'freemium_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'freemium_get_featured_posts',
		'max_posts' => 6,
	) );
}
endif; // freemium_setup
add_action( 'after_setup_theme', 'freemium_setup' );

// Implement Custom Header features.
require get_template_directory() . '/functions/custom-header.php';

//Theme Title
function freemium_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$freemium_site_description = get_bloginfo( 'description', 'display' );
	if ( $freemium_site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $freemium_site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'freemium' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'freemium_wp_title', 10, 2 );

// thumbnail list 
function freemium_thumbnail_image($content) {

    if( has_post_thumbnail() )
         return the_post_thumbnail( 'thumbnail' ); 
}

function freemium_font_url() {
	$freemium_font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'freemium' ) ) {
		$freemium_font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}
	return $freemium_font_url;
}
//enqueue scripts and styles  
function freemium_scripts() {
	wp_enqueue_style('style', get_stylesheet_uri());
	wp_enqueue_style( 'style-bootstrap', get_stylesheet_directory_uri().'/css/bootstrap.css' );
	wp_enqueue_style( 'style-custom', get_stylesheet_directory_uri().'/css/custom.css' );
	wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri().'/css/font-awesome.min.css' );
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'script-bootstrap-hover', get_template_directory_uri() . '/js/bootstrap-hover-dropdown.js', array('jquery'), '1.0' );
	wp_enqueue_script( 'script-bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '1.0' );
	wp_enqueue_script( 'script-default', get_template_directory_uri() . '/js/default.js', array('jquery'), '1.0' );	
	wp_enqueue_script( 'owl-carouselmin', get_template_directory_uri() . '/js/owl.carousel.min.js');
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'freemium_scripts');
if ( ! function_exists( 'freemium_entry_meta' ) ) :
/**
 * Set up post entry meta.
 *
 * Meta information for current post: categories, tags, permalink, author, and date.
 **/
function freemium_entry_meta() {	
	$freemium_category_list = get_the_category_list() ? ' '. get_the_category_list(', ').' ' :'';	
	$freemium_tag_list = get_the_tag_list( ', ', 'freemium');
	$freemium_date = sprintf( '<time datetime="%3$s">%4$s</time>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	$freemium_author = sprintf( '<span><a href="%1$s" title="%2$s" >%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'freemium' ), get_the_author() ) ),
		get_the_author()
	);
	
	
if ( $freemium_tag_list ) {
        $freemium_utility_text = __( 'Posted in : %1$s on %3$s by : %4$s %2$s Comments: '.get_comments_number(), 'freemium' );
    } elseif ( $freemium_category_list ) {
        $freemium_utility_text = __( 'Posted in : %1$s on %3$s by : %4$s %2$s Comments: '.get_comments_number(), 'freemium' );
    } else {
        $freemium_utility_text = __( 'Posted on : %3$s by : %4$s %2$s Comments: '.get_comments_number(), 'freemium' );
    }	
	printf(
		$freemium_utility_text,
		$freemium_category_list,
		$freemium_tag_list,
		$freemium_date,
		$freemium_author
	);
}
endif;

add_action( 'widgets_init', 'freemium_widgets_init' );
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own freemium_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
 if ( ! function_exists( 'freemium_comment' ) ) :
function freemium_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
  <p>
    <?php _e( 'Pingback:', 'freemium' ); ?>
    <?php comment_author_link(); ?>
    <?php edit_comment_link( __( '(Edit)', 'freemium' ), '<span class="edit-link">', '</span>' ); ?>
  </p>
</li>
<?php
			break;
		default :
		// Proceed with normal comments.
		if($comment->comment_approved==1)
		{
		global $post;
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
  <article id="comment-<?php comment_ID(); ?>" class="comment col-md-12 margin-top-bottom">
    <figure class="comment-avtar"> <a href="#"><?php echo get_avatar( get_the_author_meta('ID'), '70'); ?></a> </figure>
    <div class="txt-holder">
      <?php
                            printf( '%1$s',
                                get_comment_author_link(),
                                ( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author ', 'freemium' ) . '</span>' : ''
                            );
						?>
      <?php
                            
                            echo ' '.get_comment_date().'</b>';
							echo '<a href="#" class="reply pull-right">'.comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'freemium' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ).'</a>';
							
                        ?>
      <div class="comment-content comment">
        <?php comment_text(); ?>
      </div>
      
      <!-- .comment-content --> 
      
    </div>
    
    <!-- .txt-holder --> 
    
  </article>
  
  <!-- #comment-## -->
  
  <?php
		}
		break;
	endswitch; // end comment_type check
}
endif;
/*
 * Replace Excerpt [...] with Read More
 */
 
function freemium_read_more( ) {
return '..';
 }
add_filter( 'excerpt_more', 'freemium_read_more' ); 
/**
 * Add default menu style if menu is not set from the backend.
 */
function freemium_add_menuid ($page_markup) {
preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $freemium_matches);
if(!empty($freemium_matches))
	$freemium_divclass = $freemium_matches[1];
else	
	$freemium_divclass='';
$freemium_toreplace = array('<div class="'.$freemium_divclass.' pull-right-res">', '</div>');
$freemium_replace = array('<div class="navbar-collapse collapse pull-right-res">', '</div>');
$freemium_new_markup = str_replace($freemium_toreplace,$freemium_replace, $page_markup);
$freemium_new_markup= preg_replace('/<ul/', '<ul class="nav navbar-nav freemium-menu"', $freemium_new_markup);
return $freemium_new_markup; }
add_filter('wp_page_menu', 'freemium_add_menuid');
/**
 * Register our sidebars and widgetized areas.
 *
 */
function freemium_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'freemium' ),		
		'id' => 'sidebar-1',
		'class' => 'nav-list',
		'before_widget' => '<div class="col-md-12 margin-bottom-3 share-story clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="text-center">',
		'after_title' => '</h4>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Area 1','freemium' ),		
		'id' => 'footer_area_1',
		'class'         => 'nav-list',
		'before_widget' => '<div class="col-md-12 margin-bottom-3 share-story no-padding">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="head">',
		'after_title' => '</h2>',
	) );	
	register_sidebar( array(
		'name' => __( 'Footer Area 2','freemium' ),		
		'id' => 'footer_area_2',
		'class'         => 'nav-list',
		'before_widget' => '<div class="col-md-12 margin-bottom-3 share-story no-padding">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="head">',
		'after_title' => '</h2>',
	) );	
	register_sidebar( array(
		'name' => __( 'Footer Area 3','freemium' ),		
		'id' => 'footer_area_3',
		'class'         => 'nav-list',
		'before_widget' => '<div class="col-md-12 margin-bottom-3 share-story no-padding">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="head">',
		'after_title' => '</h2>',
	) );	
}
add_action( 'widgets_init', 'freemium_widgets_init' );
/*
 * freemium custom pagination for posts 
 */
function freemium_paginate($pages = '', $range = 1)
{  
     $freemium_showitems = ($range * 2)+1;  
     global $paged;
     if(empty($paged)) $paged = 1;
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $freemium_showitems < $pages) echo "<li class='pagination-previous-all'><a href='".get_pagenum_link(1)."'><span class='previous-all-icon'><<</span></a></li>";
         if($paged > 1 && $freemium_showitems < $pages) echo "<li class='pagination-previous'><a href='".get_pagenum_link($paged - 1)."'><span class='previous-icon'><</span></a></li>";
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $freemium_showitems ))
             {
                 echo ($paged == $i)? "<li><a href='#'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
             }
         }
         if ($paged < $pages && $freemium_showitems < $pages) echo "<li class='pagination-next'><a href='".get_pagenum_link($paged + 1)."'><span class='next-icon'>></span></a></li>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $freemium_showitems < $pages) echo "<li class='pagination-next-all'><a href='".get_pagenum_link($pages)."'><span class='next-all-icon'>>></span></a></li>";
         echo "</div>\n";
     }
}
/*************** Theme option ****************/
require_once('theme-option/fasterthemes.php');
/************ Widget For Subscribe ***********/
require_once('functions/freemium-custom-widget.php');

/*** TGM ***/
require_once('functions/tgm-plugins.php');
