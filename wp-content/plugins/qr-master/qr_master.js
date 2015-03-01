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

jQuery(document).ready( function($) {

// Tabs
$('#tabs').tabs();

  $("form.qrgenerator a.get").click( function() {
    
    /* only fetch results once */
    /*$(this).unbind('click').bind('click', function(){return false;});*/
    //alert($('input[name=css]:checked').val());	
    
    $.post($(this).attr("href"), {
        action: "qr_master_gen",
        srcQR: "google",
	valueQR: document.getElementById("value").value,
	widthQR: document.getElementById("width").value,
	heightQR: document.getElementById("height").value,
	encQR: document.getElementById("enc").value,
	autoQR: document.getElementById("auto").checked,
	errQR: document.getElementById("err").value,
	infoQR: document.getElementById("info").checked,
	cssQR: $('input[name=css]:checked').val()
      }, function(data) {
        var container = document.getElementById("shortcode");
	container.innerHTML = data;

      }
    );
    return false;
  });

   $("form.phpqrgen a.get").click( function() {
    
    /* only fetch results once */
    /*$(this).unbind('click').bind('click', function(){return false;});*/
    //alert($('input[name=css]:checked').val());
	

    $.post($(this).attr("href"), {
        action: "qr_master_gen",
        srcQR: "phpqrcode",
	valueQR: document.getElementById("phpvalue").value,
	sizeQR: document.getElementById("phpsize").value,
	autoQR: document.getElementById("phpauto").checked,
	errQR: document.getElementById("phperr").value,
	infoQR: document.getElementById("phpinfo").checked,
	cssQR: $('input[name=phpcss]:checked').val(),
	fgColor: $('.fg-color').val(),
	bgColor: $('.bg-color').val()
      }, function(data) {
        var container = document.getElementById("phpshortcode");
	container.innerHTML = data;

      }
    );
    return false;
  });

 
  

   $('#fg-color').iris({ palettes: true });
   $('#bg-color').iris({ palettes: true });
   $("#bg-color").iris('color', '#ffffff');
   $("#fg-color").iris('color', '#000000');
});

function AutoPhp() {
   var auto = document.getElementById("phpauto");
   if (auto.checked) {
	document.getElementById("phpvalue").disabled = true;
   }
   else {
	document.getElementById("phpvalue").disabled = false;
   }
}

function ResetPhp() {
   document.getElementById("phpvalue").value = '';
        document.getElementById("phpauto").checked = true;
   	document.getElementById("phpvalue").disabled = true;
	var container = document.getElementById("phpshortcode");
   	container.innerHTML = '';
   //reset combos!!!!!
   	document.getElementById("phpsize").selectedIndex = 3;
   	document.getElementById("phperr").selectedIndex = 0;
//alert('me!');
   	//$('#fg-color').iris('color', '#000000'); //$().val("#000000");
   	//$("#bg-color").iris('color', '#ffffff'); //$().val("#000000");
//alert('me!');
}

/*google api charts*/

function Auto() {
   var auto = document.getElementById("auto");
   if (auto.checked) {
	document.getElementById("value").disabled = true;
   }
   else {
	document.getElementById("value").disabled = false;
   }
}

function Reset() {
   document.getElementById("value").value = '';
   document.getElementById("auto").checked = true;
   document.getElementById("value").disabled = true;
   document.getElementById("height").value = '150';
   document.getElementById("width").value = '150';
   var container = document.getElementById("shortcode");
   container.innerHTML = '';
   //reset combos!!!!!
   document.getElementById("enc").selectedIndex = 0;
   document.getElementById("err").selectedIndex = 0;
}
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
    return true;
}
