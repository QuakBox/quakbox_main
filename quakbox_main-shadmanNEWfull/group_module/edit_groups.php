<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'],$con);
	$objMember = new member1();
	$lookupObject = new lookup();
	
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$group_id = $_REQUEST['group_id'];
	
	$sql = mysqli_query($con, "select * from groups where id='".$group_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$categoryid = $res['categoryid'];
	
	$cat_sql = mysqli_query($con, "select * from groups_category where id='$categoryid'") or die(mysqli_error($con));
	$cat_res = mysqli_fetch_array($cat_sql);
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" /><?php */?>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">	
        <div class="componentheading">
        <div id="submenushead"><?php echo $lang['Editing Group'];?></div>
        </div>
        <div id="submenushead">
        <ul class="dropDown">
        <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups_all.php"><?php echo $lang['All Groups'];?></a></li>
        <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups.php"><?php echo $lang['My Groups'];?></a></li>
        <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href=""><?php echo $lang['Pending Invitations'];?></a></li>
        <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php"><?php echo $lang['Create'];?></a></li>
        <li style="padding:0 8px;"><a href="groups_search.php"><?php echo $lang['Search'];?></a></li>    
        </ul>
       </div>
       <div id="border">
    <form action="action/edit_group-exec.php" method="post" role="form" class="form-horizontal">
    <input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
    <div class="form-group crt_grp_p">
    <p style="margin: 2em 0px;padding: 0px;"><?php echo $lang['Create your own groups today. Created groups will be publicly accessible to users'];?>.</p></div>
    <div class="form-group crt_grp_p">
    <?php echo $lang['You have created 0 out of 300 allowed group creation.'];?>
    </div>
    
    <div class="form-group">
    <label for="name" class="control-label col-md-4">*<?php echo $lang['Group Name'];?></label>
    <div class="col-md-4">
    <input id="name" class="form-control" type="text" value="<?php echo $res['name'];?>" name="name">
    </div>
    </div>
    
    <div class="form-group">
    <label for="name" class="control-label col-md-4">*<?php echo $lang['Description'];?></label>
    <div class="col-md-4">
    <textarea class="form-control" name="desciption"><?php echo $res['description'];?></textarea>
    </div>
    </div>
    
    <div class="form-group">
    <label for="name" class="control-label col-md-4">*<?php echo $lang['Category'];?></label>
    <div class="col-md-4">
    <select id="categoryid" class="form-control" name="categoryid">
    <?php 
    $group_sql = mysqli_query($con, "select * from groups_category");
    while($group_res = mysqli_fetch_array($group_sql))
    {
        $selected	= ( $res['categoryid'] == $group_res['id'] ) ? ' selected="selected"' : '';
    ?>
    <option value="<?php echo $group_res['id'];?>"<?php echo $selected;?>><?php echo $group_res['name'];?></option>
    <?php } ?>    
    </select>
    </div>
    </div>
    
    <div class="form-group">
         
            <label for="name" class="control-label col-md-4">* <?php echo $lang['Group Type'];?></label>
                             
               <div class="col-md-4">
                      <div class="radio">
                        
                    <input id="approve-open" type="radio" checked="checked" value="0" name="approvals" ></input>
                  <label class="checkbox-inline control-label"> <?php echo $lang['Open — Anyone can join and view this group'];?>. </label></div>
                  
                    
                   
                     <div class="radio">
                        <input id="approve-private" type="radio" value="1" name="approvals"></input>
                        <label class="checkbox-inline control-label"><?php echo $lang["Private — This group requires approval for new members to join. Anyone can view the group's description"];?>.<?php echo $lang["Only group members are allowed to see the groups content"];//echo $lang['$lang["Only group members are allowed to see the groups content"]'];?>. </label> </div>
                        </div>
            
                
        </div>
        <div class="form-group">
            <label for="name" class="control-label col-md-4"><?php echo $lang['Discussion ordering'];?></label>
            
                 
                    <div class="col-md-4">
                    <div class=" radio"> 
                    <input id="discussordering-lastreplied" type="radio" checked="checked" value="0" name="discussordering"></input>
                    <label class="checkbox-inline control-label"><?php echo $lang['Order by last replied'];?></label></div>
                           
                
                    
                    <div class=" radio">
                    <input id="discussordering-creation" type="radio" value="1" name="discussordering"></input>
                     <label class="checkbox-inline control-label"> <?php echo $lang['Order by creation date'];?>
                    </label>  </div>
                    </div>
              
                </div>
          <div class="form-group">      
                
            <label for="name" class="control-label col-md-4"><?php echo $lang['Photos'];?></label>
                <div class="col-md-4">
                    <div class=" radio">
                        <input id="photopermission-disabled" type="radio" value="-1" name="photopermission"></input>
                        <label class="checkbox-inline control-label">    <?php echo $lang['Disable group photos'];?>.
                    </label></div>
                
       
        
                    
                    <div class=" radio">
                    <input id="photopermission-members" type="radio" checked="checked" value="0" name="photopermission"></input>
                     <label class="checkbox-inline control-label"> <?php echo $lang['Allow members to upload photos and create albums'];?>
                    </label></div>
                    
        
         
        
                    <div class=" radio">
                        <input id="photopermission-admin" type="radio" value="1" name="photopermission"></input>
                        <label class="checkbox-inline control-label"><?php echo $lang['Allow only group admins to upload photos and create albums'];?>.
                    </label></div>
       </div>
      </div>  
      
      <div class="form-group">
        <label for="name" class="control-label col-md-4"><?php echo $lang['Group Albums'];?></label>
        <div class="col-md-4">
            <input id="grouprecentphotos-admin" type="text" value="6" size="1" name="grouprecentphotos" ></input></div>
            </div>
            
            <div class="form-group">
            
                <label for="name" class="control-label col-md-4"><?php echo $lang['Videos'];?></label>
            
                    <div class="col-md-4">
                    <div class=" radio">
                    <input id="videopermission-disabled" type="radio" value="-1" name="videopermission"></input>
                    <label class="checkbox-inline control-label"> <?php echo $lang['Disable group videos'];?>.
                 </label></div>
             
     
                    <div class=" radio">
                     <input id="videopermission-members" type="radio" checked="checked" value="0" name="videopermission"></input>
                        <label class="checkbox-inline control-label"> <?php echo $lang['Allow members to upload videos'];?>.
                    </label></div>
      
       
                
                    <div class=" radio">
                    <input id="videopermission-admin" type="radio" value="1" name="videopermission"></input>
                        <label class="checkbox-inline control-label"><?php echo $lang['Allow only group admins to upload videos'];?>.
                     </label></div>
                     </div>
          </div>
      <div class="form-group">
          <label for="name" class="control-label col-md-4"><?php echo $lang['Group Videos'];?></label>
          <div class="col-md-4">
            <input id="grouprecentvideos-admin" type="text" value="6" size="1" name="grouprecentvideos"></input></div>
            </div>
            
           <div class="form-group">
            
            <label for="name" class="control-label col-md-4"><?php echo $lang['New member notification'];?></label>
        <div class="col-md-4">
       
           <div class=" radio">
                    <input id="newmembernotification-enable" type="radio" checked="checked" value="1" name="newmembernotification"></input>
                    <label class="checkbox-inline control-label"><?php echo $lang['Enable'];?>
                 </label></div>
        
       
                    <div class=" radio">
                        <input id="newmembernotification-disable" type="radio" value="0" name="newmembernotification"></input>
                    <label class="checkbox-inline control-label">	 <?php echo $lang['Disable'];?>
                     </label></div>
       </div>
        </div>
        
         <div class="form-group">
              <label for="name" class="control-label col-md-4"><?php echo $lang['Join request notification'];?> </label>
                 
             
                    
                    <div class="col-md-4">
                    <div class="radio">
                        <input id="joinrequestnotification-enable" type="radio" checked="checked" value="1" name="joinrequestnotification"></input>
                     <label class="checkbox-inline control-label"> <?php echo $lang['Enable'];?>
                    </label></div>
             
                    
                    <div class=" radio">
                     <input id="joinrequestnotification-disable" type="radio" value="0" name="joinrequestnotification"></input>
                       <label class="checkbox-inline control-label">   <?php echo $lang['Disable'];?>
                    </label></div>
                    </div>
            </div>    
     
      <div class="form-group">
        <label for="name" class="control-label col-md-4"><?php echo $lang['Wall post notification'];?></label>
        
                    
                    <div class="col-md-4">
                    <div class="radio">
                    <input id="wallnotification-enable" type="radio" checked="checked" value="1" name="wallnotification"></input>
         <label class="checkbox-inline control-label"> <?php echo $lang['Enable'];?>
        </label></div>
        
                    
                    <div class=" radio">
       <input id="wallnotification-disable" type="radio" value="0" name="wallnotification"></input>
          <label class="checkbox-inline control-label"><?php echo $lang['Disable'];?>
        </label></div>
        </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <span><?php echo $lang['Fields marked with an asterisk (*) are required'];?>.</span>
            </div>
        </div>
    
     <div class="form-group">
    <input type="hidden" value="save" name="action"></input>
    <input type="hidden" value="" name="groupid"></input>
    <input class="button validateSubmit" type="submit" value="<?php echo $lang['Save'];?>"></input>
    <input class="button" type="button" value="<?php echo $lang['Cancel'];?>" onclick="history.go(-1);return false;"></input>
    <input type="hidden" value="1" name="326e4f73c340f29d8ce547ad40dc0e1b"></input>
    <input type="hidden" value="<?php echo $group_id;?>" name="group_id"></input>
    </div>
    </div>
    
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