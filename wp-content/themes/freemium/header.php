<?php
/*
 * The template for displaying the header
 */
$freemium_options = get_option( 'faster_theme_options' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php if(!empty($freemium_options['fevicon'])) { ?>
<link rel="shortcut icon" href="<?php echo esc_url($freemium_options['fevicon']);?>">
<?php } ?>
<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
    <![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
<header>
	<div class="container-sony">
    <?php 
	if(get_header_image()){ ?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" class="custom_header_img" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
	</a>
    <?php } ?>
    <div class="container clearfix">
    
    	<div class="col-md-3 margin-top-bottom-2 no-padding-right">
        	<div class="col-md-6 col-xs-6 no-padding logo">
            	<a href="<?php echo site_url(); ?>">
                <?php if(!empty($freemium_options['logo'])) { ?>
                <img src="<?php echo esc_url($freemium_options['logo']); ?>" class="freemium-header-logo" alt="Freemium" />
                <?php } else { ?>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" alt="Freemium" />
                <?php } ?>
                </a>
            </div>
            <div class="navbar-header pull-right col-md-6 col-xs-6 no-padding">
				<button type="button" class="navbar-toggle toggle-top" data-toggle="collapse" data-target=".navbar-collapse">
                   <span class="sr-only"><?php _e('Toggle navigation','freemium') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
				</button>          
			</div>
            <div class="clearfix"></div>
        </div>        
        <div class="col-md-9 margin-top-bottom-2 no-padding">        	
            <?php
			
			$freemium_args = array(
					'theme_location'  => 'primary',
					'container'       => 'div',
					'container_class' => 'navbar-collapse collapse no-padding pull-right-res',
					'container_id'    => 'bs-example-navbar-collapse-1',
					'menu_class'      => 'navbar-collapse no-padding pull-right-res collapse',
					'menu_id'         => '',
					'echo'            => true,
					'fallback_cb'     => 'wp_page_menu',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '<ul class="nav navbar-nav freemium-menu">%3$s</ul>',
					'depth'           => 0,
					'walker'          => ''
					);
			wp_nav_menu($freemium_args); ?>
        </div>
        
        </div>
        <div class="clearfix"></div>
        </div>
</header>
