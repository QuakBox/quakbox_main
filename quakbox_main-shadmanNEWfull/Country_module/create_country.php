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
	
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css"/><?php */?>

<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
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
<style type="text/css">
	#border{
		clear:both;
	}
	#submenushead {
		float: left;
		padding-left: 5px;
		padding-bottom: 5px;
		padding-top: 20px;
		width: 100%;
		position: relative;
		bottom: 4px;
	}
	div.ctitle {
		font-weight: bold;
		margin: 0px 0px 5px !important;
		padding: 5px 0px !important;
		color: rgb(59,  89,  152);
		border-color: rgb(192,  204,  220);
	}
	table.countryTB {
		border-collapse: collapse;
		border: 0px none;
		padding: 0px;
	}	
	table.countryTB td.dtfItem {
		width: 160px;
		vertical-align: top;
		text-align: center;
		border: 1px solid rgb(0,  86,  137);
		padding: 4px;
		font-size: 85%;
	}	
	table.countryTB td.dtfItem label {
		display: inline;
	}	
	table.countryTB td.dtfItem div {
		text-align: left;
	}
	.button {
		background: url(images/menu_sprite.png) repeat-x 0 -61px;
		height: 26px!important;
		line-height: 26px!important;
		margin: 0;
		cursor: pointer;
		font-size: 0.75em;
		font-weight: bold;
		text-align: center;
		text-trans: uppercase;
		padding: 0 12px;
		color: #fff!important;
		border: 1px solid #282828;
	}
	.button:hover,  .button:focus {
		background: #d8dfea none repeat scroll 0 0;
		border: 1px solid #666;
		color: #666;
	}
@media (min-width: 768px) {
	#search_country{
		width:693px;
		margin:0 auto;
	}
}
@media (min-width: 600px) and (max-width: 767px) {
	#search_country{
		font-size:12px;
	}
	table.countryTB td.dtfItem{
		width:135px;
	}
}
@media (min-width: 480px) and (max-width: 600px) {
	#search_country{
		font-size:12px;
	}
	table.countryTB td.dtfItem{
		width:105px;
	}
}
@media (min-width: 360px) and (max-width: 480px) {
	.paddingNone{
		padding-left:0;
		padding-right:0;
	}
	#search_country{
		font-size:12px;
	}
	table.countryTB td.dtfItem{
		width:80px;
	}
}
@media (min-width: 320px) and (max-width: 360px) {
	.paddingNone{
		padding-left:0;
		padding-right:0;
	}
	#search_country{
		font-size:12px;
	}
	table.countryTB td.dtfItem{
		width:60px;
	}
}
</style>
<div class="insideWrapper container">
<div class="col-lg-9 col-md-9 col-sm-8 paddingNone">
	
    <div class="componentheading">
    <div id="submenushead"><?php echo  $lang['My Countries'];?></div>
    </div>
   
   <!--<div id="submenushead">
    <ul class="dropDown">
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="friends.php">All Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups.php">My Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="find_friend_advanced.php">Pending Invitations</a></li>
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php">Create</a></li>
    <li style="padding:0 8px;"><a href="request_sent.php">Search</a></li>    
	</ul>
   </div>-->
   
   <div id="border">
   <div id="search_country">
<form name="saveProfile" id="saveProfile" action="action/create_country-exec.php" method="post">


<?php
$iMaxNewFavs = 4;
$iMaxCols=4;
$vecFCF = mysqli_query($con, "select * from favourite_country f,geo_country c where f.code=c.code and f.favourite_country=1 and member_id = '$member_id' AND c.country_id!='207'") or die(mysqli_error($con));
$iTotalFavs = mysqli_num_rows($vecFCF); 
//$iMaxNewFavs = $iMaxNewFavs - $iTotalFavs;
if ($iTotalFavs < 0){ $iTotalFavs=0; }

$vecCF = mysqli_query($con, "select * from favourite_country f,geo_country c where f.code=c.code and f.favourite_country=0 and member_id = '$member_id' AND c.country_id!='207'") or die(mysqli_error($con));
$iTotalNoFavs = mysqli_num_rows($vecCF);

