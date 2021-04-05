<?php
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
include($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_ads.php');
//require($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
$obj = new ads(); 
$adsResult=$obj->view_ads();
 $countOfAds=count($adsResult);
$member_id_for_ads = $_SESSION['SESS_MEMBER_ID'];
?>


<div class="adsPanelContainer" style="height: 450px;
    overflow-y: auto;
    width: 100%;">
<script> var lastIdForScrolling = <?php echo ($countOfAds-2); ?>;</script>
<?php 
$counter=0;
foreach($adsResult as $column => $value) {
$ads_id=$value['ads_id'];
$ads_title=$value['ads_title'];
$ads_content=$value['ads_content'];
$ads_pic=$value['ads_pic'];
$ads_url=$value['url'];
$ads_like_count=0;
$ads_like_count_member=0;
$ads_like_text='';
$counter=$counter+1;
$encypted_ads_id=$QbSecurity->QB_AlphaID($ads_id);
$encypted_member_id=$QbSecurity->QB_AlphaID($member_id_for_ads);

$ads_like_count_result=$obj->select_all_ads_like_byID($ads_id);
foreach($ads_like_count_result as $columnTitle => $valueTitle) {
		$ads_like_count=$valueTitle['count'];
}

$ads_like_count_member_result=$obj->select_all_ads_like_byIDandMemberID($ads_id,$member_id_for_ads);
foreach($ads_like_count_member_result as $columnTitle => $valueTitle) {
		$ads_like_count_member=$valueTitle['count'];
}

if($ads_like_count>0){
	if($ads_like_count_member>0){
		if($ads_like_count==1){
			$ads_like_text="You liked this..";
		}
		else{
			$ads_like_text="You and ".($ads_like_count-1)." peoples liked this..";
		}		
	}
	else{
		$ads_like_text=$ads_like_count." peoples liked this..";
	}
	

}

/*
if(isset($_SESSION['lang'])&&($_SESSION['lang']!='en')){
	$language=$_SESSION['lang'];
	$adsTitleResult=$obj->select_language_ads_title_byID($ads_id,$language);
	foreach($adsTitleResult as $columnTitle => $valueTitle) {
		$ads_title=$valueTitle['data'];
	}
	$adsDescripttionResult=$obj->select_language_ads_description_byID($ads_id,$language);
	foreach($adsDescripttionResult as $columnDesc => $valueDesc) {
		$ads_content=$valueTitle['data'];
	}
}
*/

?>

	<div style="padding: 5px;border-bottom:1px solid #ccc;border-left:1px solid #ddd;border-right:1px solid #ddd;" class="adsMsg<?Php echo $encypted_ads_id;?> adsContent clearfix adsc<?Php echo $counter;?>">
		<a  target="_blank" style="font-weight: bold; font-size: 12px;" href="<?php echo $ads_url;?>"><?php echo $ads_title;?></a>
		<?php if(empty($ads_pic)!=1){ ?>
			<a href="<?php echo $ads_url;?>" target="_blank"><img style="width:100%;" src="<?php echo $base_url.$ads_pic;?>"/></a>
		<?php } ?>
		<div><?php echo $ads_content;?></div>
		<?php if($ads_like_count>0){ ?>
			<div id="adstotal<?Php echo $encypted_ads_id;?>" style="color:#337AB7;">
				<a href="ads_likes.php?id=<?php echo $ads_id;?>" class="show_cmt_linkClr" data-toggle="modal" data-target="#myModal"><?php echo $ads_like_text;?></a>				
			</div>
		<?php } ?>
		<?php if($ads_like_count_member>0){ ?>
			<div id="adslike<?Php echo $encypted_ads_id;?>"><a href="javascript: void(0)" class="ads_unlike qm<?Php echo $encypted_member_id;?>" id="<?Php echo $encypted_ads_id;?>"  title="<?php echo $lang['Unlike']; ?>"><?php echo $lang['Unlike']; ?></a></div>
			
		<?php }
		      else{ ?>
			<div id="adslike<?Php echo $encypted_ads_id;?>"><a href="javascript: void(0)" class="ads_like qm<?Php echo $encypted_member_id;?>" id="<?Php echo $encypted_ads_id;?>"  title="<?php echo $lang['like']; ?>"><?php echo $lang['like']; ?></a></div>
		<?php }?>
		
	</div>
	
<?php } ?>
<div class="clearfix"></div>
</div>

   