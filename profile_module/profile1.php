<?php 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header1.php');
	$memberObject = new member1();
	$lookupObject = new lookup();
	$objMember = new member1();
	
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'],$con);
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$id=$res['member_id'];
        $gender= $memberObject->select_member_meta_value_for_lookupID($id,"Gender");
        $birthdate= $res['dob'];
        $relationship=$memberObject->select_member_meta_value_for_lookupID($id,"relationship_status");
        $language=$memberObject->select_member_meta_value_for_lookupID($id,"language_known");
        $political_views=$memberObject->select_member_meta_value_for_lookupID($id,"political_view");
        $displayName = $res['displayname'];
        $current_profile_image = $memberObject->select_member_meta_value($id,"current_profile_image");
        $current_profile_image = $base_url.$current_profile_image;
        
        $email_id= $res['email'];
        $mobile_no= $memberObject->select_member_meta_value($id,"phone_mobile");
        $landline_no= $memberObject->select_member_meta_value($id,"phone_landline");
        $address=$memberObject->select_member_meta_value($id,"address");
        $country=$memberObject-> select_member_meta_value_for_GeoCountry($id);
        $state=$memberObject-> select_member_meta_value_for_GeoState($id);
        $city=$memberObject-> select_member_meta_value_for_GeoCity($id);
        $zip=$memberObject->select_member_meta_value($id,"zip");
        $curcity=$memberObject->select_member_meta_value($id,"current_city");
        $hometown=$memberObject->select_member_meta_value($id,"home_town");
        $website=$memberObject->select_member_meta_value($id,"website");
        
        $educationResult = $memberObject->select_member_Education_history($member_id);
        $edures = mysqli_fetch_array($educationResult);
        $organization_name = $edures['organization_name'];
        $education_grade = $edures['education_grade'];
        $education_grade = $lookupObject->getValueByKey($education_grade);
        $education_year_from = $edures['education_year_from'];
        $education_year_to = $edures['education_year_to'];
        /*$country=$memberObject-> select_member_meta_value_for_GeoCountry($id);
        $state=$memberObject-> select_member_meta_value_for_GeoState($id);
        $city=$memberObject-> select_member_meta_value_for_GeoCity($id);
        $zip=$memberObject->select_member_meta_value($id,"zip");
        $curcity=$memberObject->select_member_meta_value($id,"current_city");
        $hometown=$memberObject->select_member_meta_value($id,"home_town");
        $website=$memberObject->select_member_meta_value($id,"website");*/
        
        $lookupResultgender = $lookupObject->getLookupValue("GENDER");
        $printGender = '[';
        while($rowLookupgender = mysqli_fetch_assoc($lookupResultgender))
        {
          $printGender .= "{value: ".$rowLookupgender['lookup_key'].", text: '".$rowLookupgender['lookup_value']."'},";
        }
        $printGender .= ']';        
?>
<script type="text/javascript">

