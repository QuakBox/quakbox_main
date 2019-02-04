<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_validation.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location:login.php?back=". urlencode($_SERVER['REQUEST_URI']));
	}
$country_id=$_REQUEST['country_id'];
$member_id=$_SESSION['SESS_MEMBER_ID'];

$country_id=htmlspecialchars(trim($country_id));
if(!(empty($country_id)||($qbValidation->qbIntegerCheck($country_id))))
	{
		$qb_err_msg="Oops Something Went Wrong...!";
		$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
		//include_once($_SERVER['DOCUMENT_ROOT'].'/includes/files.php');?>
		
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
		       alert('<?php echo 'Please Enter Photo Caption Or Description';//echo $lan['Please Enter Photo Caption Or Description'];?>');
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
      
       
           
       window.open("../albums.php?member_id="+<?php echo $member_id; ?>+"&back_page=photo_gall/photogall.php?country_id="+country_id+"&album_id="+album_id+"&image_id="+img_id+"&popup=1",'', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=yes, width='+w+', height='+h+', top='+tops+', left='+left);



 }
		</script>
	<div id="vinod" class="PopupPanel"  style="display:none;">
	
	<div align="right" class="close" onClick="hide_div()"><img src="../images/closebox.png"></div>
	<input type="hidden" id="imgid">
	<input type="hidden" id="album_id">
	<table  align="center">
	<tr><td style="padding-top: 25px; padding-left: 10px;"><?php echo $lang['Caption'];?></td><td style="padding-top: 31px; padding-left: 27px;"><input type="text" style="width: 215px;" id="imgcapt"></td></tr>
	<tr><td colspan="2">&nbsp</td></tr>
	<tr><td style="padding-left: 10px;"><?php echo $lang['Description'];?></td><td style="padding-left: 27px;"><textarea id="imgdesc" rows="3" columns="15"></textarea></td></tr>
	<tr><td colspan="2" style="padding-top: 11px; padding-left: 115px;"><input type="button" value="<?php echo $lang['Save'];?>" onClick="savechanges()" class="myButton"></td></tr>
	</table>
	</div>
    
	<input type="hidden" id="cntid" value="<?php echo $country_id;?>">
	<?php 
	
	$sql = mysqli_query($con, "select * from geo_country where country_id='".$country_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$country_title = $res['country_title'];
	
	//include('../includes/header.php');?>
    <div class="insideWrapper container" style="margin-top:90px">
         <div class="row">  
            <div class="col-lg-12 col-md-12 col-sm-12">
                   
        <input class="button" type="button"  onclick="window.open('../country_wall.php?country=<?php echo $country_title;?>','_self');" value="<?php echo $country_title;?>">
       <div class="container">
			<div id="grid-gallery" class="grid-gallery" >
			    
				<section class="grid-wrap">
					<ul class="grid">
						<li class="grid-sizer"></li><!-- for Masonry column width -->
                        
                         <?php
			$pic = "SELECT min(gp.upload_data_id) upload_data_id,min(gp.date_created) date_created,gp.FILE_NAME,gp.album_id,ua.album_user_id as member_id, gp.caption, gp.description 
						FROM upload_data gp LEFT JOIN user_album ua on gp.USER_CODE = ua.album_user_id 
						WHERE ua.country_id='$country_id' AND gp.album_id = ua.album_id 
						group by gp.FILE_NAME,gp.album_id,ua.album_user_id , gp.caption, gp.description 
						
						ORDER by gp.upload_data_id ASC";
			/*$pic= "SELECT gp.upload_data_id,gp.date_created,gp.FILE_NAME,gp.album_id,m.member_id, gp.caption, gp.description
						FROM upload_data gp LEFT JOIN member m on gp.USER_CODE = m.member_id 
						WHERE gp.country_id='$country_id' 
						ORDER by gp.upload_data_id ASC";*/
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
			   $sql_m="select * from member where member_id=$m_id";
			   $st_m=mysqli_query($con, $sql_m);
			   $row2=mysqli_fetch_array($st_m);
			   $postedby=$row2['username'];
			    $postDate = date("l jS F Y",$row['date_created']);
	 
			   
			   
			   
			   
			    $sql_get_m_id="select * from message where photo_id=$img_id";
			    
			   $st_pic=mysqli_query($con, $sql_get_m_id);
			   $rowpic=mysqli_fetch_array($st_pic);
			   $message_id=$rowpic['messages_id'];
			
			$sqllike="SELECT bleh_id FROM bleh WHERE remarks='$message_id'"; 
			$count_like=mysqli_num_rows(mysqli_query($con, $sqllike));  
			
			$sqldislike="SELECT dislike_id FROM post_dislike WHERE msg_id='$message_id'"; 
			
			$count_dislike=mysqli_num_rows(mysqli_query($con, $sqldislike));  
			
			$sql_share="select * from count_share where message_id='$message_id'";
			$count_share=mysqli_num_rows(mysqli_query($con, $sql_share));  
			
		$count_comment="SELECT * FROM `postcomment` WHERE `msg_id` = '$message_id'";
		$count_comm=mysqli_num_rows(mysqli_query($con, $count_comment));
			   
			   
			   
				?>	
		   
						<li>
						<?php //echo $_SESSION['SESS_MEMBER_ID'];
						
						
						
						if($_SESSION['SESS_MEMBER_ID']==$m_id)
							{
						
						?>
						<img src='../images/write.png' height="30" width="30" alt="Click On Image To Edit Description And Caption" 
						title="<?php $lang['Click On Image To Edit Description And Caption'];?>">
						
						<?php
						}
						?>
						<div class="photo">
							<figure  id="grid_caption_<?php echo $img_id;?>" style="padding:initial;cursor: text !important;">
								<img src="../<?php echo $row['FILE_NAME'];?>" 
								alt="<?php echo $row['description'];?>" 
								title="<?php echo $row['description'];?>" 
								height="200" width="200"
								style="max-width:100%;"
								id="<?php echo $row['upload_data_id'];?>"
								/>
								
								
								<figcaption><h3 id="gridimgcapt_<?php echo $img_id;?>"><?php echo nl2br($row['caption']);?></h3>
								<p id="gridimgdesc_<?php echo $img_id;?>"><?php echo nl2br($row['description']);?></p>
								<font size='2' color="#3300CC" ><i><?php echo $lang['Posted By'];?>:<?php echo $postedby;?><br> <?php echo $lang['On'];?> <?php echo $postDate;?></i></font>
								</figcaption>
								
								<!--code for star rating!-->
								
								
								<table>
								<tr>
								<td><?php echo $lang['Likes'];?> </td>
								<td><?php echo $count_like ?></td>
								</tr>
								
								<tr>
								<td><?php echo $lang['disLikes'];?></td>
								<td><?php echo $count_dislike ?></td>
								</tr>
								
								
								<tr>
								<td><?php echo $lang['Share'];?></td>
								<td><?php echo $count_share ?></td>
								</tr>
								<tr>
								<td><?php echo $lang['Comments'];?></td>
								<td><?php echo $count_comm ?></td>
								</tr>
								</table>





								<!-- end of code for star rating!-->






							</figure>
							</div>
						</li>
			<?php
				}
		?>				
						
					</ul>
                    
					<!--<div class="info-keys icon"><?php echo $lang['Navigate with arrow keys'];?></div>-->
            </div>   
			
        <div id="photo_preview" style="display:none">
        <div class="photo_wrp">
            <img class="close" src="../images/closebox.png" />
            <div style="clear:both"></div>
            <div class="pleft">test1</div>
            <div class="pright">test2</div>
            <div style="clear:both"></div>
             </div>
                </div>
                    
					
				</section><!-- // slideshow -->
			</div><!-- // grid-gallery -->
			
            </div>
        </div>
    </div>
	
	<!-- Link scripts -->
    <script src="https://www.google.com/jsapi"></script>
    <script>
        google.load("jquery", "1.7.1");
    </script>
    <script src="js/script.js"></script>
	
		<script src="js/imagesloaded.pkgd.min.js"></script>
		<script src="js/masonry.pkgd.min.js"></script>
		<script src="js/classie.js"></script>
		<script src="js/cbpGridGallery.js"></script>
		<script>
			new CBPGridGallery( document.getElementById( 'grid-gallery' ) );
		</script>
<?php
		include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
	}
?>