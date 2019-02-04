<?php
require_once('common/common.php');
$country_name = $countryTitle;
$country_code = str_replace('-', ' ', $country_name);
?>

<!-- Script for the news header-->
<script>
    $(document).ready(function () {
        $('#nh-QBNews').on('click', function () {
            $(".news-header-item").removeClass('active-news-cat');
            $("#nh-QBNews").addClass('active-news-cat');
        });

        $('#nh-News').on('click', function () {
            $(".news-header-item").removeClass('active-news-cat');
            $("#nh-News").addClass('active-news-cat');
        });

        $('#nh-Entertainment').on('click', function () {
            $(".news-header-item").removeClass('active-news-cat');
            $("#nh-Entertainment").addClass('active-news-cat');
        });

        $('#nh-Sport').on('click', function () {
            $(".news-header-item").removeClass('active-news-cat');
            $("#nh-Sport").addClass('active-news-cat');
        });

        $('.nh-more-item').on('click', function () {
            $(".news-header-item").removeClass('active-news-cat');
            $("#nh-More").addClass('active-news-cat');
        });


    });

</script>

<!-- Style for the news header -->
<style>
    .active-news-cat {
        background-color: #E6633A;
        color: #fff !important;
    }

    .active-news-cat:hover {
        color: #fff !important;
    }

    .active-news-cat:visited {
        color: #fff !important;
    }
</style>


<div class="panel panel-default" style="margin-bottom:7px;">
    <!-- Panel Header -->
    <div class="panel-heading">
        <ul class="list-inline" style=" font-size: 12px; font-weight: bold;">
            <li class="selected newsPanelLi"><a id="nh-QBNews" class="news-header-item active-news-cat"
                                                href="<?php echo SITE_URL ?>/news_home.php?country=<?php echo $country_name; ?>&category=qbnews">QB<?php echo $lang['news']; ?></a>
            </li>
            <li><a id="nh-News" class="news-header-item " href="<?php echo SITE_URL ?>/getRss.php?feed=news"
                   onclick="showMe('news','<?php echo $country_code; ?>');return false;"
                   target="frm"><?php echo $lang['news']; ?></a></li>
            <li><a id="nh-Entertainment" class="news-header-item " href="<?php echo SITE_URL ?>/getRss.php?feed=art"
                   onclick="showMe('art','<?php echo $country_code; ?>');return false;"
                   target="frm"><?php echo $lang['Entertainment']; ?></a></li>
            <li><a id="nh-Sport" class="news-header-item " href="<?php echo SITE_URL ?>/getRss.php?feed=sport"
                   onclick="showMe('sport','<?php echo $country_code; ?>');return false;"
                   target="frm"><?php echo $lang['Sports']; ?></a></li>
            <li class="dropdown"><a id="nh-More" class="news-header-item " href="#" class="dropdown-toggle"
                                    data-toggle="dropdown"><?php echo $lang['More']; ?></a>
                <ul class="dropdown-menu">
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=politics"
                           onclick="showMe('politics','<?php echo $country_code; ?>');return false;"
                           target="frm"><?php echo $lang['Politics']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=business"
                           onclick="showMe('business','<?php echo $country_code; ?>');return false;"
                           target="frm"><?php echo $lang['Business']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=tech"
                           onclick="showMe('tech','<?php echo $country_code; ?>');return false;"
                           target="frm"><?php echo $lang['Technology']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=health"
                           onclick="showMe('health','<?php echo $country_code; ?>');return false;"
                           target="frm"><?php echo $lang['Health']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=culture"
                           onclick="showMe('culture','<?php echo $country_code; ?>');return false;"
                           target="frm"><?php echo $lang['Culture']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=travel"
                           onclick="showMe('travel','<?php echo $country_code; ?>');return false;"
                           target="frm"><?php echo $lang['Travel']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=sci"
                           onclick="showMe('sci');return false;" target="frm"><?php echo $lang['Science']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=lifestyle"
                           onclick="showMe('disaster','<?php echo $country_code; ?>');return false;"
                           target="frm"><?php echo $lang['Liftestyle']; ?></a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- End Panel Header -->


    <div class="panel-body" style="padding:7px">
        <ol class="list-group" style="padding-left:0px;margin-left:0px;margin-bottom:5px;">
            <?php
            if(isset($isWorld) && true === $isWorld) {
                $nquery = "SELECT * FROM news WHERE status != 0 ORDER BY news_id DESC";
            } else {
                $nquery = "SELECT * FROM news WHERE country_id = '" . $countryID . "' AND status != 0 AND category_id=9 ORDER BY news_id DESC";
            }

            $nsql = mysqli_query($con, $nquery) or die(mysqli_error($con));

            $nres = mysqli_fetch_array($nsql);
            if (mysqli_num_rows($nsql) > 0) {

                $title = $nres['title'];
                $image_url = $nres['image_url'];
                //echo $title;
                if ($nres['url'] <> "") {
                    $url = $base_url . "news_detail.php?url=" . $nres['url'];
                } else {
                    $url = "#";
                }

                if(isset($isWorld) && true == $isWorld) {
                    $rssLink = $base_url . "getRss.php?feed=news";
                } else {
                    $rssLink = $base_url . "getRss.php?country_code=" . $country_code . "&country_id=" . $countryID . "&feed=news";
                }
            } else {
                $rssLink = $base_url . "getRss.php?feed=news";
//                $rssLink = $base_url . "getRss.php?country_code=" . $country_code . "&country_id=" . $countryID . "&feed=news";
            }
            ?>
            <input type="hidden" id="cntry_code" value="<?php echo $country_code; ?>">
            <li class="y-fp-pg-controls list-group-item" style="padding:0px;">
                <!--start slider-->


                <iframe src="<?php echo $rssLink; ?>" name="frm" height="390px" width="100%" frameborder="0"
                        id="frm"></iframe>
            </li>
        </ol>
    </div>
