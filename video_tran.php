<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>

 //alert(<?php //echo $_SESSION['last_id1']?>);
function ajaxTranslateCallback1(response) { 
	var type=1;
	var language1="bg";
	var post_id1="<?php echo $last_id1;?>";
	
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback11(response) { 
	
	var type=1;
	var post_id1="<?php echo $last_id1;?>";
	var language1="hi";
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;

	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback12(response) { 
	var language1="ar";
	var type=1;
	var post_id1="<?php echo $last_id1;?>";
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback13(response) { 
	var type=1;
	var language1="ca";
	var post_id1="<?php echo $last_id1;?>";
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback14(response) { 
	var language1="cs";
	var type=1;
	var post_id1="<?php echo $last_id1;?>";
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback15(response) { 
	var language1="da";
	var type=1;
	var post_id1="<?php echo $last_id1;?>";
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback16(response) { 
	var language1="nl";
	var type=1;
	var post_id1="<?php echo $last_id1;?>";
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback17(response) { 
	var language1="et";
	var type=1;
	var post_id1="<?php echo $last_id1;?>";
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback18(response) { 
	var language1="fi";
	var type=1;
	var post_id1="<?php echo $last_id1;?>";
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback19(response) { 
	var language1="fr";
	var type=1;
	var post_id1="<?php echo $last_id1;?>";
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback110(response) { 
	var language1="zh-CHS";
	var type=1;
	var post_id1="<?php echo $last_id1;?>";
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback111(response) { 
	var language1="zh-CHT";
	var type=1;
	var post_id1="<?php echo $last_id1;?>";
	//alert(language1);
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	
	
	function ajaxTranslateCallback112(response) { 
	var language1="de";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback113(response) { 
	var language1="el";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	
	function ajaxTranslateCallback114(response) { 
	var language1="ht";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	
	function ajaxTranslateCallback115(response) { 
	var language1="he";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	
	function ajaxTranslateCallback116(response) { 
	var language1="mww";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	
	function ajaxTranslateCallback117(response) { 
	var language1="hu";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback118(response) { 
	var language1="id";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	
	function ajaxTranslateCallback119(response) { 
	var language1="it";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	
	function ajaxTranslateCallback120(response) { 
	var language1="ja";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback121(response) { 
	var language1="tlh";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback122(response) { 
	var language1="ko";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback123(response) { 
	var language1="lv";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback124(response) { 
	var language1="lt";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback125(response) { 
	var language1="ms";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback126(response) { 
	var language1="mt";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	
	function ajaxTranslateCallback127(response) { 
	var language1="no";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback128(response) { 
	var language1="fa";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback129(response) { 
	var language1="pl";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback130(response) { 
	var language1="pt";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback131(response) { 
	var language1="ro";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback132(response) { 
	var language1="ru";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback133(response) { 
	var language1="sk";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback134(response) { 
	var language1="sl";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback135(response) { 
	var language1="es";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback136(response) { 
	var language1="sv";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback137(response) { 
	var language1="th";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback138(response) { 
	var language1="tr";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback139(response) { 
	var language1="uk";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback140(response) { 
	var language1="ur";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback141(response) { 
	var language1="vi";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	function ajaxTranslateCallback142(response) { 
	var language1="cy";
	var post_id1="<?php echo $last_id1;?>";
	var type=1;
	//alert(language1);
	
	var dataString1 = 'vara1=' + response + '&vara11=' + post_id1 + '&vara12=' + language1 + '&type5=' + type;
	var rqst="../translate_file1.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	
});
	}
	
	
	
	
	
	
var lan="<?php echo $language;?>";
var id="<?php echo $last_id1;?>";
var text="<?php echo $title;?>";

call1(lan,id,text);
function call1(lan,id,text)
{
var g_token = '';
		var lan =lan;
		var idbd=id;
		var src = text;

		var type = 1;
		
//alert(idbd);

//alert(src);

    var requestStr = "../token.php";
    //sleep(1000);
    $.ajax({
        url: requestStr,
        type: "GET",
        cache: true,
        dataType: 'json',
        success: function (data) {        
            g_token = data.access_token;
           
        	
		//alert(g_token);
			
        },
        complete: function(request, status) {
       // alert(status);
	   
			translate121(idbd,g_token,src,type,lan);
			
			},    
    });

//print $rsp;
		//alert("demo");
		
		
		}
		
function translate121(idbd,g_token,src1,type1,lan)
	{
		//alert("trnslate");
	 var language=lan;
	
	
		var post_id1=idbd;
		
		//alert(idbd);
		
		var src = src1;
		
		var p = new Object;
		var opt=type1;
		//alert(opt);
    p.text = src;
    p.from = null;
    p.to = "" + language + "";
    //idbd = post_id1;  

    //alert(idbd )  ;
    if(language=="hi") {p.oncomplete = 'ajaxTranslateCallback11';}
	else if (language=="ar") {p.oncomplete = 'ajaxTranslateCallback12';}
	else if (language=="ca") {p.oncomplete = 'ajaxTranslateCallback13';}
	else if (language=="cs") {p.oncomplete = 'ajaxTranslateCallback14';}
	else if (language=="da") {p.oncomplete = 'ajaxTranslateCallback15';}
	else if (language=="nl") {p.oncomplete = 'ajaxTranslateCallback16';}
	else if (language=="et") {p.oncomplete = 'ajaxTranslateCallback17';}
	else if (language=="fi") {p.oncomplete = 'ajaxTranslateCallback18';}
	else if (language=="fr") {p.oncomplete = 'ajaxTranslateCallback19';}
	else if (language=="zh-CHS") {p.oncomplete = 'ajaxTranslateCallback110';}
	else if (language=="zh-CHT") {p.oncomplete = 'ajaxTranslateCallback111';}
	else if (language=="bg") {p.oncomplete = 'ajaxTranslateCallback1';}
			
	else if (language=="de") {p.oncomplete = 'ajaxTranslateCallback112';}
	else if (language=="el") {p.oncomplete = 'ajaxTranslateCallback113';}
	else if (language=="ht") {p.oncomplete = 'ajaxTranslateCallback114';}
	
		
	else if (language=="he") {p.oncomplete = 'ajaxTranslateCallback115';}
	else if (language=="mww") {p.oncomplete = 'ajaxTranslateCallback116';}
	else if (language=="hu") {p.oncomplete = 'ajaxTranslateCallback117';}
	else if (language=="id") {p.oncomplete = 'ajaxTranslateCallback118';}
	else if (language=="it") {p.oncomplete = 'ajaxTranslateCallback119';}
	else if (language=="ja") {p.oncomplete = 'ajaxTranslateCallback120';}
	else if (language=="tlh") {p.oncomplete = 'ajaxTranslateCallback121';}
	else if (language=="ko") {p.oncomplete = 'ajaxTranslateCallback122';}
	else if (language=="lv") {p.oncomplete = 'ajaxTranslateCallback123';}
	else if (language=="lt") {p.oncomplete = 'ajaxTranslateCallback124';}
	else if (language=="ms") {p.oncomplete = 'ajaxTranslateCallback125';}
	else if (language=="mt") {p.oncomplete = 'ajaxTranslateCallback126';}
	else if (language=="no") {p.oncomplete = 'ajaxTranslateCallback127';}
	else if (language=="fa") {p.oncomplete = 'ajaxTranslateCallback128';}
	else if (language=="pl") {p.oncomplete = 'ajaxTranslateCallback129';}
	else if (language=="pt") {p.oncomplete = 'ajaxTranslateCallback130';}
	else if (language=="ro") {p.oncomplete = 'ajaxTranslateCallback131';}
	else if (language=="ru") {p.oncomplete = 'ajaxTranslateCallback132';}
	else if (language=="sk") {p.oncomplete = 'ajaxTranslateCallback133';}
	else if (language=="sl") {p.oncomplete = 'ajaxTranslateCallback134';}
	else if (language=="es") {p.oncomplete = 'ajaxTranslateCallback135';}
	else if (language=="sv") {p.oncomplete = 'ajaxTranslateCallback136';}
	else if (language=="th") {p.oncomplete = 'ajaxTranslateCallback137';}
	else if (language=="tr") {p.oncomplete = 'ajaxTranslateCallback138';}
	else if (language=="uk") {p.oncomplete = 'ajaxTranslateCallback139';}
	else if (language=="ur") {p.oncomplete = 'ajaxTranslateCallback140';}
	else if (language=="vi") {p.oncomplete = 'ajaxTranslateCallback141';}
	else if (language=="cy") {p.oncomplete = 'ajaxTranslateCallback142';}
	
    //alert(p.oncomplete );
    p.appId = "Bearer " + g_token;
    //alert(p.appId );
    var requestStr = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate";
    //alert(requestStr );
    $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: 'true',
        
			
		
		});
	}	
		
	
	
</script>




