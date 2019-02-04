<div class="column_right" >

   <div id="ads" style="width:220; float:left;margin-top:85px; margin-left:35px;">
   <h3>Partners
   <a href="<?php echo $base_url;?>add_ads.php" style="margin-left:55px;">Create Ads</a>   
   </h3>
   </div>
   <?php 
   $ads_sql = mysqli_query($con, "select * from ads WHERE status != 0 order by ads_id limit 3");
   while($ads_res = mysqli_fetch_array($ads_sql))
   {
   ?>
      
		<div style="border-bottom: 1px solid #DDDDDD;float: left;padding-top: 0px;width: 220px; margin-left:35px;margin-top:0px;">
        <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">
        <a href=""><?php echo $ads_res['ads_title'];?></a>
        </div>
        <div style="float: left;padding-right: 8px; padding-top:3px; display:inline;">        
        <a href="" target="_blank">
        <img src="<?php echo $base_url.$ads_res['ads_pic'];?>" width="165" height="95"/>
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
       
	</div>