$xNoFavs="";
$xResetFavs="";

if ($iTotalFavs + $iTotalNoFavs > 0){
?>
<div class="ctitle" style="padding:0px !important;">
<h2 style="margin:0px !important;	font-size: 110%;font-weight: bold;padding: 15px 0px 3px;margin: 0px;border: medium none;">
<?php echo  $lang['You are fan of these Countries'];?>:
</h2>
</div>
<table class="countryTB">
<tbody>
<?php
 if ($iTotalFavs > 0){
            $iPos=0;
	for($i=0; $i<$iTotalFavs; $i++){
		$country_res1 = mysqli_fetch_array($vecFCF);
		$country_name1 = str_replace(' ', '-', $country_res1['country_title']);
                if ($iPos == 0){ echo "\n<tr>"; }
                $iPos++;
	
		echo '<td class="dtfItem">';


?>


<div class="dtfItem" style="text-align:center; margin:0px;">
<a href="<?php echo $base_url;?>country_wall.php?country=<?php echo $country_name1;?>"><img src="<?php echo "images/Flags/flags_new/195x120flags/".strtolower($country_res1['code']).".png";?>" title="<?php echo $country_res1['country_title'];?>" height="36" style="border:0px none; background: none repeat scroll 0% 0% transparent;" /></a><br /><br />
<a href="<?php echo $base_url;?>country_wall.php?country=<?php echo $country_name1;?>"><?php echo $country_res1['country_title'];?></a>
</div>

<div style="text-align:left;"><?php 
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
</div>

<div id="divDel<?php echo $country_res1['code'];?>" style="display: none; text-align:left;"><input id="chkCF<?php echo $country_res1['code'];?>" type="checkbox" onclick="dtfDelCountry(this, '<?php echo $country_res1['code'];?>')" checked="checked" value="<?php echo $country_res1['code'];?>" name="chkCF<?php echo $country_res1['code'];?>"></input>
<label for="chkCF<?php echo $country_res1['code'];?>">
      <?php echo $lang['Uncheck to remove'];?>
    </label></div>
    
</td>

<?php 
if ($iPos >= $iMaxCols){
                    echo "\n</tr>";
                    $iPos=0;
                }
            } //end-for
			if ($iPos > 0 && $iPos < $iMaxCols){
                for ($i=$iPos; $i<$iMaxCols; $i++){echo "<td class=\"dtfItem\">&nbsp;</td>";}
                echo "\n</tr>";
            }
//            echo "\n</table>";
        }
 
if ($iTotalNoFavs > 0){
//            echo "\n<table class=\"countryTB\">";
            $iPos=0;
            for($i=0; $i<$iTotalNoFavs; $i++){
				$country_res2 = mysqli_fetch_array($vecCF);
				$country_name2 = str_replace(' ', '-', $country_res2['country_title']);
                if ($iPos == 0){ echo "\n<tr>"; }
                $iPos++;
        ?>
        <td class="dtfItem">
        <div class="dtfItem" style="text-align:center; margin:0px;">
<a href="<?php echo $base_url;?>country_wall.php?country=<?php echo $country_name2;?>"><img src="<?php echo "images/Flags/flags_new/195x120flags/".strtolower($country_res2['code']).".png";?>" title="<?php echo $country_res2['country_title'];?>" height="36" style="border:0px none; background: none repeat scroll 0% 0% transparent;" /></a><br /><br />
<a href="<?php echo $base_url;?>country_wall.php?country=<?php echo $country_name2;?>"><?php echo $country_res2['country_title'];?></a>
</div>

<div style="text-align:left;"><?php 
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
</div>
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
</td>
        <?php        
                //$xNoFavs.="\n   frm.chkfav" . $vecCF[$i]['code'] . ".disabled=zwEnable;";
                //$xResetFavs.="\n   frm.chkfav" . $vecCF[$i]['code'] . ".disabled=false;";
                if ($iPos >= $iMaxCols){
                    echo "\n</tr>";
                    $iPos=0;
                }
            } //end-for
            if ($iPos > 0 && $iPos < $iMaxCols){
               for ($i=$iPos; $i<$iMaxCols; $i++){echo "<td class=\"dtfItem\">&nbsp;</td>";}
               echo "\n</tr>";
            }
            
        }
?>
</tbody>
</table>
<table class="countryTB">
<tbody>
<tr>
<td class="dtfItem" style="border:0px none;">
<td class="dtfItem" style="border:0px none;">
<td class="dtfItem" style="border:0px none;">
<td class="dtfItem" style="border:0px none;">
</tr>
<tr>
<td style="text-align:center;" colspan="4">
<input class="button" type="button" onclick="dtfResetFavs()" value="<?php echo $lang['reset'];?>"></input>
<input class="button" type="submit" value="<?php echo $lang['update'];?>" name="fav"></input>
</td>
</tr>
</tbody>
</table>
<?php } ?>
<div class="ctitle" style="padding:0px !important;">
<h2 style="margin:0px !important;"><?php echo $lang['Other Countries'];?></h2>
</div>

