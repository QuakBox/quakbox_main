<?php
ob_start();
ini_set('max_execution_time', -1);
ini_set('post_max_size', "16G");
ini_set('upload_max_filesize', "16G");

set_time_limit(0);
error_reporting(-1);
if(empty($_POST) || !isset($_POST['video_name']) || !isset($_POST['logFile'])) {
    exit();
}


// error_reporting(E_ERROR | E_WARNING | E_PARSE);
//ini_set("display_errors", "on");

include('../config.php');

$upload_dir = '../uploadedvideo/';
$ffmpeg = '/usr/local/bin/ffmpeg';
$avconv = '/usr/local/bin/avconv';

$watermark_path = "../images/watermark.png";
$time = time();
$ip = $_SERVER['REMOTE_ADDR'];

$video = $_POST['video_name'];
$log = $_POST['logFile'];

if ($video && $log) {
    $video_name = f($video, 'strip');
    $video_name = f($video_name, 'escapeAll');
    $video_name = mysqli_real_escape_string($con, $video_name);

    $logFile = f($log, 'strip');
    $logFile = f($logFile, 'escapeAll');
    $logFile = mysqli_real_escape_string($con, $logFile);

    $video_namew = pathinfo($video_name, PATHINFO_FILENAME);

    $pathforinputexec = $upload_dir . $video_name;

    $pathforoutputexecMP4 = $upload_dir . "new" . $video_namew . ".mp4";
    $pathforoutputexecOGG = $upload_dir . "new" . $video_namew . ".ogg";
    $pathforoutputexecWEBM = $upload_dir . "new" . $video_namew . ".webm";

    $PathForOutputLog = $upload_dir . "/logfile/" . $logFile;
    
    $ext = strtolower(pathinfo($video_name, PATHINFO_EXTENSION));
    $commandformp4 = "" . $ffmpeg . " -i " . $pathforinputexec . " -c:v libx264 -strict -2 " . $pathforoutputexecMP4 . " 1> " . $PathForOutputLog . " 2>&1";

    if($ext == 'mp4'){
	copy($pathforinputexec, $pathforoutputexecMP4);
    } else {
        @exec($commandformp4);
    }

    //extension_loaded('ffmpeg') or die('Error in loading ffmpeg');
    require_once('../qb_classes/ffmpeg-php/FFmpegAutoloader.php');

    $ffmpegInstance = new ffmpeg_movie($pathforoutputexecMP4);

    $duration = intval($ffmpegInstance->getDuration());

    $checkWetherFileIsCreated = false; // changes to true if file is created and exist.

    @$srcAB = intval($ffmpegInstance->getAudioBitRate());

    //GET VIDEO BITRATE FROM SOURCE FILE

    @$srcVB = intval($ffmpegInstance->getVideoBitRate());

    //SET THE AUDIO CODEC TO LIBVORBIS

    $aCodec = ' -acodec libvorbis';

    //SET THE VIDEO CODEC TO LIBTHEORA

    $vCodec = ' -vcodec libtheora';

    $video_name = "new" . $video_namew . ".mp4";
    $location = $upload_dir . $video_name;

    $checkWetherFileIsCreated = file_exists("new" . $video_namew . "01.png");

    $minutes1 = "00";
    $minutes2 = "00";
    $minutes3 = "00";
    $minutes4 = "00";
    $minutes5 = "00";

    $minutes = intval($duration / 5);

    if ($minutes > 60) {
        $minutes1 = intval($minutes / 60);
        $minutes2 = 2 * $minutes1;
        $minutes3 = 3 * $minutes1;
        $minutes4 = 4 * $minutes1;
        $minutes5 = 5 * $minutes1;
    }

    if($duration > 60){
	$duration = 60;
    }
    $secs = intval($duration / 5);

    if ($secs < 10)
        $secs = "0" . $secs;

    $secs1 = 2 * $secs;

    if ($secs1 < 10)
        $secs1 = "0" . $secs1;

    $secs2 = 3 * $secs;

    if ($secs2 < 10)
        $secs2 = "0" . $secs2;

    $secs3 = 4 * $secs;

    if ($secs3 < 10)
        $secs3 = "0" . $secs3;

    $secs4 = 5 * $secs;

    if ($secs4 < 10)
        $secs4 = "0" . $secs4;

    if($minutes == 0 && $secs < 60){
        $secs = $secs1 = $secs2 = $secs3 = $secs4 = '02';
    }

    $duration1 = "00:" . $minutes1 . ":" . $secs;
    $duration2 = "00:" . $minutes2 . ":" . $secs1;
    $duration3 = "00:" . $minutes3 . ":" . $secs2;
    $duration4 = "00:" . $minutes4 . ":" . $secs3;
    $duration5 = "00:" . $minutes5 . ":" . $secs4;

    $imageBaseName = "new" . $video_namew;

    $image_name1 = $imageBaseName . "01.png";
    $pathforthumbimage1 = $upload_dir . "/videothumb/" . $image_name1;

    $image_name2 = $imageBaseName . "02.png";
    $pathforthumbimage2 = $upload_dir . "/videothumb/" . $image_name2;

    $image_name3 = $imageBaseName . "03.png";
    $pathforthumbimage3 = $upload_dir . "/videothumb/" . $image_name3;

    $image_name4 = $imageBaseName . "04.png";
    $pathforthumbimage4 = $upload_dir . "/videothumb/" . $image_name4;

    $image_name5 = $imageBaseName . "05.png";
    $pathforthumbimage5 = $upload_dir . "/videothumb/" . $image_name5;

    $cmd1 = $ffmpeg . " -i " . $pathforoutputexecMP4 . " -ss " . $duration1 . " -f image2 -vframes 1 -t 5 " . $pathforthumbimage1 . "" . ' &> /dev/null &';
    @shell_exec($cmd1);
    
    $cmd2 = $ffmpeg . " -i " . $pathforoutputexecMP4 . " -ss " . $duration2 . " -f image2 -vframes 1 -t 5 " . $pathforthumbimage2 . "" . ' &> /dev/null &';
    @shell_exec($cmd2);

    $cmd3 = $ffmpeg . " -i " . $pathforoutputexecMP4 . " -ss " . $duration3 . " -f image2 -vframes 1 -t 5 " . $pathforthumbimage3 . "" . ' &> /dev/null &';
    @shell_exec($cmd3);

    $cmd4 = $ffmpeg . " -i " . $pathforoutputexecMP4 . " -ss " . $duration3 . " -f image2 -vframes 1 -t 5 " . $pathforthumbimage4 . "" . ' &> /dev/null &';
    @shell_exec($cmd4);

    $cmd5 = $ffmpeg . " -i " . $pathforoutputexecMP4 . " -ss " . $duration2 . " -f image2 -vframes 1 -t 5 " . $pathforthumbimage5 . "" . ' &> /dev/null &';
    @shell_exec($cmd5);
    
    //$i = 3600;
    $i = 60;
    while($i > 0){
	$i--;
	if(file_exists($pathforthumbimage1) && file_exists($pathforthumbimage2) && file_exists($pathforthumbimage3) && file_exists($pathforthumbimage4) && file_exists($pathforthumbimage5)){
	    break;
	}
	sleep(1);
    }

    $RemoveSpaceForBug = str_replace(' ', '', $pathforinputexec);
    unlink($RemoveSpaceForBug);

    $result['msg'] = "Your Video is successfully Processed ...*";
    $result['vname'] = $video_namew;

    $commandforWEBM = "" . $ffmpeg . " -i " . $pathforoutputexecMP4 . " -c:v libvpx -crf 10 -b:v 1M -c:a libvorbis -strict -2 " . $pathforoutputexecWEBM . " &> /dev/null &";
    @exec($commandforWEBM);

    $commandforOGG = "" . $ffmpeg . " -i " . $pathforoutputexecMP4 . " -vf 'movie=" . $watermark_path . " [watermark]; [in][watermark] overlay=10:main_h-overlay_h-10 -strict -2 [out]' " . $pathforoutputexecOGG . "  &> /dev/null &";
    @exec($commandforOGG);

    echo json_encode($result);
    exit();
} else {
    $result['msg'] = "You Can Upload Only Video Files";
    echo json_encode($result);
    exit();
}

