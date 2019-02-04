<?php

session_start();

?>

<?php

ob_start();


include_once('../config.php');

$http = $_POST['http'] . $_POST['url'];

$title = mysqli_real_escape_string($con, $_POST['title']);

$title = trim($title);
$member_id = $_POST['member_id'];
$description = mysqli_real_escape_string($con, $_POST['description']);
$description = trim($description);

$ads_id=isset($_POST['ads_id'])?$_POST['ads_id']:'';
$upload_img=isset($_POST['flag_img'])?$_POST['flag_img']:'';

$typeofadd = $_POST['typeofadd'];
$per = trim($_POST['per']);
$click_payment = trim($_POST['click_payment']);
$paypal = trim($_POST['paypal']);


if(isset($_POST['countries']) AND $_POST['countries']!=''){
    $countries = trim($_POST['countries']);
}else{
    echo "Please select countory";
    exit;
}

if(isset($_POST['state'])AND $_POST['state']!='' ){
    $state = trim($_POST['state']);
}else{
    echo "Please select state";
    exit;
}

if(isset($_POST['city'])AND $_POST['city']!=''){
    $city = trim($_POST['city']);
}else{
    echo "Please select city";
    exit;
}

if($_POST['agelimit']!=''){
    $agelimit = $_POST['agelimit'];
}else{
    echo "Please select Agelimit";
    exit;
}
if(isset($_POST['gender'])){
  $choice = $_POST['gender'];
}else{
    echo "Please select Gender";
    exit;
}

/* $image_url = $_SESSION['actual_image_name']; */
$sql = "select `image_name` from `user_uploads` where `user_id_fk` = " . $_POST['member_id'] . " order by `upload_id` desc limit 1";
$img_url = mysqli_query($con, $sql) or die(mysqli_error($con));
$img_url = mysqli_fetch_assoc($img_url);
$image_url = "uploads/" . $img_url['image_name'];

$rowcount='';
if($ads_id==''){

$sql = "SELECT * FROM `ads` WHERE status=0 AND `ad_creator`='" . $member_id . "' limit 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$rowcount = mysqli_num_rows($query);

}
if ($rowcount!=0 AND $upload_img==true) {
    
     echo "You have hlready post ads";
     exit;
    
}else{
   
    if($ads_id==''){
      
 
            $upload_img=isset($_POST['flag_img'])?$_POST['flag_img']:'';
            list($mm, $dd, $yyyy) = explode('/', $start_date);
            if (checkdate($mm, $dd, $yyyy)){
            $timestamp = strtotime($start_date);
            $start_date = date('Y-m-d', $timestamp);
            $end_date = date('Y-m-d', strtotime($start_date . ' +60 day'));
            }else{
                echo "Invalid start date";
                exit;
            }
    } 
        if (!empty($title)){
            
             if (!empty($description)) {
                if ($upload_img === "true") {

                    $sql = "INSERT INTO ads (ad_creator,`typeofadd`,`url`,`ads_title`,`ads_pic`,`ads_content`,
                                `targetgender`,`targetstate`,`targetcity`,`pricingperclick`,`pricingbuy`,`pricinggateway`,`targetcountry`,`add_date`,`agelimit`,`start_date`,`end_date`)
                                values('$member_id','" . $typeofadd . "','" . $http . "','" . $title . "','" . $image_url . "','" . $description . "',
                                '" . $choice . "','" . $state . "','" . $city . "','" . $per . "',
                                '" . $click_payment . "','" . $paypal . "','" . $countries . "',now(),'$agelimit','$start_date','$end_date')";

                    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
                    $last_id = mysqli_insert_id($con);
                    echo "Your ads successfully created";
                    exit;
                   // header("location: " . $url);
                } elseif($upload_img == "update") {
                  
                    
                        $sql = "Update ads set typeofadd='" . $typeofadd . "',url='" . $http . "',ads_title='" . $title . "',ads_pic='" . $image_url . "',ads_content='" . $description . "',
                                targetgender='" . $choice . "',targetstate='" . $state . "',targetcity='" . $city . "',pricingperclick='" . $per . "',
                                pricingbuy='" . $click_payment . "',pricinggateway='" . $paypal . "',targetcountry='" . $countries . "',agelimit='$agelimit' where ads_id=$ads_id";
       
                      
                                 $result = mysqli_query($con, $sql) or die(mysqli_error($con));
                                $last_id = mysqli_insert_id($con);
                    
                                 echo "Your ads update successfully";
                                 exit;
                } else
                    echo "Please upload image..!";
            } else
                echo "Invalid body text";
            } else
                echo "Invalid title";
            exit;
}


?>