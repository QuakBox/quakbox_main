<?php

session_start();
//<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
?>

<?php

ob_start();


include_once('../config.php');

$http = $_POST['http'] . $_POST['url'];
$title = mysqli_real_escape_string($con, $_POST['title']);
$title = trim($title);
$description = mysqli_real_escape_string($con, $_POST['description']);
$description = trim($description);
$upload_img = $_POST['flag_img'];

$start_date =isset($_POST['start_date'])?$_POST['start_date']:'';
$end_date =isset($_POST['end_date'])?$_POST['end_date']:'';
$typeofadd =isset($_POST['typeofadd'])?$_POST['typeofadd']:''; 
$choice =isset($_POST['gender'])?$_POST['gender']:''; 

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

if(isset($_POST['agelimit'])AND $_POST['agelimit']!=''){
    $agelimit = $_POST['agelimit'];
}else{
    echo "Please select Agelimit";
    exit;
}
if(!isset($_POST['ads_id']) AND $upload_img != "update"){
if(isset($_POST['gender'])AND $_POST['gender']!=''){
        echo "Please select gender";
        exit;
}
}else{
     $ads_id = isset($_POST['ads_id']) ? $_POST['ads_id'] : '';
     $choice =$_POST['gender'];
 
 }

$per = trim($_POST['per']);
$click_payment = trim($_POST['click_payment']);
$paypal = trim($_POST['paypal']);

/* $image_url = $_SESSION['actual_image_name']; */
$sql = "select `image_name` from `user_uploads` where `user_id_fk` = " . $_POST['member_id'] . " order by `upload_id` desc limit 1";

$img_url = mysqli_query($con, $sql) or die(mysqli_error($con));
$img_url = mysqli_fetch_assoc($img_url);
$image_url = "uploads/" . $img_url['image_name'];

$member_id = $_POST['member_id'];

list($mm, $dd, $yyyy) = explode('/', $start_date);
list($mm1, $dd1, $yyyy1) = explode('/', $end_date);




if (!empty($title)) {
    if (checkdate($mm, $dd, $yyyy)) {

        $timestamp = strtotime($start_date);
        $start_date = date('Y-m-d', $timestamp);
        if (checkdate($mm1, $dd1, $yyyy1)) {
            $timestamp = strtotime($end_date);
            $end_date = date('Y-m-d', $timestamp);

            if ($start_date > $end_date) {
                echo 'End date should be Large than Startdate';
                exit;
            }

            if (!empty($description)) {
                if ($upload_img === "true") {

                    $sql = "INSERT INTO ads (ad_creator,`typeofadd`,`url`,`ads_title`,`ads_pic`,`ads_content`,
                                `targetgender`,`targetstate`,`targetcity`,`pricingperclick`,`pricingbuy`,`pricinggateway`,`targetcountry`,`add_date`,`agelimit`,`start_date`,`end_date`)
                                values('$member_id','" . $typeofadd . "','" . $http . "','" . $title . "','" . $image_url . "','" . $description . "',
                                '" . $choice . "','" . $state . "','" . $city . "','" . $per . "',
                                '" . $click_payment . "','" . $paypal . "','" . $countries . "',now(),'$agelimit','$start_date','$end_date')";


                    //$sql="insert itno ads(ad_creator)values($member_id)";
                    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
                    $last_id = mysqli_insert_id($con);
                    echo "Your ads inserted successfully";
                    exit;
                } elseif ($upload_img === "update" AND $ads_id != '') {

                    $sql = "Update ads set typeofadd='" . $typeofadd . "',url='" . $http . "',ads_title='" . $title . "',ads_pic='" . $image_url . "',ads_content='" . $description . "',
                                targetgender='" . $choice . "',targetstate='" . $state . "',targetcity='" . $city . "',pricingperclick='" . $per . "',
                                pricingbuy='" . $click_payment . "',pricinggateway='" . $paypal . "',targetcountry='" . $countries . "',agelimit='$agelimit',start_date='$start_date',end_date='$end_date' where ads_id=$ads_id";


                    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
                    $last_id = mysqli_insert_id($con);
                    //include "../ads_title.php";
                    // $url = $_SERVER['HTTP_REFERER'];
                    //echo '<script>window.location=" '.$url.'";</script>';
                    echo "Your ads update successfully";
                    exit;
                } else
                    echo "Please upload image..!";
            } else
                echo "Invalid body text";
        } else
            echo "Invalid end date";
    } else
        echo "Invalid start date";
} else
    echo "Invalid title";
exit;
?>