<?php

require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');

$item=$_POST['item'];
$loggedin_member_id_for_ajax = $_SESSION['SESS_MEMBER_ID'];
$encypted_member_id=$QbSecurity->QB_AlphaID($loggedin_member_id_for_ajax );
if($item =='ads'){
	$ads_ID_From_Post=$_POST['ads'];
	$ads_action=$_POST['action'];
	$result['msg']='done';
	if($ads_ID_From_Post!=''){
		
		if($ads_action=='i'){
			$adsID=$QbSecurity->QB_AlphaID($ads_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_ads.php');
			$obj = new ads(); 		
			$insertedID=$obj ->insert_ads_like($adsID,$loggedin_member_id_for_ajax);
			if($insertedID>0){								
				$result['msg']='done';
				$result['likeLink']='<a href="javascript: void(0)" class="ads_unlike qm'.$encypted_member_id.'" id="'.$ads_ID_From_Post.'"  title="Unlike">Unlike</a>';
				$result['likeText']='You liked this';				
			}
			else{
				$result['msg']='Error';				
			}	
		}
		else if($ads_action=='d'){
			$adsID=$QbSecurity->QB_AlphaID($ads_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_ads.php');
			$obj = new ads(); 		
			$affected=$obj ->delete_ads_like($adsID,$loggedin_member_id_for_ajax);
			if($affected==1){				
				$result['msg']='done';
				$result['likeLink']='<a href="javascript: void(0)" class="ads_like qm'.$encypted_member_id.'" id="'.$ads_ID_From_Post.'"    title="Like">Like</a>';
				$result['likeText']='You unliked this';
			}
			else{				
				$result['msg']='Error';
			}
			
		}
		
			
	}
	else{
		$result['msg']='Error';
	}
	
	print json_encode($result);
		
}
else if($item =='post'){
	$post_ID_From_Post='';
	if(isset($_POST['post'])){
		$post_ID_From_Post=$_POST['post'];
	}
	$post_action=$_POST['action'];
	$result['msg']='done';		
	if($post_ID_From_Post!=''){
		
		if($post_action=='like'){
			$postID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/post_extra_totalLikeandDislike.php');
			$obj = new posts(); 		
			$insertedID=$obj ->insert_post_like($postID,$loggedin_member_id_for_ajax);			
			if($insertedID>0){
				$objPostExtraTotalLikeandDislike = new post_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objPostExtraTotalLikeandDislike ->extra_widget($postID,$post_ID_From_Post);								
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_unlike" href="javascript: void(0)">Unlike</a>';
				$result['likeLink2']='<a id="'.$post_ID_From_Post.'" class="walls_dislike" href="javascript: void(0)">Dislike</a>';
				$result['likeText']='You liked this';
				$result['likeChange']=$totalLikeandDisLikeText;				
			}
			else{
				$result['msg']='Error';				
			}	
		}
		else if($post_action=='unlike'){
			$postID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/post_extra_totalLikeandDislike.php');
			$obj = new posts(); 		
			$affected=$obj ->delete_post_like($postID,$loggedin_member_id_for_ajax);
				
			if($affected>0){
				$objPostExtraTotalLikeandDislike = new post_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objPostExtraTotalLikeandDislike ->extra_widget($postID,$post_ID_From_Post);											
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_like" href="javascript: void(0)">Like</a>';
				$result['likeText']='You unliked this';	
				$result['likeChange']=$totalLikeandDisLikeText;			
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		else if($post_action=='dislike'){
			$postID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/post_extra_totalLikeandDislike.php');
			$obj = new posts(); 		
			$affected=$obj ->insert_post_dislike($postID,$loggedin_member_id_for_ajax);
			
			if($affected>0){
				$objPostExtraTotalLikeandDislike = new post_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objPostExtraTotalLikeandDislike ->extra_widget($postID,$post_ID_From_Post);											
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_undislike" href="javascript: void(0)">Undislike</a>';
				$result['likeLink2']='<a id="'.$post_ID_From_Post.'" class="walls_like" href="javascript: void(0)">Like</a>';
				$result['likeText']='You disliked this';
				$result['likeChange']=$totalLikeandDisLikeText;					
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		else if($post_action=='undislike'){
			$postID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/post_extra_totalLikeandDislike.php');
			$obj = new posts(); 		
			$affected=$obj ->delete_post_dislike($postID,$loggedin_member_id_for_ajax);
			
			if($affected>0){
				$objPostExtraTotalLikeandDislike = new post_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objPostExtraTotalLikeandDislike ->extra_widget($postID,$post_ID_From_Post);											
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_dislike" href="javascript: void(0)">Dislike</a>';
				$result['likeText']='You undisliked this';
				$result['likeChange']=$totalLikeandDisLikeText;					
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		else if($post_action=='d'){
			$postID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			$obj = new posts(); 		
			$affected=$obj ->delete_post($postID);
			
			if($affected>0){								
				$result['msg']='done';							
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		else if($post_action=='insertcomment'){
			$commentContent=$_POST['content'];
			$postID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/comments.php');
			$obj = new posts(); 		
			$affected=$obj ->insert_post_comment($postID,$loggedin_member_id_for_ajax,$commentContent);
			
			if($affected>0){	
				$objComment = new Comment();
				$commentText=$objComment->showComments($postID,$post_ID_From_Post);							
				$result['msg']='done';
				$result['commentChange']=$commentText;							
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		else if($post_action=='reportPost'){
			$reportContent=$_POST['content'];
			$postID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');			
			$obj = new posts(); 				
			$affected=$obj ->insert_post_report($loggedin_member_id_for_ajax,$postID,$reportContent);			
			if($affected>0){														
				$result['msg']='done';
										
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		else if($post_action=='comment_like'){
			$commentID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');	
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/comment_extra_totalLikeandDislike.php');		
			$obj = new posts(); 		
			$insertedID=$obj ->insert_comment_like($commentID,$loggedin_member_id_for_ajax);			
			if($insertedID>0){
				$objPostExtraTotalLikeandDislike = new comment_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objPostExtraTotalLikeandDislike ->extra_widget($commentID,$post_ID_From_Post);								
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_comment_unlike" href="javascript: void(0)">Unlike</a>';
				$result['likeLink2']='<a id="'.$post_ID_From_Post.'" class="walls_comment_dislike" href="javascript: void(0)">Dislike</a>';
				$result['likeText']='You liked this';
				$result['likeChange']=$totalLikeandDisLikeText;				
			}
			else{
				$result['msg']='Error';				
			}	
		}
		else if($post_action=='comment_unlike'){
			$commentID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/comment_extra_totalLikeandDislike.php');				
			$obj = new posts(); 		
			$affected=$obj ->delete_comment_like($commentID,$loggedin_member_id_for_ajax);			
			if($affected>0){
				$objPostExtraTotalLikeandDislike = new comment_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objPostExtraTotalLikeandDislike ->extra_widget($commentID,$post_ID_From_Post);								
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_comment_like" href="javascript: void(0)">Like</a>';
								
				$result['likeText']='You unliked this';
				$result['likeChange']=$totalLikeandDisLikeText;				
			}
			else{
				$result['msg']='Error';				
			}	
		}
		else if($post_action=='comment_dislike'){
			$commentID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/comment_extra_totalLikeandDislike.php');
			$obj = new posts(); 		
			$affected=$obj ->insert_comment_dislike($commentID,$loggedin_member_id_for_ajax);
			
			if($affected>0){
				$objPostExtraTotalLikeandDislike = new comment_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objPostExtraTotalLikeandDislike ->extra_widget($commentID,$post_ID_From_Post);											
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_comment_undislike" href="javascript: void(0)">Undislike</a>';
				$result['likeLink2']='<a id="'.$post_ID_From_Post.'" class="walls_comment_like" href="javascript: void(0)">Like</a>';
				$result['likeText']='You disliked this';
				$result['likeChange']=$totalLikeandDisLikeText;					
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		else if($post_action=='comment_undislike'){
			$commentID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/comment_extra_totalLikeandDislike.php');
			$obj = new posts(); 		
			$affected=$obj ->delete_comment_dislike($commentID,$loggedin_member_id_for_ajax);
			
			if($affected>0){
				$objPostExtraTotalLikeandDislike = new comment_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objPostExtraTotalLikeandDislike ->extra_widget($commentID,$post_ID_From_Post);											
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_comment_dislike" href="javascript: void(0)">Dislike</a>';				
				$result['likeText']='You undisliked this';
				$result['likeChange']=$totalLikeandDisLikeText;					
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		else if($post_action=='insertcommentreply'){
			$replyContent=$_POST['content'];
			$commentID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/comment_reply.php');
			$obj = new posts(); 		
			$affected=$obj ->insert_comment_reply($commentID,$loggedin_member_id_for_ajax,$replyContent);
			
			if($affected>0){	
				$objCommentReply = new CommentReply();
				$viewAllRplForComments=$objCommentReply->showReply($commentID,$post_ID_From_Post,0);											
				$result['msg']='done';
				$result['replyChange']=$viewAllRplForComments;							
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		else if($post_action=='insertReplyreply'){
			$replyContent=$_POST['content'];
			$replyID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/replys_reply.php');			
			$obj = new posts(); 		
			$affected=$obj ->insert_comment_replys_reply($replyID,$loggedin_member_id_for_ajax,$replyContent);
			
			if($affected>0){	
				$replyReplyObj=new replyReply();
				$viewAllRplForReply=$replyReplyObj->showReply($replyID,$post_ID_From_Post,0);											
				$result['msg']='done';
				$result['replyChange']=$viewAllRplForReply;							
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		else if($post_action=='viewallReply'){			
			$commentID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);			
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/comment_reply.php');
			$objCommentReply = new CommentReply();
			$viewAllRplForComments=$objCommentReply->showReply($commentID,$post_ID_From_Post,0);
			$result['msg']='done';
			$result['replyChange']=$viewAllRplForComments;			
		}
		else if($post_action=='viewallReply2'){			
			$replyID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);			
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/replys_reply.php');
			$replyReplyObj=new replyReply();
			$viewAllRplForReply=$replyReplyObj->showReply($replyID,$post_ID_From_Post,0);
			$result['msg']='done';
			$result['replyChange']=$viewAllRplForReply;			
		}
		else if($post_action=='reply_like'){
			$replyID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');	
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/reply_extra_totalLikeandDislike.php');		
			$obj = new posts(); 		
			$insertedID=$obj ->insert_reply_like($replyID,$loggedin_member_id_for_ajax);			
			if($insertedID>0){
				$objCReplyExtraTotalLikeandDislike = new reply_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objCReplyExtraTotalLikeandDislike->extra_widget($replyID,$post_ID_From_Post);								
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_reply_unlike" href="javascript: void(0)">Unlike</a>';
				$result['likeLink2']='<a id="'.$post_ID_From_Post.'" class="walls_reply_dislike" href="javascript: void(0)">Dislike</a>';
				$result['likeText']='You liked this';
				$result['likeChange']=$totalLikeandDisLikeText;				
			}
			else{
				$result['msg']='Error';				
			}	
		}
		else if($post_action=='reply_unlike'){
			$replyID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/reply_extra_totalLikeandDislike.php');							
			$obj = new posts(); 		
			$affected=$obj ->delete_reply_like($replyID,$loggedin_member_id_for_ajax);			
			if($affected>0){
				$objCReplyExtraTotalLikeandDislike = new reply_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objCReplyExtraTotalLikeandDislike->extra_widget($replyID,$post_ID_From_Post);								
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_reply_like" href="javascript: void(0)">Like</a>';				
				$result['likeText']='You unliked this';
				$result['likeChange']=$totalLikeandDisLikeText;				
			}
			else{
				$result['msg']='Error';				
			}	
		}	
		else if($post_action=='reply_dislike'){
			$replyID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');	
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/reply_extra_totalLikeandDislike.php');		
			$obj = new posts(); 		
			$insertedID=$obj ->insert_reply_dislike($replyID,$loggedin_member_id_for_ajax);			
			if($insertedID>0){
				$objCReplyExtraTotalLikeandDislike = new reply_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objCReplyExtraTotalLikeandDislike->extra_widget($replyID,$post_ID_From_Post);								
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_reply_undislike" href="javascript: void(0)">Undislike</a>';
				$result['likeLink2']='<a id="'.$post_ID_From_Post.'" class="walls_reply_like" href="javascript: void(0)">Like</a>';
				$result['likeText']='You liked this';
				$result['likeChange']=$totalLikeandDisLikeText;								
			}
			else{
				$result['msg']='Error';				
			}	
		}
		else if($post_action=='reply_undislike'){
			$replyID=$QbSecurity->QB_AlphaID($post_ID_From_Post,true);		
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/reply_extra_totalLikeandDislike.php');
			$obj = new posts(); 		
			$affected=$obj ->delete_reply_dislike($replyID,$loggedin_member_id_for_ajax);
			
			if($affected>0){
				$objCReplyExtraTotalLikeandDislike = new reply_extra_totalLikeandDislike();
				$totalLikeandDisLikeText=$objCReplyExtraTotalLikeandDislike->extra_widget($replyID,$post_ID_From_Post);											
				$result['msg']='done';
				$result['likeLink']='<a id="'.$post_ID_From_Post.'" class="walls_reply_dislike" href="javascript: void(0)">Dislike</a>';				
				$result['likeText']='You undisliked this';
				$result['likeChange']=$totalLikeandDisLikeText;					
			}
			else{
				$result['msg']='Error';				
			}
			
		}
		
		
		print json_encode($result);
			
	}
	else if($post_action=='getPrevious'){
		$encryptedWallID=$_POST['c'];
		$encryptedItemID=$_POST['d'];
		$result=array();		
			
		include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/posts.php');
		$postWidgetObjAjax=new postWidget();
		$result=$postWidgetObjAjax->getPosts($encryptedWallID,$encryptedItemID,'getPrevious');
		
		print $result;
		
	}
	else if($post_action=='getLatest'){
		$encryptedWallID=$_POST['c'];
		$encryptedItemID=$_POST['d'];
		$result=array();
				
		include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/posts.php');
		$postWidgetObjAjax=new postWidget();
		$result=$postWidgetObjAjax->getPosts($encryptedWallID,$encryptedItemID,'getLatest');
		
		print $result;
		
	}
	else if($post_action=='updateStatus'){
		$content=$_POST['status'];
		$wall=$_POST['c'];
		$wallItem=$_POST['d'];
		$wallID=$QbSecurity->QB_AlphaID($wall,true);		
		$objLookupClass=new lookup();
		$wallName=$objLookupClass->getValueByKey($wallID);
		$ip = $_SERVER['REMOTE_ADDR'];	
		$affected=0;
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		
								
		include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');			
		$obj = new posts(); 
				
		$affected=$obj ->insert_post_status($loggedin_member_id_for_ajax,$content,$wall,$ip,$wallItem,$type);		
		if($wallName =='Group Wall'){
			$wall='group';
			$groupID=$QbSecurity->QB_AlphaID($wallItem,true);
			$affected6=$obj ->insert_post_meta($affected,'group_id',$groupID);
		}
		if($affected>0){
			if(isset($_POST['img'])){
				$img=$_POST['img'];
				$affected1=$obj ->insert_post_meta($affected,'fetch_image',$img);
			}
			if(isset($_POST['title'])){
				$title=$_POST['title'];				
				$affected2=$obj ->insert_post_meta($affected,'fetch_title',$title);
				
				
			}
			if(isset($_POST['url'])){
				$url=$_POST['url'];
				$affected3=$obj ->insert_post_meta($affected,'fetch_url',$url);			
			}
			if(isset($_POST['desc'])){
				$desc=$_POST['desc'];
				$affected4=$obj ->insert_post_meta($affected,'fetch_desc',$desc)	;	
			}			
													
			$result['msg']='done';										
		}
		else{
			$result['msg']='Error';				
		}
		print json_encode($result);
			
	}
	else if($post_action=='updateImage'){
		$content=$_POST['status'];
		$wall=$_POST['c'];
		$wallItem=$_POST['d'];
		$uploadID=$_POST['u'];
		$ip = $_SERVER['REMOTE_ADDR'];	
		$affected=0;
		$upload_image='';
		if($wall =='qi'){
			$wall='world';
		}
		else if($wall =='6q'){
			$wall='group';
		}						
		include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
		//include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');			
		$obj = new posts();
		$objMisc = new misc(); 
		if($uploadID!=0){
			$upload_imageResult=$objMisc->getUploadedImagenameByID($uploadID);
			foreach($upload_imageResult as $valueImageResult){
				$upload_image=$valueImageResult['image_name'];
			}
			$upload_image='uploads/'.$upload_image;
		}
		
		if($wall !='group'){		
			$affected=$obj ->insert_post_image($loggedin_member_id_for_ajax,$content,$wall,$ip,0,$upload_image,$wallItem);			
		}
		else{
			//$encGroupID=$_POST['d'];
			//include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_groups.php');
			//$objGroup = new groups();
			//$affected=$objGroup->insert_post_status($loggedin_member_id_for_ajax,$content,$encGroupID,0);
		}
		
		if($affected>0){												
			$result['msg']='done';										
		}
		else{
			$result['msg']='Error';				
		}
		print json_encode($result);
			
	}
	else if($post_action=='updateVideo'){

		$title=$_POST['title'];
		$description=$_POST['desc'];
		$wall=$_POST['c'];
		$wallItem=$_POST['d'];
		$videoname=$_POST['videoname'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$affected=0;
		$upload_video='';
		if($wall =='qi'){
			$wall='world';
		}
		else if($wall =='6q'){
			$wall='group';
		}
		include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
		//include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
		$obj = new posts();
		$objMisc = new misc();
	
		if($wall !='group'){
			$affected=$obj ->insert_post_video($loggedin_member_id_for_ajax,$title,$description,$wall,$ip,0,$videoname,$wallItem);
		}
		else{
			//$encGroupID=$_POST['d'];
			//include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_groups.php');
			//$objGroup = new groups();
			//$affected=$objGroup->insert_post_status($loggedin_member_id_for_ajax,$content,$encGroupID,0);
		}
	
		if($affected>0){
			$result['msg']='done';
		}
		else{
			$result['msg']='test'.$affected.'Error';
		}
		print json_encode($result);
			
	}	
	else{
		$result['msg']='Error';
		print json_encode($result);
	}
	
	
		
}
else if($item =='user'){
	$post_action=$_POST['action'];	
	if($post_action=='search'){
		$post_action=$_POST['action'];
		$search_text=$_POST['s'];
		
		// where are we posting to?
		$url = SITE_URL.'/qb_widgets/search_user.php';
		/*
		// what post fields?
		$fields = array(
		   'searchtext' => $search_text
		);
		
		// build the urlencoded data
		$postvars = http_build_query($fields);
		
		// open connection
		$ch = curl_init();
		
		// set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		// execute post
		$result2 = curl_exec($ch);
		$msg = curl_error($ch);
		// close connection
		curl_close($ch);
		*/
$postdata = http_build_query(
    array(
        'searchtext' => $search_text,
        'memeberID' =>$loggedin_member_id_for_ajax
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

$result= file_get_contents($url, false, $context);

print $result;
exit;
	}
	else if($post_action=='acceptRequest'){
	$post_action=$_POST['action'];
	$encryptedItemID=$_POST['d'];
		if($encryptedItemID!='')
		{
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
			$obj = new member1();
			$affected=$obj ->accept_friend_request($encypted_member_id,$encryptedItemID);
			if($affected){												
			$result['msg']='done';										
			}
			else{
				$result['msg']='Error';				
			}
		print json_encode($result);
		}
		else{
		$result['msg']='Error';
		print json_encode($result);
		}
	
	}else if($post_action=='cancelRequest'){
	$post_action=$_POST['action'];
	$encryptedItemID=$_POST['d'];
		if($encryptedItemID!='')
		{
			include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
			$obj = new member1();
			$affected=$obj ->cancel_friend_request($encypted_member_id,$encryptedItemID);
			if($affected){												
			$result['msg']='done';										
			}
			else{
				$result['msg']='Error';				
			}
		print json_encode($result);
		}
		else{
		$result['msg']='Error';
		print json_encode($result);
		}
	
	}
	else{
		$result['msg']='Error';
		print json_encode($result);
	}
	
}
else if($item =='menu'){
	$menu_action=$_POST['action'];
	if($menu_action=='getFriendsList'){		
		include_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/friends_request_notification_extra.php');
		$objExtraWidget=new friendsRequestNotificationExtraWidget();			
		$innerHtml=$objExtraWidget->getPanel($loggedin_member_id_for_ajax);		
		print $innerHtml;
	}
	if($menu_action=='getFriendsMenu'){
		include_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/friends_request_notification.php');	
		$objFriendsRequest = new friendsRequestNotificationWidget();		
		$innerHtml=$objFriendsRequest->getPanel($loggedin_member_id_for_ajax);		
		print $innerHtml;
	}
	if($menu_action=='getNotificationCount'){
		include_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/view_notification.php');	
		$objViewNotification = new viewNotificationWidget(); 		
		$innerHtml=$objViewNotification->getPanel($loggedin_member_id_for_ajax);		
		print $innerHtml;
	}
	if($menu_action=='getNotificationList'){
		include_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/view_notification_extra.php');	
		$objViewNotificationExtra = new viewNotificationExtraWidget(); 		
		$innerHtml=$objViewNotificationExtra->getPanel($loggedin_member_id_for_ajax);		
		print $innerHtml;
	}
	
}
else{
	print "Error123";
}




?>