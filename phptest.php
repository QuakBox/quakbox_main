<?php
	/*$a = 'yuvaraj'; $b = 2;
	$c = $a+$b;
	echo $c;
	echo print_r(json_encode('{"default-city":"Sansad Marg","district":"CENTRAL DELHI","state":"DELHI","zone":"A","region":"NORTH","exp":"Y","cgo":"Y","sfc":"Y","to-pay":"Y","cod":"Y","partner":"Aramex"}'));
	echo $str = '99, sriram nagar, chennai, ';
	echo '<br>'. trim(trim($str), ',');*/
	
	/**/
	
	/*$text = '<iframe width="560" height="315" src="<a href="https://www.youtube.com/embed/cJPAWVutb-w" target="_blank">https://www.youtube.com/embed/hiQu0njLqy0</a>" frameborder="0" allowfullscreen></iframe> <br /><a href="https://www.youtube.com/embed/TkNAupJpy1o" target="_blank">https://www.youtube.com/embed/TkNAupJpy1o</a> <iframe width="560" height="315" src="<a href="https://www.youtube.com/embed/TkNAupJpy1o" target="_blank">https://www.youtube.com/embed/TkNAupJpy1o</a>" frameborder="0" allowfullscreen></iframe><br /><a href="https://www.youtube.com/embed/TkNAupJpy1o" target="_blank">https://www.youtube.com/embed/TkNAupJpy1o</a> <iframe width="560" height="315" src="<a href="https://www.youtube.com/embed/hiQu0njLqy0" target="_blank">https://www.youtube.com/embed/hiQu0njLqy0</a>" frameborder="0" allowfullscreen></iframe>';
	$text = preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/i', '$2', $text);
	
	echo $text.'<br><br>';
	
	$text = preg_replace_callback(
	        '(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
	        function ($matches) {
	            return '<a href="'.$matches[0].'" target="_blank">'.$matches[0].'</a>';
	        },
	        $text
	    );*/
	//preg_match('/src=\"<a.*href=\"(.*)\" .*>.*<\/a>\".*/i', $text, $matches);
//	
//	$text = preg_replace('/src=\"<a.*href=\"(.*)\" .*>.*<\/a>\".*/isU', 'src="$1"', $text);
//	
//	foreach($matches as $t):
//		echo $t.'<br>';
//	endforeach;
//		
//	echo '<br /><br />'.$text;
//	
//	echo '<br>'


function checkValues($value)
{
	$value = trim($value);
	if (get_magic_quotes_gpc()) 
	{
		$value = stripslashes($value);
	}
	$value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
	$value = strip_tags($value);
	$value = htmlspecialchars($value);
	return $value;
}	
function fetch_record($path)
{
	$file = fopen($path, "r"); 
	if (!$file)
	{
		exit("Problem occured");
	} 
	$data = '';
	while (!feof($file))
	{
		$data .= fgets($file, 1024);
	}
	return $data;
}



$url = 'https://youtu.be/pRpeEdMmmQ0';
$url = checkValues($url);

//echo $url2;
$string = fetch_record($url);


/*$title_regex = "/<title>(.+)<\/title>/i";
preg_match_all($title_regex, $string, $title, PREG_PATTERN_ORDER);
echo $url_title = $title[1];*/

/// fecth decription
$tags = get_meta_tags($url);

print_r($tags);


//$sites_html = file_get_contents($url);

$html = new DOMDocument();
@$html->loadHTML($string);
$meta_og_img = '';

$ogmetas = $html->getElementsByTagName('meta');


//Get all meta tags and loop through them.
foreach($ogmetas as $meta) {
    //If the property attribute of the meta tag is og:image
   // if(=='og:type'){ 
        //Assign the value from content attribute to $meta_og_img
		$key = $meta->getAttribute('property');
        $meta_og_img[$key] = $meta->getAttribute('content');
    //}
}
print_r($meta_og_img);
echo $meta_og_img;



?>