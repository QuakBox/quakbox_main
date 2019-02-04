<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_misc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_widgets/friends_request_notification.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_widgets/view_notification.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_security.php');


$logged_in_member_id_header1 = $_SESSION['SESS_MEMBER_ID'];
$objMemberHeader1 = new member1();

$currentMemberResultHeader1 = $objMemberHeader1->select_member_byID($logged_in_member_id_header1);
$currentMemberResultHeader1ProfileLogo = $objMemberHeader1->select_member_meta_value($logged_in_member_id_header1, 'current_profile_image');

$currentUserProfilePic = '';
if ($currentMemberResultHeader1ProfileLogo) {
    $currentUserProfilePic = SITE_URL . '/' . $currentMemberResultHeader1ProfileLogo;
} else {
    $currentUserProfilePic = SITE_URL . '/images/default.png';
}


$objMisc = new misc();

$member = new Member();
$member_user_name = $member->get_username_by_id($_SESSION['SESS_MEMBER_ID']);


$randomCountriesResult = $objMisc->getRandom3countries();
$randomCountries = '';
foreach ($randomCountriesResult as $valueRandomCountries) {

    $randomCountries .= '<a class="thumbnail headerflagthumbs pop" href="' . SITE_URL . '/country/' . $valueRandomCountries['code'] . '"';
    $randomCountries .= ' data-toggle="popover" data-trigger="hover" data-container="body" title="All Countries"';
    $randomCountries .= '>';
    $randomCountries .= '<i class="sprite sprite-' . strtolower($valueRandomCountries['code']) . '" style="min-height:10px;"></i>';
    $randomCountries .= '<span style="font-size:9px;">' . substr($valueRandomCountries['country_title'], 0, 6) . '</span>';
    $randomCountries .= '</a>';

}
$allCountriesResult = $objMisc->getallcountries();
$iMaxCols = 6;
$rowscount = count($allCountriesResult);
$allCountries = '';
$allCountries .= '<ul class="dropdown-menu scrollable-menu" role="menu" aria-labelledby="dropdownMenu1">';
$allCountries .= '<li><a href="/home"><i class="sprite sprite-world"></i><label class="world">World</label></a></li>';
$allCountries .= '<li><a href="/create_country.php"><i class="sprite sprite-world"></i><label>Favorite Countries</label></a></li>';
foreach ($allCountriesResult as $valueAllCountries) {
    $country_name1 = str_replace(' ', '-', $valueAllCountries['country_title']);
    $allCountries .= '<li>';
    $allCountries .= '<a href="' . SITE_URL . '/country/' . $valueAllCountries['code'] . '" >';
    $allCountries .= '<i class="sprite sprite-' . strtolower($valueAllCountries['code']) . '"></i>';
    $allCountries .= '<label>' . $valueAllCountries["country_title"] . '</label>';
    $allCountries .= '</a>';
    $allCountries .= '</li>';
}
$allCountries .= '</ul>';

// Countries div to be viewed in the popover when hover on country
$popover_countries = '';
foreach ($allCountriesResult as $valueCountries) {
    $popover_countries .= '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">';
    $popover_countries .= '<a href="' . SITE_URL . '/country/' . $valueCountries['code'] . '" >';
    $popover_countries .= '<img src="' . SITE_URL . '/images/Flags/flags_new/195x120flags/' . strtolower($valueCountries['code']) . '.png"' . " title=" . $valueCountries["country_title"] . ' height="36" style="border:0px none; background: none repeat scroll 0% 0% transparent;" />';
    $popover_countries .= '<br/>';
    $popover_countries .= '<font style="font-size:10px;">' . substr($valueCountries['country_title'], 0, 6) . '</font>';
    $popover_countries .= '</a>';
    $popover_countries .= '</div>';
}


$objFriendsRequest = new friendsRequestNotificationWidget();
$objViewNotification = new viewNotificationWidget();
$currentUsername = '';
while ($clMember = mysqli_fetch_array($currentMemberResultHeader1)) {
    $currentUsername = $clMember['username'];
}


// Get User Favourite Countries
$favarioteCountriesResult = $objMisc->getFavCountry($logged_in_member_id_header1);
$favCountries = '';
foreach ($favarioteCountriesResult as $valueFavCountries) {
    $favCountries .= '<a class="thumbnail headerflagthumbs" style="margin-right:3px;padding:0px;display:inline-block;margin-bottom:0px;" href="' . SITE_URL . '/country/' . $valueFavCountries['code'] . '" >';
    $favCountries .= '<i class="sprite sprite-' . strtolower($valueFavCountries['code']) . '" style="min-height:18px;"></i>';
    $favCountries .= '<span style="font-size:9px;">' . substr($valueFavCountries['country_title'], 0, 6) . '</span>';
    $favCountries .= '</a>';
}
