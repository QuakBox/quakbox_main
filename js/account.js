// JavaScript Document
$(function()
{
$("#change_name").click(function(){	
	$("#li_change_name").addClass("openPanel");	
});


$("#change_lname").click(function(){	
	$("#li_change_lname").addClass("openPanel");	
});

$("#change_username").click(function(){	
	$("#li_change_username").addClass("openPanel");
});

$("#change_email").click(function(){	
    $("#li_change_email").addClass("openPanel");
});

$("#change_password").click(function(){	
    $("#li_change_password").addClass("openPanel");
});

$("#change_lang").click(function(){	
    $("#li_change_lang").addClass("openPanel");
});
$("#change_name_cancel").click(function(){		
    $(".SettingsListItem").removeClass("openPanel");
});

$("#change_mname_cancel").click(function(){		
    $(".SettingsListItem").removeClass("openPanel");
});

$("#change_lname_cancel").click(function(){		
    $(".SettingsListItem").removeClass("openPanel");
});

$("#change_username_cancel").click(function(){		
    $(".SettingsListItem").removeClass("openPanel");
});

$("#change_email_cancel").click(function(){		
    $(".SettingsListItem").removeClass("openPanel");
});

$("#change_password_cancel").click(function(){		
    $(".SettingsListItem").removeClass("openPanel");
});

$("#change_lang_cancel").click(function(){		
    $(".SettingsListItem").removeClass("openPanel");
});


	
});