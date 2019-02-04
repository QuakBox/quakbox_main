$(document).ready(function () {
    $('.like').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("like");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = 'load_data/message_like_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
			dataType: 'json',
            success: function (html) {
				var likecount = html.likecount;
                var dislikecount = html.dislikecount;
				
                if (REL == 'Like') {
					if(likecount == 1) {
						$("#youlike" + New_ID).slideDown('slow').prepend("<span id='you" + New_ID + "'>You like this.</span>.");
					}
					if(likecount == 2) {
						$("#ads_likes" + New_ID).prepend("<span id='you" + New_ID + "'><a href='#'>You</a>, </span>");
					}
					if(likecount > 2){
						$("#ads_likes" + New_ID).prepend("<span id='you" + New_ID + "'><a href='#'>You</a>, </span>");
					}
					
                                        
                    $('#' + ID).html('Unlike').attr('rel', 'Unlike').attr('title', 'Unlike');
                } else {
                    $("#youlike" + New_ID).slideUp('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', 'Like').html('Like');
                }
				$('#likes' + New_ID).fadeIn('fast');
				if (dislikecount > 0) {					
                    $('#postdislikecount' + New_ID).html(dislikecount);
                } else {
                    $('#postdislike_container' + New_ID).fadeOut('fast');
                }
				
				if (likecount > 0) {
                    //$('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#likes' + New_ID).fadeOut('fast');
                }
            }
        });
    });
	
	//post dislike 
	$('.post_dislike').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("post_dislike");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = 'load_data/post_dislike_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                $("#you" + New_ID).remove();
                $('#like' + New_ID).html('Like').attr('rel', 'Like').attr('title', 'Like');
                $("#postdislike_container" + New_ID).fadeIn('slow');
                
                if (dislikecount > 0) {					
                    $('#postdislikecount' + New_ID).html(dislikecount);
                } else {
                    $('#postdislike_container' + New_ID).fadeOut('fast');
                } 
				if (likecount > 0) {
                    //$('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#likes' + New_ID).fadeOut('fast');
                }               
            }
        });
    });
	
    $('.comment_dislike').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("comment_dislike");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = 'load_data/comment_dislike_ajax.php';
        var dataString = 'comment_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                $("#you" + New_ID).remove();
                $('#comment_like' + New_ID).html('Like').attr('rel', 'Like').attr('title', 'Like');
                $("#dislikecout_container" + New_ID).fadeIn('slow');
                $('#dislikecout' + New_ID).html(dislikecount);
                $('#commentlikecount' + New_ID).html(likecount);
                if (dislikecount > 0) {
                    $('#dislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#dislikecout_container' + New_ID).fadeOut('slow');
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }
            }
        });
    });
    $('.comment_like').die('click').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("comment_like");
        var New_ID = sid[1];
        var msg_id = $(this).attr("msg_id");
        var comma = "";
        var youcount = $("#commacount" + New_ID).val();
        if (youcount > 0) {
            comma = ", ";
        }
        var REL = $(this).attr("rel");
        var URL = 'load_data/comment_like_ajax.php';
        var dataString = 'comment_id=' + New_ID + '&rel=' + REL + '&msg_id=' + msg_id;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: "json",
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                
                if (REL == 'Like') {
                    $("#clike" + New_ID).show('slow').prepend("<span id='you" + New_ID + "'><a href='#'>You</a>" + comma + "</span>");
                    $('#' + ID).html('Unlike').attr('rel', 'Unlike').attr('title', 'Unlike');
                } else {
                    if (youcount == 0) $("#clike" + New_ID).hide('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', 'Like').html('Like');
                }
                if (dislikecount > 0) {
                    $('#dislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#dislikecout_container' + New_ID).fadeOut('slow');
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }
            }
        });
    });
    $('.ads_like').live("click", function () {
        var ID = $(this).attr("id");
        var sid = ID.split("like_ads");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = 'load_data/ads_like_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            success: function (html) {
                if (REL == 'Like') {
                    $("#youlike" + New_ID).slideDown('slow').prepend("<span id='you" + New_ID + "'><a href='#'>You</a> like this.</span>.");
                    $("#ads_likes" + New_ID).prepend("<span id='you" + New_ID + "'><a href='#'>You</a>, </span>");
                    $('#' + ID).html('Unlike').attr('rel', 'Unlike').attr('title', 'Unlike');
                } else {
                    $("#youlike" + New_ID).slideUp('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', 'Like').html('Like');
                }
            }
        });
    });
    $(".update_button").click(function () {
        var updateval = $("#update").val();
        var country = $("#country").val();
        var member_id = $("#member_id").val();
        var privacy = $("#privacy1").val();
        var share_member_id = $("#photo_custom_share").val();
        var unshare_member_id = $("#photo_custom_unshare").val();
        var uploadvalues = $("#uploadvalues").val();
        var dataString = 'update=' + updateval + '&country=' + country + '&member_id=' + member_id + '&privacy=' + privacy + '&share_member_id=' + share_member_id + '&unshare_member_id=' + unshare_member_id;
        if (updateval == '') {
            alert("Please Enter Some Text");
        } else {
            $("#flash").show();
            $("#flash").fadeIn(400).html('Loading Update...');
            $.ajax({
                type: "POST",
                url: "action/update_ajax.php",
                data: dataString,
                cache: false,
                success: function (html) {
                    $("#flash").fadeOut('slow');
                    $(".post").prepend(html);
                    $("#update").val('');
                    $("#update").focus();
                    $("#stexpand").oembed(updateval);
                }
            });
            $('#my_status').slideUp('fast');
        }
        return false;
    });
    $(".update_image").click(function () {
        var country = $("#country").val();
        var member_id = $("#member_id").val();
        var privacy = $("#photo_privacy").val();
        var share_member_id = $("#photo_custom_share").val();
        var unshare_member_id = $("#photo_custom_unshare").val();
        var uploadvalues = $("#uploadvalues").val();
        var X = $('.preview').attr('id');
        if (X) {
            var Z = X;
        } else {
            var Z = 0;
        }
        var dataString = 'country=' + country + '&member_id=' + member_id + '&privacy=' + privacy + '&share_member_id=' + share_member_id + '&unshare_member_id=' + unshare_member_id + '&uploads=' + Z;
        $("#flash").show();
        $("#flash").fadeIn(400).html('Loading Update...');
        $.ajax({
            type: "POST",
            url: "action/image_upload_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#flash").fadeOut('slow');
                $(".post").prepend(html);
                $('#preview').html('');
                $('#uploadvalues').val('');
                $('#image').val('');
				$("#imageloadbutton").show();
            }
        });
        $("#preview").html();
        $('#myphoto').slideUp('fast');
        return false;
    });
});
$('.button').live("click", function () {
    var ID = $(this).attr("id");
    var comment = $("#ctextarea" + ID).val();
    var dataString = 'comment=' + comment + '&msg_id=' + ID;
    if (comment == '') {
        alert("Please Enter Comment Text");
    } else {
        $.ajax({
            type: "POST",
            url: "action/comment_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#commentload" + ID).append(html);
                $("#ctextarea" + ID).val('');
                $("#ctextarea" + ID).focus();
            }
        });
    }
    return false;
});
$('.report').live("click", function () {
    var ID = $(this).attr("id");
    var comment = $("#rptextarea" + ID).val();
    var dataString = 'report=' + comment + '&msg_id=' + ID;
    if (comment == '') {
        alert("Please Enter Comment Text");
    } else {
        $.ajax({
            type: "POST",
            url: "action/report_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#commentload" + ID).append(html);
                $("#reportbox" + ID).hide();
            }
        });
    }
    return false;
});
$('.commentopen').live("click", function () {
    var ID = $(this).attr("id");
    $("#commentbox" + ID).slideToggle('slow');
    $("#ctextarea" + ID).focus();;
    return false;
});
$('.flagopen').live("click", function () {
    var ID = $(this).attr("id");
    $("#reportbox" + ID).slideToggle('slow');
    $("#reportbox" + ID).focus();
    return false;
});
$('.stcommentdelete').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'com_id=' + ID;
    if (confirm("Sure you want to delete this update? There is NO undo!")) {
        $.ajax({
            type: "POST",
            url: "action/delete_comment_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#stcommentbody" + ID).slideUp();
            }
        });
    }
    return false;
});
$('.stdelete').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'msg_id=' + ID;
    if (confirm("Sure you want to delete this update? There is NO undo!")) {
        $.ajax({
            type: "POST",
            url: "action/delete_post_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#stbody" + ID).slideUp();
            }
        });
    }
    return false;
});
$('.replyopen').live("click", function () {
    var ID = $(this).attr("id");
    $("#replybox" + ID).slideToggle('slow');
    $("#rtextarea" + ID).focus();
    return false;
});
$('.reply_button').live("click", function () {
    var ID = $(this).attr("id");
    var comment = $("#rtextarea" + ID).val();
    var uname = $(this).attr("title");
    var mem_id = $(this).attr("abcd");
    var dataString = 'reply=' + comment + '&comment_id=' + ID + '&uname=' + uname + '&mem_id=' + mem_id;
    if (comment == '') {
        alert("Please Enter reply Text");
    } else {
        $.ajax({
            type: "POST",
            url: "action/reply_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#replyload" + ID).append(html);
                $("#rtextarea" + ID).val('');
                $("#replybox" + ID).hide();
            }
        });
    }
    return false;
});
$('.share_open').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'msg_id=' + ID;
    $.ajax({
        type: "POST",
        url: "load_data/share_info.php",
        data: dataString,
        cache: false,
        success: function (html) {
            $(".share_popup").show();
            $(".share_body").append(html);
			$('#mydiv3').share({
        networks: ['facebook','pinterest','googleplus','twitter','linkedin','tumblr','in1','email','stumbleupon','digg'],        
        urlToShare: 'http://beta.quakbox.com/posts.php?id='+ID
       
    });
        }
    });
    return false;
});
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
$('.bmsg').live("click", function () {
    var ID = $(this).attr("id");
    var dataString = 'member_id=' + ID;
    $.ajax({
        type: "POST",
        url: "load_data/bday_data.php",
        data: dataString,
        cache: false,
        success: function (html) {
            $(".bpopup").show();
            $(".bdaybody").append(html);
        }
    });
    return false;
});
$('.ViewComments').live("click", function () {
    var id = $(this).attr('id');
    var total_comments = $("#totals-" + id).val();
    var dataString = "postId=" + id + "&totals=" + total_comments;
    $("#loader-" + id).html('<img src="images/loader1.gif" alt="" />');
    $.ajax({
        type: "POST",
        url: "load_data/view_comments.php",
        data: dataString,
        cache: false,
        success: function (html) {
            $('#commentload' + id).prepend(html);
            $('#collapsed-' + id).hide();
        }
    });
    return false;
});
//fetch more replys
$('.ViewReply').live("click",function () {
    var parent = $(this).parent();
    var getID = parent.attr('id').replace('replycollapsed-', '');
    var total_comments = $("#replytotals-" + getID).val();
	 var dataString = "postId=" + getID + "&totals=" + total_comments;
    $("#loader-" + getID).html('<img src="images/loader1.gif" alt="" />');
	$.ajax({
        type: "POST",
        url: "load_data/view_reply.php",
        data: dataString,
        cache: false,
        success: function (response) {    
        $('#replyload' + getID).prepend(response);
        $('#replycollapsed-' + getID).hide();
		}
    });
	return false;
	});	


function canclose(valcolse) {
    document.getElementById(valcolse).style.display = "none";
}

function cancelclose(valcolse) {
    document.getElementById(valcolse).style.display = "none";
}

function closereply(valcolse) {
    document.getElementById(valcolse).style.display = "none";
}