<?php 
	ob_start();
	session_start();
	@$last_msg_id=$_GET['last_msg_id'];
	@$action=$_GET['action'];

//if($action <> "get")

//{
		
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	require_once('config.php');
	require_once('includes/time_stamp.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QuakBox</title>
<head>
<?php include('includes/files.php');?>
<script type="text/javascript">
$(document).ready(function() {

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
               		                 console.log(data);
					extracted_images = data.images;
					total_images = parseInt(data.images.length-1);
					img_arr_pos = total_images;
					
					
					// video 
					extracted_videos = data.videos;
					total_videos = parseInt(data.videos.length-1);
					video_arr_pos = total_videos;
						
					if(total_images>0){
						inc_image = '<div class="extracted_thumb" id="extracted_thumb"><img src="'+data.images[img_arr_pos]+'" width="200" height="150" align="center"></div>';
					}else{
						inc_image ='';
					}
					
					if(total_videos>0){
						//inc_video=';	
						var content = '<div class="extracted_url"><div class="extracted_content" style="padding-bottom:3px"><h4><a href="'+extracted_url+'" target="_blank">'+data.title+'</a></h4></div><div class="extracted_thumb" id="extracted_thumb"><iframe frameborder="0" src="'+data.videos[2]+'" width="200" height="150" align="center"></iframe></div><p>'+data.content+'</p></div>';
						
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
			$("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="120" height="120">');
			
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
			$("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="120" height="120">');
			
			//replace thmubnail position text
			$("#total_imgs").html((img_arr_pos) +' of '+ total_images);
		}
		
	});
	
	// div refresh on every 5 min for cmnt placing .... 
 		setInterval(function() {
					$.post('pageRefresh.php', function(data){  
						if(data!=null) {       
						// status photo,videos star here 'type'=>$type,'messages'=>$messages,'messages_id'
						if(data.messages!=null) {
                            msg = data.messages;
					  	    mid = data.messages_id;
						    totals = parseInt(data.messages.length-1);
                                                 
                          //  console.debug("row"+totals);                  
							for(i=0;i<=totals;i++) {
					            //console.debug("vj");
								var items = [];
								items.push("<div class='stbody' id='#stbody"+mid[i]+"'>");
								items.push("<div class='stimg'><a href='member_profile.php?member_id="+data.member_id[i] + "'><img src='"+data.profile_pic[i] + "' class='big_face'/></a></div>");
								items.push('<div class="sttext"><a href="member_profile.php?member_id='+data.member_id[i]+'"><b>'+data.username[i]+'</b></a>');
								if($("#country").val()!="") {
								items.push('<img style="margin:0px 3px;" src="images/arrow_png.jpg" /> ');
								}
								items.push('<a href="country_wall.php?country='+data.country_flag[i]+'"><b>'+data.country_flag[i]+'</b></a>');
								items.push('<div style="margin:5px 0px;">');
								if(data.type[i]==0) {
								  items.push(msg[i]);
								}
								if(data.type[i]==1) {
								  items.push('<img src="'+msg[i]+'" height="250" width="400" />');
								}
								if(data.type[i]==2) {
								  items.push('<video width="320" height="240" controls><source src="'+msg[i]+'" type="video/mp4">Your browser does not support the video tag</video>');								}
								if(data.type[i]==3) {
								  items.push('<span> Title : <strong> '+data.title[i]+'</strong> </span><embed src="http://www.youtube.com/v/'+data.video[i]+'&hl=en&fs=1&hd=1&showinfo=0&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="350" height="225" wmode="transparent"></embed>');
								}
								items.push("</div>");
								items.push("<div class='sttime'>"+data.stime[i]+"<br><div class='likeUsers' id='elikes"+mid[i]+"'></div></div>");
								items.push('<div id="stexpandbox"><div id="stexpand'+mid[i]+'"></div></div><div class="commentcontainer" id="commentload'+mid[i]+'"> </div><div class="commentupdate" style="display:none" id="commentbox'+mid[i]+'"><div class="stcommentimg"> <img src="profile_photo/Hydrangeas.jpg" class="small_face"> </div><div class="stcommenttext"><form method="post" action=""><textarea name="comment" class="comment" maxlength="200" id="ctextarea'+mid[i]+'"></textarea><br><input value=" Comment " id="'+mid[i]+'" class="button" type="submit"><input value=" Cancel " id="'+mid[i]+'" onclick="cancelclose(\'commentbox'+mid[i]+'\')" class="cancel" type="button"></form></div></div>');
								items.push('<div class="commentupdate" style="display:none" id="reportbox'+mid[i]+'"><div class="stcommentimg"> <img src="profile_photo/Hydrangeas.jpg" class="small_face"> </div><div class="stcommenttext"><form method="post" action=""><textarea name="comment" class="comment" maxlength="200" id="rptextarea'+mid[i]+'" placeholder="Flag this status.."></textarea><br><input value=" Report " id="'+mid[i]+'" class="report" type="submit"><input value=" Cancel " id="'+mid[i]+'" onclick="canclose(\'reportbox'+mid[i]+'\')" class="cancel" type="button"></form></div></div>');
								items.push('<div class="emot_comm"><div id="normal-button" class="settings-button" title="0" value="'+mid[i]+'"> <span style="bottom: 2px;float: left;position: relative;width: 33px;cursor: pointer;" class=""> <img src="images/Glad.png"> </span> </div><div class="submenu12" id="'+mid[i]+'-submenu12" style="display: none; position: absolute; background:#ffffff; margin-top:15px;"> <a href="action/commentpost.php?postid='+mid[i]+'&amp;member_id='+data.member_id[i]+'&amp;postcomment=images/1.jpg&amp;type=2"><img src="images/1.jpg"></a> <a href="action/commentpost.php?postid='+mid[i]+'&amp;member_id='+data.member_id[i]+'&amp;postcomment=images/2.jpg&amp;type=2"><img src="images/2.jpg"></a> <a href="action/commentpost.php?postid='+mid[i]+'&amp;member_id='+data.member_id[i]+'&amp;postcomment=images/3.jpg&amp;type=2"><img src="images/3.jpg"></a> <a href="action/commentpost.php?postid='+mid[i]+'&amp;member_id='+data.member_id[i]+'&amp;postcomment=images/4.jpg&amp;type=2"><img src="images/4.jpg"></a> <a href="action/commentpost.php?postid='+mid[i]+'&amp;member_id='+data.member_id[i]+'&amp;postcomment=images/5.jpg&amp;type=2"><img src="images/5.jpg"></a> <a href="action/commentpost.php?postid='+mid[i]+'&amp;member_id='+data.member_id[i]+'&amp;postcomment=images/6.jpg&amp;type=2"><img src="images/6.jpg"></a> <a href="action/commentpost.php?postid='+mid[i]+'&amp;member_id='+data.member_id[i]+'&amp;postcomment=images/1.gif&amp;type=2"><img src="images/1.gif"></a> </div> <span id="show-cmt1"> <a href="javascript: void(0)" class="like" id="like'+mid[i]+'" title="Like" rel="Like">Like</a></span> <span id="show-cmt1" class="show-cmt"> <a href="javascript:void(0)" id="'+mid[i]+'" class="commentopen">Comment</a> </span> <span id="show-cmt1" class="show-cmt"> <a href="javascript:void(0)" rowtype="'+data.type[i]+'" class="share_open" id="'+mid[i]+'" title="Share">Share</a> </span> <span id="show-cmt1" class="show-cmt"> <a href="javascript:void(0)" id="'+mid[i]+'" class="flagopen">Flag this Status</a> </span> </div>');
								items.push('</div></div>');
								 $(".post").prepend(items.join(''));
								 //console.debug("status posted");
								
							}// for end here
    	                  }// if not null ends here
						  
						  // newly added cmnt	
						 if(data.comments!=null) {// cmnt starts here
                            comment = data.comments;
					  	    pid = data.post_id;
                            totals = parseInt(data.comments.length-1);
                            for(i=0;i<=totals;i++) {
					         	var items = [];
								items.push("<div class='stcommentbody' id='stcommentbody"+data.cmntid[i]+"'>");
								items.push("<div class='stcommentimg'><img src='"+data.cface[i]+"' class='small_face'/></div>");
								items.push("<div class='stcommenttext'><a class='stcommentdelete' href='#' id="+data.cmntid[i]+">X</a><b>"+data.cusername[i]+"</b>"+comment[i]+"<div class='stcommenttime'>"+data.time[i]+"</div></div>");
								items.push('</div>');
								$('#commentload'+pid[i]).append(items.join(''));
								//console.debug("cmnt added");
							}// for end here
    	                  }// if not null ends here

						  // status post liked 
						  if(data.stsliked!=null) {
						    totals = parseInt(data.stsliked.length-1);
                            for(i=0;i<=totals;i++) {
					         	var items = [];
								if(data.stslikedusername[i]=="You") {
									items.push('<span id="you377">You </span> ');
								}else {
									items.push('<a href="'+data.stslikedusername[i]+'">'+data.stslikedusername[i]+' </a>');
								}
								$('#likes'+data.stsliked[i]).append(items.join(''));
								//console.debug("status post liked");
								
							}// for end here
						  }// if ends here
						  
						  // status post liked 
						  if(data.cmntlikes!=null) {
						    totals = parseInt(data.cmntlikes.length-1);
                           	var items = [];
							items.push(totals+' friends like this');
							for(i=0;i<=totals;i++) {
								$('#likes'+data.likecmntid[i]).append(items.join(''));
							}
							//console.debug("cmnt liked");	
						  }// if ends here
						  
					  }// if data null ends	  
					},'json');
					
               }, 15000);
        // pg refresh ends here.....
		
		$("div.image").mouseover(function(){
   $id=$(this).attr('title');
   document.getElementById($id).style.display = "";
}); // end each

	$("div.image").mouseleave(function(){
	$id=$(this).attr('title');
   document.getElementById($id).style.display = "none";
	});	


$(".settings-button").click(function()
{
var X=$(this).attr('title');
var H=$(this).attr('value');

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

//Mouseup textarea false
$(".submenu12").mouseup(function()
{
return false
});
$(".settings-button").mouseup(function()
{
return false
});


}); // documtn ready ends here


// JavaScript Document
function showHide() 
{
				
   if(document.getElementById("privacy").selectedIndex == 1) 
   {
	    document.getElementById("mvm1").style.display = "block"; // This line makes the DIV visible
		document.getElementById("mvm").style.display = "none";
	   	document.getElementById("mvm2").style.display = "none";
   }
   else
   {
	   document.getElementById("mvm1").style.display = "none";	   
   } 
   if(document.getElementById("privacy").selectedIndex == 2)
   {            
        document.getElementById("mvm2").style.display = "block";
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm1").style.display = "none"; 
   }
   else
   {
	   document.getElementById("mvm2").style.display = "none";	   
   }
   
   if(document.getElementById("privacy").selectedIndex == 3)
   {            
        document.getElementById("world").value = "world";
		document.getElementById("mvm2").style.display = "none";
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm1").style.display = "none";
 }
  
   
}

function set_privacy_photo(obj)
{
	if(obj=='photo_privacy_public')
	{		
		document.getElementById("photo_privacy").value = 1;
	}
	else if(obj=='photo_privacy_frineds')
	{
		document.getElementById("photo_privacy").value = 2;
	}
	else
	{
		document.getElementById("photo_privacy").value = 3;
	}
}

function set_privacy(obj)
{
	if(obj=='privacy_public')
	{		
		document.getElementById("privacy1").value = 1;
	}
	else if(obj=='privacy_frineds')
	{
		document.getElementById("privacy1").value = 2;
	}
	else
	{
		document.getElementById("privacy1").value = 3;
	}
}

function set_privacy_url(obj)
{
	if(obj=='url_privacy_public')
	{		
		document.getElementById("url_privacy").value = 1;
	}
	else if(obj=='url_privacy_frineds')
	{
		document.getElementById("url_privacy").value = 2;
	}
	else
	{
		document.getElementById("url_privacy").value = 3;
	}
}

function set_privacy_video(obj)
{
	if(obj=='video_privacy_public')
	{		
		document.getElementById("video_privacy").value = 1;
	}
	else if(obj=='video_privacy_frineds')
	{
		document.getElementById("video_privacy").value = 2;
	}
	else
	{
		document.getElementById("video_privacy").value = 3;
	}
}
function add_custom_privacy()
{
	document.getElementById("popup").style.display = 'block';	
}

$(function() {
$(".submit").click(function() {
	$("#popup").hide();
	var a = $("#post_friend").val();
	var b = $("#unpost_friend").val();
	document.getElementById("photo_custom_share").value = a;
	document.getElementById("photo_custom_unshare").value = b;
	document.getElementById("video_custom_share").value = a;
	document.getElementById("video_custom_unshare").value = b;
	document.getElementById("url_custom_share").value = a;
	document.getElementById("url_custom_unshare").value = b;
	
	document.getElementById("privacy").value = 4;
	document.getElementById("photo_privacy").value = 4;
	document.getElementById("url_privacy").value = 4;
	document.getElementById("video_privacy").value = 4;
});
});
function add_custom_privacy(){	
	document.getElementById('popup').style.display="block";
}

$(function() {
    $(".cancel_custom").click(function() {
	$("#popup").hide();
	});
	
	 $(".cancel_share").click(function() {
	$("#share_popup").hide();
	$(".share_body").children('div').remove();
	});
});

/*	$(function(){
			
		function last_msg_funtion() 
		{ 
		    
           var ID=$(".stbody:last").attr("id");		    
		   var sid=ID.split("stbody"); 
		   var New_ID=sid[1];			
		
			$('div#last_msg_loader').show();
			$.post("logged_in.php?action=get&last_msg_id="+New_ID,
			
			function(data){				
				if (data != "") {
				$(".stbody:last").after(data);			
				}
				$('div#last_msg_loader').empty();
			});
		};  
		
		$(window).scroll(function(){
			if  ($(window).scrollTop() == $(document).height() - $(window).height()){

		 last_msg_funtion();			   
			}
		}); 
		
	});*/

function Checkfiles()
{
var fup = document.getElementById('video');
var fileName = fup.value;
var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

if(ext == "mp4")
{
return true;
} 
else
{
alert("Upload only .mp4 format");
fup.focus();
return false;
}
}

</script>
<style type="text/css">
#popup{
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;	
	background-color: rgba(0,0,0,0.7); /*(255,255,255,0.5);*/
	color:#fff;
}
#share_popup{
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;	
	background-color: rgba(0,0,0,0.7); /*(255,255,255,0.5);*/
	color:#fff;
	z-index:1;
}	

</style>
</head>
<body>
<div id="wrapper">
  <?php //include 'includes/header.php';?>
  <div id="mainbody">
    <div class="column_left">
      <div class="wall_header" style="width:560px;"> <span class="memohead">MEMO</span>
        <div class="rightpanel">
          <div class="rightpanel"> <span id="status_but" class="flatButton"> <a href="javascript:void(0)" style="color: rgb(137, 0, 0); text-decoration:none;"> <img src="images/hand_stift.png" style="margin-right:4px;" /> <span class="inner">Status</span> </a> </span> <span id="photo_but" class="flatButton"> <a href="javascript:void(0)" style="color: rgb(137, 0, 0); text-decoration:none;"> <img src="images/i_photo_small.gif" style="margin-right:4px;" /> <span class="inner">Photo</span> </a> </span> <span id="link_but" class="flatButton"> <a href="javascript:void(0)" style="color: rgb(137, 0, 0); text-decoration:none;"> <img src="images/URL.png" style="margin-right:4px;" /> <span class="inner">Link</span> </a> </span> <span id="video_but" class="flatButton"> <a href="javascript:void(0)" style="color: rgb(137, 0, 0); text-decoration:none;"> <img src="images/video_small.png" style="margin-right:4px;" /> <span class="inner">Video</span> </a> </span> <span id="recent_but" class="flatButton"> <a href="javascript:void(0)" style="color: rgb(137, 0, 0); text-decoration:none;"> <img src="images/resentimages.jpg" style="margin-right:4px;" /> <span class="inner">Recent Activities</span> </a> </span> </div>
        </div>
      </div>
      <div class="column_internal_left">
        <div style="padding: 4px;">
          <!--NEXT status button -->
          <script>
		$( "#status_but" ).click(function() {
		$( "#myphoto" ).hide( 300 );
		$( "#mylink" ).hide( 300 );
		$( "#myvideo" ).hide( 300 );
		$( "#myrecent" ).hide( 300 );
		$( "#my_status" ).toggle( 300 );
		});
		</script>
          <form name="comment" id="comment" method="post">
            <div class="comment1" id="my_status" style="display: none;"> <img id="loading_indicator" src="images/ajax-loader.gif">
              <textarea name="mystatusx" id="update" placeholder="WHAT ARE YOU THINKING"></textarea>
              <input name="member_id" type="hidden" id="member_id" value="<?php echo $member_id;?>"/>
              <input type="hidden" name="country" id="country" value="<?php echo 'world';?>" />
              <input type="hidden" name="privacy" id="privacy1" value="1"/>
              <div id="results"> </div>
              <input type="submit" value="ADD" name="update_button"  class="update_button" style="margin: 6px; background-color: #222; border: 1px solid #000; color: #fff; padding: 2px;"/>
              <div style="display:inline-block; float:right; margin-top:5px;"> <a class="icon-privacy" href="javascript:void(0)" id="status_privacy"> <span style="color:#FFF;">Privacy</span></a>
                <div id="privacy_menu" style="display: none; width:100px; z-index:102; position:absolute; ">
                  <ul class="root">
                    <li> <a href="javascript:void(0)" style="color:#FFF;" class="icon-public" id="privacy_public" onclick="set_privacy('privacy_public')">Public</a> </li>
                    <li > <a href="javascript:void(0)" class="icon-add-friend" id="privacy_frineds" style="color:#FFF;" onclick="set_privacy('privacy_frineds')">Friends</a> </li>
                    <li > <a href="javascript:void(0)" class="icon-privacy" id="privacy_me" style="color:#FFF; background-color:transparent;" onclick="set_privacy('privacy_me')">Only Me</a> </li>
                    <li > <a href="#" title="Custom Privacy" class="icon-custom" style="color:#FFF; background-color:transparent;" onclick="add_custom_privacy()" >Custom</a> </li>
                  </ul>
                </div>
              </div>
            </div>
          </form>
          <!--NEXT photo button -->
          <script>
		$( "#photo_but" ).click(function() {
		$( "#my_status" ).hide( 300 );
		$( "#mylink" ).hide( 300 );
		$( "#myvideo" ).hide( 300 );
		$( "#myrecent" ).hide( 300 );
		$( "#myphoto" ).toggle( 300 );
		});
		</script>
          <form name="comment" id="comment" action="action/home_upload_image.php" method="post" enctype="multipart/form-data">
            <div class="comment1" id="myphoto" style="display: none;">
              <input type="file" name="image" value="" required="required"/>
              <input name="member_id" type="hidden"  value="<?php echo $_SESSION['SESS_MEMBER_ID'];?>"/>
              <input type="hidden" name="country" id="country" value="<?php echo 'world';?>" />
              <input type="hidden" name="photo_custom_share" id="photo_custom_share" />
              <input type="hidden" name="photo_custom_unshare" id="photo_custom_unshare" />
              <input type="hidden" name="privacy" id="photo_privacy" value="1" />
              <input type="submit" value="ADD" name="Add" class="upload_image" style="margin: 6px; background-color: #222; border: 1px solid #000; color: #fff; padding: 2px;"/>
              <div style="display:inline-block; float:right; margin-top:5px;"> <a class="icon-privacy" href="javascript:void(0)" id="privacy2"> <span style="color:#FFF;">Privacy</span></a>
                <div id="photo_privacy_menu" style="display: none; width:100px; z-index:102; position:absolute; ">
                  <ul class="root">
                    <li> <a href="javascript:void(0)" style="color:#FFF;" class="icon-public" id="photo_privacy_public" onclick="set_privacy_photo('photo_privacy_public')">Public</a> </li>
                    <li > <a href="javascript:void(0)" class="icon-add-friend" id="photo_privacy_frineds" style="color:#FFF;" onclick="set_privacy_photo('photo_privacy_frineds')">Friends</a> </li>
                    <li > <a href="javascript:void(0)" class="icon-privacy" id="photo_privacy_me" style="color:#FFF; background-color:transparent;" onclick="set_privacy_photo('photo_privacy_me')">Only Me</a> </li>
                    <li > <a href="#" title="Custom Privacy" class="icon-custom" style="color:#FFF; background-color:transparent;" onclick="add_custom_privacy()" >Custom</a> </li>
                  </ul>
                </div>
              </div>
            </div>
          </form>
          <!--NEXT link button -->
          <script>
		$( "#link_but" ).click(function() {
		$( "#myphoto" ).hide( 300 );
		$( "#my_status" ).hide( 300 );
		$( "#myvideo" ).hide( 300 );
		$( "#myrecent" ).hide( 300 );
		$( "#mylink" ).toggle( 300 );
		});
		</script>
          <form name="comment" id="comment" action="action/home_upload_url.php" method="post">
            <div class="comment1" id="mylink" style="display: none;">
              <input type="text" name="title" id="title" placeholder="Title" style="height: 20px; margin-bottom: 10px; width:100%; padding:2px;"/>
              <textarea name="mylinktext" placeholder="Enter URL" id="url" required="required"></textarea>
              <input name="member_id" type="hidden"  value="<?php echo $_SESSION['SESS_MEMBER_ID'];?>"/>
              <input type="hidden" name="country" id="country" value="<?php echo 'world';?>" />
              <input type="hidden" name="privacy" id="url_privacy" value="1" />
              <input type="hidden" name="photo_custom_share" id="url_custom_share" />
              <input type="hidden" name="photo_custom_unshare" id="url_custom_unshare" />
              <input type="submit" value="Add" name="Add" class="upload_url" style="margin: 6px; background-color: #222; border: 1px solid #000; color: #fff; padding: 2px;"/>
              <div style="display:inline-block; float:right; margin-top:5px;"> <a class="icon-privacy" href="javascript:void(0)" id="privacy3"> <span style="color:#FFF;">Privacy</span></a>
                <div id="url_privacy_menu" style="display: none; width:100px; z-index:102; position:absolute; ">
                  <ul class="root">
                    <li> <a href="javascript:void(0)" style="color:#FFF;" class="icon-public" id="url_privacy_public" onclick="set_privacy_url('url_privacy_public')">Public</a> </li>
                    <li > <a href="javascript:void(0)" class="icon-add-friend" id="url_privacy_frineds" style="color:#FFF;" onclick="set_privacy_url('url_privacy_frineds')">Friends</a> </li>
                    <li > <a href="javascript:void(0)" class="icon-privacy" id="url_privacy_me" style="color:#FFF; background-color:transparent;" onclick="set_privacy_url('url_privacy_me')">Only Me</a> </li>
                    <li > <a href="#" title="Custom Privacy" class="icon-custom" style="color:#FFF; background-color:transparent;" onclick="add_custom_privacy()" >Custom</a> </li>
                  </ul>
                </div>
              </div>
            </div>
          </form>
          <!--NEXT video button -->
          <script>
		$( "#video_but" ).click(function() {
		$( "#myphoto" ).hide( 300 );
		$( "#mylink" ).hide( 300 );
		$( "#my_status" ).hide( 300 );
		$( "#myrecent" ).hide( 300 );
		$( "#myvideo" ).toggle( 300 );
		});
		</script>
          <form name="comment" id="comment" action="action/home_upload_video.php" onsubmit="return Checkfiles();" method="post" enctype="multipart/form-data">
            <div class="comment1" id="myvideo" style="display: none;">
              <input type="text" name="title" id="title" placeholder="Title" style="height: 20px; margin-bottom: 10px; width:100%; padding:2px;"/>
              <input type="file" name="image" id="video" value="" required="required"/>
              <input name="member_id" type="hidden"  value="<?php echo $member_id;?>"/>
              <input type="hidden" name="country" id="country" value="<?php echo 'world';?>" />
              <input type="hidden" name="privacy" id="video_privacy" value="1"/>
              <input type="hidden" name="photo_custom_share" id="video_custom_share" />
              <input type="hidden" name="photo_custom_unshare" id="video_custom_unshare" />
              <input type="submit" value="ADD" name="Add" class="upload_video" style="margin: 6px; background-color: #222; border: 1px solid #000; color: #fff; padding: 2px;"/>
              <div style="display:inline-block; float:right; margin-top:5px;"> <a class="icon-privacy" href="javascript:void(0)" id="privacy4"> <span style="color:#FFF;">Privacy</span></a>
                <div id="video_privacy_menu" style="display: none; width:100px; z-index:102; position:absolute; ">
                  <ul class="root">
                    <li> <a href="javascript:void(0)" style="color:#FFF;" class="icon-public" id="video_privacy_public" onclick="set_privacy_video('video_privacy_public')">Public</a> </li>
                    <li > <a href="javascript:void(0)" class="icon-add-friend" id="video_privacy_frineds" style="color:#FFF;" onclick="set_privacy_url('video_privacy_frineds')">Friends</a> </li>
                    <li > <a href="javascript:void(0)" class="icon-privacy" id="video_privacy_me" style="color:#FFF; background-color:transparent;" onclick="set_privacy_video('video_privacy_me')">Only Me</a> </li>
                    <li > <a href="#" title="Custom Privacy" class="icon-custom" style="color:#FFF; background-color:transparent;" onclick="add_custom_privacy()" >Custom</a> </li>
                  </ul>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div id='flashmessage'>
          <div id="flash" align="left"  ></div>
        </div>
        <div class="post">
          <?php 
include('first_post.php');
?>
        </div>

      </div>
      <?php  // include_once 'ads_column.php';?>
    </div>
    <?php  // include_once 'column_right.php';?>
  </div>
  <!--end mainbody div-->
  <?php //include 'includes/footer.php';?>
</div>
<!--end wrapper div-->
</body>
</html>