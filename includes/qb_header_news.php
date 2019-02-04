<style>
    @import url(http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700);
    /* written by riliwan balogun http://www.facebook.com/riliwan.rabo*/
    .board {
        width: 100%;
        margin: 3px auto;
        height: 250px;
        background: #fff;
        /*box-shadow: 10px 10px #ccc,-10px 20px #ddd;*/
    }

    .board .nav-tabs {
        position: relative;
        /* border-bottom: 0; */
        /* width: 80%; */
        margin: 3px auto;
        margin-bottom: 0;
        box-sizing: border-box;

    }

    .board > div.board-inner {
        background: #fafafa url(http://subtlepatterns.com/patterns/geometry2.png);
        background-size: 30%;
    }

    p.narrow {
        width: 60%;
        margin: 3px auto;
    }

    .liner {
        height: 2px;
        background: #ddd;
        position: absolute;
        width: 80%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 50%;
        z-index: 1;
    }

    span.round-tabs {
        width: 25px;
        height: 25px;
        line-height: 25px;
        display: inline-block;
        border-radius: 100px;
        background: white;
        z-index: 2;
        position: absolute;
        left: 0;
        text-align: center;
        font-size: 15px;
    }

    span.txt {
        font-size: 15px;
    }

    span.round-tabs.one {
        color: rgb(34, 194, 34);
        border: 2px solid rgb(34, 194, 34);
    }

    li.active_category span.round-tabs.one {
        background: #fff !important;
        border: 2px solid #ddd;
        color: rgb(34, 194, 34);
    }

    span.round-tabs.two {
        color: #febe29;
        border: 2px solid #febe29;
    }

    li.active_category span.round-tabs.two {
        background: #fff !important;
        border: 2px solid #ddd;
        color: #febe29;
    }

    span.round-tabs.three {
        color: #3e5e9a;
        border: 2px solid #3e5e9a;
    }

    li.active_category span.round-tabs.three {
        background: #fff !important;
        border: 2px solid #ddd;
        color: #3e5e9a;
    }

    span.round-tabs.four {
        color: #f1685e;
        border: 2px solid #f1685e;
    }

    li.active span.round-tabs.four {
        background: #fff !important;
        border: 2px solid #ddd;
        color: #f1685e;
    }

    span.round-tabs.five {
        color: #9369e7;
        border: 2px solid #9369e7;
    }

    span.round-tabs.six {
        color: #ff4500;
        border: 2px solid #ff4500;
    }

    span.round-tabs.seven {
        color: #975d4b;
        border: 2px solid #975d4b;
    }

    span.round-tabs.eight {
        color: #474747;
        border: 2px solid #474747;
    }

    span.round-tabs.nine {
        color: #ee1289;
        border: 2px solid #ee1289;
    }

    li.active span.round-tabs.five {
        background: #fff !important;
        border: 2px solid #ddd;
        color: #999;
    }

    .nav-tabs > li.active_category > a span.round-tabs {
        background: #fafafa;
    }

    .nav-tabs > li {
        width: 12.5%;
    }

    /*li.active:before {
        content: " ";
        position: absolute;
        left: 45%;
        opacity:0;
        margin: 0 auto;
        bottom: -2px;
        border: 10px solid transparent;
        border-bottom-color: #fff;
        z-index: 1;
        transition:0.2s ease-in-out;
    }*/
    li:after {
        content: " ";
        position: absolute;
        left: 20%;
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: #ddd;
        transition: 0.1s ease-in-out;

    }

    li.active_category:after {
        content: " ";
        position: absolute;
        left: 38%;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 8px solid transparent;
        border-bottom-color: #666666;

    }

    .nav-tabs > li a {
        width: 30px;
        height: 30px;
        margin: 2px auto;
        border-radius: 100%;
        padding: 0;
        border: 0px;
    }

    .tab-content {
    }

    .tab-pane {
        position: relative;
        padding-top: 5px;
    }

    .tab-content .head {
        font-family: 'Roboto Condensed', sans-serif;
        font-size: 25px;
        text-transform: uppercase;
        padding-bottom: 10px;
    }

    .btn-outline-rounded {
        padding: 10px 40px;
        margin: 10px 0;
        border: 2px solid transparent;
        border-radius: 25px;
    }

    .btn.green {
        background-color: #5cb85c;
        color: #ffffff;
    }
    .fixed-header {
        position:fixed;
        width: 65%;
    }

    @media ( max-width: 585px ) {

        .fixed-header {
            position:fixed;
            width: 93%;
            box-sizing: border-box;
        }

        .board {
            width: 100%;
            height: auto !important;
        }

        span.round-tabs {
            font-size: 15px;
            width: 30px;
            height: 30px;
            line-height: 30px;
        }

        .tab-content .head {
            font-size: 20px;
        }

        .nav-tabs > li a {
            width: 50px;
            height: 50px;
            line-height: 50px;
        }

        li.active_category:after {
            content: " ";
            position: absolute;
            left: 25%;
        }

        .btn-outline-rounded {
            padding: 12px 20px;
        }
    }
