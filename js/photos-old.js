$('.commentMark').livequery("focus", function(e){
			
			var parent  = $('.commentMark').parent();
			$(".commentBox").children(".commentMark").css('width','320px');
			$(".commentBox").children("a#SubmitComment").hide();
			$(".commentBox").children(".CommentImg").hide();			
		
			var getID =  parent.attr('id').replace('record-','');			
			$("#commentBox-"+getID).children("a#SubmitComment").show();
			$('.commentMark').css('width','300px');
			$("#commentBox-"+getID).children(".CommentImg").show();			
		});	
		
		//showCommentBox
		$('a.showCommentBox').livequery("click", function(e){
			
			var getpID =  $(this).attr('id').replace('post_id','');	
			
			$("#commentBox-"+getpID).css('display','');
			$("#commentMark-"+getpID).focus();
			$("#commentBox-"+getpID).children("CommentImg").show();			
			$("#commentBox-"+getpID).children("a#SubmitComment").show();		
		});	
		
		//SubmitComment
		$('a.comment').livequery("click", function(e){
			
			var getpID =  $(this).parent().attr('id').replace('commentBox-','');	
			var comment_text = $("#commentMark-"+getpID).val();
			
			if(comment_text != "Write a comment...")
			{
				$.post("add_photo_comment.php?comment_text="+comment_text+"&post_id="+getpID, {
	
				}, function(response){
					
					$('#CommentPosted'+getpID).append($(response).fadeIn('slow'));
					$("#commentMark-"+getpID).val("Write a comment...");					
				});
			}
			
		});	
		
		//more records show
		$('a.more_records').livequery("click", function(e){
			
			var next =  $('a.more_records').attr('id').replace('more_','');
			
			$.post("posts.php?show_more_post="+next, {

			}, function(response){
				$('#bottomMoreButton').remove();
				$('#posting').append($(response).fadeIn('slow'));

			});
			
		});	
		
		//deleteComment
		$('a.c_delete').livequery("click", function(e){
			
			if(confirm('Are you sure you want to delete this comment?')==false)

			return false;
	
			e.preventDefault();
			var parent  = $('a.c_delete').parent();
			var c_id =  $(this).attr('id').replace('CID-','');	
			
			$.ajax({

				type: 'get',

				url: 'delete_comment.php?c_id='+ c_id,

				data: '',

				beforeSend: function(){

				},

				success: function(){

					parent.fadeOut(200,function(){

						parent.remove();
						location.reload();

					});

				}

			});
		});	
		
		/// hover show remove button
		$('.friends_area').livequery("mouseenter", function(e){
			$(this).children("a.delete").show();	
		});	
		$('.friends_area').livequery("mouseleave", function(e){
			$('a.delete').hide();	
		});	
		/// hover show remove button
		
		
		$('a.delete').livequery("click", function(e){

		if(confirm('Are you sure you want to delete this post?')==false)

		return false;

		e.preventDefault();

		var parent  = $('a.delete').parent();

		var temp    = parent.attr('id').replace('record-','');

		var main_tr = $('#'+temp).parent();

			$.ajax({

				type: 'get',

				url: 'delete.php?id='+ parent.attr('id').replace('record-',''),

				data: '',

				beforeSend: function(){

				},

				success: function(){

					parent.fadeOut(200,function(){

						main_tr.remove();
						location.reload();

					});

				}

			});

		});

		$('textarea').elastic();

		jQuery(function($){

		   $("#watermark").Watermark("What's on your mind?");
		   $(".commentMark").Watermark("Write a comment...");

		});

		jQuery(function($){

		   $("#watermark").Watermark("watermark","#369");
		   $(".commentMark").Watermark("watermark","#EEEEEE");

		});	

		function UseData(){

		   $.Watermark.HideAll();

		   //Do Stuff

		   $.Watermark.ShowAll();

		}
		

		
document.getElementById('imageDiv').style.visibility='hidden';


$('.like').die('click').live("click",function() 
{	
var ID = $(this).attr("id");
var sid=ID.split("like"); 
var New_ID=sid[1];

var REL = $(this).attr("rel");
var URL='load_data/photo_like_ajax.php';
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

$('.like1').die('click').live("click",function() 
{	
var ID = $(this).attr("id");
var sid=ID.split("like1"); 
var New_ID=sid[1];

var REL = $(this).attr("rel");
var URL='load_data/photo_comment_like_ajax.php';
var dataString = 'msg_id=' + New_ID +'&rel='+ REL;
$.ajax({
type: "POST",
url: URL,
data: dataString,
cache: false,
success: function(html){

if(REL=='Like')
{
$("#youlike"+New_ID).slideDown('slow').prepend("<span id='you1"+New_ID+"'><a href='#'>You</a> like this.</span>.");
$("#likes"+New_ID).prepend("<span id='you"+New_ID+"'><a href='#'>You</a>, </span>");
$('#'+ID).html('Unlike').attr('rel', 'Unlike').attr('title', 'Unlike');
}
else
{
$("#youlike"+New_ID).slideUp('slow');
$("#you1"+New_ID).remove();
$('#'+ID).attr('rel', 'Like').attr('title', 'Like').html('Like');
}
}
});
});




	$(document).ready(function(){	
	
	
	$(".settings-button").click(function()
{
var X=$(this).attr('title');
//alert(X);
var H=$(this).attr('value');
//alert(H);
//document.getElementById("submenuhidden").value=H;

if(X==1)
{
$("#"+H+"-submenu12").hide();
$(this).attr('title', '0');	
}
else
{

$("#"+H+"-submenu12").show();
$(this).attr('title', '1');
}
	
});
//var M=document.getElementById("submenuhidden").value;
//alert(M);
//Mouseup textarea false
$(".submenu12").mouseup(function()
{
return false
});
$(".settings-button").mouseup(function()
{
return false
});


//Textarea without editing.
$(document).mouseup(function()
{
$(".submenu12").hide();
$(".settings-button").attr('title', '');
});
	

	
$('.edit_link').click(function()
{
var ID = $(this).attr("id");

$('#text_wrapper'+ID).hide();
var data=$('#text_wrapper'+ID).html();

$('#edit'+ID).show();
$('#editbox'+ID).html(data);
$('#editbox'+ID).focus();

});

$(".editbox").mouseup(function() 
{
return false
});

$(".editbox").change(function() 
{
var ID = $(this).attr("id");
var sid=ID.split("editbox"); 
var New_ID=sid[1];
$('.edit').hide();
var boxval = $("#editbox"+New_ID+"").val();
var dataString = 'data='+ boxval +'&c_id=' +New_ID;
$.ajax({
type: "POST",
url: "load_data/update_comment_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$('#text_wrapper'+New_ID+'').html(boxval);
$('.text_wrapper').show();

}
});

});


$('.delete_album').click(function() 
{
	return confirm("Are you sure you want to delete this album?");
});

});