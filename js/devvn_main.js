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
		function resize_func(){
			
		}
		resize_func();
		$(window).resize(function(){
			resize_func();
		})
	});
})(jQuery);