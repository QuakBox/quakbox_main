function translate12(idbd,g_token,src1,type1,lan)
	{
	//alert("translate");
	var language=lan;
	
	
		post_id=idbd;
		
		//alert(idbd);
		
		var src = src1;
		
		var p = new Object;
		var opt=type1;
		//alert(opt);
    p.text = src;
    p.from = null;
    p.to = "" + language + "";
    //idbd = post_id;  
    //alert(idbd )  ;
    if (opt == 1) p.oncomplete = 'ajaxTranslateCallback1';
    else if (opt == 2) p.oncomplete = 'postajaxTranslateCallback1';
	else p.oncomplete = 'replyajaxTranslateCallback1';
	     //p.oncomplete = 'ajaxTranslateCallback1';
    //alert(p.oncomplete );
    p.appId = "Bearer " + g_token;
    //alert(p.appId );
    var requestStr = "https://api.microsofttranslator.com/V2/Ajax.svc/Translate";
    //alert(requestStr );
    $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: 'true',
        complete: function(request, status) {
        
			
			//sleep(100);
			//setTimeout("hi", 5000);
			},
			
		
		});
	}	
		
	function ajaxTranslateCallback1(response) { 
 //idbd2=idbd1;
  
//alert(post_id); 
//alert(response);  
    document.getElementById("target1"+ post_id).innerHTML = response;
    document.getElementById("target1"+ post_id).style.display = 'block';
}

function postajaxTranslateCallback1(response) { 
 //idbd2=idbd1;
  
//alert(post_id); 
//alert(response);  
   document.getElementById("target12"+ post_id).innerHTML = response;
    document.getElementById("target12"+ post_id).style.display = 'block';
}