<?php
function video_duration($time_ago){
$init = $time_ago;

$hours1 		= round($init / 3600);
$minutes1 	= round($init / 60);
$seconds1    = $init;


$hours 		= floor($init / 3600);
$minutes 	= floor(($init / 60) % 60);
$seconds    = $init % 60;


$seconds = ($seconds<10?"0".$seconds:"".$seconds);
if($minutes1 < 60){	
	echo "$minutes:$seconds";
}
else {
	$minutes = ($minutes<10?"0".$minutes:"".$minutes);

$hours = ($hours>0?$hours.":":"").$minutes.":".$seconds;	
	echo "$hours"; 
}
}



?>