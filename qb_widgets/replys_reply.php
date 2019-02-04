<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');

class replyReply
{
	function showReply($replyId,$encryptedreplyId,$limit){			
		
		include_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
		include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$loggedin_member_id_for_reply = $_SESSION['SESS_MEMBER_ID'];
		$objPostExtra = new posts();
		$objMemberReply = new member1(); 
		$viewAllRplForReply=0;
		$rplReply="";
		$viewTotalRplForReply=$objPostExtra ->viewAllCountReplysReplyById($replyId);
		
		$countOfAllReply=0;
		foreach($viewTotalRplForReply as $valueTotalRplForReply) {
			$countOfAllReply=$valueTotalRplForReply['count'];
		}
			
		if($limit==0){
			$viewAllRplForReply=$objPostExtra ->viewAllReplysRplById($replyId);
		}
		else{
			$viewAllRplForReply=$objPostExtra ->viewReplysRplById($replyId,$limit);
			
			if($countOfAllReply>$limit){
				$rplReply .='<div><img alt="" style="float:left;" src="'.SITE_URL.'/images/cicon.png">';
				$rplReply .='<a id="'.$encryptedreplyId.'" class="ViewAllReply2" href="javascript: void(0)">	View '.($countOfAllReply-$limit).' more reply</a></div>';
			}
			
		}		
		foreach($viewAllRplForReply as $valueRplForReply) {
			$QbSecurityReply=new QB_SqlInjection();			
			$rplCommentmemberId=$valueRplForReply['member_id'];	
			$rplId=$valueRplForReply['reply_id'];
			$encryptedReplyId2=$QbSecurityReply->QB_AlphaID($rplId);						
			$commentReplyedUserName=$valueRplForReply['username'];
			$commentReplyedContent=$valueRplForReply['content'];
			$rplProfileImage='';
			$rplCommentUser='';
			$deleteReply="";
			$rplProfileImage=$objMemberReply->select_member_meta_value($rplCommentmemberId,'current_profile_image');
			if($rplProfileImage){			
					$rplProfileImage=SITE_URL.'/'.$rplProfileImage;	
			}
			else{
				$rplProfileImage=SITE_URL.'/images/default.png';
			}							
			$dateReplyed=time_stamp_vj($valueRplForReply['date_created']);
			$rplCommentUser.='<div class=" rr'.$encryptedReplyId2.' replyreply_'.$valueRplForReply['id'].'" style="background:#EDEDED;padding:5px;margin-bottom: 3px;">';
			$rplCommentUser.='<div class="pull-left" style="width:15%;">';
			$rplyUserLink='';			
			if($loggedin_member_id_for_reply== $rplCommentmemberId){
				$rplyUserLink=SITE_URL.'/i/'.$commentReplyedUserName;				
				/*$deleteReply ='<div class="pull-right delReply"><a  id="'.$encryptedReplyId2.'" class="delwallReplyReply" href="javascript: void(0)" title="'.$lang['Delete update'].'" ><span class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete this reply.  "></span></a></div>';*/
				$deleteReply ='<div class="pull-right delReply"><a  id="'.$valueRplForReply['id'].'" class="delwallReplyReply" href="javascript: void(0)" title="'.$lang['Delete update'].'" ><span class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete this reply.  "></span></a></div>';
			}
			else{
				$rplyUserLink=SITE_URL.'/'.$commentReplyedUserName;					
			}			
			
			$rplCommentUser.='<a href="'.$rplyUserLink.'"><img style="width:100%;border:1px solid #ccc;"  src="'.$rplProfileImage.'" /></a>';
			$rplCommentUser.='</div>';
			$rplCommentUser.='<div class="pull-left" style="width:85%;padding: 5px;">';
			$rplCommentUser.=$deleteReply;
			$rplCommentUser.='<div>';
				$rplCommentUser.='<a href="'.$rplyUserLink.'"><b>'.$commentReplyedUserName.'</b></a>';
			$rplCommentUser.='</div>';
			$rplCommentUser.='<div>';
			$rplCommentUser.=$commentReplyedContent;			
			$rplCommentUser.='</div>';
			$rplCommentUser.='<div style="color: gray; font-size: 10px;margin-top:5px;margin-bottom:5px;">'.$dateReplyed.'</div>';							
			$rplCommentUser.='</div>';
			$rplCommentUser.='<div class="clearfix"></div>';			
			$rplCommentUser.='</div>';
			$rplReply .=$rplCommentUser;
		}
				

		return $rplReply;
	}
	
}

?>