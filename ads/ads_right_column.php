<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(document).on("click", '.ads_like', function (e) {
            <?php
            if(!isset($_SESSION['SESS_MEMBER_ID']))
            ?>
            //window.location.assign("<?php echo $base_url;?>login.php");
            e.preventDefault();

            if (!$(this).data('isClicked')) {
                var link = $(this);

                // Your code on successful click
                var ID = $(this).attr("id");
                var sid = ID.split("like_ads");
                var New_ID = sid[1];
                var REL = $(this).attr("rel");
                var URL = '<?php echo $base_url;?>load_data/ads_like_ajax.php';
                var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
                $.ajax({
                    type: "POST",
                    url: URL,
                    data: dataString,
                    cache: false,
                    success: function (html) {
                        if (html == 'expired') {
                            window.location.assign("<?php echo $base_url;?>login.php");
                        }
                        else {


                            if (REL == 'Like') {
                                $("#youlike" + New_ID).slideDown('slow').prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?><?php echo $lang['like this'];?>.</span>.");
                                $("#ads_likes" + New_ID).prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?>, </span>");
                                $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                            } else {
                                $("#youlike" + New_ID).slideUp('slow');
                                $("#you" + New_ID).remove();
                                $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>').html('<?php echo $lang['Like'];?>');
                            }
                            if (html > 0) {
                                $("#likes" + New_ID).show();
                            } else {
                                $("#likes" + New_ID).hide();
                            }
                            $("#ads_like_count" + New_ID).html(html);
                        }
                    }
                });
                // Set the isClicked value and set a timer to reset in 3s
                link.data('isClicked', true);
                setTimeout(function () {
                    link.removeData('isClicked')
                }, 3000);
            } else {
                // Anything you want to say 'Bad user!'
            }
            return false;
        });
    });

    $(window).scroll(function () {

        if ($(window).scrollTop() > 300) {

            $("#ads_1").hide();
            $("#ads_2").hide();


            $(".column_right").stop().css({
                "marginTop": ($(window).scrollTop()) + "px",
                "marginLeft": ($(window).scrollLeft()) + "px"
            }, "slow");
        }
        if ($(window).scrollTop() < 300) {

            $("#ads_1").show();
            $("#ads_2").show();

            $(".column_right").stop().css({
                "marginTop": ($(window).scrollTop()) + "px",
                "marginLeft": ($(window).scrollLeft()) + "px"
            }, "slow");
        }

    });
</script>
<?php

if(isset($_SESSION['lang']))
	{	
		include('common.php');
		//include('../common.php');
	}
	else
	{
		include('Languages/en.php');
		//include('../Languages/en.php');
		
	}
	include_once('config.php');
	?>
<div class="column_right">
<div class="column_internal_right-inner">
 <div id="ads">
   <h3><?php echo $lang['Partners'];?>
   <a href="add_ads.php"><?php echo $lang['Create Ads'];?></a>   
   </h3>
   </div>
   <div class="ads-wrapper">
   <?php
   $ad=0;
   $random_id = rand(1,3); 
   $ads_sql = mysqli_query($con, "select * from ads where ads_pic!='' order by rand() LIMIT 3");
   while($ads_res = mysqli_fetch_array($ads_sql))
   {
	  // print_r($ads_res);
   ?>
      
	<div class="ads-main" id="ads_<?php echo ++$ad;?>">
        <div class="ads-title">
        <a href="<?php echo $ads_res['url'];?>"><?php echo $ads_res['ads_title'];?></a>
        </div>
        <div class="ads-content">        
        <a href="<?php echo $ads_res['url'];?>" target="_blank">
        <img src="<?php echo $base_url.$ads_res['ads_pic'];?>"/>
        </a>
         <div class="ads-description">
        <?php echo $ads_res['ads_content'];?>
        </div>
               
        <?php 

$ads_like_sql = mysqli_query($con, "SELECT * FROM ads_like WHERE ads_id='". $ads_res['ads_id'] ."'");
$ads_like_count = mysqli_num_rows($ads_like_sql);
?>
 <div class="commentPanel" id="likes<?php echo $ads_res['ads_id'];?>" style="display:<?php if($ads_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<div class="likeUsers" id="ads_elikes<?php echo $ads_res['ads_id'];?>">
<a href="ads_likes.php?id=<?php echo $ads_res['ads_id'];?>" class="show_cmt_linkClr" data-toggle="modal" data-target="#myModal"><span id="ads_like_count<?php echo $ads_res['ads_id'];?>"><?php echo $ads_like_count;?></span> <?php echo $lang['people'];?></a> <?php echo $lang['like this'];?>.</div></div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 
</div><!-- /.modal -->
<?php
$q1 = mysqli_query($con, "SELECT * FROM ads_like WHERE member_id='". $member_id ."' and ads_id='".$ads_res['ads_id']."' ");

if(mysqli_num_rows($q1) <= 0)
{
?>     
          <a href="javascript: void(0)" class="ads_like" id="like_ads<?Php echo $ads_res['ads_id'];?>" title="<?Php echo $lang['Like'];?>" rel="Like"><?Php echo $lang['Like'];?></a>
          
          <?php } else
		  {?>         
                
          <a href="javascript: void(0)" class="ads_like" id="like_ads<?Php echo $ads_res['ads_id'];?>" title="<?Php echo $lang['Unlike'];?>" rel="Unlike"><?Php echo $lang['Unlike'];?></a>
          
<?php } ?>
        </div>
        </div>
       
       
     <?php 
   }
	 ?>
	 </div>
       </div>
</div>