jQuery(function(){
 $('#addGender').editable({
                           value: null,    
			   source: <?php echo json_encode($printGender); ?>,
                           name:  'add_gender',
                           url:   window.location.origin+'/action/basic_info-exec.php',  
                           title: 'Select Gender',
                           validate: function(value) {
			    if($.trim(value) == '') {
			        return 'This field is required';
			    }
			  }
                        });
                        
 $('#addBday').editable({
                           pk:    1,
                           name:  'add_bday',
                           url:   window.location.origin+'/action/basic_info-exec.php',  
                           title: 'Enter Birthday',
                           format: 'yyyy-mm-dd',    
		           viewformat: 'dd/mm/yyyy',    
		           datepicker: {
		                weekStart: 1
		           },
                           validate: function(value) {
                            if($.trim(value) == '') {
			        return 'This field is required';
			    }
			  }
                        });

 $('#change_lname').editable({
                           type:  'text',
                           pk:    1,
                           name:  'l_member_name',
                           url:   window.location.origin+'/action/change_lname.php',  
                           title: 'Enter Last Name',
                           validate: function(value) {
                           var regexname = /^[a-zA-Z ]*$/;
			    if($.trim(value) == '') {
			        return 'This field is required';
			    }else if(!regexname.test(value)) {
			        return 'The Last Name can only consist of alphabets';
			    }
			  }
                        });
                        
$('#change_username').editable({
                           type:  'text',
                           pk:    1,
                           name:  'username',
                           url:   window.location.origin+'/action/change_username-exec.php',  
                           title: 'Enter Username',
                           validate: function(value) {
                           var regexname = /^[a-zA-Z0-9_\.]+$/;
			    if($.trim(value) == '') {
			        return 'This field is required';
			    }else if($.trim(value).length < 6 || $.trim(value).length > 30) {
			        return 'The username must be more than 6 and less than 30 characters long';
			    }else if(!regexname.test(value)) {
			        return 'The username can only consist of alphabetical, number, dot and underscore';
			    }
			  },
			  success: function(data, config) {
			  obj = JSON && JSON.parse(data) || $.parseJSON(data);
			  var msg = '';
			   if(obj && obj.result) {  //record created, response like {"id": 2}
			       //proceed success...    
			       msg = 'Successfully Updated';   
			   }else if(obj && obj.errors) {              //validation error
			            
			            $.each(obj.errors, function(k, v) { msg += k+": "+v+"<br>"; }); 
			             
			    } else if(obj.responseText) {   //ajax error
			            msg = obj.responseText; 
			     }
			    
			     $('#msg').html(msg);
			     $('#msg').show();              
			}
                         });  
                   
$('#change_email').editable({
                           type:  'text',
                           pk:    1,
                           name:  'email',
                           url:   window.location.origin+'/action/change_email-exec.php',  
                           title: 'Enter Email',
                           validate: function(value) {
                           var regexname = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			    if($.trim(value) == '') {
			        return 'This field is required';
			    }else if(!regexname.test(value)) {
			        return 'The input is not a valid email address';
			    }
			  },
			  success: function(data, config) {
			  obj = JSON && JSON.parse(data) || $.parseJSON(data);
			  var msg = '';
			   if(obj && obj.result) {  //record created, response like {"id": 2}
			       //proceed success...    
			       msg = 'Successfully Updated';   
			   }else if(obj && obj.errors) {              //validation error
			            
			            $.each(obj.errors, function(k, v) { msg += k+": "+v+"<br>"; }); 
			             
			    } else if(obj.responseText) {   //ajax error
			            msg = obj.responseText; 
			     }
			    
			     $('#msg').html(msg);
			     $('#msg').show();              
			}
                        });
                        
$('#change_password').editable({
                           display: false,
                           pk:    1,
                           name:  'password',
                           url:   window.location.origin+'/action/change_password-exec.php',  
                           title: 'Enter Password',
                           validate: function(value) {
			    if($.trim(value) == '') {
			        return 'This field is required';
			    }else if($.trim(value).length < 8 || $.trim(value).length > 30) {
			        return 'The Password must be more than 8 and less than 30 characters long';
			    }
			  },
			  success: function(data, config) {
			  obj = JSON && JSON.parse(data) || $.parseJSON(data);
			  var msg = '';
			   if(obj && obj.result) {  //record created, response like {"id": 2}
			       //proceed success...    
			       msg = 'Successfully Updated';   
			   }else if(obj && obj.errors) {              //validation error
			            
			            $.each(obj.errors, function(k, v) { msg += k+": "+v+"<br>"; }); 
			             
			    } else if(obj.responseText) {   //ajax error
			            msg = obj.responseText; 
			     }
			    
			     $('#msg').html(msg);
			     $('#msg').show();              
			}
                        });   

                                            
       
});
</script>

