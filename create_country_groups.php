<?php 
	session_start();
	require_once('config.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$country_id = $_REQUEST['country_id'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Create New Group</title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>


</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
<div class="column_left">
	
    <div class="componentheading">
    <div id="submenushead">Create New Group</div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups_all.php">All Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="country_groups.php?member_id=<?php echo $country;?>">Groups</a></li>    
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_country_groups.php?country_id=<?php echo $country_id;?>">Create</a></li>
    <li style="padding:0 8px;"><a href="groups_search.php">Search</a></li>  
	</ul>
   </div>
   <div id="border">
<form name="find_friend" id="find_friend" action="action/create_country_group-exec.php" method="post">
<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
<input type="hidden" name="country_id" id="country_id" value="<?php echo $country_id;?>" />
<div style="width: 785px;min-height: 380px; line-height:1.5em;">
<p style="margin: 2em 0px;padding: 0px;">Create your own groups today. Created groups will be publicly accessible to users.</p>
<div style="font-style:italic; font-size:140;">
You have created <strong>0</strong> out of <strong>300</strong> allowed group creation.
</div>
<table cellpadding="0" cellspacing="1">
<tbody>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">*Group Name</label>
</td>
<td style="padding:5px; vertical-align:top;"><input id="name" class="required inputbox" type="text" value="" size="45" name="name"></td>
</tr>
<tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">*Description</label>
</td>
<td style="padding:5px; vertical-align:top;"><textarea style="rgb(255, 0, 0) !important; width:100%; height:110px;" id="name" class="required inputbox" type="text" value="" size="45" name="desciption"></textarea></td>
</tr>
<tr><td style="font-weight: bold;text-align: right;width: 130px; padding:5px;"><label style="font-weight: 700;text-align: right;" class="label title " title="" for="categoryid">*Category</label></td>
<td style="padding:5px; vertical-align:top;">
<select id="categoryid" class="required inputbox" name="categoryid">
<?php $group_sql = mysqli_query($con, "select * from groups_category");
while($group_res = mysqli_fetch_array($group_sql))
{
?>
<option value="<?php echo $group_res['id'];?>"><?php echo $group_res['name'];?></option>
<?php } ?>    
</select>
    </td>
    </tr>
    <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px; vertical-align:top;">
<label style="font-weight: 700;text-align: right;">*Group Type</label>
</td>
<td style="padding:5px; vertical-align:top;">
<div>
<input id="approve-open" type="radio" checked="checked" value="0" name="approvals"></input>
<label class="label lblradio" style="display:inline;" for="approve-open">Open</label>
</div>
<div style="margin-bottom:10px; font-size:90% !important;">Anyone can join and view this group. </div>
<div><input id="approve-private" type="radio" value="1" name="approvals"></input>
<label class="label lblradio" for="approve-private">Private</label>
</div>
<div style="margin-bottom:10px; font-size:90% !important;">This group requires approval for new members to join. Anyone can view the group's description. Only group members are allowed to see the group's content.  </div>
</tr>
<tr><td style="font-weight: bold;text-align: right;width: 130px; padding:5px; vertical-align:top;"><label style="font-weight: 700;text-align: right;" class="label title " title="">Discussion ordering			
    </label></td>
    <td style="padding:5px; vertical-align:top;"><div><input id="discussordering-lastreplied" type="radio" checked="checked" value="0" name="discussordering"></input><label class="label lblradio" for="discussordering-lastreplied">
      Order by last replied
    </label></div><div><input id="discussordering-creation" type="radio" value="1" name="discussordering"></input><label class="label lblradio" for="discussordering-creation">
      Order by creation date
    </label></div></td>
    </tr>
<tr><td style="font-weight: bold;text-align: right;width: 130px; padding:5px; vertical-align:top;"><label style="font-weight: 700;text-align: right;" class="label title " title="">Photos</label></td>
    <td style="padding:5px; vertical-align:top;"><div><input id="photopermission-disabled" type="radio" value="-1" name="photopermission"></input>
   <label class="label lblradio" for="photopermission-disabled">
      Disable group photos.
    </label>
    </div>
    <div><input id="photopermission-members" type="radio" checked="checked" value="0" name="photopermission"></input><label class="label lblradio" for="photopermission-members">
      Allow members to upload photos and create albums
    </label></div>
    <div><input id="photopermission-admin" type="radio" value="1" name="photopermission"></input><label class="label lblradio" for="photopermission-admin">
      Allow only group admins to upload photos and create albums.
    </label></div>
    </td>
    </tr>
    <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">Group Albums</label>
</td>
<td style="padding:5px; vertical-align:top;"><input id="grouprecentphotos-admin" type="text" value="6" size="1" name="grouprecentphotos"></input></td>
</tr>
<tr><td style="font-weight: bold;text-align: right;width: 130px; padding:5px; vertical-align:top;"><label style="font-weight: 700;text-align: right;" class="label title " title="">Videos</label></td>
    <td style="padding:5px; vertical-align:top;"><div>
    <input id="videopermission-disabled" type="radio" value="-1" name="videopermission"></input><label class="label lblradio" for="videopermission-disabled">
      Disable group videos.
    </label>
    </div>
    <div>
    <input id="videopermission-members" type="radio" checked="checked" value="0" name="videopermission"></input><label class="label lblradio" for="videopermission-members">
      Allow members to upload videos.
    </label>
    </div>
    <div>
    <input id="videopermission-admin" type="radio" value="1" name="videopermission"></input><label class="label lblradio" for="videopermission-admin">
      Allow only group admins to upload videos.
    </label>
    </div>
    </td>
    </tr>
        <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">Group Videos</label>
</td>
<td style="padding:5px; vertical-align:top;"><input id="grouprecentvideos-admin" type="text" value="6" size="1" name="grouprecentvideos"></input></td>
</tr>

<tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px; vertical-align:top;"><label style="font-weight: 700;text-align: right;" class="label title " title="">New member notification</label></td>
    <td style="padding:5px; vertical-align:top;">
    <div><input id="newmembernotification-enable" type="radio" checked="checked" value="1" name="newmembernotification"></input><label class="label lblradio" for="newmembernotification-enable">
      Enable
    </label>
    </div>
    <div>
    <input id="newmembernotification-disable" type="radio" value="0" name="newmembernotification"></input><label class="label lblradio" for="newmembernotification-disable">
      Disable
    </label>
    </div></td>
    </tr>
    
    <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px; vertical-align:top;"><label style="font-weight: 700;text-align: right;" class="label title " title="">Join request notification </label></td>
    <td style="padding:5px; vertical-align:top;">
    <div><input id="joinrequestnotification-enable" type="radio" checked="checked" value="1" name="joinrequestnotification"></input><label class="label lblradio" for="joinrequestnotification-enable">
      Enable
    </label>
    </div>
    <div>
    <input id="joinrequestnotification-disable" type="radio" value="0" name="joinrequestnotification"></input><label class="label lblradio" for="joinrequestnotification-disable">
      Disable
    </label>
    </div></td>
    </tr>
    
        <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px; vertical-align:top;"><label style="font-weight: 700;text-align: right;" class="label title " title="">Wall post notification </label></td>
    <td style="padding:5px; vertical-align:top;">
    <div><input id="wallnotification-enable" type="radio" checked="checked" value="1" name="wallnotification"></input><label class="label lblradio" for="wallnotification-enable">
      Enable
    </label>
    </div>
    <div>
   <input id="wallnotification-disable" type="radio" value="0" name="wallnotification"></input><label class="label lblradio" for="wallnotification-disable">
      Disable
    </label>
    </div></td>
    </tr>
    <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
</td>
<td style="padding:5px; vertical-align:top;"><span style="font-style:italic; line-height:140%;">Fields marked with an asterisk (*) are required.</span></td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
    <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
</td>
<td style="padding:5px; vertical-align:top;">
<input type="hidden" value="save" name="action"></input>
<input type="hidden" value="" name="groupid"></input>
<input class="button validateSubmit" type="submit" value="Create Group"></input>
<input class="button" type="button" value="Cancel" onclick="history.go(-1);return false;"></input>
<input type="hidden" value="1" name="326e4f73c340f29d8ce547ad40dc0e1b"></input>
</td>
</tr>
<tr>
</tbody>
</table>
</div>
</div>

</div><!--end column_left div-->

<!--Start column right-->
<div class="column_internal_right">
   <div id="ads" style="width:220; float:left;">
   <h3>Partners
   <a href="add_ads.php" style="margin-left:55px;">Create Ads</a>   
   </h3>
   </div>
   <?php 
   $ads_sql = mysqli_query($con, "select * from ads order by ads_id");
   while($ads_res = mysqli_fetch_array($ads_sql))
   {
   ?>
      
		<div style="border-bottom: 1px solid #DDDDDD;float: left;margin: 0px;padding-top: 0px;width: 220px;">
        <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">
        <a href=""><?php echo $ads_res['ads_title'];?></a>
        </div>
        <div style="float: left;padding-right: 8px; padding-top:3px; display:inline;">        
        <a href="" target="_blank">
        <img src="<?php echo $ads_res['ads_pic'];?>" width="100" height="72"/>
        </a>
         <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px;">
        <?php echo $ads_res['ads_content'];?>
        </div>
               
        <?php 

$ads_like_sql = mysqli_query($con, "SELECT * FROM ads_like WHERE ads_id='". $ads_res['ads_id'] ."'");
$ads_like_count = mysqli_num_rows($ads_like_sql);

if($ads_like_count > 0) 
{ 
$ads_query=mysqli_query($con, "SELECT m.username,m.member_id FROM ads_like a, members m WHERE m.member_id=a.member_id AND a.ads_id='".$ads_res['ads_id']."' LIMIT 3");
$ads_like = mysqli_num_rows($ads_query);
?>
<div class="adsPanel">
<div class='likeUsers' id="ads_likes<?php echo $ads_res['ads_id']; ?>">
<?php
while($ads_query_res = mysqli_fetch_array($ads_query))
{
$ads_like_uid=$ads_query_res['member_id']; 
$ads_likeusername=$ads_query_res['username']; 
if($ads_like_uid==$ads_res['ad_creator'])
{
echo '<span id="you'.$ads_res['ads_id'].'"><a href="'.$ads_likeusername.'">You </a></span>';
}
else
{ 
echo '<a href="'.$ads_likeusername.'">'.$ads_likeusername.'</a>';
}  
}
echo ' and '.$ads_like_count.' other friends like this';
?> 
</div></div>
<?php }
else { 
echo '<div class="likeUsers" id="ads_elikes'.$ads_res['ads_id'].'"></div>';

} 
$q1 = mysqli_query($con, "SELECT * FROM ads_like WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and ads_id='".$ads_res['ads_id']."' ");

if(mysqli_num_rows($q1) <= 0)
{
?>

          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;">
                 
          <a href="javascript: void(0)" class="ads_like" id="like_ads<?Php echo $ads_res['ads_id'];?>" title="Like" rel="Like">Like</a>
          </div>
          <?php } else
		  {?>
          
          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;">
                
          <a href="javascript: void(0)" class="ads_like" id="like_ads<?Php echo $ads_res['ads_id'];?>" title="Unlike" rel="Unlike">Unlike</a>
          </div>
<?php } ?>
        </div>
        </div>
       
       
     <?php 
   }
	 ?>
  	</div><!--end column_right div-->
</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</body>
</html>