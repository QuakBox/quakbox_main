// JavaScript Document
//share status
$('.share_open').live("click",function() 
{
var ID = $(this).attr("id");
var dataString = 'msg_id='+ ID;
$.ajax({
type: "POST",
url: base_url + "load_data/share_info.php",
data: dataString,
cache: false,
success: function(html){
$(".share_popup").show();
$(".share_body").append(html);
 }
 });

return false;
});