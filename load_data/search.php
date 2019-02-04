<?php ob_start();
session_start();
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
echo "1";	
	}
	else
	{
require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'],$con);		
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
$objMember = new member1(); 
$lookupObject = new lookup();
if($_POST)
{
$q = mysqli_real_escape_string($con, f($_POST['searchword'],'escapeAll'));
$activeID =  $lookupObject->getLookupKey("MEMBER STATUS", "ACTIVE");
$sql = "select email,member_id,username from member 
where (username like '%$q%' or email like '%$q%')
AND member_id != '$member_id' AND status ='$activeID' 
order by member_id LIMIT 5";

$sql_res = mysqli_query($con, $sql);
while($row=mysqli_fetch_array($sql_res))
{
$member=$row['member_id'];
$block=mysqli_query($con, "select * from blocklist where userid='$member' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
if($block_count==0)
	{


$username=$row['username'];
//$email=$row['email'];
$media = $objMember->select_member_meta_value($row['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;
//$country=$row['country'];
$b_username='<b>'.$q.'</b>';
//$b_email='<b>'.$q.'</b>';
$final_username = str_ireplace($q, $b_username, $username);
//$final_email = str_ireplace($q, $b_email, $email);
?>
<a href="<?php echo $base_url.$row['username'];?>">
<div class="display_box" align="left">
<img src="<?php echo $media; ?>" style="width:50px; height:50px; float:left; margin-right:2px;" />
<span class="name1" style="color:#000;"><?php echo $final_username; ?></span>
</div></a>
<?php
}
}
?>
<a id="search-all" href="<?php echo $base_url;?>search.php?q=<?php echo $q;?>">
Show all results
</a>
<?php
}}
?>