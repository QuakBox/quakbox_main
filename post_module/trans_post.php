<input id="lan1" value="<?php echo $_SESSION['lang'];?>" type="hidden" />
<input id="post_id1<?php echo $row['messages_id'];?>" value="<?php echo $row['messages_id'];?>" type="hidden" />

<script >
       var idbd=$("#post_id1<?php echo $row['messages_id'];?>").val();

//alert(idbd);
		
		translate_demo1();
		function translate_demo1()
		{
		var g_token = '';
		//var idbd=$("#post_id<?php echo $row['messages_id'];?>").val();


getToken1();

function getToken1() {

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
		var post_id=$("#post_id1<?php echo $row['messages_id'];?>").val();
		var type=2;
		var src = $("#postsource" + post_id).val();
		//alert(src);
		var p = new Object;
		var opt=type;
		
    p.text = src;
    p.from = null;
    p.to = "" + language + "";
    idbd = post_id;  
    //alert(idbd  )  ;
    
    p.oncomplete = 'postajaxTranslateCallback1';
	//alert(p);
    p.appId = "Bearer "+ g_token;
   
    var requestStr = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate";
    $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: true,
        
        
		});	
      
        }
    });
}
//print $rsp;
		//alert("demo");
		
		}
		
function postajaxTranslateCallback1(response) {  
 
alert(idbd);  
    document.getElementById("target2" + idbd).innerHTML = response;
    document.getElementById("target2" + idbd).style.display = 'block';
}
		
		
		</script>
        <div id="target2<?php echo $row['messages_id'];?>"  ></div>