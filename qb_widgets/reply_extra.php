<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/reply_extra_totalLikeandDislike.php');

class reply_extra
{
	function extra_widget($replyID,$encryptedReplyID){			
		
		$loggedin_member_id_for_replyExtra= $_SESSION['SESS_MEMBER_ID'];				
		$objReplyExtra= new posts();			
		$replyLikeByMember=$objReplyExtra->view_reply_likeDeatilsByMemberID($replyID,$loggedin_member_id_for_replyExtra);
		$countofreplyLikeByMember=count($replyLikeByMember);
		$replytDislikeByMember=$objReplyExtra->view_reply_dislikeDeatilsByMemberID($replyID,$loggedin_member_id_for_replyExtra);
		$countofreplyDislikeByMember=count($replytDislikeByMember);
		
		$panel1='';		
		$panel1 .='<div class="walls-reply-extra-panel wxpcpdrp'.$encryptedReplyID.'" style="font-size: 11px;">';
		$panel1 .='<span id="wallsReplyLikeC'.$encryptedReplyID.'" style="margin-right:5px;">';
		if($countofreplyLikeByMember>0){
			$panel1 .='<a id="'.$encryptedReplyID.'" class="walls_reply_unlike" href="javascript: void(0)">Unlike</a>';
		}
		else{
			$panel1 .='<a id="'.$encryptedReplyID.'" class="walls_reply_like" href="javascript: void(0)">Like</a>';
		}
		$panel1 .='</span>';
		$panel1 .='<span id="wallsReplyDislikeC'.$encryptedReplyID.'" style="margin-right:5px;">';
		if($countofreplyDislikeByMember>0){
			$panel1 .='<a id="'.$encryptedReplyID.'" class="walls_reply_undislike" href="javascript: void(0)">Undislike</a>';
		}
		else{
			$panel1 .='<a id="'.$encryptedReplyID.'" class="walls_reply_dislike" href="javascript: void(0)">Dislike</a>';
		}		
		$panel1 .='</span>';
		$panel1 .='<span>';
		$panel1 .='<a id="'.$encryptedReplyID.'" class="wall_reply_reply" href="javascript: void(0)">Reply</a> ';
		$panel1 .='</span>';	 	
		$panel1 .='<span>';
		$panel1 .='<a id="'.$encryptedReplyID.'" class="walls_reply_translate" href="javascript: void(0)"> Translate</a> ';
		$panel1 .='</span>';			
		
		$panel1 .='</div>';		
		
		
		$objCReplyExtraTotalLikeandDislike = new reply_extra_totalLikeandDislike();
		$totalLikeandDisLikeText=$objCReplyExtraTotalLikeandDislike->extra_widget($replyID,$encryptedReplyID);
		
		$innerhtml='';
		$innerhtml .=$totalLikeandDisLikeText;		
		$innerhtml .=$panel1;		

		return $innerhtml;
	}
}

?>