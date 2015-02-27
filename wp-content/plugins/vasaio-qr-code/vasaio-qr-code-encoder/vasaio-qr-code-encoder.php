<?php
/*
 * VASAIO QR Code Encoder
 *
 * Web: http://qr-gen.tk/
 *
 * PHP QR Code is distributed under LGPL 3 or later
 * Copyright (C) 2010-2013 Marius-Alex OLAR <me at olarmarius dot tk>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 */
 
/*
 * Version: 1.2.5
 */

include_once ( "phpqrcode.php" );
include_once ( "functions.php" );

//----------------------------------------------------------------------------------------------
//  USE OF VASAIO QR CODE ENCODER
//----------------------------------------------------------------------------------------------
//  USE:
//   	vasaio-qr-code-encoder.php?m=message&s=side&x=correction&t=filetype&b=border&d=download
//  RETURN:
//  	This script return the image(PNG, JPG or GIF) of QR code.
//  WHERE:
//		m=message	->	data to encode (default=http://qr-gen.tk)
//		s=side		->	dimension of image in pixels (64, ... 256=default, ... 3000)
//		x=correction ->	error correction level (L=7%(default), M=15%, Q=25%, H=30%) - case insensitive
//		t=filetype	->	file type of image (PNG=default, JPEG, GIF) - case insensitive
//		b=border	->	number of squares for qr code white border (2, 3, 4=default, ... 10)
//		d=download	->	if you just want to download the file, set this param to 1 (1 / 0=default)
//		c=color		->	hex code of the main color (default=black)
//		bg=color	->	hex code of the background color (default=white)
//		o=logo		->	filename of logo image, if you want to appear into the QR code (default=null)
//		a=adjust	->	automatic adjust the logo width & height to match with squares (default=1)
//
// EX: vasaio-qr-code-encoder/vasaio-qr-code-encoder.php?m=http://qr-gen.tk&s=400&x=M&t=gif&b=2
//----------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------
//  DEFAULT QR CODE PARAMETERS
//----------------------------------------------------------------------------------------------
$qr_code_default_message = 'http://qr-gen.tk';
$qr_code_default_level = 'L'; // Error Correction Lever (L=Allows recovery of up to 7% data loss, M=15%, Q=25%, H=30%)
$qr_code_default_filetype = 'PNG'; // PNG, JPEG, GIF
$qr_code_default_width = 256; // pixels
$qr_code_min_width = 64; 
$qr_code_max_width = 3000; 
$qr_code_default_border = 4; // squares
$qr_code_min_border = 2; 
$qr_code_max_border = 10; 
$qr_code_default_download = 0; 
$qr_code_default_color = "000000"; // black color
$qr_code_default_bg_color = "FFFFFF"; // the best contrasted color
$qr_code_default_adjust = "1"; 
$qr_code_default_effect = "0"; 
//----------------------------------------------------------------------------------------------

//
// The MAIN part of script
//

$qr_code_width = isset($_GET['s'])?$_GET['s']:$qr_code_default_width;
if (!(is_numeric($qr_code_width))) $qr_width = $qr_code_default_width;
if ($qr_code_width < $qr_code_min_width) $qr_code_width = $qr_code_min_width;
if ($qr_code_width > $qr_code_max_width) $qr_code_width = $qr_code_max_width;
//if ($qr_code_width == 300) $qr_code_width++; // some error correction ???
$qr_code_height = $qr_code_width;
unset($_GET['s']);

$qr_code_border = isset($_GET['b'])?$_GET['b']:$qr_code_default_border;
if (!(is_numeric($qr_code_border))) $qr_code_border = $qr_code_default_border;
if ($qr_code_border < $qr_code_min_border) $qr_code_border = $qr_code_min_border;
if ($qr_code_border > $qr_code_max_border) $qr_code_border = $qr_code_max_border;
unset($_GET['b']);

$qr_code_download = isset($_GET['d'])?$_GET['d']:$qr_code_default_download;
unset($_GET['d']);

$qr_code_effect = isset($_GET['e'])?$_GET['e']:$qr_code_default_effect;
unset($_GET['e']);

// create a blank image and add some text
$image = imagecreatetruecolor($qr_code_width, $qr_code_height);

// create qr code colors
$qr_code_color = isset($_GET['c'])?$_GET['c']:$qr_code_default_color;
$qr_code_bg_color = isset($_GET['bg'])?$_GET['bg']:get_the_best_color($qr_code_color);
if ( $qr_code_bg_color == "" ) $qr_code_bg_color = get_the_best_color($qr_code_color);

$aux_color = $qr_code_color;
$redhex    = substr($aux_color,0,2);	$var_r = hexdec($redhex);
$greenhex  = substr($aux_color,2,2);	$var_g = hexdec($greenhex);
$bluehex   = substr($aux_color,4,2);	$var_b = hexdec($bluehex);
$qr_main_color = imagecolorallocate($image, $var_r, $var_g, $var_b);

