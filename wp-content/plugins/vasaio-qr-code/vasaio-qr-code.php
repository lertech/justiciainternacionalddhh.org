<?php
/*
 *  Plugin Name: Vasaio QR Code
 *  Plugin URI: http://wordpress.org/extend/plugins/vasaio-qr-code/
 *  Description: Generate standalone QR codes, colored and customized with logo inside.
 *  Author: Marius OLAR
 *  Version: 1.2.5
 *  Author URI: http://olarmarius.tk/
 *  License: GPLv3
 *
 */

include_once ("vasaio-qr-code-encoder/functions.php"); 

define (VQRC_TEXTDOMAIN, 'vasaio-qr-code');

//----------------------------------------------------------------------------------------

function vasaio_qr_code_init() {
  load_plugin_textdomain ( VQRC_TEXTDOMAIN, false, 'vasaio-qr-code/languages' );
}

add_action ('plugins_loaded', 'vasaio_qr_code_init');

//----------------------------------------------------------------------------------------

function vasaio_qr_code_activate() {
  add_option('vasaio_qr_size', '256', 'dimensiunea imaginii in pixeli (64, ... 256=default, ... 3000)');
  add_option('vasaio_qr_correction', 'L', 'nivelul de corectie al erorilor (L=7%(default), M=15%, Q=25%, H=30%)');
  add_option('vasaio_qr_filetype', 'PNG', '(PNG=default, JPEG, GIF)');
  add_option('vasaio_qr_border', '4', '(2, 3, 4=default, ... 10)');
  add_option('vasaio_qr_color', '000000', '(default=black)');
  add_option('vasaio_qr_bg_color', 'FFFFFF', '(default=white)');
  add_option('vasaio_qr_logo', site_url().'/wp-content/plugins/vasaio-qr-code/images/VASAIO-QR-Code-logo.png', '(default=none)');
  add_option('vasaio_qr_percent', '7', '(default=7)');
  add_option('vasaio_qr_adjust', '1', '(default=1)');
  add_option('vasaio_qr_effect', '0', '(default=0)');
  $all_options = '?';
  $all_options .= 's='.get_option('vasaio_qr_size');
  $all_options .= '&x='.get_option('vasaio_qr_correction');
  $all_options .= '&t='.get_option('vasaio_qr_filetype');
  $all_options .= '&b='.get_option('vasaio_qr_border');
  $all_options .= '&c='.get_option('vasaio_qr_color');
  $all_options .= '&bg='.get_option('vasaio_qr_bg_color');
  $all_options .= '&o='.get_option('vasaio_qr_logo');
  $all_options .= '&p='.get_option('vasaio_qr_percent');
  $all_options .= '&a='.get_option('vasaio_qr_adjust');
  $all_options .= '&e='.get_option('vasaio_qr_effect');
  add_option('vasaio_qr_all_options', $all_options, '?');
}

//----------------------------------------------------------------------------------------

function vasaio_qr_code_deactivate() {
  delete_option('vasaio_qr_size');
  delete_option('vasaio_qr_correction');
  delete_option('vasaio_qr_filetype');
  delete_option('vasaio_qr_border');
  delete_option('vasaio_qr_color');
  delete_option('vasaio_qr_bg_color');
  delete_option('vasaio_qr_logo');
  delete_option('vasaio_qr_percent');
  delete_option('vasaio_qr_adjust');
  delete_option('vasaio_qr_effect');
  delete_option('vasaio_qr_all_options');
}

register_activation_hook( __FILE__, 'vasaio_qr_code_activate' );
register_deactivation_hook( __FILE__, 'vasaio_qr_code_deactivate' );

//----------------------------------------------------------------------------------------------
//  USE OF Vasaio QR CODE ENCODER
//----------------------------------------------------------------------------------------------
//
//  USE:  	vasaio-qr-code-encoder.php?m=message&s=side&x=correction&t=filetype&b=border&d=download
//
//  WHERE:
//
//		m=message		->	data to encode (default=http://vasaio.tk)
//		s=side			->	dimension of image in pixels (64, ... 256=default, ... 3000)
//		x=correction	->	error correction level (L=7%(default), M=15%, Q=25%, H=30%) - case insensitive
//		t=filetype		->	file type of image (PNG=default, JPEG, GIF) - case insensitive
//		b=border		->	number of squares for qr code white border (2, 3, 4=default, ... 10)
//		d=download		->	if you just want to download the file, set this param to 1 (1 / 0=default)
//		c=color			->	hex code of the main color (default=black)
//		bg=color		->	hex code of the background color (default=white)
//		o=logo			->	filename of logo image, if you want to appear into the QR code (default=null)
//		p=percent		->	percent of logo image, if you want to appear into the QR code (default=7)
//		a=adjust		->	automatic adjust the logo width & height to match with squares (default=1)
//		e=effect		->	special effect means random color for the main color (default=0)
//
//	EX:		vasaio-qr-code-encoder/vasaio-qr-code-encoder.php?m=http://vasaio.tk&s=400&x=M&t=gif&b=2
//
//----------------------------------------------------------------------------------------------

class VasaioQrCodeWidget extends WP_Widget {

	function VasaioQrCodeWidget() {
		// Instantiate the parent object
		parent::__construct( 
		  false, 
		  'Vasaio QR Code',
		  array('description' => __('This widget generates standalone QR codes, colored and customized with logo inside', VQRC_TEXTDOMAIN) . '.' )
		);
	}

