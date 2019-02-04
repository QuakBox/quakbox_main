var base_url  = "https://beta.quakbox.com/";
$(document).ready(function () {
//$("html").niceScroll({styler:"fb",cursorcolor:"#e8403f", cursorwidth: '3', cursorborderradius: '10px', background: '#404040', spacebarenabled:false, cursorborder: ''});

$("#mainbody").click(function () {
		$('#search-menu').hide();
		$('#menu').hide();
		$('#submenu1').hide();
		$('#submenu2').hide();
		$('#wallidid').hide();
});

$("#country_more").niceScroll();
//$("body").getNiceScroll().hide();
	var settings = $('#settings'),
		menu = $('#menu');
	settings.on('click', function () {
		menu.fadeToggle('fast');
		$('#search-menu').hide();
		$('#submenu1').hide();
		$('#submenu2').hide();
		$('#wallidid').hide();
	});
	var searchicon = $('#search-icon'),
		searchmenu = $('#search-menu');
	searchicon.on('click', function () {
		searchmenu.fadeToggle('fast');
		$('#menu').hide();
		$('#submenu1').hide();
		$('#submenu2').hide();
		$('#wallidid').hide();

	});
	$("div.image").mouseover(function () {
		$id = $(this).attr('title');
		document.getElementById($id).style.display = "";
	});
	$("div.image").mouseleave(function () {
		$id = $(this).attr('title');
		document.getElementById($id).style.display = "none";
	});
	$(".account").click(function () {
		var X = $(this).attr('id');
		if (X == 1) {
			$(".submenu").hide();
			$(this).attr('id', '0');
		}
		else {
			$(".submenu").show();
			$(this).attr('id', '1');
		}
	});
	$(".submenu").mouseup(function () {
		return false
	});
	$(".account").mouseup(function () {
		return false
	});
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
	$("#status_privacy").click(function () {
		var X = $(this).attr('id');
		if (X == 1) {
			$("#privacy_menu").hide();
			$(this).attr('id', '0');
		}
		else {
			$("#privacy_menu").show();
			$(this).attr('id', '1');
		}
	});
	$("#privacy_menu").mouseup(function () {
		return false
	});
	$("#status_privacy").mouseup(function () {
		return false
	});
	$("#privacy2").click(function () {
		var X = $(this).attr('id');
		if (X == 1) {
			$("#photo_privacy_menu").hide();
			$(this).attr('id', '0');
		}
		else {
			$("#photo_privacy_menu").show();
			$(this).attr('id', '1');
		}
	});
	$("#photo_privacy_menu").mouseup(function () {
		return false
	});
	$("#privacy2").mouseup(function () {
		return false
	});
	$("#privacy3").click(function () {
		var X = $(this).attr('id');
		if (X == 1) {
			$("#url_privacy_menu").hide();
			$(this).attr('id', '0');
		}
		else {
			$("#url_privacy_menu").show();
			$(this).attr('id', '1');
		}
	});
	$("#url_privacy_menu").mouseup(function () {
		return false
	});
	$("#privacy3").mouseup(function () {
		return false
	});
	$("#privacy4").click(function () {
		var X = $(this).attr('id');
		if (X == 1) {
			$("#video_privacy_menu").hide();
			$(this).attr('id', '0');
		}
		else {
			$("#video_privacy_menu").show();
			$(this).attr('id', '1');
		}
	});
	$("#video_privacy_menu").mouseup(function () {
		return false
	});
	$("#privacy4").mouseup(function () {
		return false
	});
	$(document).mouseup(function () {
		$("div.submenu").hide();
		$(".account").attr('id', ''); /*$(".country_more").hide();*/
		$(".connect_click").attr('id', '');
		$("#privacy_menu").hide();
		$("#status_privacy").attr('id', '');
		$("#photo_privacy_menu").hide();
		$("#privacy2").attr('id', '');
		$("#url_privacy_menu").hide();
		$("#privacy3").attr('id', '');
		$("#video_privacy_menu").hide();
		$("#privacy4").attr('id', '');
	});
});

