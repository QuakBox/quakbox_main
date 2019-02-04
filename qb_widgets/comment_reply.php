<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/reply_extra.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/replys_reply.php');

class CommentReply
{
	function showReply($commentId,$encryptedcommentId,$limit){			
		
		include_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
		include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$loggedin_member_id_for_comment = $_SESSION['SESS_MEMBER_ID'];
		$objPostExtra = new posts();
		$objMemberReply = new member1(); 
		$viewAllRplForComments=0;
		$rplComment="";
		$viewTotalRplForComments=$objPostExtra ->viewAllCountCommentsRplByCommentId($commentId);
		
		$countOfAllReply=0;
		foreach($viewTotalRplForComments as $valueTotalRplForComment) {
			$countOfAllReply=$valueTotalRplForComment['count'];
		}
			
		if($limit==0){
			$viewAllRplForComments=$objPostExtra ->viewAllCommentsRplByCommentId($commentId);
		}
		else{
			$viewAllRplForComments=$objPostExtra ->viewCommentsRplByCommentId($commentId,$limit);
			
			if($countOfAllReply>$limit){
				$rplComment .='<div><img alt="" style="float:left;" src="'.SITE_URL.'/images/cicon.png">';
				$rplComment .='<a id="'.$encryptedcommentId.'" class="ViewAllReply" href="javascript: void(0)">	View '.($countOfAllReply-$limit).' more replys</a></div>';
			}
			
		}		
		foreach($viewAllRplForComments as $valueRplForComments) {
			$QbSecurityReply=new QB_SqlInjection();
			$replyExtraObj=new reply_extra();
			$replyReplyObj=new replyReply();
			$rplCommentmemberId=$valueRplForComments['member_id'];	
			$rplId=$valueRplForComments['reply_id'];
			$encryptedReplyId=$QbSecurityReply->QB_AlphaID($rplId);						
			$commentReplyedUserName=$valueRplForComments['username'];
			$commentReplyedContent=$valueRplForComments['content'];
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
			$dateReplyed=time_stamp_vj($valueRplForComments['date_created']);
			$rplCommentUser.='<div class=" r'.$encryptedReplyId.' reply_'.$encryptedReplyId.'" style="background:#fff;padding:5px;margin-bottom: 3px;">';
			$rplCommentUser.='<div class="pull-left" style="width:15%;">';
			$rplyUserLink='';			
			if($loggedin_member_id_for_comment == $rplCommentmemberId){
				$rplyUserLink=SITE_URL.'/i/'.$commentReplyedUserName;				
				$deleteReply ='<div class="pull-right delReply"><a  id="'.$encryptedReplyId.'" class="delwallReply" href="javascript: void(0)" title="'.$lang['Delete update'].'" ><span class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete this reply.  "></span></a></div>';							
			}
			else{
				$rplyUserLink=SITE_URL.'/'.$commentReplyedUserName;					
			}
			$replyExtraContent=$replyExtraObj->extra_widget($rplId,$encryptedReplyId);
			
			$rplCommentUser.='<a href="'.$rplyUserLink.'"><img style="width:100%;border:1px solid #ccc;"  src="'.$rplProfileImage.'" /></a>';
			$rplCommentUser.='</div>';
			$rplCommentUser.='<div class="pull-left" style="width:85%;padding: 5px;">';
			$rplCommentUser.=$deleteReply;
			$rplCommentUser.='<div>';
				$rplCommentUser.='<a href="'.$rplyUserLink.'"><b>'.$commentReplyedUserName.'</b></a>';
			$rplCommentUser.='</div>';
			$rplCommentUser.='<div>';
				$rplCommentUser.=$commentReplyedContent;
				//$contentPortion.=$dateReplyed;
			$rplCommentUser.='</div>';
			$rplCommentUser.='<div style="color: gray; font-size: 10px;margin-top:5px;margin-bottom:5px;">'.$dateReplyed.'</div>';	
			$rplCommentUser.=$replyExtraContent;
			$replysRepltText=$replyReplyObj->showReply($rplId,$encryptedReplyId,2);
			$rplCommentUser.='<div class="r2'.$encryptedReplyId.'">'.$replysRepltText.'</div>';					
			$rplCommentUser.='</div>';
			$rplCommentUser.='<div class="clearfix"></div>';
						
			$rplCommentUser.='</div>';
			$rplComment .=$rplCommentUser;
		}
				

		return $rplComment;
	}
	
}

?>