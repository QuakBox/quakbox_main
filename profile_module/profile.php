<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
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
        $displayName = $res['username'];
        $current_profile_image = $memberObject->select_member_meta_value($id,"current_profile_image");
        $current_profile_image = $base_url.$current_profile_image;
        
        $email_id= $res['email'];
//		$email_signature = $memberObject->select_member_meta_value($id, "email_signature");
        $mobile_no= $memberObject->select_member_meta_value($id,"phone_mobile");
        $landline_no= $memberObject->select_member_meta_value($id,"phone_landline");
        $address=$memberObject->select_member_meta_value($id,"address");
        $country=$memberObject-> select_member_meta_value_for_GeoCountry($id);
        $countryid=$memberObject->select_member_meta_value($id,"country");
        $state=$memberObject-> select_member_meta_value_for_GeoState($id);
        $stateid=$memberObject->select_member_meta_value($id,"state");
        $city=$memberObject-> select_member_meta_value_for_GeoCity($id);
        $cityid=$memberObject->select_member_meta_value($id,"city");
        $zip=$memberObject->select_member_meta_value($id,"zip");
        $curcity=$memberObject->select_member_meta_value($id,"current_city");
		$homeCountry=$memberObject->select_member_meta_value($id,"home_country");
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
        
        
        // for edit profile lookups
        $profileLookupKeyArray = array(
        			"GENDER"
        		, "Relationship Status"
        		, "Languages Known"
        		, "Political View"
				, "Education Grade"
        		
        		
        );
        $printLookupArray = array();

        foreach( $profileLookupKeyArray as $key ){
        	$lookupResult = $lookupObject->getLookupValue($key);
        	$printJsonArray = array();
        	$i = 0;
        	while($rowLookup = mysqli_fetch_assoc($lookupResult))
        	{
        		$printJsonArray[$i]['value'] = $rowLookup['lookup_key'];
        		$printJsonArray[$i]['text']  = utf8_encode( $rowLookup['lookup_value'] );
        		$i++;
        	}
        	$printLookupArray[$key] = json_encode( $printJsonArray, JSON_UNESCAPED_UNICODE );
        }
		
		/*********** Organization name ***************/
        $eduSql ="SELECT * FROM qb_country_education_record";
        $result = mysqli_query($con, $eduSql);
		
		$j = 0;
		$printJsonArray2 = array();
        while($organization = mysqli_fetch_array($result)) {
        	if($organization['organization_name'] != '') {
        		$printJsonArray2[$j]['value'] = $organization['qb_cer_id'];
        		$printJsonArray2[$j]['text'] = $organization['organization_name'];
                $j++;
        	}
        }
		$printLookupArray['organization_name'] = json_encode( $printJsonArray2, JSON_UNESCAPED_UNICODE );
		
		/*********** Country ***************/
        $countrySql ="SELECT country_id, country_title FROM geo_country";
        $rsCountry = mysqli_query($con, $countrySql);
		
		$j = 0;
		$printJsonArray3 = array();
        while($arCountry = mysqli_fetch_array($rsCountry)) {
			$printJsonArray3[$j]['value'] = $arCountry['country_id'];
			$printJsonArray3[$j]['text'] = $arCountry['country_title'];
			$j++;
        }
		$printLookupArray['Country'] = json_encode( $printJsonArray3, JSON_UNESCAPED_UNICODE );
		
		/*********** State ***************/
        $stateSql ="SELECT state_id, state_title FROM geo_state WHERE country_id = $countryid";
        $rsState = mysqli_query($con, $stateSql);
		
		$j = 0;
		$printJsonArray4 = array();
        while($arState = mysqli_fetch_array($rsState)) {
			$printJsonArray4[$j]['value'] = $arState['state_id'];
			$printJsonArray4[$j]['text'] = $arState['state_title'];
			$j++;
        }
		$printLookupArray['State'] = json_encode( $printJsonArray4, JSON_UNESCAPED_UNICODE );
		
		/*********** City ***************/
        $citySql ="SELECT city_id, city_title FROM geo_city WHERE state_id = $stateid AND country_id = $countryid";
        $rsCity = mysqli_query($con, $citySql);
		
		$j = 0;
		$printJsonArray5 = array();
        while($arCity = mysqli_fetch_array($rsCity)) {
			$printJsonArray5[$j]['value'] = $arCity['city_id'];
			$printJsonArray5[$j]['text'] = $arCity['city_title'];
			$j++;
        }
		$printLookupArray['City'] = json_encode( $printJsonArray5, JSON_UNESCAPED_UNICODE );
         
