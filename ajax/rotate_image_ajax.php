<?php
$image_path = json_decode(stripslashes($_POST['path']));
$image160x160 = new Imagick();
$image160x160->pingImage($image_path);
$image160x160->readImage($image_path);
$image160x160->rotateimage(new ImagickPixel('#00000000'), 90);
$image160x160->stripImage();
$image160x160->writeImage($image_path);
