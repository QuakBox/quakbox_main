$(document).ready(function() {	
 		// div refresh on every 5 min for cmnt placing .... 
 		setInterval(function() {
					$.ajax({
            type: "POST",
            url: base_url + 'page_refresh_post.php',
            data: '',
            cache: false,
            success: function (data) {			
				if(data != null) {
				//alert('yes');					
				$(".post").prepend(data);
				//$('#chatAudio')[0].play();		
				}
			}
			});
   }, 60000);
});