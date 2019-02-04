<?php //Start session
ob_start();
session_start();

//Include database connection details
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/common.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_lookup.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');
$memberObject = new member1();
$lookupObject = new lookup();

$member_id = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));
$usernameRes = $memberObject->select_member_byID($member_id);
foreach ($usernameRes as $Result) {
    $username = $Result['username'];
}

if (isset($_REQUEST['uploadImage'])) {
    if ($_FILES['file']['name']) {
        $uploaddir = 'profile_photo/';
        $file = $uploaddir . mysqli_real_escape_string($con, $_FILES['file']['name']);

        $file = $_FILES['file']['tmp_name'];
        $image = addslashes(file_get_contents($_FILES['file']['tmp_name']));
        $image_name = addslashes($_FILES['file']['name']);
        $image_size = getimagesize($_FILES['file']['tmp_name']);
        if ($image_size == FALSE) {
            echo "That's not an image!";
        } else {

	    $dest_location = $_FILES["file"]["tmp_name"];
            $exif = @exif_read_data($dest_location);

            if (!empty($exif) && isset($exif['Orientation']))
            {
                switch ($exif['Orientation'])
                {
                    case 3:
                        // Need to rotate 180 deg
                        $image = new Imagick();
                        $image->pingImage($dest_location);
                        $image->readImage($dest_location);
                        $image->rotateimage(new ImagickPixel('#00000000'), 180);
			$image->stripImage();
                        $image->writeImage($dest_location);
                        break;

                    case 6:
                        // Need to rotate 90 deg clockwise
                        $image = new Imagick();
                        $image->pingImage($dest_location);
                        $image->readImage($dest_location);
                        $image->rotateimage(new ImagickPixel('#00000000'), 90);
			$image->stripImage();
                        $image->writeImage($dest_location);
                        break;

                    case 8:
                        // Need to rotate 90 deg counter clockwise
                        $image = new Imagick();
                        $image->pingImage($dest_location);
                        $image->readImage($dest_location);
                        $image->rotateimage(new ImagickPixel('#00000000'), 270);
			$image->stripImage();
                        $image->writeImage($dest_location);
                        break;
                }
            }

            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $dest_location = "../profile_photo/" . $member_id . '.' . $ext;
            move_uploaded_file($_FILES["file"]["tmp_name"], $dest_location);

            list($width, $height) = @getimagesize($dest_location);
            if($width > 1024) {
                $img = new Imagick($dest_location);
                $img->adaptiveResizeImage(1024, 1024);
                $img->writeImage($dest_location);
                unset($img);

                list($width, $height) = @getimagesize($dest_location);
            }

            $location = mysqli_real_escape_string($con, "profile_photo/" . $member_id . '.' . $ext);

            $source_file_location = "../profile_photo/" . $member_id . '.' . $ext;
            $uploaded_data_location = mysqli_real_escape_string($con, "../uploads/" . $member_id . '_' . date('d-m-y-h-i') . '.' . $ext);

            //Copy the uploaded file to the from profle_photos to uploaded data
            $uploaded_data_location_dir = dirname($uploaded_data_location);

            if(!file_exists($uploaded_data_location_dir)) {
                mkdir($uploaded_data_location_dir, 0777, true);
            }

            chmod($source_file_location, 0777);
            copy($source_file_location, $uploaded_data_location);
            $lookupWallID = $lookupObject->getLookupKey('Wall Type', 'My Wall');

            mysqli_query($con, "update member_meta set meta_value ='" . $location . "' where member_id='" . $member_id . "' and meta_key='current_profile_image' ");
            $time = time();
            $ip = $_SERVER['REMOTE_ADDR'];

            $sql = "INSERT INTO message(messages,member_id,date_created,ip,type,country_flag) VALUES ('$uploaded_data_location','$member_id','$time','$ip',1,'')";

            mysqli_query($con, $sql) or die(mysqli_error($con));
            $message_id = mysqli_insert_id($con);

            $aquery = mysqli_query($con, "SELECT album_id FROM user_album WHERE album_name ='$username' AND album_user_id='$member_id'");
            $asql = mysqli_fetch_array($aquery);
            $album_id = $asql['album_id'];

            if ($album_id == '') {
                $insertAlbumDetails = "INSERT INTO user_album (album_user_id,album_name,type) VALUES('$member_id','$username','$lookupWallID');";

                mysqli_query($con, $insertAlbumDetails) or die(mysqli_error($con));
                $album_id = mysqli_insert_id($con);
            }

            $uquery = "INSERT into upload_data (`USER_CODE`,`FILE_NAME`,`album_id`,`date_created`,msg_id) VALUES('$member_id','$uploaded_data_location','$album_id','" . strtotime(date("Y-m-d H:i:s")) . "','$message_id'); ";
            mysqli_query($con, $uquery) or die(mysqli_error($con));

            $umsql = "Update message set msg_album_id=" . $album_id . " where messages_id=" . $message_id . "";
            mysqli_query($con, $umsql);
        }
    }
    header("location: " . $base_url . "i/" . $username.'?refresh='.time());
    exit();
}
