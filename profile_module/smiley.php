<link href="<?php echo $base_url;?>assets/smiley/hangout/css/smilies.css" rel="stylesheet" type="text/css">
<link href="<?php echo $base_url;?>assets/smiley/smiley.php" rel="stylesheet" type="text/css">

<script type="text/javascript">
	    	$(function(){
	    		$('.tab').click(function(){
	    			$('.tab').removeClass('selected');
	    			$('.emojis').removeClass('emoji_selected');
	    			$(this).addClass('selected');
	    			$('.'+$(this).attr('id')).addClass('emoji_selected');
	    		});
				$(".container_body").css({height: '{$container_body_height}px', width: '100%'});
				
	
			});
		/*window.onload = function() { resizeTo(431,364); }
			window.onresize = function() { resizeTo(431,364); }*/
			

</script>
<?php 
include_once 'assets/smiley/includes/config_smiley.php';
function callback_space($m) // callback function remove all afetr dot and returns space instead
{
	$space="";
return $space;
}
$text = '';
$people_text = '';
$nature_text = '';
$objects_text = '';
$places_text = '';
$symbols_text = '';
foreach ($smileys as $pattern => $result) {	
		$pattern_class = str_replace("'","\\'",$pattern);
		$title = str_replace("-"," ",ucwords( preg_replace_callback("/\.(.*)/",'callback_space',$result)));
		$class = str_replace("-"," ", preg_replace_callback("/\.(.*)/",'callback_space',$result));
		if (in_array($result, $people)) {			
			$people_text .= '<span class="cometchat_smiley '.$class.' nature" title="'.$pattern.' ('.$title.')" style="padding:2px;" onClick="addsmiley(\''.$pattern_class.'\')"></span>';
		} elseif (in_array($result, $nature)) {
			$nature_text .= '<span class="cometchat_smiley '.$class.' nature" title="'.$pattern.' ('.$title.')" style="padding:2px;" onClick="addsmiley(\''.$pattern_class.'\')"></span>';
		} elseif (in_array($result, $objects)) {
			$objects_text .= '<span class="cometchat_smiley '.$class.' objects" title="'.$pattern.' ('.$title.')" style="padding:2px;" onClick="addsmiley(\''.$pattern_class.'\')"></span>';
		} elseif (in_array($result, $places)) {
			$places_text .= '<span class="cometchat_smiley '.$class.' places" title="'.$pattern.' ('.$title.')" style="padding:2px;" onClick="addsmiley(\''.$pattern_class.'\')"></span>';
		} elseif (in_array($result, $symbols)) {
			$symbols_text .= '<span class="cometchat_smiley '.$class.' symbols" title="'.$pattern.' ('.$title.')" style="padding:2px;" onClick="addsmiley(\''.$pattern_class.'\')"></span>';
		} else {
			$text .= '<img class="cometchat_smiley" width="20" height="20" src="'.$base_url.'images/smileys/'.$result.'" title="'.$pattern.' ('.$title.')"  style="padding:2px" onClick="addsmiley(\''.$pattern_class.'\')">';
		}	
}
?>
<div id="container_smilies" style="width:420px;left: 473px; display:none; position:absolute;z-index:100010;">
<div class="cometchat_container_title" onmousedown="dragStart(event, 'cometchat_container_smilies')"><span>Which smiley would you like?</span><div class="cometchat_closebox"></div><div style="display:none;" class="cometchat_maxwindow"></div><div style="display:none;" class="cometchat_popwindow"></div><div style="clear:both"></div></div>
<div class="cometchat_container_body" style="height:235px;width:418px;overflow-y: scroll;"><div class="cometchat_loading"></div>
		<div class="container">
			<div class="container_title embed">Which smiley would you like?</div>
			<div id="tabs">
			    <div id="people" class="tab selected"><h2>People</h2></div>
			    <div id="nature" class="tab "><h2>Nature</h2></div>
			    <div id="objects" class="tab "><h2>Objects</h2></div>
			    <div id="places" class="tab "><h2>Places</h2></div>
			    <div id="symbols" class="tab "><h2>Symbols</h2></div>			    
		    </div>
			<div class="container_body embed">
				<div class="people emojis emoji_selected" id="emoji-people"><?php echo $people_text; ?></div>
				<div class="nature emojis" id="emoji-nature"><?php echo $nature_text; ?></div>
				<div class="objects emojis" id="emoji-objects"><?php echo $objects_text; ?></div>
				<div class="places emojis" id="emoji-places"><?php echo $places_text; ?></div>
				<div class="symbols emojis" id="emoji-symbols"><?php echo $symbols_text; ?></div>				
			</div>
		</div>
</div>
</div>