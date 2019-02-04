<?php
session_start();
//error_reporting(0);
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
require_once('../config.php');


include_once('../includes/time_stamp.php');
include_once('../includes/files.php');
$country_id=$_REQUEST['country_id'];
include_once('header.php');
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,Firefox 4.x"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title><?php echo $lang['Photo Gallery'];?></title>
		<meta name="description" content="Blueprint: Blueprint: Google Grid Gallery" />
		<meta name="keywords" content="google getting started gallery, image gallery, image grid, template, masonry" />
		<meta name="author" content="Codrops" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
		<script src="js/modernizr.custom.js"></script>
		<style>
		.myButton {
    background: linear-gradient(to bottom, #33bdef 5%, #019ad2 100%) repeat scroll 0 0 #33bdef;
    border-radius: 11px;
    box-shadow: 0 0 0 0 #f0f7fa;
    color: #ffffff;
    cursor: pointer;
    display: inline-block;
    font-family: Verdana;
    font-size: 17px;
    font-weight: bold;
    padding: 8px 19px;
    text-decoration: none;
    text-shadow: 0 -1px 0 #5b6178;
}
		
		.PopupPanel
{
    border: solid 1px black;
   border: solid 1px black;
    position: absolute;
    left: 50%;
   /*top: 50%;*/
    background-color:white;
    z-index: 999;

    height: 250px;
    margin-top: -200px;

    width: 600px;
    margin-left: -300px;
    
    
    
}
		</style>
		<script>
		function hide_div()
		{
		//alert('hi');
		$("#vinod").hide();
		}
		function disp_photo()
		{
		$( ".slideshow" ).show();
		}
		
		function editimg(albumid,imgid)
		{
		//slide_caption_
		x=$("#actimage_"+imgid).position();
		//alert($(window).height());
		//var doch=$( document ).height()/2;
		//alert(doch)
		var mid=$(window).height()/2;
	
		$("#vinod").show();
		var scrol=$(document).scrollTop();
		//alert(scrol);
		$("#vinod").css('top', scrol+300);
		
		
		
		
		
		
		
		var caption=$('#slidecaption_'+imgid).text();
		var caption2=caption.trim();
		//alert(caption2)
		$('#imgcapt').val(caption2);
		
		var desc=$('#slidedesc_'+imgid).text();
		var desc2=desc.trim();
		$('#imgdesc').val(desc2);
		//alert(albumid);
		//alert(imgid);
		 
		 $("#imgid").val(imgid);
		 $('#album_id').val(albumid);
		}
		
		function savechanges()
		{
		var cntid=$("#cntid").val();
		//alert(cntid);
		var imgid=$("#imgid").val();
		var album_id=$("#album_id").val();
		//alert(imgid);
		//alert(album_id);
		var imgcapt=$("#imgcapt").val();
		var imgdesc=$("#imgdesc").val();
		//alert(imgcapt);
		//alert(imgdesc);
		      if(imgcapt=="" && imgdesc=="")
		      {
		       alert('<?php echo $lan['Please Enter Photo Caption Or Description'];?>');
		       return false;
		      }
		      else
		      {
		
		
					        $.ajax({
			      url: '../saveimgcapt_desc.php',
			      type: 'post',
			      data: {'imgid':imgid, 'album_id': album_id,'imgcapt':imgcapt,'imgdesc':imgdesc},
			      success: function(data, status) {
			      
			          $('#vinod').html(data);
			          $('#slidecaption_'+imgid).html(imgcapt);
			          $('#slidedesc_'+imgid).html(imgdesc);
			       // $("#gridimgdesc_"+imgid).html(imgdesc);
			         //   $("#gridimgcapt_"+imgid).html(imgdesc);
			            $("#vinod").hide();
			            location.href="<?php echo $base_url;?>photo_gall/photogall.php?country_id="+cntid;
			          
			          
			         
			      },
			     
			    }); // end ajax call
			}		
					        
		          
		                 
		}
		
		function showphoto(country_id,album_id,img_id)
		{
		//alert(country_id);
		//alert(album_id);
		//alert(img_id);
		 window.moveTo(0,0);
         var w = screen.width-400;
        var h = screen.height-300;
        var left = Number((screen.width/2)-(w/2));
        var tops = Number((screen.height/2)-(h/2));
       // $("#vinod").show();
       /*
       $.ajax({
            type: "POST",
            url: '<?php echo $base_url;?>albums2.php?back_page=photo_gall/photogall.php?country_id="+country_id+"&country_id="+country_id+"&album_id="+album_id+"&image_id="+img_id',
            data: '',
            cache: false,
            success: function (data) {			
				if(data != null) {
				//alert('yes');					
				$("#vinod").html(data);
				//$('#chatAudio')[0].play();		
				}
			}
			});*/
       
       
       
         //$("#vinod").append(load("<?php echo $base_url;?>albums2.php?back_page=photo_gall/photogall.php?country_id="+country_id+"&country_id="+country_id+"&album_id="+album_id+"&image_id="+img_id));
        
       window.open("<?php echo $base_url;?>country_photo_view.php?back_page=photo_gall/photogall.php?country_id="+country_id+"&country_id="+country_id+"&album_id="+album_id+"&image_id="+img_id, '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+tops+', left='+left);

//window.open("http://google.com", '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+tops+', left='+left);


 }
		</script>
	</head>
	<?php
	
	?>
	<div id="vinod" class="PopupPanel"  style="display:none;">
	
	<div align="right" class="close" onclick="hide_div()"><img src="../images/closebox.png"></div>
	<input type="hidden" id="imgid">
	<input type="hidden" id="album_id">
	<table  align="center">
	<tr><td><?php echo $lang['Caption'];?></td><td><input type="text" id="imgcapt"></td></tr>
	<tr><td colspan="2">&nbsp</td></tr>
	<tr><td><?php echo $lang['Description'];?></td><td><textarea id="imgdesc" rows="3" columns="15"></textarea></td></tr>
	<tr><td colspan="2"><input type="button" value="<?php echo $lang['Save'];?>" onclick="savechanges()" class="myButton"></td></tr>
	</table>
	</div>
	<body style="background-color:#000">
	<input type="text" id="cntid" value="<?php echo $country_id;?>">
	<?php 
	
	$sql = mysqli_query($con, "select * from geo_country where country_id='".$country_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$country_title = $res['country_title'];
	
	//include('../includes/header.php');?>
	
		<div class="container" style="margin-top:90px"> 
                   
        <input class="button" type="button"  onclick="window.open('<?php echo $base_url;?>country_wall.php?country=<?php echo $country_title;?>','_self');" value="<?php echo $country_title;?>">
        
			
			<div id="grid-gallery" class="grid-gallery" >
			    
				<section class="grid-wrap">
					<ul class="grid">
						<li class="grid-sizer"></li><!-- for Masonry column width -->
                        
                         <?php
			$pic= "SELECT gp.upload_data_id,gp.date_created,gp.FILE_NAME,gp.album_id,m.member_id, gp.caption, gp.description
						FROM upload_data gp LEFT JOIN members m on gp.USER_CODE = m.member_id 
						WHERE gp.country_id='$country_id' 
						ORDER by gp.upload_data_id ASC";
			$stpic=mysqli_query($con, $pic) or die(mysqli_error($con));
			$count=mysqli_num_rows($stpic);
			if($count==0)
			{
			 echo "<b><font color='red'>".$lang['NO PHOTO AVAILABLE']."</font></b>";
			}
			while($row=mysqli_fetch_array($stpic))
			{	
			    $m_id=$row['member_id'];
			   $img_id=$row['upload_data_id'];
			   $sql_m="select * from members where member_id=$m_id";
			   $st_m=mysqli_query($con, $sql_m);
			   $row2=mysqli_fetch_array($st_m);
			   $postedby=$row2['username'];
			    $postDate = date("l jS F Y",$row['date_created']);
	 
			   
			   
			   
			   
			    $sql_get_m_id="select * from message where photo_id=$img_id";
			    
			   $st_pic=mysqli_query($con, $sql_get_m_id);
			   $rowpic=mysqli_fetch_array($st_pic);
			   $message_id=$rowpic['messages_id'];
			
			$sqllike="SELECT bleh_id FROM bleh WHERE remarks=$message_id"; 
			$count_like=mysqli_num_rows(mysqli_query($con, $sqllike));  
			
			$sqldislike="SELECT dislike_id FROM post_dislike WHERE msg_id=$message_id"; 
			
			$count_dislike=mysqli_num_rows(mysqli_query($con, $sqldislike));  
			
			$sql_share="select * from count_share where message_id=$message_id";
			$count_share=mysqli_num_rows(mysqli_query($con, $sql_share));  
			
		$count_comment="SELECT * FROM `postcomment` WHERE `msg_id` = $message_id";
		$count_comm=mysqli_num_rows(mysqli_query($con, $count_comment));
			   
			   
			   
				?>	
		   
						<li>
						<?php //echo $_SESSION['SESS_MEMBER_ID'];
						
						
						
						if($_SESSION['SESS_MEMBER_ID']==$m_id)
							{
						
						?>
						<img src='../images/write.png' height="40" width="40" alt="Click On Image To Edit Description And Caption" title="<?php $lang['Click On Image To Edit Description And Caption'];?>">
						
						<?php
						}
						?>
							<figure  id="grid_caption_<?php echo $img_id;?>">
								<img src="../<?php echo $row['FILE_NAME'];?>" 
								
								alt="<?php echo $row['description'];?>" title="<?php echo $row['description'];?>" height="200" width="230"  />
								
								
								<figcaption><h3 id="gridimgcapt_<?php echo $img_id;?>"><?php echo nl2br($row['caption']);?></h3><p id="gridimgdesc_<?php echo $img_id;?>"><?php echo nl2br($row['description']);?></p>
								<font size='2' color="#3300CC" ><i><?php echo $lang['Posted By'];?>:<?php echo $postedby;?><br> <?php echo $lang['On'];?> <?php echo $postDate;?></i></font>
								</figcaption>
								
								<!--code for star rating!-->
								
								
								<table>
								<tr>
								<td><?php echo $lang['Likes'];?> </td>
								<?php
								if($count_like <=5)
								{
								?>
								
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_like >5 && $count_like<15)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_like >15 && $count_like<35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_like>35)
								{
								?>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<?php
								}
								?>
								
								
								
								</tr>
								
								<tr>
								<td><?php echo $lang['disLikes'];?></td>
								<?php
								if($count_dislike <=5)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_dislike >5 && $count_dislike<15)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_dislike >15 && $count_dislike<35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_dislike>35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								?>
								
								
								
								</tr>
								
								
								<tr>
								<td><?php echo $lang['Share'];?></td>
								<?php
								if($count_share <=5)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_share >5 && $count_share<15)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_share >15 && $count_share<35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_share >35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								?>
								</tr>
								<tr>
								<td><?php echo $lang['Comments'];?></td>
								
								<?php
								if($count_comm <=5)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_comm >5 && $count_comm<15)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_comm >15 && $count_comm<35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_comm >35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								?>
								
								
								
								
								</tr>
								
								</table>
								
								
								
								
								
								<!-- end of code for star rating!-->								
								
								
								
								
								
								
							</figure>
						</li>
			<?php
				}
		?>				
						
					</ul>
                    <nav>
						<span class="icon nav-prev"></span>
						<span class="icon nav-next" style="content: url(img/next.png)"></span>
						<span class="icon nav-close"></span>
					</nav>
					<!--<div class="info-keys icon"><?php echo $lang['Navigate with arrow keys'];?></div>-->
                    
                    
                 <section class="slideshow">
					<ul>
                    
                     <?php
			$pic= "SELECT gp.upload_data_id, gp.FILE_NAME,gp.date_created,gp.album_id,m.member_id, gp.caption, gp.description
						FROM upload_data gp LEFT JOIN members m on gp.USER_CODE = m.member_id 
						WHERE gp.country_id='$country_id'
						ORDER by gp.upload_data_id ASC";
			$stpic=mysqli_query($con, $pic);
			
			while($row=mysqli_fetch_array($stpic))
			{	
			
			  $m_id_slide=$row['member_id'];
			  
			  $img_id2=$row['upload_data_id'];
			   $sql_m_slide="select * from members where member_id=$m_id_slide";
			   $st_m_slide=mysqli_query($con, $sql_m_slide);
			   $row2_slide=mysqli_fetch_array($st_m_slide);
			   $postedbyslide=$row2_slide['username'];
			   $postDate2 = date("l jS F Y",$row['date_created']);
			   
			  //  $message_id=$row2_slide['messages_id'];
			    
			     $sql_get_m_id="select * from message where photo_id=$img_id2";
			    
			   $st_pic=mysqli_query($con, $sql_get_m_id);
			   $rowpic=mysqli_fetch_array($st_pic);
			   $message_id=$rowpic['messages_id'];
			    
			//echo "mid=".$message_id."<br>";
			$sqllike="SELECT bleh_id FROM bleh WHERE remarks=$message_id"; 
			$count_like=mysqli_num_rows(mysqli_query($con, $sqllike));  
			
			$sqldislike="SELECT dislike_id FROM post_dislike WHERE msg_id=$message_id"; 
			
			$count_dislike=mysqli_num_rows(mysqli_query($con, $sqldislike));  
			
			$sql_share="select * from count_share where message_id=$message_id";
			//echo $sql_share;
			$count_share=mysqli_num_rows(mysqli_query($con, $sql_share));
			
		$count_comment="SELECT * FROM `postcomment` WHERE `msg_id` = $message_id";
		$count_comm=mysqli_num_rows(mysqli_query($con, $count_comment));
				?>	
						<li>
						<?php
						$s_alb_id=$row['album_id'];
								$img_id=$row['upload_data_id'];
						?>
							<figure  id="slide_caption_<?php echo $img_id;?>">
							<?php 
							//echo $m_id_slide;
							//echo $member_id;
							
								
							if($_SESSION['SESS_MEMBER_ID']==$m_id_slide)
							{
							?>
							<a href="#!" id="img_<?php echo $img_id;?>"  onclick="editimg('<?php echo $s_alb_id;?>','<?php echo $img_id;?>')"><img src='../images/write.png' height="30" width="30" alt="<?php echo $lang['Click On Image To Edit Description And Caption'];?>" title="<?php echo $lang['Click On Image To Edit Description And Caption'];?>"></a>
							
								
								<?php
								}
								//echo $count_share;
								
								?>
								<a href="#!" id="actimage_<?php echo $img_id;?>"  onclick="showphoto('<?php echo $country_id;?>','<?php echo $s_alb_id;?>','<?php echo $img_id;?>')" ><img src="../<?php echo $row['FILE_NAME'];?>" alt="<?php echo $row['description'];?>" title="<?php echo $row['description'];?>" height="400" width="600"/></a>
								
								<figcaption>
									<h3 id="slidecaption_<?php echo $img_id;?>">
									
									<?php // echo $m_id_slide.$postedbyslide."<br>";
									 echo $row['caption'];?></h3>
									<p id="slidedesc_<?php echo $img_id;?>"><?php echo $row['description'];?></p>
									<font size='2' color="#3300CC" ><i><?php echo $lang['Posted By'];?>:<?php echo $postedbyslide;?> <?php echo $lang['On'];?> <?php echo  $postDate2;?>
									</i></font>
									<!--code for slideshow star rating!-->
									
									<table>
								<tr>
								<td><?php echo $lang['Likes'];?></td>
								<?php
								if($count_like <=5)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_like >5 && $count_like<15)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_like >15 && $count_like<35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_like>35)
								{
								?>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<?php
								}
								?>
								
								
								
								<td>&nbsp;</td>
								
								
								<td><?php echo $lang['disLikes'];?></td>
								<?php
								if($count_dislike <=5)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_dislike >5 && $count_dislike<15)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_dislike >15 && $count_dislike<35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_dislike>35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								?>
								
								<td>&nbsp;</td>
								<td><?php echo $lang['Share'];?></td>				
								   <?php
								   //echo $count_share;
								if($count_share <=5)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_share >5 && $count_share<15)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_share >15 && $count_share<35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_share >35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								?>
								
								<td>&nbsp;</td>
								
								
								<td><?php echo $lang['Comments'];?></td>
								
								<?php
								if($count_comm <=5)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_comm >5 && $count_comm<15)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_comm >15 && $count_comm<35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								else if($count_dislike >35)
								{
								?>
								<td>
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								<img src="<?php echo $base_url;?>images/star.png" height="20" width="20">
								</td>
								<?php
								}
								?>
								
								
								
								</tr>
								</table>
									
									
									
									
									
									
									<!--code for slideshow star rating!-->
									
									
									
								</figcaption>
								
								
								
								
								
								
								
								
								
								
							</figure>
							
						</li>
                        
                    <?php
				}
		?>		    

					</ul>
                    
                    
                    
                    
					<nav>
						<span class="icon nav-prev"><img src="img/prev.png"></span>
						<span class="icon nav-next"><img src="img/next.png"></span>
						<span class="icon nav-close"><img src="../images/closebox.png"></span>
					</nav>
					<!--<div class="info-keys icon"><?php echo $lang['Navigate with arrow keys'];?></div>-->
				</section><!-- // slideshow -->   
                    
                    
                    
                    
                    
					
				</section><!-- // slideshow -->
			</div><!-- // grid-gallery -->
		</div>
		<script src="js/imagesloaded.pkgd.min.js"></script>
		<script src="js/masonry.pkgd.min.js"></script>
		<script src="js/classie.js"></script>
		<script src="js/cbpGridGallery.js"></script>
		<script>
			new CBPGridGallery( document.getElementById( 'grid-gallery' ) );
		</script>
		<?php include('../includes/footer.php');?>
	</body>
</html>