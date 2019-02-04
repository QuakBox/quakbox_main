$(document).ready(function() {
		$(".oembed").oembed(null, 
			{
			embedMethod: "fill", 
			maxWidth: 424,
			maxHeight: 268,
			vimeo: { autoplay: false, maxWidth: 400, maxHeight: 300}
						
			});			
			
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

$(".cancel_custom").click(function() {
	$("#popup").hide();
	});
	
	 $(".cancel_share").click(function() {
	$("#share_popup").hide();
	$(".share_body").children('div').remove();
	$('#mydiv3').empty();
	});
	
	$('.tooltip').mouseenter(function() 
	{
		var ID = $(this).attr("id");
		var dataString = 'member_id='+ ID;
		//$(".tooltip_show1").fadeOut('fast');
		$.ajax({
			type: "POST",
			url: base_url + "load_data/member_info.php",
			data: dataString,
			cache: false,
			success: function(html){				
				$(".tooltip_show1").append(html).fadeIn('fast');
				
			 }
		 });
		//return false;
	});
	
	$(".tooltip_show1").mouseleave(function(){
		$(".tooltip_show1").fadeOut();
  		$(".tooltip_show1").children('div').remove().fadeOut('fast');
	
	});

});

function showHide() 
{
				
   if(document.getElementById("privacy").selectedIndex == 0) 
   {
	    
		document.getElementById("mvm").style.display = "block";// This line makes the DIV visible
		document.getElementById("hiddenIDForSelection").value = "0"; 
		document.getElementById("mvm1").style.display = "none"; 
	   	document.getElementById("mvm2").style.display = "none";
   }
   else if(document.getElementById("privacy").selectedIndex == 1) 
   {
	    	document.getElementById("mvm1").style.display = "block"; // This line makes the DIV visible
	    	document.getElementById("hiddenIDForSelection").value = "1"; 
		document.getElementById("mvm").style.display = "none";
	   	document.getElementById("mvm2").style.display = "none";
   }
   else if(document.getElementById("privacy").selectedIndex == 2)
   {            
       		document.getElementById("mvm2").style.display = "block";// This line makes the DIV visible
        	document.getElementById("hiddenIDForSelection").value = "2"; 
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm1").style.display = "none"; 
   }
   else if(document.getElementById("privacy").selectedIndex == 3)
   {            
        	document.getElementById("world").value = "world";
        	document.getElementById("hiddenIDForSelection").value = "3"; 
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
	document.getElementById('photo_privacy_menu').style.display="none";
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
	document.getElementById('privacy_menu').style.display="none";
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
	document.getElementById('url_privacy_menu').style.display="none";
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
	document.getElementById('video_privacy_menu').style.display="none";
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
	document.getElementById('privacy_menu').style.display="none";
	document.getElementById('photo_privacy_menu').style.display="none";
	document.getElementById('url_privacy_menu').style.display="none";
	document.getElementById('video_privacy_menu').style.display="none";
});
});
function add_custom_privacy(){	
	document.getElementById('popup').style.display="block";
}
function showMe(val,country_code) {
//alert(val);
//alert('hi');
//alert(val);
	
	var invertedshiftdownInnerBody = document.getElementById("invertedshiftdownUL");
	var liStr = invertedshiftdownInnerBody.getElementsByTagName("li");
	for(var i=0;i<liStr.length; i++) {
		var li = liStr[i];
		li.className="";
		
	}
	
	var cntry_code=document.getElementById('cntry_code').value;
	
	document.getElementById(val).className="selected";
	
        parent.frames['frm'].location = 'getRss.php?feed='+val+'&country_code='+cntry_code;
          //parent.frames['frm'].location = 'getRss.php?feed='+val+'&country_code=vinod';
}

function hide_profile_photo(){
	document.getElementById('text1').style.display='none';
}
function change_profile_photo(){
		
	document.getElementById('text1').style.display='block';
}
function hide_box(){
	document.getElementById('text2').style.display='none';
}
function show_box(){
	//alert("hii");
	document.getElementById('text2').style.display='block';
	document.getElementById('text1').style.display='block';
}
function select_row( id ){
	document.getElementById(id).style='text-align:left;border:none;background-color:#03F;color:#FFF;';
}
function deselect_row( id ){

	
	document.getElementById(id).style='text-align:left;border:none;background-color:#FFF;color:#000;';
}
$(function() {
    $(".cancel_bpopup").click(function() {
	$("#bpopup").hide();
	});
});
function show_bday()
{
	document.getElementById("bpopup").style.display = 'block';	
}








