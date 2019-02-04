// JavaScript Document
//Global Variables
 var videoname="";   //Container For Storing actual trimmed video name with time stamp with Extension.
 var logfileoutput = ""; //logfile of ffmpe conversion
 var logRunningConditionStatus = false;//for preventing set interval jquery post
 var nameWithoutExt = ""; //video name without extension
 var uploadBoolCheck = false;//for preventing page refresh while processing by window unload function
 var DefaultImageThumbnailName = "";//for storing default thumbnail name
$(document).ready(function() {
//video upload script start	
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
    
    $('#update_video').click(function(){
		uploadBoolCheck = false;
    var member_id = $("#member_id").val();
    var title = $('#title').val();
	var event_id = $('#event_id').val();
  
    $.post(base_url + 'action/event_video_insert.php', { title : title , member_id : member_id, defaultthumbnail : DefaultImageThumbnailName, nwe : nameWithoutExt,event_id : event_id }, function(data) {
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
	 $('#progress1').hide();
	 logRunningConditionStatus = false;
	 status.html(result);
	 $('#update_video').removeAttr('disabled'); 	 
	}); 
   }  
 });
 
 //video upload script end
 	
$('.like').live("click",function() 
{
		
var ID = $(this).attr("id");
var sid=ID.split("like"); 
var New_ID=sid[1];

var REL = $(this).attr("rel");
var URL = base_url + 'action/event_wall_like_ajax.php';
var dataString = 'msg_id=' + New_ID +'&rel='+ REL;
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){

if(REL=='Like')
{
$("#youlike"+New_ID).slideDown('slow').prepend("<span id='you"+New_ID+"'><a href='#'>You</a> like this.</span>.");
$("#likes"+New_ID).prepend("<span id='you"+New_ID+"'><a href='#'>You</a>, </span>");
$('#'+ID).html('Unlike').attr('rel', 'Unlike').attr('title', 'Unlike');
}
else
{
$("#youlike"+New_ID).slideUp('slow');
$("#you"+New_ID).remove();
$('#'+ID).attr('rel', 'Like').attr('title', 'Like').html('Like');
}
}
});
});

//comment like
$('.comment_like').die('click').live("click",function() 
{
		
var ID = $(this).attr("id");
var sid=ID.split("comment_like"); 
var New_ID=sid[1];

var REL = $(this).attr("rel");
var URL=base_url + 'action/event_wall_comment_like_ajax.php';
var dataString = 'comment_id=' + New_ID +'&rel='+ REL;
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){

if(REL=='Like')
{
$("#youlike"+New_ID).slideDown('slow').prepend("<span id='you"+New_ID+"'><a href='#'>You</a> like this.</span>.");
$("#likes"+New_ID).prepend("<span id='you"+New_ID+"'><a href='#'>You</a>, </span>");
$('#'+ID).html('Unlike').attr('rel', 'Unlike').attr('title', 'Unlike');
}
else
{
$("#youlike"+New_ID).slideUp('slow');
$("#you"+New_ID).remove();
$('#'+ID).attr('rel', 'Like').attr('title', 'Like').html('Like');
}
}
});
});


// Update Status

$(".update_button").click(function() 
{
var updateval = $("#update").val();
var event_id = $("#event_id").val();
var member_id = $("#member_id").val();
var dataString = 'update=' + updateval + '&member_id=' + member_id + '&event_id=' + event_id;

if(updateval=='')
{
alert("Please Enter Some Text");
}
else
{
$("#flash").show();
$("#flash").fadeIn(400).html('Loading Update...');
$.ajax({
type: "POST",
url: base_url + "action/event_post_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$("#flash").fadeOut('slow');
$(".post").prepend(html);
$("#update").val('');	
$("#update").focus();   	
$("#stexpand").oembed(updateval);
window.location.href = window.location.href;
  }
 });
}
return false;
	});

});

//report Submint

$('.report').live("click",function() 
{

var ID = $(this).attr("id");
var comment= $("#rptextarea"+ID).val();
var dataString = 'report='+ comment + '&msg_id=' + ID;

if(comment=='')
{
alert("Please Enter Comment Text");
}
else
{
$.ajax({
type: "POST",
url: base_url + "action/event_wall_report_ajax.php",
data: dataString,
cache: false,
success: function(html){
$("#commentload"+ID).append(html);
$("#reportbox"+ID).hide();
 }
 });
}
return false;
});

// commentopen 
$('.commentopen').live("click",function() 
{
var ID = $(this).attr("id");
$("#commentbox"+ID).slideToggle('slow');
$("#ctextarea"+ID).focus();;
return false;
});

//flagopen
$('.flagopen').live("click",function() 
{
var ID = $(this).attr("id");
$("#reportbox"+ID).slideToggle('slow');
$("#reportbox"+ID).focus();
return false;
});

