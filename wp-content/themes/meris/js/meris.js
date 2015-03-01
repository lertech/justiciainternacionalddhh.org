 jQuery(document).ready(function(){
    jQuery("form.contact-form").submit(function(){
	var Name    = jQuery(this).find("input#contact-name").val();
	var Email   = jQuery(this).find("input#contact-email").val();
	var Message = jQuery(this).find("textarea#contact-msg").val();
	var     obj = jQuery(this);
    jQuery('.fa-spinner').remove();
	jQuery(this).find("#loading").append('<i class="fa fa-spinner fa-2 fa-spin"></i>');
	
	 jQuery.ajax({
				 type:"POST",
				 dataType:"json",
				 url:meris_params.ajaxurl,
				 data:"contact-name="+Name+"&contact-email="+Email+"&contact-msg="+Message+"&action=meris_contact",
				 success:function(data){
					 if(data.error==0){
						   obj.find("#loading").html(data.msg);	
						  }
				obj.find('.fa-spinner').remove();
				obj[0].reset();
				return false;
				},
				error:function(){
					obj.find("#loading").html("Error.");
					obj.find('.fa-spinner').remove();
					return false;
					}});
	 return false;
	 });
				
	//
	jQuery(".slogan-wrapper").parents(".col-md-12").css({"padding":0});
	//
	
			jQuery(".site-nav-toggle").click(function(){
				jQuery(".site-nav").toggle();
			});
	
			jQuery(".site-search-toggle").click(function(){
				jQuery(".search-form").toggle();
			
		});
			
/* ------------------------------------------------------------------------ */
/*  sticky header             	  								  	    */
/* ------------------------------------------------------------------------ */
	 // sticky header resizing control
	jQuery(window).on('resize', function() {
	
	
	  if (jQuery(".site-nav").length) {
	  if (jQuery(window).width() > 919) {
	  jQuery(".site-nav").show();
	  } else {
	  jQuery(".site-nav").hide();
	  }
	  }
	  
		if(jQuery(".sticky-header").length ) {
			if(jQuery(window).width() < 765) {
				jQuery('body.admin-bar header.sticky-header').css('top', '46px');
			} else {
				jQuery('body.admin-bar header.sticky-header').css('top', '32px');
			}
		}
	});
	
	jQuery( window ).scroll(function() {
	if( jQuery( 'header.sticky-header' ).length ) {
		var scrollTop    = jQuery(window).scrollTop();
		var headerHeight = jQuery( 'header.sticky-header' ).height();
	if(jQuery(".slider-above-header").length){
			headerHeight = headerHeight + jQuery(".slider-above-header").height();
			}
	  if(jQuery("body.admin-bar").length){
		if(jQuery(window).width() < 765) {
				headerHeight = headerHeight+46;
				jQuery('body.admin-bar header.sticky-header').css('top', '46px');
			} else {
				headerHeight = headerHeight+23;
				jQuery('body.admin-bar header.sticky-header').css('top', '32px');
			}
			
	  }
	  else{
		  jQuery('body header.sticky-header').css('top', '0');
		  }
	  
	  if(scrollTop>=headerHeight){
		  jQuery( 'header.sticky-header' ).show();
		  }else{
		  jQuery( 'header.sticky-header' ).hide();
			  }
		
	   }
	});
	
 });
 
 
 
 if(typeof meris_js_var !== 'undefined' && typeof meris_js_var.global_color !== 'undefined'){
 less.modifyVars({
        '@color-main': meris_js_var.global_color
    });
   }