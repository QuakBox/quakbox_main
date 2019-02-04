<?php  ob_start();

session_start();

$member_id = $_SESSION['userid'];

include('../config.php');



 $upload_dir = '../../../uploadedvideo/ads/';
 //$ffmpeg = 'C:\\ffmpeg\\bin\\ffmpeg';  
 $ffmpeg = '/usr/local/bin/ffmpeg';
	

	/*$title = $_POST['title'];

	$description = $_POST['description'];

	$category = $_POST['category'];

	$type = $_POST['type'];*/

	$watermark_path="../../../images/watermark.png";

	$time = time();

	$ip=$_SERVER['REMOTE_ADDR'];

	

	if($_POST['video_name'] && $_POST['logFile'])  

	{  

	

	$video_name = $_POST['video_name'];

	$logFile = $_POST['logFile'];

	$video_namew = pathinfo($video_name, PATHINFO_FILENAME);

	$pathforinputexec = $upload_dir.$video_name;

	$pathforoutputexecMP4 = $upload_dir."new".$video_namew.".mp4";

	$pathforoutputexecOGG = $upload_dir."new".$video_namew.".ogg";

	$pathforoutputexecWEBM = $upload_dir."new".$video_namew.".webm";

	$PathForOutputLog = $upload_dir."/logfile/".$logFile;

$commandformp4 = "".$ffmpeg." -i ".$pathforinputexec." -vf 'movie=".$watermark_path." [watermark]; [in][watermark] overlay=10:main_h-overlay_h-10 [out]' ".$pathforoutputexecMP4." 1> ".$PathForOutputLog." 2>&1";
//$commandformp4 = "".$ffmpeg." -i ".$pathforinputexec." -vf 'movie=".$watermark_path."    [watermark]; [in][watermark] overlay=10:main_h-overlay_h-10 [out]'  -c:a aac -strict -2 -b:a 128k -c:v libx264 -profile:v baseline ".$pathforoutputexecMP4." 1> ".$PathForOutputLog." 2>&1";
	exec($commandformp4);

	

				//extension_loaded('ffmpeg') or die('Error in loading ffmpeg');
				require_once('../../../qb_classes/ffmpeg-php/FFmpegAutoloader.php');

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

	
$commandforOGG = "".$ffmpeg." -i ".$pathforinputexec." -vf 'movie=".$watermark_path." [watermark]; [in][watermark] overlay=10:main_h-overlay_h-10 [out]' ".$pathforoutputexecOGG." 1> ".$PathForOutputLog." 2>&1";

/*$commandforOGG = "".$ffmpeg." -i ".$pathforinputexec.$vCodec." -vf 'movie=".$watermark_path." [watermark]; [in][watermark] 

	overlay=10:main_h-overlay_h-10 [out]' -vb ".$srcVB." -ab ".$srcAB." ".$pathforoutputexecOGG." 1> ".$PathForOutputLog." 2>&1";*/	

	exec($commandforOGG);

	$commandforWEBM = "".$ffmpeg." -i ".$pathforinputexec." -vf 'movie=".$watermark_path." [watermark]; [in][watermark] overlay=10:main_h-overlay_h-10 [out]' ".$pathforoutputexecWEBM." 1> ".$PathForOutputLog." 2>&1";

	//$commandforWEBM = "".$ffmpeg." -i ".$pathforinputexec." -vf 'movie=".$watermark_path." [watermark]; [in][watermark] overlay=10:main_h-overlay_h-10 [out]'  -c:a libvorbis -ac 1 -b:a 96k -ar 48000 -b:v 1100k -maxrate 1100k -bufsize 1835k -vcodec libvpx -cpu-used -5 -deadline realtime  ".$pathforoutputexecWEBM." 1> ".$PathForOutputLog." 2>&1";

	exec($commandforWEBM);	

	$RemoveSpaceForBug = str_replace(' ', '', $pathforinputexec);

	unlink($PathForOutputLog);

	unlink($RemoveSpaceForBug);		  

	  }

	  else

	  {

		  echo "You Can Upload Only Video Files";

	  }

        

 ?>  