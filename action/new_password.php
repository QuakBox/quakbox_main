<?php ob_start(); 
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
$memberObject = new member1();
$id =$_REQUEST['member_id']; 
$rpass=$_POST['password'];
$pass = $_POST['password'];
$hash = hash('sha256', $pass); 
$salt = genUid();
$password = hash('sha256', $salt . $hash);

$sql = "update member set password='$password',salt = '$salt' where member_id='$id'";
$res = mysqli_query($con, $sql);
if($res){
    //echo "<script>alert('Good Esso');</script>";
$rsRelationship= $memberObject->update_member_meta($id,"temp_pwd",$pass); 
}
//else{echo "<script>alert('Bad Esso');</script>";}

header("location: ".$base_url."index.php");
exit();

?>