<?php

require_once (__DIR__.'/../includes/php_fast_cache.php');

class fetchURL
{

    function fetchgivenURL($URL)
    {
		//echo "test".$URL;
		
		
        $urlId = 'url_'.md5($URL);
        $cache = new phpFastCache();
		//echo "test1".$cache;
		
       $res = $cache->get($urlId);
	  if( strpos( $res, 'YouTube' ) == false ) {
       if(!is_null($res)){
           unset($cache);
           return $res;
       }
		
	  } 
        $url = $this->checkValues($URL);
       
		
		$string = $this->fetch_record($url);
        /// fecth title
        $title_regex = "/<title>(.+)<\/title>/i";
        preg_match_all($title_regex, $string, $title, PREG_PATTERN_ORDER);
        $url_title = $title[1];

        /// fecth decription
        $tags = get_meta_tags($url);
        $graph = OpenGraph::fetch($url);

        /// fetch og meta tags
        $ogTags = $this->get_og_meta_tags($string);
        $linkType = isset($ogTags['og:type']) ? $ogTags['og:type'] : '';
        $image_og = "";
        if (isset($ogTags['og:image'])) {
            $image_og = $ogTags['og:image'];
        }
        $image_twitter = '';
        if (isset($tags['twitter:image'])) {
            $image_twitter = $tags['twitter:image'];
        }
        // fetch images
        $image_regex = '/<img[^>]*' . 'src=[\"|\'](.*)[\"|\']/Ui';
        preg_match_all($image_regex, $string, $img, PREG_PATTERN_ORDER);
        $images_array = $img[1];

        $html = '';
		
        if(empty($linkType) && strstr($url, 'facebook')){
            $html .= '<div class="embed-responsive embed-responsive-4by3">';
            $html .= '<iframe src="https://www.facebook.com/plugins/video.php?href='.urlencode($url).'&show_text=0&width=560" width="560" height="315" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>';
            $html .= '</div>';
        } else if (strstr($url, 'youtu')) {
			
            if(strstr($url, 'youtu.be') && ($ppos = strpos($url, '?')) !== false){
                $url = substr($url, 0, $ppos);
            }

            if(($ppos = strpos($url, '#')) !== false){
                $url = substr($url, 0, $ppos);
            }

            if(($ppos = strpos($url, '&')) !== false){
                $url = substr($url, 0, $ppos);
            }

            $matches = [];
            $pattern =
                '%^# Match any youtube URL
				(?:https?://)?  # Optional scheme. Either http or https
				(?:www\.)?      # Optional www subdomain
				(?:             # Group host alternatives
				  youtu\.be/    # Either youtu.be,
				| youtube\.com  # or youtube.com
				  (?:           # Group path alternatives
					/embed/     # Either /embed/
				  | /v/         # or /v/
				  | /watch\?v=  # or /watch\?v=
				  )             # End path alternatives.
				)               # End host alternatives.
				([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
				$%x';
            $res = preg_match($pattern, $url, $matches);

            if ($res) {
                $html .= '<div class="embed-responsive embed-responsive-4by3">';
                $html .= '<iframe src="https://www.youtube.com/embed/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe>';
                $html .= '</div>';
            }
        } else if ((trim($linkType) == 'video') && (isset($tags['twitter:player'])) && (strpos($tags['twitter:player'], "https://") !== false)) {
            $html .= '<div class="embed-responsive embed-responsive-4by3">';
            $html .= '<iframe src="' . $tags['twitter:player'] . '" frameborder="0" allowfullscreen></iframe>';
            $html .= '</div>';
        } else if ((trim($linkType) == 'video') && $graph->player != '' && (strpos($graph->player, "https://") !== false)) {
            $html .= '<div class="embed-responsive embed-responsive-4by3">';
            $html .= '<iframe src="' . $graph->{'player'} . '" frameborder="0" allowfullscreen></iframe>';
            $html .= '</div>';
        } else if ($image_twitter != '') {
            $html .= '<div class="images">';
            $html .= '<img src="/common/image_fetch.php?url=' . $image_twitter . '" width="100%" >';
            $html .= '</div>';
        } // by tom
        else if ($image_og != "") {
            $html .= '<div class="images">';
            $html .= '<img src="/common/image_fetch.php?url=' . $image_og . '" width="100%" >';
            $html .= '</div>';
        } else {
            $k = 1;
            $j = 0;
            for ($i = 0; $i <= sizeof($images_array); $i++) {
                if (@$images_array[$i]) {

                    if (@getimagesize(@$images_array[$i])) {

                        list($width, $height, $type, $attr) = getimagesize(@$images_array[$i]);
                        if ($width >= 50 && $height >= 50) {
                            $html .= "<div class='images'><img src='/common/image_fetch.php?url=" . @$images_array[$i] . "' width='100%' id='" . $k . "' ></div>";
                            break;
                            $k++;
                            $j = $i;
                        }

                    } else {
                        $getsubstring = substr(@$images_array[$i], 0, 2);

                        if ($getsubstring == '//') {
                            $imagesrc = "http:" . @$images_array[$i];
                            list($width, $height, $type, $attr) = getimagesize($imagesrc);
                            if ($width >= 50 && $height >= 50) {
                                $html .= "<div class='images'><img src='/common/image_fetch.php?url=" . $imagesrc . "' width='100%' id='" . $k . "' ></div>";
                                break;
                                $k++;
                                $j = $i;
                            }
                        }


                    }

                }
            }

        }

        $html .= '<div class="info" style="font-weight:normal;font-size: 11px;">';
        $html .= '<div class="title" style="font-size: 12px;border-bottom: 1px solid #ddd;">' . @$url_title[0] . '</div>';
        $html .= '</div>	';

        $cache->set($urlId, $html, 432000);
        unset($cache);

        return $html;
    }

    function checkValues($value)
    { // echo $value."-test1";
        $value = trim($value);
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        $value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    function fetch_record($path)
    {
        $context = array(
            'http' => array('max_redirects' => 99)
        );
        $context = stream_context_create($context);
        // hand over the context to fopen()
        $file = @fopen($path, "r", false, $context);
        if (is_resource($file)) {
            $data = '';
            while (!feof($file)) {
                $data .= fgets($file, 1024);
            }
            return $data;
        }

        return '';
    }

    function get_og_meta_tags($urlstring)
    {
        $html = new DOMDocument();
        @$html->loadHTML($urlstring);
        $og_tags = '';

        $ogmetas = $html->getElementsByTagName('meta');

        //Get all meta tags and loop through them.
        foreach ($ogmetas as $meta) {
            //Assign the value from content attribute to $meta_og_img
            $key = $meta->getAttribute('property');
            $og_tags[$key] = $meta->getAttribute('content');
        }

        return $og_tags;
    }
}
