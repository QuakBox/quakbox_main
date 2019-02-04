<script>
//Global Variables
 var videoname="";   //Container For Storing actual trimmed video name with time stamp with Extension.
 var logfileoutput = ""; //logfile of ffmpe conversion
 var logRunningConditionStatus = false;//for preventing set interval jquery post
 var nameWithoutExt = ""; //video name without extension
 var uploadBoolCheck = false;//for preventing page refresh while processing by window unload function
 var DefaultImageThumbnailName = "";//for storing default thumbnail name
$(document).ready(function () {

//video upload

$('#videodedx').live('change',function(){
alert("hbhjb");
         var fsize = $('#video')[0].files[0].size; //get file size
           var ftype = $('#video')[0].files[0].type; // get file type
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
            break;
            default:
             alert(ftype+"<?php echo $lang[' Unsupported file type']; ?> !");
         return false
        
           }
    
       //Allowed file size is less than 1000 MB (1048576 = 1 mb)
       if(fsize> 1048576000) 
       {
         alert(fsize +"<?php echo $lang['Too big file! <br />File is too big, it should be less than 1000 MB']; ?>.");
         return false
         
       }
         
         
         $(this).closest('form').trigger('submit'); //this button submits closest form and action page is action/video_upload.php
         $('#uploadPage').hide();//hiding upload page
         
    	 $('#ProcessPage').show();//showing process page
    	 
    	 uploadBoolCheck = true;
    	 
    	 
         
    });
    
    $('#update_video').click(function(){
    var member_id = $("#member_id").val();
    var title = $('#title').val();      
    var privacy = $('#video_privacy').val();    
    var country = $("#country").val();
    var video_custom_share = $("#video_custom_share").val();
    var video_custom_unshare = $("#video_custom_unshare").val(); 
    
  
    $.post('action/wall-video-upload.php', { title : title , member_id : member_id, privacy: privacy, country: country, video_custom_share : video_custom_share ,video_custom_unshare :video_custom_unshare , defaultthumbnail : DefaultImageThumbnailName, nwe : nameWithoutExt }, function(data) {
    uploadBoolCheck = false;
    $("#flash").fadeOut('slow');
                $(".post").prepend(data);
                $("#video").val('');
             $("#video_form").fadeOut('slow');       
	
     });
    
    
    
});
    
       
     var bar1 = $('#bar1');
 var percent1 = $('#percent1');
 //progress bar for processing and calling unload function
 setInterval(function(){
        if(uploadBoolCheck){
        
        	window.onbeforeunload = function()
	        {
	    		return '<?php echo $lang['You have unsaved changes'];?>!';
	    		$(window).unload();
		}
        
        }
        if(logRunningConditionStatus){
        $.post('action/ffmpegProgRes.php', { logfilepath : logfileoutput }, function(data) {
        
        bar1.width(data);
        percent1.html(data);
        
    }); }
}, 100);

var bar = $('.bar');  
 var percent = $('.percent'); 
  var progress = $('.progress'); 
 var status = $('#status');
$('#update_video').attr('disabled','disabled');;
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
   
     bar.width("100%");  
     percent.html("100%");  
     videoname = xhr.responseText;
     nameWithoutExt = videoname.substr(0,videoname.lastIndexOf("."));
     logfileoutput = nameWithoutExt + ".txt";
     progress.hide();
     logRunningConditionStatus = true;
     $('#bar1').width('1%');
     $('#percent1').html('1%');
     $('#progress1').show();
     $("#flash").show();
            $("#flash").fadeIn(400).html('Loading Update...');
     $.post('action/video_convert.php', { video_name: videoname, logFile: logfileoutput  }, function(result) {
	 $('#progress1').hide();
	 logRunningConditionStatus = false;
	 status.html(result);
	 $('#update_video').removeAttr('disabled');; 	 
	}); 
   }  
 });

    $('.like').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("like");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = 'load_data/message_like_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
			dataType: 'json',
            success: function (html) {
				var likecount = html.likecount;
                var dislikecount = html.dislikecount;
				
                if (REL == 'Like') {
					if(likecount == 1) {
						$("#likes" + New_ID).prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?></span>");
					}
					if(likecount == 2) {
						$("#likes" + New_ID).prepend("<span id='you" + New_ID + "'><a href='#'><?php echo $lang['You'];?></a> <?php echo $lang['and'];?> </span>");
					}
					if(likecount > 2){
						$("#likes" + New_ID).prepend("<span id='you" + New_ID + "'><a href='#'><?php echo $lang['Unlike'];?></a>, </span>");
					}
					
                                        
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                } else {
                    $("#youlike" + New_ID).slideUp('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['like'];?>').html('<?php echo $lang['like'];?>');
                }
				
				if (dislikecount > 0) {					
                    $('#postdislikecount' + New_ID).html(dislikecount);
                } else {
                    $('#postdislike_container' + New_ID).fadeOut('fast');
                }
				
				if (likecount > 0) {
                    $('#likes' + New_ID).fadeIn('fast');
                } else {
                    $('#likes' + New_ID).fadeOut('fast');
                }
            }
        });
    });
	
	//post dislike 
	$('.post_dislike').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("post_dislike");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = 'load_data/post_dislike_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                $("#you" + New_ID).remove();
                $('#like' + New_ID).html('<?php echo $lang['like'];?>').attr('rel', 'Like').attr('title', '<?php echo $lang['like'];?>');
                $("#postdislike_container" + New_ID).fadeIn('slow');
                
                if (dislikecount > 0) {					
                    $('#postdislikecount' + New_ID).html(dislikecount);
                } else {
                    $('#postdislike_container' + New_ID).fadeOut('fast');
                } 
				if (likecount > 0) {
                    //$('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#likes' + New_ID).fadeOut('fast');
                }               
            }
        });
    });
	
    $('.comment_dislike').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("comment_dislike");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = 'load_data/comment_dislike_ajax.php';
        var dataString = 'comment_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                $("#you" + New_ID).remove();
                $('#comment_like' + New_ID).html('<?php echo $lang['like'];?>').attr('rel', 'Like').attr('title', '<?php echo $lang['like'];?>');
                $("#dislikecout_container" + New_ID).fadeIn('slow');
                $('#dislikecout' + New_ID).html(dislikecount);
                $('#commentlikecount' + New_ID).html(likecount);
                if (dislikecount > 0) {
                    $('#dislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#dislikecout_container' + New_ID).fadeOut('slow');
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }
            }
        });
    });
    $('.comment_like').die('click').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("comment_like");
        var New_ID = sid[1];
        var msg_id = $(this).attr("msg_id");
        var comma = "";
        var youcount = $("#commacount" + New_ID).val();
        if (youcount > 0) {
            comma = ", ";
        }
        var REL = $(this).attr("rel");
        var URL = 'load_data/comment_like_ajax.php';
        var dataString = 'comment_id=' + New_ID + '&rel=' + REL + '&msg_id=' + msg_id;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: "json",
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                
                if (REL == 'Like') {
                    $("#clike" + New_ID).show('slow').prepend("<span id='you" + New_ID + "'><a href='#'>You</a>" + comma + "</span>");
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                } else {
                    if (youcount == 0) $("#clike" + New_ID).hide('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', '<?php echo $lang['like'];?>').attr('title', 'Like').html('<?php echo $lang['like'];?>');
                }
                if (dislikecount > 0) {
                    $('#dislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#dislikecout_container' + New_ID).fadeOut('slow');
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }
            }
        });
    });
	//reply dislike function
	$('.reply_dislike').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("reply_dislike");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = 'load_data/reply_dislike_ajax.php';
        var dataString = 'reply_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                $("#you" + New_ID).remove();
                $('#reply_like' + New_ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Like').attr('title', '<?php echo $lang['Unlike'];?>');
                $("#rdislikecout_container" + New_ID).fadeIn('slow');
                $('#rdislikecout' + New_ID).html(dislikecount);
                //$('#commentlikecount' + New_ID).html(likecount);
                if (dislikecount > 0) {
                    $('#rdislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#rdislikecout_container' + New_ID).fadeOut('slow');
                }
                /*if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }*/
            }
        });
    });
	
	//reply like function
    $('.reply_like').die('click').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("reply_like");
        var New_ID = sid[1];        
        
        var REL = $(this).attr("rel");
        var URL = 'load_data/reply_like_ajax.php';
        var dataString = 'reply_id=' + New_ID + '&rel=' + REL ;
		var comma = "";
        var youcount = $("#commacount" + New_ID).val();
        if (youcount > 0) {
            comma = ", ";
        }
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: "json",
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
				                
                if (REL == 'Like') {
                    $("#rlike" + New_ID).show('slow').prepend("<span id='you" + New_ID + "'><a href='#'>You</a>" + comma + "</span>");
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                } else {
                    if (youcount == 0) $("#rlike" + New_ID).hide('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', '<?php echo $lang['like'];?>').attr('title', 'Like').html('<?php echo $lang['like'];?>');
                }
                if (dislikecount > 0) {
                    $('#rdislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#rdislikecout_container' + New_ID).fadeOut('slow');
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }
            }
        });
    });
    $('.ads_like').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("like_ads");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = 'load_data/ads_like_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            success: function (html) {
                if (REL == 'Like') {
                    $("#youlike" + New_ID).slideDown('slow').prepend("<span id='you" + New_ID + "'><a href='#'><?php echo $lang['You'];?></a><?php echo $lang['like this'];?>.</span>.");
                    $("#ads_likes" + New_ID).prepend("<span id='you" + New_ID + "'><a href='#'><?php echo $lang['You'];?></a>, </span>");
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                } else {
                    $("#youlike" + New_ID).slideUp('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['like'];?>').html('<?php echo $lang['like'];?>');
                }
            }
        });
    });
    $(".update_button").click(function () {
        var updateval = $("#update").val();
        var country = $("#country").val();
        var member_id = $("#member_id").val();
        var privacy = $("#privacy1").val();
        var share_member_id = $("#photo_custom_share").val();
        var unshare_member_id = $("#photo_custom_unshare").val();
        var uploadvalues = $("#uploadvalues").val();
        var dataString = 'update=' + updateval + '&country=' + country + '&member_id=' + member_id + '&privacy=' + privacy + '&share_member_id=' + share_member_id + '&unshare_member_id=' + unshare_member_id;
        if (updateval == '') {
            alert("<?php echo $lang['Please Enter Some Text'];?>");
        } else {
            $("#flash").show();
            $("#flash").fadeIn(400).html('<?php echo $lang['Loading update']?>...');
            $.ajax({
                type: "POST",
                url: "action/update_ajax.php",
                data: dataString,
                cache: false,
                success: function (html) {
                    $("#flash").fadeOut('slow');
                    $(".post").prepend(html);
                    $("#update").val('');
                    $("#update").focus();
                    $("#stexpand").oembed(updateval);
                }
            });
            $('#my_status').slideUp('fast');
        }
        return false;
    });
    $(".update_image").click(function () {
        var country = $("#country").val();
        var member_id = $("#member_id").val();
        var privacy = $("#photo_privacy").val();
        var share_member_id = $("#photo_custom_share").val();
        var unshare_member_id = $("#photo_custom_unshare").val();
        var uploadvalues = $("#uploadvalues").val();
        var X = $('.preview').attr('id');
        if (X) {
            var Z = X;
        } else {
            var Z = 0;
        }
        var dataString = 'country=' + country + '&member_id=' + member_id + '&privacy=' + privacy + '&share_member_id=' + share_member_id + '&unshare_member_id=' + unshare_member_id + '&uploads=' + Z;
        $("#flash").show();
        //$("#flash").fadeIn(400).html('<?php echo $lang['Loading update'];?>...');
        $.ajax({
            type: "POST",
            url: "action/image_upload_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#flash").fadeOut('slow');
                $(".post").prepend(html);
                $('#preview').html('');
                $('#uploadvalues').val('');
                $('#image').val('');
				$("#imageloadbutton").show();
            }
        });
        $("#preview").html();
        $('#myphoto').slideUp('fast');
        return false;
    });
});
$('.button').live("click", function () {
    var ID = $(this).attr("id");
    var comment = $("#ctextarea" + ID).val();
    var dataString = 'comment=' + comment + '&msg_id=' + ID;
    if (comment == '') {
        alert("<?php echo $lang['Please Enter Comment Text'];?>");
    } else {
        $.ajax({
            type: "POST",
            url: "action/comment_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#commentload" + ID).append(html);
                $("#ctextarea" + ID).val('');
                $("#ctextarea" + ID).focus();
            }
        });
    }
    return false;
});
$('.report').live("click", function () {
    var ID = $(this).attr("id");
    var comment = $("#rptextarea" + ID).val();
    var dataString = 'report=' + comment + '&msg_id=' + ID;
    if (comment == '') {
        alert("<?php echo $lang['Please Enter Comment Text'];?>");
    } else {
        $.ajax({
            type: "POST",
            url: "action/report_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#commentload" + ID).append(html);
                $("#reportbox" + ID).hide();
            }
        });
    }
    return false;
});
$('.commentopen').live("click", function () {
    var ID = $(this).attr("id");
    $("#commentbox" + ID).slideToggle('slow');
    $("#ctextarea" + ID).focus();;
    return false;
});
$('.flagopen').live("click", function () {
    var ID = $(this).attr("id");
    $("#reportbox" + ID).slideToggle('slow');
    $("#reportbox" + ID).focus();
    return false;
});
$('.stcommentdelete').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'com_id=' + ID;
    if (jConfirm('<?php echo $lang['Can you confirm this'];?>?', '<?php echo $lang['Confirmation Dialog'];?>')) {
        $.ajax({
            type: "POST",
            url: "action/delete_comment_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
				alert("<?php echo $lang['Seccessfully deleted'];?>");
                $("#stcommentbody" + ID).slideUp();
            }
        });
    }
    return false;
});
$('.stdelete').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'msg_id=' + ID;
    if (jConfirm('<?php echo $lang['Can you confirm this'];?>?', '<?php echo $lang['Confirmation Dialog'];?>')) {
        $.ajax({
            type: "POST",
            url: "action/delete_post_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
				alert("<?php echo $lang['Seccessfully deleted'];?>");
                $("#stbody" + ID).slideUp();
            }
        });
    }
    return false;
});
//delete reply from wall
$('.streplydelete').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'reply_id=' + ID;
   if (jConfirm('<?php echo $lang['Can you confirm this'];?>?', '<?php echo $lang['Confirmation Dialog'];?>')) {
        $.ajax({
            type: "POST",
            url: "action/delete_reply_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
				alert("<?php echo $lang['Seccessfully deleted'];?>");				
                $("#streplybody" + ID).hide();
            }
        });
    }
    return false;
});
//delete reply from wall
$('.reply-reply-delete').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'reply_id=' + ID;
    if (jConfirm('<?php echo $lang['Can you confirm this'];?>?', '<?php echo $lang['Confirmation Dialog'];?>')) {
        $.ajax({
            type: "POST",
            url: "action/delete_reply-reply_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
				alert("<?php echo $lang['Seccessfully deleted'];?>");				
                $("#reply-reply-body" + ID).hide();
            }
        });
    }
    return false;
});
$('.replyopen').live("click", function () {
    var ID = $(this).attr("id");
    $("#replybox" + ID).slideToggle('slow');
    $("#rtextarea" + ID).focus();
    return false;
});
$('.reply_button').live("click", function () {
    var ID = $(this).attr("id");
    var comment = $("#rtextarea" + ID).val();
    var uname = $(this).attr("title");
    var mem_id = $(this).attr("abcd");
    var dataString = 'reply=' + comment + '&comment_id=' + ID + '&uname=' + uname + '&mem_id=' + mem_id;
    if (comment == '') {
        alert("<?php echo $lang['Please Enter reply Text'];?>");
    } else {
        $.ajax({
            type: "POST",
            url: "action/reply_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
            alert(ID);
                $("#replyload" + ID).append(html);
                $("#rtextarea" + ID).val('');
                $("#replybox" + ID).hide();
            }
        });
    }
    return false;
});
//reply@reply box open
$('.reply-replyopen').live("click", function () {
    var ID = $(this).attr("id");
    $("#reply-reply-update" + ID).slideToggle('slow');
    $("#reply-reply" + ID).focus();
    return false;
});
//repy@reply
$('.reply-reply').live("click", function () {
    var ID = $(this).attr("id");
    var comment = $("#reply-reply" + ID).val();
    var uname = $(this).attr("title");
    var mem_id = $(this).attr("abcd");
    var dataString = 'reply=' + comment + '&reply_id=' + ID + '&uname=' + uname + '&mem_id=' + mem_id;	
    if (comment == '') {
        alert("<?php echo $lang['Please Enter reply Text'];?>");
    } else {
        $.ajax({
            type: "POST",
            url: "action/reply-reply-ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#reply-reply-load" + ID).prepend(html);
                $("#reply-reply" + ID).val('');
                $("#reply-reply-update" + ID).hide();
                $("#replybox" + ID).hide();
            }
        });
    }
    return false;
});

