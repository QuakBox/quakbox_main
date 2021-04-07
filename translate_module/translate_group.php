<?php 


 //$r_g=0;
 
  ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
	//$(document).ready(function()
	//{
	//alert(<?php echo $r_g ?>);
 

//alert("hi");
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
var text="<?php echo $title; ?>";
	  var lan =lan1;
		var idbd=id;
		var src = text;

		var type = 0;
			translate_group<?php echo $r_g;?>(idbd,g_token,src,type,lan);
			
			},    
    });

//print $r_gsp;
		//alert("demo");
		
		
		//}
//alert(<?php echo $r_g;?>);		
function translate_group<?php echo $r_g;?>(idbd,g_token,src1,type1,lan)
	{
		//alert("trnslate");
	 var language=lan;
	
	
		var post_id1=idbd;
		
		//alert(idbd);
		
		var src = src1;
		
		var p = new Object;
		var opt=type1;
		//alert(src);
    p.text = src;
    p.from = null;
    p.to = "" + language + "";
    //idbd = post_id1;  

    //alert(<?php echo $r_g;?> )  ;
    
    
	p.oncomplete = 'ajaxTranslateCallback_group<?php echo $r_g;?>';
	
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
	
	
	
	function ajaxTranslateCallback_group<?php echo $r_g;?> (response) 
	{ 
	
//alert("test");
	var type="<?php echo $type_gp;?>";
	//alert(<?php echo $r_g;?>);
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
	document.getElementById("tr_back_group<?php echo $r_g;?>").innerHTML = response;
	}
});
	}
	
</script>
 <div id="tr_back_group<?php echo $r_g;?>">
<?php $r_g++;?>	






















