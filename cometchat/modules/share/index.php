<?php
	include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules.php");
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php");
	if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
	        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>{$share_language[100]}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=module&name=share" />
		<script>
			var controlparameters = {"type":"modules", "name":"share", "method":"setTitle", "params":{}};
			controlparameters = JSON.stringify(controlparameters);
			parent.postMessage('CC^CONTROL_'+controlparameters,'*');
		</script>
		<script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f38dbd865c1cfe2"></script>
		<script type="text/javascript" src="../../js.php?type=core&name=jquery"></script>
		<script>
			jqcc(document).ready(function() {
				var controlparameters = {"type":"modules", "name":"share", "method":"getParentURL", "params":{}};
				controlparameters = JSON.stringify(controlparameters);
				if(typeof(parent) != 'undefined' && parent != null && parent != self){
					parent.postMessage('CC^CONTROL_'+controlparameters,'*');
				} else {
					window.opener.postMessage('CC^CONTROL_'+controlparameters,'*');
				}
			});
			var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
			var eventer = window[eventMethod];
			var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
			eventer(messageEvent,function(e) {
	    		if(typeof(e.data) != 'undefined' && typeof(e.data) == 'string') {
	    			if(e.data.indexOf('CC^CONTROL_')!== -1){
	    				var controlparameters = e.data.slice(11);
		                controlparameters = JSON.parse(controlparameters);
		                var theUrl = controlparameters.theUrl;
		                var title = controlparameters.title;
						addthis.toolbox(".addthis_toolbox", null, {title: title, url: theUrl});
	    			}
	    		}
	    	},false);
		</script>
	</head>

	<body>
		<div id="wrapper">
			<div class="addthis_toolbox addthis_32x32_style addthis_default_style">
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_google_plusone" g:plusone:count="false" g:plusone:annotation="none" style="margin-top:5px"></a>
				<a class="addthis_button_linkedin" title="LinkedIn"></a>
				<a class="addthis_button_stumbleupon"></a>
				<a class="addthis_button_reddit"></a>
				<a class="addthis_button_delicious"></a>
				<a class="addthis_button_digg" title="Digg This"></a>
				<a class="addthis_button_favorites" title="Bookmark this Page"></a>
			</div>
		</div>
		<style>
			.gc-reset {
				display: none !important;
			}
		</style>
	</body>
</html>