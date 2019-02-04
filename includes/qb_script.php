<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
?>	
	<script src="<?php echo $base_url; ?>js/vendor/jquery-1.11.2.min.js"></script>
	<script src="<?php echo $base_url; ?>js/vendor/bootstrap.min.js"></script>
	<script src="<?php echo $base_url; ?>js/plugins.js"></script>
        <script src="<?php echo $base_url; ?>js/main.js"></script>
        <script src="<?php echo $base_url; ?>js/bootstrap-editable.min.js"></script>
<!--	<script src="https://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>-->
	<script src="<?php echo $base_url; ?>js/translate_page.js" type="text/javascript"></script>      
	<script type="text/javascript">
	var base_url = '<?php echo $base_url; ?>';
	function set_cookie_lacale(lang, url)
	{
	
	     $.ajax({
	            type: "POST",
	            url: "lang.php",
	            data: {lang:lang},
	            cache: false,
	            success: function (html) {
	               $("#lang").html(html);
	               document.cookie = 'lang=' + lang ;
		window.location = url;
	            }
	        });
		
	}
	</script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.0/jquery.nicescroll.min.js"></script>
    	<script src="<?php SITE_URL ?>/includes/js/walls.js?v=<?php echo time();?>"></script>
    	<script src="<?php SITE_URL ?>/includes/js/menu.js?v=1.13"></script>
	<script type="text/javascript" src="<?php SITE_URL;?>/js/jquery.share.js"></script>
	<script src="<?php SITE_URL;?>/video-ads/js/IScroll4Custom.js" type="text/javascript"></script>
	<script src='<?php SITE_URL;?>/video-ads/js/THREEx.FullScreen.js'></script>
	<script src="<?php SITE_URL;?>/video-ads/js/videoPlayer.js" type="text/javascript"></script>
	<script src="<?php SITE_URL;?>/video-ads/js/Playlist.js" type="text/javascript"></script>
	<script src="<?php echo $base_url; ?>assets/formvalidation/dist/js/formValidation.min.js"></script>
	<script src="<?php echo $base_url; ?>assets/formvalidation/dist/js/framework/bootstrap.min.js"></script>

  
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<script type="text/javascript">
		// console.log( "ready!" );
		 var videoname = "";   //Container For Storing actual trimmed video name with time stamp with Extension.
		 var logfileoutput = ""; //logfile of ffmpe conversion
		 var logRunningConditionStatus = false;//for preventing set interval jquery post
		 var nameWithoutExt = ""; //video name without extension
		 var uploadBoolCheck = false;//for preventing page refresh while processing by window unload function
		 var DefaultImageThumbnailName = "";//for storing default thumbnail name
		var processing =true;
		$(function($) {
			$(function(){
				var prevCountryName = "";
				$(document).on('keyup', "#filter_country", function(){
					var val = $.trim($(this).val()).toLowerCase();
					if(val == prevCountryName){
						return;
					}

					if(val == ""){
						// Show all
						$('.filter-country-name').each(function(){
							$(this).parent().css('opacity', 1);
						});
					} else {
						// Filter
						$('.filter-country-name').each(function(){
							if($(this).html().toLowerCase().indexOf(val) > -1){
								$(this).parent().css('opacity', 1)
							} else {
								$(this).parent().css('opacity', 0.1);
							}
						});
					}

					prevCountryName = val;
				});
			});
			
			

		    $(window).scroll(function(){
			var WindowHeight = $(window).height();
		//	if($(window).scrollTop() +1 >= $(document).height() - WindowHeight){   this commented on 29-03-2017
		if( $(window).scrollTop() >= ($(document).height() - WindowHeight)*0.7){
			//if(processing){
				
				if($("#twn").length != 0)
				{
					$("#wall_loader").show();	    	
				    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
					var twn=$("#twn").val(); 
					twn="b1"; 
			    		var twnECLength=$("#twnEC").length;
		    			var twnEC='';
		    			if(twnECLength!=0){
		    				twnEC=$("#twnEC").val();
		    			}
					var data = {item:"post",action:"getPrevious",c:twn,d:twnEC};		    	
				    	$.post(ajaxurl, data, function(response){
							//if(response)
				    		//{
									$(".wallvwe").append(response);
				    		$("#wall_loader").hide();	
							//processing = true;
							
							//}else{
							//$("#wall_loader").html('There is no further element');	
							///processing = false;
							//}
				    	});	
			    	}  	
			//}	
			}
			return false;
		  });

	   
			/*$(window).scroll(function() { 
							
				if(lastIdForScrolling!=null){	
				if(lastIdForScrolling>0){			
				var adNextLimit = lastIdForScrolling + 1;		
				var s = $(".adsc"+adNextLimit);
				var pos = s.position();	
				var windowpos = $(window).scrollTop();
				var posTop=pos.top;
				if(posTop==0){
					posTop=s.offset().top;
				}
				
				//console.log(pos);	
				//console.log("wp"+windowpos);	
				//console.log("pt"+posTop);
					
				if (windowpos >= posTop){			
											
						//$('.adsPanelContainer').removeClass("adsPanelDef");					
						$('.adsQBxzqw').addClass("adsPanelFxd");
						
						
						var i = 1;
						while (i <= lastIdForScrolling) 
						{
					  		$(".adsc"+i).hide();
					    		i++;
						}
											
					
				} else {	
							
						//$('.adsPanelContainer').removeClass("adsPanelFxd");
						//$('.adsPanelContainer').addClass("adsPanelDef");					
						$('.adsQBxzqw').removeClass("adsPanelFxd");
						var i = 1;
						while (i <= lastIdForScrolling) 
						{
					  		$(".adsc"+i).show();
					    		i++;
						}
											
					
						
				}
				}
				}
		
				
			});*/


		   
		   	setInterval(function(){
		    		
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    	/*var datamenu = {item:"menu",action:"getFriendsMenu"};		    	
			    	$.post(ajaxurl, datamenu, function(response){ 			    		   		
			    		$('.friendsMenuLinkHeader').html(response);
			    		$('[data-toggle="tooltip"]').tooltip();			    		
			    	});
			    	/*var twn=$("#twn").val();			    	
			    	var data = {item:"post",action:"getLatest",c:twn};		    	
			    	$.post(ajaxurl, data, function(response){
			    		$(".wallvwe").prepend(response);			    			
			    	});*/
			    	/*var datamenuNotification = {item:"menu",action:"getNotificationCount"};		    	
			    	$.post(ajaxurl, datamenuNotification, function(response){ 			    		   		
			    		$('.notificationMenuHeader1').html(response);
			    		$('[data-toggle="tooltip"]').tooltip();			    		
			    	});*/		    	
			    	
			}, 5000);
			
		   
		    /*$(document).on('keyup, change', '#updateStatus', function(e){	
		    	var content=$(this).val();
			var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
			// Filtering URL from the content using regular expressions
			var url= content.match(urlRegex);
				$('#btnSaveStatus').hide();					
			if(url!=null)
			{
				var loadedcontent= $("#loader").find(".info").length;
				if((url.length>0) && (loadedcontent==0))
				{					
					$('#load').show();
					$.post("https://qbdev.quakbox.com/fetching/fetch.php?url="+url, {
					}, function(response){
						$('#loader').css({"border": "1px solid #ccc","padding": "5px"});
						$('#loader').html($(response).fadeIn('slow'));
						$('#loader .images img').hide();
						$('#load').hide();
						$('img#1').fadeIn();
						$('#cur_image').val(1);
						$('#btnSaveStatus').show();
					});
				}
			}
			else{
				$('#loader').css({"border": "none","padding": "0px"});
				$('#loader').html('');
				
				$('#btnSaveStatus').show();
			}
			
		    });*/
		    // next image
			
			$(document).on('click', '#next', function(e){
				var firstimage = $('#cur_image').val();
				var total=$('#total_images').val();
				if(parseInt(firstimage)!=parseInt(total)){
					$('#cur_image').val(1);
					$('img#'+firstimage).hide();
				}
								
				if(parseInt(firstimage) < parseInt(total))
				{
					firstimage = parseInt(firstimage)+parseInt(1);					
					$('#cur_image').val(firstimage);
					$('img#'+firstimage).show();
					
				}				
			});	
			// prev image
			$(document).on('click', '#prev', function(e){		
			
				var firstimage = $('#cur_image').val();	
				if(parseInt(firstimage)!=1){			
					$('img#'+firstimage).hide();
				}
				if(parseInt(firstimage)>1)
				{
					firstimage = parseInt(firstimage)-parseInt(1);
					$('#cur_image').val(firstimage);
					$('img#'+firstimage).show();
					
				}
				
			});
			$(document).on('click', '#fetch_close', function(e){		
			
				$('#loader').css({"border": "none","padding": "0px"});
				$('#loader').html('<div align="center" id="load" style="display:none;"><img src="https://qbdev.quakbox.com/images/ajax-loader.gif" id="loading_indicator"></div>');
				
			});
			
			$( "#status_but" ).click(function() {							
				$( "#updateStatus" ).val('');
				var loadedcontent= $("#loader").find(".info").length;
				if(loadedcontent!=0)
				{
					$('#loader').css({"border": "none","padding": "0px"});
					$('#loader').html('<div align="center" id="load" style="display:none;"><img src="https://qbdev.quakbox.com/images/ajax-loader.gif" id="loading_indicator"></div>');	
				}
				$( "#myphoto" ).hide();
				$( "#updateContainer" ).toggle();					
				$( "#my_status" ).toggle();
			});
			$( "#photo_but" ).click(function() {
				$( "#my_status" ).hide();				
				$( "#updateContainer" ).toggle();					
				$( "#myphoto" ).toggle();
				var loadedcontent= $("#myphoto").find("#image_preview_wall").length;
				if(loadedcontent!=0)
				{
					$( "#myphoto #image_preview_wall" ).remove(); 
				}
				$( "#imageloadstatus" ).hide();
				$( "#imageloadbutton" ).show();
				
				
			});
			$( "#video_but" ).click(function() {				
				$( "#updateContainer" ).toggle();					
				$( "#myvideo" ).toggle();
			});
			//$( "#live_but" ).click(function() {
				//alert('Work is in progress');
				//return false;  
			// }); 
			/*$( "#live_but" ).click(function() {
	 //alert('opening camera');
	// $( "#mylive" ).toggle(); 
	 $( "#my_status" ).hide();				
				$( "#updateContainer" ).toggle();	 
				//navigator.getUserMedia = navigator.getUserMedia ||navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUsermedia || navigator.oGetUserMedia; if(navigator.getUserMedia){ navigator.getUserMedia({video: true}, handleVideo,videoError); } function handleVideo(stream){ document.querySelector('#a').src = window.URL.createObjectURL(stream); } function videoError(e){ alert("erro"); } 
			//	$( "#updateContainer" ).toggle();	
					// e.preventDefault();
// cross domain ajax call will fail, need more work to set up CORS
  //$.get("https://quakbox.com/RecordRTC/index.html", function(data) {
    //$("#myModal").html(data).foundation("open");
  //});

  //$("#myModal")
   // .html('<object width="70%" height="70%" type="text/html" data="https://quakbox.com/RecordRTC/index.html" ></object>')
    //.foundation("open");
				
			});*/
			
			$( "#btnCancelStatus" ).click(function(e) {
				e.preventDefault();							
				$( "#updateStatus" ).val('');
				var loadedcontent= $("#loader").find(".info").length;
				if(loadedcontent!=0)
				{
					$('#loader').css({"border": "none","padding": "0px"});
					$('#loader').html('<div align="center" id="load" style="display:none;"><img src="https://qbdev.quakbox.com/images/ajax-loader.gif" id="loading_indicator"></div>');	
				}	
				$( "#updateContainer" ).toggle();
				$( "#my_status" ).toggle();				
				
			});
			$('#closeLiveButton').click(function (e){
				
				location.reload();
			});
			$( "#btnCancelLive" ).click(function(e) {
				e.preventDefault();		
				$( "#mylive" ).toggle();
				$( "#updateContainer" ).toggle();				
				$( "#a" ).val('');
				document.querySelector('#a').src = '';
				
				
				navigator.getUserMedia = ( navigator.getUserMedia ||
navigator.webkitGetUserMedia ||
navigator.mozGetUserMedia ||
navigator.msGetUserMedia);

var video;
var webcamStream;
webcamStream.stop();
				
			});
			$(document).on('click', '.cancel_update_image', function(e){	
				e.preventDefault();					
				var loadedcontent= $("#myphoto").find("#image_preview_wall").length;
				if(loadedcontent!=0)
				{
					$( "#myphoto #image_preview_wall" ).remove(); 
				}
				$( "#imageloadstatus" ).hide();
				$( "#imageloadbutton" ).hide();									
				$( "#myphoto" ).toggle();
				$( "#updateContainer" ).toggle();
			});
			
			
			$(document).on('click', '#btnSaveStatus', function(e){
				$('#btnSaveStatus').attr("disabled", true);
			    	e.preventDefault();
					
			    	var postStatus=$("#updateStatus").val();
					var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
					var url= postStatus.match(urlRegex);
			    	if(postStatus!=''){
			    		var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    		/*var loadedcontent= $("#loader").find(".info").length;
						var linkType = $('#link_type').val();
						var videoContent = $('#videoContent').val();*/
			    		var twn=$("#twn").val();
			    		var twnECLength=$("#twnEC").length;
		    			var twnEC='';
		    			if(twnECLength!=0){
		    				twnEC=$("#twnEC").val();
		    			}
			    		var data='';
						/*postStatus = ( (linkType == 'video') && (videoContent != '') ) ? videoContent : postStatus;*/
						
			    		/*if( (loadedcontent>0) && (linkType != 'video') ){
			    			var currentImage = $('#cur_image').val();
			    			var imgsrc=$('#loader img#'+currentImage).attr('src');
			    			var srctitle=$('#loader .info .title').html();
			    			var srcurl=$('#loader .info .url').html();
			    			var srcdesc=$('#loader .info .desc').html();
			    			var data = 	 {item:"post",action:"updateStatus",status:postStatus,c:twn,d:twnEC,img:imgsrc,title:srctitle,url:srcurl,desc:srcdesc};
			    		}
			    		else{	*/
							//linkType = (linkType != '') ? linkType : '';type:linkType,
							$('#btnSaveStatus').attr("disabled", false);
			    			var data = {item:"post",action:"updateStatus",status:postStatus,c:twn,d:twnEC};
			    		/*}*/
			    		$.post(ajaxurl, data, function(response){
			    			var result = $.parseJSON(response);
			    			if(result.msg=='done'){
			    				$( "#updateContainer" ).toggle();
			    				$( "#my_status" ).toggle( 300 );
			    				var twn=$("#twn").val();
				    			$(".wall_header").append("<div class='wpsUp' style='color:green;text-align:center;'>You posted a new status</div>");
				    			   	
						    	var data = {item:"post",action:"getLatest",c:twn,d:twnEC,};		    	
						    	$.post(ajaxurl, data, function(response){
						    		$(".wallvwe").prepend(response);			    			
						    	});
						    	window.location.reload();		    			
				    		}
				    		else{
				    			$("#my_status").append("<div class='wpsUp' style='color:red;text-align:center;'>Error</div>");
				    		}
				    		
				    		window.setTimeout(function() {
						    $(".wpsUp").fadeTo(300, 0).slideUp(300, function(){
						        $(this).remove();
						        
						    });
						}, 3000);			    			
				    	});
				    				    		
			    	}
			    	else{
			    		$("#my_status").append("<div style='color:red;text-align:center;'>Please fill the status text..</div>");
			    	}		    		
			    	
			    });	
			    $(document).on('click', '.update_image', function(e){
			    	e.preventDefault();
			    	var postDescription=$("#photo_description").val();
			    	var upID=$(".update_image").attr('id');			    	
		    		var ajaxurl=window.location.origin+"/ajax/acccept.php";		    		
		    		var twn=$("#twn").val();
		    		var twnECLength=$("#twnEC").length;
	    			var twnEC='';
	    			if(twnECLength!=0){
	    				twnEC=$("#twnEC").val();
	    			}
		    		var data={item:"post",action:"updateImage",status:postDescription,c:twn,d:twnEC,u:upID};

		    		$.post(ajaxurl, data, function(response){
		    			var result = $.parseJSON(response);
		    			if(result.msg=='done'){
		    				$( "#updateContainer" ).toggle();
		    				$( "#myphoto" ).toggle(300);		    				
			    			$(".wall_header").append("<div class='wpsUp' style='color:green;text-align:center;'>You posted a new image</div>");
					    	var data = {item:"post",action:"getLatest",c:twn,d:twnEC,};		    	
					    	$.post(ajaxurl, data, function(response){
					    		$(".wallvwe").prepend(response);			    			
					    	});
					    	window.location.reload();		    			
			    		}
			    		else{
			    			$("#my_status").append("<div class='wpsUp' style='color:red;text-align:center;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(".wpsUp").fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove();
					        
					    });
					}, 3000);			    			
			    	});
			    });
			    
			    
			    $(document).on('click', '.accept_request', function(e){
			    e.preventDefault();
			    		var illahi = $(this).attr("id");
					var twnECLength=illahi.length;
		    			var twnEC='';
		    			if(twnECLength!=0){
		    				twnEC= illahi;
		    			}
					
					var ajaxurl=window.location.origin+"/ajax/acccept.php";
					var data={item:"user",action:"acceptRequest",d:twnEC};
					$.post(ajaxurl, data, function(response){
		    			var result = $.parseJSON(response);
		    			if(result.msg=='done'){
		    				$("#friends1"+ twnEC).hide();
						$("#friends"+ twnEC).show();
						if($("#fri"+ twnEC).length != 0)
						{
							$("#fri"+ twnEC).hide();
						}
						if($("#friend"+ twnEC).length != 0)
						{
							$("#friend"+ twnEC).show();
						}
						//
						//
					    			    			
			    		}
			    		else{
			    			//$("#my_status").append("<div class='wpsUp' style='color:red;text-align:center;'>Error</div>");
			    			alert(result.msg);
			    		}
			    					    			
			    		});
					 
					});
					$('.cancel_request').click(function (e) {	
					e.preventDefault();
					var illahi = $(this).attr("custoMid");
					var twnECLength=illahi.length;
		    			var twnEC='';
		    			if(twnECLength!=0){
		    				twnEC= illahi;
		    			}
					
					var ajaxurl=window.location.origin+"/ajax/acccept.php";
					var data={item:"user",action:"cancelRequest",d:twnEC};
					$.post(ajaxurl, data, function(response){
		    			var result = $.parseJSON(response);
		    			if(result.msg=='done'){
		    				$("#friends1"+ twnEC).hide();
						$("#mini_prof"+ twnEC).remove();
						if($("#fri"+ twnEC).length != 0)
						{
							$("#fri"+ twnEC).hide();
						}
						
					    			    			
			    		}
			    		else{
			    			//$("#my_status").append("<div class='wpsUp' style='color:red;text-align:center;'>Error</div>");
			    			alert(result.msg);
			    		}
			    					    			
			    		});
					
						
					});
							    
			    
			    
			    			    
			    $(document).on('change', '#wall_video', function(e){

		         	var fsize = $('#wall_video')[0].files[0].size; //get file size
		           	var ftype = $('#wall_video')[0].files[0].type; // get file type
		          // 	console.log(fsize);
		           //	console.log(ftype);
			        //allow file types 
			     	//validation of mime types of uploaded video file
				 switch(ftype)
				   {
				            case 'video/avi': 
				            case 'video/mpeg': 
				            case 'video/quicktime': 
				            case 'video/webm':
				            case 'video/ogg':
				            case 'video/x-matroska':
				            case 'video/x-ms-wmv':
				            case 'video/x-flv':
				            case 'video/flv':
				            case 'video/mp4':
				            case 'video/3gpp':
				            break;
				            default:
				             alert(ftype+" Unsupported file type!");
				         return false
				        
			           }
		    
			       //Allowed file size is less than 1000 MB (1048576 = 1 mb) 500000000
			       if(fsize> 500000000) 
			       {
			         //alert(fsize +"<?php echo $lang['Too big file! <br />File is too big, it should be less than 500MB']; ?>.");
			         alert("Too big file! File is too big, it should be less than 500MB");
			         return false
			         
			       }
			      //$(this).closest('form').trigger('submit');
			     // var formData = new FormData();
				//formData.append('file',$('#wall_video')[0].files[0]);
				
				 $('#update_video').attr('disabled','disabled');
/*		         var ajaxurl=window.location.origin+"/action/qb_video_process.php";
		         $.ajax({
				url: ajaxurl, // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					console.log(data);
					if(data !='error'){
						var videoname = data;
						var nameWithoutExt = videoname.substr(0,videoname.lastIndexOf("."));
						var logfileoutput = nameWithoutExt + ".txt";
						$.post('action/qb_video_convert.php', { video_name: videoname, logFile: logfileoutput  }, function(result) {
						     	 console.log(result);
							 $('#progress1').hide();
							 //logRunningConditionStatus = false;
							 status.html(result);
							 //$('#update_video').removeAttr('disabled');; 	 
						}); 
					}
					else{
						alert("sorry an error occured while processing your request");
					}
				}
			});
			*/ 
		          $(this).closest('form').trigger('submit');
		         //this button submits closest form and action page is action/video_upload.php
		         //$('#uploadPage').hide();//hiding upload page
		         
		    	 $('#ProcessPage').show();//showing process page  
		    	 $('#progress').show();
		    	 $('#progress1').hide();
		    	
		    	 
		    	 
		         
		    });
		     var bar = $('.bar');  
			 var percent = $('.percent'); 
			 var progress = $('.progress'); 
			 var status = $('#status');
			 
			 //progress bar for processing and calling unload function
			 //setTimeout(checkFfmpegProgress(),100);

			 
			 var bar1 = $('#bar1');
 			 var percent1 = $('#percent1');
			 function setCorrectingInterval(func, delay) {
			  if (!(this instanceof setCorrectingInterval)) {
			    return new setCorrectingInterval(func, delay);
			  }
			
			  var target = (new Date().valueOf()) + delay;
			  var that = this;
			
			  function tick() {
			    if (that.stopped) return;
			
			    target += delay;
			    func();
			
			    setTimeout(tick, target - (new Date().valueOf()));
			  };
			
			  setTimeout(tick, delay);
			};
			
			function clearCorrectingInterval(interval) {
				if(typeof(interval) == "object" && "stopped" in interval){
					interval.stopped = true;
				}
			}
			
			var startTime = Date.now();
			setCorrectingInterval(function() {
			   if(logRunningConditionStatus){
			        $.post(window.location.origin +'/action/ffmpegProgRes.php', { logfilepath : logfileoutput }, function(data) {
			        
			        bar1.width(data);
			        percent1.html(data);
			        if( data == "100%"){
			        	clearCorrectingInterval();
				    }
			        
			    }); }
			
			}, 1000);
			
			
		  
		    $('#video_form').ajaxForm({ 
				 beforeSend: function() {
				     progress.show();
				     status.empty();  
				     var percentVal = '0%';  
				     bar.width(percentVal);  
				     percent.html(percentVal);            
				   },  
				   uploadProgress: function(event, position, total, percentComplete) {  
				     console.log('percentage: ' + percentComplete);
				     var percentVal = percentComplete + '%';  
				     bar.width(percentVal)  
				     percent.html(percentVal);
				    
				   },  
				   complete: function(xhr) { 
				    console.log(xhr);
                                    
				     bar.width("100%");  
				     percent.html("100%"); 
				     if(xhr.responseText !=='error'){
				     	 videoname = xhr.responseText;
						 console.log(videoname);
					     nameWithoutExt = videoname.substr(0,videoname.lastIndexOf("."));
					     logfileoutput = nameWithoutExt + ".txt";
					     progress.hide();
					     logRunningConditionStatus = true;
					     setTimeout(checkFfmpegProgress(), 200);
					     $('#bar1').width('1%');
					     $('#percent1').html('1%');
					     $('#progress1').show();
					     $("#flash").show();
					     $("#flash").fadeIn(400).html('Loading Update...');
						 var ajaxurl34 = window.location.origin + "/action/qb_video_convert.php";

						 $.post(ajaxurl34, {video_name: videoname, logFile: logfileoutput}, function (result, textStatus, jqXHR) {
							 var res = $.parseJSON(result);
							 $('#progress1').hide();
							 logRunningConditionStatus = false;
							 status.html(res.msg);
							 $('#update_video').removeAttr('disabled');
							 $('#update_video').data('vname', res.vname);
							 $('#update_video').val("Save");
						 });
						
				     }
				     else{
				     	alert("sorry some error occurred");
				     } 
				    
				   }  
			});	
                    $(document).on('click', '#update_video', function(e){
			    	e.preventDefault();
			    	var title =$("#title").val();
					//var vname = $('#update_video').data('vname');
					var vname = videoname;
					vname = (vname !== '' && vname !== null && vname !== 'undefined') ? vname : '';
			    	var postDescription=$("#video_description").val();			    	
		    		var ajaxurl=window.location.origin+"/ajax/acccept.php";		    		
		    		var twn=$("#twn").val();
		    		var twnECLength=$("#twnEC").length;
	    			var twnEC='';
	    			if(twnECLength!==0){
	    				twnEC=$("#twnEC").val();
	    			}
		    		var data={item:"post",action:"updateVideo",videoname:vname,title:title,c:twn,d:twnEC,desc:postDescription};

		    		$.post(ajaxurl, data, function(response){
		    			var result = $.parseJSON(response);
		    			if(result.msg=='done'){
		    				$( "#updateContainer" ).toggle();
		    				$( "#myvideo" ).toggle(300);		    				
			    			$(".wall_header").append("<div class='wpsUp' style='color:green;text-align:center;'>You posted a new video</div>");
			    			   	
					    	var data = {item:"post",action:"getLatest",c:twn,d:twnEC,};		    	
					    	$.post(ajaxurl, data, function(response){
					    		$(".wallvwe").prepend(response);
								$(".wallvwe >div:first-child").find('script').each(function(){
									eval($(this).text());
								});
					    	});
							$('#video_form')[0].reset();
							window.location.reload();
			    		}
			    		else{
			    			$("#my_status").append("<div class='wpsUp' style='color:red;text-align:center;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(".wpsUp").fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove();
					        
					    });
					}, 3000);
			    	});	

			    /**			
				logRunningConditionStatus = false;
				/ *var title = $('#title').val(); * /  
				var nameWithoutExt = $('#update_video').data('vname');
				/*var privacy = $('#video_privacy').val();  
				var country = $("#country").val(); * / 
				var video_custom_share = $("#video_custom_share").val();
				var video_custom_unshare = $("#video_custom_unshare").val(); 
				var content_id = $("#content_id").val();
			  
				$.post(window.location.origin+'/action/wall-video-upload.php', { title : '' , privacy: '', country: '', video_custom_share :'',video_custom_unshare :'' , defaultthumbnail : '', nwe : nameWithoutExt, content_id: '' }, function(data) {
					logRunningConditionStatus = false;
					/*$("#flash").fadeOut('slow');
					$(".post").prepend(data);* /
					$("#wall_video").val('');
					$("#updateContainer").fadeOut('slow');       
					alert("Video upload successfully !!!");
				});
				****/
				
				
			});
			
                       
                       
			$(document).on('change', '#image', function(e){
			    var values = $("#uploadvalues").val();
			    $("#previeww").html('<img src="wall_icons/loader.gif"/>');
			    $("#imageform").ajaxForm({
			        target: '#preview',
			        beforeSubmit: function () {
			            $("#imageloadstatus").show();
			            $("#imageloadbutton").hide();
			        },
			        success: function () {
			            $("#imageloadstatus").hide();
			            $("#imageloadbutton").hide();
			            $('#image').val('');
			        },
			        error: function () {
			            $("#imageloadstatus").hide();
			            $("#imageloadbutton").show();
			        }
			    }).submit();
			    var X = $('.preview').attr('id');
			    if (X != 'undefined') {
			        $("#uploadvalues").val(X);
			    }
			});			
			
			$(document).on('click', '.walls_share', function(e){ 
				// Your code on successful click
				//for resetting form and values
				$("#shareSubmitButtonID").removeAttr('disabled');
				$('#shareform')[0].reset();
				$('#countries').val('').trigger('chosen:updated');
				$("#group_name").tokenInput("clear");
				$("#friend_name").tokenInput("clear");
				$(".share_body").empty();
				$('#mydiv3').empty();
				
				$("#mvm").show();
				$("#hiddenIDForSelection").attr("value" , "0");
				$("#mvm1").hide();
				$("#mvm2").hide();
			    var ID = $(this).attr("id");
				var rowtype = $(this).data("type");
				var rowTypeValue = null;
				if(rowtype=="0")
				{ rowTypeValue='Share';}
				else if(rowtype=="1")
				{ rowTypeValue='Share Photo';}
				else if(rowtype=="2")
				{ rowTypeValue='Share Video';}
				else if(rowtype=="3")
				{ rowTypeValue='Share Video';}
			    var dataString = 'msg_id=' + ID;
			    $.ajax({
			        type: "POST",
			        url: "<?php echo $base_url;?>load_data/share_info.php",
			        data: dataString,
			        cache: false,
			        success: function (html) {
            			$("#shareSubmitButtonID").attr("value",rowTypeValue );
			            $(".share_popup").show();
			            $(".share_body").append(html);
						$('#mydiv3').share({
			        networks: ['facebook','pinterest','googleplus','twitter','linkedin','tumblr','in1','stumbleupon','digg'],        
			        urlToShare: '<?php echo $base_url;?>fetch_posts.php?id='+ID
			       
			    });
			    $('#mydiv3').append("<img id='email' src='<?php echo $base_url;?>images/sendemail.png' height='40' width='40' alt='Send Email' title='Send Email' onclick='showform()' class='pop share-icon'>");
			    $('#email').css('cursor', 'pointer');
			        }
			    });
			    return false;
			});
			$("#addTabsC").niceScroll();
			
			
			/* walls */
			
						    
			    
			    //common			   
  			    $('[data-toggle="tooltip"]').tooltip();

					    
			//add share using jquery
  			  $('#shareSubmitButtonID').on('click', function () {
  			  //alert('hii');
  			      var friend_name = $("#friend_name").val();
  			      var group_name = $("#group_name").val();
  			      var countries = $("#countries").val();
  			      var privacy= $("#privacy")[0].selectedIndex;
  			      if(privacy == 0){
  			      if(friend_name == ''){
  			      /*jAlert('You must provide a recipient for your shared item.', 'No Recipient');*/
				  alert('You must provide a recipient for your shared item.', 'No Recipient');
  			      return false;
  			      }
  			      } else if(privacy == 1){
  			      if(group_name == ''){
  			      alert('You must provide a recipient for your shared item.', 'No Recipient');return false;
  			      }
  			      }else if(privacy == 2){
  			      if(countries == null){
  			      alert('You must provide a recipient for your shared item.', 'No Recipient');return false;
  			      }
  			      }
  			      $('#shareSubmitButtonID').attr('disabled','disabled');	
  			      //$("#previeww").html('<img src="wall_icons/loader.gif"/>');
  			      $("#shareform").ajaxForm({        
  			          success: function () {
  			              $(".share_popup").hide();
  			              alert('Share successfully.', 'Share');           
  			          },
  			          error: function () {
  			              $("#imageloadstatus").hide();            
  			          }
  			      }).submit();
  			      
  			  });
		});
		function checkFfmpegProgress(){
			console.log( logRunningConditionStatus );
			var bar1 = $('#bar1'); 
			var percent1 = $('#percent1');        
			if(logRunningConditionStatus){
		        $.post('<?php echo $base_url;?>action/ffmpegProgRes.php', { logfilepath : logfileoutput }, function(data) {
			        bar1.width(data);
			        percent1.html(data);
			       	intPercentage = data.replace("%", "" );
			       	intPercentage = parseInt( intPercentage );
			        if( intPercentage < 100 ){
			        	checkFfmpegProgress();
				    } else {
						console.log("Continue to the video execution");
						
					}

					$('#update_video').removeAttr('disabled'); // .data('vname', res.vname);
		        }); 
		    }
		}
/*window.setInterval(function(){
 $( ".wallvwe").load("test.html");
 }, 5000);*/	
 
 
	</script>