function notification(maiid, divid) {
	if (document.getElementById(divid).style.display == 'none') {
		document.getElementById(divid).style.display = 'block'
		document.getElementById('submenu2').style.display = 'none';
		document.getElementById('wallidid').style.display = 'none';
	} else {
		document.getElementById(divid).style.display = 'none'
	}
}

function notification1(maiid, divid) {
	if (document.getElementById(divid).style.display == 'none') {
		document.getElementById(divid).style.display = 'block'
		document.getElementById('submenu1').style.display = 'none';
		document.getElementById('wallidid').style.display = 'none';
	} else {
		document.getElementById(divid).style.display = 'none'
	}
}

function notification2(maiid, divid) {
	if (document.getElementById(divid).style.display == 'none') {
		document.getElementById(divid).style.display = 'block';
		document.getElementById('submenu1').style.display = 'none';
		document.getElementById('submenu2').style.display = 'none';
	} else {
		document.getElementById(divid).style.display = 'none'
	}
}

$(function () {
count= $("#count").val();
	$(".search").on("keyup",function () {
		var inputSearch = $(this).val();
		var dataString = 'searchword=' + inputSearch;
		if (inputSearch != '') {
			$.ajax({
				type: "POST",
				url: base_url + "load_data/search.php",
				data: dataString,
				cache: false,
				success: function (html) {
				var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
				
					$("#divResult").html(html).show();
				}}
			});
		}
		return false;
	});
	jQuery("#divResult").click(function (e) {
		var $clicked = $(e.target);
		var $name = $clicked.find('.name').html();
		var decoded = $("<div/>").html($name).text();
		$('#search').val(decoded);
	});
	jQuery(document).click(function (e) {
		var $clicked = $(e.target);
		if (!$clicked.hasClass("search")) {
			jQuery("#divResult").fadeOut();
		}
	});
	$('#search').click(function () {
		jQuery("#divResult").fadeIn();
	});
	$('.accept_request').click(function (e) {
	//alert("hello");
	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
	
		var ID = $(this).attr("id");
		
		
		var dataString = 'member_id=' + ID;
		$.ajax({
			type: "POST",
			url: base_url + "action/accept_request_ajax.php",
			data: dataString,
			cache: false,
			success: function (html) {
			var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
			
				$("#friends1"+ID).hide();
				$("#friends"+ID).show();
				$("#fri"+ID).hide();
				$("#friend"+ID).show();
				
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
		
	});
	$('.cancel_request').click(function (e) {	
	e.preventDefault();
if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click

		var ID = $(this).attr("id");
		var dataString = 'member_id=' + ID;
		$.ajax({
			type: "POST",
			url: base_url + "action/delete_request_ajax.php",
			data: dataString,
			cache: false,
			success: function (html) {
			var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
			
				$("#friends1"+ID).hide();
				$("#mini-profile"+ID).hide();
				if(count<=1)
				{
				$("#community").show();
			}
			count--;
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
	});
	$('#notifi_count').click(function (e) {
	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


		$.ajax({
			type: "POST",
			url: base_url + "action/notifi_count.php",
			cache: false,
			success: function (html) {
			var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
			
				$("#notifi_count_wrapper").hide();
			}}
		});
		$('#search-menu').hide();
		$('#menu').hide();
		$('#submenu1').hide();
		$('#submenu2').hide();
		// Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
		
	});
	$('#notifi_msg').click(function (e) {
	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


		$.ajax({
			type: "POST",
			url: base_url + "action/notifi_msg.php",
			cache: false,
			success: function (html) {
			var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
			
				$("#msg_count_wrapper").hide();
			}}
		});
		$('#search-menu').hide();
		$('#menu').hide();
		$('#submenu1').hide();
		$('#wallidid').hide();
		// Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
	});
	$('#notifi_request').click(function (e) {
	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click


		$.ajax({
			type: "POST",
			url: base_url + "action/notifi_request.php",
			cache: false,
			success: function (html) {
			var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
			
				$("#request_count_wrapper").hide();
			}}
		});
		$('#search-menu').hide();
		$('#menu').hide();
		$('#submenu2').hide();
		$('#wallidid').hide();
		// Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
	});
});