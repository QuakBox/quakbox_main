<?php

require_once('common/database.php');
require_once('qb_classes/qb_misc.php');

class QB_News
{
    private $countryTitle = '';
    private $category = 'politics';
    private $countryCode = '';
    private $countryId = 0;
    private $newsCode = '';

    /**
     * @return string
     */
    public function getNewsCode()
    {
        return $this->newsCode;
    }

    /**
     * @param string $newsCode
     */
    public function setNewsCode($newsCode)
    {
        $this->newsCode = $newsCode;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getCountryTitle()
    {
        return $this->countryTitle;
    }

    /**
     * @param string $countryTitle
     */
    public function setCountryTitle($countryTitle)
    {
        $this->countryTitle = $countryTitle;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function dataToArray()
    {
        return [
            'code' => $this->getCountryCode(),
            'country_id' => $this->getCountryId(),
            'news_code' => $this->getNewsCode(),
            'country_title' => $this->getCountryTitle()
        ];
    }

    public function __construct($countryTitle = '')
    {
        // Set category
        if(isset($_REQUEST['category'])){
            $this->setCategory($_REQUEST['category']);
        }
        
        // Set country
        if(!empty($countryTitle)){
            $this->setCountryTitle($countryTitle);
        } else {
            if(isset($_REQUEST['country'])){
                $this->setCountryTitle($_REQUEST['country']);
            }
        }

        $sql = "SELECT * FROM geo_country WHERE country_title='".$this->getCountryTitle()."'";
        $data = dbFetch($sql);

        if(!empty($data)){
            $this->setCountryCode($data['code']);
            $this->setCountryId($data['country_id']);
            $this->setNewsCode($data['news_code']);
        }
    }

    public function getXmlUrl()
    {
        $topic = '';

        switch($this->getCategory()){
            case 'health':
                $topic = 'm';
                break;

            case 'oped':
                $topic = 'oped';
                break;

            case 'showbiz':
                $topic = 'e';
                break;

            case 'sports':
                $topic = 's';
                break;

            case 'science':
                $topic = 'snc';
                break;

            case 'business':
                $topic = 'b';
                break;

            case 'education':
                $topic = 'education';
                break;

            case 'economy':
                $topic = 'economy';
                break;

            default:
                // Politics category
                $topic = 'politics';
        }

        $xmlUrl = 'http://news.google.com/news/feeds?pz=1&cf=all&output=rss&topic='.$topic.'&ned='.$this->getNewsCode();
        return $xmlUrl;
    }
	
	public function getXmlUrlSitemap($value)
    {
        $topic = '';

        switch($value){
            case 'health':
                $topic = 'm';
                break;

            case 'oped':
                $topic = 'oped';
                break;

            case 'showbiz':
                $topic = 'e';
                break;

            case 'sports':
                $topic = 's';
                break;

            case 'science':
                $topic = 'snc';
                break;

            case 'business':
                $topic = 'b';
                break;

            case 'education':
                $topic = 'education';
                break;

            case 'economy':
                $topic = 'economy';
                break;

            default:
                // Politics category
                $topic = 'politics';
        }

        $xmlUrl = 'http://news.google.com/news/feeds?pz=1&cf=all&output=rss&topic='.$topic.'&ned='.$this->getNewsCode();
        return $xmlUrl;
    }

    public function getCountryNewsList()
    {
        $xmlUrl = 'http://news.google.com/news/feeds?pz=1&cf=all&output=rss&ned='.$this->getNewsCode();
        return $this->getListFromXml($xmlUrl);
    }
	
	public function getNewsCategory(){
		return array('8'=>'health','2'=>'showbiz','1'=>'sports','7'=>'science','6'=>'business','12'=>'education','3'=>'politics','6'=>'economy');
	}

    private function categoryToId()
    {
        $id = '';

        switch($this->getCategory()){
            case 'health':
                $id = 8;
                break;

            case 'oped':
                break;

            case 'showbiz':
                $id = 2;
                break;

            case 'sports':
                $id = 1;
                break;

            case 'science':
                $id = 7;
                break;

            case 'business':
                $id = 6;
                break;

            case 'education':
                $id = 12;
                break;

            case 'politics':
                $id = 3;
                break;

            case 'economy':
                $id = 6;
                break;
        }

        return $id;
    }

    private function getUsersFeed()
    {
        $sql = 'SELECT * FROM news WHERE status!=0';
        if($this->getCountryId() > 0){
            $sql .= ' AND country_id='.$this->getCountryId();
        }

        $categoryId = $this->categoryToId();
        if(!empty($categoryId)){
            $sql .= ' AND category_id='.$categoryId;
        }

        $sql .= ' ORDER BY news_id DESC LIMIT 50';
        $result = dbFetchArray($sql);

        foreach($result as &$item) {
            $item['description'] = stripcslashes(str_replace(["\\r\\n"], ["<br>"], strip_tags($item['description'])));
            $item['title'] = stripcslashes(str_replace(["\\r\\n"], ["<br>"], strip_tags($item['title'])));
            $item['url'] = '/news_detail.php?url='.$item['url'];

            if(!empty($item['image_url'])){
                $item['description'] = '<img src="'.$item['image_url'].'" style="float:left; max-width: 80px; max-height: 80px; margin-right: 20px; margin-bottom: 20px;">'.$item['description'].'<div style="clear:both;"></div>';
            }
        }

        return $result;
    }
	
	private function getUsersFeedSitemap($id,$countryID)
    { 
        $sql = 'SELECT * FROM news WHERE status!=0';
        if($countryID > 0){
            $sql .= ' AND country_id='.$countryID;
        }

        $categoryId = $id;
        if(!empty($categoryId)){
            $sql .= ' AND category_id='.$categoryId;
        }

        $sql .= ' ORDER BY news_id DESC LIMIT 50';
        $result = dbFetchArray($sql);

        foreach($result as &$item) {
            $item['description'] = stripcslashes(str_replace(["\\r\\n"], ["<br>"], strip_tags($item['description'])));
            $item['title'] = stripcslashes(str_replace(["\\r\\n"], ["<br>"], strip_tags($item['title'])));
            $item['url'] = '/news_detail.php?url='.$item['url'];

            if(!empty($item['image_url'])){
                $item['description'] = '<img src="'.$item['image_url'].'" style="float:left; max-width: 80px; max-height: 80px; margin-right: 20px; margin-bottom: 20px;">'.$item['description'].'<div style="clear:both;"></div>';
            }
        }

        return $result;
    }


    public function getNewsList()
    {
        $result = $this->getUsersFeed();
        $feed = $this->getListFromXml($this->getXmlUrl());

        $result = array_merge($result, $feed);
        return $result;
    }

	
	 public function getSitemapNews($id,$countryID,$value)
    {
        $result = $this->getUsersFeedSitemap($id,$countryID);
        $feed = $this->getListFromXml($this->getXmlUrlSitemap($value));

        $result = array_merge($result, $feed);
        return $result;
    }
	
    private function getListFromXml($xml)
    {
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml);
        $x = $xmlDoc->getElementsByTagName('item');
        $newsCount = $x->length;

        if($newsCount < 1){
            return [];
        }

        $list = [];
        for ($i = 0; $i < $newsCount; $i++) {
            $title = $x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
            $description = $x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
            $description = strip_tags($description, '<div><img><table><tr><td>');
            $description = str_replace([
                '<img alt="" height="1" width="1">', '<br>',
                $title
            ], '', $description);

            $list[] = [
                'title' => $title,
                'url' => $x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue,
                'description' => $description
            ];
        }

        return $list;
    }
}