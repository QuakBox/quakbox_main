$(window).scroll(function(){ /* window on scroll run the function using jquery and ajax */
		var WindowHeight = $(window).height(); /* get the window height */
		if($(window).scrollTop() +1 >= $(document).height() - WindowHeight){ /* check is that user scrolls down to the bottom of the page */		
			$("#last_msg_loader").show(); /* displa the loading content */
			var LastDiv = $(".stbody:last"); /* get the last div of the dynamic content using ":last" */
			var LastId  = $(".stbody:last").attr("data-id"); /* get the id of the last div */	
			var wall_type  = $(".stbody:last").attr("wall-type");
				//alert(wall_type);		
			var ValueToPass = "lastid="+LastId + "&wall_type=" + wall_type; /* create a variable that containing the url parameters which want to post to getdata.php file */
			$.ajax({ /* post the values using AJAX */
			type: "POST",
			url: base_url + "post.php",
			data: ValueToPass,
			cache: false,
				success: function(html){
					$("#last_msg_loader").hide();
					if(html){
						LastDiv.after(html); /* get the out put of the getdata.php file and append it after the last div using after(), for each scroll this function will execute and display the results */
					}
				}
			});
			return false;
		}
		return false;
});