  	// Widget output
	function widget( $args, $instance ) {
		extract( $args );

		$vqrc_widget_title = apply_filters( 'widget_title', $instance['vqrc_widget_title'] );
		
		$vqrc_widget_message = apply_filters( 'widget_title', $instance['vqrc_widget_message'] );
		$vqrc_widget_size = apply_filters( 'widget_title', $instance['vqrc_widget_size'] );
		$vqrc_widget_correction = apply_filters( 'widget_title', $instance['vqrc_widget_correction'] );
		$vqrc_widget_filetype = apply_filters( 'widget_title', $instance['vqrc_widget_filetype'] );
		$vqrc_widget_border = apply_filters( 'widget_title', $instance['vqrc_widget_border'] );
		$vqrc_widget_color = apply_filters( 'widget_title', $instance['vqrc_widget_color'] );
		$vqrc_widget_bg_color = apply_filters( 'widget_title', $instance['vqrc_widget_bg_color'] );
		$vqrc_widget_logo = apply_filters( 'widget_title', $instance['vqrc_widget_logo'] );
		$vqrc_widget_percent = apply_filters( 'widget_title', $instance['vqrc_widget_percent'] );
		$vqrc_widget_adjust = apply_filters( 'widget_title', $instance['vqrc_widget_adjust'] );
		$vqrc_widget_effect = apply_filters( 'widget_title', $instance['vqrc_widget_effect'] );

		$vqrc_widget_credit_link = apply_filters( 'widget_title', $instance['vqrc_widget_credit_link'] );

	    if ( !( empty( $vqrc_widget_message ) ) )
			$vqrc_widget_message_out = '&m=' . urlencode( $vqrc_widget_message );
		else
			$vqrc_widget_message_out = '&m=' . urlencode( get_permalink() );

		$vqrc_widget_size_out = $vqrc_widget_size; 
		if ( $vqrc_widget_size == '' ) $vqrc_widget_size_out = get_option('vasaio_qr_size');

		$vqrc_widget_correction_out = $vqrc_widget_correction; 
		if ( $vqrc_widget_correction == '' ) $vqrc_widget_correction_out = get_option('vasaio_qr_correction');

		$vqrc_widget_filetype_out = $vqrc_widget_filetype; 
		if ( $vqrc_widget_filetype == '' ) $vqrc_widget_filetype_out = get_option('vasaio_qr_filetype');

		$vqrc_widget_border_out = $vqrc_widget_border; 
		if ( $vqrc_widget_border == '' ) $vqrc_widget_border_out = get_option('vasaio_qr_border');

		$vqrc_widget_color_out = $vqrc_widget_color; 
		if ( $vqrc_widget_color == '' ) $vqrc_widget_color_out = get_option('vasaio_qr_color');

		$vqrc_widget_bg_color_out = $vqrc_widget_bg_color; 
		if ( $vqrc_widget_bg_color == '' ) $vqrc_widget_bg_color_out = get_option('vasaio_qr_bg_color');

		$vqrc_widget_logo_out = $vqrc_widget_logo; 
		//if ( $vqrc_widget_logo == '' ) $vqrc_widget_logo_out = get_option('vasaio_qr_logo');

		$vqrc_widget_percent_out = $vqrc_widget_percent; 
		if ( $vqrc_widget_percent == '' ) $vqrc_widget_percent_out = get_option('vasaio_qr_percent');

		$vqrc_widget_adjust_out = $vqrc_widget_adjust; 
		if ( $vqrc_widget_adjust == '' ) $vqrc_widget_adjust_out = get_option('vasaio_qr_adjust');

		$vqrc_widget_effect_out = $vqrc_widget_effect; 
		if ( $vqrc_widget_effect == '' ) $vqrc_widget_effect_out = get_option('vasaio_qr_effect');

	    $vqrc_widget_size_out = '&s=' . $vqrc_widget_size_out;
	    $vqrc_widget_correction_out = '&x=' . $vqrc_widget_correction_out;
	    $vqrc_widget_filetype_out = '&t=' . $vqrc_widget_filetype_out;
	    $vqrc_widget_border_out = '&b=' . $vqrc_widget_border_out;
	    $vqrc_widget_color_out = '&c=' . $vqrc_widget_color_out;
	    $vqrc_widget_bg_color_out = '&bg=' . $vqrc_widget_bg_color_out;

	    if ( !( empty( $vqrc_widget_logo_out ) ) )
		{
			$vqrc_widget_logo_out = '&o=' . $vqrc_widget_logo_out; // the logo can be empty
			$vqrc_widget_percent_out = '&p=' . $vqrc_widget_percent_out; 
		}
		else
			$vqrc_widget_percent_out = '&p=0'; // if logo is empty then percent is 0

	    $vqrc_widget_adjust_out = '&a=' . $vqrc_widget_adjust_out;
	    $vqrc_widget_effect_out = '&e=' . $vqrc_widget_effect_out;

		echo $before_widget;
		if ( ! empty( $vqrc_widget_title ) )
			echo $before_title . $vqrc_widget_title . $after_title;
		$widget_qr_code = '<img src="'.get_bloginfo('siteurl').'/wp-content/plugins/vasaio-qr-code/vasaio-qr-code-encoder/vasaio-qr-code-encoder.php?'
		  .$vqrc_widget_size_out
		  .$vqrc_widget_correction_out
		  .$vqrc_widget_filetype_out
		  .$vqrc_widget_border_out
		  .$vqrc_widget_color_out
		  .$vqrc_widget_bg_color_out
		  .$vqrc_widget_logo_out
		  .$vqrc_widget_percent_out
		  .$vqrc_widget_adjust_out
		  .$vqrc_widget_effect_out
		  .$vqrc_widget_message_out
		  .'" class="vasaio-qr-code"/>';
		
		if ( $vqrc_widget_credit_link == 0 )
			$widget_qr_code = '<a href="http://wordpress.org/extend/plugins/vasaio-qr-code/" title="Vasaio QR Code" target="_blank">' . $widget_qr_code . '</a>';

		echo $widget_qr_code;
		echo $after_widget;
	}

  	// Save widget options
	function update( $new_instance, $old_instance ) {
		$instance = array();
		
		$instance['vqrc_widget_title'] = strip_tags( $new_instance['vqrc_widget_title'] );
		
		$instance['vqrc_widget_message'] = strip_tags( $new_instance['vqrc_widget_message'] );
		$instance['vqrc_widget_size'] = strip_tags( $new_instance['vqrc_widget_size'] );
		$instance['vqrc_widget_correction'] = strip_tags( $new_instance['vqrc_widget_correction'] );
		$instance['vqrc_widget_filetype'] = strip_tags( $new_instance['vqrc_widget_filetype'] );
		$instance['vqrc_widget_border'] = strip_tags( $new_instance['vqrc_widget_border'] );
		$instance['vqrc_widget_color'] = strip_tags( $new_instance['vqrc_widget_color'] );
		$instance['vqrc_widget_bg_color'] = strip_tags( $new_instance['vqrc_widget_bg_color'] );
		$instance['vqrc_widget_logo'] = strip_tags( $new_instance['vqrc_widget_logo'] );
		
		if ( empty( $instance['vqrc_widget_logo'] ) )
			$instance['vqrc_widget_percent'] = '0';
		else
			$instance['vqrc_widget_percent'] = strip_tags( $new_instance['vqrc_widget_percent'] );

		$instance['vqrc_widget_adjust'] =  $new_instance['vqrc_widget_adjust'] ? 1 : 0;
		$instance['vqrc_widget_effect'] =  $new_instance['vqrc_widget_effect'] ? 1 : 0;
		$instance['vqrc_widget_credit_link'] = $new_instance['vqrc_widget_credit_link'] ? 1 : 0;

		return $instance;
	}

