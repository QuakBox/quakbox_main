<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$memberUsername=$_GET['username'];
	$_SESSION['memberUsername'] = $memberUsername;
	$objMember = new member1();
	$lookupObject = new lookup();
	$member_id = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));
	$activeID =  $lookupObject->getLookupKey("MEMBER STATUS", "ACTIVE");
	$albumTypeID =  $lookupObject->getLookupKey("WALL TYPE", "PHOTO GALLERY");
	if(empty($albumTypeID ))
	{
		$albumTypeID = 0;
	}
	$memberResult=$objMember->getMemberByUsernameandStatus($memberUsername,$activeID);
	$countOfMemberResult=count($memberResult);
	$memberID=0;
	$encryptedMemberID=0;
	$memberProfilePic='';
	$memberDisplayName='';
	$memberMenuResult='';	
	$countOfBlockedResult=0;
	$countOfFriendsRequestStatus=0;
	$countOffriends=0;
	
	$privacyProfileVisibility=0;
	$privacyPhoto=0;
	$privacyFriends=0;
	
	
	foreach($memberResult as $valueMemberResult){
		$memberID=$valueMemberResult['member_id'];
		$memberUsername=$valueMemberResult['username'];			
	}
	if($countOfMemberResult>0){
		//$memberProfilePic=$objMember->select_member_meta_value($memberID,'current_profile_image');
		$encryptedMemberID=$QbSecurity->QB_AlphaID($memberID);
		/*if($memberProfilePic){			
				$memberProfilePic=SITE_URL.'/'.$memberProfilePic;	
		}
		else{
			$memberProfilePic=SITE_URL.'/images/default.png';
		}*/
		$blockedResult=$objMember->get_member_blocked_status($member_id,$memberID);
		$countOfBlockedResult=count($blockedResult);
		//$menuObjProfile=new memberProfileMenu();
		$objMisc = new misc();
		//$memberMenuResult=$menuObjProfile->getMenu($memberID,$memberUsername);
		$checkFriendsrequestTime=$objMisc->getCountOfFriendsRequestStatus($member_id,$memberID);
		foreach($checkFriendsrequestTime as $valuecheckFriendsrequestTime){
			$countOfFriendsRequestStatus=$valuecheckFriendsrequestTime['count'];
		}
		$checkPrivacyOfMember=$objMisc->checkPrivacyOfMember($memberID);
		foreach($checkPrivacyOfMember as $valuecheckPrivacyOfMember){
			$privacyProfileVisibility=$valuecheckPrivacyOfMember['profile'];
			$privacyPhoto=$valuecheckPrivacyOfMember['photo'];
			$privacyFriends=$valuecheckPrivacyOfMember['friends'];
		}
		//$checkPrivacyOfMember=$objMisc->getFriendsListCount($memberID);
		//foreach($checkPrivacyOfMember as $valuecheckPrivacyOfMember){
		//	$countOffriends=
		//}
		//$checkPrivacyOfMember=$objMisc->getFriendsRequestStatus($logged_in_member_id_member_profile,$memberID);
		//$groupMembers=$menuObjGroup->getGroupMembers($groupID,6);
		//$countryPeoples=$menuObjCountry->getCountryPeoples($countryCode,$countryID,$countryTitle);
	}
	if($member_id == $memberID){
		$countOfBlockedResult=0;
		$countOfFriendsRequestStatus=1;
	}	
	
