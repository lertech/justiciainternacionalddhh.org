<?php
/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : info@studi7.com)

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

$auto_mode = $autoQR === 'true'? true: false;

if ($srcQR == 'google') {

	if(($valueQR == null && !$auto_mode) || $widthQR == null || $heightQR == null) _e('<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><label>Width, Height and Value fields are required.</label></div>','qrmaster');
	else {
		$size = $heightQR * $widthQR;
		if($size > 300000 || $size == 0) _e('<label class="error">'.$widthQR.'x'.$heightQR.'='.$size.' is up to 300000 pixels allow or not a valid value.</label>','qrmaster');
		else {
			$code;
			if($auto_mode) $code = '[qrcode src="'.$srcQR.'" mode="auto" width="'.$widthQR.'" height="'.$heightQR.'" enc="'.$encQR.'" err="'.$errQR.'"';
			else $code = '[qrcode src="'.$srcQR.'" data="'.$valueQR.'" width="'.$widthQR.'" height="'.$heightQR.'" enc="'.$encQR.'" err="'.$errQR.'"';
			if($infoQR == 'false') $code = $code.' info="no"';
			if($cssQR != 'classic') $code = $code.' css="'.$cssQR.'"';
			$code = $code.']';
			echo $code;
		}
	}
} else {
	if($valueQR == null && !$auto_mode) _e('<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><label>Value field are required.</label></label>','qrmaster');
	else {
		
		$code;
		if($auto_mode) $code = '[qrcode src="'.$srcQR.'" mode="auto" size="'.$sizeQR.'" err="'.$errQR.'"';
		else $code = '[qrcode src="'.$srcQR.'" data="'.$valueQR.'" size="'.$sizeQR.'" err="'.$errQR.'"';
		if($infoQR == 'false') $code = $code.' info="no"';
		if($cssQR != 'classic') $code = $code.' css="'.$cssQR.'"';
		if($fgQR != '#000000' && $fgQR != '') $code = $code.' fg="'.$fgQR.'"';
		if($bgQR != '#ffffff' && $bgQR != '') $code = $code.' bg="'.$bgQR.'"';
		$code = $code.']';
		echo $code;
		
	}
}
?>