  	// Output admin widget options form
	function form( $instance )
	{
		// title - can be empty
	    if ( isset( $instance[ 'vqrc_widget_title' ] ) ) {
			$vqrc_widget_title = $instance[ 'vqrc_widget_title' ];
		}
		else {
			$vqrc_widget_title = __( 'Scan with your mobile phone', VQRC_TEXTDOMAIN ).'!';
		    $instance[ 'vqrc_widget_title' ] = $vqrc_widget_title;
		}

		// message - if empty then is permalink
	    if ( isset( $instance[ 'vqrc_widget_message' ] ) ) {
			$vqrc_widget_message = $instance[ 'vqrc_widget_message' ];
		}
		else {
			$vqrc_widget_message = ''; // default is empty to use permalink by default
		    $instance[ 'vqrc_widget_message' ] = $vqrc_widget_message;
		}

		// size
	    if ( isset( $instance[ 'vqrc_widget_size' ] ) ) {
			$instance[ 'vqrc_widget_size' ] = trim( $instance[ 'vqrc_widget_size' ] );
			$vqrc_widget_size = $instance[ 'vqrc_widget_size' ];
			if ( $instance[ 'vqrc_widget_size' ] == '' ) $vqrc_widget_size = get_option('vasaio_qr_size');
		} 
	    else {
	    	$vqrc_widget_size = get_option('vasaio_qr_size');
		    $instance[ 'vqrc_widget_size' ] = $vqrc_widget_size;
		}

		// correction
	    if ( isset( $instance[ 'vqrc_widget_correction' ] ) ) {
			$instance[ 'vqrc_widget_correction' ] = trim( $instance[ 'vqrc_widget_correction' ] );
			$vqrc_widget_correction = $instance[ 'vqrc_widget_correction' ];
			if ( $instance[ 'vqrc_widget_correction' ] == '' ) $vqrc_widget_correction = get_option('vasaio_qr_correction');
		} 
	    else {
	    	$vqrc_widget_correction = get_option('vasaio_qr_correction');
		    $instance[ 'vqrc_widget_correction' ] = $vqrc_widget_correction;
		}

		// filetype
	    if ( isset( $instance[ 'vqrc_widget_filetype' ] ) ) {
			$instance[ 'vqrc_widget_filetype' ] = trim( $instance[ 'vqrc_widget_filetype' ] );
			$vqrc_widget_filetype = $instance[ 'vqrc_widget_filetype' ];
			if ( $instance[ 'vqrc_widget_filetype' ] == '' ) $vqrc_widget_filetype = get_option('vasaio_qr_filetype');
		} 
	    else {
	    	$vqrc_widget_filetype = get_option('vasaio_qr_filetype');
		    $instance[ 'vqrc_widget_filetype' ] = $vqrc_widget_filetype;
		}

		// border
	    if ( isset( $instance[ 'vqrc_widget_border' ] ) ) {
			$instance[ 'vqrc_widget_border' ] = trim( $instance[ 'vqrc_widget_border' ] );
			$vqrc_widget_border = $instance[ 'vqrc_widget_border' ];
			if ( $instance[ 'vqrc_widget_border' ] == '' ) $vqrc_widget_border = get_option('vasaio_qr_border');
		} 
	    else {
	    	$vqrc_widget_border = get_option('vasaio_qr_border');
		    $instance[ 'vqrc_widget_border' ] = $vqrc_widget_border;
		}

		// main color
	    if ( isset( $instance[ 'vqrc_widget_color' ] ) ) {
			$instance[ 'vqrc_widget_color' ] = trim( $instance[ 'vqrc_widget_color' ] );
			$vqrc_widget_color = $instance[ 'vqrc_widget_color' ];
			if ( $instance[ 'vqrc_widget_color' ] == '' ) $vqrc_widget_color = get_option('vasaio_qr_color');
		} 
	    else {
	    	$vqrc_widget_color = get_option('vasaio_qr_color');
		    $instance[ 'vqrc_widget_color' ] = $vqrc_widget_color;
		}

		// background color
	    if ( isset( $instance[ 'vqrc_widget_bg_color' ] ) ) {
			$instance[ 'vqrc_widget_bg_color' ] = trim( $instance[ 'vqrc_widget_bg_color' ] );
			$vqrc_widget_bg_color = $instance[ 'vqrc_widget_bg_color' ];
			if ( $instance[ 'vqrc_widget_bg_color' ] == '' ) $vqrc_widget_bg_color = get_option('vasaio_qr_bg_color');
		} 
	    else {
	    	$vqrc_widget_bg_color = get_option('vasaio_qr_bg_color');
		    $instance[ 'vqrc_widget_bg_color' ] = $vqrc_widget_bg_color;
		}

		// logo - can be empty
	    if ( isset( $instance[ 'vqrc_widget_logo' ] ) ) {
			$instance[ 'vqrc_widget_logo' ] = trim( $instance[ 'vqrc_widget_logo' ] );
			$vqrc_widget_logo = $instance[ 'vqrc_widget_logo' ];
			if ( $instance[ 'vqrc_widget_logo' ] == '' ) $instance[ 'vqrc_widget_percent' ] = '0';
		} 
	    else {
	    	$vqrc_widget_logo = get_option('vasaio_qr_logo');
		    $instance[ 'vqrc_widget_logo' ] = $vqrc_widget_logo;
		}

		// percent
	    if ( isset( $instance[ 'vqrc_widget_percent' ] ) ) {
			$instance[ 'vqrc_widget_percent' ] = trim( $instance[ 'vqrc_widget_percent' ] );
			$vqrc_widget_percent = $instance[ 'vqrc_widget_percent' ];
			if ( $instance[ 'vqrc_widget_percent' ] == '' ) $vqrc_widget_percent = get_option('vasaio_qr_percent');
		} 
	    else {
	    	$vqrc_widget_percent = get_option('vasaio_qr_percent');
		    $instance[ 'vqrc_widget_percent' ] = $vqrc_widget_percent;
		}

		// adjust
	    if ( isset( $instance[ 'vqrc_widget_adjust' ] ) ) {
			$vqrc_widget_adjust = $instance['vqrc_widget_adjust'] ? ' checked="checked" ' : '';
		} 
	    else {
			$vqrc_widget_adjust = get_option('vasaio_qr_adjust') ? ' checked="checked" ' : '';
		}

		// effect
	    if ( isset( $instance[ 'vqrc_widget_effect' ] ) ) {
			$vqrc_widget_effect = $instance['vqrc_widget_effect'] ? ' checked="checked" ' : '';
		} 
	    else {
			$vqrc_widget_effect = get_option('vasaio_qr_effect') ? ' checked="checked" ' : '';
		}

		// Disable the credit link: http://wordpress.org/extend/plugins/vasaio-qr-code/
		$vqrc_widget_credit_link = $instance['vqrc_widget_credit_link'] ? ' checked="checked" ' : '';

		$default_vasaio_qr_color_contrast = round(
			get_the_contrast( esc_attr( $vqrc_widget_color ),
				esc_attr( $vqrc_widget_bg_color )), 3);
	?>
		<p>
		<label for="<?php echo $this->get_field_id( 'vqrc_widget_title' ); ?>"><?php echo __( 'Title', VQRC_TEXTDOMAIN); ?>:</label> 
		  <input class="widefat" id="<?php echo $this->get_field_id( 'vqrc_widget_title' ); ?>" name="<?php echo $this->get_field_name( 'vqrc_widget_title' ); ?>" type="text" value="<?php echo esc_attr( $vqrc_widget_title ); ?>" />
		</p>

		<p title="<?php echo __( 'Leave this field empty to use permalink instead', VQRC_TEXTDOMAIN); ?>!">
		<label for="<?php echo $this->get_field_id( 'vqrc_widget_message' ); ?>"><?php echo __( 'QR code message', VQRC_TEXTDOMAIN); ?>:</label> 
		  <input class="widefat" id="<?php echo $this->get_field_id( 'vqrc_widget_message' ); ?>" name="<?php echo $this->get_field_name( 'vqrc_widget_message' ); ?>" type="text" value="<?php echo esc_attr( $vqrc_widget_message ); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'vqrc_widget_size' ); ?>"><?php echo __('Image width', VQRC_TEXTDOMAIN); ?></label> 
		<input class="widefat" style="width:40px;" id="<?php echo $this->get_field_id( 'vqrc_widget_size' ); ?>" name="<?php echo $this->get_field_name( 'vqrc_widget_size' ); ?>" type="text" value="<?php echo esc_attr( $vqrc_widget_size ); ?>" /> (64..3000)
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'vqrc_widget_correction' ); ?>"><?php echo __('Destruction tolerance', VQRC_TEXTDOMAIN); ?></label> 
			<select id="<?php echo $this->get_field_id('vqrc_widget_correction'); ?>" name="<?php echo $this->get_field_name('vqrc_widget_correction'); ?>">
		<?php
			$corrections = array ('L', 'M', 'Q', 'H');
			$corrections_name = array (
				'L' => __('Low (L=7%)', VQRC_TEXTDOMAIN),
				'M' => __('Medium (M=15%)', VQRC_TEXTDOMAIN),
				'Q' => __('Quality (Q=25%)', VQRC_TEXTDOMAIN), 
				'H' => __('High (H=30%)', VQRC_TEXTDOMAIN)
			);
			foreach ( $corrections as $value ) {
				$selected = $vqrc_widget_correction == $value ? ' selected="selected" ' : '';
				echo '<option'. $selected .' value="'. $value .'">'. $corrections_name[$value] .'</option>';
			}
		?>
			</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'vqrc_widget_filetype' ); ?>"><?php echo __('Image filetype', VQRC_TEXTDOMAIN); ?></label> 
			<select id="<?php echo $this->get_field_id('vqrc_widget_filetype'); ?>" name="<?php echo $this->get_field_name('vqrc_widget_filetype'); ?>">
		<?php
			$filetypes = array ('PNG', 'JPEG', 'GIF');
			foreach ( $filetypes as $value ) {
				$selected = $vqrc_widget_filetype == $value ? ' selected="selected" ' : '';
				echo '<option'. $selected .' value="'. $value .'">'. $value .'</option>';
			}
		?>
			</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'vqrc_widget_border' ); ?>"><?php echo __('Edge size', VQRC_TEXTDOMAIN); ?></label> 
			<select id="<?php echo $this->get_field_id('vqrc_widget_border'); ?>" name="<?php echo $this->get_field_name('vqrc_widget_border'); ?>">
		<?php
			$borders = array (2, 3, 4, 5, 6, 7, 8, 9, 10);
			foreach ( $borders as $value ) {
				$selected = $vqrc_widget_border == $value ? ' selected="selected" ' : '';
				echo '<option'. $selected .' value="'. $value .'">'. $value .'</option>';
			}
		?>
			</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'vqrc_widget_color' ); ?>"><?php echo __('Main color', VQRC_TEXTDOMAIN); ?></label> 
		<input class="color" style="width:60px;" id="<?php echo $this->get_field_id( 'vqrc_widget_color' ); ?>" name="<?php echo $this->get_field_name( 'vqrc_widget_color' ); ?>" type="text" value="<?php echo esc_attr( $vqrc_widget_color ); ?>" />
		</p>

		<p>
		<label for="vqrc_widget_contrast"><?php echo __('Contrast', VQRC_TEXTDOMAIN); ?> </label> 
		<strong><?php echo $default_vasaio_qr_color_contrast; ?></strong>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'vqrc_widget_bg_color' ); ?>"><?php echo __('Background color', VQRC_TEXTDOMAIN); ?></label> 
		<input class="color" style="width:60px;" id="<?php echo $this->get_field_id( 'vqrc_widget_bg_color' ); ?>" name="<?php echo $this->get_field_name( 'vqrc_widget_bg_color' ); ?>" type="text" value="<?php echo esc_attr( $vqrc_widget_bg_color ); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'vqrc_widget_logo' ); ?>"><?php echo __('Logo', VQRC_TEXTDOMAIN); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'vqrc_widget_logo' ); ?>" name="<?php echo $this->get_field_name( 'vqrc_widget_logo' ); ?>" type="text" value="<?php echo esc_attr( $vqrc_widget_logo ); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'vqrc_widget_percent' ); ?>"><?php echo __('Logo area', VQRC_TEXTDOMAIN); ?></label> 
		<input class="widefat" style="width:40px;" id="<?php echo $this->get_field_id( 'vqrc_widget_percent' ); ?>" name="<?php echo $this->get_field_name( 'vqrc_widget_percent' ); ?>" type="text" value="<?php echo esc_attr( $vqrc_widget_percent ); ?>" /> (0..100%)
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php echo $vqrc_widget_adjust; ?> id="<?php echo $this->get_field_id('vqrc_widget_adjust'); ?>" name="<?php echo $this->get_field_name('vqrc_widget_adjust'); ?>" /> <label for="<?php echo $this->get_field_id('vqrc_widget_adjust'); ?>"><?php echo __( 'Automatic adjustment of the logo', VQRC_TEXTDOMAIN ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php echo $vqrc_widget_effect; ?> id="<?php echo $this->get_field_id('vqrc_widget_effect'); ?>" name="<?php echo $this->get_field_name('vqrc_widget_effect'); ?>" /> <label for="<?php echo $this->get_field_id('vqrc_widget_effect'); ?>"><?php echo __( 'Apply special effect for main color', VQRC_TEXTDOMAIN ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php echo $vqrc_widget_credit_link; ?> id="<?php echo $this->get_field_id('vqrc_widget_credit_link'); ?>" name="<?php echo $this->get_field_name('vqrc_widget_credit_link'); ?>" /> <label for="<?php echo $this->get_field_id('vqrc_widget_credit_link'); ?>"><?php echo __( 'Disable the credit link', VQRC_TEXTDOMAIN ); ?></label>
		</p>

		<?php 
	}
}

