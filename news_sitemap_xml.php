<?php

/**
 * News Category page
 */
require_once('common/core.php');
require_once('includes/time_stamp.php');
require_once('qb_classes/qb_news.php');
require_once('qb_classes/qb_misc.php');
require_once('qb_widgets/country_menu.php');

$news = new QB_News();
$res = $news->dataToArray();
$country_code = $news->getCountryTitle();
$category = '';
$countryID = 0;
if(isset($_GET['category'])){
	$category = $_GET['category'];
}
if(isset($_GET['country'])){
	$_GET['country'] = $_GET['country'];
} else{
	$_GET['country'] = '';
}
$countryCode =$_GET['country'];
$miscObjCountry = new misc();
$countryID = $miscObjCountry->getcountryIdByName(trim($countryCode));


?>
<?php $newsCategory = $news->getNewsCategory(); 
	
	$dom = new DOMDocument('1.0','UTF-8');
	$dom->formatOutput = true;

	$root = $dom->createElement('urlset');
	
	foreach($newsCategory as $id=>$value){ 
		 $list = $news->getSitemapNews($id,$countryID,$value);
		 foreach($list as $newsItem) { 
			$dom->appendChild($root);
			$result = $dom->createElement('url');
			$root->appendChild($result);
			//$result->appendChild( $dom->createElement('title',$newsItem['title']) );
			if (strpos($newsItem['url'], 'http:') !== false){
				
			}else{
				 $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
				 $domain = $_SERVER['HTTP_HOST'];
				 $newsItem['url'] = $protocol.'://'.$domain.$newsItem['url'];
			}
			$result->appendChild( $dom->createElement('loc', htmlentities($newsItem['url'])));
			$result->appendChild( $dom->createElement('changefreq','always' ));
			$result->appendChild( $dom->createElement('priority','1.00' ));
		}
    }
	echo '<xmp>'. $dom->saveXML() .'</xmp>';
	$dom->save('sitemap.xml') or die('XML Create Error');


?>