<?php
$iMaxCols = 4;

$country_sql = mysqli_query($con, "SELECT country_title,code FROM geo_country WHERE code NOT IN 
(SELECT DISTINCT code FROM favourite_country WHERE member_id=$member_id) AND country_id!='207' ORDER BY country_title ASC");

$rows = mysqli_num_rows($country_sql);


if($rows > 0)
{
?>
<table class="countryTB">
<tbody>
<?php
$iPos=0;
for($i=0;$i<$rows;$i++)
{
	
$country_res = mysqli_fetch_array($country_sql);
	if ($iPos == 0){ echo "\n<tr>"; }
	 $iPos++;
	echo '<td class="dtfItem">';
	$country_name3 = str_replace(' ', '-', $country_res['country_title']);
?>
<div class="dtfItem" style="text-align:center; margin:0px;">
<a href="<?php echo $base_url;?>country_wall.php?country=<?php echo $country_name3;?>"><img src="<?php echo "images/Flags/flags_new/195x120flags/".strtolower($country_res['code']).".png";?>" title="<?php echo $country_res['country_title'];?>" height="36" style="border:0px none; background: none repeat scroll 0% 0% transparent;" /></a><br /><br />
<a href="<?php echo $base_url;?>country_wall.php?country=<?php echo $country_name3;?>"><?php echo $country_res['country_title'];?></a>
</div>
<div style="text-align:left; line-height: 1.5em;"><input id="chkfav<?php echo $country_res['code'];?>" type="checkbox" onclick="dtfSetFavorite2(this);" disabled="disabled" value="<?php echo $country_res['code'];?>" name="chkfav<?php echo $country_res['code'];?>"></input>
<label for="chkfav<?php echo $country_res['code'];?>">
      <?php echo $lang['Favorite'];?>
    </label>
</div>
<div style="line-height: 1.5em;"><input id="chkC<?php echo $country_res['code'];?>" type="checkbox" onclick="dtfEnableOtherFavs(this,'<?php echo $country_res['code'];?>')" 
value="<?php echo $country_res['code'];?>" name="chkC<?php echo $country_res['code'];?>"></input>
<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
<label for="chkC<?php echo $country_res['code'];?>">
      <?php echo $lang['Check to become fan'];?>
    </label></div>
    </td>
<?php
	 
	 if ($iPos >= $iMaxCols){
                echo "\n</tr>";
                $iPos=0;
            }
        } //end-for
	if ($iPos > 0 && $iPos < $iMaxCols){
           for ($i=$iPos; $i<$iMaxCols; $i++){echo "<td class=\"dtfItem\">&nbsp;</td>";}
           echo "\n</tr>";
        }
        echo "\n<tr><td class=\"dtfButton\" colspan=\"$iMaxCols\" style=\"padding:20px\"><input type=\"submit\" class=\"button\" value=\"".$lang['update']."\" name='nonfav'/></td></tr>";
        echo "\n</table>";
    } //end-if ($iTotalOther > 0)
?>		

</tbody>
</table>
</form>

</div>
</div>  

</div><!--end column left-->
<div class="col-lg-2 col-md-2 col-sm-3 hidden-xs"> 
	<div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
</div>
<!--end column_right div-->
</div><!--end mainbody div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>