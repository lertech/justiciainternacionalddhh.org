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

include_once("lib/phpqrcode/qrlib.php");

$plugin_dir = path_join(WP_PLUGIN_DIR, plugin_dir_path(__FILE__));
$plugin_url = path_join(WP_PLUGIN_URL, basename( dirname( __FILE__) ));
$uploads = wp_upload_dir();

if(!function_exists('foldersize'))
{    
function foldersize($path) {
    $total_size = 0;
    $files = scandir($path);
    $cleanPath = rtrim($path, '/'). '/';

    foreach($files as $t) {
        if ($t<>"." && $t<>"..") {
            $currentFile = $cleanPath . $t;
            if (is_dir($currentFile)) {
                $size = foldersize($currentFile);
                $total_size += $size;
            }
            else {
                $size = filesize($currentFile);
                $total_size += $size;
            }
        }   
    }

    return $total_size;
}
}

if(!function_exists('format_size'))
{  
function format_size($size) {
    $units = explode(' ', 'B KB MB GB TB PB');

    $mod = 1024;

    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }

    $endIndex = strpos($size, ".")+3;

    return substr( $size, 0, $endIndex).' '.$units[$i];
}

}


if($css == "classic") echo '<link type="text/css" rel="stylesheet" href="' . $plugin_url . '/css/shortcode.css" />';

if($mode == "auto") $data = uniqid(true);

if($src == "google") {

	
	
	//get url google qr
	$url = 'http://chart.apis.google.com/chart?cht=qr&chs='.$width.'x'.$height.'&chl='.$data.'&chld='.$err.'&choe='.$enc.'|0';
	//print qr	
	if ($css == "none") echo  '<span class="qr-code-"'.$css.'>'; else echo '<span class="qr-code">'; echo '<img src="'.$url.'"/>';
	if($info == "yes") {	
		echo '<span class="qr-data"><b>';
		_e('Encoding:','qrmaster');
		echo '</b> '.$enc.' | <b>';
		_e('Error:','qrmaster');
		echo '</b> '.$err.' | <a href="'.$url.'">';
		_e('Link','qrmaster');
		echo '</a></span></span>';
	}
	//echo '<div class="clear"></div></div></br>';
} else {

	$cache_upload_dir = $uploads['basedir']."/qrmaster/cache/";
	$cache_upload_url = $uploads['baseurl']."/qrmaster/cache/";

	if (!is_dir($cache_upload_dir)) {
	    wp_mkdir_p($cache_upload_dir);
	}
	//echo $cache_upload_dir;

	//CACHE REMOVE
	$folder_size = foldersize($cache_upload_dir);
	//echo $folder_size;
	if (($folder_size/pow(1024, 2)) > 10) { //up than 10 mb
                $files = glob($cache_upload_dir.'*'); // get all file names
		foreach($files as $file){ // iterate files
			  if(is_file($file)) unlink($file); // delete file
		}
		//echo "borrat!";
	}

	//echo format_size(foldersize($plugin_dir));



	//echo $err.$size;

	

	$backColor = hexdec(str_replace('#', '0x', $bg));
	$foreColor = hexdec(str_replace('#', '0x', $fg));

	//var_dump(hexdec('0xFF00FF'));

	$num_files = count(glob($cache_upload_dir .'*.png'));
	QRcode::png($data, $cache_upload_dir .'qrmcode-'.$num_files.'.png', $err, $size, 2, false, $backColor, $foreColor);
	//QRcode::png($data, $cache_upload_dir .'qrmcode-'.$num_files.'.png', $err, $size, 2);

	//QRcode::svg($data, $cache_upload_dir .'qrmcode-'.$num_files.'.svg', "L", 4, 4, false, $backColor, $foreColor);

	//get url php qr
	$url = $cache_upload_url .'qrmcode-'.$num_files.'.png';
	//print qr	
	if ($css == "none") echo  '<span class="qr-code-"'.$css.'>'; else echo '<span class="qr-code">'; echo '<img src="'.$url.'"/>';
	if($info == "yes") {	
		echo '<span class="qr-data"><b>';
		_e('Error:','qrmaster');
		echo '</b> '.$err.' | <a href="'.$url.'">';
		_e('Link','qrmaster');
		echo '</a></span></span>';
	}

}

    


    
     
    
    



?>
