<div class="sidebar-menu">
    <?php if(!isset($countryID) || $countryID == 0){ ?>
        <ul>
            <li class="smi-news"><a href="/news_home.php">News</a></li>
            <li class="smi-groups"><a href="/groups.php">Groups</a></li>
            <li class="smi-photos"><a href="/photos/<?php echo $currentUsername ?>">Photos</a></li>
            <li class="smi-videos"><a href="/myvideos.php">Videos</a></li>
            <li class="smi-events"><a href="/create_event.php">Events</a></li>
            <li class="smi-invite-friends"><a href="/friends/<?php echo $currentUsername ?>">Friends</a></li>
            <?php /*<li class="smi-add-news"><a href="#">Add News</a></li>*/ ?>
            <li class="smi-countries"><a href="/create_country.php">My Countries</a></li>
        </ul>
    <?php } else { ?>
        <?php print $countryMenuResult; ?>
    <?php } ?>
</div>

<?php if (isset($countryID) && $countryID > 0) { ?>
    <div class="current-location">
        <div style="box-sizing: border-box; padding: 0px; text-align:center; line-height: 110%;" class="moduletable">
            <img src="<?php echo SITE_URL . '/images/Flags/flags_new/flags/' . $countryCode . '.png' ?>" style="width: 100%; padding: 5px;"/>
            <div style="color:#aaa;"><?php echo strtoupper($countryTitle); ?></div>
        </div>
    </div>

    <?php print $countryFans; ?>
    <?php print $countryPeoples; ?>

<?php } else { ?>

<!-- Popular Photos -->
<?php
$photos = wallGetPopularPhotos();
if(!empty($photos)) {
?>
<div class="sidebar-widget clearfix photos-widget">
    <div class="title">Popular Photos</div>
    <ul class="photos">
        <?php foreach ($photos as $pres) { ?>
            <li><a href="/albums.php?back_page=country_wall.php?country=<?php echo $country_code; ?>&member_id=<?php echo $pres['USER_CODE']; ?>&album_id=<?php echo $pres['album_id']; ?>&image_id=<?php echo $pres['upload_data_id']; ?>"><img src="<?php echo $base_url . $pres['FILE_NAME']; ?>" /></a></li>
        <?php } ?>
    </ul>
</div>
<?php } ?>
<?php } ?>
