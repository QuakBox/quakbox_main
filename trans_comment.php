<script>
       var idbd=$("#post_id<?php echo $row1['comment_id'];?>").val();

//alert(idbd);
       

		
		translate_demo();
		function translate_demo()
		{
		var g_token = '';
		//var idbd=$("#post_id<?php echo $row1['comment_id'];?>").val();


getToken();

function getToken() {

    var requestStr = "token.php";
    $.ajax({
        url: requestStr,
        type: "GET",
        cache: true,
        dataType: 'json',
        success: function (data) {        
            g_token = data.access_token;
		//alert(g_token);
		var language=$("#lan").val();
		var post_id=$("#post_id<?php echo $row1['comment_id'];?>").val();
		var type=1;
		var src = $("#source" + post_id).val();
		
		var p = new Object;
		var opt=type;
    p.text = src;
    p.from = null;
    p.to = "" + language + "";
    idbd = post_id;  
    //alert(idbd  )  ;
    if (opt == 1) p.oncomplete = 'ajaxTranslateCallback1';
    else if (opt == 2) p.oncomplete = 'postajaxTranslateCallback';
	else p.oncomplete = 'replyajaxTranslateCallback';
    p.appId = "Bearer " + g_token;
    //alert(p.appId );
    var requestStr = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate";
    $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: true
        
		});	
        }
    });
}
//print $rsp;
		//alert("demo");
		
		}
		
function ajaxTranslateCallback1(response) {  
 
//alert(idbd);  
    document.getElementById("target1" + idbd).innerHTML = response;
    document.getElementById("target1" + idbd).style.display = 'block';
}
		
		
		</script>