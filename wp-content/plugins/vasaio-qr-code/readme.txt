=== Vasaio QR Code ===
Contributors: olarmarius
Donate link: http://olarmarius.tk/
Tags: vasaio, qr code, generator, standalone, permalink, shortcode, standalone-qr-code, colored-qr-code, customized-qr-code, qr-code logo, automatic, custom-qr-code, custom, olar, widget
Requires at least: 3.2.1
Tested up to: 3.5
Stable tag: 1.2.5
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Generate standalone QR codes, colored and customized with logo inside.


== Description ==

This plugin will insert standalone QR code with permalink or another content.

= Coming soon features =
Calendar event, vCard, MECARD, Email, Geo location, Phone number and Wifi network.

= Usage =
Just put `[vasaioqrcode]` shortcode into you content page, and you have one QR code customized in what color you want, with a logo inside of it. The content of the QR code will be the permalink of the current page. If you want to change the content of the QR code just use the parameter 'm' like that: `[vasaioqrcode m="new content"]`.

You can also use the `widget` of the plugin. The settings from `Vasaio QR Code` settings page will be the default settings for new `widget`, and the settings from widget will be individual for every widget you use.

The uniqueness of this plugin stand in three things: standalone QR codes, colored QR codes and customized QR codes with logo inside.

= Standalone QR code =
The plugin is not using any other application to generate the QR code.

= Colored QR code =
The QR code can be generated in any other peer of colors, not just black and white. The principle is simple: the only think that is metter is the contrast between colors. You can choose another color (insted of black) for the code and the plugin will get automaticaly the inverse color of "the main color" you choose => the contrast resulted is the same between balck and white (the maximum contrast).

= Customized QR code =
You can add any logo you want direct into your QR code. This is very important if you want to have customized QR codes.

= Available interface languages: =
1. English (default language)<br />
2. Romanian<br />

