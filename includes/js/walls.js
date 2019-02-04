$(function($) {
	
	    $(document).on('click', '.ads_unlike', function(e){
	    	e.preventDefault();
	    	var adsID=$(this).attr("id");
	    	var data = {item:"ads",action:"d",ads:adsID};
	    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
	    			    	
	    	$.post(ajaxurl, data, function(response){
	    		var result = $.parseJSON(response);
	    		var adsMsgC=".adsMsg"+adsID;
	    		var adsMsg=".adsMsgM"+adsID;
	    		var adsLike="#adslike"+adsID;
	    		if(result.msg=='done'){
	    			$(adsMsgC).append("<div class='adsMsgM"+adsID+"' style='color:#53920D;'>You unliked this.</div>");
	    			$(adsLike).html(result.likeLink);
	    		}
	    		else{
	    			$(adsMsgC).append("<div class='adsMsgM"+adsID+"' style='color:red;'>Error</div>");
	    		}
	    		
	    		window.setTimeout(function() {
			    $(adsMsg).fadeTo(300, 0).slideUp(300, function(){
			        $(this).remove(); 
			    });
			}, 100);
	    	});	    	
	    	
	    });	
	    $(document).on({
		  mouseenter: function() {
		     if($(this).find(".delPost").length){  
			  $(this).find(".delPost a").show();
		    }
		  },
		  mouseleave: function() {
		     if($(this).find(".delPost").length){  
			  $(this).find(".delPost a").hide();
		    }	
		  }
		}, '.postContents');

	$(document).on('click', '.btnreadmore', function(e){
		e.preventDefault();
		$(this).parent().children(".more-content").slideDown(500).css("display", "inline");
		$(this).parent().children("span").remove();
		$(this).remove();
	});

	  $(document).on('click', '.walls_like', function(e){
		    	e.preventDefault();
		    	var postID=$(this).attr("id");
		    	var data = {item:"post",action:"like",post:postID};
		    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
		    			    	
		    	$.post(ajaxurl, data, function(response){
		    		var result = $.parseJSON(response);
		    		var postMsgC=".wxp"+postID;
		    		var postMsg=".wxpgM"+postID;
		    		var postLike="#wallsLikeP"+postID;
		    		var postDisLike="#wallsDislikeP"+postID;
		    		var totalLikePanel=".tlatdl"+postID;
		    		if(result.msg=='done'){
		    			$(postMsgC).append("<div class='wxpgM"+postID+"' style='color:#53920D;'>You liked this.</div>");
		    			$(postLike).html(result.likeLink);
		    			$(postDisLike).html(result.likeLink2);
		    			$(totalLikePanel).html(result.likeChange);
		    		}
		    		else{
		    			$(postMsgC).append("<div class='wxpgM"+postID+"' style='color:red;'>Error</div>");
		    		}
		    		
		    		window.setTimeout(function() {
				    $(postMsg).fadeTo(300, 0).slideUp(300, function(){
				        $(this).remove(); 
				    });
				}, 100);
		    	});	    	
		    	
		    });	
		    $(document).on('click', '.walls_unlike', function(e){
		    	e.preventDefault();
		    	var postID=$(this).attr("id");
		    	var data = {item:"post",action:"unlike",post:postID};
		    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
		    			    	
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
				}, 100);
		    	});	    	
		    	
		    });
		    $(document).on('click', '.walls_dislike', function(e){
		    	e.preventDefault();
		    	var postID=$(this).attr("id");
		    	var data = {item:"post",action:"dislike",post:postID};
		    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
		    			    	
		    	$.post(ajaxurl, data, function(response){
		    		var result = $.parseJSON(response);
		    		var postMsgC=".wxpd"+postID;
		    		var postMsg=".wxpgdM"+postID;
		    		var postDisLike="#wallsDislikeP"+postID;
		    		var totalLikePanel=".tlatdl"+postID;
		    		var postLike="#wallsLikeP"+postID;
		    		if(result.msg=='done'){
		    			$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:#53920D;'>You disliked this.</div>");
		    			$(postDisLike).html(result.likeLink);
		    			$(postLike).html(result.likeLink2);
		    			$(totalLikePanel).html(result.likeChange);
		    		}
		    		else{
		    			$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:red;'>Error</div>");
		    		}
		    		
		    		window.setTimeout(function() {
				    $(postMsg).fadeTo(300, 0).slideUp(300, function(){
				        $(this).remove(); 
				    });
				}, 100);
		    	});	    	
		    	
		    });
		    $(document).on('click', '.walls_undislike', function(e){
		    	e.preventDefault();
		    	var postID=$(this).attr("id");
		    	var data = {item:"post",action:"undislike",post:postID};
		    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
		    			    	
		    	$.post(ajaxurl, data, function(response){
		    		var result = $.parseJSON(response);
		    		var postMsgC=".wxpd"+postID;
		    		var postMsg=".wxpgdM"+postID;
		    		var postDisLike="#wallsDislikeP"+postID;
		    		var totalLikePanel=".tlatdl"+postID;
		    		if(result.msg=='done'){
		    			$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:#53920D;'>You undisliked this.</div>");
		    			$(postDisLike).html(result.likeLink);
		    			$(totalLikePanel).html(result.likeChange);
		    		}
		    		else{
		    			$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:red;'>Error</div>");
		    		}
		    		
		    		window.setTimeout(function() {
				    $(postMsg).fadeTo(300, 0).slideUp(300, function(){
				        $(this).remove(); 
				    });
				}, 100);
		    	});	    	
		    	
		    });	
		    $(document).on('click', '.delwallpost', function(e){
		    	e.preventDefault();
		    	var postID=$(this).attr("id");
		    	var data = {item:"post",action:"d",post:postID};
		    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
		    			    	
		    	$.post(ajaxurl, data, function(response){
		    		var result = $.parseJSON(response);
		    		var postMsgC=".post"+postID;		    				    		
		    		if(result.msg=='done'){
		    			$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:#53920D;text-align:center;'>You deleted this post.</div>");		    			
		    		}
		    		else{
		    			$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:red;'>Error</div>");
		    		}
		    		
		    		window.setTimeout(function() {
				    $(postMsgC).fadeTo(300, 0).slideUp(300, function(){
				        $(this).remove(); 
				    });
				}, 10);
		    	});	    	
		    	
		    });
			$(document).on('click', '.delwallComment', function(e){
				e.preventDefault();
				var postID=$(this).attr("id");
				var data = {item:"post",action:"delComment",post:postID};
				var ajaxurl=window.location.origin+"/ajax/acccept.php";

				$.post(ajaxurl, data, function(response){
					var result = $.parseJSON(response);
					var postMsgC=".comment_"+postID;
					if(result.msg=='done'){
						$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:#53920D;text-align:center;'>You deleted this comment.</div>");
					}
					else{
						$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:red;'>Error</div>");
					}

					window.setTimeout(function() {
						$(postMsgC).fadeTo(300, 0).slideUp(300, function(){
							$(this).remove();
						});
					}, 10);
				});

			});
			$(document).on('click', '.delwallReply', function(e){
				e.preventDefault();
				var postID=$(this).attr("id");
				var data = {item:"post",action:"delReply",post:postID};
				var ajaxurl=window.location.origin+"/ajax/acccept.php";

				$.post(ajaxurl, data, function(response){
					var result = $.parseJSON(response);
					var postMsgC=".reply_"+postID;
					if(result.msg=='done'){
						$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:#53920D;text-align:center;'>You deleted this reply.</div>");
					}
					else{
						$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:red;'>Error</div>");
					}

					window.setTimeout(function() {
						$(postMsgC).fadeTo(300, 0).slideUp(300, function(){
							$(this).remove();
						});
					}, 10);
				});

			});
			$(document).on('click', '.delwallReplyReply', function(e){
				e.preventDefault();
				var postID=$(this).attr("id");
				var data = {item:"post",action:"delReplyReply",post:postID};
				var ajaxurl=window.location.origin+"/ajax/acccept.php";

				$.post(ajaxurl, data, function(response){
					var result = $.parseJSON(response);
					var postMsgC=".replyreply_"+postID;
					if(result.msg=='done'){
						$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:#53920D;text-align:center;'>You deleted this reply.</div>");
					}
					else{
						$(postMsgC).append("<div class='wxpgdM"+postID+"' style='color:red;'>Error</div>");
					}

					window.setTimeout(function() {
						$(postMsgC).fadeTo(300, 0).slideUp(300, function(){
							$(this).remove();
						});
					}, 10);
				});

			});

		    $(document).on('click', '.walls_comment', function(e){
		    	e.preventDefault();
		    	
		    	var postID=$(this).attr("id");
		    	var cmntInsPnl='.commentInsertPanel'+postID;	    	
		    	
		    	if($(document).find(cmntInsPnl).length){
		    		$(cmntInsPnl).remove();
		    		
		    	}
		    	else{
		    		if($(document).find(".commentsubmit").length){
			    		$(".commentsubmit").remove();
			    	}
			    	var innerhtml="<div class='commentsubmit commentInsertPanel"+postID+"'><div><textarea style='width:100%' class='postCommentContent'></textarea></div><div style='margin-top:5px;'><a style='background: #333; color: #fff; padding: 5px;margin-right:5px;text-decoration:none;' href='javascript: void(0)' class='commentSubmit' id='"+postID+"'>comment</a><a style='background: #333; color: #fff; padding: 5px;margin-right:5px;text-decoration:none;' href='javascript: void(0)' class='commentCancel'>cancel</a></div>";	
			    	var outerElement='.rp'+postID;  
			    	$(outerElement).append(innerhtml); 
		    	}	
		    	
		    });
		    $(document).on('click', '.commentCancel', function(e){
		    	e.preventDefault();		    		  	
		    	if($(document).find(".commentsubmit").length){
		    		$(".postCommentContent").val('');
		    		$(".commentsubmit").remove();
		    	}	    	
		    });
		    
		    $(document).on('click', '.commentSubmit', function(e){
		    	e.preventDefault();
		    	var postID=$(this).attr("id");
		    	var commentContent=$(".postCommentContent").val();
		    	var postMsgC=".wxp"+postID;
			var postMsg=".wxpgM"+postID;
		    	if(commentContent==''){
		    		$(postMsgC).append("<div class='wxpgM"+postID+"' style='color:red;'>Please enter comment to submit..</div>");
		    	}
		    	else{
			    	var cmntInsPnl='.commentInsertPanel'+postID;
			    	var postCC=".postComment"+postID;
			    	var data = {item:"post",action:"insertcomment",post:postID,content:commentContent};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);
			    		if($(document).find(cmntInsPnl).length){
				    		$(cmntInsPnl).remove();
				    		
				    	}
			    		if(result.msg=='done'){
			    			$(postMsgC).append("<div class='wxpgM"+postID+"' style='color:#53920D;'>You commented on this post.</div>");
			    			$(postCC).html(result.commentChange);		    			
			    		}
			    		else{
			    			$(postMsgC).append("<div class='wxpgM"+postID+"' style='color:red;'>Error</div>");
			    		}			    		
			    		
			    	});
		    	}
		    	window.setTimeout(function() {
			    $(postMsg).fadeTo(300, 0).slideUp(300, function(){
			        $(this).remove(); 
			    });
			}, 10);	    	
		    	
		    });
		    $(document).on('click', '.walls_flag_status', function(e){
			    	e.preventDefault();
			    	
			    	var postID=$(this).attr("id");
			    	var reptInsPnl='.reportInsertPanel'+postID;	    	
			    	
			    	if($(document).find(reptInsPnl).length){
			    		$(reptInsPnl).remove();
			    		
			    	}
			    	else{
			    		if($(document).find(".commentsubmit").length){
				    		$(".commentsubmit").remove();
				    	}
				    	var innerhtml="<div class='reportsubmit reportInsertPanel"+postID+"'><div><textarea style='width:100%' class='postReportContent'></textarea></div><div style='margin-top:5px;'><a style='background: #333; color: #fff; padding: 5px;margin-right:5px;text-decoration:none;' href='javascript: void(0)' class='reportSubmit' id='"+postID+"'>Report</a><a style='background: #333; color: #fff; padding: 5px;margin-right:5px;text-decoration:none;' href='javascript: void(0)' class='reportCancel'>cancel</a></div>";	
				    	var outerElement='.rp'+postID;  
				    	$(outerElement).append(innerhtml); 
			    	}	
			    	
			    });
			    $(document).on('click', '.reportCancel', function(e){
			    	e.preventDefault();		    		  	
			    	if($(document).find(".reportSubmit").length){
			    		$(".postReportContent").val('');
			    		$(".reportsubmit").remove();
			    	}	    	
			    });
			    
			    $(document).on('click', '.reportSubmit', function(e){
			    	e.preventDefault();
			    	var postID=$(this).attr("id");
			    	var reptInsPnl=".reportInsertPanel"+postID;		    	
			    	var repContent=$(".postReportContent").val();
			    	var postMsgC=".wxp"+postID;
			    	var postMsg=".wxpgMR"+postID;			    	
			    	var data = {item:"post",action:"reportPost",post:postID,content:repContent};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);
			    		if($(document).find(reptInsPnl).length){
				    		$(reptInsPnl).remove();
				    		
				    	}
			    		if(result.msg=='done'){
			    			$(postMsgC).append("<div class='wxpgMR"+postID+"' style='color:#53920D;'>You reported on this post.</div>");			    				    			
			    		}
			    		else{
			    			$(postMsgC).append("<div class='wxpgM"+postID+"' style='color:red;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(postMsg).fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove(); 
					    });
					}, 10);
			    	});	    	
			    	
			    });
			    $(document).on('click', '.ads_like', function(e){
			    	e.preventDefault();
			    	var adsID=$(this).attr("id");		    	
			    	var data = {item:"ads",action:"i",ads:adsID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    	
			    	$.post(ajaxurl, data, function(response){		    		
			    		var result = $.parseJSON(response);
			    		var adsMsgC=".adsMsg"+adsID;
			    		var adsMsg=".adsMsgM"+adsID;
			    		var adsLike="#adslike"+adsID;			    		
			    		if(result.msg=='done'){
			    			$(adsMsgC).append("<div class='adsMsgM"+adsID+"' style='color:#53920D;'>You liked this.</div>");		    			
			    			$(adsLike).html(result.likeLink);
			    		}
			    		else{
			    			$(adsMsgC).append("<div class='adsMsgM"+adsID+"' style='color:red;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(adsMsg).fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove(); 
					    });
					}, 10);
			    	});	    	
			    	
			    });
			    
			    $(document).on('click', '.walls_comment_like', function(e){
			    	e.preventDefault();
			    	var commentID=$(this).attr("id");
			    	var data = {item:"post",action:"comment_like",post:commentID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);
			    		var commentMsgC=".wxpcpd"+commentID;
			    		var commentMsg=".wxpgCM"+commentID;
			    		var commentLike="#wallsCommentLikeC"+commentID;
			    		var commentDisLike="#wallsCommentDislikeC"+commentID;
			    		var totalLikePanel=".tlatdlC"+commentID;
			    		if(result.msg=='done'){
			    			$(commentMsgC).append("<div class='wxpgCM"+commentID+"' style='color:#53920D;'>You liked this.</div>");
			    			$(commentLike).html(result.likeLink);
			    			$(commentDisLike).html(result.likeLink2);
			    			$(totalLikePanel).html(result.likeChange);
			    		}
			    		else{
			    			$(commentMsgC).append("<div class='wxpgCM"+commentID+"' style='color:red;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(commentMsg).fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove(); 
					    });
					}, 10);
			    	});	    	
			    	
			    });	
			    $(document).on('click', '.walls_comment_unlike', function(e){
			    	e.preventDefault();
			    	var commentID=$(this).attr("id");
			    	var data = {item:"post",action:"comment_unlike",post:commentID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);
			    		var commentMsgC=".wxpcpd"+commentID;
			    		var commentMsg=".wxpgCM"+commentID;
			    		var commentLike="#wallsCommentLikeC"+commentID;			    		
			    		var totalLikePanel=".tlatdlC"+commentID;
			    		if(result.msg=='done'){
			    			$(commentMsgC).append("<div class='wxpgCM"+commentID+"' style='color:#53920D;'>You unliked this.</div>");
			    			$(commentLike).html(result.likeLink);			    			
			    			$(totalLikePanel).html(result.likeChange);
			    		}
			    		else{
			    			$(commentMsgC).append("<div class='wxpgCM"+commentID+"' style='color:red;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(commentMsg).fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove(); 
					    });
					}, 10);
			    	});	        	
			    	
			    });
			    $(document).on('click', '.walls_comment_dislike', function(e){
			    	e.preventDefault();
			    	var commentID=$(this).attr("id");
			    	var data = {item:"post",action:"comment_dislike",post:commentID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);
			    		var commentMsgC=".wxpcpd"+commentID;
			    		var commentMsg=".wxpgCM"+commentID;
			    		var commentLike="#wallsCommentLikeC"+commentID;
			    		var commentDisLike="#wallsCommentDislikeC"+commentID;
			    		var totalLikePanel=".tlatdlC"+commentID;
			    		if(result.msg=='done'){
			    			$(commentMsgC).append("<div class='wxpgCM"+commentID+"' style='color:#53920D;'>You disliked this.</div>");
			    			$(commentDisLike).html(result.likeLink);
			    			$(commentLike).html(result.likeLink2);
			    			$(totalLikePanel).html(result.likeChange);
			    		}
			    		else{
			    			$(commentMsgC).append("<div class='wxpgCM"+commentID+"' style='color:red;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(commentMsg).fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove(); 
					    });
					}, 10);
			    	});		    	
			    	
			    });	
			    $(document).on('click', '.walls_comment_undislike', function(e){
			    	e.preventDefault();
			    	var commentID=$(this).attr("id");
			    	var data = {item:"post",action:"comment_undislike",post:commentID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);
			    		var commentMsgC=".wxpcpd"+commentID;
			    		var commentMsg=".wxpgCM"+commentID;
			    		var commentLike="#wallsCommentLikeC"+commentID;
			    		var commentDisLike="#wallsCommentDislikeC"+commentID;
			    		var totalLikePanel=".tlatdlC"+commentID;
			    		if(result.msg=='done'){
			    			$(commentMsgC).append("<div class='wxpgCM"+commentID+"' style='color:#53920D;'>You undisliked this.</div>");
			    			$(commentDisLike).html(result.likeLink);			    			
			    			$(totalLikePanel).html(result.likeChange);
			    		}
			    		else{
			    			$(commentMsgC).append("<div class='wxpgCM"+commentID+"' style='color:red;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(commentMsg).fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove(); 
					    });
					}, 10);
			    	});		    	
			    	
			    });	
			    
			    $(document).on('click', '.wall_comment_reply', function(e){
			    	e.preventDefault();
			    	
			    	var commentID=$(this).attr("id");
			    	var rplyInsPnl='.replyInsertPanel'+commentID;	    	
			    	
			    	if($(document).find(rplyInsPnl).length){
			    		$(rplyInsPnl).remove();			    		
			    	}
			    	else{
			    		if($(document).find(".replysubmit").length){
				    		$(".replysubmit").remove();
				    	}
				    	var innerhtml="<div class='replysubmit replyInsertPanel"+commentID+"'><div><textarea style='width:100%' class='replyCommentContent'></textarea></div><div style='margin-top:5px;'><a style='background: #333; color: #fff; padding: 5px;margin-right:5px;text-decoration:none;' href='javascript: void(0)' class='replySubmit' id='"+commentID+"'>reply</a><a style='background: #333; color: #fff; padding: 5px;margin-right:5px;text-decoration:none;' href='javascript: void(0)' class='replyCancel'>cancel</a></div>";	
				    	var outerElement='.wxpcpd'+commentID;  
				    	$(outerElement).after(innerhtml); 
			    	}	
			    	
			    });
			    $(document).on('click', '.replyCancel', function(e){
			    	e.preventDefault();		    		  	
			    	if($(document).find(".replysubmit").length){
			    		$(".replyCommentContent").val('');
			    		$(".replysubmit").remove();
			    	}	    	
			    });
			    
			    $(document).on('click', '.replySubmit', function(e){
			    	e.preventDefault();
			    	var commentID=$(this).attr("id");
			    	var replyContent=$(".replyCommentContent").val();
			    	var commentMsgC=".wxpcpd"+commentID;
					var rplyMsg=".wxpgMcr"+commentID;
			    	if(replyContent ==''){
			    		$(commentMsgC).append("<div class='wxpgMcr"+commentID+"' style='color:red;'>Please enter reply to submit..</div>");
			    	}
			    	else{
				    	var rplyInsPnl='.replyInsertPanel'+commentID;
				    	var rplyCC=".rplyCn"+commentID;
				    	var data = {item:"post",action:"insertcommentreply",post:commentID,content:replyContent};
				    	var ajaxurl=window.location.origin+"/ajax/acccept.php";

				    	$.post(ajaxurl, data, function(response){
				    		var result = $.parseJSON(response);
				    		if($(document).find(rplyInsPnl).length){
					    		$(rplyInsPnl).remove();
					    		
					    	}
				    		if(result.msg=='done'){
				    			$(commentMsgC).append("<div class='wxpgMcr"+commentID+"' style='color:#53920D;'>You commented on this post.</div>");
				    			$(rplyCC).html(result.replyChange);		    			
				    		}
				    		else{
				    			$(commentMsgC).append("<div class='wxpgMcr"+commentID+"' style='color:red;'>Error</div>");
				    		}
				    		
				    		
				    	});
			    	}
			    	window.setTimeout(function() {
				    $(rplyMsg).fadeTo(300, 0).slideUp(300, function(){
				        $(this).remove(); 
				    });
				}, 100);	    	
			    	
			    });
			    $(document).on('click', '.ViewAllReply', function(e){
			    	e.preventDefault();
			    	var commentID=$(this).attr("id");			    	
			    	var commentMsgC=".wxpcpd"+commentID;
				var rplyMsg=".wxpgMcr"+commentID;	    					    	
			    	var rplyCC=".rplyCn"+commentID;
			    	var data = {item:"post",action:"viewallReply",post:commentID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);			    		
			    		if(result.msg=='done'){			    			
			    			$(rplyCC).html(result.replyChange);		    			
			    		}
			    		else{
			    			$(commentMsgC).append("<div class='wxpgMcr"+commentID+"' style='color:red;'>Error</div>");
			    			window.setTimeout(function() {
						$(rplyMsg).fadeTo(300, 0).slideUp(300, function(){
						        $(this).remove(); 
						    });
						}, 100);
			    		}	    		
			    	});
			    	
			    		    	
			    	
			    });
			    
			    
			    $(document).on('click', '.walls_reply_like', function(e){
			    	e.preventDefault();
			    	var replyID=$(this).attr("id");
			    	var data = {item:"post",action:"reply_like",post:replyID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);
			    		var replyMsgC=".wxpcpdrp"+replyID;
			    		var replyMsg=".wxpgRM"+replyID;
			    		var replyLike="#wallsReplyLikeC"+replyID;
			    		var replyDisLike="#wallsReplyDislikeC"+replyID;
			    		var totalLikePanel=".tlatdlCrp"+replyID;
			    		if(result.msg=='done'){
			    			$(replyMsgC).append("<div class='wxpgRM"+replyID+"' style='color:#53920D;'>You liked this.</div>");
			    			$(replyLike).html(result.likeLink);
			    			$(replyDisLike).html(result.likeLink2);
			    			$(totalLikePanel).html(result.likeChange);
			    		}
			    		else{
			    			$(replyMsgC).append("<div class='wxpgRM"+replyID+"' style='color:red;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(replyMsg).fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove(); 
					    });
					}, 100);
			    	});	    	
			    	
			    });
			    
			    $(document).on('click', '.walls_reply_unlike', function(e){
			    	e.preventDefault();
			    	var replyID=$(this).attr("id");
			    	var data = {item:"post",action:"reply_unlike",post:replyID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);
			    		var replyMsgC=".wxpcpdrp"+replyID;
			    		var replyMsg=".wxpgRM"+replyID;
			    		var replyLike="#wallsReplyLikeC"+replyID;			    		
			    		var totalLikePanel=".tlatdlCrp"+replyID;
			    		if(result.msg=='done'){
			    			$(replyMsgC).append("<div class='wxpgRM"+replyID+"' style='color:#53920D;'>You unliked this.</div>");
			    			$(replyLike).html(result.likeLink);			    			
			    			$(totalLikePanel).html(result.likeChange);
			    		}
			    		else{
			    			$(replyMsgC).append("<div class='wxpgRM"+replyID+"' style='color:red;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(replyMsg).fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove(); 
					    });
					}, 100);
			    	});	    	
			    	
			    });
			    $(document).on('click', '.walls_reply_dislike', function(e){
			    	e.preventDefault();
			    	var replyID=$(this).attr("id");
			    	var data = {item:"post",action:"reply_dislike",post:replyID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);			    		
			    		var replyMsgC=".wxpcpdrp"+replyID;
			    		var replyMsg=".wxpgRM"+replyID;
			    		var replyLike="#wallsReplyLikeC"+replyID;
			    		var replyDisLike="#wallsReplyDislikeC"+replyID;
			    		var totalLikePanel=".tlatdlCrp"+replyID;
			    		if(result.msg=='done'){
			    			$(replyMsgC).append("<div class='wxpgRM"+replyID+"' style='color:#53920D;'>You disliked this.</div>");
			    			$(replyDisLike).html(result.likeLink);
			    			$(replyLike).html(result.likeLink2);
			    			$(totalLikePanel).html(result.likeChange);
			    		}
			    		else{
			    			$(replyMsgC).append("<div class='wxpgRM"+replyID+"' style='color:red;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(replyMsg).fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove(); 
					    });
					}, 100);
			    	});		    	
			    	
			    });	
			    $(document).on('click', '.walls_reply_undislike', function(e){
			    	e.preventDefault();
			    	var replyID=$(this).attr("id");
			    	var data = {item:"post",action:"reply_undislike",post:replyID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);			    		
			    		var replyMsgC=".wxpcpdrp"+replyID;
			    		var replyMsg=".wxpgRM"+replyID;			    		
			    		var replyDisLike="#wallsReplyDislikeC"+replyID;
			    		var totalLikePanel=".tlatdlCrp"+replyID;
			    		if(result.msg=='done'){
			    			$(replyMsgC).append("<div class='wxpgRM"+replyID+"'  style='color:#53920D;'>You undisliked this.</div>");
			    			$(replyDisLike).html(result.likeLink);			    			
			    			$(totalLikePanel).html(result.likeChange);
			    		}
			    		else{
			    			$(replyMsgC).append("<div class='wxpgRM"+replyID+"' style='color:red;'>Error</div>");
			    		}
			    		
			    		window.setTimeout(function() {
					    $(replyMsg).fadeTo(300, 0).slideUp(300, function(){
					        $(this).remove(); 
					    });
					}, 100);
			    	});		    	
			    	
			    });	
			    $(document).on('click', '.wall_reply_reply', function(e){
			    	e.preventDefault();
			    	
			    	var replyID=$(this).attr("id");
			    	var rplyInsPnl='.reply2InsertPanel'+replyID;	    	
			    	
			    	if($(document).find(rplyInsPnl).length){
			    		$(rplyInsPnl).remove();			    		
			    	}
			    	else{
			    		if($(document).find(".reply2submit").length){
				    		$(".reply2submit").remove();
				    	}
				    	var innerhtml="<div class='reply2submit reply2InsertPanel"+replyID+"'><div><textarea style='width:100%' class='reply2ReplyContent'></textarea></div><div style='margin-top:5px;'><a style='background: #333; color: #fff; padding: 5px;margin-right:5px;text-decoration:none;' href='javascript: void(0)' class='reply2Submit' id='"+replyID+"'>reply</a><a style='background: #333; color: #fff; padding: 5px;margin-right:5px;text-decoration:none;' href='javascript: void(0)' class='reply2Cancel'>cancel</a></div>";	
				    	var outerElement='.wxpcpdrp'+replyID;  
				    	$(outerElement).after(innerhtml); 
			    	}	
			    	
			    });
			    $(document).on('click', '.reply2Cancel', function(e){
			    	e.preventDefault();		    		  	
			    	if($(document).find(".reply2submit").length){
			    		$(".reply2ReplyContent").val('');
			    		$(".reply2submit").remove();
			    	}	    	
			    });
			    $(document).on('click', '.reply2Submit', function(e){
			    	e.preventDefault();
			    	var replyID=$(this).attr("id");
			    	var replyContent=$(".reply2ReplyContent").val();
			    	var replyMsgC=".wxpcpdrp"+replyID;
				var rplyMsg=".wxpgMcr2"+replyID;
			    	if(replyContent ==''){
			    		$(replyMsgC).append("<div class='wxpgMcr2"+replyID+"'  style='color:red;'>Please enter reply to submit..</div>");
			    	}
			    	else{				    	
				    	var rplyInsPnl='.reply2InsertPanel'+replyID;				    	
				    	var rplyCC=".r2"+replyID;
				    	var data = {item:"post",action:"insertReplyreply",post:replyID,content:replyContent};
				    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
				    			    	
				    	$.post(ajaxurl, data, function(response){
				    		var result = $.parseJSON(response);
				    		if($(document).find(rplyInsPnl).length){
					    		$(rplyInsPnl).remove();
					    		
					    	}
				    		if(result.msg=='done'){
				    			$(replyMsgC).append("<div class='wxpgMcr2"+replyID+"'  style='color:#53920D;'>You posted a reply.</div>");
				    			$(rplyCC).html(result.replyChange);		    			
				    		}
				    		else{
				    			$(replyMsgC).append("<div class='wxpgMcr2"+replyID+"' style='color:red;'>Error</div>");
				    		}
				    		
				    		
				    	});
			    	}
			    	window.setTimeout(function() {
				    $(rplyMsg).fadeTo(300, 0).slideUp(300, function(){
				        $(this).remove(); 
				    });
				}, 100);	    	
			    	
			    });
			    $(document).on('click', '.ViewAllReply2', function(e){
			    	e.preventDefault();
			    	var replyID=$(this).attr("id");			    	
			    	var replyMsgC=".wxpcpdrp"+replyID;
				var rplyMsg=".wxpgMcr2"+replyID;	    					    	
			    	var rplyCC=".r2"+replyID;
			    	var data = {item:"post",action:"viewallReply2",post:replyID};
			    	var ajaxurl=window.location.origin+"/ajax/acccept.php";
			    			    	
			    	$.post(ajaxurl, data, function(response){
			    		var result = $.parseJSON(response);			    		
			    		if(result.msg=='done'){			    			
			    			$(rplyCC).html(result.replyChange);		    			
			    		}
			    		else{
			    			$(replyMsgC).append("<div class='wxpgMcr2"+replyID+"' style='color:red;'>Error</div>");
			    			window.setTimeout(function() {
						$(rplyMsg).fadeTo(300, 0).slideUp(300, function(){
						        $(this).remove(); 
						    });
						}, 100);
			    		}	    		
			    	});
			    	
			    		    	
			    	
			    });


		    


});