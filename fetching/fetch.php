<?php

$url = $_REQUEST['url'];
$url = checkValues($url);

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

function get_og_meta_tags($urlstring) {
	$html = new DOMDocument();
	@$html->loadHTML($urlstring);
	$og_tags = '';
	
	$ogmetas = $html->getElementsByTagName('meta');
	
	//Get all meta tags and loop through them.
	foreach($ogmetas as $meta) {
		//Assign the value from content attribute to $meta_og_img
		$key = $meta->getAttribute('property');
		$og_tags[$key] = $meta->getAttribute('content');
	}
	
	return $og_tags;
}

$string = fetch_record($url);


/// fecth title
$title_regex = "/<title>(.+)<\/title>/i";
preg_match_all($title_regex, $string, $title, PREG_PATTERN_ORDER);
$url_title = $title[1];

/// fecth decription
$tags = get_meta_tags($url);

/// fetch og meta tags
$ogTags = get_og_meta_tags($string);
$linkType = isset($ogTags['og:type']) ? $ogTags['og:type'] : '';
$videoContent = '';

if( (trim($linkType) == 'video') && (isset($tags['twitter:player'])) ) {
	$videoContent = '<iframe src="'.$tags['twitter:player'].'" frameborder="0" allowfullscreen></iframe>';
}

// fetch images
$image_regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
preg_match_all($image_regex, $string, $img, PREG_PATTERN_ORDER);
$images_array = $img[1];

?>
	<div class="head pull-left">Link</div>	
	<div class="pull-right"><a id="fetch_close" href="javascript: void(0)" class="closes"></a></div>
	
	<div class="clearfix" style="border-bottom:1px solid #ccc;margin-bottom: 5px;"></div>	
	<div class="images" style="width:25%; float:left;margin-right:0px;">
	
	
	<?php
	$image_twitter='';
	$k=1;
	if(isset($tags['twitter:image'])){
		$image_twitter=$tags['twitter:image'];
	}
	if($image_twitter!=''){
		echo "<img src='https://quakbox.com/common/image_fetch.php?url=".$image_twitter."' width='100%' id='".$k."' >";
		echo "<input type='hidden' name='total_images' id='total_images' value='".$k."' />";
	}
	else{
	
		for ($i=0;$i<=sizeof($images_array);$i++)
		{
			if(@$images_array[$i])
			{
				if(@getimagesize(@$images_array[$i]))
				{
					list($width, $height, $type, $attr) = getimagesize(@$images_array[$i]);
					if($width >= 50 && $height >= 50 ){
					
					echo "<img src='https://quakbox.com/common/image_fetch.php?url=".@$images_array[$i]."' width='100%' id='".$k."' >";
					
					$k++;
					
					}
				}
				else{
					$getsubstring=substr(@$images_array[$i],0,2);			
					if($getsubstring=='//'){
						$imagesrc="http:".@$images_array[$i];
						list($width, $height, $type, $attr) = getimagesize($imagesrc);
						if($width >= 50 && $height >= 50){				
							 echo "<img src='https://quakbox.com/common/image_fetch.php?url=".$imagesrc."' width='100%' id='".$k."' >";	
										
							$k++;
							$j=$i;					
						}
					}
												
						
				}
			}
		}
		echo '<input type="hidden" name="total_images" id="total_images" value="'. --$k.'" />';
	}
	?>
	<!--<img src="ajax.jpg"  alt="" />-->
	<input type="hidden" name="cur_image" id="cur_image" />
	
	</div>
	<input type="hidden" name="link_type" id="link_type" value="<?php echo $linkType; ?>" />
	<input type="hidden" name="videoContent" id="videoContent" value="<?php echo htmlspecialchars($videoContent); ?>" />
	<div class="info" style="width:72%;float:left;padding-left:10px;">
		
		<div class="title" style="font-size:11px; font-weight:bold; cursor:pointer;">
			<?php  echo @$url_title[0]; ?>
		</div>		
		<div class="url" style="font-size:10px; padding:3px;color:gray;">
			<?php  echo substr($url ,0,35); ?>
		</div>		
		<div class="desc" style="font-size:12px; margin-top:5px; cursor:pointer;">
			<?php  echo @$tags['description']; ?>
		</div>		
		<div style="float:left"><img style="cursor:pointer;" src="https://quakbox.com/fetching/prev.png" id="prev" alt="" /><img src="https://quakbox.com/fetching/next.png" id="next"  style="cursor:pointer;" alt="" /></div>		
		<div class="totalimg" style="font-size:10px; color:#333333;float:left; margin:5px;">
			Total <?php echo $k?> images
		</div>
		
		
	</div>
	<div class="clearfix"></div>
	<div align="center" id="load" style="display:none;"><img src="https://quakbox.com/images/ajax-loader.gif" id="loading_indicator"></div>
	
	
	
	