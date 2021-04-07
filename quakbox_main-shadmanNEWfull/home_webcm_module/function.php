<? 
include_once("includes/simple_html_dom.php");
function CheckUrl($url){
	if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}
function get_url($url)
{
		$get_url = CheckUrl($url); 
		
		//Include PHP HTML DOM parser (requires PHP 5 +)
		include_once("includes/simple_html_dom.inc.php");
		
		//get URL content
		$get_content = file_get_html($get_url); 
	
		//Get Page Title 
		foreach($get_content->find('title') as $element) 
		{
			$page_title = $element->plaintext;
		}
		
		//Get Body Text
		foreach($get_content->find('body') as $element) 
		{
			$page_body = trim($element->plaintext);
			$pos=strpos($page_body, ' ', 200); //Find the numeric position to substract
			$page_body = substr($page_body,0,$pos ); //shorten text to 200 chars
		}
	
		$image_urls = array(); $video_urls=array();
		
		
		//get all images URLs in the content
		foreach($get_content->find('meta') as $element) 
		{
				/* check image URL is valid and name isn't blank.gif/blank.png etc..
				you can also use other methods to check if image really exist */
				if(filter_var($element->content, FILTER_VALIDATE_URL)) 
				{
						//print_r($element);
						$video_urls[] =  $element->content;
				}
				
		}
		if(count($video_urls)<2) { 
			foreach($get_content->find('img') as $element) 
			{
					/* check image URL is valid and name isn't blank.gif/blank.png etc..
					you can also use other methods to check if image really exist */
					if(!preg_match('/blank.(.*)/i', $element->src) && filter_var($element->src, FILTER_VALIDATE_URL))
					{
						$image_urls[] =  $element->src;
						
					}
			}
		}
	
		//prepare for JSON 
		$output = array('title'=>$page_title, 'images'=>$image_urls,'videos'=>$video_urls, 'content'=> $page_body);
		
		return $output;
}
function get_username_by_id($id, $con)
{
	if($id<>"") { 
		$sqlCount = "SELECT username FROM members WHERE member_id =".$id;
		$resCount = mysqli_query($con, $sqlCount) or die(mysqli_error($con));
		if(mysqli_num_rows($resCount)>0) {
			return $rowCount['username'];		
		} else return "";
	}else return "";
}

//extract url functions ------- starts 
function html_title($url) {
    // create HTML DOM
    $html = file_get_html($url);

    // remove all comment elements
    foreach($html->find('title') as $e)
       $ret =  $e->innertext;

    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

function html_img($url) {
    // create HTML DOM
    $html = file_get_html($url);

    // remove all comment elements
    foreach($html->find('img') as $e) {
       if($e->attr and $e->attr['width']>10 and $e->attr['height']>10) {
	   		$ret  =  $e->attr['src'];
			break;
	    }
	}
    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}
function html_video($url) {
    // create HTML DOM
   $html = file_get_html($url);

	//iframe video parser 
	foreach($html->find('iframe') as $e) {
		if($e->attr) {
			$ret =  $e->attr;
				break;
			}
	}
	// video parser 
	foreach($html->find('source') as $e) {
		if($e->attr) {
			$ret =  $e->attr['src'];
			break;
		}
	}
	
	$html->clear();
    unset($html);
    return $ret;
} 


function html_video_vimeo($url) {
    // create HTML DOM
    $html = file_get_html($url);
	foreach($html->find('object') as $e) {
	   if($e->attr) {
			$ret =  "http://".$e->attr['data'];//data;
			break;
		}
	}
	 // clean up memory
    $html->clear();
    unset($html);

    return $ret;
} 

function extract_url($url)
{
		$url = CheckUrl($url); 

		/*$title = html_title($url);
		$imgArray =  html_img($url);
		
		// check for youtube videos if youtube url then extract video id from url else parse html to get video/imgs
		if (preg_match('![?&]{1}v=([^&]+)!', $url . '&', $m)) {
			$videoArray = 'http://www.youtube.com/v/'.$m[1];
		}else { 
			if(strstr($url,"vimeo"))
				$videoArray =  html_video_vimeo($url);
			else 
				$videoArray =  html_video($url);
		}
	*/
	$html = file_get_html($url);

    // remove all comment elements
    foreach($html->find('title') as $e)
       $title =  $e->innertext;
	
	
	 // remove all comment elements
    foreach($html->find('img') as $e) {
       if($e->attr and $e->attr['width']>10 and $e->attr['height']>10) {
	   		$imgArray  =  $e->attr['src'];
			break;
	    }
	}
	
   // $imgArray =  html_img($url);
	
	// check for youtube videos if youtube url then extract video id from url else parse html to get video/imgs
	if (preg_match('![?&]{1}v=([^&]+)!', $url . '&', $m)) {
		$videoArray = 'http://www.youtube.com/v/'.$m[1];
	}else { 
		if(strstr($url,"vimeo")) {
			foreach($html->find('object') as $e) {
			   if($e->attr) {
					$videoArray =  $e->attr['data'];//data;
					break;
				}
			}
			//$videoArray =  html_video_vimeo($url);
		}
		else { 
			//$videoArray =  html_video($url);
			//iframe video parser 
			foreach($html->find('iframe') as $e) {
				if($e->attr) {
					$videoArray =  $e->attr;
						break;
					}
			}
			// video parser 
			foreach($html->find('source') as $e) {
				if($e->attr) {
					$videoArray =  $e->attr['src'];
					break;
				}
			}
		}
	}
	 $html->clear();
        unset($html);

		//prepare for JSON 
		$output = array('title'=>$title, 'images'=>$imgArray,'videos'=>$videoArray);
		//print_r($output);
		return $output;
}
// extract url functions ----------------ends 

?>