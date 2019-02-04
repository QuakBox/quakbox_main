var baseurl  = "https://quakbox.com/";
$(document).ready(function(e) {
//subscribe or unsuscribe channel code here
$('.subscribe_btn').click(function (e) {
e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


    var ID = $(this).attr("id");
	var rel = $(this).attr("rel");    
    var dataString = 'id=' + ID + '&rel=' + rel;
        $.ajax({
            type: "POST",
            url: baseurl + "action/subscribe-channel.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#channel_subscribers_count").html(html);
				if(rel == 'subscribe'){
					$('.subscribe_btn').removeClass('btn-success');
					$('.subscribe_btn').addClass('btn-danger');					
					$('.subscribe_btn').attr('rel', 'unsubscribe').html('Unsubscribe');					
				}else{
					$('.subscribe_btn').removeClass('btn-danger');
					$('.subscribe_btn').addClass("btn-success");					
					$('.subscribe_btn').attr('rel', 'subscribe').html('Subscribe');					
				}				
				
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
});

//add or edit channel description
$('.save-desc').click(function (e) {
e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click

    var description = $('#description').val();
	var id = $('#channel_id').val();	    
    var dataString = 'description=' + description + '&id=' + id;
        $.ajax({
            type: "POST",
            url: baseurl + "action/edit-channel-description.php",
            data: dataString,
            cache: false,
            success: function (html) {				
                //$('#edit_desc').html(description);				
				//$('#edit_desc').show();
				//$('#video_description').hide();		
				location.reload();
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
      
});

$('.save-canecl').click(function () {    
	$('#comment_desc_btn').show();
    $('#video_description').hide();
	$('#edit_desc').show();		
});

$('#edit_btn').click(function () {
	var data = $('#desc').html();			
    $('#edit_desc').hide();	
	$('#description').val(data);	
	$('#video_description').show();	
});

$('#comment_desc_btn').click(function () {
	$('#add_desc').hide();
    $('#video_description').show();	
});
});