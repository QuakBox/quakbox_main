$(document).click(function() {

//$(document).keypress(function( event ) {
//if ( event.which == 13 ) {
//alert("working");


   $.ajax({
                type: "POST",
                url: base_url + "check.php",
                
                cache: false,
                success: function (html) {
                //alert("working");
                  var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                 }
                 
			
            });//}});
});
