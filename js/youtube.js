// Update Status
$(document).ready(function() 
{
$(".view_video").live("click",function() 
{
	var id = $(this).attr("id");
	var dataString = 'id='+ id;

/*$.ajax({
type: "POST",
url: base_url + "action/update_ajax.php",
data: dataString,
cache: false,
success: function(html)
{

  }
 });
*/
});
});