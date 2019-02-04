<?php
// disable warnings
if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE); 

if ($_POST['action'] == 'get_info' && (int)$_POST['id'] > 0) {

    require_once('classes/CMySQL.php'); // include service classes to work with database and comments
    require_once('classes/CMyComments.php');

    // get photo info
    $iPid = (int)$_POST['id'];
    $alb= $_REQUEST['name'];
    $aImageInfo = $GLOBALS['MySQL']->getRow("SELECT * FROM `upload_data` WHERE album_id='{$alb}' and `id` = '{$iPid}'");

    // prepare last 10 comments
    $sCommentsBlock = $GLOBALS['MyComments']->getComments($iPid);

    $aItems = $GLOBALS['MySQL']->getAll("SELECT * FROM `upload_data` WHERE album_id='{$alb}' ORDER by `id` ASC"); // get photos info

    // Prev & Next navigation
    $sNext = $sPrev = '';
    $iPrev = (int)$GLOBALS['MySQL']->getOne("SELECT `id` FROM `upload_data` WHERE album_id='{$alb}' and `id` < '{$iPid}' ORDER BY `id` DESC LIMIT 1");
    $iNext = (int)$GLOBALS['MySQL']->getOne("SELECT `id` FROM `upload_data` WHERE album_id='{$alb}' and `id` > '{$iPid}' ORDER BY `id` ASC LIMIT 1");
    $sPrevBtn = ($iPrev) ? '<div class="preview_prev" onclick="getPhotoPreviewAjx(\''.$iPrev.'\',\''.$alb.'\')"></div>' : '';
    $sNextBtn = ($iNext) ? '<div class="preview_next" onclick="getPhotoPreviewAjx(\''.$iNext.'\',\''.$alb.'\')"></div>' : '';

    require_once('classes/Services_JSON.php');
    $oJson = new Services_JSON();
    header('Content-Type:text/javascript');
    echo $oJson->encode(array(
        'data1' => '<img width="600" height="525"  class="fileUnitSpacer" src="uploadedimage/'. $aImageInfo['FILE_NAME'] .'">' . $sPrevBtn . $sNextBtn,
        'data2' => $sCommentsBlock,
    ));
    exit;
}