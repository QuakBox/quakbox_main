<?php
//error_reporting(0);
session_start();	
	 if(!isset($_SESSION['SESS_MEMBER_ID']))
	{	
	
		echo "<script>alert(1);</script>";
	}
	
	?>