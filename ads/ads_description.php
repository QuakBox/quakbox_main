<script>
	//$(document).ready(function()
	//{
	//alert(<?php echo $r ?>);
 


//call_back1(lan,id,text);
//function call_back1(lan,id,text)
//{
var g_token = '';
		
		
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
        //alert(status);
        var lan1="<?php echo $_SESSION['lang'];?>";
var id="<?php echo $last_id;?>";
var  text="<?php echo $description; ?>";
	 //alert(text);
	  var lan =lan1;
		var idbd=id;
		var src = text;

		var type = 2;
			translate_description121<?php echo $r;?>(idbd,g_token,src,type,lan);
			
			},    
    });

//print $rsp;
		//alert("demo");
		
		
		//}
		
function translate_description121<?php echo $r;?>(idbd,g_token,src1,type1,lan)
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
    
    
	p.oncomplete = 'ajaxTranslateCallback_description1<?php echo $r;?>';
	
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
		
	//});
	
	function ajaxTranslateCallback_description1<?php echo $r;?>(response) { 

	var type=2;
	
	var language1="<?php echo $_SESSION['lang'];?>";
	var post_id1="<?php echo $last_id;?>";
	//alert(<?php echo $z;?>);
	//alert(response);
	//alert(language1);
	var dataString1 = 'vara=' + response + '&vara1=' + post_id1 + '&vara2=' + language1 + '&type=' + type;
	var rqst="../translate_title.php";
	$.ajax({
    url: rqst, // current page
    type: 'POST',
    data: dataString1,
	success:function()
	{
	//alert(response);
	document.getElementById("tr_description_ads<?php echo $r;?>").innerHTML = response;
	}
});
	}
	
</script>
 <div id="tr_description_ads<?php echo $r;?>">
<?php $r++;?>	

<?php //echo "hi"; ?>




















