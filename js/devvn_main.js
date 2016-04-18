/*
* Author: Le Van Toan
* Website: http://levantoan.com
*/
(function($) {
	$(document).ready(function() {
		/*Go to element*/
		$("a.gotoDiv").click(function(){
			var idElement = $(this).attr("href");
			var top = $(idElement).offset().top;
			$('html, body').animate({scrollTop:top-44}, 500 );
			return false;
		});
		/*Go to top*/
		$(".gototop").click(function(){
			$('html, body').animate({scrollTop:0}, 500 );
			return false;
		});
		$('.button_menu,.over_wrap').click(function() {
			if( ($('html').hasClass('openMenu')) ){
				$('html').removeClass('openMenu');
			}else {
				$('html').addClass('openMenu');
			}
			return false;
		});
		$('.menu_header li.menu-item-has-children').each(function(){
	    	$(this).prepend('<i class="fa fa-angle-down click_opensub_menu"></i>');
	    });
	    $('.click_opensub_menu').on('click',function(){
	    	if($(this).parent().hasClass('opensub_menu')){
	    		$(this).parent().removeClass('opensub_menu');
	    		return false;
	    	}
	    	$('.menu_header li').removeClass('opensub_menu');
	    	if($(this).parent().hasClass('opensub_menu')){
	    		$(this).parent().removeClass('opensub_menu');
	    	}else{
	    		$(this).parent().addClass('opensub_menu');
	    	}
	    	return false;
	    });
		/**********
		 * Scroll
		 * **************/
		function scroll_element(){
			/*Add class menuStick to body*/
			$top = $(window).scrollTop(); 
			if( $top >= 200 && !($('body').hasClass('menuStick')) ){
				$('body').addClass('menuStick');
			}else if($top < 200 && $('body').hasClass('menuStick') ){
				$('body').removeClass('menuStick');
			}
		}
		scroll_element();
		$(window).scroll(function(){
			scroll_element();
		});
		/**********
		 * Resize
		 * **************/
		var id;
		function resize_func(){
								
		}
		$(window).resize(function(){
			clearTimeout(id);
		    id = setTimeout(resize_func, 500);
		});
	});
})(jQuery);