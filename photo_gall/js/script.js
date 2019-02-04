
// close photo preview block
function closePhotoPreview() {
    $('#photo_preview').hide();
    $('#photo_preview .pleft').html('empty');
    $('#photo_preview .pright').html('empty');
};

// display photo preview block
function getPhotoPreviewAjx(id) {
//alert('hello');
    $.post('photos_ajax.php', {id: id},
        function(data){
            $('#photo_preview .pleft').html(data.data1);
            $('#photo_preview .pright').html(data.data2);
            $('#photo_preview').show();
           // alert(id);
        }, "json"
    );
};


// submit comment
function submitComment(id) {
    var sName = $('#name').val();
    var sText = $('#text').val();

    if (sName && sText) {
        $.post('index.php', { action: 'accept_comment', name: sName, text: sText, id: id }, 
            function(data){ 
                if (data != '1') {
                    $('#comments_list').fadeOut(1000, function () { 
                        $(this).html(data);
                        $(this).fadeIn(1000); 
                    }); 
                } else {
                    $('#comments_warning2').fadeIn(1000, function () { 
                        $(this).fadeOut(1000); 
                    }); 
                }
            }
        );
    } else {
        $('#comments_warning1').fadeIn(1000, function () { 
            $(this).fadeOut(1000); 
        }); 
    }
};

// init
$(function(){

    // onclick event handlers
    $('#photo_preview .photo_wrp').click(function (event) {
        event.preventDefault();

        return false;
    });
    $('#photo_preview').click(function (event) {
        closePhotoPreview();
    });
    $('#photo_preview img.close').click(function (event) {
        closePhotoPreview();
    });

    // display photo preview ajaxy
    $('.container .photo img').click(function (event) {
        if (event.preventDefault) event.preventDefault();
        getPhotoPreviewAjx($(this).attr('id'));
    });
    
    
    
       
		    $('#photo_preview .pright a').click(function (event){
		    	e.preventDefault();
		    	var postID=$(this).attr("id");
		    	var data = {item:"post",action:"unlike",post:postID};
		    	var ajaxurl="/ajax/acccept.php";
		    			    	
		    	$.post(ajaxurl, data, function(response){
		    		var result = $.parseJSON(response);
		    		var postMsgC=".wxp"+postID;
		    		var postMsg=".wxpgM"+postID;
		    		var postLike="#wallsLikeP"+postID;
		    		var totalLikePanel=".tlatdl"+postID;
		    		if(result.msg=='done'){
		    			$(postMsgC).append("<div class='wxpgM"+postID+"' style='color:#53920D;'>You unliked this.</div>");
		    			$(postLike).html(result.likeLink);
		    			$(totalLikePanel).html(result.likeChange);
		    		}
		    		else{
		    			$(postMsgC).append("<div class='wxpgM"+postID+"' style='color:red;'>Error</div>");
		    		}
		    		
		    		window.setTimeout(function() {
				    $(postMsg).fadeTo(300, 0).slideUp(300, function(){
				        $(this).remove(); 
				    });
				}, 5000);
		    	});	    	
		    	
		    });
                    
		    
		    


})
















	