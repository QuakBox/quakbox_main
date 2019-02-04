<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	$objMember = new member1(); 
	$lookupObject = new lookup();
	
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'],$con);
	$username = $QbSecurity->qbClean($_REQUEST['username'], $con);
	if(!(empty($username) || $QbSecurity->qbCheckSpecialChars($username)))
	{
	$qb_err_msg="Oops Something Went Wrong...!";
$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	
	$gmember_id = $res['member_id'];
?>
<?php /*?><link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>
<link rel="icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="shortcut icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/format.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/search.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css" /><?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/group.css"/>
<script src="<?php echo $base_url;?>js/jquery.livequery.js" type="text/javascript"></script>
<script src="<?php echo $base_url;?>js/jquery.oembed.js"></script>
<script src="<?php echo $base_url;?>js/jquery-1.9.1.js"></script>
<script src="<?php echo $base_url;?>js/jquery-ui.js"></script>

<script src="<?php echo $base_url;?>js/jquery-1.7.2.min.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>

<style type="text/css">
	.dropdown li a, .dropDown li a {
		color: #FFFFFF;
		display: block;
		font-family: arial;
		font-weight: bold;
		padding: 6px 15px;
		cursor: pointer;
		text-decoration: none;
	}
	.dropdown li a:hover, .dropDown li a:hover {
		background: #0000CC;
		color: #FFFFFF;
		text-decoration: none;
	}
</style>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">
        
        <div class="componentheading">
        <div id="submenushead"><?php echo $lang['My Groups'];?></div>
        </div>
        <div id="submenushead">
        <ul class="dropDown">
        <?php /*<li><a href="echo $base_url;?>groups_all.php"><?php echo $lang['All Groups']</a></li> */
        ?>
        <li><a href="<?php echo $base_url.'groups/'.$res['username'];?>"><?php echo $lang['My Groups'];?></a></li>
        <li><a href=""><?php echo $lang['Pending Invitations'];?></a></li>
         <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="<?php echo $base_url;?>create_groups.php"><?php echo $lang['Create'];?></a></li>
        <li style="padding:0 8px;"><a href="<?php echo $base_url;?>groups_search.php"><?php echo $lang['Search'];?></a></li>  
       
        </ul>
       </div>
    
    <div id="cFilterBar">
    <div class="cFilterBar_inner">
    <div class="filterGroup" id="cFilterType_Sort">
    <span class="filterName"><?php echo $lang['Sort By'];?>:</span>
    <ul class="filterOptions">
    <li class="filterOption"><a href="<?php echo $base_url;?>groups.php?username=<?php echo $username;?>&sort=<?php echo 'latest';?>"><?php echo $lang['Latest Group'];?></a></li>
    <li class="filterOption"><a href="<?php echo $base_url;?>groups.php?username=<?php echo $username;?>&sort=<?php echo 'alphabetical';?>"><?php echo $lang['Alphabetical'];?></a></li>
    <li class="filterOption"><a href="<?php echo $base_url;?>groups.php?username=<?php echo $username;?>&sort=<?php echo 'mostdiscussed';?>"><?php echo $lang['Most Discussed'];?></a></li>
    <li class="filterOption"><a href="<?php echo $base_url;?>groups.php?username=<?php echo $username;?>&sort=<?php echo 'mostwall';?>"><?php echo $lang['Most wall posts'];?></a></li>
    <li class="filterOption"><a href="<?php echo $base_url;?>groups.php?username=<?php echo $username;?>&sort=<?php echo 'mostmember';?>"><?php echo $lang['Most Members'];?></a></li>
    <li class="filterOption"><a href="<?php echo $base_url;?>groups.php?username=<?php echo $username;?>&sort=<?php echo 'mostactive';?>"><?php echo $lang['Most Active'];?></a></li>
    </ul>
    </div>
    </div>
    
    </div>
    <div class="cLayout clrfix" id="groupintex">
    <div class="cSidebar">
    <div class="app-box">
    <div class="app-box-header">
    <h2 class="app-box-title"><?php echo $lang['Latest Discussion'];?></h2>
    </div>
    </div>
    <div id="border">
    <?php
    if(isset($_REQUEST['sort']))
    {
    if($_REQUEST['sort']=="alphabetical")
     {
         $group_sql = mysqli_query($con, "select * from  groups g WHERE g.ownerid='$gmember_id' order by g.name asc") or die(mysqli_error($con));
     }
     else if($_REQUEST['sort']=="latest")
     {
        $group_sql = mysqli_query($con, "select * from groups g WHERE g.ownerid='$gmember_id' order by g.created desc");
     }
     else if($_REQUEST['sort']=="mostdiscussed")
     {
        $group_sql = mysqli_query($con, "select * from groups g WHERE g.ownerid='$gmember_id' order by g.discusscount desc");
     }
     else if($_REQUEST['sort']=="mostwall")
     {
        $group_sql = mysqli_query($con, "select * from groups g WHERE g.ownerid='$gmember_id' order by g.wallcount desc");
     }
     else if($_REQUEST['sort']=="mostmember")
     {
        $group_sql = mysqli_query($con, "select * from groups g  WHERE g.ownerid='$gmember_id' order by g.membercount desc");
     }
     else if($_REQUEST['sort']=="mostactive")
     {
        $group_sql = mysqli_query($con, "select * from groups g WHERE g.ownerid='$gmember_id' order by g.created desc");
     }
    }
     else
     {
        $group_sql = mysqli_query($con, "select * from groups g where g.ownerid='$gmember_id' order by g.created desc");
     }
     $group_count = mysqli_num_rows($group_sql);
     if($group_count > 0)
     {
     $r_g = 0; 
     while($group_res = mysqli_fetch_array($group_sql))
     {
         $group_id = $group_res['id'];
         $group_member_sql = mysqli_query($con, "select * from groups_members where groupid='$group_id'");
         $group_member_count = mysqli_num_rows($group_member_sql);
    ?>
    <div class="community-groups-results-item" style="line-height:1.5em;">
    <div class="community-events-results-left">
    <a href="<?php echo $base_url;?>groups_wall.php?group_id=<?php echo $group_res['id']?>">
        <img src="<?php echo $base_url. '/images/groupThumbAvatar.jpg';?>" height="68" width="68" style="border-radius: 15px;" />
    </a>
    </div>
    <div class="community-events-results-right">
    <h3><a href="<?php echo $base_url;?>groups_wall.php?group_id=<?php echo $group_res['id']?>">
    <script>
    //alert("hi");
    </script>
     <?php  
        
        
         if(isset($_SESSION['lang'])&&($_SESSION['lang']!='en'))
             {
            $res=mysqli_query($con, "select * from groups1  where group_id = '".$group_res['id']."' and  lang = '".$_SESSION['lang']."' and type ='0' ");		
                 $result_group=mysqli_fetch_array($res);
                  $count=mysqli_num_rows($res);
            //echo $count;
                 if($count > 0)
                 {
                   echo $result_group['data'];
                  }
                  else
                  {
                 // echo $s;
                      $last_id = $group_res['id'];
                      $title = $group_res['name'];
                      $type_gp='2';
                     include "translate_group.php";
                    // $r_g++;
                  }
             }
             else
             {
            echo $group_res['name'];
             }
                
        ?>
    <?php //echo $group_res['name'];?>
    
    
    </a></h3>
    </div>
    <div class="groupDescription">
    <?php  
         
        
         if(isset($_SESSION['lang'])&&($_SESSION['lang']!='en'))
             {
            $res=mysqli_query($con, "select * from groups1  where group_id = '".$group_res['id']."' and  lang = '".$_SESSION['lang']."' and type ='0' ");		
                 $result_group=mysqli_fetch_array($res);
                  $count=mysqli_num_rows($res);
            //echo $count;
                 if($count > 0)
                 {
                   echo $result_group['data'];
                  }
                  else
                  {
                 // echo $s;
                      $last_id = $group_res['id'];
                      $title = $group_res['description'];
                      $type_gp='3';
                     include "translate_group.php";
                    // $r_gd++;
                  }
             }
             else
             {
            echo $group_res['description'];
             }
                
        ?>
    
    
    <?php // echo $group_res['description'];?>
    
    
    
    </div>
    <div class="small"><?php echo $lang['Created on'];?>: <?php echo date("l, j F Y",$group_res['created']);?></div>
    <div class="groupActions">
    <span class="icon-group" style="margin-right:5px;">
    <a href="<?php echo $base_url;?>group_members.php?group_id=<?php echo $group_id;?>"><?php echo $group_member_count;?> <?php echo $lang['Members'];?></a></span>
    <span class="icon-discuss" style="margin-right:5px;"><a href="">0 <?php echo $lang['Discusions'];?></a></span>
    <span class="icon-wall" style="margin-right:5px;"><a href="">0 <?php echo $lang['Wall Posts'];?></a></span>
    </div>
    </div>
    <?php } 
     }
     else
     {
    ?>
    <div class="group-not-found">
    <?php echo $lang['Group Not Found '];?>
    </div>
    <?php } ?>
    </div><!--End border div-->
    </div>
    </div><!--End cLayout div-->
    
    </div><!--end column_left div-->
    
    <!--Start column right-->
    <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
    <!--end column_right div-->
</div><!--end mainbody div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>
<?php 
}
?>