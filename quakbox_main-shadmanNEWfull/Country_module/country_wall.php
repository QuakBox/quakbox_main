<?php
//error_reporting(E_ALL);
error_reporting( -1 );
//ini_set('display_errors', 1);
$pageIsVisibleForEveryone = true;
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/common.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/qb_header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_misc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_widgets/country_menu.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_widgets/posts.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_widgets/apps.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_security.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_widgets/status.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_lookup.php');
//require_once($_SERVER['DOCUMENT_ROOT'] . '/common/core.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_news_feed.php');

$countryCode = strtolower($_GET['country']);
$miscObjCountry = new misc();
$countryResult = $miscObjCountry->getcountryByCode($countryCode);
//echo "<pre>";
//print_r($countryResult);
//die();
$postWidgetObjCountry = new postWidget();
$appsWidgetObjHome = new appsWidget();
$statusWidgetObjCountry = new statusWidget();
$objLookupClass = new lookup();
$lookupWallID = $objLookupClass->getLookupKey('Wall Type', 'Country');

$QbSecurityCW = new QB_SqlInjection;
//echo "<pre>country wall";
//print_r($lookupWallID);
//die();

if (isset($_GET['notid'])) {
    echo $_GET['notid'];
    $notificationid = $_GET['notid'];
    $updatesql = "UPDATE notifications SET notifications.is_unread=1 where notifications.id=$notificationid";
    $db_Obj = new database();
    $rs = $db_Obj->execQuery($updatesql);
    print "this is notid " . $_GET['notid'];
}

$countryID = 0;
$countryTitle = '';
$countryMenuResult = '';
$countryFans = '';
$countryPeoples = '';
foreach ($countryResult as $valueCountryResult) {
    $countryID = $valueCountryResult['country_id'];
    $countryTitle = $valueCountryResult['country_title'];
}
if ($countryID > 0) {
    $menuObjCountry = new countryMenu();
    $countryMenuResult = $menuObjCountry->getCountryMenu($countryCode, $countryID, $countryTitle);
    $countryFans = $menuObjCountry->getCountryFans($countryCode, $countryID, $countryTitle);
    $countryPeoples = $menuObjCountry->getCountryPeoples($countryCode, $countryID, $countryTitle);
}

$encryptedWallID = $QbSecurityCW->QB_AlphaID($lookupWallID);
//echo "<pre>";
//print_r($encryptedWallID);
//die();
$encryptedCountry = base64_encode($QbSecurityCW->Qbencrypt($countryTitle, ENC_KEY));
$encryptedCountry = $countryTitle;
?>
<?php if ($countryID > 0) { ?>
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs" style="padding-left:0px;padding-right:0px;">
        <div class="LeftPanel">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/yahoo_news_menu.php') ?>
        </div>
    </div>

    <div class="col-lg-2 visible-xs">
        <div class="">
            <div style="text-align:center;background: #fff;" class="moduletable">
                <img src="<?php echo SITE_URL . '/images/Flags/flags_new/flags/' . $countryCode . '.png' ?>"
                     style="width: 100%; padding: 5px;"/>
                <div
                    style="background:#C0C0C0;color:#fff; padding: 5px; margin-bottom: 5px;"><?php echo strtoupper($countryTitle); ?></div>
            </div>
        </div>
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target="#addTabsC" aria-expanded="false"
                        aria-controls="navbar" class="navbar-toggle collapsed  btn-warning">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="addTabsC" class="navbar-collapse collapse" style="background: #fff;">
                <?php print $countryMenuResult; ?>
            </div>
        </nav>
    </div>

    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 NoSidepadding">
        <div class="MemoBar">
            <?php print $statusWidgetObjCountry->getStatusWidget($encryptedWallID,$lookupWallID); ?>
        </div>
        <div class="wallvwe countrywall">
            <?php
/*
            if(!isset($world)) {
                $news = new QB_NewsFeed($country_code);
                $newsList = $news->getCountryNewsList();
                if (!empty($newsList)) {
                    ?>
                    <div class="postContents postwL news-block" style=" background: #fff;border:1px solid #ccc;padding:5px;margin-bottom:5px;border-radius:10px;">
                        <ul class="news-list">
                            <?php $c = 0; foreach ($newsList as $newsItem) { if($c++ > 5){ break; }?>
                                <li>
                                    <h3><a href="<?php echo $newsItem['url'] ?>" target="_blank"><?php echo $newsItem['title'] ?></a></h3>
                                    <div class="news-item-body"><?php echo $newsItem['description'] ?></div>
                                </li>
                            <?php } ?>
                            <li class="more"><a href="/news_category.php?country=<?php echo $country_code ?>&category=politics">View
                                    More &raquo;</a></li>
                        </ul>
                    </div>
                    <?php
                }
                unset($news);
            }
*/
            ?>

            <?php print $postWidgetObjCountry->getPosts($encryptedWallID, $encryptedCountry, 'get'); ?>
        </div>
        <?php if ($postWidgetObjCountry->getCountIntialPost() > 9) { ?>
            <div style="text-align: center; z-index: 99999; font-size: 25px; margin: 80px 0px 30px;" id="wall_loader"><i
                    class="fa fa-spinner fa-spin" style="margin-right: 5px;"></i>Loading ...
            </div>
        <?php } ?>
    </div>


    <!-- Ads panel -->
    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">
        <div class="RightPanel">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/qb_widgets/ads.php'); ?>
        </div>
    </div>


    <!-- Flag and activity panel -->
    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">
        <div id="fixedapp" class="fixedapp RightPanel">
            <div style="text-align:center;background: #fff;" class="moduletable">
                <img src="<?php echo SITE_URL . '/images/Flags/flags_new/flags/' . $countryCode . '.png' ?>"
                     style="width: 100%; padding: 5px;"/>
                <div
                    style="background:#C0C0C0;color:#fff; padding: 5px; margin-bottom: 5px;"><?php echo strtoupper($countryTitle); ?></div>

            </div>
            <div id="addTabsC" style="max-height:300px;background: #fff;">
                <?php print $countryMenuResult; ?>
                <?php print $countryFans; ?>
                <?php print $countryPeoples; ?>
            </div>
        </div>
    </div>
<?php } else {
    print '<div class="col-lg-12" style="font-size:30px;padding:10px;"> <i class="fa fa-search"></i> <span style="margin-left:10px;">Sorry No results</span> </div>';
}


?>


    <input type="hidden" id="twn" class="twn" value="<?php //echo $encryptedWallID; ?>"/>
    <input type="hidden" id="twnEC" class="twnEC" value="<?php echo $encryptedCountry; ?>"/>

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/share.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/qb_footer.php');

?>