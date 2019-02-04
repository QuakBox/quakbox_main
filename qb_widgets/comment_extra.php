<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/comment_extra_totalLikeandDislike.php');


class comment_extra
{
	function extra_widget($commentID,$encryptedCommentID){			
		
		$loggedin_member_id_for_commentExtra = $_SESSION['SESS_MEMBER_ID'];				
		$objCommentExtra = new posts();			
		$commentLikeByMember=$objCommentExtra->view_comment_likeDeatilsByMemberID($commentID,$loggedin_member_id_for_commentExtra);
		$countofcommentLikeByMember=count($commentLikeByMember);
		$commentDislikeByMember=$objCommentExtra->view_comment_dislikeDeatilsByMemberID($commentID,$loggedin_member_id_for_commentExtra);
		$countofcommentDislikeByMember=count($commentDislikeByMember);
		
		$panel1='';		
		$panel1 .='<div class="walls-comment-extra-panel wxpcpd'.$encryptedCommentID.'" style="font-size: 11px;">';
		$panel1 .='<span id="wallsCommentLikeC'.$encryptedCommentID.'" style="margin-right:5px;">';
		if($countofcommentLikeByMember>0){
			$panel1 .='<a id="'.$encryptedCommentID.'" class="walls_comment_unlike" href="javascript: void(0)">Unlike</a>';
		}
		else{
			$panel1 .='<a id="'.$encryptedCommentID.'" class="walls_comment_like" href="javascript: void(0)">Like</a>';
		}
		$panel1 .='</span>';
		$panel1 .='<span id="wallsCommentDislikeC'.$encryptedCommentID.'" style="margin-right:5px;">';
		if($countofcommentDislikeByMember>0){
			$panel1 .='<a id="'.$encryptedCommentID.'" class="walls_comment_undislike" href="javascript: void(0)">Undislike</a>';
		}
		else{
			$panel1 .='<a id="'.$encryptedCommentID.'" class="walls_comment_dislike" href="javascript: void(0)">Dislike</a>';
		}		
		$panel1 .='</span>';
		$panel1 .='<span>';
		$panel1 .='<a id="'.$encryptedCommentID.'" class="wall_comment_reply" href="javascript: void(0)">Reply</a> ';
		$panel1 .='</span>';	 	
		$panel1 .='<span>';
		$panel1 .='<a id="'.$encryptedCommentID.'" class="walls_comment_translate" href="javascript: void(0)"> Translate</a> ';
		$panel1 .='</span>';			
		
		$panel1 .='</div>';		
		
		
		$objCommentExtraTotalLikeandDislike = new comment_extra_totalLikeandDislike();
		$totalLikeandDisLikeText=$objCommentExtraTotalLikeandDislike->extra_widget($commentID,$encryptedCommentID);
		
		$innerhtml='';
		$innerhtml .=$totalLikeandDisLikeText;		
		$innerhtml .=$panel1;		

		return $innerhtml;
	}
}

?>