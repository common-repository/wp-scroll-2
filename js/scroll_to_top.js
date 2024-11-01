var scroll_to_top_js_object={	
	start:function(){
		var self=this;
		jQuery(document).ready(function(){
			if(hhg_scroll_to_top.enabled=="1"){
				self.create_top_image();
				self.conect_to_scroll();
			}
		})		
	},
	create_top_image:function(){	
		jQuery('body').append('<img id="hhg_scroll_to_top" src="'+hhg_scroll_to_top.image_src+'">');
		jQuery("#hhg_scroll_to_top").css( "bottom",hhg_scroll_to_top.padding+"px" );
		var scrolled = window.pageYOffset || document.documentElement.scrollTop;
		if(scrolled==0)
			jQuery("#hhg_scroll_to_top").css( "display","none" );
		if(hhg_scroll_to_top.position_scroll=="right"){
			jQuery("#hhg_scroll_to_top").css( "right",hhg_scroll_to_top.padding+"px" );
		}else{
			jQuery("#hhg_scroll_to_top").css( "left",hhg_scroll_to_top.padding+"px" );
		}		
		this.conect_click_to_top_image();
	},
	conect_click_to_top_image:function(){
		var self=this;
		jQuery("#hhg_scroll_to_top").click(function(){
			var body = jQuery("html, body");
			body.animate({scrollTop:0},parseInt(hhg_scroll_to_top.time_to_scroll), "linear");
		})	
	},
	conect_to_scroll:function(){		
		jQuery(document).scroll(function(){
			var scrolled = window.pageYOffset || document.documentElement.scrollTop;
			if(scrolled>0){
				jQuery("#hhg_scroll_to_top").fadeIn(250);
			}else{
				jQuery("#hhg_scroll_to_top").fadeOut(250);
			}
		});
	}
	
	
}
scroll_to_top_js_object.start();



