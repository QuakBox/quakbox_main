//BELOW CODE IS FOR URL FETCH
	var getUrl  = $('#update'); //url to extract from text field
	
	getUrl.keyup(function() { //user types url in text field		
		
		//url to match in the text field
		var match_url = /\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i;
		
		//returns true and continue if matched url is found in text field
		if (match_url.test(getUrl.val())) {
				$("#results").hide();
				$("#loading_indicator").show(); //show loading indicator image
				
				var extracted_url = getUrl.val().match(match_url)[0]; //extracted first url from text filed
				
				//ajax request to be sent to extract-process.php
				$.post('extract-process.php',{'url': extracted_url}, function(data){         
               		
					extracted_images = data.images;
					total_images = parseInt(data.images.length-1);
					img_arr_pos = total_images;
					
					
					// video 
					extracted_videos = data.videos;
					total_videos = parseInt(data.videos.length-1);
					video_arr_pos = total_videos;
						
					if(total_images>0){
						inc_image = '<div class="extracted_thumb" id="extracted_thumb"><img src="'+data.images[img_arr_pos]+'" width="200px" height="150px"></div>';
					}else{
						inc_image ='';
					}
					
					if(total_videos>0){
						//inc_video=';	
						var content = '<div class="extracted_url"><div class="extracted_content" style="padding-bottom:3px"><h4><a href="'+extracted_url+'" target="_blank">'+data.title+'</a></h4></div><div class="extracted_thumb" id="extracted_thumb"><iframe frameborder="0" src="'+data.videos[2]+'" width="200px" height="150px"></iframe></div><p>'+data.content+'</p></div>';
						
					}else {					
						if(inc_image!='') { 	
						//content to be loaded in #results element
						var content = '<div class="extracted_url"><div class="extracted_content" style="padding-bottom:3px"><h4><a href="'+extracted_url+'" target="_blank">'+data.title+'</a></h4></div>'+ inc_image +'<p>'+data.content+'</p><div class="thumb_sel"><span class="prev_thumb" id="thumb_prev">&nbsp;</span><span class="next_thumb" id="thumb_next">&nbsp;</span> </div><span class="small_text" id="total_imgs">'+img_arr_pos+' of '+total_images+'</span><span class="small_text">&nbsp;&nbsp;Choose a Thumbnail</span></div>';
					
						}
					}
					
					//load results in the element
					$("#results").html(content); //append received data into the element
					$("#results").slideDown(); //show results with slide down effect
					$("#loading_indicator").hide(); //hide loading indicator image
                },'json');
		}
	});


	//user clicks previous thumbail
	$("body").on("click","#thumb_prev", function(e){		
		if(img_arr_pos>0) 
		{
			img_arr_pos--; //thmubnail array position decrement
			
			//replace with new thumbnail
			$("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="200px" height="150px">');
			
			//show thmubnail position
			$("#total_imgs").html((img_arr_pos) +' of '+ total_images);
		}
		
	});
	
	//user clicks next thumbail
	$("body").on("click","#thumb_next", function(e){		
		if(img_arr_pos<total_images)
		{
			img_arr_pos++; //thmubnail array position increment
			
			//replace with new thumbnail
			$("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="200px" height="150px">');
			
			//replace thmubnail position text
			$("#total_imgs").html((img_arr_pos) +' of '+ total_images);
		}
		
	});