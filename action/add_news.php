<?php
/**
 * @package    action
 * @subpackage
 * @author     Vishnu
 * Created date  02/05/2015
 * Updated date  03/13/2015
 * Updated by    Vishnu S
 **/

ob_start();
session_start();
$member_id = $_POST['member_id'];
include('../config.php');
include('../qb_classes/qb_misc.php');


$file = $_FILES['video']['tmp_name'];
$image = $_FILES['image']['tmp_name'];
$country_id = $_POST['country_id'];
//$country_id	 = 	f($country_id, 'strip');
//$country_id	 = 	f($country_id, 'escapeAll');
//$country_id   = mysqli_real_escape_string($con, $country_id);

$title = mysqli_real_escape_string($con, $_POST['title']);
$title = f($title, 'escapeAll');
$title = mysqli_real_escape_string($con, $title);

$description = mysqli_real_escape_string($con, $_POST['description']);
$description = f($description, 'escapeAll');
$description = mysqli_real_escape_string($con, $description);

$category = mysqli_real_escape_string($con, $_POST['category']);
$category = f($category, 'strip');
$category = f($category, 'escapeAll');
$category = mysqli_real_escape_string($con, $category);

$ip = $_SERVER['REMOTE_ADDR'];

$gquery = "SELECT country_title,code FROM geo_country WHERE country_id = '$country_id'";
$gsql = mysqli_query($con, $gquery);
$gres = mysqli_fetch_array($gsql);
$country = mysqli_real_escape_string($con, $gres['country_title']);
$country_code = mysqli_real_escape_string($con, $gres['code']);
function friendlyURL($string)
{
    $cyr = [
        'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
        'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
        'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
        'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
    ];
    $lat = [
        'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
        'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
        'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
        'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
    ];
    $string = str_replace($cyr, $lat, $string);

    $string = preg_replace_callback("`\[.*\]`U", function ($matches) {
        return '';
    }, $string);
    $string = preg_replace_callback('`&(amp;)?#?[a-z0-9]+;`i', function ($matches) {
        return '-';
    }, $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace_callback("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", function ($matches) {
        return $matches[1];
    }, $string);
    $string = preg_replace_callback(array("`[^a-z0-9]`i", "`[-]+`"), function ($matches) {
        return '-';
    }, $string);
    return strtolower(trim($string, '-'));
}

$myFriendlyURL = friendlyURL($title);
echo $myFriendlyURL;


$file_size = $_FILES['image']['size'];
$video_size = $_FILES['video']['size'];

if ($file_size == NULL) {
    echo "not set";

} else {
    $video = addslashes(file_get_contents($_FILES['video']['tmp_name']));
    $video_name = addslashes($_FILES['video']['name']);

    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $image_name = addslashes($_FILES['image']['name']);
    $location = '';

    if ($video_size != NULL) {
        echo "not set";


        move_uploaded_file($_FILES["video"]["tmp_name"], "../uploadedvideo/" . $video_name);
        $location = "uploadedvideo/" . $video_name;
    }
    move_uploaded_file($_FILES["image"]["tmp_name"], "../uploadedimage/" . $image_name);
    $location1 = "uploadedimage/" . $image_name;

    //exec("ffmpeg -i video.mp4 -s 320x240 video2.flv");

    echo $sql = "insert into news(image_url,video_url,title,description,member_id,country_id,date_created,ip,category_id,url,status) 
			values('$location1','$location','$title','$description','$member_id','$country_id',now(),'$ip','$category','$myFriendlyURL',1)";

    mysqli_query($con, $sql) or die(mysqli_error($con));

//------------------------------------------------------------------------------------------------
//adding notifications when someone add news alerts on a country wall Mushira & Yasser 06-02-2016
//------------------------------------------------------------------------------------------------
    require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_send_email.php');
    $misc = new misc();
    $member = new Member();
    $email = new SendEmail();


    $country_members = $misc->get_country_fans_ids($country_id, $member_id);

    foreach ($country_members as $row) {
        $country_mem_id = $row['member_id'];
        echo $country_mem_id . " ";

        $newsql = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, title, href, is_unread, date_created) 
	
	VALUES($member_id,$country_mem_id,30,'posted a news alert on " . $country . "','" . "country/" . $country_code . "',0," . strtotime(date("Y-m-d H:i:s")) . ")";
        mysqli_query($con, $newsql) or die(mysqli_error($con));

        /////////////////// Send Notification Message
        $sender_name = $member->get_member_name($member_id);
        $message_body = "<b>" . $title . "</b>" . "<br/>" . $description;

        $subject = " posted a news alert on $country ";

        ////////send_notification_email($sender_id,$receiver_id,$subject,$message_body,$media)
        $email->send_notification_email($member_id, $country_mem_id, $subject, $message_body, $media);
        ///// End Send Notification Message


    }

}


header("location: " . $base_url . "country/" . $country_code . "");
exit();

?> 