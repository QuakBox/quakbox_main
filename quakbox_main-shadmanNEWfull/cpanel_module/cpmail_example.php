<?php
/*
This is the example script for cpmail class
*/

?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>cPanel Email Creator</title>
</head>

<body>

<p><b><font size="5">Cpanel Email Creator</font></b></p>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

	<table border="0" width="52%" style="border-collapse: collapse">
		<tr>
			<td colspan="2">
			<p align="left"><b>Create Email Accounts</b></td>
		</tr>
		<tr>
			<td width="78">
			<p align="right">Username:</td>
			<td><input type="text" name="euser" size="20"></td>
		</tr>
		<tr>
			<td width="78">
			<p align="right">Password:</td>
			<td><input type="password" name="epass" size="20"></td>
		</tr>
		<tr>
			<td width="78">&nbsp;</td>
			<td><input type="submit" value="Create New Account" name="create"></td>
		</tr>
	</table>
</form>
<p>&nbsp;</p>
<?php
if(isset($_POST['create'])){

 //include class file
 require_once('cpmail_class.php');
 
 /*
  instanceiate class & pass three arguments cpanelusername, cpanelpassword,yourdomainname,cpanelskin
  See following URL to know how to determine your cPanel skin 
  http://www.zubrag.com/articles/determine-cpanel-skin.php 
  if you don't pass cpanelskin argument, default will be x
 */
 $cpanel=new cpmail("wwwquakb","betatest","quakbox.com","paper_lantern");

 //call create function and you have to pass three arguments as follows:
 //emailid, password, quota

 echo $cpanel->create($_POST['euser'],$_POST['epass'],"20");
}
?>
</body>

</html>
