<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');


class comment_extra_totalLikeandDislike
{
	function extra_widget($commentID,$encryptedCommentID){			
		
		$loggedin_member_id_for_commentExtra = $_SESSION['SESS_MEMBER_ID'];
		$objMember = new member1(); 
		$currentMemberResultForCommentExtra=$objMember->select_member_byID($loggedin_member_id_for_commentExtra );		
		$objCommentExtra = new posts();
		$commentTotalLike=$objCommentExtra->view_comment_likeDeatilsByCommentID($commentID);
		$countofcommentTotalLike=count($commentTotalLike);
		$totalLikeText='';		
		$totalLikeTextInner='';
		$commentTotalDislike=$objCommentExtra->view_comment_dislikeDeatilsByCommentID($commentID);
		$countofcommentTotalDislike=count($commentTotalDislike);		
		$totalDislikeText='';
		$commenttLikeByMember=$objCommentExtra->view_comment_likeDeatilsByMemberID($commentID,$loggedin_member_id_for_commentExtra);
		$countofcommentLikeByMember=count($commenttLikeByMember);
		$commentDislikeByMember=$objCommentExtra->view_comment_dislikeDeatilsByMemberID($commentID,$loggedin_member_id_for_commentExtra);
		$countofcommentDislikeByMember=count($commentDislikeByMember);
		
		
		
		if($countofcommentLikeByMember>0){
			foreach($currentMemberResultForCommentExtra as $columnCurrentMember => $valueCurrentMember) {					
				$currentMemberUsername=$valueCurrentMember['username'];
				$totalLikeTextInner.='<a title="'.$currentMemberUsername.'" href="'.SITE_URL.'/i/'.$currentMemberUsername.'" >You </a> ';
			}
			
		}
		$a=0;
		foreach($commentTotalLike as $columnLikes => $valueLikes) {
			$likedMemberObj=$objMember->select_member_byID($valueLikes['member_id']);			
			
			foreach($likedMemberObj as $columnMemberLike => $valueMemberLike) {
				$likedMemberID=$valueMemberLike['member_id'];
				$likedMemberUsername=$valueMemberLike['username'];
				if($likedMemberID == $loggedin_member_id_for_commentExtra ){
					continue;
				}
				else{
					$totalLikeTextInner.='<a title="'.$likedMemberUsername.'" href="'.SITE_URL.'/'.$likedMemberUsername.'" >'.$likedMemberUsername.'</a>';
				}				
			}
			
			$a++;
						
						
			if($a==2){
				$othercountText='';
				if($countofcommentTotalLike-2>0){
					$othercountText=' .. and '.($countofcommentTotalLike-2).' others';
				}
				$totalLikeTextInner.= $othercountText;
				break;
			}
			if($a>=1){
				$totalLikeTextInner.= ' ';
			}			
		}
		if($totalLikeTextInner!=''){
			$totalLikeText ='<div style="background:#EDEDED;" class="tl'.$encryptedCommentID.'">'.$totalLikeTextInner.' liked this comment</div>';
		}
		if($countofcommentTotalDislike>0){
			$totalDislikeText='<div style="background:#EDEDED;" class="tdl'.$encryptedCommentID.'">'.$countofcommentTotalDislike.' persons disliked this comment</div>';
		}		
		
		
		
		$innerhtml='<div class="tlatdlC'.$encryptedCommentID.'">';
		$innerhtml .=$totalLikeText;
		$innerhtml .=$totalDislikeText;
		$innerhtml .='</div>';
		
		return $innerhtml;
	}
}

?>