</style>
<script>
    $(function () {
        $('a[title]').tooltip();
    });
</script>

<?php
if (isset($_GET['category'])) {
    $category = $_GET['category'];
} else {
    $category = '';
}

$politics_cat = $category == "politics" ? "class='active_category'" : "";
$business_cat = $category == "business" ? "class='active_category'" : "";
$sports_cat = $category == "sports" ? "class='active_category'" : "";
$health_cat = $category == "health" ? "class='active_category'" : "";
$showbiz_cat = $category == "showbiz" ? "class='active_category'" : "";
$oped_cat = $category == "oped" ? "class='active_category'" : "";
$science_cat = $category == "science" ? "class='active_category'" : "";
$economy_cat = $category == "economy" ? "class='active_category'" : "";
$education_cat = $category == "education" ? "class='active_category'" : "";
?>
<div class="row">
    <div>
        <ul class="nav nav-tabs" id="myTab">
            <li <?php echo $politics_cat; ?>>
                <a href="news_category.php?country=<?php echo $country_code; ?>&category=politics" title="Politics">
                    <span class="round-tabs one"><i class="glyphicon glyphicon-globe"></i></span>
                </a>
            </li>
            <li <?php echo $sports_cat; ?>>
                <a href="news_category.php?country=<?php echo $country_code; ?>&category=sports" title="sports">
                    <span class="round-tabs two"><i class="fa fa-futbol-o"></i></span>
                </a>
            </li>
            <li <?php echo $business_cat; ?>>
                <a href="news_category.php?country=<?php echo $country_code; ?>&category=business" title="Business">
                    <span class="round-tabs three"><i class="glyphicon glyphicon-briefcase"></i></span>
                </a>
            </li>
            <li <?php echo $health_cat; ?>>
                <a href="news_category.php?country=<?php echo $country_code; ?>&category=health" title="Health">
                    <span class="round-tabs four"><i class="fa fa-heart"></i></span>
                </a>
            </li>
            <li <?php echo $showbiz_cat; ?>>
                <a href="news_category.php?country=<?php echo $country_code; ?>&category=showbiz" title="Entertainment">
                    <span class="round-tabs five"><i class="fa fa-money"></i></span>
                </a>
            </li>
            <li <?php echo $science_cat; ?>>
                <a href="news_category.php?country=<?php echo $country_code; ?>&category=science" title="Sci-Tech">
                    <span class="round-tabs six"><i class="fa fa-flask"></i></span>
                </a>
            </li>
            <li <?php echo $economy_cat; ?>>
                <a href="news_category.php?country=<?php echo $country_code; ?>&category=economy" title="Economy">
                    <span class="round-tabs seven"><i class="fa fa-line-chart"></i></span>
                </a>
            </li>
            <li <?php echo $education_cat; ?>>
                <a href="news_category.php?country=<?php echo $country_code; ?>&category=education" title="Education">
                    <span class="round-tabs eight"><i class="fa fa-graduation-cap"></i></span>
                </a>
            </li>
        </ul>
    </div>
</div>

