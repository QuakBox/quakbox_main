<?php  ob_start();
session_start();
$member_id = $_SESSION['userid'];
include('../config.php');

 $upload_dir = '../uploadedvideo/';  
	
	/*$title = $_POST['title'];
	$description = $_POST['description'];
	$category = $_POST['category'];
	$type = $_POST['type'];*/
	$watermark_path="../images/watermark.png";
	$time = time();
	$ip=$_SERVER['REMOTE_ADDR'];
	
	if($_POST['video_name'] && $_POST['logFile'])  
	{  
	
	system("cp /usr/local/WowzaStreamingEngine-4.0.4/content/".$_POST['video_name'].$root_folder_path."public_html/uploadedvideo/".$_POST['video_name']."");

	$video_name   = f($_POST['video_name'], 'strip');
    $video_name	 = 	f($video_name, 'escapeAll');
    $video_name   = mysqli_real_escape_string($con, $video_name);
    

	$logFile   = f($_POST['logFile'], 'strip');
    $logFile	 = 	f($logFile, 'escapeAll');
    $logFile   = mysqli_real_escape_string($con, $logFile);
    
	$video_namew = pathinfo($video_name, PATHINFO_FILENAME);
	$pathforinputexec = $upload_dir.$video_name;
	$pathforoutputexecMP4 = $upload_dir."new".$video_namew.".mp4";
	$pathforoutputexecOGG = $upload_dir."new".$video_namew.".ogg";
	$pathforoutputexecWEBM = $upload_dir."new".$video_namew.".webm";
	$PathForOutputLog = $upload_dir."/logfile/".$logFile;
	exec("/usr/local/bin/ffmpeg -i ".$pathforinputexec." -vf 'movie=".$watermark_path."    [watermark]; [in][watermark] overlay=10:main_h-overlay_h-10 [out]'  -c:a aac -strict -2 -b:a 128k -c:v libx264 -profile:v baseline ".$pathforoutputexecMP4." 1> ".$PathForOutputLog." 2>&1");
	
				//extension_loaded('ffmpeg') or die('Error in loading ffmpeg');
				require_once('../qb_classes/ffmpeg-php/FFmpegAutoloader.php');

				$ffmpegInstance = new ffmpeg_movie($pathforoutputexecMP4);
			        $duration = intval($ffmpegInstance->getDuration());
				$checkWetherFileIsCreated = false; // changes to true if file is created and exist.
				$srcAB = intval($ffmpegInstance->getAudioBitRate());
				//GET VIDEO BITRATE FROM SOURCE FILE
				$srcVB = intval($ffmpegInstance->getVideoBitRate());
				//SET THE AUDIO CODEC TO LIBVORBIS
				$aCodec = ' -acodec libvorbis';
				//SET THE VIDEO CODEC TO LIBTHEORA
				$vCodec = ' -vcodec libtheora';
	
	
	exec("/usr/local/bin/ffmpeg -i ".$pathforinputexec.$vCodec." -vf 'movie=".$watermark_path." [watermark]; [in][watermark] 
	overlay=10:main_h-overlay_h-10 [out]' -vb ".$srcVB." -ab ".$srcAB." ".$pathforoutputexecOGG." 1> ".$PathForOutputLog." 2>&1");
	
	
	exec("/usr/local/bin/ffmpeg -i ".$pathforinputexec." -vf 'movie=".$watermark_path." [watermark]; [in][watermark] overlay=10:main_h-overlay_h-10 [out]'  -c:a libvorbis -ac 1 -b:a 96k -ar 48000 -b:v 1100k -maxrate 1100k -bufsize 1835k -vcodec libvpx -cpu-used -5 -deadline realtime  ".$pathforoutputexecWEBM." 1> ".$PathForOutputLog." 2>&1");
	
	
	$video_name ="new".$video_namew.".mp4";
	$location =$upload_dir. $video_name;
	
	if($duration>60)
	{
	$image_name = "new".$video_namew."%2d.png";
	$pathforthumbimage=$upload_dir."/videothumb/".$image_name;
	$command = "/usr/local/bin/ffmpeg -i ".$pathforoutputexecMP4." -vf 'select=gt(scene\,0.5)' -frames:v 5 -vsync vfr ".$pathforthumbimage."";
	exec($command . ' 2>&1', $output);
	//print_r($output);
	}
	$checkWetherFileIsCreated = file_exists("new".$video_namew."01.png");
	if($duration<=60 || !$checkWetherFileIsCreated )
	{
	$minutes1 = "00";$minutes2 = "00";$minutes3 = "00";$minutes4 = "00";$minutes5 = "00";
	if($duration<3600 && $duration>60)
	{
	  $minutes = intval($duration / 6);
	  if($minutes > 60)
	    {
	     $minutes1 = intval($minutes/60);
	     $minutes2 = 2 * $minutes1;
	     $minutes3 = 3 * $minutes1;
	     $minutes4 = 4 * $minutes1;
	     $minutes5 = 5 * $minutes1;
	    }
	  else
	    {
	     
	    }
	  $duration = 60;
	}
	$secs = intval($duration / 6);
	if($secs<10)
	$secs = "0".$secs;
	$secs1 = 2 * $secs;
	if($secs1<10)
	$secs1 = "0".$secs1;
	$secs2 = 3 * $secs;
	if($secs2<10)
	$secs2 = "0".$secs2;
	$secs3 = 4 * $secs;
	if($secs3<10)
	$secs3 = "0".$secs3;
	$secs4 = 5 * $secs;
	if($secs4<10)
	$secs4 = "0".$secs4;
	$duration1 = "00:".$minutes1.":".$secs;
	$duration2 = "00:".$minutes2.":".$secs1;
	$duration3 = "00:".$minutes3.":".$secs2;
	$duration4 = "00:".$minutes4.":".$secs3;
	$duration5 = "00:".$minutes5.":".$secs4;
	$imageBaseName = "new".$video_namew;
	$image_name1 = $imageBaseName."01.png";
	$pathforthumbimage1=$upload_dir."/videothumb/".$image_name1;
	$image_name2 = $imageBaseName."02.png";
	$pathforthumbimage2=$upload_dir."/videothumb/".$image_name2;
	$image_name3 = $imageBaseName."03.png";
	$pathforthumbimage3=$upload_dir."/videothumb/".$image_name3;
	$image_name4 = $imageBaseName."04.png";
	$pathforthumbimage4=$upload_dir."/videothumb/".$image_name4;
	$image_name5 = $imageBaseName."05.png";
	$pathforthumbimage5=$upload_dir."/videothumb/".$image_name5;
	exec("/usr/local/bin/ffmpeg -i ".$pathforoutputexecMP4." -ss ".$duration1." -f image2 -vframes 1 -t 5 ".$pathforthumbimage1."". ' 2>&1', $output1);
	exec("/usr/local/bin/ffmpeg -i ".$pathforoutputexecMP4." -ss ".$duration2." -f image2 -vframes 1 -t 5 ".$pathforthumbimage2."". ' 2>&1', $output2);
	exec("/usr/local/bin/ffmpeg -i ".$pathforoutputexecMP4." -ss ".$duration3." -f image2 -vframes 1 -t 5 ".$pathforthumbimage3."". ' 2>&1', $output3);
	exec("/usr/local/bin/ffmpeg -i ".$pathforoutputexecMP4." -ss ".$duration4." -f image2 -vframes 1 -t 5 ".$pathforthumbimage4."". ' 2>&1', $output4);
	exec("/usr/local/bin/ffmpeg -i ".$pathforoutputexecMP4." -ss ".$duration5." -f image2 -vframes 1 -t 5 ".$pathforthumbimage5."". ' 2>&1', $output5);
	}
	$RemoveSpaceForBug = str_replace(' ', '', $pathforinputexec);
	unlink($PathForOutputLog);
	unlink($RemoveSpaceForBug);
	system("rm -rf /usr/local/WowzaStreamingEngine-4.0.4/content/".$_POST['video_name']." ");		  
	  }
	  else
	  {
		  echo "You Can Upload Only Video Files";
	  }
        
 ?>  