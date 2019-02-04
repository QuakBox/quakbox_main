<script type="text/javascript">
var lastIdForScrolling = null;
$(document).ready(function() {
if(lastIdForScrolling!=null){
var adNextLimit = lastIdForScrolling + 1;

	var s = $("#ads_"+adNextLimit);
	var pos = s.position();		   
	$(window).scroll(function() {
	
		var windowpos = $(window).scrollTop();
		//s.html("Distance from top:" + pos.top + "<br />Scroll position: " + windowpos);
		if (windowpos >= pos.top) {
		$('.column_internal_right').addClass("clearDiv");
		$('.column_internal_right').addClass("fixed");
		
		var i = 1;
		while (i <= lastIdForScrolling) 
		{
  		$("#ads_"+i).hide();
    		i++;
		}
			
		} else {
		$('.column_internal_right').removeClass("fixed");
		$('.column_internal_right').removeClass("clearDiv");
		var i = 1;
		while (i <= lastIdForScrolling) 
		{
  		$("#ads_"+i).show();
    		i++;
		}
				
		}
		$('#myModal').on('hidden.bs.modal', function() {
    $(this).removeData('bs.modal');
});
	});
}
});

/*
$(window).scroll(function(){
if($(window).scrollTop()>762)
{

$("#ads_1").hide();
$("#ads_2").hide();
$("#ads_3").hide();
//$(".column_internal_right").stop().css({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "slow" );
$('.column_internal_right').addClass('fixed');
}
else
//if($(window).scrollTop()<dynamicHeight)
{

$("#ads_1").show();
$("#ads_2").show();
$("#ads_3").show();
//$(".column_internal_right").stop().css({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "slow" );
$('.column_internal_right').removeClass('fixed');
} 
$('#myModal').on('hidden.bs.modal', function() {
    $(this).removeData('bs.modal');
});
});*/
</script>
<div class="column_internal_right" id="column_internal_right">
 <div id="ads">
   <h3><?php echo $lang['Partners']; ?>
   <a href="<?php echo $base_url; ?>add_ads.php"><?php echo $lang['Create Ads']; ?></a>   
   </h3>
   </div>
   <div class="ads-wrapper">
   <?php 
   $s=0;
   $r=0;
   $ad_count=0;
   $ads_sql = mysqli_query($con, "select * from ads order by ads_id");
   $totalCount= mysqli_num_rows($ads_sql);
   $NewtotalCount= $totalCount -2;
   ?>
   <script>
    var lastIdForScrolling = <?php echo $NewtotalCount; ?>;
   </script>
   <?php
   while($ads_res = mysqli_fetch_array($ads_sql))
   {
   
   
   ?>
      
	<div class="ads-main" id="ads_<?php echo ++$ad_count;?>">
        <div class="ads-title">
        <a  target="_blank" href="<?php echo $ads_res['url'];?>">
         <?php
       // echo $_SEESION['lang'];
         if(isset($_SESSION['lang'])&&($_SESSION['lang']!='en'))
		 {
		$res=mysqli_query ($con, "select * from ads_title  where ads_id = '".$ads_res['ads_id']."' and  lang = '".$_SESSION['lang']."'");		
             $result=mysqli_fetch_array($res);
              $count=mysqli_num_rows($res);
		//echo $count; 
             if($count > 0)
             {
               echo $result['data'];
              }
              else
              {
             // echo $s;
				  $last_id = $ads_res['ads_id'];
				  $title = $ads_res['ads_title'];
			     include "ads_title.php";
			     $s++;
			  }
		 }
		 else
		 {
		echo $ads_res['ads_title'];
		 }
		 
		 ?>
        
        
        </a>
        
        </div>
        <div class="ads-content">        
        <a href="<?php echo $ads_res['url'];?>" target="_blank">
        <img src="<?php echo $base_url.$ads_res['ads_pic'];?>"/>
        </a>
         <div class="ads-description">
        <?php
       // echo $_SEESION['lang'];
         if(isset($_SESSION['lang']))
		 {
		$res=mysqli_query ($con, "select * from ads_description  where ads_id = '".$ads_res['ads_id']."' and  lang = '".$_SESSION['lang']."'");		
             $result=mysqli_fetch_array($res);
              $count=mysqli_num_rows($res);
		//echo $count; 
             if($count > 0)
             {
               echo $result['data'];
              }
              else
              {
             // echo $s;
				  $last_id = $ads_res['ads_id'];
				  $description = $ads_res['ads_content'];
			     include "ads_description.php";
			     $r++;
			  }
		 }
		 else
		 {
		echo $ads_res['ads_content'];
		 }
		 
		 ?>
        
        </div>
               
        <?php 

$ads_like_sql = mysqli_query($con, "SELECT * FROM ads_like WHERE ads_id='". $ads_res['ads_id'] ."'");
$ads_like_count = mysqli_num_rows($ads_like_sql);
?>
 <div class="commentPanel" id="likes<?php echo $ads_res['ads_id'];?>" style="display:<?php if($ads_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<div class="likeUsers" id="ads_elikes<?php echo $ads_res['ads_id'];?>">
<a href="ads_likes.php?id=<?php echo $ads_res['ads_id'];?>" class="show_cmt_linkClr" data-toggle="modal" data-target="#myModal"><span id="ads_like_count<?php echo $ads_res['ads_id'];?>"><?php echo $ads_like_count;?></span> <?php echo $lang['people'];?></a> <?php echo $lang['like this'];?>.</div></div>

<?php
$q1 = mysqli_query($con, "SELECT * FROM ads_like WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and ads_id='".$ads_res['ads_id']."' ");

if(mysqli_num_rows($q1) <= 0)
{
?>    

 
          <a href="javascript: void(0)" class="ads_like show_cmt_linkClr" id="like_ads<?Php echo $ads_res['ads_id'];?>" title="<?php echo $lang['like']; ?>" rel="Like"><?php echo $lang['like']; ?></a>
          
          <?php } else
		  {?>         
                
          <a href="javascript: void(0)" class="ads_like show_cmt_linkClr" id="like_ads<?Php echo $ads_res['ads_id'];?>" title="<?php echo $lang['Unlike']; ?>" rel="Unlike"><?php echo $lang['Unlike']; ?></a>
          
<?php } ?>
        </div>
        </div>
       
       
     <?php 

   }
	 ?>
	 </div>
       </div>
       

	<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 
</div><!-- /.modal -->