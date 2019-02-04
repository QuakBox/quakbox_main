(function($) {

	        var x = 0;
	        var y = 0;
			//cache a reference to the banner
	        var banner = $("#background_img_design");

			// set initial banner background position
	        banner.css('backgroundPosition', x + 'px' + ' ' + y + 'px');

	 		// scroll up background position every 90 milliseconds
	        window.setInterval(function() {
	        	banner.css("backgroundPosition", x + 'px' + ' ' + y + 'px');
	            y--;
	            //x--;

	            //if you need to scroll image horizontally -
	            // uncomment x and comment y

	        }, 90);

})(jQuery);