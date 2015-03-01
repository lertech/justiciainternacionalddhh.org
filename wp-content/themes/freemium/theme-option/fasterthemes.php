<?php
function fasterthemes_options_init(){
 register_setting( 'ft_options', 'faster_theme_options', 'ft_options_validate');
} 
add_action( 'admin_init', 'fasterthemes_options_init' );
function ft_options_validate( $input ) {
	$input['footertext'] = wp_filter_nohtml_kses( $input['footertext'] );
	$input['logo'] = esc_url($input['logo']);
	$input['fevicon'] = esc_url($input['fevicon']);
	
	$input['address'] = wp_filter_nohtml_kses( $input['address'] );
	$input['email'] = is_email( $input['email'] );
	$input['phone'] = wp_filter_nohtml_kses( $input['phone'] );
	$input['fax'] = wp_filter_nohtml_kses( $input['fax'] );
	$input['web'] = wp_filter_nohtml_kses( $input['web'] );
	
	$input['fburl'] = esc_url($input['fburl']);
	$input['twitter'] = esc_url($input['twitter']);
	$input['linkedin'] = esc_url($input['linkedin']);
	$input['googleplus'] = esc_url($input['googleplus']);
	
	 for($freemium_k=1; $freemium_k < 5 ;$freemium_k++ ):
	 	$input['slider-img-'.$freemium_k] = esc_url( $input['slider-img-'.$freemium_k] );
	 	$input['slidelink-'.$freemium_k] = esc_url( $input['slidelink-'.$freemium_k] );
		$input['slidetitle'.$freemium_k] = wp_filter_nohtml_kses( $input['slidetitle-'.$freemium_k] );
		$input['slidetext'.$freemium_k] = wp_filter_nohtml_kses( $input['slidetext-'.$freemium_k] );
	 endfor;
	 
	 for($freemium_p=1; $freemium_p <= 4 ;$freemium_p++ ):
	 	$input['rankingnumber'.$freemium_p] = wp_filter_nohtml_kses( $input['rankingnumber-'.$freemium_p] );
	 	$input['rankingtitle'.$freemium_p] = wp_filter_nohtml_kses( $input['rankingtitle-'.$freemium_p] );
	 endfor;
	 
    return $input;
}
function fasterthemes_framework_load_scripts(){
	wp_enqueue_media();
	wp_enqueue_style( 'fasterthemes_framework', get_template_directory_uri(). '/theme-option/css/fasterthemes_framework.css' ,false, '1.0.0');
	wp_enqueue_style( 'fasterthemes_framework' );
	// Enqueue custom option panel JS
	wp_enqueue_script( 'options-custom', get_template_directory_uri(). '/theme-option/js/fasterthemes-custom.js', array( 'jquery' ) );
	wp_enqueue_script( 'media-uploader', get_template_directory_uri(). '/theme-option/js/media-uploader.js', array( 'jquery' ) );		
	wp_enqueue_script('media-uploader');
}
add_action( 'admin_enqueue_scripts', 'fasterthemes_framework_load_scripts' );
function fasterthemes_framework_menu_settings() {
	$freemium_menu = array(
				'page_title' => __( 'FasterThemes Options', 'freemium'),
				'menu_title' => __('Theme Options', 'freemium'),
				'capability' => 'edit_theme_options',
				'menu_slug' => 'fasterthemes_framework',
				'callback' => 'fastertheme_framework_page'
				);
	return apply_filters( 'fasterthemes_framework_menu', $freemium_menu );
}
add_action( 'admin_menu', 'theme_options_add_page' ); 
function theme_options_add_page() {
	$freemium_menu = fasterthemes_framework_menu_settings();
   	add_theme_page($freemium_menu['page_title'],$freemium_menu['menu_title'],$freemium_menu['capability'],$freemium_menu['menu_slug'],$freemium_menu['callback']);
} 
function fastertheme_framework_page(){ 
		global $select_options; 
		if ( ! isset( $_REQUEST['settings-updated'] ) ) 
		$_REQUEST['settings-updated'] = false; 
		$freemium_image=get_template_directory_uri().'/theme-option/images/logo.png';
		echo "<h1><img src='".$freemium_image."' height='64px'  /> ". __( 'FasterThemes Options', 'customtheme' ) . "</h1>"; 
		if ( false !== $_REQUEST['settings-updated'] ) :
			echo "<div><p><strong>"._e( 'Options saved', 'customtheme' )."</strong></p></div>";
		endif; 
?>
<div id="fasterthemes_framework-wrap" class="wrap">
  <h2 class="nav-tab-wrapper"> 
  <a id="options-group-1-tab" class="nav-tab basicsettings-tab" title="Basic Settings" href="#options-group-1"><?php _e('Basic Settings','freemium') ?></a> 
  <a id="options-group-2-tab" class="nav-tab socialsettings-tab" title="Social Settings" href="#options-group-2"><?php _e('Social Settings','freemium') ?></a>
  <a id="options-group-3-tab" class="nav-tab socialsettings-tab" title="Social Settings" href="#options-group-3"><?php _e('Footer Settings','freemium') ?></a> 
   <a id="options-group-4-tab" class="nav-tab socialsettings-tab" title="Home Settings" href="#options-group-4"><?php _e('Home Page Settings','freemium') ?></a>
  </h2>
  <div id="fasterthemes_framework-metabox" class="metabox-holder">
    <div id="fasterthemes_framework" class="postbox"> 
      
      <!--======================== F I N A L - - T H E M E - - O P T I O N ===================-->
      
      <form method="post" action="options.php" id="form-option" class="theme_option_ft">
        <?php settings_fields( 'ft_options' );  
		$freemium_options = get_option( 'faster_theme_options' ); ?>
        
        <!-------------- First group ----------------->
        
        <div id="options-group-1" class="group basicsettings">
          <h3><?php _e('Basic Settings','freemium') ?></h3>
          <div id="section-logo" class="section section-upload ">
            <h4 class="heading"><?php _e('Site Logo','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input id="logo" class="upload" type="text" name="faster_theme_options[logo]" 
                            value="<?php if(!empty($freemium_options['logo'])) { echo esc_url($freemium_options['logo']); } ?>" placeholder="<?php _e('No file chosen','freemium') ?>" />
                <input id="upload_image_button" class="upload-button button" type="button" value="<?php _e('Upload','freemium') ?>" />
                <div class="screenshot" id="logo-image">
                  <?php if(!empty($freemium_options['logo'])) { echo "<img src='".esc_url($freemium_options['logo'])."' /><a class='remove-image'><?php _e('Remove','freemium') ?></a>"; } ?>
                </div>
              </div>
              <div class="explain"><?php _e('Size of logo should be exactly 360x125px for best results. Leave blank to use text heading.','freemium') ?></div>
            </div>
          </div>
          <div id="section-logo" class="section section-upload ">
            <h4 class="heading"><?php _e('Favicon','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input id="logo" class="upload" type="text" name="faster_theme_options[fevicon]" 
                            value="<?php if(!empty($freemium_options['fevicon'])) { echo esc_url($freemium_options['fevicon']); } ?>" placeholder="<?php _e('No file chosen','freemium') ?>" />
                <input id="upload_image_button" class="upload-button button" type="button" value="<?php _e('Upload','freemium') ?>" />
                <div class="screenshot" id="logo-image">
                  <?php if(!empty($freemium_options['fevicon'])) { echo "<img src='".esc_url($freemium_options['fevicon'])."' /><a class='remove-image'><?php _e('Remove','freemium') ?></a>"; } ?>
                </div>
              </div>
              <div class="explain"><?php _e('Size of fevicon should be exactly 32x32px for best results.','freemium') ?></div>
            </div>
          </div>
        </div>
        
        <!-------------- Second group ----------------->
        
        <div id="options-group-2" class="group socialsettings">
          <h3><?php _e('Social Settings','freemium') ?></h3>
          <div id="section-facebook" class="section section-text mini">
            <h4 class="heading"><?php _e('Facebook','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input id="facebook" class="of-input" name="faster_theme_options[fburl]" size="30" type="text" value="<?php if(!empty($freemium_options['fburl'])) { echo esc_url($freemium_options['fburl']); } ?>" />
              </div>
              <div class="explain"><?php _e('Facebook profile or page URL i.e. ','freemium'); ?>http://facebook.com/username/</div>
            </div>
          </div>
          <div id="section-twitter" class="section section-text mini">
            <h4 class="heading"><?php _e('Twitter','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input id="twitter" class="of-input" name="faster_theme_options[twitter]" type="text" size="30" value="<?php if(!empty($freemium_options['twitter'])) { echo esc_url($freemium_options['twitter']); } ?>" />
              </div>
            <div class="explain"><?php _e('Twitter profile or page URL i.e.','freemium'); ?> http://twitter.com/username/</div>
            </div>
          </div>
          <div id="section-linkedin" class="section section-text mini">
            <h4 class="heading"><?php _e('Linkedin','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input id="linkedin" class="of-input" name="faster_theme_options[linkedin]" size="30" type="text" value="<?php if(!empty($freemium_options['linkedin'])) { echo esc_url($freemium_options['linkedin']); } ?>" />
              </div>
              <div class="explain"><?php _e('Linkedin profile or page URL i.e. ','freemium'); ?> https://in.linkedin.com/username/</div>
            </div>
          </div>
          <div id="section-gp" class="section section-text mini">
            <h4 class="heading"><?php _e('Google+','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input id="googleplus" class="of-input" name="faster_theme_options[googleplus]" type="text" size="30" value="<?php if($freemium_options['googleplus']) { echo esc_url($freemium_options['googleplus']); } ?>" />
              </div>
              
              <div class="explain"><?php _e('Google+  profile or page URL i.e. ','freemium'); ?> https://plus.google.com/username/</div>
            </div>
          </div>
        </div>
        
        <!-------------- Third group ----------------->
        
        <div id="options-group-3" class="group socialsettings">
          <h3><?php _e('Footer Settings','freemium') ?></h3>
          <div id="section-footertext2" class="section section-textarea">
            <h4 class="heading"><?php _e('Copyright Text','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input type="text" id="footertext2" class="of-input" name="faster_theme_options[footertext]" size="32"  value="<?php if(!empty($freemium_options['footertext'])) { echo wp_filter_nohtml_kses($freemium_options['footertext']); } ?>">
              </div>
              <div class="explain"><?php _e('Some text regarding copyright of your site, you would like to display in the footer.','freemium') ?></div>
            </div>
          </div>
          <div id="section-address" class="section section-textarea">
            <h4 class="heading"><?php _e('Address','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <textarea id="address" class="of-input" name="faster_theme_options[address]" size="32"><?php if(!empty($freemium_options['address'])) { echo $freemium_options['address']; } ?>
</textarea>
              </div>
              <div class="explain"><?php _e('Enter address for your site , you would like to display in the Home Page.','freemium') ?></div>
            </div>
          </div>
          <div id="section-email" class="section section-textarea">
            <h4 class="heading"><?php _e('Email','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input type="text" id="email" class="of-input" name="faster_theme_options[email]" size="32"  value="<?php if(!empty($freemium_options['email'])) { echo $freemium_options['email']; } ?>">
              </div>
              <div class="explain"><?php _e('Enter e-mail id for your site , you would like to display in the Footer.','freemium') ?></div>
            </div>
          </div>
          <div id="section-phone" class="section section-textarea">
            <h4 class="heading"><?php _e('Phone','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input type="text" id="phone" class="of-input" name="faster_theme_options[phone]" size="32"  value="<?php if(!empty($freemium_options['phone'])) { echo $freemium_options['phone']; } ?>">
              </div>
              <div class="explain"><?php _e('Enter phone number for your site , you would like to display in the Footer.','freemium') ?></div>
            </div>
          </div>
          <div id="section-phone" class="section section-textarea">
            <h4 class="heading"><?php _e('Fax','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input type="text" id="fax" class="of-input" name="faster_theme_options[fax]" size="32"  value="<?php if(!empty($freemium_options['fax'])) { echo $freemium_options['fax']; } ?>">
              </div>
              <div class="explain"><?php _e('Enter fax number for your site , you would like to display in the Footer.','freemium') ?></div>
            </div>
          </div>
          <div id="section-phone" class="section section-textarea">
            <h4 class="heading"><?php _e('Web','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input type="text" id="web" class="of-input" name="faster_theme_options[web]" size="32"  value="<?php if(!empty($freemium_options['web'])) { echo $freemium_options['web']; } ?>">
              </div>
              <div class="explain"><?php _e('Enter web site for your site , you would like to display in the Footer.','freemium') ?></div>
            </div>
          </div>
        </div>
        
        
        <!-------------- HomePage Settings ----------------->
        <div id="options-group-4" class="group socialsettings">
          <h3><?php _e('Home page slider images','freemium') ?></h3>
            <!-- Slide -->
           <?php for($freemium_i=1; $freemium_i < 5 ;$freemium_i++ ):?> 
           <div id="section-slider-upload" class="section section-text">
            <h4 class="heading"><?php _e('Slide','freemium') ?><?php echo $freemium_i; ?></h4>
            <div class="option">
              <div class="controls">
                <input id="slider-img-<?php echo $freemium_i;?>" class="upload" type="text" name="faster_theme_options[slider-img-<?php echo $freemium_i;?>]" 
                            value="<?php if(!empty($freemium_options['slider-img-'.$freemium_i])) echo esc_url($freemium_options['slider-img-'.$freemium_i]); ?>" placeholder="<?php _e('No file chosen','freemium') ?>" />
                <input id="slider" class="upload-button button" type="button" value="<?php _e('Upload','freemium') ?>" />
                <div class="screenshot" id="slider-image">
                  <?php if(!empty($freemium_options['slider-img-'.$freemium_i])) echo "<img src='".esc_url($freemium_options['slider-img-'.$freemium_i])."' /><a class='remove-image'><?php _e('Remove','freemium') ?></a>"; ?>
                </div>
               
              </div>
              <div class="explain"></div>
            </div>
          </div>
           <div id="section-link" class="section section-text mini">
            <h4 class="heading"><?php _e('Slide','freemium') ?><?php echo $freemium_i; ?><?php _e('Link','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input id="slidelink-<?php echo $freemium_i; ?>" class="of-input" name="faster_theme_options[slidelink-<?php echo $freemium_i; ?>]" type="text" size="30" value="<?php if(!empty($freemium_options['slidelink-'.$freemium_i])) { echo esc_url($freemium_options['slidelink-'.$freemium_i]); } ?>" />
              </div>
              <div class="explain"></div>
            </div>
           </div>
           <div id="section-link" class="section section-text mini">
            <h4 class="heading"><?php _e('Slide','freemium') ?><?php echo $freemium_i; ?> <?php _e('Title','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input id="slidetitle-<?php echo $freemium_i; ?>" class="of-input" name="faster_theme_options[slidetitle-<?php echo $freemium_i; ?>]" type="text" size="30" value="<?php if(!empty($freemium_options['slidetitle-'.$freemium_i])) { echo wp_filter_nohtml_kses($freemium_options['slidetitle-'.$freemium_i]); } ?>" />
              </div>
              <div class="explain"></div>
            </div>
            </div>
           <div id="section-link" class="section section-text mini">
            <h4 class="heading"><?php _e('Slide','freemium') ?><?php echo $freemium_i; ?> <?php _e('Text','freemium') ?></h4>
            <div class="option">
              <div class="controls">
                <input id="slidetext-<?php echo $freemium_i; ?>" class="of-input" name="faster_theme_options[slidetext-<?php echo $freemium_i; ?>]" type="text" size="30" value="<?php if(!empty($freemium_options['slidetext-'.$freemium_i])) { echo wp_filter_nohtml_kses($freemium_options['slidetext-'.$freemium_i]); } ?>" />
              </div>
              <div class="explain"></div>
            </div>
            </div>
           <?php endfor; ?>
          
		<h3><?php _e('Section Settings','freemium') ?></h3>
    	<?php for($freemium_j=1; $freemium_j <= 4 ;$freemium_j++ ):?> 
        <div id="section-slider-upload" class="section section-text">
        <h4 class="heading"><?php _e('Section ','freemium') ?><?php echo $freemium_j; ?></h4>
        <div class="option">
          <div class="controls">
            <input id="section-icon-<?php echo $freemium_j;?>" class="upload" type="text" name="faster_theme_options[section-icon-<?php echo $freemium_j;?>]" 
                        value="<?php if(!empty($freemium_options['section-icon-'.$freemium_j])) echo esc_url($freemium_options['section-icon-'.$freemium_j]); ?>" placeholder="<?php _e('No file chosen','freemium') ?>" />
            <input id="icon" class="upload-button button" type="button" value="<?php _e('Upload','freemium') ?>" />
            <div class="screenshot" id="slider-image">
              <?php if(!empty($freemium_options['section-icon-'.$freemium_j])) echo "<img src='".esc_url($freemium_options['section-icon-'.$freemium_j])."' /><a class='remove-image'><?php _e('Remove','freemium') ?></a>"; ?>
            </div>
           
          </div>
          <div class="explain"></div>
        </div>
        </div>
        <div id="section-title" class="section section-text mini">
        <div class="option">
          <div class="controls">
            <input id="sectiontitle-<?php echo $freemium_j; ?>" class="of-input" name="faster_theme_options[sectiontitle-<?php echo $freemium_j; ?>]" type="text" size="30" value="<?php if(!empty($freemium_options['sectiontitle-'.$freemium_j])) { echo wp_filter_nohtml_kses($freemium_options['sectiontitle-'.$freemium_j]); } ?>"  placeholder="<?php _e('Section Title','freemium') ?>" />
          </div>
          <div class="explain"></div>
        </div>
        </div>
		<div id="section-desc" class="section section-textarea">
        <div class="option">
          <div class="controls">
          <textarea name="faster_theme_options[sectiondesc-<?php echo $freemium_j; ?>]" id="sectiondesc-<?php echo $freemium_j; ?>" class="of-input" placeholder="<?php _e('Section Description','freemium') ?>" rows="5" ><?php if(!empty($freemium_options['sectiondesc-'.$freemium_j])) { echo wp_filter_nohtml_kses($freemium_options['sectiondesc-'.$freemium_j]); } ?></textarea>
          </div>
          <div class="explain"></div>
        </div>
        </div>          
		<?php endfor; ?>

        <h3><?php _e('Recent Post Settings','freemium') ?></h3>

        <div id="section-category" class="section section-textarea">
            <h4 class="heading"><?php _e('Category','freemium') ?></h4>
            <div class="option">
              <div class="controls">
               <select name="faster_theme_options[post-category]" id="category"> 
                 <option value=""><?php echo esc_attr(__('Select Category','freemium')); ?></option> 
                <?php 
				$freemium_args = array(
       'meta_query' => array(
        array(
         'key' => '_thumbnail_id',
         'compare' => 'EXISTS'
        ),
       )
      );  
      $freemium_post = new WP_Query( $freemium_args );
      $cat_id=array();
     while($freemium_post->have_posts()){
      $freemium_post->the_post();
      $post_id=get_the_id();
      $post_categories = wp_get_post_categories( $post_id );   
      $cat_id[]=$post_categories[0];
     }
     $cat_id=array_unique($cat_id);
				 $freemium_args = array(
				  'orderby' => 'name',
				  'parent' => 0,
				  'include'=>$cat_id
				 );
   			      $freemium_categories = get_categories($freemium_args); 
				  foreach ($freemium_categories as $freemium_category) {
					  if($freemium_category->term_id == $freemium_options['post-category'])
					  	$freemium_selected="selected=selected";
					  else
					  	$freemium_selected='';
                    $freemium_option = '<option value="'.$freemium_category->term_id .'" '.$freemium_selected.'>';
                    $freemium_option .= $freemium_category->cat_name;
                    $freemium_option .= '</option>';
                    echo $freemium_option;
                  }
                 ?>
                </select>
              </div>
              <div class="explain"></div>
            </div>
          </div>

		<h3><?php _e('Area Below Responsive','freemium') ?></h3>
        <div id="area-img" class="section section-text">
        <h4 class="heading"><?php _e('Image','freemium') ?></h4>
        <div class="option">
          <div class="controls">
            <input id="area-img" class="upload" type="text" name="faster_theme_options[area-img]" 
                        value="<?php if(!empty($freemium_options['area-img'])) echo $freemium_options['area-img']; ?>" placeholder="<?php _e('No file chosen','freemium') ?>" />
            <input id="icon" class="upload-button button" type="button" value="<?php _e('Upload','freemium') ?>" />
            <div class="screenshot" id="area-img">
              <?php if(!empty($freemium_options['area-img'])) echo "<img src='".$freemium_options['area-img']."' /><a class='remove-image'><?php _e('Remove','freemium') ?></a>"; ?>
            </div>
           
          </div>
          <div class="explain"></div>
        </div>
        </div>
        <div id="section-category" class="section section-textarea">
       	<?php wp_editor( $freemium_options['subscribe-points'] , 'subscribe-points',array( 'textarea_name' => 'faster_theme_options[subscribe-points]','textarea_rows' => 10) ); ?>
       </div>
      
      
       
       
        <h3><?php _e('Ranking Number Settings','freemium') ?></h3>
    	<?php for($freemium_p=1; $freemium_p <= 4 ;$freemium_p++ ):?> 
        <div id="section-slider-upload" class="section section-text">
        <h4 class="heading"><?php _e('Ranking','freemium') ?> <?php echo $freemium_p; ?></h4>

        </div>
        <div id="section-title" class="section section-text mini">
        <div class="option">
          <div class="controls">
            <input id="rankingnumber-<?php echo $freemium_p; ?>" class="of-input" name="faster_theme_options[rankingnumber-<?php echo $freemium_p; ?>]" type="text" size="30" value="<?php if(!empty($freemium_options['rankingnumber-'.$freemium_p])) { echo wp_filter_nohtml_kses($freemium_options['rankingnumber-'.$freemium_p]); } ?>"  placeholder="<?php _e('Ranking Number-','freemium') ?><?php echo $freemium_p; ?>" />
          </div>
          <div class="explain"></div>
        </div>
        </div>
        <div id="section-title" class="section section-text mini">
        <div class="option">
          <div class="controls">
            <input id="rankingtitle-<?php echo $freemium_p; ?>" class="of-input" name="faster_theme_options[rankingtitle-<?php echo $freemium_p; ?>]" type="text" size="30" value="<?php if(!empty($freemium_options['rankingtitle-'.$freemium_p])) { echo wp_filter_nohtml_kses($freemium_options['rankingtitle-'.$freemium_p]); } ?>"  placeholder="<?php _e('Ranking Title-','freemium') ?><?php echo $freemium_p; ?>" />
          </div>
          <div class="explain"></div>
        </div>
        </div>
		<?php endfor; ?>  
        </div>
        
        <!-------------- End group ----------------->
        
        <!-------------- End group ----------------->
        
        
        
        <div id="fasterthemes_framework-submit" class="section-submite"> 
          <input type="submit" class="button-primary" value="<?php _e('Save Options','freemium') ?>" />
          <div class="clear"></div>
        </div>
        
        <!-- Container -->
        
      </form>
      
      <!--======================== F I N A L - - T H E M E - - O P T I O N S ===================--> 
      
    </div>
 
  </div>
</div>
   
<?php }
