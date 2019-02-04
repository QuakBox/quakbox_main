<meta charset="utf-8">
<meta name="google-translate-customization" content="8b141b4044eaadae-34d0daded713c076-gf3a3a33322f73d44-10"></meta>
<meta http-equiv="X-UA-Compatible" content="IE=edge">   

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/wall.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/group.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/search.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/youtube.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/video-js.css">
<link href="<?php echo $base_url;?>css/videojs.addThis.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery.share.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/memberprofile.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>assets/jquery-alert-dialogs/css/jquery.alerts.css"/>
<link rel="icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="shortcut icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/keyboard.css"/>
<link rel="stylesheet" href="<?php echo $base_url;?>assets/chosen-jquery/chosen.css">
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-facebook.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-mac.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/bootstrap-theme.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/about.css" />
<!--external js file-->
<script src="<?php echo $base_url;?>js/modernizr.custom.91332.js"></script>
<script src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script src="<?php echo $base_url;?>js/selectivizr.js"></script>
<script src="<?php echo $base_url;?>js/html5shiv-printshiv.js"></script>
<script src="<?php echo $base_url;?>js/respond.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/ibox2.2.js"></script>
<!--<script src="https://www.microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>-->
<script src="<?php echo $base_url;?>js/jquery.form.js"></script>
<script src="<?php echo $base_url;?>js/jquery.livequery.js" type="text/javascript"></script>
<script src="<?php echo $base_url;?>js/jquery.oembed.js"></script>
<script src="<?php echo $base_url;?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.share.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/jquery-alert-dialogs/js/jquery.alerts.js"></script>
<!--<script type="text/javascript" src="<?php echo $base_url;?>js/keyboard.js"></script>-->
<!--common scripts for all wall pages-->
<script src="<?php echo $base_url;?>js/translate.js"></script>
<?php 
  //include "js/wall-js.php";
 ?>

<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.tokeninput.js"></script>
<script src="/js/wall.js"></script>
<script src="<?php echo $base_url;?>js/page-refresh.js"></script>
<script src="<?php echo $base_url;?>js/common-scripts.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/autocomplete.js"></script>





<!--video player files -->
<link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/videoPlayerMain.css" type="text/css">
  <link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/videoPlayer.theme1.css" type="text/css">
  <link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/preview.css" type="text/css" media="screen"/>

  
  <script src="<?php echo $base_url;?>video-ads/js/IScroll4Custom.js" type="text/javascript"></script>
  <script src='<?php echo $base_url;?>video-ads/js/THREEx.FullScreen.js'></script>
  <script src="<?php echo $base_url;?>video-ads/js/videoPlayer.js" type="text/javascript"></script>
  <script src="<?php echo $base_url;?>video-ads/js/Playlist.js" type="text/javascript"></script> <!--video player files -->
  <script src="<?php echo $base_url;?>js/check.js"></script>
   
