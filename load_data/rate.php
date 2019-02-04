<?php

include("../config.php"); //FILE THAT CONNECTS TO YOUR DATABASE

$rating = (int)$_POST["rating"];
$user_id = (int)$_POST["user_id"];
$video_id = (int)$_POST["video_id"];
$ip = $_SERVER["REMOTE_ADDR"];
$date = date("l, F j, Y"). " at " .date("h:i:s A");
$timestamp = time();

//CHECKS TO SEE IF USER HAS ALREADY RATED THE CONTENT
$q = mysqli_query($con, "SELECT * FROM videos WHERE video_id='$video_id' and user_id = '$user_id'");
$nn = mysqli_num_rows($q);
$r = mysqli_fetch_assoc($q);

//CHECKS IF THE CONTENT EXISTS
$q = mysqli_query($con, "SELECT * FROM videos WHERE video_id='$video_id' and user_id = '$user_id'");
$content_exists = mysqli_num_rows($q);

if($content_exists){
    
            mysqli_query($con, "UPDATE videos SET rating='$rating' WHERE video_id='$video_id' and user_id = '$user_id'");
        }
     else {
        //ADDS THE NEW RATING, IF USER HAS NOT ALREADY RATING
        $range = range(1, 5);
        if(in_array($rating, $range)){
            mysqli_query($con, "INSERT INTO videos(rating,user_id) VALUES('$rating','$user_id')");
        }
    
}

$q = mysqli_query($con, "SELECT * FROM videos WHERE video_id='$video_id' and user_id = '$user_id'");
$n = mysqli_num_rows($q);

    
//ADDS ALL THE STAR FOR THE CONTENT BEING RATED
while($s=mysqli_fetch_array($q)){
    $rr = $s["rating"];
    @$x += $rr;
}
$a = $x;

//IF THERE ARE RATINGS...
if($n){
    $rating = $a/$n; //GETS THE AVERAGE RATING (UNROUNDED)
}

//GETS THE RATING ON THE 5-STAR SCALE (ROUNDED TO THE NEAREST 10TH)
$dec_rating = round($rating, 1);

//LOOPS THE WHOLE NUMBER OF STARS THAT THE CONTENT HAS BEEN RATED
for($i=1; $i<=floor($rating); $i++){
    @$stars[$video_id] .= '<div class="star s'.$video_id.'" x="'.$video_id.'" video_id="'.$i.'"></div>';
}

//THE CURRENT RATING & THE TRANSPARENT BASE RIGHT USER TO SUBMIT A NEW RATING
echo '<div class="rating r'.$video_id.'">'.@$stars[$video_id].'</div>
<div class="transparent">
<div class="star s'.$video_id.'" x="'.$video_id.'" id="1"></div>
<div class="star s'.$video_id.'" x="'.$video_id.'" id="2"></div>
<div class="star s'.$video_id.'" x="'.$video_id.'" id="3"></div>
<div class="star s'.$video_id.'" x="'.$video_id.'" id="4"></div>
<div class="star s'.$video_id.'" x="'.$video_id.'" id="5"></div>

</div>';
?>