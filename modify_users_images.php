<?php
require_once 'qb_classes/connection/qb_database.php';

$db_Obj = new database();

$sql = "
SELECT `member_id`, `meta_value`
FROM `member_meta`
WHERE `meta_key` = 'current_profile_image'";
$results = $db_Obj->execQueryWithFetchAll($sql);

foreach( $results as $row ) 
{
    $member_id = $row['member_id'];
    $profile_img = $row['meta_value'];
 
    if($profile_img !='images/ImageGenderMale.png' && $profile_img !='images/ImageGenderFemale.png' && $profile_img !='images/defaultProfile.png' && $profile_img !='images/default.png')
    {
        $ext = pathinfo($profile_img, PATHINFO_EXTENSION);
        $newFilename = 'profile_photo/'.$member_id . '.' . $ext;

        //1- Rename the file
        rename($profile_img, $newFilename);

        //2- update the database
        $sql2 = "UPDATE  `member_meta` SET `meta_value` = '$newFilename' WHERE `meta_key` = 'current_profile_image' AND `member_id` =$member_id ;";
        mysqli_query($db_Obj->con, $sql2);
        


    }    
    
}





