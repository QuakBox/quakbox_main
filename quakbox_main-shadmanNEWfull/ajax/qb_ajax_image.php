<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_misc.php');

$loggedin_member_id_for_post = $_SESSION['SESS_MEMBER_ID'];

$path = "../uploads/";

list($width, $height) = @getimagesize($_FILES['image']['tmp_name']);

function getExtension($str)
{
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

$maxFilesize = 1048576; // 2 Mb
$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_FILES['image']['name'];
    $size = $_FILES['image']['size'];
    $time = time();
    if (strlen($name)) {
        $ext = getExtension($name);
        if (in_array($ext, $valid_formats)) {
            $tmp = $_FILES['image']['tmp_name'];
            $file = $tmp;

	    $dest_location = $tmp;
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


            if($width > 1024) {
                $img = new Imagick($file);
                $img->adaptiveResizeImage(1024, 1024);
                $img->writeImage($file);
                unset($img);

                list($width, $height) = @getimagesize($file);
            }

            $actual_image_name = time() . $loggedin_member_id_for_post . "." . $ext;

            $p400x250 = 'p400x250' . $actual_image_name;
            $p400x250_path = $path . 'p400x250' . $actual_image_name;
            $image160x160 = new Imagick($file);
            $image160x160->adaptiveResizeImage($width, $height);
            $image160x160->writeImage($p400x250_path);

            $miscObj = new misc();
            $id = $miscObj->insertUserUploads($p400x250, $loggedin_member_id_for_post);
        ?>

            <style>
                .rotate90 {
                    -webkit-transform: rotate(90deg);
                    -moz-transform: rotate(90deg);
                    -o-transform: rotate(90deg);
                    -ms-transform: rotate(90deg);
                    transform: rotate(90deg);
                }
            </style>

            <script>
                $('#rotate').on('click', function (e) {
                    if ($(".preview").hasClass("rotate90")) {
                        $(".preview").removeClass('rotate90');
                    }
                    else {
                        $(".preview").addClass('rotate90');

                        $(".preview-container").css({
                            "height": "250px"
                        });

                        $(".preview").css({
                            "margin-top": "50px"
                        });


                        $.ajax({
                            type: "POST",
                            url: "<?php echo SITE_URL . '/ajax/rotate_image_ajax.php'?>",
                            data: ({
                                path: '<?php echo json_encode($p400x250_path); ?>'
                            }),
                            cache: false,
                            success: function (data) {
                            },
                            error: function (exception) {
                                alert('Exeption:' + exception);
                            }
                        });
                    }
                    e.preventDefault();
                });


            </script>

            <div id='image_preview_wall'>
                <div>Description:</div>
                <textarea name="description" style="width: 100%;" id="photo_description" placeholder="Description"></textarea>
                <div style="height: 30px; margin-top: 5px;">

                    <span><a style="margin-right: 5px; background-color: #222; border: 1px solid #000; color: #fff; padding: 5px; cursor:pointer;text-decoration:none;" class="update_image" id="<?php echo $id; ?>">Save</a></span>
                    <span><a style="margin-right: 5px; background-color: #222; border: 1px solid #000; color: #fff; padding: 5px; cursor:pointer;text-decoration:none;" class="cancel_update_image">Cancel</a></span>


                </div>

            <?php
            echo
                "
<div  class='preview-container' style='text-align: center; border: 1px solid #ddd; padding: 5px;'>
<img style='max-width:50%;border:1px solid #ccc;padding:2px;' src='" . SITE_URL . "/uploads/$p400x250' class='preview' id='" . $id . "'/>

</div></div>";
//<a href='#' data-toggle='tooltip' title='Rotate' data-placement='bottom' data-original-title='Rotate' id='rotate' style='float:right;top:0;right:0;'>
//<img src='" . SITE_URL . "/images/icons/rotate.png' />
//</a>
//}
//else
//echo "failed";
        } else
            echo "Invalid file format..";
    } else
        echo "Please select image..!";
    exit;
}
?>