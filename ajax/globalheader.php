<?php
// Output MIME type header
header("Content-Type: application/javascript");
session_start();
// Load default libraries
require_once($_SERVER['DOCUMENT_ROOT'].'/common/core.php');

$logo = '';
$displayName = '';

if(QB_Core::isLoggedIn()) {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_security.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_lookup.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_config.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_misc.php');

  $member = new member1();
  $objMisc = new misc();

  $memberRecord = $member->select_member_byID(QB_Core::getLoggedMemberId());
  $logo = SITE_URL . '/' . $member->select_member_meta_value(QB_Core::getLoggedMemberId(), 'current_profile_image');
  $memberData = $member->getMemberById(QB_Core::getLoggedMemberId());
  $displayName = str_replace("'", "\\'", isset($memberData['displayname']) ? $memberData['displayname'] : '');
}
  /* Output global header */
  $jsCode = '
  <link rel="stylesheet" href="/css/header.css">
  <header class="qbheader">
  <div class="logo">
    <a href="/">Quakbox</a>
  </div>
  <div class="search-bar">
    <form action="/create_country.php">
      <div class="search-input-field">
        <input type="text" name="search" placeholder="Search Quakbox">
        <input type="button" value="Search">
      </div>
    </form>
  </div>
  <ul class="services-list">
    <li class="cast"><a href="/qcast.php">Cast</a></li>
    <li class="find-friends"><a href="/find_friend.php">Find Friends</a></li>
    <li class="messages"><a href="/messages.php">Messages</a></li>
    <li class="notifications"><a href="/notifications.php">Notifications</a></li>
    <li class="email"><a href="/qbmail/">Webmail</a></li>
    <li class="world"><a href="/home">World</a></li>
    <li class="flag"><a href="/create_country.php">Flag</a></li>
  </ul>
  <ul class="user-panel">';

  if(QB_Core::isLoggedIn()) {
    $jsCode .= '<li class="user-info">
      <a href="#"><img src="' . $logo . '" alt="' . $displayName . '"> ' . $displayName . '</a>
    </li>
    <li><a href="/logout.php" class="logout">Logout</a></li>
    <li><a href="/profile.php" class="settings">Settings</a></li>
    ';
  }

  $jsCode .= '<li><a href="/report_issue.php" class="info">Report an Issue</a></li>
  </ul>
  <div class="mobile-menu">
    <label href="#" class="menu-icon" for="header-menu-toggle">&#9776;</label>
    <input type="checkbox" name="header-menu-toggle" id="header-menu-toggle">
    <ul class="header-menu">
      <li><a href="/qcast.php">qkass</a></li>
      <li><a href="/find_friend.php">Find a Friend</a></li>
      <li><a href="/notifications.php">Notifications</a></li>
      <li><a href="/messages.php">My Messages</a></li>
      <li><a href="/qbmail/">Webmail</a></li>
      <li><a href="/home">World</a></li>
      <li><a href="/create_country.php">Favorite Countries</a></li>
    </ul>
  </div>
  </header>';
?>
!function(){function e(){if(!r&&(r=!0,l)){for(var e=0;e<l.length;e++)l[e].call(window,[]);l=[]}}function t(e){var t=window.onload;"function"!=typeof window.onload?window.onload=e:window.onload=function(){t&&t(),e()}}function n(){if(!d){if(d=!0,document.addEventListener&&!a.opera&&document.addEventListener("DOMContentLoaded",e,!1),a.msie&&window==top&&function(){if(!r){try{document.documentElement.doScroll("left")}catch(t){return void setTimeout(arguments.callee,0)}e()}}(),a.opera&&document.addEventListener("DOMContentLoaded",function(){if(!r){for(var t=0;t<document.styleSheets.length;t++)if(document.styleSheets[t].disabled)return void setTimeout(arguments.callee,0);e()}},!1),a.safari){var n;!function(){if(!r){if("loaded"!=document.readyState&&"complete"!=document.readyState)return void setTimeout(arguments.callee,0);if(void 0===n){for(var t=document.getElementsByTagName("link"),o=0;o<t.length;o++)"stylesheet"==t[o].getAttribute("rel")&&n++;var i=document.getElementsByTagName("style");n+=i.length}return document.styleSheets.length!=n?void setTimeout(arguments.callee,0):void e()}}()}t(e)}}var o=window.DomReady={},i=navigator.userAgent.toLowerCase(),a={version:(i.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/)||[])[1],safari:/webkit/.test(i),opera:/opera/.test(i),msie:/msie/.test(i)&&!/opera/.test(i),mozilla:/mozilla/.test(i)&&!/(compatible|webkit)/.test(i)},d=!1,r=!1,l=[];o.ready=function(e,t){n(),r?e.call(window,[]):l.push(function(){return e.call(window,[])})},n()}();
(function () {
  DomReady.ready(function(){
    /*var loggedIn = <?php echo QB_Core::isLoggedIn() ? 'true' : 'false' ?>;
    if(loggedIn){*/
      var menuElement = document.createElement("div");
      menuElement.innerHTML = '<?php echo str_replace(["\"", "\r", "\n"], ["\\\"", "", ""], $jsCode) ?>';
      document.body.insertBefore(menuElement, window.document.body.firstChild);
    /*} else {
      window.location.href = '/';
    }*/
  });
})();
