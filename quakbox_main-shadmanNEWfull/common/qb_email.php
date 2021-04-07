<?php

require($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');

class QBEMAIL
{

	function send_email($to,$subject,$headerAppend,$mailTitle,$innerMessage,$messageAppendContent)
	{
	
		$htmlbody = " <html>
				<body>				
				<div id='wrapper' style='min-height:350px; width:98%;margin-top:10px;margin-bottom:10px;border:1px solid #ddd;position: relative;'>
				
					<div id='logo' style='background:url(".SITE_URL."/images/grid.jpg) repeat-x #075DC4;clear:both;'>    		
				    		<div style='float:left;'><a href='".SITE_URL."' title='".SITE_NAME."' target='_blank'><img title='".SITE_NAME."' alt='".SITE_NAME."' src='".SITE_URL."/images/quack.png'/></a></div>
						<div style='float:left;color:#fff;font-size: 22px; padding: 15px;'>".$mailTitle."</div>		
						<div style='clear:both;'></div>
				    	</div>
				    
				    <div id='containt' style='padding: 10px; margin: 0px auto; width: 95%;clear:both;'>
				    	<div style='width:25%;min-height:100px;float:left;'>
				    		<img title='".SITE_NAME."' alt='".SITE_NAME."' src='".SITE_URL."/images/email.jpg' style='width:100%'/>	        
					  </div>
				    	<div style='margin-top:3px;float:left;width:75%;'> ";
		if($innerMessage!= ''){	
			$htmlbody .= $innerMessage;
		}			        	      	 
		$htmlbody .="	        </div>
				        <div style='clear:both;'></div>
				    </div>
				    <div style='clear:both;'></div>
				    <div id='link' style='clear:both;text-align:center;padding: 20px;border-top: 1px solid #ccc;' > 
				    	<div style='text-align:center;font-size: 16px;'>If you want to stop the notification please contact <a href='mailto:support@quakbox.com?Subject=Stop%20notification%20from%20quakbox' target='_top' style='text-decoration:none;'>support@quakbox.com</a>.</div> 
				    	<div style='text-align:center;font-size: 16px;color:#409D5B;'>We are always happy to help you. </div>   
				    	<div style='text-align:center;'><a href='".SITE_URL."' title='".SITE_NAME."' target='_blank' style='text-decoration:none;color:#1155CC; font-family:Verdana, Geneva, sans-serif; font-size:15px;'> <b>View more updates on ".SITE_NAME."</b> </a></div>
				    	<div style='clear:both;'></div>
				    </div>
				    <div style='clear:both;'></div>    
				</div>
				
				</body>
				
				</html>";
		if($messageAppendContent!= ''){	
			$htmlbody .= $messageAppendContent;
		}
				
		$headers = "MIME-Version: 1.0" . "\r\n";						
		if($headerAppend!= ''){	
			$headers .= $headerAppend;
		}
		else{
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		}
		$headers .= "From:Quakbox<".SITE_NOTIFICATION_EMAIL.">";
		
		$mail = mail($to, $subject, $htmlbody, $headers); 
		
		return $mail;	
	}

}



?>