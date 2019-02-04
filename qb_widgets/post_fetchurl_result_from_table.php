<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');

class fetchURLpostmeta
{

	function fetchURL($postID){
		$objPost = new posts();
		$fetch_url_result=$objPost->check_post_meta($postID,'fetch_url');
		$fetch_title_result=$objPost->check_post_meta($postID,'fetch_title');
		$fetch_desc_result=$objPost->check_post_meta($postID,'fetch_desc');
		$fetch_image_result=$objPost->check_post_meta($postID,'fetch_image');
		$innerHtml='';
		if($fetch_image_result != 'qberror'){
			$innerHtml .='<div class="images">';
			$innerHtml .='<img src="'.$fetch_image_result.'" width="100%" >';
			$innerHtml .='</div>';
                        
		}
		$innerHtml .='<div class="info" style="font-weight:normal;font-size: 11px;">';
		if($fetch_title_result != 'qberror'){
			$innerHtml .='<div class="title" style="font-size: 12px;border-bottom: 1px solid #ddd;">'.$fetch_title_result .'</div>';
		}
		if($fetch_url_result!= 'qberror'){
//			$innerHtml .='<div class="url"><a style="text-decoration:none;font-weight:normal;" target="_blank" href="'.$fetch_url_result.'" title="'.$fetch_title_result .'">'.substr($fetch_url_result ,0,35).'..</a></div>';	
		}			
		if($fetch_desc_result != 'qberror'){
//			$innerHtml .='<div class="desc">'.substr($fetch_desc_result ,0,100).'..</div>';
		}			
		$innerHtml .='</div>	';
		
		return $innerHtml;
	}
}

?>