= FEEDBACK =
<a href="http://wordpress.org/support/plugin/vasaio-qr-code" target="_blank">Howdy, if you like or don`t like my plugin give me your FEEDBACK! Thanks!</a>

== Installation ==

= Installation =
1. Upload `vasaio-qr-code.zip` to the `/wp-content/plugins/` directory;
2. Extract the `vasaio-qr-code.zip` archive into the `/wp-content/plugins/` directory;
3. Activate the plugin through the 'Plugins' menu in WordPress.

= Usage =
1. Customize your plugin settings into the `Settings->Vasaio QR Code` settings page;
2. Place `[vasaioqrcode]` shortcode in your content page or user Vasaio QR Code Widget.


== Frequently asked questions ==

= Why should I use this plugin? =

If you want to create an automatic QR code to connect the site with the mobile devices (if the site has also a mobile theme), or you just want to create independently and customized QR codes, you can use this plugin very easy.

= Can I customize the CSS for resulted QR Code? =

YES, you can!
You must add the class `vasaio-qr-code` to the `style.css` of the theme and put your custom CSS code there.
Ex:
`
.vasaio-qr-code {
  float: left;
}
`

= How to use direct in PHP code? =

To use this plugin direct into PHP code use:

`<?php echo do_shortcode('[vasaioqrcode s="600" x="q" t="gif" b="3" c="000000" p="0" m="hahaha" ]'); ?>`

= If I work offline on localhost without Internet connection, the plugin will still work? =

YES! The Vasaio QR Code Plugin will work offline because is not using any other application to generate the QR codes. It will generate the QR codes even on localhost.

= How can I customize my QR code inside of shortcode [vasaioqrcode]? =

You can customize the QR code using this explanation of the shortcode parameters.

*	m=message -> data to encode (default=permalink)
*	s=side -> dimension of image in pixels (64, ... 256=default, ... 3000)
*	x=correction -> error correction level (L=7%(default), M=15%, Q=25%, H=30%) - case insensitive
*	t=filetype -> file type of image (PNG=default, JPEG, GIF) - case insensitive
*	b=border -> number of squares for qr code white border (2, 3, 4=default, ... 10)
*	c=color -> hex code of the main color 
*	o=logo -> filename of logo image, if you want to appear into the QR code (default=null)
*	p=percent -> percent of logo image, if you want to appear into the QR code (default=7)
*	a=adjust -> automatic adjust the logo width & height to match with squares (default=1)

= Can you be more specific with some concrete examples? =

I can provide you some examples and you can also check the 'Screenshots' section.

1. `[vasaioqrcode m="http://google.com/"]`
2. `[vasaioqrcode s="100" e="1"]`
3. `[vasaioqrcode x="m"]`
4. `[vasaioqrcode t="gif"]`
5. `[vasaioqrcode b="2"]`
6. `[vasaioqrcode c="000000"]`
7. `[vasaioqrcode x="L" s="512" c="f0f0f0" o="http://www.google.com/homepage/images/google_favicon_64.png"]`
8. `[vasaioqrcode p="0"]`
9. `[vasaioqrcode a="0" s="512"]`
10. `[vasaioqrcode s="512"]`

= Ok, now is for free! When will be with payment? =

Never, it will be always under GPL license.

== Screenshots ==

1. Vasaio QR Code - Settings

2. Vasaio QR Code - Documentation

3. Vasaio QR Code Widget

4. [vasaioqrcode m="http://google.com/"]

5. [vasaioqrcode s="100"]

6. [vasaioqrcode x="m" c="FFFF00" bg="333333" e="1"]

7. [vasaioqrcode t="gif"]

8. [vasaioqrcode b="2"]

9. [vasaioqrcode c="000000"]

10. [vasaioqrcode x="L" s="512" c="f0f0f0" o="http://2.bp.blogspot.com/_oshGJSerQc0/Sw7PNtKnrOI/AAAAAAAABog/EHfxIyY_c48/s1600/google_wave_logo.jpg"]

11. [vasaioqrcode p="0"]

12. [vasaioqrcode a="0" s="512"]

13. [vasaioqrcode s="512"]


== Changelog ==

= 1.2.5 =
* Add background color option.
* Add special color effect.
* Add textarea with shortcode resulted.

= 1.2.4 =
* Correct some core error.

= 1.2.3 =
* Correct the HTML special chars showing error.

= 1.2.2 =
* Correct the error of image generation.

= 1.2.1 =
* Correct some error.

= 1.2 =
* Add one widget.
* Add documentation to the settings page.

= 1.1 =
* The main language of plugin interface was changed into english.
* The plugin was translated into romanian.

= 1.0 =
* The start version.


== Upgrade notice ==

= 1.2.5 =
Add background color option.
Add special color effect.
Add textarea with shortcode resulted.

= 1.2.4 =
Correct some core error.

= 1.2.3 =
Correct the HTML special chars showing error.

= 1.2.2 =
Correct the error of image generation.

= 1.2.1 =
Correct some error.

= 1.2 =
This new version comes with a new widget and some documentation to the settings page.

= 1.1 =
The main language of plugin interface was changed into english and the old interface language (romanian) was put into translation sistem.

= 1.0 =
The start version.


== Thanks to the following programmers: ==
<br />
= PHP QR Code encoder =
(<a href="https://sourceforge.net/projects/phpqrcode/" target="_blank" title="https://sourceforge.net/projects/phpqrcode/">https://sourceforge.net/projects/phpqrcode/</a>)<br />
<a href="http://www.dzienia.pl/" target="_blank" title="http://www.dzienia.pl/">Dominik Dzienia</a><br />
<a href="http://fukuchi.org/" target="_blank" title="http://fukuchi.org/">Kentaro Fukuchi</a> <br />
<a href="http://www.ka9q.net/" target="_blank" title="http://www.ka9q.net/">Phil Karn, KA9Q</a><br />

= Resizing images with PHP =
(<a href="http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php" target="_blank" title="http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php">http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php</a>)<br />
Simon Jarvis <br />

= PHP Color inverse =
(<a href="http://www.jonasjohn.de/snippets/php/color-inverse.htm" target="_blank" title="http://www.jonasjohn.de/snippets/php/color-inverse.htm">http://www.jonasjohn.de/snippets/php/color-inverse.htm</a>)<br />
<a href="http://www.jonasjohn.de/" target="_blank" title="http://www.jonasjohn.de/">Jonas John</a><br />

= jscolor, JavaScript Color Picker =
(<a href="http://jscolor.com" target="_blank" title="http://jscolor.com">http://jscolor.com</a>)<br />
<a href="http://odvarko.cz" target="_blank" title="http://odvarko.cz">Jan Odvarko</a><br />

= JavaScript tabifier =
(<a href="http://www.barelyfitz.com/projects/tabber/" target="_blank" title="http://www.barelyfitz.com/projects/tabber/">http://www.barelyfitz.com/projects/tabber/</a>)<br />
<a href="http://www.barelyfitz.com/" target="_blank" title="http://www.barelyfitz.com/">Patrick Fitzgerald</a><br />
