<?php 
ob_start();
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
        require_once('includes/time_stamp.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	
        $sql = mysqli_query($con, "select ads_id from ads where status=0 AND ad_creator='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
        $sql1 = mysqli_query($con, "select ads_id from ads where status=0 AND ad_creator='".$member_id."'") or die(mysqli_error($con));
	$res_count = mysqli_fetch_array($sql1);
      
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

    
<script type="text/javascript" >
 $(document).ready(function() { 
		
		load_options('','country');
		
            $('#photoimg').on('change', function()

			{
			    $("#preview").html('');
			    $("#preview").html('<img src="images/loader.gif" alt="<?php echo $lang['Uploading'];?>...."/>');
			    $("#imageform").ajaxForm({
						target: '#preview',
                        success: function(data){
						    str = data;
                            str = str.indexOf("<img");
                            if(str > -1){
                                $("#flag-img").val("true");
                            } else {
                                $("#flag-img").val("false");
                            }
                        }
			    }).submit();

			});



            $('.validateSubmit').on('click', function()
            {
                $("#adsform").ajaxForm({
                    success: function(data){
                        resData = data;
                        res = resData.indexOf("<script");
                        if(res > -1){
                            $(data).find('script').each(function(){
                                eval($(this).text());
                            });
                        } else {
                            alert(data);
                            Console.log(data);
                        }
                    }
                });
            });

			//Advertise title
			$('#title').keyup(function() {
    $('#adtitle').html($(this).val());
    //$("#adtitle").css("width", "180px");
});
//Advertise Body
$('#description').keyup(function() {
    $('#adbody').html($(this).val());
});

//image size
$(".radi").change(function () {

    var val = $('.radi:checked').val();
    document.getElementById('sizeofimage').value=val;

    //alert(document.getElementById('sizeofimage').value);
});

        }); 
		
		
function load_options(id,index){
	$("#loading").show();
	
	if(index=="state"){
		$("#city").html('<option value=""><?php echo $lang['Select City'];?></option>');
	}
	$.ajax({
		url: "load_data/ajax.php?index="+index+"&id="+id,
		complete: function(){$("#loading").hide();},
		success: function(data) {
		
			$("#"+index).html(data);
			
			
		}
	})
}

</script>

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
<div id="wrapper" align="left">
    <div class="headerMenu">
       <?php include('includes/qb_header.php');
           include_once("config.php"); 
        ?>
    </div>
    
    
<div id="mainbody">
<?php if($res_count) {  ?>
<div class="column_left" style="border:none;">
<div class="column_internal_left" style="padding:5px;margin-top:0">

    <div class="adsheading"><?php echo $lang['Design Your ad'];?> &nbsp;&nbsp;&nbsp;<a style="color:#261f50;" href="<?php echo $base_url;?>view_add_user.php">View Ads</a></div>
<div class="alert alert-error" style=" color: white; font-size:13px;">
  You have already posted one ad.
</div>
</div>
<?php } else { ?>
<div class="column_left">
<div class="column_internal_left" style="padding:5px;margin-top:0">

<div class="adsheading"><?php echo $lang['Design Your ad'];?> </div>
<br>
<div class="adsdiv">
  <form id="imageform" method="post" enctype="multipart/form-data" action='action/ajaximage.php'>
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr>
    <td colspan="4" align="left" class="adstd"><span></span><?php echo $lang['Image'];?>(<?php echo $lang['opitional'];?>)<br></td>
  </tr>
  <br>
 
  <br>
  <tr>
  <p>
    <td colspan="4" class="adstd1">
<input type="file" name="image" id="photoimg" /> <input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" /><input type="hidden" name="sizeofimage" id="sizeofimage" value="3" >
</td>
   </p>
   </tr>
  </table>
        </form>
 <form  id="adsform" method="post" action='action/ads-exec2.php'>
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>

  <input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
  <td align="right">Ads &nbsp;&nbsp; <input name="typeofadd" id="rad" value="<?php echo $lang['Social Ads'];?>" type="radio" checked />&nbsp;<?php echo $lang['Social Ads'];?> <td class="adstd2"><input name="typeofadd" id="rad" value="<?php echo $lang['Partners'];?>" type="radio"/>&nbsp;<?php echo $lang['Partners'];?></td>
  
  
  <tr>
    <td colspan="4">
  </tr>
  <tr>
    <td colspan="4"><br><h4><?php echo $lang['Destination URL, Example'];?>: http://www.yourwebsite.com</h4></td>
  </tr>
  <tr>
  
  <td class="adstd3"><select id="http" name="http" >
    <option>http://</option>
    <option>https://</option>
   </select></td>
    <td class="adstd2">
    <input id="title2" class="required inputbox" type="text" value="" size="40" name="url" /></td>
 <tr>
     
     
     <td class="adstd3">
       <label>* <?php echo $lang['Title'];?></label>
       </td>
     <td class="adstd3">
     <input id="title" class="required inputbox" type="text" value="" size="40" name="title"  required="required"></td>
</tr>

 <tr>
     
     
     <td class="adstd3">
       <label>* <?php echo $lang['Ad Start Date'];?></label>
       </td>
     <td class="adstd2">
     <input id="MyDate1"  name="start_date" type="text"  required="required"></td>
</tr>

 <!--
<tr>
     
    
     <td class="adstd3">
       <label>* <?php echo $lang['Ad End Date'];?></label>
       </td>
     <td class="adstd2">
     <input id="MyDate2" type="text"  name="end_date" required="required"></td>
</tr>
-->
<tr>
<td class="adstd3">
<label>*<?php echo $lang['Body Text'];?></label>
</td>
<td class="adstd2">
<textarea id="description" class="required inputbox" type="text" value="" size="45"  name="description" required="required"></textarea></td>
</tr>
<tr>
  <td colspan="4"></td>
</tr>
</table>
</div>
<!------------------------->
<br>
<br>
<div class="adsheading"><?php echo $lang['Targeting'];?></div>
<br>
<div id="target" class="hidden"><?php echo $lang['vindo'];?></div>
<div class="adsdiv">
<table width="700" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="adstd2"><table width="700" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="4"><span id="ad-form-span"><h4><?php echo $lang['Please fill the form details to reach the right audience'];?>.</h4><br></span></td>
    </tr>
  <td class="adstd3">
  <label ><?php echo $lang['Gender'];?></label></td>
    <td class="adstd2">&nbsp;
          <span class="txtalignleft"></span>
          <span txtaligncenter></span>
          <input type="checkbox" name="gender" value="male"> <?php echo $lang['male'];?>
      <input type="checkbox" name="gender" value="female"><?php echo $lang['Female'];?> </td>
  </tr>
 
  <tr>
    <td class="adstd3"><label ><?php echo $lang['Select country'];?>:</label></td>
    <td class="adstd2"><select class="adsselect" id="country" onchange="load_options(this.value,'state'); pot_user()" name="countries">
      <option value=""><?php echo $lang['Select country'];?></option>
    </select></td>
  </tr>
  <tr>
    <td class="adstd3"><label ><?php echo $lang['Select state'];?>:</label></td>
    <td class="adstd2"><select class="adsselect" id="state" onchange="load_options(this.value,'city');" name="state">
      <option value="" ><?php echo $lang['Select state'];?></option>
    </select></td>
  </tr>
  <tr>
    <td class="adstd3"><label ><?php echo $lang['Select City'];?>:</label></td>
    <td class="adstd2"><select class="adsselect" id="city" name="city">
      <option value=""><?php echo $lang['Select City'];?></option>
    </select></td>
  </tr>
 <!-- <td class="adstd3"><label >DOB</label></td>
    <td class="adstd2"><input id="title2" type="text" value="" size="40" name="dob" class="adsselect" /></td>-->
   
  </tr>
  
  
  <tr>
    <td class="adstd3"><label ><?php echo $lang['AGE LIMIT'];?>:</label></td>
    <td class="adstd2">
 
    <select id="agelimit" name="agelimit">
    <option value=""><?php echo $lang['Select Age Limit'];?></option>
    <option value="<10"> <?php echo $lang['Less Than 10 Years'];?></option>
      <option value=">10 && <21"> <?php echo $lang['Greater Than 10 And'];?> <br /><?php echo $lang['Less Than Or Equal To 20 Years'];?></option>
       <option value=">20&& <31"> <?php echo $lang['Greater Than 20 And'];?> <br /><?php echo $lang['Less Than Or Equal To 30 Years'];?></option>
        <option value=">30"><?php echo $lang['Greater Than 30 Years'];?></option>
       
    </select>
    </td>
  </tr>
  
  <tr>
    <td colspan="4" ></td>
  </tr>
  <tr>
    <td colspan="4"></td>
  </tr>
  </table></td>
</tr>
</table>
</div>

<!--------------------------------------->
<br><br>
<div class="adsheading"><?php echo $lang['Pricing'];?></div>
<br>
<div class="adsdiv">

<table width="500" border="0" cellspacing="0" cellpadding="0">
 
  <td class="adstd3">
  <label ><?php echo $lang['How do you want the ads to be charged'];?>?</label>
  </td>
  <td class="adstd2">
  <select class="adsselect" id="per" name="per">
    <option><?php echo $lang['Per Click'];?></option>
    <option><?php echo $lang['Per Like'];?></option>
	</select></td>
    
  
  <label > </label>
  </td>
  <tr>
  <td class="adstd3">
  <label ><br><?php echo $lang['How many clicks/impressions do you want to buy'];?>?</label>
  </td>
  
  <td class="adstd2"><br><input name="click_payment" class="adsselect"  size="10" id="click_payment" type="text"/><span id="errmsg"></span></td></tr>
   <td colspan="4"><br><h3><?php echo $lang['Total Amount you need to pay'];?>:</h3></td>
    
  </tr>
  
  <td class="adstd3">
  <label ><?php echo $lang['Select Payment Gateway'];?></label></td>
    <td class="adstd2"><select class="adsselect" name="paypal" id="paypal">
      <option><?php echo $lang['paypal'];?></option>
    </select></td>
  <tr>
    <td colspan="3">&nbsp;</td></tr>
  <tr>
    
    
    
  </tr>
  <tr>
    <td colspan="4"><h4>** <?php echo $lang['Please note that you cannot change from Like pricing to click pricing or viceversa later for this add'];?></h4> </td></tr>
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td colspan="4"></td>
  
  </tr>
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
  <td colspan="4"></td>
   </p>
   </tr>
  <tr>    
    <td colspan="2">
   <div align="center">
       <input id="flag-img" value="false" type="hidden" name="flag_img">
       <input class="button validateSubmit" type="submit" value="<?php echo $lang['Save']; ?>" align="center" height="50px" width="50px"/></div>
    <tr>    
    
    
    </td>
    </tr>
</table>
</form>
</div>
<!------------------------------------------------------>
    
</div><!--end column_internal_left div-->

<div class="column_internal_ads" >
		<input class="flatButton manage_ads" type="button" align="middle" value="<?php echo $lang['Manage Ads']; ?>"/>
	<div id="preview1" class="preview1" >
		<div id="adtitle">
		</div>	
		<div id='preview'>
		</div>
		<div id="adbody">
		</div>
       
	</div>
		
	</div>	
	<?php } ?>		
</div><!--end column_left div-->
<!--Start column right-->
<?php //include 'ads_right_column.php';?>
<!--end column_right div-->
</div><!--end mainbody div-->
<?php include 'includes/qb_footer.php';?>
</div><!--end wrapper div-->

</body>
</html>

<script>
$(document).ready(function(e) {
    //alert('hi');
	
	jQuery('#MyDate2').datepicker({
        dateFormat : 'yy-mm-dd',
  changeMonth: true,
    });
	  jQuery("#MyDate1").datepicker({
        dateFormat : 'yy-mm-dd',
  changeMonth: true,
        minDate:  0,
        onSelect: function(date){            
            var date1 = jQuery('#MyDate1').datepicker('getDate');           
            var date = new Date( Date.parse( date1 ) ); 
            date.setDate( date.getDate() + 1 );        
            var newDate = date.toDateString(); 
            newDate = new Date( Date.parse( newDate ) );                      
           jQuery('#MyDate2').datepicker("option","minDate",newDate);            
        }
    });
	
	
	 $("#click_payment").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("<?php echo $lang['Digits Only']; ?>").show().fadeOut("slow");
               return false;
    }
   });
	
	
	
	
});

function pot_user()
{
	//alert('hi');
	var country=$("#country").val();
	//alert(country)
	$("#target").fadeIn();
	$.ajax({
            type: "POST",
            url: "pot_user.php",
            data: {country:country},
            cache: false,
            success: function (html) {
               $("#target").html(html);
            }
        });
	
}
</script>
