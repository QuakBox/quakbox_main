<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');


class post_extra_totalLikeandDislike
{
	function extra_widget($postID,$encryptedPostID){			
		
		$loggedin_member_id_for_postExtra = $_SESSION['SESS_MEMBER_ID'];
		$objMember = new member1(); 
		$currentMemberResultForPostExtra=$objMember->select_member_byID($loggedin_member_id_for_postExtra);		
		$objPostExtra = new posts();
		$postTotalLike=$objPostExtra ->view_post_likeDeatilsByPostID($postID);
		$countofpostTotalLike=count($postTotalLike);
		$totalLikeText='';		
		$totalLikeTextInner='';
		$postTotalDislike=$objPostExtra ->view_post_dislikeDeatilsByPostID($postID);
		$countofpostTotalDislike=count($postTotalDislike);		
		$totalDislikeText='';
		$postLikeByMember=$objPostExtra ->view_post_likeForPostIDByMember($postID,$loggedin_member_id_for_postExtra);
		$countofpostLikeByMember=count($postLikeByMember);
		$postDislikeByMember=$objPostExtra ->view_post_dislikeForPostIDByMember($postID,$loggedin_member_id_for_postExtra);
		$countofpostDislikeByMember=count($postDislikeByMember);
		
		
		
		if($countofpostLikeByMember>0){
			foreach($currentMemberResultForPostExtra as $columnCurrentMember => $valueCurrentMember) {					
				$currentMemberUsername=$valueCurrentMember['username'];
				$totalLikeTextInner.='<a title="'.$currentMemberUsername.'" href="'.SITE_URL.'/i/'.$currentMemberUsername.'" >You </a> ';
			}
			
		}
		$a=0;
		foreach($postTotalLike as $columnLikes => $valueLikes) {
			$likedMemberObj=$objMember->select_member_byID($valueLikes['member_id']);			
			
			foreach($likedMemberObj as $columnMemberLike => $valueMemberLike) {
				$likedMemberID=$valueMemberLike['member_id'];
				$likedMemberUsername=$valueMemberLike['username'];
				if($likedMemberID == $loggedin_member_id_for_postExtra){
					continue;
				}
				else{
					$totalLikeTextInner.='<a title="'.$likedMemberUsername.'" href="'.SITE_URL.'/'.$likedMemberUsername.'" >'.$likedMemberUsername.'</a>';
				}				
			}
			
			$a++;
						
						
			if($a==2){
				$othercountText='';
				if($countofpostTotalLike-2>0){
					$othercountText=' .. and '.($countofpostTotalLike-2).' others';
				}
				$totalLikeTextInner.= $othercountText;
				break;
			}
			if($a>=1){
				$totalLikeTextInner.= ', ';
			}			
		}
		if($totalLikeTextInner!=''){
			$totalLikeText ='<div style="background:#EDEDED;padding:5px;" class="tl'.$encryptedPostID.' ">'.$totalLikeTextInner.' liked this post</div>';
		}
		if($countofpostTotalDislike>0){
			$totalDislikeText='<div style="background:#EDEDED;padding:5px;" class="tdl'.$encryptedPostID.'">'.$countofpostTotalDislike.' persons disliked this post</div>';
		}		
		
		
		
		$innerhtml='<div class="tlatdl'.$encryptedPostID.'">';
		$innerhtml .=$totalLikeText;
		$innerhtml .=$totalDislikeText;
		$innerhtml .='</div>';
		
		return $innerhtml;
	}
}

?>