?>

<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
<link href="/js/poshytip/tip-yellowsimple/tip-yellowsimple.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
<script src="/js/poshytip/jquery.poshytip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>

<script type="text/javascript">

jQuery(function(){
	$('#addhomeCountry').editable({
 			pk: 1,
 			source:'<?php echo $printLookupArray["Country"]; ?>',
            value: '<?php echo $countryid;?>', 
            name:  'home_country',
            url:   window.location.origin+'/action/basic_info-exec.php',  
            title: 'Enter Country',
            validate: function(value) {
                
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		},
                        success: function(response, newValue) {
                
                        }          
	});	
	
 $('#addGender').editable({
			   value: '<?php echo $lookupObject->getKeyByValue($gender);?>',     
			   source: <?php echo $printLookupArray["GENDER"]; ?>,
			   name:  'gender',
			   url:   window.location.origin+'/action/basic_info-exec.php',  
			   title: 'Select Gender',
			   validate: function(value) {
				if($.trim(value) == '') {
					return 'This field is required';
				}
			  }
 });
<?php /*
	$('#addEmailSignature').editable({
			   pk: 1,
			   value: '<?php echo $email_signature ?>',
			   //source: "<?php echo $email_signature ?>",
			   name:  'email_signature',
			   url:   window.location.origin+'/action/basic_info-exec.php',
			   title: 'Add Your Email Signature',
		       validate: function(value) {

			   }
 	});
*/ ?>
 $('#addBday').editable({
                           pk:    1,
						   value: '<?php echo $birthdate; ?>',
                           name:  'birthDay',
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

 		$('#addRela').editable({
                           value: '<?php echo $lookupObject->getKeyByValue($relationship);?>',     
                           source: <?php echo $printLookupArray["Relationship Status"]; ?>,
                           name:  'relationship_status',
                           url:   window.location.origin+'/action/basic_info-exec.php',  
                           title: 'Select Relationship',
                           validate: function(value) {
			    if($.trim(value) == '') {
			        return 'This field is required';
			    }
			  }
		});
 		$('#addLang').editable({
            value: '<?php echo $lookupObject->getKeyByValue($language);?>',  
            source: <?php echo $printLookupArray["Languages Known"]; ?>,  
            name:  'language_known',
            url:   window.location.origin+'/action/basic_info-exec.php',  
            title: 'Select Language',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	
 		$('#addPoli').editable({
            value: '<?php echo $lookupObject->getKeyByValue($political_views);?>',  
            source: <?php echo $printLookupArray["Political View"]; ?>,  
            name:  'political_view',
            url:   window.location.origin+'/action/basic_info-exec.php',  
            title: 'Select Politics',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	
 		$('#addMobi').editable({
            value: '<?php echo $mobile_no;?>', 
            name:  'phone_mobile',
            url:   window.location.origin+'/action/contact_info-exec.php',  
            title: 'Enter Mobile No.',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	
 		$('#addOther').editable({
            value: '<?php echo $landline_no;?>', 
            name:  'phone_landline',
            url:   window.location.origin+'/action/contact_info-exec.php',  
            title: 'Enter Landline No.',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	
 		$('#addCurcity').editable({
 	 		pk: 1,
            value: '<?php echo $curcity;?>', 
            name:  'current_city',
            url:   window.location.origin+'/action/contact_info-exec.php',  
            title: 'Enter Current City',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	
 		$('#addHometown').editable({
 			pk: 1,
            value: '<?php echo $hometown;?>', 
            name:  'home_town',
            url:   window.location.origin+'/action/contact_info-exec.php',  
            title: 'Enter Hometown',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	
 		$('#addWebsite').editable({
 			pk: 1,
            value: '<?php echo $website;?>', 
            name:  'website',
            url:   window.location.origin+'/action/contact_info-exec.php',  
            title: 'Enter Website',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	 
 		$('#addAddr').editable({
 			pk: 1,
            value: '<?php echo $address;?>', 
            name:  'address',
            url:   window.location.origin+'/action/contact_info-exec.php',  
            title: 'Enter Address',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	

 		$('#addCity').editable({
 			pk: 1,
 			source:'<?php echo $printLookupArray["City"]; ?>',
            value: '<?php echo $cityid;?>', 
            name:  'city',
            url:   window.location.origin+'/action/contact_info-exec.php',  
            title: 'Enter City',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	
 		$('#addState').editable({
 			pk: 1,
            value: '<?php echo $stateid;?>',
            source:'<?php echo addslashes($printLookupArray["State"]); ?>',
            name:  'state',
            url:   window.location.origin+'/action/contact_info-exec.php',  
            title: 'Enter State',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	
 		$('#addCountry').editable({
 			pk: 1,
 			source:'<?php echo $printLookupArray["Country"]; ?>',
            value: '<?php echo $countryid;?>', 
            name:  'country',
            url:   window.location.origin+'/action/contact_info-exec.php',  
            title: 'Enter Country',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	
 		$('#addZip').editable({
 			pk: 1,
            value: '<?php echo $zip;?>', 
            name:  'zip',
            url:   window.location.origin+'/action/contact_info-exec.php',  
            title: 'Enter Zip',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	 		

 		$('#addOrganization').editable({
            value: '<?php echo $organization_name;?>',
            source: <?php echo $printLookupArray['organization_name']; ?>,
            name:  'education_organization',
            url:   window.location.origin+'/action/education_info-exec.php',  
            title: 'Select Organization Name',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	 
 		$('#addGrade').editable({
            value: '<?php echo $education_grade;?>',    
            source: <?php echo $printLookupArray["Education Grade"]; ?>,
            name:  'education_grade',
            url:   window.location.origin+'/action/education_info-exec.php',  
            title: 'Enter Education Grade',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	 
 		$('#addFrom').editable({
            value: '<?php echo $education_year_from;?>', 
            name:  'education_year_from',
            url:   window.location.origin+'/action/education_info-exec.php',  
            title: 'Enter Education From',
            validate: function(value) {
 			if($.trim(value) == '') {
     			return 'This field is required';
 			}
		}
	});	 
 		$('#addTo').editable({
            value: '<?php echo $education_year_to;?>', 
            name:  'education_year_to',
            url:   window.location.origin+'/action/education_info-exec.php',  
            title: 'Enter Education To',
            validate: function(value) {
				if($.trim(value) == '') {
					return 'This field is required';
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
                           var regexname = /^[a-zA-Z 0-9_\.]+$/;
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
.editTd, .editTdCell{
display: table-cell;
width: 60%;
}
.editTd a, .editTdCell a{
display: inline-block;
width:100%;
}
.editTd:hover, .editTd1:hover
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
.editTd a, .editTdCell a {
	display: block;
	position: relative;
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
                            <a href="javascript:void(0);" id="addBday" data-type="date" data-placement="bottom" data-pk="1" data-title="Select Date">
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
                           <div class="editTd"> 
                           <a href="javascript:void(0);" class="SettingsListLink pvm phs" data-type="select" data-pk="1" id="addRela">
                           <span ><?php 
                            if($relationship==null){
                            echo 'Add Relationship Status';
                            }else{
                            echo $relationship; 
                            }
                            ?></span>
                            </a>
                            </div>
                          </div>
                          
                          <div id="langFull" class="tr">
                            <div class="td"><span ><?php echo $lang['Languages'].' Known';?> :</span></div>
                            <div class="editTd">
                            <a href="javascript:void(0);" class="SettingsListLink pvm phs" data-type="select" data-pk="1" id="addLang">
                            <span ><?php
                            if($language == null){
                            echo 'Add Languages';
                            }else{
                            echo $language; 
                            } ?></span>
                            </a>
                            </div>
                          </div>
                          
                          <div id="poliFull" class="tr">
                            <div class="td"><span ><?php echo $lang['Political Views'];?> :</span></div>
                            <div class="editTd">
                            <a href="javascript:void(0);" class="SettingsListLink pvm phs" data-type="select" data-pk="1" id="addPoli">
                            <span ><?php
                            if($political_views == null){
                            echo 'Add Political Views';
                            }else{
                            echo $political_views; 
                            } ?></span>
                            </a>
                            </div>
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
                    <?php /*?> <div class="panel-footer">
                            <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
                            <span class="pull-right">
                                <a href="javascript:void(0)" data-original-title="Edit Basic Info" data-toggle="tooltip" type="button" 
                                class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                                <a data-original-title="Remove this Information" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                            </span>
                        </div><?php */?>
                
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
                           <div id="addEmail" class="editTdCell">
                           <span ><?php 
                            if($email_id ==null){
                            echo 'href="javascript:void(0)"> Add Your Email</a>';
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
                            <div class="editTdCell">
                            <a href="javascript:void(0)" data-pk="1" id="addMobi">
                            <span ><?php
                             if($mobile_no ==null){
                            echo ' Add Your Mobile No.';
                            }else{
                            echo $mobile_no; 
                            } ?></span>
                            </a>
                            </div>
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
                           <div class="editTd"> 
							<a  href="javascript:void(0);" class="SettingsListLink pvm phs" data-pk="1" id="addOther">
							<span class="SettingsListItemContent"><?php 
                            if($landline_no ==null){
                            echo 'Add Landline No.';
                            }else{
                            echo $landline_no; 
                            }
                            ?></span>
							</a>
							</div>
                          </div>
                          
                          
                          
                          <div id="curcityFull" class="tr">
                           <div class="td"> <span >Current City :</span></div>
                           <div class="editTd" > 
                           <a href="javascript:void(0)" data-type="text" id="addCurcity">
                           <span ><?php 
                            if($curcity ==null){
                            echo ' Add Your Current City';
                            }else{
                            echo $curcity; 
                            }
                            ?></span>
                            </a>
                            </div>
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
                          <!--home country form start-->
                          
                          <div id="homeCountry" class="tr">
                           <div class="td"> <span >Home Country :</span></div>
                           <div class="editTd"> 
                           
                               <a href="javascript:void(0)" data-type="select" id="addhomeCountry" data-pk="1">
                           <span ><?php 
                            if($homeCountry ==null){
                            echo ' Add Your Home country';
                            }else{
                                 $countrySql ="SELECT country_title FROM geo_country where country_id=".$homeCountry;
                                 $rsCountry = mysqli_query($con, $countrySql);
                                 $result=mysqli_fetch_array($rsCountry);   
                                  echo $result['country_title']; 
                            }
                            ?></span>
                            </a>
                            </div>
                          </div>
                          <div id="homeCountrytr" class="hiddenTR">
                            <form id="homeCountryForm"  name="homeCountryForm" >
                    <input id="homeCountry" name="homeCountry" type="text" class="form-control dsiplInlineBlock" placeholder="Hometown" aria-describedby="sizing-addon3">
                    <button id="hometownSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button id="hometownCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                            </form>
                          </div>
                          
                          <!--End Home Country Form-->
                          
                          <div id="hometownFull" class="tr">
                           <div class="td"> <span >Hometown :</span></div>
                           <div class="editTd"> 
                           <a href="javascript:void(0)" data-type="text" id="addHometown">
                           <span ><?php 
                            if($hometown ==null){
                            echo ' Add Your Hometown';
                            }else{
                            echo $hometown; 
                            }
                            ?></span>
                            </a>
                            </div>
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
                           <div class="editTd"> 
                           <a href="javascript:void(0)" data-type="text" id="addWebsite">
                           <span ><?php 
                            if($website ==null){
                            echo ' Add Your Website';
                            }else{
                            echo $website; 
                            }
                            ?></span>
                            </a>
                            </div>
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
                            <div class="editTdCell">
                                <div class="editTd1">
                                <a href="javascript:void(0)" data-type="text" id="addAddr" data-pk="1">
                                <span ><?php
                                if($address ==null){
                                echo ' Add Address ';
                                }else{
                                echo $address; 
                                } ?></span>
                                </a>
                                </div>
                                <div class="editTd1">
                                <a href="javascript:void(0)" data-type="select" id="addCountry" data-pk="1">
                                <span ><?php
                                if($country ==null){
                                echo ' Add Country ';
                                }else{
                                echo $country; 
                                } ?></span>
                                </a> 
                                </div>
                                <div class="editTd1">
                                <a href="javascript:void(0)" data-type="select" id="addState" data-pk="1">
                                <span ><?php
                                if($state ==null){
                                echo ' Add State ';
                                }else{
                                echo $state; 
                                } ?></span>
                                </a>
                                </div>
                                <div class="editTd1">
                                <a href="javascript:void(0)" data-type="select" id="addCity" data-pk="1">
                                <span ><?php
                                if($city ==null){
                                echo ' Add City';
                                }else{
                                echo $city; 
                                } ?></span>
                                </a>
                                </div>
                                <div class="editTd1"> 
                                <a href="javascript:void(0)" data-type="text" id="addZip" data-pk="1">
                                <span ><?php
                                if($zip ==null){
                                echo ' Add Zip ';
                                }else{
                                echo $zip; 
                                } ?></span>
                                </a>                                                      
                                </div>
                            </div>
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
                               <?php /*?> <a href="javascript:void(0)" data-original-title="Edit Contact Information" data-toggle="tooltip" type="button" 
                                class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a><?php */?>
                                <a data-original-title="Remove this Info" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                            </span>
                        </div>
                
              </div>
            </div>
            
            <!--education history -->
            <?php  
       // $id=$res['member_id'];
        
        
        ?>

		<?php/*
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-7 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-3 toppad" id="editEmailSignature">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Emails Signature</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3 col-lg-3 " align="center"></div>
						<div class=" col-md-9 col-lg-9 ">
							<div class="tablew table-user-information">
								<div>
									<div id="emailSignatureFull" class="tr first-child">
										<div class="td"><span>Email Signature:</span ></div>
										<div class="editTdCell" id="addEmailSignature" data-type="textarea">
                           				<span><?php if(is_null($email_signature)){ echo '<a href="javascript:void(0)"> Add Your Signature</a>'; }else{ echo str_replace("\\n", "<br>", $email_signature); } ?></span></div>
									</div>
									<div id="emailSignatureTR" class="hiddenTR first-child">
										<form id="emailSignatureForm"  name="emailSignatureForm" >
											<textarea id="emailSignature" name="emailSignature" type="text" class="form-control dsiplInlineBlock" placeholder="Email Signature" aria-describedby="sizing-addon3"></textarea>
											<button id="emailSignatureSubmit" type="button" class="btn btn-sm btn-primary" aria-label="Left Align">
												<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
											</button>
											<button id="emailSignatureCancel" type="button" class="btn btn-sm btn-danger" aria-label="Left Align">
												<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
											</button>
										</form>
									</div>
								</div><!--tbody -->
							</div><!--table -->

						</div>
					</div>
				</div>
			</div>
		</div>
		*/ ?>
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
                            <div class="td"><span >Organization Name:</span ></div>
                           <div class="editTd"> 
						   <a href="javascript:void(0)" data-type="select" data-pk="1" id="addOrganization">
                           <span>
						   <?php 
                            if($organization_name ==null){
                            echo ' Add Your Organization Name';
                            }else{
                            echo $organization_name; 
                            } ?></span >
                            </a>
                            </div>
                          </div>
                          
                          
                          <div id="gradeFull" class="tr">
                            <div class="td"><span >Education Grade :</span></div>
                            <div class="editTd">
                            <a href="javascript:void(0)" data-type="select" data-pk="1" id="addGrade">
                            <span ><?php
                             if($education_grade ==null){
                            echo ' Add Your Education Grade';
                            }else{
                            echo $education_grade; 
                            } ?></span>
                            </a>
                            </div>
                          </div>
                          
                          
                          
                          <div id="timeperiodFull"  class="tr">
                           <div class="td"> <span >Time Period </span></div>
                           <div  ></div>
                          </div>
                          
                          
                          
                       
                             <div id="fromFull" class="tr">
                            <div class="td"><span >From :</span></div>
                            <div class="editTd">
                            <a href="javascript:void(0)" data-type="text" data-pk="1" id="addFrom">
                            <span ><?php
                            if($education_year_from ==null){
                            echo ' Add Starting Year';
                            }else{
                            echo $education_year_from; 
                            } ?></span>
                            </a>
                            </div>
                          </div>
                          
                          
                          
                            <div id="toFull" class="tr">
                            <div class="td"><span >To :</span></div>
                           <div class="editTd">
                           <a href="javascript:void(0)" data-type="text" data-pk="1" id="addTo">
                           <span ><?php 
                            if($education_year_to ==null){
                            echo ' Add Passing Year';
                            }else{
                            echo $education_year_to; 
                            } ?></span>
                            </a>
                            </div>
                          </div>
                          
                          <!--Education Edit Form-->
                          <div id="educationTR" class="hiddenTR">
                            <form id="educationForm"  name="educationForm" >
                   <input id="organization_name" name="organization_name" type="text" class="form-control dsiplInlineBlock" placeholder="Organization Name" aria-describedby="sizing-addon3">
                   <select name="education_grade" id="education_grade" class="form-control col-xs- widthSelect40 dsiplInlineBlock">
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
            </div>
            
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
                                <?php /*?><a id="editEducationButton" href="javascript:void(0)" data-original-title="Edit Education History" data-toggle="tooltip" type="button" 
                                class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a><?php */?>
                                <a id="cancelEducationButton" data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                            </span>
                        </div>
                
              </div>
            </div>
            
            
            
          </div><!--end of row column-->
    
    </div><!--end column_left div-->
    <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
</div><!--end wrapper div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/share.php');
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>