// delete update
$('.stdelete').live("click",function() 
{
var ID = $(this).attr("id");
var dataString = 'msg_id='+ ID;

if(confirm("Sure you want to delete this update? There is NO undo!"))
{

$.ajax({
type: "POST",
url: base_url + "action/event_wall_delete_ajax.php",
data: dataString,
cache: false,
success: function(html){
 $("#stbody"+ID).slideUp();
 }
 });
}
return false;
});

// delete comment
$('.stcommentdelete').live("click",function() 
{
var ID = $(this).attr("id");
var dataString = 'com_id='+ ID;

if(confirm("Sure you want to delete this update? There is NO undo!"))
{

$.ajax({
type: "POST",
url: base_url + "action/event_wall_comment_delete_ajax.php",
data: dataString,
cache: false,
success: function(html){
 $("#stcommentbody"+ID).slideUp();
 }
 });

}
return false;
});

// delete reply
$('.streplydelete').live("click",function() 
{
var ID = $(this).attr("id");
var dataString = 'reply_id='+ ID;

if(confirm("Sure you want to delete this update? There is NO undo!"))
{

$.ajax({
type: "POST",
url: base_url + "action/event_wall_comment_reply_delete_ajax.php",
data: dataString,
cache: false,
success: function(html){
	
 $("#streplybody"+ID).slideUp();
 }
 });
}
return false;
});
//delete reply@reply from wall
$('.reply-reply-delete').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'reply_id=' + ID;
    if(confirm('Do you want Delete this?', 'Confirmation Dialog')) {
        $.ajax({
            type: "POST",
            url: base_url +  "action/event_delete_reply-reply_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
				alert("Seccessfully deleted");				
                $("#reply-reply-body" + ID).hide();
            }
        });
    }
    return false;
});

// commentreply 
$('.replyopen').live("click",function() 
{
var ID = $(this).attr("id");
$("#replybox"+ID).slideToggle('slow');
$("#rtextarea"+ID).focus();
return false;
});

//reply Submint

$('.reply_button').live("click",function() 
{

var ID = $(this).attr("id");
var comment= $("#rtextarea"+ID).val();
var dataString = 'reply='+ comment + '&comment_id=' + ID;

if(comment=='')
{
alert("Please Enter reply Text");
}
else
{
$.ajax({
type: "POST",
url: base_url + "action/event_wall_comment_reply_ajax.php",
data: dataString,
cache: false,
success: function(html){
$("#replyload"+ID).append(html);
$("#rtextarea"+ID).val('');
$("#replybox"+ID).hide();
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
        alert("Please Enter reply Text");
    } else {
        $.ajax({
            type: "POST",
            url: base_url + "action/event_wall_reply-reply-ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#reply-reply-load" + ID).prepend(html);
                $("#reply-reply" + ID).val('');
                $("#reply-reply-update" + ID).hide();
            }
        });
    }
    return false;
});

//view more comments
$('.ViewComments').live("click", function () {
    var id = $(this).attr('id');
    var total_comments = $("#totals-" + id).val();
    var dataString = "postId=" + id + "&totals=" + total_comments;
    $("#loader-" + id).html('<img src="'+base_url+'images/loader1.gif" alt="" />');
    $.ajax({
        type: "POST",
        url: base_url +  "load_data/view_comments.php",
        data: dataString,
        cache: false,
        success: function (html) {
            $('#commentload' + id).prepend(html);
            $('#collapsed-' + id).hide();
        }
    });
    return false;
});

//view more reply
//fetch more replys
$('.ViewReply').live("click",function () {
    var parent = $(this).parent();
    var getID = parent.attr('id').replace('replycollapsed-', '');
    var total_comments = $("#replytotals-" + getID).val();
	 var dataString = "postId=" + getID + "&totals=" + total_comments;
    $("#loader-" + getID).html('<img src="'+base_url+'images/loader1.gif" alt="" />');
	$.ajax({
        type: "POST",
        url: base_url +  "load_data/event_view_reply.php",
        data: dataString,
        cache: false,
        success: function (response) {    
        $('#replyload' + getID).prepend(response);
        $('#replycollapsed-' + getID).hide();
		}
    });
	return false;
	});	

//unload funtion
window.onbeforeunload = function(){
	if(uploadBoolCheck){
	    return 'You have unsaved changes!';
	}
}
function canclose(valcolse){	
  document.getElementById(valcolse).style.display="none";
}
function cancelclose(valcolse){	
  document.getElementById(valcolse).style.display="none";
}
function closereply(valcolse){	
  document.getElementById(valcolse).style.display="none";
}
function closereplyreply(valcolse) {	
    document.getElementById(valcolse).style.display = "none";
}