function vasaio_qr_code_register_widgets() {
	register_widget( 'VasaioQrCodeWidget' );
}

add_action( 'widgets_init', 'vasaio_qr_code_register_widgets' );

//----------------------------------------------------------------------------------------------

function admin_vasaio_qr_options() {
  ?><div class="wrap"><h2>Vasaio QR Code</h2><?php

  if ($_REQUEST['submit']) {
     update_vasaio_qr_options();
  }
  print_vasaio_qr_form();

  ?></div><?php
}

//----------------------------------------------------------------------------------------------

function update_vasaio_qr_options() {
  $all_options = '?';
  $eroare = '';
  
  $ok = false; if ($_REQUEST['vasaio_qr_size']) { update_option('vasaio_qr_size', $_REQUEST['vasaio_qr_size']);
  $ok = true; $all_options .= 's='.$_REQUEST['vasaio_qr_size'];} else {$eroare.='2';}
  
  $ok = false; if ($_REQUEST['vasaio_qr_correction']) { update_option('vasaio_qr_correction', $_REQUEST['vasaio_qr_correction']);  $ok = true; $all_options .= '&x='.$_REQUEST['vasaio_qr_correction'];} else {$eroare.='3';}
  
  $ok = false; if ($_REQUEST['vasaio_qr_filetype']) { update_option('vasaio_qr_filetype', $_REQUEST['vasaio_qr_filetype']);  
  $ok = true; $all_options .= '&t='.$_REQUEST['vasaio_qr_filetype'];} else {$eroare.='4';}
  
  $ok = false; if ($_REQUEST['vasaio_qr_border']) { update_option('vasaio_qr_border', $_REQUEST['vasaio_qr_border']);  
  $ok = true; $all_options .= '&b='.$_REQUEST['vasaio_qr_border'];} else {$eroare.='5';}
  
  $ok = false; if ($_REQUEST['vasaio_qr_color']) { update_option('vasaio_qr_color', $_REQUEST['vasaio_qr_color']);  
  $ok = true; $all_options .= '&c='.$_REQUEST['vasaio_qr_color'];} else {$eroare.='6';}
  
  $ok = false; if ($_REQUEST['vasaio_qr_bg_color']) { update_option('vasaio_qr_bg_color', $_REQUEST['vasaio_qr_bg_color']);  
  $ok = true; $all_options .= '&bg='.$_REQUEST['vasaio_qr_bg_color'];} else {$eroare.='6';}
  
  $ok = false; if (isset($_REQUEST['vasaio_qr_logo'])) { update_option('vasaio_qr_logo', $_REQUEST['vasaio_qr_logo']);  
  $ok = true; if($_REQUEST['vasaio_qr_logo']) $all_options .= '&o='.$_REQUEST['vasaio_qr_logo'];} else {$eroare.='7';}
  
  $ok = false; if (isset($_REQUEST['vasaio_qr_percent'])) { update_option('vasaio_qr_percent', $_REQUEST['vasaio_qr_percent']);  $ok = true; $all_options .= '&p='.$_REQUEST['vasaio_qr_percent'];} else {$eroare.='8';}
  
  $ok = false; if (isset($_REQUEST['vasaio_qr_adjust'])) { update_option('vasaio_qr_adjust', $_REQUEST['vasaio_qr_adjust']);  
  $ok = true; $all_options .= '&a='.$_REQUEST['vasaio_qr_adjust'];} else {$eroare.='9';}
  
  $ok = false; if (isset($_REQUEST['vasaio_qr_effect'])) { update_option('vasaio_qr_effect', $_REQUEST['vasaio_qr_effect']);  
  $ok = true; $all_options .= '&e='.$_REQUEST['vasaio_qr_effect'];} else {$eroare.='9';}
  
  $ok = false; if ($all_options) { update_option('vasaio_qr_all_options', $all_options);  
  $ok = true; } else {$eroare.='0';}
 
  if ($ok) {
    ?><div id="message" class="updated fadee">
       <p><?php echo __('Message', VQRC_TEXTDOMAIN); ?>: <strong> <?php echo __('Saved options', VQRC_TEXTDOMAIN); ?>!</strong></p>
      </div><?php
  } else {
       ?><div id="message" class="error fade">
         <p><?php echo __('Message', VQRC_TEXTDOMAIN); ?>: <strong> <?php echo __('Error saving options', VQRC_TEXTDOMAIN); ?>! (<?php echo $eroare;?>) </strong></p>
         </div><?php
  }
}

