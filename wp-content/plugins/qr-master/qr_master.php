<?php
/*
Plugin Name: QR Master
Description: Generation shortcodes to include QR codes to posts and pages
Author: Roger Pàmies
Author URI: http://studi7.com/
Version: 1.0.5
License: GPLv2 or later
Plugin URI: http://studi7.com/codi/plugin-wordpress-qr-master/
*/

/*  Copyright 2012  Roger Pàmies  (email : info@studi7.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function qr_master_add_management_page(  ) {
  if ( function_exists('add_management_page') ) {
    $page = add_management_page( 'QR Master', 'QR Master', 'manage_options', 'qr_master', 'qr_master_admin' );
    add_action("admin_print_scripts-$page", 'qr_master_scripts');
  }
}

function qr_master_admin(  ) {
  
  include_once('qr_master_admin.php');
}

function qr_master_gen(  ) {
  $srcQR = isset($_POST['srcQR'])?$_POST['srcQR']:null;
if ($srcQR == 'google') {
  $valueQR = isset($_POST['valueQR'])?$_POST['valueQR']:null;
  $widthQR = isset($_POST['widthQR'])?$_POST['widthQR']:null;
  $heightQR = isset($_POST['heightQR'])?$_POST['heightQR']:null;
  $encQR = isset($_POST['encQR'])?$_POST['encQR']:null;
  $autoQR = isset($_POST['autoQR'])?$_POST['autoQR']:null;
  $errQR = isset($_POST['errQR'])?$_POST['errQR']:null;
  $infoQR = isset($_POST['infoQR'])?$_POST['infoQR']:null;
  $cssQR = isset($_POST['cssQR'])?$_POST['cssQR']:null;
} else { //phpqrcode
  $valueQR = isset($_POST['valueQR'])?$_POST['valueQR']:null;
  $sizeQR = isset($_POST['sizeQR'])?$_POST['sizeQR']:null;
  $autoQR = isset($_POST['autoQR'])?$_POST['autoQR']:null;
  $errQR = isset($_POST['errQR'])?$_POST['errQR']:null;
  $infoQR = isset($_POST['infoQR'])?$_POST['infoQR']:null;
  $cssQR = isset($_POST['cssQR'])?$_POST['cssQR']:null;
  $fgQR = isset($_POST['fgColor'])?$_POST['fgColor']:null;
  $bgQR = isset($_POST['bgColor'])?$_POST['bgColor']:null;
}
  

  include_once('qr_shortcode_view.php');
  exit();
}

function qr_master_scripts(  ) {
  wp_enqueue_script( "qrmaster", path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )."/qr_master.js"), array( 'jquery' ) );
//wp_enqueue_script( "qrmaster", path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )."/my-script.js"), array( 'jquery' ) );

  wp_enqueue_style( 'wp-jquery-ui', plugins_url( 'css/jquery-ui.css', __FILE__ ), false );
  wp_enqueue_script( 'jquery-ui-tabs' );

  wp_enqueue_style( 'wp-color-picker' );
  wp_enqueue_script(
            'iris',
            admin_url( 'js/iris.min.js' ),
            array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
            false,
            1
        );
}

//shortcode
function get_qrcode($atts) 
{ 
	// atributes (user)
	extract(shortcode_atts(array('data' => 'data'), $atts));
	extract(shortcode_atts(array('width' => 'width'), $atts));
	extract(shortcode_atts(array('height' => 'height'), $atts));
	extract(shortcode_atts(array('enc' => 'UTF-8'), $atts));
	extract(shortcode_atts(array('err' => 'L'), $atts));
	extract(shortcode_atts(array('mode' => 'static'), $atts)); //set static by default if not specify mode auto
	extract(shortcode_atts(array('src' => 'google'), $atts)); //set google api by default
	extract(shortcode_atts(array('info' => 'yes'), $atts));
	extract(shortcode_atts(array('css' => 'classic'), $atts));
	extract(shortcode_atts(array('size' => '4'), $atts));
	extract(shortcode_atts(array('fg' => '#000000'), $atts));
	extract(shortcode_atts(array('bg' => '#FFFFFF'), $atts));  

	ob_start();
     	include('get_qrcode.php');
     	$output = ob_get_clean();
	//print $output; // debug
	return $output;	

	
}

/*add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}*/

function load_plugin_languages()
{
	load_plugin_textdomain('qrmaster', false, dirname(plugin_basename(__FILE__)).'/languages/');
}

add_action('plugins_loaded', 'load_plugin_languages');
add_action('admin_menu', 'qr_master_add_management_page');
add_action('wp_ajax_qr_master_gen', 'qr_master_gen' );
add_shortcode('qrcode', 'get_qrcode');