$aux_color = $qr_code_bg_color;
$redhex    = substr($aux_color,0,2);	$var_r = hexdec($redhex);
$greenhex  = substr($aux_color,2,2);	$var_g = hexdec($greenhex);
$bluehex   = substr($aux_color,4,2);	$var_b = hexdec($bluehex);
$qr_background_color = imagecolorallocate($image, $var_r, $var_g, $var_b);

//
// draw the white background of QR code
//
imagefilledrectangle($image, 0, 0, $qr_code_width, $qr_code_height, $qr_background_color);

//QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
$qr_code_message = isset($_GET['m'])?$_GET['m']:$qr_code_default_message;
$qr_code_message = urldecode( $qr_code_message );
$qr_code_message = htmlspecialchars_decode( $qr_code_message );
unset($_GET['m']);

$qr_code_level = isset($_GET['x'])?$_GET['x']:$qr_code_default_level;
$qr_code_level = strtoupper($qr_code_level);
unset($_GET['x']);

//
// get the QR code bytes
//
$qr_code_bit_matrix = QRcode::text($qr_code_message, false, $qr_code_level);

//$qr_code_bit_matrix = file_get_contents('qr.txt');
//$qr_code_bit_matrix = explode("\n", $qr_code_bit_matrix); // use "\n" for Linux OS \x0D\x0A

//print_r($qr_code_bit_matrix);
$qr_code_count = count($qr_code_bit_matrix); // the number of rows (equal with squares)
$qr_code_length = strlen($qr_code_bit_matrix[0]); // the number of squares

if ( !($qr_code_count == $qr_code_length) ) { echo'Fatal error !!!'; exit(1); }

$qr_square_side = (int)$qr_code_width/($qr_code_count+2*$qr_code_border); // pixels

//
// draw the black squares of QR code
//
for ($qr=0; $qr<$qr_code_count; $qr++) {
  for ($k=0; $k<$qr_code_length; $k++) {
    if (substr($qr_code_bit_matrix[$qr],$k,1)=='1') { // draw only the $qr_main_color squares
		if ( $qr_code_effect == '1' ) {
			$qr_main_color_hex = get_random_color_with_contrast($qr_code_bg_color, $qr_code_color, 5);
			$redhex    = substr($qr_main_color_hex,0,2);	$var_r = hexdec($redhex);
			$greenhex  = substr($qr_main_color_hex,2,2);	$var_g = hexdec($greenhex);
			$bluehex   = substr($qr_main_color_hex,4,2);	$var_b = hexdec($bluehex);
			$qr_main_color = imagecolorallocate($image, $var_r, $var_g, $var_b);
		}
		
	  imagefilledrectangle($image, 
	    round($qr_code_border*$qr_square_side + $k*$qr_square_side) +1, 
		round($qr_code_border*$qr_square_side + $qr*$qr_square_side) +1, 
		round($qr_code_border*$qr_square_side + $k*$qr_square_side+$qr_square_side), 
		round($qr_code_border*$qr_square_side + $qr*$qr_square_side+$qr_square_side), 
		$qr_main_color);
	}
  }
}

$imagetype = isset($_GET['imagetype'])?$_GET['imagetype']:IMG_PNG;

$qr_code_filetype = isset($_GET['t'])?$_GET['t']:$qr_code_default_filetype;
$qr_code_filetype = strtolower($qr_code_filetype);
if ($qr_code_filetype == 'png') $imagetype = IMG_PNG;
if ( ($qr_code_filetype == 'jpeg') || ($qr_code_filetype == 'jpg') ) $imagetype = IMG_JPG;
if ($qr_code_filetype == 'gif') $imagetype = IMG_GIF;
unset($_GET['t']);

