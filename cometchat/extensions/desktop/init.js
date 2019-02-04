<?php

	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");

?>

/*
 * CometChat
 * Copyright (c) 2016 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){
	$.ccdesktop = (function () {
		var title = 'Desktop Extension';
        return {
			getTitle: function() {
				return title;
			},
			init: function() {
			},
			logout: function(){
				window.location.href='cometchat_login.php';
			},
			desktopNotify: function(image, message, uname, msgid){
    			var tempMsg = jqcc('<div>'+message+'</div>');
                jqcc.each(tempMsg.find('img.cometchat_smiley'),function(){
                     jqcc(this).replaceWith('*'+jqcc(this).attr('title')+'*');
                });
                message = tempMsg.text();
                if(image.indexOf('//')!=-1 && image.indexOf('//')==0 && image.indexOf('http://')==-1 && image.indexOf('https://')==-1){
                    image=window.location.protocol+image;
                }else if(image.indexOf('http://')==-1 && image.indexOf('https://')==-1){
                     image=window.location.protocol+'//'+window.location.host+image;
                }
                var controlparameters = {"type":"extensions", "name":"desktop", "method":"notification", "params":{"icon": image,"uname": uname, "message":message, "mid": msgid, "host_name": location.hostname, "host_protocol":location.protocol}};
                       controlparameters = JSON.stringify(controlparameters);
                parent.postMessage('CC^CONTROL_'+controlparameters,'*');
			}
        };
    })();
})(jqcc);