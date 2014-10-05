jQuery(document).ready(function() {					
	jQuery("#modal-upload, #modal-report, .badge-overlay-signin, .badge-overlay-signup-fb").click(function(event) {	    
	    event.stopPropagation();	    
	});
	
	jQuery(document).click(function (e) {
		var elemtent = jQuery(e.target).parents().andSelf();
	    if (!elemtent.hasClass('badge-upload-selector') && !elemtent.hasClass('badge-login-button') 
	    	&& !elemtent.hasClass('badge-signup-button')) {	    	
			jQuery(".overlay-scroll-container").addClass("hide");
	    }
	});	
		
	jQuery(".badge-overlay-close").click(function() {
		jQuery(".overlay-scroll-container").addClass("hide");
	});
	
	jQuery(".badge-upload-selector").click(function() {				
		jQuery(".overlay-scroll-container").removeClass("hide");
		jQuery("#modal-upload").removeClass("hide");
		jQuery(".badge-upload-items").addClass("hide");
	});
	
	jQuery(".badge-upload-image").click(function() {				
		if ( !jQuery("#jsid-upload-url-input").hasClass("hide")) {
			jQuery("#jsid-upload-url-input").addClass("hide");
		}
		jQuery("#jsid-upload-file-input").removeClass("hide");
									
	});
	jQuery(".badge-upload-url").click(function() {		
				
		if ( !jQuery("#jsid-upload-file-input").hasClass("hide")) {
			jQuery("#jsid-upload-file-input").addClass("hide");
		}
		jQuery("#jsid-upload-url-input").removeClass("hide");								
	});
	
 	jQuery("textarea[name=title]").keyup(function() {                  
	  	var limit = parseInt(jQuery(this).attr('data-maxlength'));         
	  	var text = jQuery(this).val();
	  	var chars = text.length;
	  	var result = (limit - chars) > 0 ? (limit - chars) : 0;     
	  	jQuery('#jsid-char-count').html(result);                          
	  	if(chars > limit || (limit - chars) <=0 ) {
		   alert('Bạn đã nhập quá số ký tự cho phép');                            
		   var new_text = text.substr(0, limit);                    
		   jQuery(this).val(new_text);
	  	}
 	});
 	jQuery("#jsid-upload-menu").click(function() {
 		if ( jQuery(".badge-upload-items").hasClass("hide")) {
			jQuery(".badge-upload-items").removeClass("hide");
		} else {
			jQuery(".badge-upload-items").addClass("hide");
		}
 	});
 	
 	//register and login
 	jQuery(".badge-login-button").click(function() {
 		jQuery(".overlay-scroll-container").removeClass("hide");
		jQuery(".badge-overlay-signin").removeClass("hide");
		jQuery(".badge-overlay-signup-fb").addClass("hide"); 
		jQuery("#modal-upload").addClass("hide");		
 	});
 	jQuery(".badge-signup-button").click(function() {
 		jQuery(".overlay-scroll-container").removeClass("hide");
		jQuery(".badge-overlay-signup-fb").removeClass("hide"); 
		jQuery(".badge-overlay-signin").addClass("hide");
		jQuery("#modal-upload").addClass("hide");		
 	});
});

function valivateFormUpload() { 		
	if ( !jQuery("#jsid-upload-url-input").hasClass("hide")) {		
		if (jQuery("#jsid-upload-url-input").val() == "") {
			alert('Vui lòng nhập đuờng dẫn');
			return false;
		}
	}
	
	if ( !jQuery("#jsid-upload-file-input").hasClass("hide")) {
		if (jQuery("#jsid-upload-file-input").val() == "") {
			alert('Vui lòng chọn hình ảnh cần upload');
			return false;
		}
	}
	
	// validate title
	var limit = parseInt(jQuery("textarea[name=title]").attr('data-maxlength'));  
	var text = jQuery("textarea[name=title]").val();
  	var chars = text.length; 
	if (chars > limit) {
		alert('Bạn đã nhập quá số ký tự cho phép');
		return false;
	}
	if (chars <= 0) {
		alert('Vui lòng nhập title');
		return false;
	}
	      
    return true;
}