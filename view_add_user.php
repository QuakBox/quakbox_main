<?php 
ob_start();
	session_start();
	
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
        include('common.php');
	require_once('config.php');
        require_once('includes/time_stamp.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
        if(isset($_GET['delete_id'])){	
            $delete_id =$_GET['delete_id'];
            mysqli_query($con,"DELETE FROM ads WHERE ads_id = '$delete_id' AND ad_creator='$member_id'");
        
            
            
        }
            ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $lang['Manage Ads'];?></title>
<head>
    
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/search.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/ads.css"/>
<link rel="icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="shortcut icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">


<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/format.css"/>
<style>
#errmsg
{
color: red;
}
</style>
<link rel="stylesheet" href="<?php echo $base_url;?>css/colorpicker.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $base_url;?>css/layoutcolorpicker.css" type="text/css" />  
	<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo $base_url;?>js/colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/eye.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/utils.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/layout.js?ver=1.0.2"></script>
<script src="<?php echo $base_url;?>js/jquery-1.7.2.min.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.form.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css"/>

<style>
.content a:hover , .headerMenu a:default, .headerMenu a
{
color: black !important;
}

.headerMenu a, .headerMenu a:link, .content a:visited, .content a:hover 
{
text-decoration: none !important;
background-color: transparent !important;
}
</style>

</head>
<body>

    <div class="headerMenu">
        <?php include('includes/qb_header.php');
           include_once("config.php"); 
        ?>
    </div>
    

<div class="adsheading">List Your Ads &nbsp;&nbsp;&nbsp;<a style="color:#261f50;" href="<?php echo $homepage;?>">Home</a></div>
<br>
<div class="adsdiv">
 
<div class="container">
  <?php
	 $sql="
	SELECT `ads_id`, `ad_creator`, `ads_title`, `ads_content`, `ads_pic`, `typeofadd`, `url`, `targetgender`, `targetmob`, `targetstate`, `targetcity`, `targetcountry`, `targetdob`, `targetadd`, `targetgrad`, `pricingperclick`, `pricingbuy`, `pricingpay`, `pricinggateway`, `status`,`country_title`,`state_title`,`city_title`,`start_date`,`end_date` FROM ads a 
	INNER JOIN geo_country gc
	on a.targetcountry=gc.country_id  
	INNER JOIN geo_state gs
	ON a.targetstate=gs.state_id
	INNER JOIN geo_city gci
	ON a.targetcity=gci.city_id
	WHERE a.ads_pic!='' And ad_creator='$member_id' order by a.ads_id DESC 	
	";
         ?>
    <table class="table table-bordered" style="width: 100%!important;">
        
    <thead>
        
      <tr>
          <th>Ad name</th>
          <th>Image</th>
          <th>Country</th>
          <th>State</th>
          <th>City</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Edit</th>
          
          <th>Delete</th>
      </tr>
    </thead>
    <tbody>
        <?php
                   $query = mysqli_query($con,$sql);	
                   while($ads_res = mysqli_fetch_array($query )) { 
                                          
                                           ?>
    
      <tr>
          
        <td><?php echo $ads_res['ads_title']; ?></td>
        <td><img src="<?php echo  $base_url.$ads_res['ads_pic']; ?>" height="150px" width="150px"></td>
          <td><?php echo  $ads_res['country_title']; ?></td>
         <td><?php echo  $ads_res['state_title']; ?></td>
         <td><?php echo  $ads_res['city_title']; ?></td>
         <td style="width:10px; height: 20px;"><?php echo date("M-jS-Y ", strtotime($ads_res['start_date']));?></td>
        <td><?php echo date("M-jS-Y ", strtotime($ads_res['end_date']));?></td>
        <td>
             <a class="btn btn-info" href="edit_add_user.php?id=<?php echo $ads_res['ads_id']?>">
										<i class="icon-edit icon-white"></i> 
										Edit
									</a>
         </td>

         
        <td>
             <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this advertisement?')"  href="view_add_user.php?delete_id=<?php echo $ads_res['ads_id']?>">
										<i class="icon-trash icon-white"></i> 
										Delete
									</a>
         </td>
      </tr>
        <?php
        }
        ?>
    </tbody>
  </table>
</div>
</div>
    