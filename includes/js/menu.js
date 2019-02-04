$(function($) {	

	$("#country_more").niceScroll();
	
	$(".connect_click").click(function () {
		var X = $(this).attr('id');
		if (X == 1) {
			$(".country_more").hide();
			$(this).attr('id', '0');
		}
		else {
			$(".country_more").show();
			$(this).attr('id', '1');
		}
	});
	$(".connect_click").mouseup(function () {
		return false
	});
	$(".search-form-dropdown li,.search-form-dropdown input").click(function(){
		return false;
	});
	$(document).on('click', '#search-icon', function(e){
		$('#search-menu').fadeToggle('fast');
	});
	
	$(document).on('keyup', '.search', function(e){
    			    	
	    	var txt=$.trim($(this).val());			    	
	    	if(txt!=''){				
			var ajaxurl=window.location.origin+"/ajax/acccept.php";
			var data = {item:"user",action:"search",s:txt};
		    		
		    	$.post(ajaxurl, data, function(response){						
				$(".divResult").html(response);
				if(response != ''){
					$('#divResult').html('<div class="search-result-layer">' + response + '</div>');
				} else {
					$('#divResult').html('');
				}
			});
		}
		else{
			$("#divResult").html('');	
		}						
						
				
			
		
	});
	var settings = $('#settings'),menu = $('#menu');
	settings.on('click', function () {
		fmenu.hide('fast');
		nmenu.hide('fast');
		menu.fadeToggle('fast');
						
	});
	var fRequest = $("#friendsRequest"),fmenu = $("#friendsReqMenu");
	
		
	fRequest.on('click', function () {
		menu.hide('fast');
		nmenu.hide('fast');
		var loadedcontent= fmenu.is(":visible");
		if(loadedcontent){
			fmenu.fadeToggle('fast');
			fmenu.html('');
		}
		else{		
			var ajaxurl=window.location.origin+"/ajax/acccept.php";
			var data = {item:"menu",action:"getFriendsList"};		    	
		    	$.post(ajaxurl, data, function(response){ 
		    		$("#request_count_wrapper").remove();   		
		    		fmenu.html(response);
		    		$('[data-toggle="tooltip"]').tooltip();
		    		fmenu.fadeToggle('fast');	
		    	});
	    	}
		
						
	});
	var vNotification= $("#viewNotification"),nmenu = $("#notificationMenuInner");
	vNotification.on('click', function () {
		menu.hide('fast');
		fmenu.hide('fast');
		var loadedcontent= nmenu.is(":visible");
		if(loadedcontent){
			nmenu.fadeToggle('fast');
			nmenu.html('');
		}
		else{		
			var ajaxurl=window.location.origin+"/ajax/acccept.php";
			var data = {item:"menu",action:"getNotificationList"};		    	
		    	$.post(ajaxurl, data, function(response){ 
		    		$("#notification_count_wrapper").remove();   		
		    		nmenu.html(response);
		    		$('[data-toggle="tooltip"]').tooltip();
		    		nmenu.fadeToggle('fast');	
		    	});
	    	}
		
						
	});


});