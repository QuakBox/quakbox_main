<?php
/**
   * @package      emailfrm
   * @subpackage 
   * @author        Vishnu 
   * Created date  02/11/2015 
   * Updated date  03/26/2015 
   * Updated by    Vishnu S
 **/

ob_start();
if(!isset($_SESSION)){
session_start();
}
error_reporting(-1);
include($_SERVER['DOCUMENT_ROOT'].'/config.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Share via email</title>
</head>

<body>
<form name="email" id="email" method="post" action="emailform.php">
Email:<input type="email" placeholder="Enter Email Address" name="email"  required="required"/>
<input type="hidden" name="mesg_id" value="<?php echo $_REQUEST['mesgid'];?>">
<input type="hidden" name="share_status" value="<?php echo $_REQUEST['share_status'];?>">

<?php

if(isset($_REQUEST['link']) )
{
?>
<input type="hidden" name="link" value="<?php echo $_REQUEST['link'];?>">
<?php
}
?>

<?php

if(isset($_REQUEST['vlink']))
{
?>
<input type="hidden" name="vlink" value="<?php echo $_REQUEST['vlink'];?>">
<?php
}
?>
<input type="submit" value="Send Email" />
<?php //echo $_REQUEST['vlink'];?>
</form>
</body>
</html>