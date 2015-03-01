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
*/?>

	
	<!--<h2 class="nav-tab-wrapper">
	<a href="?page=qr_master&tab=tab1" class="nav-tab">PHP QR Code</a>
	<a href="#" class="nav-tab nav-tab-active">Google API Charts</a>
	<a href="#" class="nav-tab">Tab #2</a>
	</h2>-->





<?php 
 echo '<link type="text/css" rel="stylesheet" href="' . path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )) . '/css/admin.css" />';
?>
<div class="wrap">

	<div class="header">
		<div class="title">
			<h1><?php _e( 'QR Master','qrmaster'); ?></h1>
			<h2><?php _e( 'Shortcode generator','qrmaster'); ?></h2>
		</div>
		<div class="credits">
			<label><?php _e('Plugin created by ','qrmaster');?><a href="http://studi7.com" target="_blank">Studi7</a></label><br />
			<label><?php _e('Licensed with ','qrmaster');?><a href="http://www.gnu.org/licenses/old-licenses/gpl-2.0.html" target="_blank"><?php _e('GNU General Public License, version 2','qrmaster');?></a></label><br />
			<label><?php _e('If you like this plugin, you can make a donation :) ','qrmaster');?>&nbsp;<a href="https://www.paypal.com/es/cgi-bin/webscr?cmd=_flow&SESSION=N3FBPCkFbss4IquTxeNOxg4Psp_bwV3CUOaj9DCN4PyisiYw8y8kj-GWziS&dispatch=5885d80a13c0db1f8e263663d3faee8d0b7e678a25d883d0fa72c947f193f8fd">PayPal</a></label><br />
		</div>
	</div>

	<div id="tabs">
	<ul>
		<li><a href="#tabs-1"><?php _e( 'PhpQR API','qrmaster'); ?></a></li>
		<li><a href="#tabs-2"><?php _e( 'Google API Charts','qrmaster'); ?></a></li>
		<li><a href="#tabs-3"><?php _e( 'QR code usages','qrmaster'); ?></a></li>
	</ul>
	<div id="tabs-1">
		<form class="phpqrgen" id="phpqrgen">
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<?php echo '<img src="'.path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )) . '/img/phpqrcode.png"'.'"/>'; ?>
					</th>
					<td>
						<a target="_blank" href="http://phpqrcode.sourceforge.net/index.php#home"><?php _e('Php QR Code','qrmaster'); ?></a> | <label><?php _e('This method save generated qr-codes in \'uploads/qrmaster/cache\' folder. The folder will be cleared when exceed 10MB');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('Size image:','qrmaster');?></b></label>
					</th>
					<td>
						<select class="phpsize" id="phpsize">
							<option value="1"><?php _e('1','qrmaster');?></option>
							<option value="2"><?php _e('2','qrmaster');?></option>
							<option value="3"><?php _e('3','qrmaster');?></option>
							<option value="4" selected><?php _e('4','qrmaster');?></option>
							<option value="5"><?php _e('5','qrmaster');?></option>
							<option value="6"><?php _e('6','qrmaster');?></option>
							<option value="7"><?php _e('7','qrmaster');?></option>
							<option value="8"><?php _e('8','qrmaster');?></option>
							<option value="9"><?php _e('9','qrmaster');?></option>
							<option value="10"><?php _e('10','qrmaster');?></option>
						</select><br/>
						<label class="note"><?php _e('4 by default. 40 maximum size.','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('Value:','qrmaster');?></b></label>
					</th>
					<td>
						<input type="checkbox" class="phpauto" id="phpauto" value="1" checked onclick="javascript:AutoPhp()"> <b><?php _e('Automatic mode','qrmaster');?></b><br/>
						<label class="note"><?php _e('Generate a random value of 23 characters based on current time in microseconds. Get random QR code each time to refresh page or post.','qrmaster');?></label><br/><br/>
						<b><?php _e('Manual mode','qrmaster');?></b><br/>
						<textarea cols="80" rows="6" class="phpvalue" id="phpvalue" disabled="true"></textarea><br />
						<!--<input type="text" placeholder="Value" /><br/>-->
						<label class="note"><?php _e('Only set if automatic mode is not checked.','qrmaster');?>&nbsp;</label><!-- <a href="#tabs-3"><?php _e('Usages','qrmaster'); ?></a>-->
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('Code information','qrmaster');?></b></label><br />
					</th>
					<td>
						<input type="checkbox" class="phpinfo" id="phpinfo" checked/><?php _e('Show','qrmaster');?><br />
						<label class="note"><?php _e('Show/hide information below QR code.','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('Foreground color','qrmaster');?></b></label>
					</th>
					<td>
						<input type="text" value="#000000" class="fg-color" id="fg-color" /><br />
						<label class="note"><?php _e('Foreground color of QR code.','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('Background color','qrmaster');?></b></label>
					</th>
					<td>
						<input type="text" value="#FFFFFF" class="bg-color" id="bg-color"/><br />
						<label class="note"><?php _e('Background color of QR code.','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('ECC:','qrmaster');?></b></label>
					</th>
					<td>
						<select class="phperr" id="phperr">
							<option value="L"><?php _e('L (smallest)','qrmaster');?></option>
							<option value="M"><?php _e('M','qrmaster');?></option>
							<option value="Q"><?php _e('Q','qrmaster');?></option>
							<option value="H"><?php _e('H (best)','qrmaster');?></option>
						</select><br /><label class="note"><?php _e('L by default','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('CSS Style','qrmaster');?></b></label>
					</th>
					<td>
						<input type="radio" class="phpcss" id="phpcss" name="phpcss" value="classic" checked/><?php _e('Classic','qrmaster');?>
						<input type="radio" class="phpcss" id="phpcss" name="phpcss" value="none"/><?php _e('None','qrmaster');?><br /><label class="note"><?php _e('Set css style to code QR.','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<a class="button-primary get" href="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php"><?php _e('Get shortcode','qrmaster'); ?></a>
						<a class="button-secondary clear" href="javascript:ResetPhp()"><?php _e('Reset','qrmaster'); ?></a>
					</th>
					<td>
						<div class="shortcode" id="phpshortcode"></div>
						<label class="note"><i><?php _e('Copy the shortcode and paste to page or post','qrmaster'); ?></i></label>
					</td>
				</tr>
			</tbody>
		</table>
		</form>
	</div>
	<div id="tabs-2">
		<form class="qrgenerator">
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<?php echo '<img src="'.path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )) . '/img/developers-logo.png"'.'"/>'; ?>
					</th>
					<td>
						<a target="_blank" href="https://developers.google.com/chart/infographics/docs/qr_codes?hl=ca"><?php _e('Google Chart Tools','qrmaster'); ?></a> &nbsp;<i><?php _e('(Deprecated)');?>
					</td>
				</tr>
				<tr>
					<th>
						<label><?php _e('Width image:','qrmaster');?></label>
					</th>
					<td>
						<input type="text" placeholder="Width" class="width" id="width" value="150" maxlength="4" onkeypress="return isNumberKey(event)"/>
						<br /><label class="note"><?php _e('width x height can not up to 300000 pixels','qrmaster');?></label>	
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('Heigth image:','qrmaster');?></b></label>
					</th>
					<td>
						<input type="text" class="height" id="height" value="150" maxlength="4" onkeypress="return isNumberKey(event)"/><br />
						<label class="note"><?php _e('width x height can not up to 300000 pixels','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('Codification:','qrmaster');?></b></label>
					</th>
					<td>
						<select class="enc" id="enc">
							<option value="UTF-8"><?php _e('UTF-8','qrmaster');?></option>
							<option value="Shift_JIS"><?php _e('Shift_JIS','qrmaster');?></option>
							<option value="ISO-9985-1"><?php _e('ISO-9985-1','qrmaster');?></option>
						</select><br /><label class="note"><?php _e('UTF-8 by default','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('Value:','qrmaster');?></b></label>
					</th>
					<td>
						<input type="checkbox" class="auto" id="auto" value="1" checked onclick="javascript:Auto()"> <b><?php _e('Automatic mode','qrmaster');?></b><br/>
						<label class="note"><?php _e('Generate a random value of 23 characters based on current time in microseconds. Get random QR code each time to refresh page or post.','qrmaster');?></label><br/><br/>
						<b><?php _e('Manual mode','qrmaster');?></b><br/>
						<textarea cols="80" rows="6" class="value" id="value" disabled="true"></textarea><br />
						<!--<input type="text" placeholder="Value" /><br/>-->
						<label class="note"><?php _e('Only set if automatic mode is not checked.','qrmaster');?>&nbsp;</label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('Code information','qrmaster');?></b></label>
					</th>
					<td>
						<input type="checkbox" class="info" id="info" checked/><?php _e('Show','qrmaster');?><br />
						<label class="note"><?php _e('Show/hide information below QR code.','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('Error correction Level:','qrmaster');?></b></label>
					</th>
					<td>
						<select class="err" id="err">
							<option value="L"><?php _e('L (7% data loss)','qrmaster');?></option>
							<option value="M"><?php _e('M (15% data loss)','qrmaster');?></option>
							<option value="Q"><?php _e('Q (25% data loss)','qrmaster');?></option>
							<option value="H"><?php _e('H (30% data loss)','qrmaster');?></option>
						</select><br /><label class="note"><?php _e('L by default','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<label><b><?php _e('CSS Style','qrmaster');?></b></label>
					</th>
					<td>
						<input type="radio" class="css" id="css" name="css" value="classic" checked/><?php _e('Classic','qrmaster');?>
						<input type="radio" class="css" id="css" name="css" value="none"/><?php _e('None','qrmaster');?><br />
						<label class="note"><?php _e('Set css style to code QR.','qrmaster');?></label>
					</td>
				</tr>
				<tr>
					<th>
						<a class="button-primary get" href="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php"><?php _e('Get shortcode','qrmaster'); ?></a>
						<a class="button-secondary clear" href="javascript:Reset()"><?php _e('Reset','qrmaster'); ?></a>
					</th>
					<td>
						<div class="shortcode" id="shortcode"></div><br />
						<label class="note"><i><?php _e('Copy the shortcode and paste to page or post','qrmaster'); ?></i></label>
					</td>
				</tr>
			</tbody>
		</table>
		</form>
	</div>
	<div id="tabs-3">
		<p><?php _e('The QR code is a way of representing data as binary code, a series of letters or musical notes. QR codes only show data in a way that the machine can read. The documentation of the QR Code does not specify what the data mean or indicate how it represents a URL or a phone number or a link to Android Market.','qrmaster');?>
		</p><p><?php _e('Developers of code generators and scanners have agreed on how to representing and interpreting some data, such as: surfing the web, add contact, or initializing a call. Here are some examples:','qrmaster');?>
		</p>
		<h2><?php _e('Links','qrmaster');?></h2>
		<p><a href="http://example.com" title="http://example.com" rel="nofollow">http://example.com</a></p>
		<p><a href="http://example.com?withparameter=a&amp;andother=b" title="http://example.com?withparameter=a&amp;andother=b" rel="nofollow">http://example.com?withparameter=a&amp;andother=b</a></p>
		<p><a href="http://goo.gl/short" title="http://goo.gl/short" rel="nofollow">http://goo.gl/short</a></p>
		<p>market://details?id=my.android.market.full.qualiffied.package.name</p>
		<h2><?php _e('Phone number','qrmaster');?></h2>
		<p>tel:012345678</p>
		<h2><?php _e('E-mail address','qrmaster');?></h2>
		<p><a href="mailto:hello@example.com" title="mailto:hello@example.com" rel="nofollow">mailto:hello@example.com</a></p>
		<p><a href="mailto:hello@example.com?subject=promotion" title="mailto:hello@example.com?subject=promotion" rel="nofollow">mailto:hello@example.com?subject=promotion</a></p>
		<h2><?php _e('Contact card (V-Card)','qrmaster');?></h2>
		<p>
		BEGIN:VCARD<br />
		VERSION:2.1<br />
		N:Jack;Sparrow<br />
		FN:Jack Sparrow<br />
		TITLE:Captain<br />
		TEL;WORK;VOICE:(666) 555-7212<br />
		END:VCARD
	</div>
	</div> <!--end tabs -->


<!--<div class="wrap-tab wrap-4" id="wrap-4">
<h5>Customize CSS style of QR Master codes</h5>
<p>You can create css styles, select css style in form for each shortcode.</p>
<textarea>
.qr-code img {
    border: 1px solid #FFFFFF;
    margin: 0;
    background: #F6F6F6;
    padding: 8px;
    -moz-box-shadow: 2px 2px 5px #CCCCCC;
    -webkit-box-shadow: 2px 2px 5px #CCCCCC;
}
 
.qr-code { 
    display: inline-block;
    margin: 8px;
    text-align:center;}

.qr-data { text-align:center; width:100%; font-size:11px; margin: 4px; display:block; }
</textarea>
<a class="button-secondary clear" href="javascript:ResetCSS()"><?php _e('Reset','qrmaster'); ?></a><br />
Preview style: <a class="button-secondary clear" href="javascript:PreviewCSS()"><?php _e('Preview','qrmaster'); ?></a><br />
CSS file name: <input type="text" class="cssname" id="cssname"/>
<a class="button-primary get" href="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php"><?php _e('Save','qrmaster'); ?></a>
<h5>Saved styles</h5>
llista
<br />

</div>-->


</div> <!-- end wrap -->
<!--PREVIEW-->
<?php /*echo do_shortcode( '[qrcode src="google" mode="auto" width="150" height="150" enc="UTF-8" err="L"]' );*/ ?> 