//----------------------------------------------------------------------------------------------

function print_vasaio_qr_form() {
  $default_vasaio_qr_size = get_option('vasaio_qr_size');
  $default_vasaio_qr_correction = get_option('vasaio_qr_correction');
  $default_vasaio_qr_filetype = get_option('vasaio_qr_filetype');
  $default_vasaio_qr_border = get_option('vasaio_qr_border');
  $default_vasaio_qr_color = get_option('vasaio_qr_color');
  $default_vasaio_qr_bg_color = get_option('vasaio_qr_bg_color');
  $default_vasaio_qr_logo = get_option('vasaio_qr_logo');
  $default_vasaio_qr_percent = get_option('vasaio_qr_percent');
  $default_vasaio_qr_adjust = get_option('vasaio_qr_adjust');
  $default_vasaio_qr_effect = get_option('vasaio_qr_effect');
  $default_vasaio_qr_options = get_option('vasaio_qr_all_options');
  
  $default_vasaio_qr_suggested_bg_color = 
	get_the_best_color($default_vasaio_qr_color);
  
  $default_vasaio_qr_color_contrast = round(
	get_the_contrast( $default_vasaio_qr_color,
	$default_vasaio_qr_bg_color), 3);
  
  $default_vasaio_qr_suggested_color_contrast = round(
	get_the_contrast( $default_vasaio_qr_color,
	$default_vasaio_qr_suggested_bg_color), 3);
  ?>
<div class="tabber">

     <div class="tabbertab">
	  <h2><?php echo __('Settings', VQRC_TEXTDOMAIN); ?></h2>
	  
	  <h1><?php echo __('Settings', VQRC_TEXTDOMAIN); ?></h1>

<?php echo '<div style="float:left; width:100%; height:auto;" ><div style="float:left; width:auto; height:auto; border:solid 1px #AAA; margin:10px;"><img style="display:block;" src="'.get_bloginfo('siteurl').'/wp-content/plugins/vasaio-qr-code/vasaio-qr-code-encoder/vasaio-qr-code-encoder.php'.$default_vasaio_qr_options.'&m=http://vasaio.tk" /></div></div>';
?>
  <div class="postbox" style="float:left; width:auto; height:auto; padding:10px;margin:10px;" >
  <form method="POST">
  
  <table>
  <tbody>

  <tr>
    <td><label for="vasaio_qr_size"><?php echo __('Image width', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><input type="text" name="vasaio_qr_size" value="<?php echo$default_vasaio_qr_size;?>" size="5" /></td>
    <td><?php echo __('image size in pixels (64, ... 256 = default, ... 3000)', VQRC_TEXTDOMAIN); ?></td>
  </tr>

  <tr style="background-color:aliceblue;">
    <td><label for="vasaio_qr_correction"><?php echo __('Destruction tolerance', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><select name="vasaio_qr_correction">
        <option value="L" <?php if($default_vasaio_qr_correction=='L')echo' selected=selected ';?> /><?php echo __('Low (L=7%)', VQRC_TEXTDOMAIN); ?></option>
        <option value="M" <?php if($default_vasaio_qr_correction=='M')echo' selected=selected ';?> /><?php echo __('Medium (M=15%)', VQRC_TEXTDOMAIN); ?></option>
        <option value="Q" <?php if($default_vasaio_qr_correction=='Q')echo' selected=selected ';?> /><?php echo __('Quality (Q=25%)', VQRC_TEXTDOMAIN); ?></option>
        <option value="H" <?php if($default_vasaio_qr_correction=='H')echo' selected=selected ';?> /><?php echo __('High (H=30%)', VQRC_TEXTDOMAIN); ?></option>
	  </select></td>
    <td><?php echo __('the correction of errors (L = 7% (default), M = 15%, Q = 25%, H = 30%)', VQRC_TEXTDOMAIN); ?></td>
  </tr>

  <tr>
    <td><label for="vasaio_qr_filetype"><?php echo __('Image filetype', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><select name="vasaio_qr_filetype">
        <option value="PNG" <?php if($default_vasaio_qr_filetype=='PNG')echo' selected=selected ';?> />PNG</option>
        <option value="JPEG" <?php if($default_vasaio_qr_filetype=='JPEG')echo' selected=selected ';?> />JPEG</option>
        <option value="GIF" <?php if($default_vasaio_qr_filetype=='GIF')echo' selected=selected ';?> />GIF</option>
	  </select></td>
    <td><?php echo __('file type of QR code (PNG=default, JPEG, GIF) - case insensitive', VQRC_TEXTDOMAIN); ?></td>
  </tr>

  <tr style="background-color:aliceblue;">
    <td><label for="vasaio_qr_border"><?php echo __('Edge size', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><select name="vasaio_qr_border">
        <option value="2" <?php if($default_vasaio_qr_border=='2')echo' selected=selected ';?> />2</option>
        <option value="3" <?php if($default_vasaio_qr_border=='3')echo' selected=selected ';?> />3</option>
        <option value="4" <?php if($default_vasaio_qr_border=='4')echo' selected=selected ';?> />4</option>
        <option value="5" <?php if($default_vasaio_qr_border=='5')echo' selected=selected ';?> />5</option>
        <option value="6" <?php if($default_vasaio_qr_border=='6')echo' selected=selected ';?> />6</option>
        <option value="7" <?php if($default_vasaio_qr_border=='7')echo' selected=selected ';?> />7</option>
        <option value="8" <?php if($default_vasaio_qr_border=='8')echo' selected=selected ';?> />8</option>
        <option value="9" <?php if($default_vasaio_qr_border=='9')echo' selected=selected ';?> />9</option>
        <option value="10" <?php if($default_vasaio_qr_border=='10')echo' selected=selected ';?> />10</option>
	  </select></td>
    <td><?php echo __('number of squares from edge (2, 3, 4 = default, ... 10)', VQRC_TEXTDOMAIN); ?></td>
  </tr>

  <script type="text/javascript" src="<?php echo get_bloginfo('siteurl');?>/wp-content/plugins/vasaio-qr-code/vasaio-qr-code-encoder/jscolor/jscolor.js"></script>
  <tr>
    <td><label for="vasaio_qr_color"><?php echo __('Main color', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><input type="text" name="vasaio_qr_color" value="<?php echo$default_vasaio_qr_color;?>" class="color" /></td>
    <td><?php echo __('squares color (default = black)', VQRC_TEXTDOMAIN); ?></td>
  </tr>

  <tr style="background-color:aliceblue;">
    <td><label for="vasaio_qr_color_contrast"><?php echo __('Color contrast', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><input type="text" name="vasaio_qr_color_contrast" value="<?php echo$default_vasaio_qr_color_contrast;?>" disabled="disabled" size="7" /></td>
    <td><?php echo __('contrast between main color and background color (greater is the best, greater than 5 is ok)', VQRC_TEXTDOMAIN); ?></td>
  </tr>

  <tr>
    <td><label for="vasaio_qr_bg_color"><?php echo __('Background color', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><input type="text" name="vasaio_qr_bg_color" id="vasaio_qr_bg_color" value="<?php echo$default_vasaio_qr_bg_color;?>" class="color" /></td>
    <td><?php echo __('background color (default = white)', VQRC_TEXTDOMAIN); ?></td>
  </tr>

  <tr style="background-color:aliceblue;">
    <td><label for="vasaio_qr_suggested_bg_color"><?php echo __('Suggested background color', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><input type="text" name="vasaio_qr_suggested_bg_color" id="vasaio_qr_suggested_bg_color" value="<?php echo$default_vasaio_qr_suggested_bg_color;?>" /></td>
	<td>
	<?php echo __('the contrast between the main color and the suggested background color is: ', VQRC_TEXTDOMAIN); ?><strong><?php echo$default_vasaio_qr_suggested_color_contrast;?></strong></td>
  </tr>

  <tr>
    <td><label for="vasaio_qr_effect"><?php echo __('Special color effect', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><select name="vasaio_qr_effect">
        <option value="1" <?php if($default_vasaio_qr_effect=='1')echo' selected=selected ';?> /><?php echo __('random color', VQRC_TEXTDOMAIN); ?></option>
        <option value="0" <?php if($default_vasaio_qr_effect=='0')echo' selected=selected ';?> /><?php echo __('without effect', VQRC_TEXTDOMAIN); ?></option>
	  </select></td>
    <td><?php echo __('special color effect for main color', VQRC_TEXTDOMAIN); ?></td>
  </tr>

  <tr style="background-color:aliceblue;">
    <td><label for="vasaio_qr_logo"><?php echo __('Logo', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><input type="text" name="vasaio_qr_logo" value="<?php echo$default_vasaio_qr_logo;?>" /></td>
    <td><?php echo __('this logo will appear in all QR codes', VQRC_TEXTDOMAIN); ?></td>
  </tr>

  <tr>
    <td><label for="vasaio_qr_percent"><?php echo __('Logo area', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><input type="text" name="vasaio_qr_percent" value="<?php echo$default_vasaio_qr_percent;?>" /></td>
    <td><?php echo __('logo coverage (percentage of QR code - recommended 10%)', VQRC_TEXTDOMAIN); ?></td>
  </tr>

  <tr style="background-color:aliceblue;">
    <td><label for="vasaio_qr_adjust"><?php echo __('Automatic adjustment', VQRC_TEXTDOMAIN); ?>:</label></td>
    <td><select name="vasaio_qr_adjust">
        <option value="1" <?php if($default_vasaio_qr_adjust=='1')echo' selected=selected ';?> /><?php echo __('automatic', VQRC_TEXTDOMAIN); ?></option>
        <option value="0" <?php if($default_vasaio_qr_adjust=='0')echo' selected=selected ';?> /><?php echo __('without adjustment', VQRC_TEXTDOMAIN); ?></option>
	  </select></td>
    <td><?php echo __('automatic adjustment of the logo', VQRC_TEXTDOMAIN); ?></td>
  </tr> 
  
  <tr>
    <td colspan="3"><hr></td>
  </tr>

  <tr>
    <td colspan="3"><input type="submit" name="submit" value="<?php echo __('Save', VQRC_TEXTDOMAIN); ?>" /></td>
  </tr>
  </tbody>
  </table>
  </form>
<?php

  $short_size_txt = "";
  $short_size = get_option('vasaio_qr_size');
  if ( $short_size != "" ) $short_size_txt = 's="'.$short_size.'" ';

  $short_correction_txt = "";
  $short_correction = get_option('vasaio_qr_correction');
  if ( $short_correction != "" ) $short_correction_txt = 'x="'.$short_correction.'" ';

  $short_filetype_txt = "";
  $short_filetype = get_option('vasaio_qr_filetype');
  if ( $short_filetype != "" ) $short_filetype_txt = 't="'.$short_filetype.'" ';

  $short_border_txt = "";
  $short_border = get_option('vasaio_qr_border');
  if ( $short_border != "" ) $short_border_txt = 'b="'.$short_border.'" ';

  $short_color_txt = "";
  $short_color = get_option('vasaio_qr_color');
  if ( $short_color != "" ) $short_color_txt = 'c="'.$short_color.'" ';

  $short_bg_color_txt = "";
  $short_bg_color = get_option('vasaio_qr_bg_color');
  if ( $short_bg_color != "" ) $short_bg_color_txt = 'bg="'.$short_bg_color.'" ';

  $short_logo_txt = "";
  $short_logo = get_option('vasaio_qr_logo');
  if ( $short_logo != "" ) $short_logo_txt = 'o="'.$short_logo.'" ';

  $short_percent_txt = "";
  $short_percent = get_option('vasaio_qr_percent');
  if ( $short_percent != "" ) $short_percent_txt = 'p="'.$short_percent.'" ';

  $short_adjust_txt = "";
  $short_adjust = get_option('vasaio_qr_adjust');
  if ( $short_adjust != "" ) $short_adjust_txt = 'a="'.$short_adjust.'" ';

  $short_effect_txt = "";
  $short_effect = get_option('vasaio_qr_effect');
  if ( $short_effect != "" ) $short_effect_txt = 'e="'.$short_effect.'" ';

  $short_txt = '[vasaioqrcode '
	.$short_size_txt
	.$short_correction_txt
	.$short_filetype_txt
	.$short_border_txt
	.$short_color_txt
	.$short_bg_color_txt
	.$short_logo_txt
	.$short_percent_txt
	.$short_adjust_txt
	.$short_effect_txt
	.'m="http://vasaio.tk"]';
?>  
  <br />
   
  <table>
  <tbody>
  <tr>
	<td></td>
    <td><?php echo __('If you omit one of the parameter, the parameter will be take from options above', VQRC_TEXTDOMAIN); ?></td>
  </tr>
  <tr>
    <td><?php echo __('Resulted shortcode', VQRC_TEXTDOMAIN); ?>:</td>
    <td><textarea name="short" disabled="disabled" cols="75" rows="5"><?php echo$short_txt;?></textarea></td>
  </tr>
  </tbody>
  </table>
 
  </div>
     </div>
	 
     <div class="tabbertab">
	  <h2><?php echo __('Documentation', VQRC_TEXTDOMAIN); ?></h2>
	  
	  <h1><?php echo __('Documentation', VQRC_TEXTDOMAIN); ?></h1>

  <div class="postbox" style="float:left; width:auto; height:auto; padding:10px;margin:10px;" >
  
	  <p><?php echo __('To use this plugin just put the [vasaioqrcode] shortcode into the content of the page', VQRC_TEXTDOMAIN) . '.'; ?></p>
	  
	  <p>You can customize the QR code using this explanation of the shortcode parameters.</p>

<p>
<table border="1" cellspacing="0" cellpadding="5">
<tbody>
<tr>
	<th><?php echo __('Parameter', VQRC_TEXTDOMAIN); ?></th>
	<th><?php echo __('Explanation', VQRC_TEXTDOMAIN); ?></th>
	<th><?php echo __('Description', VQRC_TEXTDOMAIN); ?></th>
</tr>

<tr style="background-color:aliceblue;"><td><strong>m</strong></td><td><?php echo __('message', VQRC_TEXTDOMAIN); ?></td><td><?php echo __('data to encode (default=permalink)', VQRC_TEXTDOMAIN); ?></td></tr>

<tr><td><strong>s</strong></td><td><?php echo __('size', VQRC_TEXTDOMAIN); ?></strong></td><td><?php echo __('image size in pixels (64, ... 256 = default, ... 3000)', VQRC_TEXTDOMAIN); ?></td></tr>

<tr style="background-color:aliceblue;"><td><strong>x</strong></td><td><?php echo __('correction', VQRC_TEXTDOMAIN); ?></strong></td><td><?php echo __('the correction of errors (L = 7% (default), M = 15%, Q = 25%, H = 30%)', VQRC_TEXTDOMAIN); ?></td></tr>

<tr><td><strong>t</strong></td><td><?php echo __('filetype', VQRC_TEXTDOMAIN); ?></strong></td><td><?php echo __('file type of QR code (PNG=default, JPEG, GIF) - case insensitive', VQRC_TEXTDOMAIN); ?></td></tr>

<tr style="background-color:aliceblue;"><td><strong>b</strong></td><td><?php echo __('border', VQRC_TEXTDOMAIN); ?></strong></td><td><?php echo __('number of squares from edge (2, 3, 4 = default, ... 10)', VQRC_TEXTDOMAIN); ?></td></tr>

<tr><td><strong>c</strong></td><td><?php echo __('color', VQRC_TEXTDOMAIN); ?></strong></td><td><?php echo __('squares color (default = black)', VQRC_TEXTDOMAIN); ?></td></tr>

<tr><td><strong>bg</strong></td><td><?php echo __('color', VQRC_TEXTDOMAIN); ?></strong></td><td><?php echo __('background color (default = white)', VQRC_TEXTDOMAIN); ?></td></tr>

<tr style="background-color:aliceblue;"><td><strong>o</strong></td><td><?php echo __('logo', VQRC_TEXTDOMAIN); ?></strong></td><td><?php echo __('this logo will appear in all QR codes', VQRC_TEXTDOMAIN); ?></td></tr>

<tr><td><strong>p</strong></td><td><?php echo __('percent', VQRC_TEXTDOMAIN); ?></strong></td><td><?php echo __('logo coverage (percentage of QR code - recommended 10%)', VQRC_TEXTDOMAIN); ?></td></tr>

<tr style="background-color:aliceblue;"><td><strong>a</strong></td><td><?php echo __('adjust', VQRC_TEXTDOMAIN); ?></strong></td><td><?php echo __('automatic adjustment of the logo', VQRC_TEXTDOMAIN); ?> (0/1)</td></tr>

<tr style="background-color:aliceblue;"><td><strong>e</strong></td><td><?php echo __('effect', VQRC_TEXTDOMAIN); ?></strong></td><td><?php echo __('special color effect for main color', VQRC_TEXTDOMAIN); ?> (0/1)</td></tr>

</tbody>
</table>
</p>

	  <p><?php echo __('For more examples visit', VQRC_TEXTDOMAIN) . ': <a href="http://wordpress.org/extend/plugins/vasaio-qr-code/" target="_blank">http://wordpress.org/extend/plugins/vasaio-qr-code/</a>'; ?></p>
 
 	  <h1><?php echo __('Examples', VQRC_TEXTDOMAIN); ?></h1>
	  <p><strong>[vasaioqrcode]</strong><br /></p>
	  <p><strong>[vasaioqrcode m="http://google.com"]</strong><br /></p>
	  <p><strong>[vasaioqrcode s="100"]</strong><br /></p>
	  <p><strong>[vasaioqrcode x="m"]</strong><br /></p>
	  <p><strong>[vasaioqrcode t="gif"]</strong><br /></p>
	  <p><strong>[vasaioqrcode b="2"]</strong><br /></p>
	  <p><strong>[vasaioqrcode c="000000"]</strong><br /></p>
	  <p><strong>[vasaioqrcode bg="FFFFFF"]</strong><br /></p>
	  <p><strong>[vasaioqrcode x="L" s="512" c="f0f0f0" o="http://www.google.com/homepage/images/google_favicon_64.png"]</strong><br /></p>
	  <p><strong>[vasaioqrcode p="0"]</strong><br /></p>
	  <p><strong>[vasaioqrcode a="0" s="512"]</strong><br /></p>
	  <p><strong>[vasaioqrcode s="512"]</strong><br /></p>
    </div>
	 
     </div>
     </div>
  <?php
}

//----------------------------------------------------------------------------------------------

function vasaio_qr_code_style_for_front_end() {
	echo'
	<style type="text/css">
	.vasaio-qr-code { margin:10px;}
	</style>
	';
}

add_action('wp_head', 'vasaio_qr_code_style_for_front_end');

//----------------------------------------------------------------------------------------------

function vasaio_qr_code_style_for_back_end() {
	echo'
	<script type="text/javascript" src="'.get_bloginfo('siteurl').'/wp-content/plugins/vasaio-qr-code/vasaio-qr-code-encoder/jscolor/jscolor.js"></script>
	
	<script type="text/javascript" src="'.get_bloginfo('siteurl').'/wp-content/plugins/vasaio-qr-code/tabber/tabber-minimized.js"></script>
	<link rel="stylesheet" href="'.get_bloginfo('siteurl').'/wp-content/plugins/vasaio-qr-code/tabber/tabber.css" TYPE="text/css" MEDIA="screen">
<script type="text/javascript">

/* Optional: Temporarily hide the "tabber" class so it does not "flash"
   on the page as plain HTML. After tabber runs, the class is changed
   to "tabberlive" and it will appear. */

document.write(\'<style type="text/css">.tabber{display:none;}<\/style>\');
</script>
	';
}

add_action('admin_head', 'vasaio_qr_code_style_for_back_end');

//----------------------------------------------------------------------------------------------

function vasaio_qr_code_menu() {
  add_options_page(
    'Vasaio QR Code - ' . __('Settings', VQRC_TEXTDOMAIN), // page title
    'Vasaio QR Code', // submenu title
    'manage_options', // access/capability
    __FILE__, // file
    'admin_vasaio_qr_options' // function
  );
}

add_action('admin_menu', 'vasaio_qr_code_menu');

//----------------------------------------------------------------------------------------------

function vasaio_qr_code_shortcode( $atts ) {
	extract( 
	  shortcode_atts( 
		array(
			's' => get_option('vasaio_qr_size'),
			'x' => get_option('vasaio_qr_correction'),
			't' => get_option('vasaio_qr_filetype'),
			'b' => get_option('vasaio_qr_border'),
			'c' => get_option('vasaio_qr_color'),
			'bg' => get_option('vasaio_qr_bg_color'),
			'o' => get_option('vasaio_qr_logo'),
			'p' => get_option('vasaio_qr_percent'),
			'a' => get_option('vasaio_qr_adjust'),
			'e' => get_option('vasaio_qr_effect'),
			'm' => get_permalink()
		), 
		$atts 
	  ) 
	);

  	$all_options = "?";
  	$all_options .= "s={$s}";
  	$all_options .= "&x={$x}";
  	$all_options .= "&t={$t}";
  	$all_options .= "&b={$b}";
  	$all_options .= "&c={$c}";
  	$all_options .= "&bg={$bg}";
  	$all_options .= "&o={$o}";
  	$all_options .= "&p={$p}";
  	$all_options .= "&a={$a}";
  	$all_options .= "&e={$e}";
  	$all_options .= "&m={$m}";

	$img_resulted = '<img src="'.get_bloginfo('siteurl').'/wp-content/plugins/vasaio-qr-code/vasaio-qr-code-encoder/vasaio-qr-code-encoder.php'.$all_options.'" class="vasaio-qr-code"/>';
	
	$img_resulted = str_ireplace("&o=&", "", $img_resulted); // eliminate the empty logo 
	
	return $img_resulted;
}

add_shortcode('vasaioqrcode', 'vasaio_qr_code_shortcode');

?>
