<?php

	ob_start();

	session_start();

	

	if(isset($_SESSION['lang']))

	{	

		include('common.php');

	}

	else

	{

		include('Languages/en.php');

		

	}

	if(!isset($_SESSION['SESS_MEMBER_ID']))

	{

		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();

	}

	require_once('config.php');

	

	$session_member_id = $_SESSION['SESS_MEMBER_ID'];

	$country_code = $_REQUEST['country'];

	$gquery = "SELECT country_id, code FROM geo_country WHERE country_title = '$country_code'";

	$gsql = mysqli_query($con, $gquery);

	$gres = mysqli_fetch_array($gsql);

	

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo  $lang['Add news'];?></title>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="stylesheet" type="text/css" href="css/wall.css"/>

<link rel="stylesheet" type="text/css" href="css/search.css"/>

<link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />

<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />

<link rel="stylesheet" type="text/css" href="css/responsive.css" />

<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />

<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />



<script src="js/bootstrap.min.js"></script>

<script src="js/jquery.min.js"></script>





<link rel="icon" href="images/favicon.ico" type="image" />

<link rel="shortcut icon" href="images/favicon.ico" type="image" />







<script src="js/youtube.js"></script>

    <script type="text/javascript" src="flowplayer/flowplayer.min.js"></script>

 <link rel="stylesheet" type="text/css" href="flowplayer/skin/minimalist.css">

 <link rel="stylesheet" type="text/css" href="css/youtube.css"/>

<script type="text/javascript">

window.onload=function() {

  var form = document.getElementsByTagName("form")[0]; // assuming first form on page

  form.onsubmit=function() {

    var sels = form.getElementsByTagName("select");	

    for (var i=0,n=sels.length;i<n;i++) {

      if (sels[i].selectedIndex<1) {

        alert('<?php echo $lang['Select news category'];?>'); // alerts Plz Select whatever

        sels[i].focus();

        return false; // disallow submit

      }

    }

    return true; // allow submission

  }

}

</script>

</head>

<body id="add_news1">

<div id="wrapper">

<?php 

include('includes/header.php');



?>

<div id="mainbody">



<div class="column_left">

<div id="submenushead">

	<div class="componentheading">

    	<div id="submenushead"><?php echo  $lang['Add news'];?><input type="button" name="add_video" class=" button" value="<?php echo  $lang['back to country'];?>" onclick="window.open('country_wall.php?country=<?php echo $country_code;?>','_self');" style="float:right; margin-right: 26px;" /></div>

  

   			 

   		 

   </div>

</div>



   <div id="border">

  <form name="video_upload" method="post" enctype="multipart/form-data" action="action/add_news.php" class="form-horizontal"> 

  

  

  <input type="hidden" name="member_id" value="<?php echo $session_member_id;?>" />

  

  <div class="form-group">

		<label for="name" class="control-label col-md-4">* <?php echo  $lang['Title'];?></label>

			<div class="col-md-4">

				<input type="text" name="title" id="title" size="45" required="required" class="textinput form-control"  />

			</div>

	</div>

    

     <div class="form-group">

		<label for="name" class="control-label col-md-4">* <?php echo  $lang['Description'];?></label>

			<div class="col-md-4">

			<div id="typefile" >

				<textarea name="description" id="description" required="required" style="width:100%; height:110px;" class="textinput form-control">

                </textarea>

			</div></div>

     </div>



	<div class="form-group">

		<label for="name" class="control-label col-md-4">*<?php echo  $lang['Image'];?></label>

			<div class="col-md-4">

				<input type="file" name="image" id="image" size="45" required="required" class="default"  />

			</div>

	</div>

    

	<div class="form-group">

		<label for="name" class="control-label col-md-4"><?php echo  $lang['Video'];?></label>

			<div class="col-md-4">

				<input type="file" name="video" id="video" size="45" class="default" />

			</div>

    </div>

    

    

    <div class="form-group">

		<label for="name" class="control-label col-md-4"><?php echo  $lang['Category'];?></label>

        	<div class="col-md-4">

			<select name="category" id="category" class="form-control">

					<option value="0"><?php echo  $lang['select category'];?></option>

						<?php 

							$cquery = "SELECT id, name FROM news_category";

							$csql = mysqli_query($con, $cquery);

							while($cres = mysqli_fetch_array($csql))

							{

						?>

						<option value="<?php echo $cres['id'];?>"><?php echo $cres['name'];?></option>

						<?php } ?>

			</select>

			</div>

	</div>

 <div class="form-group">

 <div class="col-md-4">

<input type="hidden" name="member_id" id="member_id" value="<?php echo $session_member_id;?>" />

<input type="hidden" name="country_id" id="country_id" value="<?php echo $gres['country_id'];?>" />

<input class="button validateSubmit" type="submit" value="<?php echo  $lang['Add news'];?>"></input>

<input class="button" type="button" value="<?php echo  $lang['Cancel'];?>" onclick="history.go(-1);return false;"></input>

</div>

</div>



 </form> 

</div>



</div><!--End column left div-->

</div><!--End mainbody div-->



<?php include 'includes/footer.php';?>

</div><!--End wrapper div-->

</body>

</html>