<script src="<?php echo $base_url.'assets/birthday_picker/js/jquery-birthday-picker.min.js';?>"></script> 
<style>
	.birthdayPicker select {
		border: 0 !important;  /*Removes border*/
		-webkit-appearance: none;  /*Removes default chrome and safari style*/
		-moz-appearance: none; /* Removes Default Firefox style*/
		background: #4969cc ;
		width: 60px; /*Width of select dropdown to give space for arrow image*/
		text-indent: 0.01px; /* Removes default arrow from firefox*/
		text-overflow: "";  /*Removes default arrow from firefox*/ /*My custom style for fonts*/
		color: #FFF;
		border-radius: 15px;
		padding: 5px;
		box-shadow: inset 0 0 5px rgba(000,000,000, 0.5);
		margin-left:2px;
		
		font-size: 12px;
	}
	.demo select.balck {
		background-color: #000;
	}
	.demo select.span1 {
		border-radius: 10px 0;
	}
</style>


<style>
.widthSelect40 {
width:50%;
}
.dsiplInlineBlock  {
display:inline-block;
}
.tr {
min-height:25px;
margin-top: 10px;
border-bottom: 1px solid rgb(221, 221, 221);
}
.hiddenTR {
   display: none;
}
.first-child {
    border-top: 0;
}

.td {
border-top: 0;
display: table-cell;
width: 140px; 
}

.td1 {
border-top: 0; 
width: 80px;  
}
.editTd{
display: table-cell;
width: 60%;
}
.editTd:hover
{
background:url(images/edit_icon.png) right no-repeat #80C8E5;
cursor:pointer;
}
.toppad
{margin-top:20px;
}
.tablew
{width: 100%;
margin-bottom: 20px;
display: table;
border-collapse: separate;
-webkit-border-horizontal-spacing: 2px;
-webkit-border-vertical-spacing: 2px;
border-top-color: gray;
border-right-color: gray;
border-bottom-color: gray;
border-left-color: gray;
max-width: 100%;
background-color: transparent;
border-collapse: collapse;
border-spacing: 0;
}
</style>
<script type="text/javascript">

		jQuery(document).ready(function(){
			load_options('','country');
			// binds form submission and fields to the validation engine
			//jQuery("#addrForm").validationEngine();
		});

		/**
		*
		* @param {jqObject} the field where the validation applies
		* @param {Array[String]} validation rules for this field
		* @param {int} rule index
		* @param {Map} form options
		* @return an error string if validation failed
		*/
		function checkHELLO(field, rules, i, options){
			if (field.val() != "HELLO") {
				// this allows to use i18 for the error msgs
				return options.allrules.validate2fields.alertText;
			}
		}
		
		function loadSelectbox(){
				    
				    var prefix = "selectBox_"

				// binds form submission and fields to the validation engine
				jQuery("#addrForm").validationEngine({
					prettySelect : true,
					usePrefix: prefix
				});
				    
                                    $("select").selectBox();
                                    // By default, selectBox does not create an id to the newly created element - We need to add this manually
                                    $('select').each(function(){ 
                                        // The jquery validation engine needs an id on the "a" element created by selectBox plugin
                                        $(this).next('a.selectBox')
                                        // Since id needs to be unique, we use a prefix here (can use suffix - up to you)
                                        .attr("id", prefix + this.id )
                                        // By default, all classes are passed on to the new element - Important: We need to remove it
                                        .removeClass("validate[required]");		
                                    });
                                }

				/*$("select").selectBox();

				// By default, selectBox does not create an id to the newly created element - We need to add this manually
				$('select').each(function(){ 
					// The jquery validation engine needs an id on the "a" element created by selectBox plugin
			    $(this).next('a.selectBox')
			    // Since id needs to be unique, we use a prefix here (can use suffix - up to you)
			    .attr("id", prefix + this.id )
			    // By default, all classes are passed on to the new element - Important: We need to remove it
			    .removeClass("validate[required]");		
			  })
			  
			  // This demo is for hidden elements in the form
			  */
			  
		
		function load_options(id,index){
	//$("#loading").show();
	
	if(index=="state"){
		$("#city").html('<option value="">Select city</option>');
	}
	$.ajax({
		url: "load_data/ajax.php?index="+index+"&id="+id,
		complete: function(){
		//$("#loading").hide();
		},
		success: function(data) {
		
			$("#"+index).html(data);
			// loadSelectbox();
			
		}
	})
}
	</script>
	<script type="text/javascript">

		jQuery(document).ready(function(){
			load_options1('','country');
			// binds form submission and fields to the validation engine
			//jQuery("#educationForm").validationEngine();
		});

		/**
		*
		* @param {jqObject} the field where the validation applies
		* @param {Array[String]} validation rules for this field
		* @param {int} rule index
		* @param {Map} form options
		* @return an error string if validation failed
		*/
		/*
		
		function loadSelectbox(){
				    
				    var prefix = "selectBox_"

				// binds form submission and fields to the validation engine
				jQuery("#educationForm").validationEngine({
					prettySelect : true,
					usePrefix: prefix
				});
				    
                                    $("select").selectBox();
                                    // By default, selectBox does not create an id to the newly created element - We need to add this manually
                                    $('select').each(function(){ 
                                        // The jquery validation engine needs an id on the "a" element created by selectBox plugin
                                        $(this).next('a.selectBox')
                                        // Since id needs to be unique, we use a prefix here (can use suffix - up to you)
                                        .attr("id", prefix + this.id )
                                        // By default, all classes are passed on to the new element - Important: We need to remove it
                                        .removeClass("validate[required]");		
                                    });
                                }

				$("select").selectBox();

				// By default, selectBox does not create an id to the newly created element - We need to add this manually
				$('select').each(function(){ 
					// The jquery validation engine needs an id on the "a" element created by selectBox plugin
			    $(this).next('a.selectBox')
			    // Since id needs to be unique, we use a prefix here (can use suffix - up to you)
			    .attr("id", prefix + this.id )
			    // By default, all classes are passed on to the new element - Important: We need to remove it
			    .removeClass("validate[required]");		
			  })
			  
			  // This demo is for hidden elements in the form
			  */
			  
		
		function load_options1(id,index){
	//$("#loading").show();
	
	if(index=="state"){
		$("#cityedu").html('<option value="">Select city</option>');
	}
	
	$.ajax({
		
		url: "load_data/ajax.php?index="+ index +"&id="+id,
		complete: function(){
		//$("#loading").hide();
		},
		success: function(data) {
		
			$("#"+index+"edu").html(data);
			// loadSelectbox();
			
		}
	})
}
</script>

