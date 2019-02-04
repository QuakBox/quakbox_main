<?php 
/**
   * @package    assets
   * @subpackage 
   * @author     Vishnu
   * Created date  02/05/2015 
   * Updated date  03/13/2015 
   * Updated by    Vishnu S
 **/
require_once('../config.php');
include_once 'includes/config_smiley.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Smiley page</title>
<link href="smilies.css" rel="stylesheet" type="text/css">
<link href="hangout/css/smilies.css" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<style type="text/css">
.cometchat_smiley {
    cursor: pointer;
    float: left;
}
.cometchat_container_title {
    cursor: default;
    background-color: #102A8F !important;
    background-image: -moz-linear-gradient(center top , #617CDF, #3F5BBE);
    background-repeat: repeat;
    background-attachment: scroll;
    background-position: 0% 0%;
    background-clip: border-box;
    background-origin: padding-box;
    background-size: auto auto;
    border-left: 1px solid #102A8F;
    border-right: 1px solid #102A8F;
    border-top: 1px solid #102A8F;
    color: #FFF;
    font-family: Tahoma,Verdana,Arial,"Bitstream Vera Sans",sans-serif;
    font-size: 12px;
    line-height: 14px;
    padding: 5px 0px 6px 10px;
    font-weight: bold;
    text-shadow: 1px 1px 0px #3E5ABD;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}
.cometchat_closebox {
    background: url('images/cometchat.png') no-repeat scroll 4px -973px transparent;
    float: right;
    height: 12px;
    width: 20px;
    cursor: pointer;
    opacity: 0.5;
}
</style>
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
			window.onload = function() { resizeTo(431,364); }
			window.onresize = function() { resizeTo(431,364); }
			
			$(function() {
    $('#cometchat_container_smilies').css({
        'position' : 'absolute',
        'left' : '50%',
        'top' : '50%',
        'margin-left' : -$(this).width()/2,
        'margin-top' : -$(this).height()/2
    });
	
});
	    </script>
</head>

<body>

<?php 

$text = '';
$people_text = '';
$nature_text = '';
$objects_text = '';
$places_text = '';
$symbols_text = '';
$basepath_url=$base_url.'assets/smiley/';
define('BASE_URL',$basepath_url);
foreach ($smileys as $pattern => $result) {	
		$pattern_class = str_replace("'","\\'",$pattern);
		$title = str_replace("-"," ",ucwords(preg_replace_callback("/\.(.*)/",function($space){$space="";
	    return $space;
		},$result)));
		$class = str_replace("-"," ",preg_replace_callback("/\.(.*)/",function($space){
		$space="";
	    return $space;
		},$result));
		if (in_array($result, $people)) {			
			$people_text .= '<span class="cometchat_smiley '.$class.' nature" title="'.$pattern.' ('.$title.')" style="padding:2px;"></span>';
		} elseif (in_array($result, $nature)) {
			$nature_text .= '<span class="cometchat_smiley '.$class.' nature" title="'.$pattern.' ('.$title.')" style="padding:2px;"></span>';
		} elseif (in_array($result, $objects)) {
			$objects_text .= '<span class="cometchat_smiley '.$class.' objects" title="'.$pattern.' ('.$title.')" style="padding:2px;">
			</span>';
		} elseif (in_array($result, $places)) {
			$places_text .= '<span class="cometchat_smiley '.$class.' places" title="'.$pattern.' ('.$title.')" style="padding:2px;"></span>';
		} elseif (in_array($result, $symbols)) {
			$symbols_text .= '<span class="cometchat_smiley '.$class.' symbols" title="'.$pattern.' ('.$title.')" style="padding:2px;">
			</span>';
		} else {
			$text .= '<img class="cometchat_smiley" width="20" height="20" src="'.BASE_URL.'images/smileys/'.$result.'" title="'.$pattern.' ('.$title.')"  style="padding:2px">';
		}	
}
?>

<body style="overflow:scroll">
<div id="cometchat_container_smilies" style="width:420px;left: 473px;top: 1093px;">
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

</body>
</html>