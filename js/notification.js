var base_url  = "https://beta.quakbox.com/";
$(document).ready(function() {	
 		// notification refresh on every 10 sec 
		$('<audio id="chatAudio"><source src="'+base_url+'images/notify.ogg"  type="audio/ogg"><source src="'+base_url+'images/notify.mp3" type="audio/mpeg"><source src="'+base_url+'images/notify.wav" type="audio/wav"></audio>').appendTo('body');
 		setInterval(function() {
 		
			/*$.post(base_url+ 'load_data/get-notification.php', function(data){										
			    if(data!=null) {
					var nid = data.id;
					var href = data.href;
					var username = data.username;
					var cface = data.cface;
					var usernamer = data.usernamer;
					var title = data.title;
					var date_created = data.date_created;
					var ncount = data.ncount;					
					var items = [];
					
					items.push("<li class='notili' id='"+nid+"'><a href='" + base_url + href+"' style='display:block; color:#FFFFFF; font-size:11px; padding: 7px 27px 7px 8px;'><div style='float:left; width:50px; height:50px; margin-right:8px;'><img src='"+cface+"' width='50' height='50'/></div><div style='overflow:hidden;'><div><strong>"+username+"</strong>");
					
					if(data.type==1){
						items.push('<span> likes </span>' + usernamer + ' status');
					}
					if(data.type==2){
						items.push('<span> commented on </span>' + usernamer + ' status');
					}
					if(data.type==3){
						items.push('<span> commented on </span>' + usernamer + ' status');
					}
					if(data.type==4){
						items.push('<span> invited you to join </span><strong>'+ title +'</strong>');
					}
					if(data.type==5){
						items.push('<span> added you to the group </span><strong>'+ title +'</strong>');
					}
					if(data.type==6){
						items.push('<span> invited you to join event </span><strong>'+ title +'</strong>');
					}
					if(data.type==7){
						items.push('<span> Accepted your request </span>');
					}
					if(data.type==8){
						items.push('<span> posts on wall </span>');
					}
					if(data.type==9){
						items.push('<span> Shared a link on your wall </span>');
					}
					if(data.type==10){
						items.push('<span> wants to be a friend </span>');
					}
					
					items.push('</div><div><span style="color:gray;">'+ date_created +'</span></div></div></a></li>');
					$("#notifi-post").prepend(items.join(''));
					$("#notifi_count_value").html(ncount);
					$("#notifi_count_wrapper").css("display","block");
					$('#chatAudio')[0].play();
				}
			},'json');
			$.ajax({
            type: "POST",
            url: base_url+'load_data/get-message.php',
            data: '',
            cache: false,
            success: function (data) {			
				if(data != null) {					
				$("#message-post").prepend(data);
				//$('#chatAudio')[0].play();		
				}
			}
			});
		
		
		$.ajax({
            type: "POST",
            url:  base_url+'load_data/get-friend_request.php',
            data: '',
            cache: false,
            success: function (data) {			
				if(data != null) {
				//alert('yes');					
				$("#friendreq").html(data);
				//$('#chatAudio')[0].play();		
				}
			}
			});*/
		
		
		
		
		
		
			
			
        }, 10000);
});