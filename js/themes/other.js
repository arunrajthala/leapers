$(document).ready(function() {
		$('a[href=#top]').click(function(){
	$('html, body').animate({scrollTop:0}, 'slower');
		return false;
		});
		$(window).bind('scroll', function(){
		if($(this).scrollTop() > 50) {
		$(".to-top").fadeIn("1000");
		}
		else{
		$(".to-top").fadeOut("2000");
		}
		}
	);
	$(".helper-slideshow").owlCarousel({
 		autoPlay: 5000, //Set AutoPlay to 3 seconds
		 
		items : 5,
		itemsDesktop : [1199,5],
		itemsDesktopSmall : [979,5]
		 
		});
});
