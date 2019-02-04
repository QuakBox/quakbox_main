<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/wall.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/group.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery.share.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/token-input.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/token-input-facebook.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/token-input-mac.css"/>
<link rel="stylesheet" href="<?php echo $base_url;?>assets/chosen-jquery/chosen.css" />
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.share.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.oembed.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.tokeninput.js"></script>

<script type="text/javascript">

function showHide() 
{
				
   if(document.getElementById("privacy").selectedIndex == 0) 
   {
	    
		document.getElementById("mvm").style.display = "block";// This line makes the DIV visible
		document.getElementById("hiddenIDForSelection").value = "0"; 
		document.getElementById("mvm1").style.display = "none"; 
	   	document.getElementById("mvm2").style.display = "none";
   }
   else if(document.getElementById("privacy").selectedIndex == 1) 
   {
	    	document.getElementById("mvm1").style.display = "block"; // This line makes the DIV visible
	    	document.getElementById("hiddenIDForSelection").value = "1"; 
		document.getElementById("mvm").style.display = "none";
	   	document.getElementById("mvm2").style.display = "none";
   }
   else if(document.getElementById("privacy").selectedIndex == 2)
   {            
       		document.getElementById("mvm2").style.display = "block";// This line makes the DIV visible
        	document.getElementById("hiddenIDForSelection").value = "2"; 
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm1").style.display = "none"; 
   }
   else if(document.getElementById("privacy").selectedIndex == 3)
   {            
        	document.getElementById("world").value = "world";
        	document.getElementById("hiddenIDForSelection").value = "3"; 
		document.getElementById("mvm2").style.display = "none";
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm1").style.display = "none";
 }
  
   
}

</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".cancel_custom").click(function() {
		$("#popup").hide();
	});

	$(".cancel_share").click(function() {
		$("#share_popup").hide();
		$(".share_body").children('div').remove();
	});
});
</script>
<style>
#share_popup{
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;	
	background-color: rgba(0,0,0,0.7); /*(255,255,255,0.5);*/
	color:#333;
}	

</style>
<div id="share_popup" class="share_popup" style="display:none;">
  <div id="custom_privacy"> 
    <div style="background:#085D93;padding:7px 5px; font-weight:normal;color:#fff;">
    <?php echo $lang['Share This'] ?>
    <input type="button" class="cancel_share close" title="Cancel share" aria-label="Close" name="submit" value="X" style="color:#fff;opacity:1;border:none;background:transparent;font-size: 15px; padding: 2px;font-weight:normal;" />    
    </div>
    <form action="<?php echo $base_url.'action/add_share-exec.php'; ?>"  method="post" id="shareform">
      <div style="padding:5px;">
        <div style="margin-bottom:10px;">
          <label style="float:left; font-size:12px; font-weight:bold; color:#085D93; margin-right:5px;padding-top:5px;"><?php echo $lang['Share With'] ?></label>
          <select name="privacy" id="privacy" onChange="showHide()" style="padding:5px;">
            <option value="2"><?php echo $lang['friend/s'] ?></option>
            <option value="3"><?php echo $lang['in a group']?></option>
            <option value="4"><?php echo $lang['In country/s']?></option>
            <option value="5"><?php echo $lang['The World']?></option>
          </select>
        </div>
        <div style="margin-bottom:10px; margin-top:10px;" id="mvm">
         
         <input type="text" name="friend_name" id="friend_name" class="friend_name" style="padding:5px; width:98%;" placeholder="<?php echo $lang['friends name'];?>">
        <script type="text/javascript">
        $(document).ready(function() {
       
            $("#friend_name").tokenInput("<?php echo $base_url;?>load_data/friends_names_ajax.php", {
                theme: "facebook",
                hintText: "<?php echo $lang['friends name'];?>"
                 
            });
        });
        </script>
        </div>
        
        <div style="margin-bottom:10px; margin-top:10px;" id="mvm1">
          <input type="text" name="group_name" id="group_name" class="group_name" style="padding:5px; width:95%;" placeholder="<?php echo $lang['Group Name']?>">
          
        <script type="text/javascript">
        $(document).ready(function() {
       		
            $("#group_name").tokenInput("<?php echo $base_url;?>load_data/group_names_ajax.php", {
                theme: "facebook",
                 hintText: "<?php echo $lang['Group Name'];?>"
                 
            });
        });
        </script>
        </div>
       
        <div id="mvm2" style="margin-bottom:10px; margin-top:10px; display:none;" >

        

<select name="countries[]" id="countries" data-placeholder="<?php echo $lang['Choose a Country'];?>..." class="chosen-select" multiple style="padding:5px; width:95%;"  tabindex="4">

<?php $favcountries_sql = mysqli_query($con, "select * from geo_country where country_id!=207 ") or die(mysqli_error($con));

while($favcountries_res = mysqli_fetch_array($favcountries_sql))

{

?>



<option value="<?php echo $favcountries_res['country_id'];?>"><?php echo $favcountries_res['country_title'];?></option>									



<?php } ?>    

</select>

</div>
<script src="<?php echo $base_url.'assets/chosen-jquery/chosen.jquery.js';?>"></script> 

<script type="text/javascript">

    var config = {

      '.chosen-select'           : {},

      '.chosen-select-deselect'  : {allow_single_deselect:true},

      '.chosen-select-no-single' : {disable_search_threshold:10},

      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},

      '.chosen-select-width'     : {width:"95%"}

    }

    for (var selector in config) {

      $(selector).chosen(config[selector]);

    }

  </script>  
       
<input type="hidden" name="world" id="world" value="" />
<input type="hidden" name="hiddenIDForSelection" id="hiddenIDForSelection" value="0" />
        <div>
          <div style="margin-bottom:5px;">
            <textarea name="share_status" id="share_status" style="width:95%;" placeholder="<?php echo $lang['Write Something']?>...."></textarea>
          </div>
          <div class="share_body"></div>
        </div>
      </div>
        
      <div id="mydiv3" style="padding:0px 5px;text-align:center;"></div>
      <div style="background:#085D93;padding:7px 5px;">
       <div style="float:right;">
          <input type="button"  id="shareSubmitButtonID" name="submit" value="<?php echo $lang['Share']?>" style="background:#fff; border:none; padding: 5px;" />
          <input type="button" class="cancel_share" name="submit" value="<?php echo $lang["Cancel"]?>"  style="background:#fff; border:none; padding: 5px;"  />
          <div style="clear:both;"></div>
        </div>
        <div style="clear:both;"></div>
      </div>
    </form>
  </div>
</div>

<!--
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
<script  type="text/javascript">
 $(document).ready(function() {
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
});
});
</script>

-->