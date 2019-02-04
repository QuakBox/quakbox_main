<?php
	error_reporting(-1);
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
	$objMember = new member1(); 
	$lookupObject = new lookup();
	$member_id = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$countryCode=strtolower($_REQUEST['country']);
	$miscObjCountry=new misc();	
	$countryResult=$miscObjCountry->getcountryByCode($countryCode);
	
	$countryID=0;
	$countryTitle='';

	foreach($countryResult as $valueCountryResult){
		$countryID=$valueCountryResult['country_id'];
		$countryTitle=$valueCountryResult['country_title'];
	}	
	
?>
<link href="<?php SITE_URL ?>/css/jquery-ui.css" rel="Stylesheet"></link>
<script src="<?php SITE_URL ?>/js/jquery-ui.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {

	var country_id = $("#country_code").val();

$("#invite_frinds").autocomplete({

	

	 source: window.location.origin+"/load_data/country_invite_names_ajax.php?c="+country_id,			

			select: function(event,ui)

			{				

				$( "#event_member_id" ).val( ui.item.id);				

			}

 });
 
});
</script>
	 
	 <div class="insideWrapper container"> 
	 <?php if($countryID>0){?>
		<div class="col-lg-8" style="background:#fff;" >
			
<h2><?php echo $lang['Invite friends to'];?> <?php echo $countryTitle?></h2>

<form name="find_friend" id="find_friend" action="action/add_country_member-exec.php" method="post">

<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />

<input type="hidden" name="country_code" id="country_code" value="<?php echo $res['code'];?>" />

<input type="hidden" name="event_member_id" id="event_member_id" value="" />


   <div class="form-group">

     

      <label for="Invite Friends" class="control-label col-md-4">* <?php echo $lang['Invite Friends You Email'];?></label>   

      	 <div class="col-md-4">

		<input id="invite_frinds" class="form-control" type="text" value="" name="invite_frinds" placeholder="<?php echo $lang['Invite Friends'];?>"></input>

        </div>







<input type="hidden" value="save" name="action"></input>

<input type="hidden" value="" name="groupid"></input>
</div>


<div class="form-group">

<div class="col-md-4 crt_grp" style="margin-top: 20px;">

<input class="button validateSubmit" type="submit" value="<?php echo $lang['add'];?>"></input>

<input class="button" type="button" value="<?php echo $lang["Cancel"];?>" onclick="window.open('<?php echo $base_url;?>country_wall.php?country=<?php echo $country;?>','_self')"></input>
</div>

</div>

</form>

</div>
<?php }
		else{ 
			print '<div class="col-lg-12" style="font-size:30px;padding:10px;"> <i class="fa fa-search"></i> <span style="margin-left:10px;">Sorry No results</span> </div>';
		}
  	
  	
  	?>
<script type="text/javascript">
	$(document).ready(function() {
   
    
    
    $('#find_friend').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            invite_frinds: {
                validators: {
                    notEmpty: {
                        message: 'This feild is required'
                    }
                }
            }
        }
    });
    
    
});
</script>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>