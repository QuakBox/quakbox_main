// JavaScript Document
function showHide() 
{
				
   if(document.getElementById("privacy").selectedIndex == 1) 
   {
	    document.getElementById("mvm1").style.display = "block"; // This line makes the DIV visible
		document.getElementById("mvm").style.display = "none";
	   	document.getElementById("mvm2").style.display = "none";
   }
   else
   {
	   document.getElementById("mvm1").style.display = "none";	   
   } 
   if(document.getElementById("privacy").selectedIndex == 2)
   {            
        document.getElementById("mvm2").style.display = "block";
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm1").style.display = "none"; 
   }
   else
   {
	   document.getElementById("mvm2").style.display = "none";	   
   }
   
   if(document.getElementById("privacy").selectedIndex == 3)
   {            
        document.getElementById("world").value = "world";
		document.getElementById("mvm2").style.display = "none";
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm1").style.display = "none";
 }
  
   
}