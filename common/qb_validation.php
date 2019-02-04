<?php
/**
* 
*
* validation class checks the validation of  user inputs whether it is right format or not.
*
* @class QBValidation
*@author : Vishnu S
*/

class QbValidation{
	/*check a email address is valid or not */
	function qbCheckEmail($value){	
		if( preg_match('/^[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,4}$/i', $value))
		{
			return true;
					}
					else
					{
						return false;

					}
	}
	/* function to check a IP address in format */
	function qbCheckIp($value){	
		return (bool) preg_match("/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){4}$/", $value.".");
	}

	/* function to check a date in format */

	function qbCheckDate($date,$format="dd/mm/yy"){	//check a date
		  if(!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $date))
		   {
			return false;   
		   }
		   else
		   {
			   return true;
		   }
	}

	/* function to check a url in format */
	
	function qbCheckUrl($url){	
		return (bool) preg_match(
		"/^(?:(?:ht|f)tp(?:s?)\:\/\/|~\/|\/)?(?:(?:\w+\.)+)\w+(?:\:\d+)?(?:(?:\/[^\/?#]+)+)?\/?(?:\?[^?]*)?(#.*)?$/i", $url);
	}
	
		/* function to check whethr the string is empty or valid */

	public function qbIsEmpty($string) {

			//Check string length, if 0 then return empty
			if ( strlen($string) === 0 ) {
				return true;
			}
			//Otherwise the string is valid, return true
			else {
				return false;
			}

	}
	
		/* function to check a mobile number in format */

function qbCheckNumber($mob){
if (preg_match('/[\-+]?[0-9]+$/', $mob) ) {
	
return true;
}
else {
	
return false;
}
}

	//Check if name contains alphabets only (white spaces are allowed)
public function qbCheckAlphabets($name){

if (preg_match("/^[a-zA-Z ]*$/",$name))
 {
return true;//alphabets only, return true.
}
else
{
return false;
}
			
}  
   
  public static function qbCheckFile($filename, $whitelist) 
  {
 
//Check if array of values or single value
if ( is_array($whitelist) ) {
 
//string to hold allowed filetypes
$allowed ='';
 
//add each item in array to the string
foreach ( $whitelist as $filetype ) {
 
$allowed.= $filetype . "|";
}
 
}
else {
$allowed = $filename;
}
 
//Pattern breakdown:
//** \.{1} - single '.' required
//** [" . $allowed . "]+ - check for filetypes passed into parameter ($allowed), 1 or more required.
//** $- String must end with this.
$pattern = "!\.{1}[" . $allowed . "]+$!";
 
//Valid file, return true.
if ( preg_match($pattern, $filename) ) {
return true;
}
//else invalid file type.
else {
return false;
}
 
}  
 
 
  public static function qbCheckLength($string, $minLength, $exact = 0) {
 
//Looking for exact match
if ($exact) {
if ( strlen($string) == $minLength ) {
return true;
}
else {
return false;
}
}
 
//Minimum length
if ( strlen($string) >= $minLength ) {
return true;
}
else {
return false;
}
}
function qbIntegerCheck($value)
{
	if(filter_var($value , FILTER_VALIDATE_INT))
	{
		return true;
	}
	else
	{
		return false;
	}

}


	/* function to check special characters */
function qbCheckSpecialChars($variable)
{
if (preg_match('/[\'^£$%&*()}{@#~?><>,"|=_+¬-]/', $variable))
{
 return true;
}
else
{
return false;
}
}
//function for find url from passed message
function check_url($text)
{

//$reg_exUrl = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
$reg_exUrl = '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i';	
if(preg_match($reg_exUrl, $text,$url)) {
	$link=$url[0];
	return $link;
}
else
{
	return 1;
}
	
}

//function to make clickeable links inside the post
function makeClickableLinks($text)
{

        $text = html_entity_decode($text);
	$text = preg_replace_callback(
	        '(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
	        function ($matches) {
	            return '<a href="'.$matches[0].'" target="_blank">'.$matches[0].'</a>';
	        },
	        $text
	    );
       	$text = preg_replace_callback(
	        '(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
	        function ($matches) {
	            return '<a href="'.$matches[0].'" target="_blank">'.$matches[0].'</a>';
	        },
	        $text
	    );
		$text = preg_replace('/src=\"<a.*href=\"(.*)\" .*>.*<\/a>\".*/isU', 'src="$1"', $text);
	/*$text = preg_replace_callback(
	        '([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
	        function ($matches) {
	            return $matches[0].'<a href="http://'.$matches[1].'" target="_blank">'.$matches[1].'</a>';
	        },
	        $text
	    );*/
	            
              
      
        return $text;
}

}
/*object creation for the class */
$qbValidation=new QbValidation; 
?>