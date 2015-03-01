=== QR Master ===
Contributors: studi7
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F4VJKZW7THJ22
Tags: mobile, qr code, shortcode, qr
Requires at least: 3.5.1
Tested up to: 4.1.1
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Generate shortcodes to include colored QR code in page or post.

== Description ==

QR Master generate shortcodes to include QR code in page or post. Get QR codes from Google API Charts and Php QR code. This plugin support two methods to getting QR:

* Value: get same QR whith fixed value
* Automatic: get random QR code for each visit in page or post.

The shortcode form tool include:

* Form with parameters of Google API Charts,
* Form with parameters of Php QR Code API, 
* CSS options and hide code information and credits.
* Foreground and background colours in QR Code (Php QR Code)

All QR codes are generated in live. The Php QR Code API save some data in cache, please read FAQ.

= Available Languages =

* English
* Català
* Español
* Serbian (thanks to Ogi Djuraskovic - [First Site Guide](http://www.firstsiteguide.com/ "firstsiteguide.com"))

= TO-DO =

* Widget, save codes to database, insert shortcode assistant, customize css, value generator, QR-Server API

== Installation ==

1. Upload 'qrmaster' forler to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to 'Tools' -> 'QR Master' and generate shortcode
1. Copy shortcode and paste in your post or page

== Frequently Asked Questions ==

= Size of QR code in Google API Charts not change? =

Yes, change the image of QR code canvas, but not change the QR code size.
Limitations of Google API Charts.

= QR Master save QR codes in disk? =

Yes, with Php QR API each QR code is saved in 'upload/qrmaster/cache'. When size of folder exceed 10MB, will be cleared.

== Screenshots ==

1. Generation QR Shortcode Tool (Php QR Code API)

2. Generation QR Shortcode Tool (Google API Charts)

3. Code QR usages

4. Example of generated QR code

== Changelog ==

= 1.0.5 =
* Include Serbian Language (thanks to Ogi Djuraskovic - [First Site Guide](http://www.firstsiteguide.com/ "firstsiteguide.com"))

= 1.0.4 =
* Colored QR codes with Php QR Code
* New admin styled forms

= 1.0.3 =
* Php QR Code API implmented
* Admin from tool with tabs and new style
* New classic CSS style
* Cache in uploads folder for save temporally QR codes from Php API (clear at 10MB)
* Usages of QR codes and examples in admin tool

= 1.0.2 =
* Option to disable code information and credits
* Set CSS classic or disable CSS style

= 1.0.1 =
* Bug fixed. Shortcode appears in top of content

= 1.0 =
* First version (testing)



