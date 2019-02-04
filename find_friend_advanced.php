<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');

	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	$objMember = new member1(); 
	$lookupObject = new lookup();
	$InactiveIDRem =  $lookupObject->getLookupKey("MEMBER STATUS", "ACTIVE");
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" /><?php */?>
<!--<script src="js/jquery-1.7.2.min.js"></script>-->

<!--<script src="js/wall.js"></script>-->
<script src="js/jquery.fastLiveFilter.js"></script>
<script src="js/move-top.js"></script>

<script src="js/ibox.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" />
<script src="<?php echo $base_url;?>js/check.js"></script>

<script type="text/javascript">

$(function() {

$('#boxclose').click(function(){	

	$('.box').hide();
	
	//window.location.assign("<?php echo $base_url;?>find_friend_advanced.php");
});

});

</script>

<script type="text/javascript">

$(document).ready(function(){

 $("#college").autocomplete("load_data/college_names.php?findword="+$(this).val(),{

		selectFirst: true

	});

  $("#profession").autocomplete("load_data/profession_names.php?findword="+$(this).val(),{

		selectFirst: true

	});

$("#country").autocomplete("load_data/country_names.php?findword="+$(this).val(),{

		selectFirst: true

	});

	$("#city").autocomplete("load_data/city_names.php?findword="+$(this).val(),{

		selectFirst: true

	});

});

</script>
<script src="js/1.11.1_jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){

$(".add_friend").click(function(){
$("#ibox").show();

});


 $(".myform").submit(function(){
//alert("working");
var member_id = $(this).attr('val');
var message = $("#message"+member_id).val();

//alert(member_id);
//alert(message);

 var dataString = 'member_id=' + member_id + '&message=' + message;
 $.ajax({
                type: "POST",
               url:"<?php echo $base_url;?>action/add_friend1.php",
                                
                data: dataString,
                cache: false,
                success: function (html) {
                  var test = html;
                // alert(html);
                if(test == 1)
                {
                
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
               
               $("#add_as"+member_id).hide();
 $("#req_sen"+member_id).show();
 

               // $("#ibox").hide();
                //$("#box").show();
                //$("#box").css("z-index","10000000"); 
                
                $("#myform_hide"+member_id).hide();
                $("#req_sent"+member_id).show();
                }
                 }
                 
			
            });

});
 //alert("working");
  $("#city").keyup(function(event){
  var city= $("#city").val();
  var country= $("#country").val();
  
  if(country==''&& event.which!=8 && event.which!=13 && event.which!=46)
  {
  alert('please insert country ');
  $("#city").val()='';
  return false;
  }
  });
  $("#find_friend").submit(function(event){
  
  var city= $("#city").val();
  var country= $("#country").val();
  var sel= $("#gender option:selected").val();
 
 var col= $("#college").val();
 var pro= $("#profession").val();
 
  if(city!='')
  {
  if(country=='' && event.which!=8 && event.which!=13 && event.which!=46)
  {
  alert('please insert country ');
  
  return false;
  
  }
  }
  if(city!='' && country=='')
  {
  return false;
  }
  
  else if(city=='' && country=='' && sel=='Select Gender' && col=='' && pro=='' )
  {
  
  alert("please select/insert one option");
  return false;
  }
  });
  
 
  
});

</script>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">


	<?php 

	/*if(isset($_REQUEST['err'])){
	
if(($_REQUEST['err'] == null) && ($_SESSION['err_count'])==0){ 
$_SESSION['err_count']++;*/

?>

<div class="box" id="box" style="width: 245px; display:none" >

<a class="boxclose" id="boxclose"></a>

<div class="alert-box"><span><?php echo $lang['Request Sent Successfully'];?></span></div>

</div>

<?php

/*}
else
{*/
?>
<script>
//window.location.assign("<?php echo $base_url;?>find_friend_advanced.php");
</script>
<?php
/*}


}*/

?>



	

    <div class="componentheading">

    <div id="submenushead"><?php echo $lang['Search People'];?></div>

    </div>

   <div id="submenushead" style="margin-bottom: 40px;">

   

    <ul class="submenu">

     <!-- <li><a href="friends.php?friend_id=<?php //echo $member_id;?>"><?php //echo $lang['Show all'];?></a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="find_friend.php">Search</a></li>-->

    <li style="font-size:15px;"><a href="find_friend_advanced.php"><?php echo $lang['Advanced Search'];?></a></li>

  	<li style="font-size:15px;"><a href="invite_friends.php"><?php echo $lang['Invite Friends'];?></a></li>

    <li style="font-size:15px;"><a href="request_sent.php"><?php echo $lang['Request Sent'];?></a></li>

    <li style="font-size:15px;"><a href="pending_request.php" style="border-right:none;"><?php echo $lang['Pending my approval'];?></a></li>

	</ul>

   

   </div>
