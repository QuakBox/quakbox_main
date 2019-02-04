//Global Variables
 var videoname = "";   //Container For Storing actual trimmed video name with time stamp with Extension.
 var logfileoutput = ""; //logfile of ffmpe conversion
 var logRunningConditionStatus = false;//for preventing set interval jquery post
 var nameWithoutExt = ""; //video name without extension
 var uploadBoolCheck = false;//for preventing page refresh while processing by window unload function
 var DefaultImageThumbnailName = "";//for storing default thumbnail name

function validFBurl(enteredURL) {
  var FBurl = /^(http|https)\:\/\/www.facebook.com\/.*/i;
  if(!enteredURL.match(FBurl)) {
      alert("This is not a Facebook URL");
      }
  else {
      alert("This IS a Facebook URL");
      }
  }
  
$(document).live("click", function() {
   $.ajax({
                type: "POST",
                url:base_url + "check.php",
                
                cache: false,
                success: function (html) {
                  var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                 }
                 
			
            });
});

 
$(document).ready(function () {
$('#likemodal').on('hidden.bs.modal', function() {
    $(this).removeData('bs.modal');
});
//See more500 chars
$(".see_more_link").live('click',function(e) {
    e.preventDefault();
	
	var id = $(this).attr("id");
		$("#id"+id).addClass("text_exposed");
	
});

//video uploadsasaas

$('#video').live('change',function(){

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
             alert(ftype+" Unsupported file type!");
         return false
        
           }
    
       //Allowed file size is less than 1000 MB (1048576 = 1 mb)
       if(fsize> 1048576000) 
       {
         alert(fsize +"Too big file! <br />File is too big, it should be less than 1000 MB.");
         return false
         
       }
         
         $(this).closest('form').trigger('submit'); //this button submits closest form and action page is action/video_upload.php
         $('#uploadPage').hide();//hiding upload page
         
    	 $('#ProcessPage').show();//showing process page
    	 
    	 uploadBoolCheck = true;
    	 
    	
         
    });
    
    $('#update_video').live("click", function(){
    
   uploadBoolCheck = false;
    var member_id = $("#member_id").val();
    var title = $('#title').val();      
    var privacy = $('#video_privacy').val();    
    var country = $("#country").val();
    var video_custom_share = $("#video_custom_share").val();
    var video_custom_unshare = $("#video_custom_unshare").val(); 
    var content_id = $("#content_id").val();
  
    $.post(base_url + 'action/wall-video-upload.php', { title : title , member_id : member_id, privacy: privacy, country: country, video_custom_share : video_custom_share ,video_custom_unshare :video_custom_unshare , defaultthumbnail : DefaultImageThumbnailName, nwe : nameWithoutExt, content_id: content_id }, function(data) {
    uploadBoolCheck = false;
    $("#flash").fadeOut('slow');
                $(".post").prepend(data);
                $("#video").val('');
             $("#video_form").fadeOut('slow');       
	alert("Video upload successfully !!!");
     });
    
    
    
});
    
       
     var bar1 = $('#bar1');
 var percent1 = $('#percent1');
 //progress bar for processing and calling unload function
 setInterval(function(){        
        if(logRunningConditionStatus){
        $.post(base_url + 'action/ffmpegProgRes.php', { logfilepath : logfileoutput }, function(data) {
        
        bar1.width(data);
        percent1.html(data);
        
    }); }
}, 100);

var bar = $('.bar');  
 var percent = $('.percent'); 
  var progress = $('.progress'); 
 var status = $('#status');
$('#update_video').attr('disabled','disabled');
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
            
     $.post(base_url + 'action/video_convert.php', { video_name: videoname, logFile: logfileoutput  }, function(result) {
	alert(result);
	 $('#progress1').hide();
	 logRunningConditionStatus = false;
	 status.html(result);
	 $('#update_video').removeAttr('disabled'); 	 
	}); 
   }  
 });

