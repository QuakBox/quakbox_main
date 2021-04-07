<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
var lan1="hi";
var text1="hello";
call(lan1,text1);
function call(lan1,text1)
{
var g_token = '';
var lan =lan1;
var src = text1;
    var requestStr = "../token.php";
       $.ajax({
        url: requestStr,
        type: "GET",
        cache: true,
        dataType: 'json',
        success: function (data) {        
            g_token = data.access_token;
           	
        },
        complete: function(request, status) {
     
			translate12(g_token,src,lan);
			
			},    
    });

	
		}
		
function translate12(g_token,src1,lan)
	{
		 var language=lan;
	
		var src = src1;
		
		var p = new Object;
		
    p.text = src;
    p.from = null;
    p.to = "" + language + "";
    p.oncomplete = 'ajaxTranslate';
    p.appId = "Bearer " + g_token;
    //alert(p.appId );
    var requestStr = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate";
       $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: 'true',
       
		});
	}	
		
	function ajaxTranslate(response) { 
		
		 document.getElementById("target_tr").innerHTML = response;

	}
    
    </script>
    
    
    
    <div id="target_tr"></div>