<span style="display:block; clear:both;"></span>
   <div id="border">

<form name="find_friend" id="find_friend" action="" method="post" class="form-horizontal" >



<div class="form-group">

<div class="col-md-4">
<select name="gender" id="gender" class="form-control">
              <option value="0" selected="selected"><?php echo $lang['select gender'];?></option>
              <?php 
              $lookupResult = $lookupObject->getLookupValue("GENDER");
              while($rowLookup = mysqli_fetch_assoc($lookupResult))
              {
              echo '<option value='.$rowLookup['lookup_key'].'>'.$rowLookup['lookup_value'].'</option>';
              }
              ?>
            </select>       

</div>

</div>

<div class="form-group">

<div class="col-md-4">

<input type="text" name="college" id="college" placeholder="<?php echo $lang['College/University'];?>" class="form-control"/>

</div>

</div>

<div class="form-group">

<div class="col-md-4">

<input type="text" name="profession" id="profession" placeholder="<?php echo $lang['profession'];?>" class="form-control"/>

</div>

</div>

<div class="form-group">
<div class="col-md-4">

<input type="text" name="country" id="country" placeholder="<?php echo $lang['Country'];?>" class="form-control" />

</div>
</div>


<div class="form-group">

<div class="col-md-4">

<input type="text" name="city" id="city" placeholder="<?php echo $lang['City'];?>" class="form-control" />

</div>

</div>

<div class="form-group">

<div class="col-md-4">

<input type="submit" name="submit" value="<?php echo $lang['Search'];?>" class="button" />

</div>

</div>

</form>





    

<?php 

if(isset($_REQUEST['submit']))