$('.share_open').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'msg_id=' + ID;
    $.ajax({
        type: "POST",
        url: "load_data/share_info.php",
        data: dataString,
        cache: false,
        success: function (html) {
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
$('#image').die('click').live('change', function () {
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
$('.bmsg').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'member_id=' + ID;
    $.ajax({
        type: "POST",
        url: "load_data/bday_data.php",
        data: dataString,
        cache: false,
        success: function (html) {
            $(".bpopup").show();
            $(".bdaybody").append(html);
        }
    });
    return false;
});
$('.ViewComments').live("click", function () {
    var id = $(this).attr('id');
    var total_comments = $("#totals-" + id).val();
    var dataString = "postId=" + id + "&totals=" + total_comments;
    $("#loader-" + id).html('<img src="images/loader1.gif" alt="" />');
    $.ajax({
        type: "POST",
        url: "load_data/view_comments.php",
        data: dataString,
        cache: false,
        success: function (html) {
            $('#commentload' + id).prepend(html);
            $('#collapsed-' + id).hide();
        }
    });
    return false;
});
//fetch more replys
$('.ViewReply').live("click",function () {
    var parent = $(this).parent();   
    var getID = parent.attr('id').replace('replycollapsed-', '');
    var total_comments = $("#replytotals-" + getID).val();
	 var dataString = "postId=" + getID + "&totals=" + total_comments;
    $("#loader-" + getID).html('<img src="images/loader1.gif" alt="" />');
	$.ajax({
        type: "POST",
        url: "load_data/view_reply.php",
        data: dataString,
        cache: false,
        success: function (response) {    
        $('#replyload' + getID).prepend(response);
        $('#replycollapsed-' + getID).hide();
		}
    });
	return false;
	});	
// This Function is called after clicking Upload Button.


     
function canclose(valcolse) {
    document.getElementById(valcolse).style.display = "none";
}

function cancelclose(valcolse) {
    document.getElementById(valcolse).style.display = "none";
}

function closereply(valcolse) {
    document.getElementById(valcolse).style.display = "none";
}

</script>