window.onbeforeunload = function(){
    if(uploadBoolCheck){
        return 'You have unsaved changes!';
    }
}
     
    $(".update_button").live("click", function (e) {
    e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


        var updateval = $("#update").val();
        var str = "data abc";
if((jQuery.trim( updateval )).length==0){
  alert("Please write something"); return false;}

        var country = $("#country").val();
        var member_id = $("#member_id").val();
        var privacy = $("#privacy1").val();
        var share_member_id = $("#photo_custom_share").val();
        var unshare_member_id = $("#photo_custom_unshare").val();
        var uploadvalues = $("#uploadvalues").val();
        var dataString = 'update=' + updateval + '&country=' + country + '&member_id=' + member_id + '&privacy=' + privacy + '&share_member_id=' + share_member_id + '&unshare_member_id=' + unshare_member_id;
        
        
        var matches = updateval.match(/watch\?v=([a-zA-Z0-9\-_]+)/);
		
  var FBurl = updateval.match(/^(http|https)\:\/\/(www|).facebook.com\/.*/i);
  
  
if (FBurl)
{
	alert("Please Enter Other url");
    return false;
}
		if (updateval == '') {
            alert("Please Enter Some Text");
        } else {
            $("#flash").show();
            $("#flash").fadeIn(400).html('Loading Update...');
            $.ajax({
                type: "POST",
                url: base_url + "action/update_ajax.php",
                data: dataString,
                cache: false,
                success: function (html) {
                 
                 var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
               
              $("#update").val('');
                    $("#flash").fadeOut('slow');
                    
                    $(".post").prepend(html);
                    $("#update").val('');
                   
                    $("#stexpand").oembed(updateval);
                    
                }}
                 
			
            });
            $('#my_status').slideUp('fast');
        }
        
        
// Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
        return false;
    });
    
    
    $(".update_image").live("click", function (e) {
    
    e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


        var country = $("#country").val();
        var member_id = $("#member_id").val();
        var privacy = $("#photo_privacy").val();
        var share_member_id = $("#photo_custom_share").val();
        var unshare_member_id = $("#photo_custom_unshare").val();
        var uploadvalues = $("#uploadvalues").val();
        var content_id = $("#content_id").val();
        var X = $('.preview').attr('id');
       
        var description =$("#photo_description").val();
        //alert(description);
        if (X) {
            var Z = X;
        } else {
            var Z = 0;
        }
        if(Z == ''){
        alert("Select image");} else {
        var dataString =  'member_id=' + member_id + '&country=' + country + '&privacy=' + privacy + '&share_member_id=' + share_member_id + '&unshare_member_id=' + unshare_member_id + '&uploads=' + Z + '&content_id=' + content_id + '&description=' + description;
      
        $("#flash").show();
        $("#flash").fadeIn(400).html('Loading Update...');
        $.ajax({
            type: "POST",
            url: base_url +  "action/image_upload_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
            var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            
            
                $("#flash").fadeOut('slow');
                $(".post").prepend(html);
                $('#preview').html('');
                $('#uploadvalues').val('');
                $('#image').val('');
				$("#imageloadbutton").show();
				
            }}
        });
        $("#preview").html();
       $('#myphoto').slideUp('fast');
        
        alert("Image upload successfully !!!");
        }
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
        return false;
    });
});

//comment post code start
$('.button22').live("click", function (e) {
e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

    var ID = $(this).attr("id");
    var comment = jQuery.trim($("#ctextarea"+ID).val());	
 
  if(comment.length==0){
  alert("Please write something"); return false;}
   
    var dataString = 'comment=' + comment + '&msg_id=' + ID;
    if (comment == '') {
        alert("Please Enter Comment Text");
    } else {
        $.ajax({
            type: "POST",
            url: base_url + "action/comment_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
              var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            	
               $("#commentload"+ID).append(html);
                $("#ctextarea"+ID).val('');
                $("#commentbox"+ID).hide();  
               
                
                           
                
            }}
        });
    }
    // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});





$('.report').live("click", function (e) {
    e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


    var ID = $(this).attr("id");
    var comment = $("#rptextarea" + ID).val();
    if((jQuery.trim( comment )).length==0){
  alert("Please write something"); return false;}

    var dataString = 'report=' + comment + '&msg_id=' + ID;
    if (comment == '') {
        alert("Please Enter Comment Text");
    } else {
        $.ajax({
            type: "POST",
            url: base_url +  "action/report_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
             var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            
            
                $("#commentload" + ID).append(html);
                $("#reportbox" + ID).hide();
            }}
        });
    }
    


// Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});
$('.commentopen').live("click", function () {
    var ID = $(this).attr("id");
    $("#commentbox" + ID).slideToggle('slow');
    $("#ctextarea" + ID).focus();;
    return false;
});
$('.cometchat_closebox').live("click", function () {
$("#container_smilies").hide();
});
$('.flagopen').live("click", function () {
    var ID = $(this).attr("id");
    $("#reportbox" + ID).slideToggle('slow');
    $("#reportbox" + ID).focus();
    return false;
});
$('.stcommentdelete').live("click", function (e) {
e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


    var ID = $(this).attr("id");
    var dataString = 'com_id=' + ID;
   jConfirm('Are you sure you want to delete this?', 'Delete comment', function(r)  {
   if(r == true){
        $.ajax({
            type: "POST",
            url: base_url +  "action/delete_comment_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
            
             var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            
            
				alert("Successfully deleted");
                $("#stcommentbody" + ID).slideUp();
            }}
        });
     } return false;
    });
    
// Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});
$('.stdelete').live("click", function (e) {
    e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click

    var ID = $(this).attr("id");
    var dataString = 'msg_id=' + ID;
    jConfirm('Are you sure you want to delete this?', 'Delete Post', function(r)  {   
    if(r == true){
        $.ajax({
            type: "POST",
            url: base_url +  "action/delete_post_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {	
             var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            			
                $("#stbody" + ID).slideUp();
            }}
        });
    
    

    } return false;
    });
    
// Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    }
    else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});

//Delete img from album
$('.stdeleteimg').live("click", function (e) {
    e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click

    var ID = $(this).attr("id");
    var dataString = 'msg_id=' + ID;
    jConfirm('Are you sure you want to delete this?', 'Delete Photo', function(r)  {   
    if(r == true){
        $.ajax({
            type: "POST",
            url: base_url +  "action/delete_photo_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {	
             var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            			
                $("#stbody" + ID).slideUp();
            }}
        });
    
    

    } return false;
    });
    
// Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    }
    else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});

//Delete album
		
		 $('.stdeletealb').live("click", function (e) {
	
	  var ID = $(this).attr("id");
    var USERNAME = $(this).attr("user_id");
    
    var dataString = 'msg_id=' + ID;
    $.ajax({
            type: "POST",
           url: base_url +  "action/delete_album.php",
            data: dataString,
            cache: false,
            success: function (html) {	
            
            // var test = html;
                 
              //  if(test == 1)
               // {
                
               // window.location.assign(base_url + "photos/" + USERNAME );
                //}
                //else
                //{
            			
                //$("#stbody" + ID).slideUp();
            //}
            },
            complete:  function () {
            
            window.location.assign(base_url +"photos/" + USERNAME );
            }
            
        });
    
});


		

//delete reply from wall
$('.streplydelete').live("click", function (e) {
    e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click

    var ID = $(this).attr("id");
    var dataString = 'reply_id=' + ID;
   jConfirm('Are you sure you want to delete this?', 'Delete reply', function(r)  {
   if(r == true){
        $.ajax({
            type: "POST",
            url: base_url +  "action/delete_reply_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
             var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
                       
		alert("Successfully deleted");				
                $("#streplybody" + ID).hide();
            }}
        });
   }
   });
   // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});
//delete reply from wall
$('.reply-reply-delete').live("click", function (e) {
    e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


    var ID = $(this).attr("id");
    var dataString = 'reply_id=' + ID;
    jConfirm('Are you sure you want to delete this?', 'Delete reply', function(r)  {
   if(r == true){
        $.ajax({
            type: "POST",
            url: base_url +  "action/delete_reply-reply_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
            
            var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            
		$("#reply-reply-body" + ID).hide();
				alert("Successfully deleted");				
                
            }}
        });
    }
    });
    // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});
$('.replyopen').live("click", function () {
    var ID = $(this).attr("id");
    $("#replybox" + ID).slideToggle('slow');
    $("#rtextarea" + ID).focus();
    return false;
});
$('.reply_button').live("click", function (e) {
    e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


    var ID = $(this).attr("id");
    var comment = $("#rtextarea" + ID).val();
    if((jQuery.trim( comment )).length==0){
  jAlert('Please Enter reply Text.', 'Reply Is Empty'); return false;}
    var uname = $(this).attr("title");
    var mem_id = $(this).attr("abcd");
    var dataString = 'reply=' + comment + '&comment_id=' + ID + '&uname=' + uname + '&mem_id=' + mem_id;
    if (comment == '') {
        alert("Please Enter reply Text");
    } else {
        $.ajax({
            type: "POST",
            url: base_url +  "action/reply_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
             var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            
            
                $("#replyload" + ID).append(html);
                $("#rtextarea" + ID).val('');
                $("#replybox" + ID).hide();
            }}
        });
    }
    // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
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
$('.reply_reply_button').live("click", function (e) {
    e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click

    var ID = $(this).attr("id");
    var comment = $("#reply-reply" + ID).val();
    if((jQuery.trim(comment)).length==0){
  jAlert('Please Enter reply Text.', 'Reply Is Empty'); return false;}
    var uname = $(this).attr("title");
    var mem_id = $(this).attr("abcd");
    var dataString = 'reply=' + comment + '&reply_id=' + ID + '&uname=' + uname + '&mem_id=' + mem_id;	
    if (comment == '') {
        alert("Please Enter reply Text");
    } else {
        $.ajax({
            type: "POST",
            url: base_url +  "action/reply-reply-ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
             var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            
                $("#reply-reply-load" + ID).prepend(html);
                $("#reply-reply" + ID).val('');
                $("#reply-reply-update" + ID).hide();
            }}
        });
    }
    

// Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});

$('.share_open').live("click",function (e) {
e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        //for resetting form and values
        $('#shareform')[0].reset();
	$('#countries').val('').trigger('chosen:updated');
	$("#group_name").tokenInput("clear");
	$("#friend_name").tokenInput("clear");
	$(".share_body").empty();
	$('#mydiv3').empty();
	$("#shareSubmitButtonID").removeAttr('disabled');
	$("#mvm").show();
	$("#hiddenIDForSelection").attr("value" , "0");
	$("#mvm1").hide();
	$("#mvm2").hide();

        var ID = $(this).attr("id");
        var rowtype = $(this).attr("rowtype");
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
        url: base_url +  "load_data/share_info.php",
        data: dataString,
        cache: false,
        success: function (html) {
        
        var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            $("#shareSubmitButtonID").attr("value",rowTypeValue );
            $(".share_popup").show();
            $(".share_body").append(html);
			$('#mydiv3').share({
        //networks: ['facebook','pinterest','googleplus','twitter','linkedin','tumblr','in1','stumbleupon','digg'],
        networks: ['facebook','pinterest','googleplus','twitter','linkedin'],        
        urlToShare: base_url +'fetch_posts.php?id='+ID
       
    });
    
    $('#mydiv3').append("<img id='email' src='images/sendemail.png' height='40' width='40' alt='Send Email' title='Send Email' onclick='showform()' class='pop share-icon'>");
    $('#email').css('cursor', 'pointer');
        }}
    });
    
        
        

        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});

$('.update_image').attr('disabled','disabled');
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
			$('.update_image').removeAttr('disabled');
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

//add share using jquery
$('#shareSubmitButtonID').live('click', function () {
//alert('hii');
    var friend_name = $("#friend_name").val();
    var group_name = $("#group_name").val();
    var countries = $("#countries").val();
    var privacy= $("#privacy")[0].selectedIndex;
    if(privacy == 0){
    if(friend_name == ''){
    jAlert('You must provide a recipient for your shared item.', 'No Recipient');
    return false;
    }
    } else if(privacy == 1){
    if(group_name == ''){
    jAlert('You must provide a recipient for your shared item.', 'No Recipient');return false;
    }
    }else if(privacy == 2){
    if(countries == null){
    jAlert('You must provide a recipient for your shared item.', 'No Recipient');return false;
    }
    }
    $('#shareSubmitButtonID').attr('disabled','disabled');	
    //$("#previeww").html('<img src="wall_icons/loader.gif"/>');
    $("#shareform").ajaxForm({        
        success: function () {
            $(".share_popup").hide();
            jAlert('Share successfully.', 'Share');           
        },
        error: function () {
            $("#imageloadstatus").hide();            
        }
    }).submit();
    
});


$('.bmsg').live("click", function (e) {
    e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


    var ID = $(this).attr("id");
    var dataString = 'member_id=' + ID;
    $.ajax({
        type: "POST",
        url: base_url +  "load_data/bday_data.php",
        data: dataString,
        cache: false,
        success: function (html) {
        var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
        
            $(".bpopup").show();
            $(".bdaybody").append(html);
        }}
    });
    
// Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});
$('.ViewComments').live("click", function (e) {
    
    e.preventDefault();

if (!$(this).data('isClicked')) {
var link = $(this);

// Your code on successful click
    var id = $(this).attr('id');
    var total_comments = $("#totals-" + id).val();
    var dataString = "postId=" + id + "&totals=" + total_comments;
    $("#loader-" + id).html('<img src="images/loader1.gif" alt="" />');
    $.ajax({
        type: "POST",
        url: base_url +  "load_data/view_comments.php",
        data: dataString,
        cache: false,
        success: function (html) {
        var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
        
            $('#commentload' + id).prepend(html);
            $('#collapsed-' + id).hide();
        }}
    });
    
    // Set the isClicked value and set a timer to reset in 3s
link.data('isClicked', true);
setTimeout(function() {
link.removeData('isClicked')
}, 3000);
} else {
// Anything you want to say 'Bad user!'
}
    
    return false;
});

