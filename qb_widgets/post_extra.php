<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/post_extra_totalLikeandDislike.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/comments.php');




class post_extra
{
	function extra_widget($country,$postID,$encryptedPostID,$postType){			
		
		$loggedin_member_id_for_postExtra = $_SESSION['SESS_MEMBER_ID'];
		$objMember = new member1(); 
		$currentMemberResultForPostExtra=$objMember->select_member_byID($loggedin_member_id_for_postExtra);		
		$objPostExtra = new posts();			
		$postLikeByMember=$objPostExtra ->view_post_likeForPostIDByMember($postID,$loggedin_member_id_for_postExtra);
		$countofpostLikeByMember=count($postLikeByMember);
		$postDislikeByMember=$objPostExtra ->view_post_dislikeForPostIDByMember($postID,$loggedin_member_id_for_postExtra);
		$countofpostDislikeByMember=count($postDislikeByMember);
		//echo "<pre>For displaying share icons";
		//print_r(isPageVisibleForEveryone());
		//echo "<pre>outside";
        if(!isPageVisibleForEveryone()) {
			//echo "<pre>For displaying share icons21321";
            $panel1 = '';
            $panel1 .= '<div class="walls-extra-panel wxp' . $encryptedPostID . '" style="padding:5px;font-size: 11px;">';
            $panel1 .= '<span id="wallsLikeP' . $encryptedPostID . '" style="margin-right:5px;">';
            if ($countofpostLikeByMember > 0) {
                $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_unlike" href="javascript: void(0)">Unlike</a>';
            } else {
                $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_like" href="javascript: void(0)">Like</a>';
            }
            $panel1 .= '</span>';
            $panel1 .= '<span id="wallsDislikeP' . $encryptedPostID . '" style="margin-right:5px;">';
            if ($countofpostDislikeByMember > 0) {
                $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_undislike" href="javascript: void(0)">Undislike</a>';
            } else {
                $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_dislike" href="javascript: void(0)">Dislike</a>';
            }
            $panel1 .= '</span>';
            $panel1 .= '<span>';
            $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_comment" href="javascript: void(0)">Comment</a> ';
            $panel1 .= '</span>';
            $panel1 .= '<span>';
			//echo "<pre>For displaying share icons1321312";
            $panel1 .= '<a id="' . $postID . '" class="walls_share" href="javascript: void(0)" data-type="' . $postType . '">Share</a> ';
            $panel1 .= '</span>';
            $panel1 .= '<span>';
            $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_flag_status" href="javascript: void(0)"> Flag This Status</a> ';
            $panel1 .= '</span>';
            if ($postType == 0) {
                $panel1 .= '<span>';
                $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_translate" href="javascript: void(0)"> Translate</a> ';
                $panel1 .= '</span>';
            }

            $panel1 .= '</div>';
        }else if($loggedin_member_id_for_postExtra!=0)
		{
			$panel1 = '';
            $panel1 .= '<div class="walls-extra-panel wxp' . $encryptedPostID . '" style="padding:5px;font-size: 11px;display: inline !important;;">';
            $panel1 .= '<span id="wallsLikeP' . $encryptedPostID . '" style="margin-right:5px;">';
            if ($countofpostLikeByMember > 0) {
                $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_unlike" href="javascript: void(0)">Unlike</a>';
            } else {
                $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_like" href="javascript: void(0)">Like</a>';
            }
            $panel1 .= '</span>';
            $panel1 .= '<span id="wallsDislikeP' . $encryptedPostID . '" style="margin-right:5px;">';
            if ($countofpostDislikeByMember > 0) {
                $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_undislike" href="javascript: void(0)">Undislike</a>';
            } else {
                $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_dislike" href="javascript: void(0)">Dislike</a>';
            }
            $panel1 .= '</span>';
            $panel1 .= '<span>';
            $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_comment" href="javascript: void(0)">Comment</a> ';
            $panel1 .= '</span>';
            $panel1 .= '<span>';
			//echo "<pre>For displaying share icons1321312";
            $panel1 .= '<a id="' . $postID . '" class="walls_share" href="javascript: void(0)" data-type="0">Share</a> ';
            $panel1 .= '</span>';
            $panel1 .= '<span>';
            $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_flag_status" href="javascript: void(0)"> Flag This Status</a> ';
            $panel1 .= '</span>';
            if ($postType == 0) {
                $panel1 .= '<span>';
                $panel1 .= '<a id="' . $encryptedPostID . '" class="walls_translate" href="javascript: void(0)"> Translate</a> ';
                $panel1 .= '</span>';
            }

            $panel1 .= '</div>';
		}
		
		$commentText='';
		$objComment = new Comment();
		$commentText=$objComment->showComments($postID,$encryptedPostID);
		$objPostExtraTotalLikeandDislike = new post_extra_totalLikeandDislike();
		$totalLikeandDisLikeText=$objPostExtraTotalLikeandDislike ->extra_widget($postID,$encryptedPostID);
		
		$innerhtml='';
		$innerhtml .=$panel1;	
		$innerhtml .=$totalLikeandDisLikeText;
		$innerhtml .=$commentText;
			
		//print_r($innerhtml);

		return $innerhtml;
	}
}

?>