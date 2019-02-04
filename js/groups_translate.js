var g_token = '';
var idbd = '';

setInterval(getToken, 1000);

function getToken() {

    var requestStr = "./token.php";
    $.ajax({
        url: requestStr,
        type: "GET",
        cache: true,
        dataType: 'json',
        success: function (data) {        
            g_token = data.access_token;
        }
    });
}

function translate(text, from, to, id, opt) {
    var p = new Object;
    p.text = text;
    p.from = from;
    p.to = to;
    idbd = id;    
    if (opt == 1) p.oncomplete = 'ajaxTranslateCallback';
    else if (opt == 2) p.oncomplete = 'postajaxTranslateCallback';
	else p.oncomplete = 'replyajaxTranslateCallback';
    p.appId = "Bearer " + g_token;
    var requestStr = "https://api.microsofttranslator.com/V2/Ajax.svc/Translate";
    $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: true
    });
}

function ajaxTranslateCallback(response) {    
    document.getElementById("target" + idbd).innerHTML = response;
    document.getElementById("target" + idbd).style.display = 'block';
}

function postajaxTranslateCallback(response) {
    document.getElementById("posttarget" + idbd).innerHTML = response;
    document.getElementById("posttarget" + idbd).style.display = 'block';
}

function replyajaxTranslateCallback(response) {
    document.getElementById("replytarget" + idbd).innerHTML = response;
    document.getElementById("replytarget" + idbd).style.display = 'block';
}


function translateSourceTarget(lang, id, opt) {
    if (opt == 1) var src = $("#source" + id).val();
	else if (opt == 2) var src = $("#postsource" + id).val();
    else var src = $("#replysource" + id).val();
    
    translate(src, null, "" + lang + "", id, opt);
}

function fillList(listOfLanguages, id, optionss) {
    if (optionss == 1) var ddlLangs = document.getElementById('langs' + id);
	else if (optionss == 2) var ddlLangs = document.getElementById('postlangs' + id);
    else var ddlLangs = document.getElementById('replylangs' + id);
    for (var key in listOfLanguages) {
        var optLang = document.createElement('option');
        optLang.innerHTML = listOfLanguages[key].Name;
        optLang.value = listOfLanguages[key].Code;
        ddlLangs.appendChild(optLang);
    }
}

function selectOption(optLang, id, opt) {
    if (optLang != "") {
        if (opt == 1) $("#translatemenu" + id).hide(300);
        else if (opt == 2) $("#posttranslatemenu" + id).hide(300);
		else $("#replytranslatemenu" + id).hide(300);
        translateSourceTarget(optLang, id, opt);
    }
}
$(document).ready(function () {
    $('.translateButton').click(function (event) {
        var ID = $(this).attr('id');
        var sid = ID.split("translateButton");
        var New_ID = sid[1];
        var optionss = 1;
        fillList(Microsoft.Translator.Widget.GetLanguagesForTranslateLocalized(), New_ID, optionss);        
        $('#translatemenu' + New_ID).toggle(300);
        event.stopPropagation();
    });
    $('.posttranslateButton').click(function (event) {
        var ID = $(this).attr('id');
        var sid = ID.split("posttranslateButton");
        var New_ID = sid[1];
        var optionss = 2;
        fillList(Microsoft.Translator.Widget.GetLanguagesForTranslateLocalized(), New_ID, optionss);
        console.log('click - form');
        $('#posttranslatemenu' + New_ID)[0].focus();
        $('#posttranslatemenu' + New_ID).toggle(300);
        event.stopPropagation();
    });
	
	$('.replytranslateButton').click(function (event) {
        var ID = $(this).attr('id');
        var sid = ID.split("replytranslateButton");
        var New_ID = sid[1];
        var optionss = 3;
        fillList(Microsoft.Translator.Widget.GetLanguagesForTranslateLocalized(), New_ID, optionss);        
        $('#replytranslatemenu' + New_ID).toggle(300);
        event.stopPropagation();
    });
	
    $('.posttranslatemenu').click(function (event) {        
        var ID = $(this).attr('id');
        var sid = ID.split("posttranslatemenu");
        var New_ID = sid[1];
        $('#postlangs' + New_ID).css('display', 'block');
        event.stopPropagation();
    });
	
	
	$('.replytranslatemenu').click(function (event) {        
        var ID = $(this).attr('id');
        var sid = ID.split("replytranslatemenu");
        var New_ID = sid[1];
        $('#replylangs' + New_ID).css('display', 'block');
        event.stopPropagation();
    });
	
	
	
});