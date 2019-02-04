<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');


class reply_extra_totalLikeandDislike
{
	function extra_widget($replyID,$encryptedReplyID){			
		
		$loggedin_member_id_for_replyExtra = $_SESSION['SESS_MEMBER_ID'];
		$objMember = new member1(); 
		$currentMemberResultForReplyExtra=$objMember->select_member_byID($loggedin_member_id_for_replyExtra);		
		$objReplyExtra = new posts();
		$replyTotalLike=$objReplyExtra->view_reply_likeDeatilsByReplyID($replyID);
		$countofreplyTotalLike=count($replyTotalLike);
		$totalLikeText='';		
		$totalLikeTextInner='';
		$replytTotalDislike=$objReplyExtra->view_reply_dislikeDeatilsByReplyID($replyID);
		$countofreplyTotalDislike=count($replytTotalDislike);		
		$totalDislikeText='';
		$replyLikeByMember=$objReplyExtra->view_reply_likeDeatilsByMemberID($replyID,$loggedin_member_id_for_replyExtra);
		$countofreplyLikeByMember=count($replyLikeByMember);
		$replyDislikeByMember=$objReplyExtra->view_reply_dislikeDeatilsByMemberID($replyID,$loggedin_member_id_for_replyExtra);
		$countofreplyDislikeByMember=count($replyDislikeByMember);
		
		
		
		if($countofreplyLikeByMember>0){
			foreach($currentMemberResultForReplyExtra as $valueCurrentMember) {					
				$currentMemberUsername=$valueCurrentMember['username'];
				$totalLikeTextInner.='<a title="'.$currentMemberUsername.'" href="'.SITE_URL.'/i/'.$currentMemberUsername.'" >You </a> ';
			}
			
		}
		$a=0;
		foreach($replyTotalLike as $valueLikes) {
			$likedMemberObj=$objMember->select_member_byID($valueLikes['member_id']);			
			
			foreach($likedMemberObj as $valueMemberLike) {
				$likedMemberID=$valueMemberLike['member_id'];
				$likedMemberUsername=$valueMemberLike['username'];
				if($likedMemberID == $loggedin_member_id_for_replyExtra){
					continue;
				}
				else{
					$totalLikeTextInner.='<a title="'.$likedMemberUsername.'" href="'.SITE_URL.'/'.$likedMemberUsername.'" >'.$likedMemberUsername.'</a>';
				}				
			}
			
			$a++;
						
						
			if($a==2){
				$othercountText='';
				if($countofreplyTotalLike-2>0){
					$othercountText=' .. and '.($countofreplyTotalLike-2).' others';
				}
				$totalLikeTextInner.= $othercountText;
				break;
			}
			if($a>=1){
				$totalLikeTextInner.= ' ';
			}			
		}
		if($totalLikeTextInner!=''){
			$totalLikeText ='<div style="" class="tl'.$encryptedReplyID.'">'.$totalLikeTextInner.' liked this reply</div>';
		}
		if($countofreplyTotalDislike>0){
			$totalDislikeText='<div style="" class="tdl'.$encryptedReplyID.'">'.$countofreplyTotalDislike.' persons disliked this reply</div>';
		}		
		
		
		
		$innerhtml='<div class="tlatdlCrp'.$encryptedReplyID.'">';
		$innerhtml .=$totalLikeText;
		$innerhtml .=$totalDislikeText;
		$innerhtml .='</div>';
		
		return $innerhtml;
	}
}

?>