//fetch more replys
$('.ViewReply').live("click",function (e) {
e.preventDefault();

if (!$(this).data('isClicked')) {
var link = $(this);

// Your code on successful click

    var parent = $(this).parent();
    var getID = parent.attr('id').replace('replycollapsed-', '');
    var total_comments = $("#replytotals-" + getID).val();
	 var dataString = "postId=" + getID + "&totals=" + total_comments;
    $("#loader-" + getID).html('<img src="images/loader1.gif" alt="" />');
	$.ajax({
        type: "POST",
        url: base_url +  "load_data/view_reply.php",
        data: dataString,
        cache: false,
        success: function (response) { 
        var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {   
        $('#replyload' + getID).prepend(response);
        $('#replycollapsed-' + getID).hide();
		}}
    });
    
    // Set the isClicked value and set a timer to reset in 3s
link.data('isClicked', true);
setTimeout(function() {
link.removeData('isClicked')
}, 3000);
} else {
// Anything you want to say 'Bad user!'
}
	return false;
	});	
// This Function is called after clicking Upload Button.
$('.translateButton').click(function (event) {
        var ID = $(this).attr('id');
        var sid = ID.split("translateButton");
        var New_ID = sid[1];
        var optionss = 1;
        fillList(Microsoft.Translator.Widget.GetLanguagesForTranslateLocalized(), New_ID, optionss);        
        $('#translatemenu' + New_ID).toggle(300);
        event.stopPropagation();
    });

     
function canclose(valcolse) {
var ID = valcolse;
        var sid = ID.split("reportbox");
        var New_ID = sid[1];
    document.getElementById(valcolse).style.display = "none";
    document.getElementById("rptextarea"+New_ID).innerHTML="";
}

function cancelclose(valcolse) {
var ID = valcolse;
        var sid = ID.split("commentbox");
        var New_ID = sid[1];        
    document.getElementById(valcolse).style.display = "none";
    document.getElementById("ctextarea"+New_ID).innerHTML="";
}

function closereply(valcolse) {
var ID = valcolse;
        var sid = ID.split("replybox");
        var New_ID = sid[1];		
    document.getElementById(valcolse).style.display = "none";
    document.getElementById("rtextarea"+New_ID).value="";
}
function closereplyreply(valcolse) {	
var ID = valcolse;
        var sid = ID.split("reply-reply-update");
        var New_ID = sid[1];  
    document.getElementById("reply-reply"+New_ID).value = "";
    document.getElementById(valcolse).style.display = "none";
    
}
//smiley panel start
function show(id)
{
	//alert(id);
	$("#currentid").val(id);
	//alert('hi');
	$("#vinod").show();
	var scrol=$(document).scrollTop();
		//alert(scrol);
		$("#vinod").css('top', scrol+300);
}


function showsmiley(id){    
    $("#currentid").val(id);    
    var smiley_top = $(window).scrollTop();
    smiley_top = smiley_top + 150;
    $("#container_smilies").css("top",smiley_top);
    $("#container_smilies").show();
    
}

function closesmiley()
{
	$("#vinod").hide();
}

function addsmiley(text){
	
	var currentid=$("#currentid").val();
	var string = $('#ctextarea'+ currentid).val();	
					if (string.charAt(string.length-1) == ' ') {
						$('#ctextarea'+ currentid).val($('#ctextarea' + currentid).val()+text);
					} else {
						if (string.length == 0) {
							$('#ctextarea' + currentid).val(text);
						} else {
							$('#ctextarea' + currentid).val($('#ctextarea'+ currentid).val()+' '+text);
						}
					}
					
					$('#ctextarea'+ currentid).focus();
							
	
}

function checkdata(id)
{
	//alert(id);
	var str=id.split('ctextarea');
	//alert(str[1]);
	var typecontent=$("#"+id).text();
	//alert(typecontent);
	$("#showimg2_"+str[1]).text(typecontent);
}