<script >
$('.like').live("click", function (e) {

	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
 
        var ID = $(this).attr("id");
        
        var sid = ID.split("like");
        
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        
        var URL = '<?php echo $base_url;?>load_data/message_like_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
	    dataType: 'json',
            success: function (html,status) {
            
             //var json = jQuery.parseJSON(html) ;
            
            
         	var likecount = html.likecount;
         	//alert(likecount);
                var dislikecount = html.dislikecount;
                
                if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
				
                if (REL == 'Like') {
					if(likecount == 1) {
					
						$("#likes" + New_ID).prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?> </span>");
						
					}
					if(likecount == 2) {
						$("#likes" + New_ID).prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?> <?php echo $lang['and'];?></span>");
					}
					if(likecount > 2){
						$("#likes" + New_ID).prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?>, </span>");
					}
					
                                        
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                } else {
                    $("#youlike" + New_ID).slideUp('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>').html('<?php echo $lang['Like'];?>');
                }
				
				if (dislikecount > 0) {					
                    $('#postdislikecount' + New_ID).html(dislikecount);
                } else {
                    $('#postdislike_container' + New_ID).fadeOut('fast');
                }
				
				if (likecount > 0) {
                    $('#likes' + New_ID).fadeIn('fast');
                } else {
                    $('#likes' + New_ID).fadeOut('fast');
                }}
            },
             error: function (jqXHR, textStatus, errorThrown) {
             
            if (typeof errorFn !== 'undefined') {
                errorFn(jqXHR, textStatus, errorThrown);
            }
        },
             complete: function (html,status)
             {   
            
             }
        });
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
        
    });
	
	//post dislike 
	$('.post_dislike').live("click", function (e) {
	
	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
	
        var ID = $(this).attr("id");
        var sid = ID.split("post_dislike");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/post_dislike_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
            
          
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
                $("#you" + New_ID).remove();
                $('#like' + New_ID).html('<?php echo $lang['Like'];?>').attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>');
                $("#postdislike_container" + New_ID).fadeIn('slow');
                
                if (dislikecount > 0) {					
                    $('#postdislikecount' + New_ID).html(dislikecount);
                } else {
                    $('#postdislike_container' + New_ID).fadeOut('fast');
                } 
				if (likecount > 0 ) {
                    //$('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#likes' + New_ID).fadeOut('fast');
                }               
            }},
             error: function (jqXHR, textStatus, errorThrown) {
             alert(textStatus);
            if (typeof errorFn !== 'undefined') {
                errorFn(jqXHR, textStatus, errorThrown);
            }
        },
            
            
            
        });
        
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
    });
	
    $('.comment_dislike').live("click", function (e) {
  <?php 

	
	 if(!isset($_SESSION['SESS_MEMBER_ID']))
		
	?>
		//window.location.assign("<?php echo $base_url;?>login.php");
	  	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        var ID = $(this).attr("id");
        var sid = ID.split("comment_dislike");
        //alert(sid);
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/comment_dislike_ajax.php';
        var dataString = 'comment_id=' + New_ID + '&rel=' + REL;
        //alert("dislike");
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
            //alert(data);
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
               //alert(likecount);
               //alert(dislikecount);
                $("#you" + New_ID).remove();
                $('#comment_like' + New_ID).html('<?php echo $lang['Like'];?>').attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>');
                $("#dislikecout_container" + New_ID).fadeIn('slow');
                $('#dislikecout' + New_ID).html(dislikecount);
                $('#commentlikecount' + New_ID).html(likecount);
                //alert(likecount);
                if (dislikecount > 0) {
                    $('#dislikecout' + New_ID).html(dislikecount);
                    //$("#clike" + New_ID).hide('slow');
                    //alert(dislikecount);
                } else {
                    $('#dislikecout_container' + New_ID).fadeOut('slow');
                     //alert(dislikecount);
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else  {
                    //$('#commentlikecout_container' + New_ID).fadeOut('slow');
                    $("#clike" + New_ID).hide('slow');
                }
            }}
        });
        
         // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
        
    });
    $('.comment_like').die('click').live("click", function (e) {
   <?php 

	
	 if(!isset($_SESSION['SESS_MEMBER_ID']))
		
	?>
		//window.location.assign("<?php echo $base_url;?>login.php");
   	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        var ID = $(this).attr("id");
        var sid = ID.split("comment_like");
        var New_ID = sid[1];
        var msg_id = $(this).attr("msg_id");
        var comma = "";
        var youcount = $("#commacount" + New_ID).val();
        //alert(ID);
        if (youcount > 0) {
            comma = ", ";
        }
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/comment_like_ajax.php';
        var dataString = 'comment_id=' + New_ID + '&rel=' + REL + '&msg_id=' + msg_id;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: "json",
            success: function (data) {
           
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
                
                if (REL == 'Like') {
                    $("#clike" + New_ID).show('slow').prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?>" + comma + "</span>");
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                } else {
                    if (youcount == 0) $("#clike" + New_ID).hide('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>').html('<?php echo $lang['Like'];?>');
                }
                if (dislikecount > 0) {
                    $('#dislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#dislikecout_container' + New_ID).fadeOut('slow');
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }
            }}
        });
        
         // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
    });
	//reply dislike function
	$('.reply_dislike').live("click", function (e) {
	<?php 

	
	 if(!isset($_SESSION['SESS_MEMBER_ID']))
		
	?>
		//window.location.assign("<?php echo $base_url;?>login.php");
        e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        
        var ID = $(this).attr("id");
        var sid = ID.split("reply_dislike");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/reply_dislike_ajax.php';
        var dataString = 'reply_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                
                 if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
                $("#you" + New_ID).remove();
                $('#reply_like' + New_ID).html('<?php echo $lang['Like'];?>').attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>');
                $("#rdislikecout_container" + New_ID).fadeIn('slow');
                $('#rdislikecout' + New_ID).html(dislikecount);
                //$('#commentlikecount' + New_ID).html(likecount);
                if (dislikecount > 0) {
                    $('#rdislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#rdislikecout_container' + New_ID).fadeOut('slow');
                }
                /*if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }*/
            }}
        });
        
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
    });
	
	//reply like function
    $('.reply_like').live("click", function (e) {
  
		//window.location.assign("<?php echo $base_url;?>login.php");
        e.preventDefault();
   
if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        <?php 

	
	 if(!isset($_SESSION['SESS_MEMBER_ID']))
		
	?>
        var ID = $(this).attr("id");
        var sid = ID.split("reply_like");
        var New_ID = sid[1];        
        
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/reply_like_ajax.php';
        var dataString = 'reply_id=' + New_ID + '&rel=' + REL ;
		var comma = "";
        var youcount = $("#rcommacount" + New_ID).val();
        if (youcount > 0) {
            comma = ", ";
        }
       
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: "json",
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
		 if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {		                
          	 if (REL == 'Like') {
          	alert('like');
                    $("#rlike" + New_ID).show('slow').prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?>" + comma + "</span>");                
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                
                } else {
                    if (youcount == 0) $("#rlike" + New_ID).hide('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>').html('<?php echo $lang['Like'];?>');
                }
                if (dislikecount > 0) {
                    $('#rdislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#rdislikecout_container' + New_ID).fadeOut('slow');
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }
            }}
        });
        
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
    });
    $('.ads_like').live("click", function (e) {
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
             if(html=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
            
            
                if (REL == 'Like') {
                    $("#youlike" + New_ID).slideDown('slow').prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?><?php echo $lang['like this'];?>.</span>.");
                    $("#ads_likes" + New_ID).prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?>, </span>");
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                } else {
                    $("#youlike" + New_ID).slideUp('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>').html('<?php echo $lang['Like'];?>');
                }
                if(html > 0){
					$("#likes" + New_ID).show();                
                }else {
					$("#likes" + New_ID).hide();
                }
				$("#ads_like_count" + New_ID).html(html);
            }}
        });
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
    });
</script>
<style>
.vjs-control.vjs-tweet-button:before {
        content:url(<?php echo $base_url;?>images/watermark.png);
}
</style>
 