<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8" style="text-align:center">
    <div id="msg" class="alert alert-danger" role="alert" style="display:none;"></div>
    <div class="row">
          
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-7 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-3 toppad" >
    <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title"><?php echo $displayName; ?></h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center"><img alt="<?php echo $displayName; ?>" src="<?php echo $current_profile_image; ?>" class="img-circle" height="100px" width="100px"> </div>
                    <div class=" col-md-9 col-lg-9 "> 
                      <div class="tablew table-user-information">
                        <div>
              
                           <div id="genderFull" class="tr first-child">
                           <div class="td"><span ><?php echo $lang['Gender'];?> :</span ></div>
                           <div class="editTd">
                           <a href="javascript:void(0);" class="SettingsListLink pvm phs" data-type="select" data-pk="1" id="addGender">
<span class="SettingsListItemContent"><strong><?php if($gender ==null){
                        echo 'Add Your Gender';
                        }else{
                        echo $gender; 
                        } ?></strong></span>
			  </a>
			  </div>
                          </div>
                          
                          <div id="bdayFull" class="tr">
                            <div class="td"><span ><?php echo $lang['Birthday'];?> :</span></div>
                            <div class="editTd">
                            <a href="javascript:void(0);" id="addBday" data-type="date" data-pk="1" data-url="/post" data-title="Select Date">
                            <div><?php
                             if($birthdate==null){
                            echo 'Add Your Birthday';
                            }else{
                            echo $birthdate; 
                            } ?></div>
                            </a>
                            </div>
                          </div>
                       
                          
                          
                          <div id="relaFull" class="tr">
                           <div class="td"> <span ><?php echo $lang['Relationship'].' '.$lang['Status'];?> :</span></div>
                           <div id="addRela" class="editTd"> <span ><?php 
                            if($relationship==null){
                            echo '<a href="javascript:void(0)"> Add Relationship Status</a>';
                            }else{
                            echo $relationship; 
                            }
                            ?></span></div>
                          </div>
                          <div id="relaTR" class="hiddenTR">
                            <form id="relaForm"  name="relaForm" >
                    <select class="form-control col-xs- widthSelect40 dsiplInlineBlock" id="relationship" name="relationship">
                    <?php 
                      $lookupResultrela = $lookupObject->getLookupValue("Relationship Status");
                      while($rowLookuprela = mysqli_fetch_assoc($lookupResultrela))
                      {
                      echo '<option value='.$rowLookuprela['lookup_key'].'>'.$rowLookuprela['lookup_value'].'</option>';
                      }
                      ?>
                    </select>
                    <button id="relaSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="relaCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                          
                          
                       
                             <div id="langFull" class="tr">
                            <div class="td"><span ><?php echo $lang['Languages'].' Known';?> :</span></div>
                            <div id="addLang" class="editTd"><span ><?php
                            if($language ==null){
                            echo '<a href="javascript:void(0)"> Add Languages</a>';
                            }else{
                            echo $language; 
                            } ?></span></div>
                          </div>
                          <div id="langTR" class="hiddenTR">
                            <form id="langForm"  name="langForm" >
                    <select class="form-control col-xs- widthSelect40 dsiplInlineBlock" id="language" name="language">
                    <?php 
                      $lookupResultlang = $lookupObject->getLookupValue("Languages Known");
                      while($rowLookuplang = mysqli_fetch_assoc($lookupResultlang))
                      {
                      echo '<option value='.$rowLookuplang['lookup_key'].'>'.$rowLookuplang['lookup_value'].'</option>';
                      }
                      ?>
                    </select>
                    <button id="langSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="langCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                          
                          
                            <div id="poliFull" class="tr">
                            <div class="td"><span ><?php echo $lang['Political Views'];?> :</span></div>
                           <div id="addPoli" class="editTd"><span ><?php 
                            if($political_views ==null){
                            echo '<a href="javascript:void(0)"> Add Political Views</a>';
                            }else{
                            echo $political_views; 
                            } ?></span></div>
                          </div>
                          <div id="poliTR" class="hiddenTR">
                            <form id="poliForm"  name="poliForm" >
                    <select class="form-control col-xs- widthSelect40 dsiplInlineBlock" id="politics" name="politics">
                    <?php 
                      $lookupResultpoli = $lookupObject->getLookupValue("Political View");
                      while($rowLookuppoli = mysqli_fetch_assoc($lookupResultpoli))
                      {
                      echo '<option value='.$rowLookuppoli['lookup_key'].'>'.$rowLookuppoli['lookup_value'].'</option>';
                      }
                      ?>
                    </select>
                    <button id="poliSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="poliCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                         
                        </div><!--tbody -->
                      </div><!--table -->
                     
                    </div>
                  </div>
                </div>
                     <div class="panel-footer">
                            <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
                            <span class="pull-right">
                                <a href="javascript:void(0)" data-original-title="Edit Basic Info" data-toggle="tooltip" type="button" 
                                class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                                <a data-original-title="Remove this Information" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                            </span>
                        </div>
                
              </div>
            </div>
            
            
            <?php  
       // $id=$res['member_id'];
        
        
        ?>
            
            
            
            
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-7 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-3 toppad" >
    <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title">Contact Information</h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center"></div>
                    <div class=" col-md-9 col-lg-9 "> 
                      <div class="tablew table-user-information">
                        <div>
              
                          <div id="emailFull" class="tr first-child">
                            <div class="td"><span ><?php echo $lang['Email'];?> :</span ></div>
                           <div id="addEmail" class="editTd"> <span ><?php 
                            if($email_id ==null){
                            echo '<a href="javascript:void(0)"> Add Your Email</a>';
                            }else{
                            echo $email_id; 
                            } ?></span ></div>
                          </div>
                          <div id="emailTR" class="hiddenTR first-child">
                            <form id="emailForm"  name="emailForm" >
                    <input id="email" name="email" type="text" class="form-control dsiplInlineBlock" placeholder="<?php echo $lang['Email'];?>" aria-describedby="sizing-addon3">
                    <button id="emailSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="emailCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                          
                          
                          
                          <div id="mobiFull" class="tr">
                            <div class="td"><span ><?php echo $lang['Mobile No'];?> :</span></div>
                            <div id="addMobi" class="editTd"><span ><?php
                             if($mobile_no ==null){
                            echo '<a href="javascript:void(0)"> Add Your Mobile No.</a>';
                            }else{
                            echo $mobile_no; 
                            } ?></span></div>
                          </div>
                          <div id="mobiTR" class="hiddenTR">
                            <form id="mobiForm"  name="mobiForm" >
                    <input id="mobile" name="mobile" type="text" class="form-control dsiplInlineBlock" placeholder="<?php echo $lang['Mobile No'];?>" aria-describedby="sizing-addon3">
                    <button id="mobiSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="mobiCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                          
                          
                          <div id="otherFull" class="tr">
                           <div class="td"> <span ><?php echo $lang['Other No'];?> :</span></div>
                           <div id="addOther" class="editTd"> <span ><?php 
                            if($landline_no ==null){
                            echo '<a href="javascript:void(0)"> Add Landline No.</a>';
                            }else{
                            echo $landline_no; 
                            }
                            ?></span></div>
                          </div>
                          <div id="otherTR" class="hiddenTR">
                            <form id="otherForm"  name="otherForm" >
                    <input id="other_no" name="other_no" type="text" class="form-control dsiplInlineBlock" placeholder="<?php echo $lang['Other No'];?>" aria-describedby="sizing-addon3">
                    <button id="otherSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="otherCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                          
                          
                          <div id="curcityFull" class="tr">
                           <div class="td"> <span >Current City :</span></div>
                           <div id="addCurcity" class="editTd"> <span ><?php 
                            if($curcity ==null){
                            echo '<a href="javascript:void(0)"> Add Your Current City</a>';
                            }else{
                            echo $curcity; 
                            }
                            ?></span></div>
                          </div>
                          <div id="curcityTR" class="hiddenTR">
                            <form id="curcityForm"  name="curcityForm" >
                    <input id="current_city" name="current_city" type="text" class="form-control dsiplInlineBlock" placeholder="Current City" aria-describedby="sizing-addon3">
                    <button id="curcitySubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="curcityCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                          
                          
                          <div id="hometownFull" class="tr">
                           <div class="td"> <span >Hometown :</span></div>
                           <div id="addHometown" class="editTd"> <span ><?php 
                            if($hometown ==null){
                            echo '<a href="javascript:void(0)"> Add Your Hometown</a>';
                            }else{
                            echo $hometown; 
                            }
                            ?></span></div>
                          </div>
                          <div id="hometownTR" class="hiddenTR">
                            <form id="hometownForm"  name="hometownForm" >
                    <input id="hometown" name="hometown" type="text" class="form-control dsiplInlineBlock" placeholder="Hometown" aria-describedby="sizing-addon3">
                    <button id="hometownSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="hometownCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                          
                          
                          
                          <div id="websiteFull" class="tr">
                           <div class="td"> <span ><?php echo $lang['Website'];?> :</span></div>
                           <div id="addWebsite" class="editTd"> <span ><?php 
                            if($website ==null){
                            echo '<a href="javascript:void(0)"> Add Your Website</a>';
                            }else{
                            echo $website; 
                            }
                            ?></span></div>
                          </div>
                          <div id="websiteTR" class="hiddenTR">
                            <form id="websiteForm"  name="websiteForm" >
                    <input id="website" name="website" type="text" class="form-control dsiplInlineBlock" placeholder="<?php echo $lang['Website'];?>" aria-describedby="sizing-addon3">
                    <button id="websiteSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="websiteCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                       
                       
                       
                             <div id="addrFull" class="tr">
                            <div class="td"><span ><?php echo $lang['Address'];?> :</span></div>
                            <div id="addAddr" class="editTd"><span ><?php
                            if($address ==null){
                            echo '<a href="javascript:void(0)"> Add Address </a>';
                            }else{
                            echo $address.', '.$city.', '.$state.', '.$country.', '.$zip; 
                            } ?></span></div>
                          </div>
                          <div id="addrTR" class="hiddenTR">
                            <form id="addrForm"  name="addrForm" >
                   <input id="address" name="address" type="text" class="form-control dsiplInlineBlock" placeholder="<?php echo $lang['Address'];?>" aria-describedby="sizing-addon3">
                            <div class="form-group">
                    <label for="country" class="td1 dsiplInlineBlock">Country:</label>        
            <select id="country" onChange="load_options(this.value,'state');" name="country" class="form-control col-xs- widthSelect40 dsiplInlineBlock validate[required]" >
                        <option value=" ">Select country</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="state" class="td1 dsiplInlineBlock">State:</label>
                    
                      <select id="state" onChange="load_options(this.value,'city');" name="state" class="form-control col-xs- widthSelect40 dsiplInlineBlock validate[required]">
                        <option  value="">Select state</option>
                      </select>
            
                    </div>
                    
                    <div class="form-group">
                    <label for="city" class="td1 dsiplInlineBlock">City:</label>        
                    <select id="city" name="city" class="form-control col-xs- widthSelect40 dsiplInlineBlock validate[required]">
                        <option value="">Select City</option>
                    </select>
                    </div>
            <input id="zip" type="text" class="form-control dsiplInlineBlock" placeholder="<?php echo $lang['Zip Code'];?>"
            aria-describedby="sizing-addon3">
                    <button id="addrSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="addrCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                          
                          
                            
                         
                        </div><!--tbody -->
                      </div><!--table -->
                     
                    </div>
                  </div>
                </div>
                     <div class="panel-footer">
                            <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
                            <span class="pull-right">
                                <a href="javascript:void(0)" data-original-title="Edit Contact Information" data-toggle="tooltip" type="button" 
                                class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                                <a data-original-title="Remove this Info" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                            </span>
                        </div>
                
              </div>
            </div>
            
            <!--education history -->
            <?php  
       // $id=$res['member_id'];
        
        
        ?>
            
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-7 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-3 toppad" >
    <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title"><?php echo $lang['Education'];?></h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center"></div>
                    <div class=" col-md-9 col-lg-9 "> 
                      <div class="tablew table-user-information">
                        <div>
              
                          <div id="organizationFull" class="tr first-child">
                            <div class="td1 dsiplInlineBlock"><span >Organization Name:</span ></div>
                           <div id="addOrganization" class="dsiplInlineBlock"> <span ><?php 
                            if($organization_name ==null){
                            echo '<a href="javascript:void(0)"> Add Your Organization Name</a>';
                            }else{
                            echo $organization_name; 
                            } ?></span ></div>
                          </div>
                          
                          
                          <div id="gradeFull" class="tr">
                            <div class="td1 dsiplInlineBlock"><span >Education Grade :</span></div>
                            <div id="addGrade" class="dsiplInlineBlock"><span ><?php
                             if($education_grade ==null){
                            echo '<a href="javascript:void(0)"> Add Your Education Grade</a>';
                            }else{
                            echo $education_grade; 
                            } ?></span></div>
                          </div>
                          
                          
                          
                          <div id="timeperiodFull"  class="tr">
                           <div class="td1 dsiplInlineBlock"> <span >Time Period </span></div>
                           <div  ></div>
                          </div>
                          
                          
                          
                       
                             <div id="fromFull" class="tr">
                            <div class="td1 dsiplInlineBlock"><span >From :</span></div>
                            <div id="addFrom" class="dsiplInlineBlock"><span ><?php
                            if($education_year_from ==null){
                            echo '<a href="javascript:void(0)"> Add Starting Year</a>';
                            }else{
                            echo $education_year_from; 
                            } ?></span></div>
                          </div>
                          
                          
                          
                            <div id="toFull" class="tr">
                            <div class="td1 dsiplInlineBlock"><span >To :</span></div>
                           <div id="addTo" class="dsiplInlineBlock"><span ><?php 
                            if($education_year_to ==null){
                            echo '<a href="javascript:void(0)"> Add Passing Year</a>';
                            }else{
                            echo $education_year_to; 
                            } ?></span></div>
                          </div>
                          
                          <!--Education Edit Form-->
                          <div id="educationTR" class="hiddenTR">
                            <form id="educationForm"  name="educationForm" >
                   <input id="organization_name" name="organization_name" type="text" class="form-control dsiplInlineBlock" placeholder="Organization Name" aria-describedby="sizing-addon3">
                   <select name="education_grade" id="education_grade" class="form-control" class="form-control col-xs- widthSelect40 dsiplInlineBlock">
                  <option value="0" selected="selected" >Select Education Grade:</option>
                  <?php 
                  $lookupResult = $lookupObject->getLookupValue("Education Grade");
                  while($rowLookup = mysqli_fetch_assoc($lookupResult))
                  {
                  echo '<option value='.$rowLookup['lookup_key'].'>'.$rowLookup['lookup_value'].'</option>';
                  }
                  ?>
                </select> 
                            <div class="form-group">
            <label for="TimePireod">Time Period :</label>
            
            <select name="starting_year"  id="starting_year"  class="form-control col-xs- widthSelect40 dsiplInlineBlock">
            <option value="0" selected="selected">From:</option>
            <?php 
            $current_year = date("Y");
            $start_year = $current_year + 1;
            $end_year = $current_year - 25;
            for ($i=$start_year;$i>=$end_year;$i--)
            { 
                echo "<option value=".$i.">".$i."</option>";     
                } 
            ?>
            </select>
            <select name="ps_year"   id="ps_year" class="form-control col-xs- widthSelect40 dsiplInlineBlock">
            <option value="0" selected="selected">To:</option>
            <?php 
            $start_year = $current_year + 10;
            $end_year = $current_year - 25;
            for ($i=$start_year;$i>=$end_year;$i--)
            { 
                echo "<option value=".$i.">".$i."</option>";     
                } 
            ?>
            </select>			
            
                            <div class="form-group">
                    <label for="country" class="td1 dsiplInlineBlock">Country:</label>        
            <select id="countryedu" onChange="load_options1(this.value,'state');" name="country" class="form-control col-xs- widthSelect40 dsiplInlineBlock validate[required]" >
                        <option value=" ">Select country</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="state" class="td1 dsiplInlineBlock">State:</label>
                    
                      <select id="stateedu" onChange="load_options1(this.value,'city');" name="state" class="form-control col-xs- widthSelect40 dsiplInlineBlock validate[required]">
                        <option  value="">Select state</option>
                      </select>
            
                    </div>
                    
                    <div class="form-group">
                    <label for="city" class="td1 dsiplInlineBlock">City:</label>        
                    <select id="cityedu" name="city" class="form-control col-xs- widthSelect40 dsiplInlineBlock validate[required]">
                        <option value="">Select City</option>
                    </select>
                    </div>
            
                    <button id="educationSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="cancelEducationButton" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                          
                          
                          
                         
                        </div><!--tbody -->
                      </div><!--table -->
                     
                    </div>
                  </div>
                </div>
                     <div class="panel-footer">
                            <a data-original-title="Add New Education" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
                            <span class="pull-right">
                                <a id="editEducationButton" href="javascript:void(0)" data-original-title="Edit Education History" data-toggle="tooltip" type="button" 
                                class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                                <a id="cancelEducationButton" data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                            </span>
                        </div>
                
              </div>
            </div>
            
            
            
          </div><!--end of row column-->
    
    </div><!--end column_left div-->
    <div class="column_right" >
    </div>
    
    </div><!--end mainbody div-->
    <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
</div><!--end wrapper div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>