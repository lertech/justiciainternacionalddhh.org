// JavaScript Document

jQuery(document).ready(function(e) {
	
	//jQuery('.cnss-social-icon').parent
	jQuery('.cnss-social-icon').parents('.col-md-3.margin-bottom-3.share-story.no-padding').addClass('social-box');
});
jQuery(document).ready(function() {
    jQuery("#freemimum-gellery").owlCarousel({
    autoPlay: true,
    items : 4,
    itemsDesktop : [1199,3],
    itemsDesktopSmall : [979,3]
    });
});

jQuery(document).ready(function() {
    jQuery("#sliderhome").owlCarousel({
    autoPlay: true,
    items : 1,
	itemsDesktop : [1199,1],
	itemsDesktopSmall : [979,1],
	itemsMobile : [978,1]
    });
});