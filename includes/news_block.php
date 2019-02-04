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

<div class="panel panel-default news-block">
    <div class="panel-heading">
        <ul class="list-inline">
            <li class="selected newsPanelLi"><a id="nh-QBNews" class="news-header-item active-news-cat" href="<?php echo SITE_URL ?>/news_home.php?country=<?php echo $country_name; ?>&category=qbnews">QB<?php echo $lang['news']; ?></a></li>
            <li><a id="nh-News" class="news-header-item " href="<?php echo SITE_URL ?>/getRss.php?feed=news" onclick="showMe('news','<?php echo $country_code; ?>');return false;" target="frm"><?php echo $lang['news']; ?></a></li>
            <li><a id="nh-Entertainment" class="news-header-item " href="<?php echo SITE_URL ?>/getRss.php?feed=art" onclick="showMe('art','<?php echo $country_code; ?>');return false;" target="frm"><?php echo $lang['Entertainment']; ?></a></li>
            <li><a id="nh-Sport" class="news-header-item " href="<?php echo SITE_URL ?>/getRss.php?feed=sport" onclick="showMe('sport','<?php echo $country_code; ?>');return false;" target="frm"><?php echo $lang['Sports']; ?></a></li>
            <li class="dropdown">
                <a id="nh-More" class="news-header-item " href="#" class="dropdown-toggle" data-toggle="dropdown">...</a>
                <ul class="dropdown-menu">
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=politics" onclick="showMe('politics','<?php echo $country_code; ?>');return false;" target="frm"><?php echo $lang['Politics']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=business" onclick="showMe('business','<?php echo $country_code; ?>');return false;" target="frm"><?php echo $lang['Business']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=tech" onclick="showMe('tech','<?php echo $country_code; ?>');return false;" target="frm"><?php echo $lang['Technology']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=health" onclick="showMe('health','<?php echo $country_code; ?>');return false;" target="frm"><?php echo $lang['Health']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=culture" onclick="showMe('culture','<?php echo $country_code; ?>');return false;" target="frm"><?php echo $lang['Culture']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=travel" onclick="showMe('travel','<?php echo $country_code; ?>');return false;" target="frm"><?php echo $lang['Travel']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=sci" onclick="showMe('sci');return false;" target="frm"><?php echo $lang['Science']; ?></a></li>
                    <li><a class="nh-more-item" href="<?php echo SITE_URL ?>/getRss.php?feed=lifestyle" onclick="showMe('disaster','<?php echo $country_code; ?>');return false;" target="frm"><?php echo $lang['Liftestyle']; ?></a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="panel-body">
        <ol class="list-group">
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
                if ($nres['url'] <> "") {
                    $url = $base_url . "news_detail.php?url=" . $nres['url'];
                } else {
                    $url = "#";
                }

                if(isset($isWorld) && true === $isWorld) {
                    $rssLink = $base_url . "getRss.php?feed=news";
                } else {
                    $rssLink = $base_url . "getRss.php?country_code=" . $country_code . "&country_id=" . $countryID . "&feed=news";
                }
            } else {
                $rssLink = $base_url . "getRss.php?country_code=" . $country_code . "&country_id=" . $countryID . "&feed=news";
            }
            ?>
            <input type="hidden" id="cntry_code" value="<?php echo $country_code; ?>">
            <li class="y-fp-pg-controls list-group-item">
                <iframe src="<?php echo $rssLink; ?>" name="frm" height="390px" width="100%" frameborder="0" id="frm"></iframe>
            </li>
        </ol>
    </div>
</div>