//
//  If is set the logo, then insert it into the QR code image
//
if (isset($_GET['o']))
{
	include 'simpleimage.php';
	
	$qr_logo = new SimpleImage();
	$qr_logo->load($_GET['o']);

	$side = $qr_code_width - (2*$qr_code_border*$qr_square_side); // fara bordura alba
	$percent = isset($_GET['p'])?$_GET['p']:-1;
	
	//
	//  The highest logo area percent is limited to 30%
	//
	if ($percent > 30) $percent = 30;
	
	//
	//  Resize the logo area to fit into the given percent
	//
	$width	 = $qr_logo->getWidth();
	$height	 = $qr_logo->getHeight();

	if ($height > 0) $ratio = $width / $height; else $ratio = 0;
	$qr_area = $side * $side;
	$qr_area_percent = $qr_area * $percent / 100;
	$logo_area = $width * $height;

	$new_width = $width;
	$new_height = $height;
	while ( $logo_area > $qr_area_percent )
	{
		$new_width--;
		$new_height = $new_width / $ratio;
		$logo_area = $new_width * $new_height;
	}
	$new_width = round ($new_width);
	$new_height = round ($new_height);
	//  ENF OF "Resize the logo area.."
	
	//
	//  Get the logo position
	//
	$logo_x_position = (int)($qr_code_width / 2) - (int)($new_width / 2);
	$logo_y_position = (int)($qr_code_width / 2) - (int)($new_height / 2);

	//
	//  Automatic adjust the new_width & new_height to match with squares
	//
	$auto_adjust = isset($_GET['a']) ? $_GET['a'] : $qr_code_default_adjust;
	if ($auto_adjust == '1')
	{
		$adjust_width = (int)floor($new_width / $qr_square_side);
		$adjust_height = (int)floor($new_height / $qr_square_side);
		
		$new_width = $adjust_width * $qr_square_side +1;
		$new_height = $adjust_height * $qr_square_side +1;
		
		// adjust also the position
		$logo_x_position = ((($qr_code_length - $adjust_width ) / 2) + $qr_code_border) * $qr_square_side +1;
		$logo_y_position = ((($qr_code_length - $adjust_height) / 2) + $qr_code_border) * $qr_square_side +1; 

		$adjust_logo_x_position = (int)floor($logo_x_position / $qr_square_side);
		$adjust_logo_y_position = (int)floor($logo_y_position / $qr_square_side);
		
		$logo_x_position = $adjust_logo_x_position * $qr_square_side + 1;
		$logo_y_position = $adjust_logo_y_position * $qr_square_side + 1;
	}

	$qr_logo->resize($new_width, $new_height);
	//$qr_logo->writeImage($_GET['o']);
 
} // END OF "If is set the logo..."

// L=7%, M=15%, Q=25%, H=30%
// L=3%, M=9%,  Q=12%, H=16%

$qr_code_filename = urlencode($qr_code_message);
$qr_code_filename = $qr_code_filename . '.' . $qr_code_filetype;

//
//  For GIF file type image
//
if ($imagetype == IMG_GIF) { 
	if ($qr_code_download == 1) {
		if (isset($_GET['o'])) 
			imagecopymerge($image, $qr_logo->image, 
				$logo_x_position, $logo_y_position, 0, 0, 
				$qr_logo->getWidth(), $qr_logo->getHeight(), 100);
		imagegif($image, $qr_code_filename);
		header('Content-Disposition: attachment; filename='.$qr_code_filename); 
		readfile($qr_code_filename);
	} else {
		if (isset($_GET['o'])) 
			imagecopymerge($image, $qr_logo->image, 
				$logo_x_position, $logo_y_position, 0, 0, 
				$qr_logo->getWidth(), $qr_logo->getHeight(), 100);
		header('Content-Disposition: filename='.$qr_code_filename); 
		header('Content-Type: image/gif');
		imagegif($image);
	}
}

//
//  For PNG file type image
//
if ($imagetype == IMG_PNG) {
	if ($qr_code_download == 1) {
		if (isset($_GET['o'])) 
			imagecopymerge($image, $qr_logo->image, 
				$logo_x_position, $logo_y_position, 0, 0, 
				$qr_logo->getWidth(), $qr_logo->getHeight(), 100);
		imagepng($image, $qr_code_filename);
		header('Content-Disposition: attachment; filename='.$qr_code_filename); 
		readfile($qr_code_filename);
	} else {
		if (isset($_GET['o'])) 
			imagecopymerge($image, $qr_logo->image, 
				$logo_x_position, $logo_y_position, 0, 0, 
				$qr_logo->getWidth(), $qr_logo->getHeight(), 100);
		header('Content-Disposition: filename='.$qr_code_filename); 
		header('Content-Type: image/png');
		imagepng($image);
	}
}

//
//  For JPG file type image
//
if ($imagetype == IMG_JPG) {
	if ($qr_code_download == 1) {
		if (isset($_GET['o'])) 
			imagecopymerge($image, $qr_logo->image, 
				$logo_x_position, $logo_y_position, 0, 0, 
				$qr_logo->getWidth(), $qr_logo->getHeight(), 100);
		imagejpeg($image, $qr_code_filename);
		header('Content-Disposition: attachment; filename='.$qr_code_filename);
		readfile($qr_code_filename);
	} else {
		if (isset($_GET['o'])) 
			imagecopymerge($image, $qr_logo->image, 
				$logo_x_position, $logo_y_position, 0, 0, 
				$qr_logo->getWidth(), $qr_logo->getHeight(), 100);
		header('Content-Disposition: filename='.$qr_code_filename); 
		header('Content-Type: image/jpeg'); // Set the content type header - in this case image/jpeg
		imagejpeg($image); // imagejpeg($image, null, 70);
	}
}

//
//  Free up memory
//
imagedestroy($image); 
if (isset($_GET['o'])) $qr_logo->destroy();
?>