{

	$gender = $_REQUEST['gender'];	

	$college = $_REQUEST['college'];

	$profession = $_REQUEST['profession'];

	$country = $_REQUEST['country'];

	$city = $_REQUEST['city'];
	
$count1=0;
	

	if($gender !='Select Gender')

	{		

		if($college != NULL && $profession != NULL)

		{

			$sql = "select * from member m, member_meta mm, member_education_history meh, qb_country_education_record cer where mm.meta_key='gender' and mm.meta_value='$gender' and mm.member_id=m.member_id and cer.organization_name ='$college' and cer.qb_cer_id=meh.education_organization and meh.member_id=m.member_id and m.member_id!='$member_id' and m.status='$InactiveIDRem'";
			//and designation='$profession'
			

		}

		else if($profession != NULL && $city != NULL)

		{

			$sql = "select * from member m, member_meta mm, geo_city gc where mm.meta_key='gender' and mm.meta_value='$gender' and mm.member_id=m.member_id and mm.meta_key='city' and mm.meta_value=gc.city_id and gc.city_title='$city' and m.member_id!='$member_id' and m.status='$InactiveIDRem'";

		}
		//and designation = '$profession'

		else if($profession != NULL && $country != NULL)

		{

			$sql = "select * from member m, member_meta mm, geo_country gc where gc.country_title = '$country' and gc.country_id=mm.meta_value and mm.meta_key='country' and mm.member_id=m.member_id and  m.member_id!='$member_id' and m.status='$InactiveIDRem'";

		}

		// designation = '$profession' and 

		else if($college != NULL)

		{

			$sql = "select * from member m, member_meta mm, member_education_history meh, qb_country_education_record cer where mm.meta_key='gender' and mm.meta_value='$gender' and mm.member_id=m.member_id and cer.organization_name ='$college' and cer.qb_cer_id=meh.education_organization and meh.member_id=m.member_id and m.member_id!='$member_id' and m.status='$InactiveIDRem'";		

		}

		else if($profession != NULL)

		{

			$sql = "select * from member m, member_meta mm where mm.meta_key='gender' and mm.meta_value='$gender' and mm.member_id=m.member_id  and m.member_id!='$member_id' and m.status='$InactiveIDRem'";
//and designation = '$profession'
		}

		else if($country != NULL)

		{

			$sql = "select * from member m, member_meta mm, geo_country gc where gc.country_title = '$country' and gc.country_id=mm.meta_value and mm.meta_key='country' and mm.member_id=m.member_id and  m.member_id!='$member_id' and m.status='$InactiveIDRem'";

		}

	
	
		else if($city != NULL)

		{

			$sql = "select * from member m, member_meta mm, geo_city gc where mm.meta_key='gender' and mm.meta_value='$gender' and mm.member_id=m.member_id and mm.meta_key='city' and mm.meta_value=gc.city_id and gc.city_title='$city' and m.member_id!='$member_id' and m.status='$InactiveIDRem'";

		}

		else

		{

			$sql = "select * from member m, member_meta mm where mm.meta_key='gender' and mm.meta_value='$gender' and mm.member_id=m.member_id  and m.member_id!='$member_id' and m.status='$InactiveIDRem'";

		}

		

	}

	

	else

	{

	

	if($college != NULL && $profession != NULL && $country != NULL && $city != NULL)

	{	

		$sql = "select * from member m, member_meta mm, member_education_history meh, qb_country_education_record cer, geo_country gc, geo_city gcy where mm.member_id=m.member_id and cer.organization_name ='$college' and cer.qb_cer_id=meh.education_organization  and meh.member_id=m.member_id  and gc.country_title = '$country' and gc.country_id=mm.meta_value and mm.meta_key='country' and mm.meta_key='city' and mm.meta_value=gcy.city_id and gcy.city_title='$city'  where college = '$college' and country = '$country' and city='$city' and m.member_id!='$member_id' and m.status='$InactiveIDRem'" ;

//and designation = '$profession' 
	}

	

	else if($college != NULL && $profession != NULL)

	{

		$sql = "select * from member m, member_education_history meh, qb_country_education_record cer where and cer.organization_name ='$college' and cer.qb_cer_id=meh.education_organization and meh.member_id=m.member_id and m.member_id!='$member_id' and m.status='$InactiveIDRem'";
//and designation = '$profession'
	}

	

	else if($profession != NULL && $country != NULL)

	{

		$sql = "select * from member m, member_meta mm, geo_country gc where gc.country_title = '$country' and gc.country_id=mm.meta_value and mm.meta_key='country' and mm.member_id=m.member_id and  m.member_id!='$member_id' and m.status='$InactiveIDRem'";
//and designation = '$profession'
	}

	

	else if($profession != NULL && $city != NULL)

	{

		$sql = "select * from member m, member_meta mm, geo_city gc where gc.city_title = '$city' and gc.city=mm.meta_value and mm.meta_key='city' and mm.member_id=m.member_id and  m.member_id!='$member_id' and m.status='$InactiveIDRem'";
//designation = '$profession' and
	}

	

	else if($college != NULL)

	{

		$sql = "select * from member m, member_education_history meh, qb_country_education_record cer where and cer.organization_name ='$college' and cer.qb_cer_id=meh.education_organization and meh.member_id=m.member_id and m.member_id!='$member_id' and m.status='$InactiveIDRem'";		

	}

	

	else if($profession != NULL)

	{

		$sql = "select * from member where member_id!='$member_id' and status='$InactiveIDRem'";
//designation = '$profession' and 
	}

	

	else if($country != NULL)

	{

		$sql = "select * from member m, member_meta mm, geo_country gc where gc.country_title = '$country' and gc.country_id=mm.meta_value and mm.meta_key='country' and mm.member_id=m.member_id and  m.member_id!='$member_id' and m.status='$InactiveIDRem'";

	}

	

	else if($city != NULL)

	{

		$sql = "select * from member m, member_meta mm, geo_city gc where gc.city_title = '$city' and gc.city=mm.meta_value and mm.meta_key='city' and mm.member_id=m.member_id and  m.member_id!='$member_id' and m.status='$InactiveIDRem'";
		

	}

	else

	{

		echo $lang['No Records Found'];

	}

	}

	//echo $sql;

	$result = mysqli_query($con, $sql);
$count1=mysqli_num_rows($result);
if($count1==0)
echo $lang['No Records Found'];
	?>
	
	<?php

	while($row = mysqli_fetch_array($result))

	{
	$member  = $row['member_id'];
	
	$block=mysqli_query($con, "select * from blocklist where userid='$member' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
	//echo $block_count;
	if($block_count==0)
	{
		
		$count = mysqli_query($con, "select * from friendlist where added_member_id = '".$member."'");
		$count_res = mysqli_fetch_array($count);
		$count_row = mysqli_num_rows($count);
		
		$fcount = mysqli_query($con, "select * from friendlist where (added_member_id = '$member_id' AND member_id='$member') OR
		(member_id = '$member_id' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row = mysqli_num_rows($fcount);
		
		
$media = $objMember->select_member_meta_value($row['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;

		

?>

<div class=" col-md-12">

<div class="mini-profile" style="width: 65%;">

<div class="form-group">

<div class="mini-profile-avatar">

<div class="col-md-4">

<a href="<?php echo $base_url.$row['username'];?>" title="<?php echo $row['username'];?>"><img src="<?php echo $media;?>" width="68" height="68" /></a>

</div>

</div>



<div class="mini-profile-details">

<div class="col-md-4">

<h3 style="font-size:120%;"><a href="<?php echo $base_url.$row['username'];?>" title="<?php echo $row['username'];?>"><strong><?php echo $row['username'];?></strong></a></h3>

</div>

</div>

</div>

<div class="mini-profile-details-status"></div>

<div class="mini-profile-details-action">

<div class="form-group">

<div class="col-md-8">

<span class="icon-group"><?php echo $count_row.' ';?><?php echo $lang['Friends'];?></span>
<?php
if($fcount_row == 1)
	{
	$fcount2 = mysqli_query($con, "select * from friendlist where (member_id = '$member_id' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row2 = mysqli_num_rows($fcount2);
		if($fcount_row2==1)
		{
		
		
		}
	else
	{?>
	
	<a href="write_message.php?id=<?php echo $row['username'];?>"><span class="icon-write"><?php echo $lang['write message'];?></span></a>
<?php	}
	} 
	else
	{?>
	
	<a href="write_message.php?id=<?php echo $row['username'];?>"><span class="icon-write"><?php echo $lang['write message'];?></span></a>
<?php	}
	
	?>




<?php

$add_friend =mysqli_query($con, "select * from friendlist where added_member_id = '".$member."' and member_id = '".$count_res['member_id']."'");

$add_res  = mysqli_fetch_array($add_friend);

$add_friend_status = $add_res['status'];

/*if($add_friend_status == 0)

{

if($row['member_id']!=$member_id)

{*/

?>


<?php 
if($fcount_row <= 0)
{

?>

<a href="#myform1<?php echo $member;?>" rel="ibox" id="add_as<?php echo $member;?>" class="add_friend" title="<?php echo $lang['Add as friend'];?>"><span class="icon-add-friend"><?php echo $lang['Add as friend'];?></span></a>
<?php }
else if($fcount_row == 1)
	{
	$fcount1 = mysqli_query($con, "select * from friendlist where (member_id = '$member_id' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row1 = mysqli_num_rows($fcount1);
		if($fcount_row1==1)
		{
		?>
		<div style="float:right" id="fri<?Php echo $member;?>" data-id="<?Php echo $member;?>">

<div style="display:inline;"><input type="button" name="accept_request" value="<?Php echo $lang['confirm'];?>" id="<?Php echo $member;?>" 
        class="accept_request"></div>
        <div style="display:inline;"><input type="button" name="cancel_request" value="<?Php echo $lang['not now'];?>" id="<?Php echo $member;?>" class="cancel_request"></div>

</div>
<div style="display:none; float:right" id="friend<?Php echo $member;?>">
        <input type="button" name="accept_request" value="friends" class="friends">
        </div>
        
		<?php }
	else
	{
	
	 echo "<span class='icon-add-friend'>".$lang['Request Sent']."</span>";
	}
	} 
else
{

?>

<?php echo $lang['friends'];?>

<?php }?>
<span class='icon-add-friend' id="req_sen<?php echo $member;?>" style="display:none;" ><?php echo $lang['Request Sent'];?></span>

</div>

</div>

</div>
<div  id="fr_form<?php echo $member;?>">
<form class='myform' id="myform1<?php echo $member;?>" style="display:none;" action="javascript:void(0)" method="post" val="<?php echo $member;?>">
<div id="req_sent<?php echo $member;?>" style="font-size: 23px; margin: 42px 86px;display:none"><span ><?php echo $lang['Request Sent Successfully'];?></span></div>
<div id="myform_hide<?php echo $member;?>">
<p><?php echo $lang['Are you sure you want to add this friend'];?>?</p>

<textarea name="message" style="width:90%; margin:5px;" placeholder="<?php echo $lang['write message'];?>" id="message<?php echo $member;?>" ></textarea>

<input type="hidden" value="<?php echo $member;?>"  name="member_id" id="member_id"/>
<input type="submit" name="add_friend" value="<?php echo $lang['Add friend'];?>" class="button" style="margin:3px; margin-top:10px; margin-left:250px;" id="add_friend"/>
<input type="button" class="button" name="cancel" id="cancel_request" onclick="javascript:{window.location.reload();}" value="<?php echo $lang['Cancel'];?>" style="margin:3px; margin-top:10px; float:right;"/>
</div>
</form>
</div>


<?php 

//}

//}



?>



</div>

</div>

	<?php	

	}
}
	echo '</div>';

}

?>

</div>

</div><!--end column_left div-->

<!--Start column right-->
    <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->

</div><!--end mainbody div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>