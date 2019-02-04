<?php

require_once('common/database.php');

class QB_NewsFeed
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

    public function getCountryNewsList()
    {
        $xmlUrl = 'http://news.google.com/news/feeds?pz=1&cf=all&output=rss&ned='.$this->getNewsCode();
        return $this->getListFromXml($xmlUrl);
    }

    public function getNewsList()
    {
        return $this->getListFromXml($this->getXmlUrl());
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