<?php 
	session_start();
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('Languages/en.php');
		
	}
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	require_once('config.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $lang['My Countries'];?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css"/>

<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
function dtfDisableFav(obj, zCode){
	
   if ( layerDel = document.getElementById('divDel'+zCode) ){
      layerDel.style.display=(obj.checked)?'none':'block';
   }
}

function dtfCheckFavsLimit(){
   var frm = document.saveProfile;
   var kMax = 3;
   var iChecked = 0;
   var iTotal=frm.elements.length;
   for (ii=0; ii<iTotal; ii++){
      if ( (frm.elements[ii].type == 'checkbox') && (frm.elements[ii].name.substr(0,6) == 'chkfav')){
         if (frm.elements[ii].checked) iChecked++
      }
   }
   if ( iChecked <= kMax ){ return true }else{ return false }
}

function dtfSetFavorite(obj){
   if (obj.checked){
      if ( !dtfCheckFavsLimit() ){
         obj.checked=false;
         alert("<?php echo $lang['Favorites limit reached'];?>");
      }
   }else{
      if ( dtfCheckFavsLimit() ){
         dtfEnableMoreFavs(false);
      }
   }
}
function dtfSetFavorite2(obj){
   if (obj.checked){
      if ( !dtfCheckFavsLimit() ){
         obj.checked=false;
         xMsg="<?php echo $lang['You are allowed to have only 3 favorite countries'];?>";
         alert(xMsg);
      }
   }
}
function dtfEnableOtherFavs(obj, zCCode)
{
	
   if ( objfav = document.getElementById('chkfav'+zCCode) ){
      if (obj.checked){
         objfav.disabled=false;
      }else{
         objfav.checked=false;
         objfav.disabled=true;
      }
   }
}
function dtfDelCountry(obj, zCode){
   if ( objfav = document.getElementById('chkfav'+zCode) ){
      if (obj.checked){
         objfav.disabled=false
      }else{
         objfav.checked=false;
         objfav.disabled=true
      }
   }
}

</script>
<script>
function dtfEnableMoreFavs(zwEnable){   
}

function dtfResetFavs(){	
   var w = document.getElementsByTagName('input');   
      for(var i = 0; i < w.length; i++){ 
        if(w[i].type=='checkbox'){ 		
          w[i].checked = false; 
        }
      }
}
</script>
</head>
<body id="crt_cnt_mob">
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
<div class="column_left">
	
    <div class="componentheading">
    <div id="submenushead"><?php echo  $lang['My Countries'];?></div>
    </div>
   
<div id="border" style="padding-bottom: 50px;">

<form name="saveProfile" id="saveProfile" action="action/create_country-exec.php" method="post">
<?php 

$vecFCF = mysqli_query($con, "select * from favourite_country f,geo_country c where f.code=c.code and f.favourite_country=1 and member_id = '$member_id'");

$rows = mysqli_num_rows($country_sql);
?>
<div class="ctitle" style="padding:0px !important;">
<h2 style=" margin-left:10px !important;	font-size: 110%;font-weight: bold;padding: 15px 0px 3px;margin: 0px;border: medium none;">
<?php echo  $lang['You are fan of these Countries'];?>:
</h2>
</div>
<?php
while($country_res1 = mysqli_fetch_array($vecFCF))
{	
$country_name1 = str_replace(' ', '-', $country_res1['country_title']);
?>	<div>
<div class="mini-profile" id="mini-profile_<?php echo $country_res1['country_id'];?>">
<div class="mini-profile-avatar">
<a href="country_wall.php?country=<?php echo $country_name1;?>" title="<?php echo $country_res1['country_title'];?>"><img src="<?php echo "images/Flags/".strtoupper($country_res1['code']).".gif";?>" width="68" height="68" /></a>
</div>
<div class="mini-profile-details">
<h3 style="font-size:120%;"><a href="country_wall.php?country=<?php echo $country_name1;?>" title="<?php echo $country_res1['country_title'];?>"><div<strong><?php echo $country_res1['country_title'];?></strong></a></h3>
<div class="mini-profile-details-action">
<?php 
if($country_res1['favourite_country'])
{
?><input id="chkfav<?php echo $country_res1['code'];?>" type="checkbox" onclick="dtfDisableFav(this, '<?php echo $country_res1['code'];?>'); dtfSetFavorite(this);" title="0" checked="checked" value="<?php echo $country_res1['code'];?>" name="chkfav<?php echo $country_res1['code'];?>" class="checkbox"></input>
<?php } else
{?>

<input id="chkfav<?php echo $country_res1['code'];?>" type="checkbox" onclick="dtfDisableFav(this, '<?php echo $country_res1['code'];?>'); dtfSetFavorite(this);" title="1" value="<?php echo $country_res1['code'];?>" name="chkfav<?php echo $country_res1['code'];?>" class="checkbox"></input>
<?php }?>
<label for="chkfavAF">
      <?php echo $lang['Favorite'];?>
    </label>
    
    <div id="divDel<?php echo $country_res1['code'];?>" style="display: none; text-align:left;"><input id="chkCF<?php echo $country_res1['code'];?>" type="checkbox" onclick="dtfDelCountry(this, '<?php echo $country_res1['code'];?>')" checked="checked" value="<?php echo $country_res1['code'];?>" name="chkCF<?php echo $country_res1['code'];?>"></input>
<label for="chkCF<?php echo $country_res1['code'];?>">
      <?php echo $lang['Uncheck to remove'];?>
    </label></div>
</div>
</div>

</div>
</div><!--end mini profile-->	
<?php 
}
$vecCF = mysqli_query($con, "select * from favourite_country f,geo_country c where f.code=c.code and f.favourite_country=0 and member_id = '$member_id'") or die(mysqli_error($con));

while($country_res2 = mysqli_fetch_array($vecCF))
{
$country_name2 = str_replace(' ', '-', $country_res2['country_title']);	
?>	
<div>
<div class="mini-profile" id="mini-profile_<?php echo $country_res2['country_id'];?>">
<div class="mini-profile-avatar">
<a href="country_wall.php?country=<?php echo $country_name1;?>" title="<?php echo $country_name2;?>"><img src="<?php echo "images/Flags/".strtoupper($country_res2['code']).".gif";?>" width="68" height="68" /></a>
</div>
<div class="mini-profile-details">
<h3 style="font-size:120%;"><a href="country_wall.php?country=<?php echo $country_name2;?>" title="<?php echo $country_res2['country_title'];?>"><div<strong><?php echo $country_res2['country_title'];?></strong></a></h3>
<div class="mini-profile-details-action">
<?php 
if($country_res2['favourite_country'])
{
?><input id="chkfav<?php echo $country_res2['code'];?>" type="checkbox" onclick="dtfDisableFav(this, '<?php echo $country_res2['code'];?>'); dtfSetFavorite(this);" title="0" checked="checked" value="<?php echo $country_res2['code'];?>" name="chkfav<?php echo $country_res2['code'];?>" class="checkbox"></input>
<?php } else
{?>

<input id="chkfav<?php echo $country_res2['code'];?>" type="checkbox" onclick="dtfDisableFav(this, '<?php echo $country_res2['code'];?>'); dtfSetFavorite(this);" title="1" value="<?php echo $country_res2['code'];?>" name="chkfav<?php echo $country_res2['code'];?>" class="checkbox"></input>
<?php }?>
<label for="chkfavAF">
      <?php echo $lang['Favorite'];?>
    </label>
    
    <?php
if($country_res2['favourite_country'])
{
?>
<div id="divDel<?php echo $country_res2['code'];?>" style="display: none; text-align:left;"><input id="chkCF<?php echo $country_res2['code'];?>" type="checkbox" onclick="dtfDelCountry(this, '<?php echo $country_res2['code'];?>')" checked="checked" value="<?php echo $country_res2['code'];?>" name="chkCF<?php echo $country_res2['code'];?>"></input>
<label for="chkCF<?php echo $country_res2['code'];?>">
      <?php echo $lang['Uncheck to remove'];?>
    </label></div>
<?php }
else
{
	?>
    <div>
    <input type="checkbox" name="chkCF<?php echo $country_res2['code'];?>" id="chkCF<?php echo $country_res2['code'];?>" value="<?php echo $country_res2['code'];?>" checked="checked" onclick="dtfDelCountry(this, '<?php echo $country_res2['code'];?>')" >
    <label for="chkCF<?php echo $country_res2['code'];?>"><?php echo $lang['Uncheck to remove'];?></label>
    </div>
    <?php } ?>
</div>
</div>

</div>
</div>

<?php } ?>
<div>
<input class="button" type="button" onclick="dtfResetFavs()" value="<?php echo $lang['reset'];?>" style="margin-left: 10px;"></input>
<input class="button" type="submit" value="<?php echo $lang['update'];?>" name="fav"></input>
</div><div class="ctitle " style=" padding-left:5% !important; margin-top:10px !important;">
<h2 style="margin:0px !important;"><?php echo $lang['Other Countries'];?></h2>
</div>
<?php 

$country_sql = mysqli_query($con, "SELECT country_title,code,country_id FROM geo_country WHERE code NOT IN 
(SELECT DISTINCT code FROM favourite_country WHERE member_id=$member_id) ORDER BY country_title ASC");

$rows = mysqli_num_rows($country_sql);
while($country_res = mysqli_fetch_array($country_sql))
{
	$country_name3 = str_replace(' ', '-', $country_res['country_title']);		
?>	
<div class="mini-profile" id="mini-profile_<?php echo $country_res['country_id'];?>">
<div class="mini-profile-avatar">
<a href="country_wall.php?country=<?php echo $country_name3;?>" title="<?php echo $country_res['country_title'];?>"><img src="<?php echo "images/Flags/".strtoupper($country_res['code']).".gif";?>" width="68" height="68" /></a>
</div>
<div class="mini-profile-details">
<h3 style="font-size:120%;"><a href="country_wall.php?country=<?php echo $country_name3;?>" title="<?php echo $country_res['country_title'];?>"><div<strong><?php echo $country_res['country_title'];?></strong></a></h3>
<div class="mini-profile-details-action">
<input id="chkfav<?php echo $country_res['code'];?>" type="checkbox" onclick="dtfSetFavorite2(this);" disabled="disabled" value="<?php echo $country_res['code'];?>" name="chkfav<?php echo $country_res['code'];?>"></input>
<label for="chkfav<?php echo $country_res['code'];?>">
      <?php echo $lang['Favorite'];?>
    </label>
    
    <input id="chkC<?php echo $country_res['code'];?>" type="checkbox" onclick="dtfEnableOtherFavs(this,'<?php echo $country_res['code'];?>')" 
value="<?php echo $country_res['code'];?>" name="chkC<?php echo $country_res['code'];?>"></input>
<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
<label for="chkC<?php echo $country_res['code'];?>">
      <?php echo $lang['Check to become fan'];?>
    </label>
</div>
</div>

</div><!--end mini profile-->	
<?php 
}
?>
<input type="submit" class="button" value="<?php echo $lang['update'];?>" name="nonfav"/>
</form>

</div>  

</div><!--end column left-->


</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</body>
</html>