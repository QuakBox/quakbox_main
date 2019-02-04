<?php
// disable warnings
if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE); 
//echo (int)$_POST['id'] ;
if ((int)$_POST['id'] > 0) {

    //require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/connection/qb_database.php'); // include service classes to work with database and comments
    require_once($_SERVER['DOCUMENT_ROOT'].'/photo_gall/classes/MyComments.php');

    // get photo info
    $photo_id= (int)$_POST['id'];
    $dbconn =new database();
    $con= $dbconn->con;
  
  
  //get the data from upload_data table
  
   $query= "select * from upload_data where upload_data_id =$photo_id order by upload_data_id DESC";  
   $aImageInfo_q =mysqli_query($con, $query) or die(mysqli_error($con));
   $aImageInfo =mysqli_fetch_array($aImageInfo_q);
   
   // prepare last 10 comments
    $MyComments= new MyComments();
    $sCommentsBlock =$MyComments->getComments($aImageInfo['msg_id']);

    // Prev & Next navigation
    $sNext = $sPrev = '';
   /*if(isset($_REQUEST['country_id']))
   {
     echo 'country_id='.$_REQUEST['country_id'];
   }*/
   
    $iPrev = (int) $dbconn->getOne("select Q.upload_data_id from (SELECT MIN( gp.upload_data_id ) upload_data_id, MIN( gp.date_created ) date_created, gp.FILE_NAME, gp.album_id, m.member_id, m.username, gp.caption, gp.description FROM upload_data gp LEFT JOIN member m ON gp.USER_CODE = m.member_id WHERE gp.album_id ='{$aImageInfo['album_id']}' GROUP BY gp.FILE_NAME, gp.album_id, m.member_id, m.username, gp.caption, gp.description ORDER BY gp.upload_data_id DESC) Q Where  Q.upload_data_id > '{$photo_id}'  ORDER BY Q.upload_data_id DESC LIMIT 1");
    $iNext = (int) $dbconn->getOne("select Q.upload_data_id from (SELECT MIN( gp.upload_data_id ) upload_data_id, MIN( gp.date_created ) date_created, gp.FILE_NAME, gp.album_id, m.member_id, m.username,    gp.caption, gp.description FROM upload_data gp LEFT JOIN member m ON gp.USER_CODE = m.member_id WHERE gp.album_id ='{$aImageInfo['album_id']}' GROUP BY gp.FILE_NAME, gp.album_id, m.member_id, m.username, gp.caption, gp.description ORDER BY gp.upload_data_id DESC) Q Where  Q.upload_data_id < '{$photo_id}' ORDER BY Q.upload_data_id DESC LIMIT 1");
   // echo 'prev='.$iPrev.'next='.$iNext;
    $sPrevBtn = ($iPrev) ? '<div class="preview_prev" onclick="getPhotoPreviewAjx(\''.$iPrev.'\')"><img src="img/prev.png" alt="prev"  /></div>' : '';
    $sNextBtn = ($iNext) ? '<div class="preview_next" onclick="getPhotoPreviewAjx(\''.$iNext.'\')"><img src="img/next.png" alt="next" /></div>' : '';
    
  
    require_once($_SERVER['DOCUMENT_ROOT'].'/photo_gall/classes/Services_JSON.php');
    $oJson = new Services_JSON();
    header('Content-Type:text/javascript');

    echo $oJson->encode(array(
    
        'data1' => '<img class="fileUnitSp acer" style="width:90%; height:auto;" src="../'. $aImageInfo['FILE_NAME'].'"/>' . $sPrevBtn . $sNextBtn,
        'data2' => $sCommentsBlock,
    ));
    exit;
   
}