</div>
<!-- End News Panel -->


<!-- Video Panel-->
<div style="text-align:center;background: #fff;margin-top:5px;" class="moduletable">
    <div
        style="background:#C0C0C0;color:#fff; padding: 5px; margin-bottom: 5px;"><?php echo strtoupper($lang['Video']); ?></div>
    <ul class="news_photo">
        <?php
        $rvquery1 = "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			v.url_type,v.country_id 
			FROM videos v LEFT JOIN member m ON m.member_id = v.user_id";
        $rvsql1 = mysqli_query($con, $rvquery1) or die(mysqli_error($con));

        while ($rvres1 = mysqli_fetch_array($rvsql1)) {
            if ($rvres1['country_id'] != 0) {
                $count_c = explode(",", $rvres1['country_id']);
                for ($i = 0; $i < count($count_c); $i++) {
                    if ($countryID == $count_c[$i]) {
                        $rvquery = "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type 
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id
			WHERE video_id = '" . $rvres1['video_id'] . "'
			ORDER BY v.video_id DESC";
                        $rvsql = mysqli_query($con, $rvquery) or die(mysqli_error($con));

                        while ($rvres = mysqli_fetch_array($rvsql)) {
                            ?>
                            <li id="popular_list-<?php echo $rvres['video_id']; ?>"><a
                                    href="<?php echo $base_url; ?>watch.php?video_id=<?php echo $rvres['video_id']; ?>"
                                    id="<?php echo $rvres['video_id']; ?>">
                                    <?php
                                    if ($rvres['url_type'] == 1) {
                                        ?>
                                        <div style="" class="playButton"></div>
                                        <img src="<?php echo $base_url . 'uploadedvideo/videothumb/p200x150' . $rvres['thumburl']; ?>" width="145" height="80"/>
                                    <?php }
                                    if ($rvres['url_type'] == 2) {
                                        if (preg_match('![?&]{1}v=([^&]+)!', $rvres['location'] . '&', $mr))
                                            $video_idr = $mr[1];
                                        $urlr = "http://img.youtube.com/vi/" . $video_idr . "/default.jpg";

                                        ?>
                                        <img src="<?php echo $urlr; ?>" width="145" height="80"/>
                                        <?php
                                    }

                                    ?>
                                </a></li>
                            <?php
                        }
                    }
                }
            }
        }//for loop bracket
        ?>
    </ul>
</div>


<div style="text-align:center;background: #fff;margin-top:5px;" class="moduletable">
    <div
        style="background:#C0C0C0;color:#fff; padding: 5px; margin-bottom: 5px;"><?php echo strtoupper($lang['Popular photo']); ?></div>
    <ul class="news_photo">

        <?php
        $pquery = "
SELECT post.album_id, post.upload_data_id, post.USER_CODE, post.FILE_NAME, post.message_id, post.country_flag,
COALESCE(likes.likes_count,0) AS likes_count, COALESCE(shares.shares_count,0) AS shares_count, (COALESCE(likes_count,0) + COALESCE(shares_count,0)) AS Rank
FROM
(
SELECT a.album_id, u.upload_data_id, u.USER_CODE, u.FILE_NAME,u.msg_id AS message_id, country_flag
FROM user_album a
LEFT JOIN
(SELECT upload_data_id, USER_CODE, FILE_NAME, msg_id, album_id FROM upload_data
INNER JOIN 
(SELECT DISTINCT min(upload_data_id) AS upload_id, FILE_NAME AS File FROM upload_data GROUP BY FILE_NAME) as files ON files.upload_id = upload_data.upload_data_id
) u
ON a.album_id = u.album_id
INNER JOIN message ON u.msg_id = message.messages_id
) AS post
LEFT OUTER JOIN
(
SELECT `remarks` AS message_id , count( `bleh_id` ) AS likes_count
FROM `bleh`
GROUP BY `remarks`
) AS likes
ON post.message_id = likes.message_id
LEFT OUTER JOIN
(
SELECT `share_id` AS message_id, count(`messages_id`) AS shares_count  FROM `message` WHERE `share_id` <>0 GROUP BY `share_id`
) AS shares
ON post.message_id = shares.message_id "
            . (strpos($_SERVER['REQUEST_URI'], 'country') == true ? " WHERE country_flag = '$country_code'" : "")
            . " ORDER BY Rank DESC 
   LIMIT 4";

        $psql = mysqli_query($con, $pquery);
        while ($pres = mysqli_fetch_array($psql)) {
            ?>
            <li>
                <a href="/albums.php?back_page=country_wall.php?country=<?php echo $country_code; ?>&member_id=<?php echo $pres['USER_CODE']; ?>&album_id=<?php echo $pres['album_id']; ?>&image_id=<?php echo $pres['upload_data_id']; ?>">
                    <img src="<?php echo $base_url . $pres['FILE_NAME']; ?>" height="100"/> </a></li>
            <?php
        } ?>
    </ul>

</div>
<style>
    .news_photo {
        list-style: none;
        text-align: left;
        padding: 5px 15px 15px;
    }

    .news_photo li {
        display: inline-block;
        margin: 0 2%;
        padding-top: 10px;
        width: 45%;
    }

    .news_photo li img {
        width: 100%;
        height: auto;
    }

</style>