?>
<style>
.thumb {
    margin-bottom: 30px;
}
.heightOfThumbnail{
height : 180px;
}
</style>
<div class="insideWrapper container"> 
<div class="row">
<?php if($countOfMemberResult>0){?>
	<?php if($countOfBlockedResult==0){?>
		<?php if($countOfFriendsRequestStatus!=0){ ?>  	   
		

    <?php 

	if($member_id != $memberID)

	{

	?>

     <input type="button" class="button" value="Profile" 

    onclick="window.open('<?php echo $base_url.$memberUsername;?>','_self');" /> 

    <?php } ?>


<div class="col-lg-12">
                <h2 class="page-header"><?php echo ucfirst($memberUsername);?> <?php echo $lang['Photos'];?></h2>
</div>




<?php 



if($member_id == $memberID)

{

?>

<div class="col-lg-3 col-md-4 col-xs-6 thumb">
                <a id="createAlbum" name="createAlbum" class="thumbnail heightOfThumbnail" href="#"  data-toggle="modal" data-target="#albumCreate">
                    <img class="img-responsive" src="<?php echo $base_url;?>images/uploadAlbum.png" alt="">
                </a>
</div>
<div class="modal fade" id="albumCreate" tabindex="-1" role="dialog" aria-labelledby="createAlbum" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <form id="albumCreateForm" name="albumCreateForm" role="form" action="<?php echo $base_url;?>action/create_photo-exec.php" method="POST" enctype="multipart/form-data">
			            <div class="modal-header">
			                <h3 class="modal-title">Create Album</h3>
			            </div>
			            <div class="modal-body">
				            <div id="errbox" name="errbox" class="alert alert-danger alert-dismissible" style="display:none;" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					    </div>
				            <div class="form-group">
					 	<label for="album"><?php echo $lang['Enter Album Name'];?></label>
						<input value="" name="album" type="text" class="form-control" id="album" placeholder="<?php echo $lang['Type Your Album Name here'];?>.." required="required" autocomplete="off" >
					    </div>
					    <div class="form-group">
					 	<input class="btn btn-primary" id="myfiles" type="file" name="myfiles[]" multiple required="required"/>
					    </div>
			            <table id="uploadedfiles" style="display:none;">
			                <tr><th>Image</th><th>Name</th><th>Size</th><th>Actions</th></tr>
			            </table>
				    </div>
				    <div class="modal-footer">
				    	<input type="submit" value="<?php echo $lang['Upload'];?>"class="btn btn-success"/>
			            </div>
			            </form>
			        </div>
			    </div>
</div>



<?php

}

	$da= "Select * from user_album where album_user_id=".$memberID." ";
//echo $da;
	$result = mysqli_query($con, $da) or die(mysqli_error($con));

	if(mysqli_num_rows($result) > 0)

	{

	while ($row = mysqli_fetch_array($result) )

	{ 

	  $ia = "Select * from upload_data where album_id=".$row["album_id"]." and user_code=".$memberID." AND share !=1 order by date_created";

	  $result1 = mysqli_query($con, $ia) or die(mysqli_error($con));

	  $count = mysqli_num_rows($result1);

	  $row1 = mysqli_fetch_array($result1);

	  $dir123 = $base_url.$row1['FILE_NAME'];

	  echo '<div class="col-lg-3 col-md-4 col-xs-6 thumb">';
                echo '<a class="thumbnail heightOfThumbnail" href="'.$base_url.'photo_gall/myphotogall.php?back_page=photos.php&album_id='.$row["album_id"].'">';
                    echo '<img class="img-responsive" style="max-height: 170px;" src="'.$dir123.'" alt="">';
                echo '</a>';
                echo '<div class="caption">';
		         echo '<h3>'.$row['album_name'].'</h3>';
		         echo '<p>'.$count.$lang['Photos'].'</p>';
		        if($member_id == $memberID)
		        {
		        	if($albumTypeID == $row['type'] || $count==0)
		        	{
		   			echo '<p><a  href="'.$base_url.'photo_gall/myphotogall.php?back_page=photos.php&album_id='.$row["album_id"].'"><button type="text" class="btn btn-primary editalbum" id="edit'.$row["album_id"].'" name="edit'.$row["album_id"].'">Edit</button></a>';
					echo '<button type="text" class="btn btn-danger deletealbum" id="'.$row["album_id"].'" name="delete'.$row["album_id"].'">Delete</button></p>';
				}
		        }
		echo '</div>';
          echo '</div>';

	}

	}

	else

	{

?>

<div class="community-empty-list"><?php echo $lang['No Photos'];?></div>

 <?php } ?>


    





	  	  
		<?php } ?>
	<?php }
	      else
	      { 
		print '<div class="col-lg-12" style="font-size:30px;padding:10px;"> <span style="margin-left:10px;">You are Blocked by this user</span> </div>';
	      }
      }
      else{ 
print '<div class="col-lg-12" style="font-size:30px;padding:10px;"> <i class="fa fa-search"></i> <span style="margin-left:10px;">Sorry we don\'t have any active users..</span> </div>';
      }
  	
  	
  	?>
</div>
</div>
<script type="text/javascript">
            $(document).ready(function() {
                var storedFiles = [];      
                $('#myfiles').on('change', function() {
                    $('#messages').html('');
                    var myfiles = document.getElementById('myfiles');
                    var files = myfiles.files;
                    var i=0;
                    for (i = 0; i<files.length; i++) {
                        var readImg = new FileReader();
                        var file=files[i];
                        if(file.type.match('image.*')){
                            storedFiles.push(file);
                            readImg.onload = (function(file) {
                                return function(e) {
                                    $('#uploadedfiles').show();
                                    $('#uploadedfiles').append('<tr class="imageinfo"><td><img style="max-width:70px;max-height:70px;" src="'+e.target.result+'"/></td><td>'+file.name+'</td><td>'+Math.round((file.size/1024))+'KB</td><td><a href="" class="btn btn-default lnkcancelimage" file="'+file.name+'" title="Remove">Remove</a></td></tr>');
                                };
                            })(file);
                            readImg.readAsDataURL(file);
                        }else{
                             $(this).closest('form').find("input[type=file],input[type=text]").val("");
                             $('#errbox').show();
                             $('#errbox').append('<strong>Warning!</strong> The file '+file.name+' is not an image');
                        }
                    }
                });

                $('#uploadedfiles').on('click','a.lnkcancelimage',function(){
                    $(this).parent().parent().html('');
                    var file=$(this).attr('file');
                    for(var i=0;i<storedFiles.length;i++) {
                        if(storedFiles[i].name == file) {
                            storedFiles.splice(i,1);
                            break;
                        }
                    }
                    return false;
                });

                $('#lnkupload').click(function(){
               
                    var data = new FormData();
                    var i=0;
                    for(i=0; i<storedFiles.length; i++) {
                        data.append('files'+i, storedFiles[i]); 
                    }
		    
                    if(i>0){
                        $.ajax({
                            url: 'loadddded.php',
                            type: 'POST',
                            contentType: false,
                            data: data,
                            processData: false,
                            cache: false
                        }).done(function(msg) {
                            storedFiles = [];
                            if(msg){
                                alert(msg);
                            }else{
                                $('#messages').html('Images uploaded successfully');
                            }
                        }).fail(function() {
                            alert('error');
                        });
                    }
                    return false;
                });
                
                $('#albumCreateForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            album: {
                validators: {
                    notEmpty: {
                        message: 'This feild is required'
                    }
                }
            },
            myfiles: {
                validators: {
                    notEmpty: {
                        message: 'Please Select the Files'
                    }
                }
            }
        }
    });

            });
        </script>
		 <script src="https://www.google.com/jsapi"></script>
    <script>
        google.load("jquery", "1.7.1");
    </script>
		<script src="js/modernizr.custom.js"></script>
		<script src="../js/photos.js"></script>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>