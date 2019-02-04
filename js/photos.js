$(document).mouseup(function() {
	//edit CAption
    $('.captions').click(function() {		
        var ID = $(this).attr("id");
        $('#text_wrapper_caption'+ID).hide();
        $('#edit_caption'+ID).show();        
        $('#editbox_caption'+ID).focus();
    });

    $(".editbox_caption").mouseup(function() {		
        return false
    });
	
	$(".editbox_caption").change(function() {		
		var ID = $(this).attr("id");
		var sid=ID.split("editbox_caption"); 
		var New_ID=sid[1];
		$('.edit_caption').hide();
		var boxval = $("#editbox_caption"+New_ID+"").val();
		var dataString = 'data='+ boxval +'&c_id=' +New_ID;	
		
		$.ajax({
		    type: "POST",
		    url: base_url + "action/update_caption.php",
		    data: dataString,
		    cache: false,
		    success: function(html)	{
				location.reload();						        	
		    }
		});
	});
	
	$(document).mouseup(function() {
		$('.edit_caption').hide();
		$('.text_wrapper_caption').show();
		});	
		
		//edit Desccription
    $('.descriptions').click(function()	{
		var ID = $(this).attr("id");
		$('#text_wrapper_description'+ID).hide();
		$('#edit_description'+ID).show();		
		$('#editbox_description'+ID).focus();
    });
	
	$(".editbox_description").mouseup(function() {
		return false
	});

    $(".editbox_description").change(function() {
		var ID = $(this).attr("id");
		var sid=ID.split("editbox_description"); 
		var New_ID=sid[1];
		$('.edit_description').hide();
		var boxval = $("#editbox_description"+New_ID+"").val();
		var dataString = 'data='+ boxval +'&c_id=' +New_ID;		
		
		$.ajax({
			type: "POST",
			url: base_url + "action/update_description.php",
			data: dataString,
			cache: false,
			success: function(html)	{
				location.reload();			
			}
		});
    });
	
	$('.delete_album').click(function() {
	    return confirm("Are you sure you want to delete this album?");
    });
	
	// delete update
$('.stdeletealb').live("click",function(e) 
{
	//alert('hi');
e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


	var ID = $(this).attr("id");
	var dataString = 'msg_id='+ ID;

	if(confirm("Sure you want to delete this Photo? There is NO undo!"))
	{
	
		$.ajax({
		type: "POST",
		url: base_url + "action/delete_photo_from_albums.php",
		data: dataString,
		cache: false,
		success: function(html){
		location.reload();
		 }
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
$('.deletephotofromalbum').live("click",function(e){
	if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


	var ID = $(this).attr("id");
	var dataString = 'msg_id='+ ID;

	if(confirm("Sure you want to delete this Photo? There is NO undo!"))
	{
	
		$.ajax({
		type: "POST",
		url: base_url + "action/delete_photo_from_albums.php",
		data: dataString,
		cache: false,
		success: function(html){
		location.reload();
		 }
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
$('.deletealbum').live("click",function(e) 
{
	//alert('hi');
e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


	var ID = $(this).attr("id");
	var dataString = 'msg_id='+ ID;

	if(confirm("Sure you want to delete this Photo? There is NO undo!"))
	{
	
		$.ajax({
		type: "POST",
		url: base_url + "action/delete_album.php",
		data: dataString,
		cache: false,
		success: function(html){
		location.reload();
		 }
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
});

