<?php
/*
 * VASAIO QR Code Functions
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

//------------------------------------------------------------------

function lumdiff($R1,$G1,$B1,$R2,$G2,$B2){
//
// This function return the luminosity difference between two colors.
// The colors are given by RGB separated decimal code.
//
    $L1 = 0.2126 * pow($R1/255, 2.2) +
          0.7152 * pow($G1/255, 2.2) +
          0.0722 * pow($B1/255, 2.2);
 
    $L2 = 0.2126 * pow($R2/255, 2.2) +
          0.7152 * pow($G2/255, 2.2) +
          0.0722 * pow($B2/255, 2.2);
 
    if($L1 > $L2){
        return ($L1+0.05) / ($L2+0.05);
    }else{
        return ($L2+0.05) / ($L1+0.05);
    }
}

//------------------------------------------------------------------

function color_inverse($color){
//
// This function return the opposite color code.
// The input color is giving by RGB hex code, all in one without #.
//
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '0000FF'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = 255 - hexdec(substr($color,(2*$x),2));
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
    return $rgb;
}

//------------------------------------------------------------------

function get_random_color() {
//
// This function return one random color(hex code).
//
	return dechex(rand(0,255)).dechex(rand(0,255)).dechex(rand(0,255));
}

//------------------------------------------------------------------

function get_the_contrast($c1, $c2) {
//
// This function return the luminosity difference between two colors.
// The colors are given by RGB hex code(all in one, without #).
//
	return (lumdiff(hexdec(substr($c1,0,2)),
		hexdec(substr($c1,2,2)),hexdec(substr($c1,4,2)),
		hexdec(substr($c2,0,2)),hexdec(substr($c2,2,2)),
		hexdec(substr($c2,4,2))));
}

//------------------------------------------------------------------

function get_the_best_color($color) {
//
// This function return the best color with the best contrast between 
// $color parameter and other searched color.
// The input color is giving by RGB hex code(all in one, without #).
//
	$contrast = 0;
	$the_best_color = color_inverse($color);
	
	//
	// Search through 100 random colors and
	// select the color with the highest contrast
	//
	for ( $k = 0; $k < 100; $k++ ) {
		$current_color = get_random_color();
		if ( get_the_contrast($color,$current_color) > $contrast ) {
			$contrast = get_the_contrast($color,$current_color);
			$the_best_color = $current_color;
		}	
	}
	
	//
	// Verify if the white color has greater contrast
	//
	$current_color = "FFFFFF"; // white
	if ( get_the_contrast($color,$current_color) > $contrast ) {
		$contrast = get_the_contrast($color,$current_color);
		$the_best_color = $current_color;
	}

	//
	// Verify if the black color has greater contrast
	//
	$current_color = "000000"; // black
	if ( get_the_contrast($color,$current_color) > $contrast ) {
		$contrast = get_the_contrast($color,$current_color);
		$the_best_color = $current_color;
	}
	
	return $the_best_color;
}

//------------------------------------------------------------------

function get_random_color_with_contrast($bg_color, $fg_color, $contrast) {
//
// This function return random color with the contrast
// greater then $contrast parameter.
// The input colors is giving by RGB hex code(all in one, without #).
//
	$the_random_color = get_random_color();
	$current_contrast = get_the_contrast($bg_color, $the_random_color);
	$k = 0;
	while ( ($current_contrast < $contrast) && ($k < 100) ) {
		$the_random_color = get_random_color();
		$current_contrast = get_the_contrast($bg_color, $the_random_color);
		$k++;
	}
	
	if ( $k == 100 ) $the_random_color = $fg_color;
	
	return $the_random_color;
}

//------------------------------------------------------------------



?>