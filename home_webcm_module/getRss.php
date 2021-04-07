<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/common/common.php');
//error_reporting(0);

//get image from rss feed
function image_from_description($data)
{
    preg_match_all('/(<img[^>]+>)/i', $data, $matches);
    $img = preg_replace_callback('/width="(\d+)(px)?" height="(\d+)(px)?"/', function ($matches) {
        return 'width="240" height="240"';
    }, $matches[1][0]);
    return $img;
}

if (isset($_GET['feed'])) {
    $feed = $QbSecurity->qbClean($_GET['feed'], $con);
}

$country_code = str_replace('-', ' ', $QbSecurity->qbClean($_GET['country_code'], $con));
$country_code = htmlspecialchars(trim($country_code));
$cnt_id = "select * from geo_country where country_title='$country_code'";
$st_id = mysqli_query($con, $cnt_id);

while ($row = mysqli_fetch_array($st_id)) {
    $country_id = $row['country_id'];
}

$nodes = array();
$nxttab = "news";
if (isset($_REQUEST['qb'])) {
    if ($_REQUEST['qb'] == "qbnews") {
        $nquery = "SELECT * FROM news WHERE country_id = '$country_id' AND status != 0 ORDER BY news_id DESC LIMIT 20";
        $nsql = mysqli_query($con, $nquery) or die(mysqli_error($con));
        $count_news = mysqli_num_rows($nsql);
//        $nres = mysqli_fetch_array($nsql);

        if ($count_news > 0) {
            $item = array();
            while ($nres = mysqli_fetch_array($nsql)) {
                $item['title'] = $nres['title'];
                $item['link'] = $nres['url'];
                $item['img'] = '<img src="' . $nres['image_url'] . '" width="240" height="240" alt="' . $nres['title'] . '"/>';
                if ($item['img'] <> "") $nodes[] = $item;
            }
        }
    }
}

if ($feed == "qbnews") {
    $nquery = "SELECT * FROM news WHERE country_id = '$country_id' AND status != 0 ORDER BY news_id DESC LIMIT 20";
    $nsql = mysqli_query($con, $nquery) or die(mysqli_error($con));
    $count_news = mysqli_num_rows($nsql);
//    $nres = mysqli_fetch_array($nsql);

    if ($count_news > 0) {
        $item = array();
        while ($nres = mysqli_fetch_array($nsql)) {
            $item['title'] = $nres['title'];
            $item['link'] = $nres['url'];
            $item['img'] = '<img src="' . $nres['image_url'] . '" width="240" height="240" alt="' . $nres['title'] . '"/>';
            if ($item['img'] <> "") $nodes[] = $item;
        }
    } else {
        $feed == "news";
    }
}

if ($feed <> "") {
    if (@$count_news > 0) {
        if ($feed == "qbnews") {
            $nxttab = "news";
        }
    }
    if (@$count_news <= 0) {
        $nxttab = "news";
    }
    if ($feed == "news") {
        $nxttab = "art";
    }

    // set url value as per country
    $country_code = $QbSecurity->qbClean($_GET['country_code'], $con);
    if ($country_code == 'India') {
        $url = ("https://globalvoicesonline.org/-/world/south-asia/india/feed/");
    } else if ($country_code == 'United States') {
        $url = ("https://globalvoicesonline.org/-/world/north-america/usa/feed/");
    } else if ($country_code == 'Afghanistan') {
        $url = ("https://globalvoicesonline.org/-/world/central-asia-caucasus/afghanistan/feed/");
    } else if ($country_code == 'Albania') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/albania/feed/");
    } else if ($country_code == 'Algeria') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/algeria/feed/");
    } else if ($country_code == 'Andorra') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/algeria/feed/");
    } else if ($country_code == 'Angola') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/angola/feed/");
    } else if ($country_code == 'Anguilla') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/anguilla/feed/");
    } else if ($country_code == 'Antigua and Barbuda') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/antigua-and-barbuda/feed/");
    } else if ($country_code == 'Argentina') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/argentina/feed/");
    } else if ($country_code == 'Armenia') {
        $url = ("https://globalvoicesonline.org/-/world/central-asia-caucasus/armenia/feed/");
    } else if ($country_code == 'Aruba') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/aruba/feed/");
    } else if ($country_code == 'Australia') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/australia/feed/");
    } else if ($country_code == 'Austria') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/austria/feed/");
    } else if ($country_code == 'Azerbaijan') {
        $url = ("https://globalvoicesonline.org/-/world/central-asia-caucasus/azerbaijan/feed/");
    } else if ($country_code == 'Bahamas') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/bahamas/feed/");
    } else if ($country_code == 'Bahrain') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/bahrain/feed/");
    } else if ($country_code == 'Bangladesh') {
        $url = ("https://globalvoicesonline.org/-/world/south-asia/bangladesh/feed/");
    } else if ($country_code == 'Barbados') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/barbados/feed/");
    } else if ($country_code == 'Belarus') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/belarus/feed/");
    } else if ($country_code == 'Belgium') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/belgium/feed/");
    } else if ($country_code == 'Belize') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/belize/feed/");
    } else if ($country_code == 'Benin') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/benin/feed/");
    } else if ($country_code == 'Bermuda') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/bermuda/feed/");
    } else if ($country_code == 'Bhutan') {
        $url = ("https://globalvoicesonline.org/-/world/south-asia/bhutan/feed/");
    } else if ($country_code == 'Bolivia') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/bolivia/feed/");
    } else if ($country_code == 'Bosnia and Herzegovina') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/bosnia-herzegovina/feed/");
    } else if ($country_code == 'Botswana') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/botswana/feed/");
    } else if ($country_code == 'Brazil') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/brazil/feed/");
    } else if ($country_code == 'British Virgin Islands') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/british-virgin-islands/feed/");
    } else if ($country_code == 'Bulgaria') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/bulgaria/feed/");
    } else if ($country_code == 'Burkina Faso') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/burkina-faso/feed/");
    } else if ($country_code == 'Burundi') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/burundi/feed/");
    } else if ($country_code == 'Cambodia') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/cambodia/feed/");
    } else if ($country_code == 'Cameroon') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/cameroon/feed/");
    } else if ($country_code == 'Canada') {
        $url = ("https://globalvoicesonline.org/-/world/north-america/canada/feed/");
    } else if ($country_code == 'Cape Verde') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/cape-verde/feed/");
    } else if ($country_code == 'Cayman Islands') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/cayman-islands/feed/");
    } else if ($country_code == 'Central African Republic') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/central-african-republic/feed/");
    } else if ($country_code == 'Chad Tchad') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/chad/feed/");
    } else if ($country_code == 'Chile') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/chile/feed/");
    } else if ($country_code == 'China') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/china/feed/");
    } else if ($country_code == 'Colombia') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/colombia/feed/");
    } else if ($country_code == 'Comoros') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/comoros/feed/");
    } else if ($country_code == 'Congo Rep. of the Congo') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/comoros/feed/");
    } else if ($country_code == 'Cook Islands') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/cook-islands/feed/");
    } else if ($country_code == 'Costa Rica') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/costa-rica/feed/");
    } else if ($country_code == "Cote D'Ivoire Ivory Coast") {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/cote-divoire/feed/");
    } else if ($country_code == 'Croatia') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/croatia/feed/");
    } else if ($country_code == 'Cuba') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/cuba/feed/");
    } else if ($country_code == 'Cyprus') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/cyprus/feed/");
    } else if ($country_code == 'Czech Republic') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/czech-republic/feed/");
    } else if ($country_code == 'Dem. Rep. of the Congo Zaire') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/dr-of-congo/feed/");
    } else if ($country_code == 'Denmark') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/denmark/feed/");
    } else if ($country_code == 'Djibouti') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/djibouti/feed/");
    } else if ($country_code == 'Dominica') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/dominica/feed/");
    } else if ($country_code == 'Dominican Republic') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/dominican-republic/feed/");
    } else if ($country_code == 'Ecuador') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/ecuador/feed/");
    } else if ($country_code == 'Egypt') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/egypt/feed/");
    } else if ($country_code == 'El Salvador') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/el-salvador/feed/");
    } else if ($country_code == 'Equatorial Guinea') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/equatorial-guinea/feed/");
    } else if ($country_code == 'Eritrea') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/eritrea/feed/");
    } else if ($country_code == 'Estonia') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/estonia/feed/");
    } else if ($country_code == 'Ethiopia') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/ethiopia/feed/");
    } else if ($country_code == 'Faroe Islands') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/finland/feed/");
    } else if ($country_code == 'Finland') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/finland/feed/");
    } else if ($country_code == 'France') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/france/feed/");
    } else if ($country_code == 'French Guiana') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/french-guiana/feed/");
    } else if ($country_code == 'French Polynesia') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/france/feed/");
    } else if ($country_code == 'French Southern Territories') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/france/feed/");
    } else if ($country_code == 'Gabon') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/gabon/feed/");
    } else if ($country_code == 'Gambia') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/gambia/feed/");
    } else if ($country_code == 'Georgia') {
        $url = ("https://globalvoicesonline.org/-/world/central-asia-caucasus/georgia/feed/");
    } else if ($country_code == 'Germany') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/germany/feed/");
    } else if ($country_code == 'Ghana') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/ghana/feed/");
    } else if ($country_code == 'Gibraltar') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/ghana/feed/");
    } else if ($country_code == 'Greece') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/greece/feed/");
    } else if ($country_code == 'Greenland') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/greece/feed/");
    } else if ($country_code == 'Grenada') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/grenada/feed/");
    } else if ($country_code == 'Guadeloupe') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/guadeloupe/feed/");
    } else if ($country_code == 'Guatemala') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/guatemala/feed/");
    } else if ($country_code == 'Guinea') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/guinea/feed/");
    } else if ($country_code == 'Guinea Bissau') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/guinea-bissau/feed/");
    } else if ($country_code == 'Guyana') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/guyana/feed/");
    } else if ($country_code == 'Haiti') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/haiti/feed/");
    } else if ($country_code == 'Honduras') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/honduras/feed/");
    } else if ($country_code == 'Hungary') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/hungary/feed/");
    } else if ($country_code == 'Iceland') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/iceland/feed/");
    } else if ($country_code == 'Indonesia') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/indonesia/feed/");
    } else if ($country_code == 'Iran') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/iran/feed/");
    } else if ($country_code == 'Iraq') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/iraq/feed/");
    } else if ($country_code == 'Ireland') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/ireland/feed/");
    } else if ($country_code == 'Israel') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/israel/feed/");
    } else if ($country_code == 'Italy') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/italy/feed/");
    } else if ($country_code == 'Jamaica') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/jamaica/feed/");
    } else if ($country_code == 'Japan') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/japan/feed/");
    } else if ($country_code == 'Jordan') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/jordan/feed/");
    } else if ($country_code == 'Kazakhstan') {
        $url = ("https://globalvoicesonline.org/-/world/central-asia-caucasus/kazakhstan/feed/");
    } else if ($country_code == 'Kenya') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/kenya/feed/");
    } else if ($country_code == 'Kiribati') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/kenya/feed/");
    } else if ($country_code == 'Kuwait') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/kuwait/feed/");
    } else if ($country_code == 'Kyrgyzstan') {
        $url = ("https://globalvoicesonline.org/-/world/central-asia-caucasus/kyrgyzstan/feed/");
    } else if ($country_code == 'Laos') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/laos/feed/");
    } else if ($country_code == 'Latvia') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/latvia/feed/");
    } else if ($country_code == 'Lebanon') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/lebanon/feed/");
    } else if ($country_code == 'Lesotho') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/lesotho/feed/");
    } else if ($country_code == 'Liberia') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/liberia/feed/");
    } else if ($country_code == 'Libya') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/libya/feed/");
    } else if ($country_code == 'Liechtenstein') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/liechtenstein/feed/");
    } else if ($country_code == 'Lithuania') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/lithuania/feed/");
    } else if ($country_code == 'Luxembourg') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/luxembourg/feed/");
    } else if ($country_code == 'Macedonia') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/macedonia/feed/");
    } else if ($country_code == 'Madagascar') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/madagascar/feed/");
    } else if ($country_code == 'Malawi') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/malawi/feed/");
    } else if ($country_code == 'Malaysia') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/malaysia/feed/");
    } else if ($country_code == 'Maldives') {
        $url = ("https://globalvoicesonline.org/-/world/south-asia/maldives/feed/");
    } else if ($country_code == 'Mali') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/mali/feed/");
    } else if ($country_code == 'Malta') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/malta/feed/ ");
    } else if ($country_code == 'Martinique') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/martinique/feed/");
    } else if ($country_code == 'Mauritania') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/mauritania/feed/");
    } else if ($country_code == 'Mauritius') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/mauritius/feed/");
    } else if ($country_code == 'Mayotte') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/mayotte/feed/");
    } else if ($country_code == 'Mexico') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/mexico/feed/");
    } else if ($country_code == 'Moldova') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/moldova/feed/");
    } else if ($country_code == 'Mongolia') {
        $url = ("https://globalvoicesonline.org/-/world/central-asia-caucasus/mongolia/feed/");
    } else if ($country_code == 'Morocco') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/morocco/feed/");
    } else if ($country_code == 'Mozambique') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/mozambique/feed/");
    } else if ($country_code == 'Myanmar Burma') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/myanmar-burma/feed/");
    } else if ($country_code == 'Namibia') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/namibia/feed/");
    } else if ($country_code == 'Nepal') {
        $url = ("https://globalvoicesonline.org/-/world/south-asia/nepal/feed/");
    } else if ($country_code == 'Netherlands') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/netherlands/feed/");
    } else if ($country_code == 'Netherlands Antilles') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/mayotte/feed/");
    } else if ($country_code == 'New Caledonia') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/new-caledonia/feed/");
    } else if ($country_code == 'New Zealand') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/mayotte/feed/");
    } else if ($country_code == 'Nicaragua') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/mayotte/feed/");
    } else if ($country_code == 'Niger') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/niger/feed/");
    } else if ($country_code == 'Nigeria') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/nigeria/feed/");
    } else if ($country_code == 'Norway') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/norway/feed/");
    } else if ($country_code == 'Oman') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/oman/feed/");
    } else if ($country_code == 'Pakistan') {
        $url = ("https://globalvoicesonline.org/-/world/south-asia/pakistan/feed/");
    } else if ($country_code == 'Palau') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/mayotte/feed/");
    } else if ($country_code == 'Panama') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/panama/feed/");
    } else if ($country_code == 'Papua New Guinea') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/papua-new-guinea/feed/");
    } else if ($country_code == 'Peru') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/peru/feed/");
    } else if ($country_code == 'Philippines') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/philippines/feed/");
    } else if ($country_code == 'Poland') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/poland/feed/");
    } else if ($country_code == 'Portugal') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/portugal/feed/");
    } else if ($country_code == 'Qatar') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/qatar/feed/");
    } else if ($country_code == 'Romania') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/romania/feed/");
    } else if ($country_code == 'Russia') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/russia/feed/");
    } else if ($country_code == 'Rwanda') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/rwanda/feed/");
    } else if ($country_code == 'Saint Helena') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/saint-helena/feed/");
    } else if ($country_code == 'Saint Kitts and Nevis') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/stkitts-nevis/feed/");
    } else if ($country_code == 'Saint Lucia') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/saint-lucia/feed/");
    } else if ($country_code == 'Saint Vincent and the Grenadines') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/st-vincent-the-grenadines/feed/");
    } else if ($country_code == 'Saint Pierre and Miquelon') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/st-maarten/feed/");
    } else if ($country_code == 'Samoa Western Samoa') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/samoa/feed/");
    } else if ($country_code == 'San Marino') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/san-marino/feed/");
    } else if ($country_code == 'Saudi Arabia') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/saudi-arabia/feed/");
    } else if ($country_code == 'Senegal') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/senegal/feed/");
    } else if ($country_code == 'Seychelles') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/seychelles/feed/");
    } else if ($country_code == 'Sierra Leone') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/sierra-leone/feed/");
    } else if ($country_code == 'Singapore') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/singapore/feed/");
    } else if ($country_code == 'Slovakia') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/slovakia/feed/");
    } else if ($country_code == 'Slovenia') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/slovenia/feed/");
    } else if ($country_code == 'Solomon Islands') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/somaliland/feed/");
    } else if ($country_code == 'Somalia') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/somalia/feed/");
    } else if ($country_code == 'South Africa') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/south-africa/feed/");
    } else if ($country_code == 'South Korea') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/south-korea/feed/");
    } else if ($country_code == 'Spain') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/spain/feed/");
    } else if ($country_code == 'Sri Lanka') {
        $url = ("https://globalvoicesonline.org/-/world/south-asia/sri-lanka/feed/");
    } else if ($country_code == 'Sudan') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/sudan/feed/");
    } else if ($country_code == 'Suriname') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/suriname/feed/");
    } else if ($country_code == 'Svalbard and Jan Mayen Islands') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/senegal/feed/");
    } else if ($country_code == 'Swaziland') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/swaziland/feed/");
    } else if ($country_code == 'Sweden') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/sweden/feed/");
    } else if ($country_code == 'Switzerland') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/switzerland/feed/");
    } else if ($country_code == 'Syria') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/syria/feed/");
    } else if ($country_code == 'Taiwan') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/taiwan-roc/feed/");
    } else if ($country_code == 'Tajikistan') {
        $url = ("https://globalvoicesonline.org/-/world/central-asia-caucasus/tajikistan/feed/");
    } else if ($country_code == 'Tanzania') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/tanzania/feed/");
    } else if ($country_code == 'Thailand') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/thailand/feed/");
    } else if ($country_code == 'Togo') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/togo/feed/");
    } else if ($country_code == 'Tonga') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/tonga/feed/");
    } else if ($country_code == 'Trinidad and Tobago') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/trinidad-tobago/feed/");
    } else if ($country_code == 'Tunisia') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/tunisia/feed/");
    } else if ($country_code == 'Turkey') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/turkey/feed/");
    } else if ($country_code == 'Turkmenistan') {
        $url = ("https://globalvoicesonline.org/-/world/central-asia-caucasus/turkmenistan/feed/");
    } else if ($country_code == 'Turks and Caicos Islands') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/turks-caicos-isl/feed/");
    } else if ($country_code == 'Tuvalu') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/swaziland/feed/");
    } else if ($country_code == 'Uganda') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/uganda/feed/");
    } else if ($country_code == 'Ukraine') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/ukraine/feed/");
    } else if ($country_code == 'United Arab Emirates') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/united-arab-emirates/feeds/");
    } else if ($country_code == 'United Kingdom') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/united-kingdom/feed/");
    } else if ($country_code == 'Uruguay') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/uruguay/feed/");
    } else if ($country_code == 'Uzbekistan') {
        $url = ("https://globalvoicesonline.org/-/world/central-asia-caucasus/uzbekistan/feed/");
    } else if ($country_code == 'Vanuatu') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/vatican-city/feed/");
    } else if ($country_code == 'Venezuela') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/venezuela/feed/");
    } else if ($country_code == 'Viet Nam Vietnam') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/vietnam/feed/");
    } else if ($country_code == 'Wallis and Futuna') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/wallis-futuna/feed/");
    } else if ($country_code == 'Yemen') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/yemen/feed/");
    } else if ($country_code == 'Zambia') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/zambia/feed/");
    } else if ($country_code == 'Zimbabwe') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/zimbabwe/feed/");
    } else if ($country_code == 'Aland Islands') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/finland/feed/");
    } else if ($country_code == 'American Samoa') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/american-samoa/feed/");
    } else if ($country_code == 'British Indian Ocean Territory') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/tanzania/feed/");
    } else if ($country_code == 'Brunei Darussalam') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/brunei/feed/");
    } else if ($country_code == 'Christmas Island') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/australia/feed/");
    } else if ($country_code == 'European Union') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/feed/");
    } else if ($country_code == 'Falkland Islands') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/united-kingdom/feed/");
    } else if ($country_code == 'Fiji') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/fiji/feed/");
    } else if ($country_code == 'Guam') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/papua-new-guinea/");
    } else if ($country_code == 'Guernsey') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/indonesia/feed/");
    } else if ($country_code == 'Hong Kong') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/hong-kong-china/feed/");
    } else if ($country_code == 'Isle of Man') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/ireland/feed/");
    } else if ($country_code == 'Jersey') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/feed/");
    } else if ($country_code == 'Kosovo') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/kosovo/feed/");
    } else if ($country_code == 'Macau') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/macau-china/feed/");
    } else if ($country_code == 'Marshall Islands') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/marshall-islands/feed/");
    } else if ($country_code == 'Micronesia') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/feed/");
    } else if ($country_code == 'Montenegro') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/montenegro/feed/");
    } else if ($country_code == 'Montserrat') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/montserrat/feed/");
    } else if ($country_code == 'Nauru') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/feed/");
    } else if ($country_code == 'North Korea') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/north-korea/feed/");
    } else if ($country_code == 'Northern Mariana Islands') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/puerto-rico-us/feed/");
    } else if ($country_code == 'Norfolk Island') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/trinidad-tobago/feed/");
    } else if ($country_code == 'Palestine') {
        $url = ("https://globalvoicesonline.org/-/world/middle-east-north-africa/palestine/feed/");
    } else if ($country_code == 'Pitcairn Islands') {
        $url = ("https://globalvoicesonline.org/-/world/oceania/feed/");
    } else if ($country_code == 'Puerto Rico') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/puerto-rico-us/feed/");
    } else if ($country_code == 'Sao Tome and Principe') {
        $url = ("https://globalvoicesonline.org/-/world/sub-saharan-africa/sao-tome-and-principe/feed/");
    } else if ($country_code == 'Serbia') {
        $url = ("https://globalvoicesonline.org/-/world/eastern-central-europe/serbia/feed/");
    } else if ($country_code == 'South Georgia and the Islands') {
        $url = ("https://globalvoicesonline.org/-/world/latin-america/argentina/feed/");
    } else if ($country_code == 'Timor Leste') {
        $url = ("https://globalvoicesonline.org/-/world/east-asia/east-timor/feed/");
    } else if ($country_code == 'Vatican City') {
        $url = ("https://globalvoicesonline.org/-/world/western-europe/vatican-city/feed/
	");
    } else if ($country_code == 'Virgin Islands of the United States') {
        $url = ("https://globalvoicesonline.org/-/world/caribbean/us-virgin-islands/feed/");
    } else {
        $url = ("https://globalvoicesonline.org/-/world/feed/");
    }
}


if ($feed == "art") {
    $nxttab = "sport";
    $url = "https://globalvoicesonline.org/-/topics/film/feed/";
}
if ($feed == "sport") {
    $nxttab = "politics";
    $url = "https://globalvoicesonline.org/-/topics/sport/feed/";
}
if ($feed == "politics") {
    $nxttab = "business";
    $url = "https://globalvoicesonline.org/-/topics/politics/feed/";
}
if ($feed == "business") {
    $nxttab = "sci";
    $url = "https://globalvoicesonline.org/-/topics/economics-business/feed/";
}
if ($feed == "sci") {
    $nxttab = "tech";
    $url = "https://globalvoicesonline.org/-/topics/science/feed/";
}
if ($feed == "tech") {
    $nxttab = "health";
    $url = "https://globalvoicesonline.org/-/topics/technology/feed/";
}
if ($feed == "health") {
    $nxttab = "disaster";
    $url = "https://globalvoicesonline.org/-/topics/health/feed/";
}
if ($feed == "disaster") {
    $nxttab = "culture";
    $url = "https://globalvoicesonline.org/-/topics/disaster/feed/";
}
if ($feed == "culture") {
    $nxttab = "travel";
    $url = "https://globalvoicesonline.org/-/topics/arts-culture/feed/";
}
if ($feed == "travel") {
    $nxttab = "qbnews";
    $url = "https://globalvoicesonline.org/-/topics/travel/feed/";
}

if ($url <> "") $url = $url;

if ($url <> "") {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/simple_rss/autoloader.php');
    $simple_rss = new SimplePie();
    $simple_rss->set_feed_url($url);
    $simple_rss->enable_cache(false);
    $simple_rss->init();

    $itemCount = $simple_rss->get_item_quantity();
    $items = $simple_rss->get_items();

    // copy item if img / video found in node
    $items = $simple_rss->get_items();

} else {

    $csql = mysqli_query($con, "select * from geo_country where country_title='" . $country_code . "'") or die(mysqli_error($con));
    $cres = mysqli_fetch_array($csql);
    $nquery1 = "SELECT * FROM news WHERE country_id = '$country_id' AND status != 0 ORDER BY news_id DESC LIMIT 20";
    $nsql1 = mysqli_query($con, $nquery1) or die(mysql_error($con));

    $nres1 = mysqli_fetch_array($nsql1);
    $item = array();
    $item['title'] = $nres1['title'];
    $item['link'] = $nres1['url'];
    $item['img'] = '<img src="' . $nres1['image_url'] . '" width="140" height="140" alt="' . $nres1['title'] . '"/>';
    if ($item['img'] <> "") $nodes[] = $item;
}

?>
<!doctype html>
<html>
<head>
    <title>Rss</title>
    <!-- jQuery library (served from Google) -->
    <script src="<?php echo $base_url; ?>js/jquery-1.10.2.min.js"></script>
    <!-- bxSlider Javascript file -->
    <script src="<?php echo $base_url; ?>js/jquery.bxslider.min.js"></script>
    <!-- bxSlider CSS file -->
    <link href="<?php echo $base_url; ?>css/jquery.bxslider.css" rel="stylesheet"/>
    <!-- fitvids Javascript file -->
    <script src="<?php echo $base_url; ?>js/jquery.fitvids.js"></script>
    <script type="text/javascript">


        $(document).ready(function () {
            $('.bxslider').bxSlider({
                auto: true,
                speed: '500',
                slideWidth: '400px',
                adaptiveHeight: '550px',
                pager: false,
                autoHover: true,

                video: true,
                onSlideAfter: function ($slideElement, oldIndex, newIndex) {
                    var itemCnt = document.getElementById("items").value;
                    itemCnt = itemCnt - 1;

                    if (newIndex == itemCnt) {
                        var ntab = document.getElementById("nxttab").value;
                        //parent.showMe(ntab);
                    }
                }
            });
        });

    </script>
</head>

<body>
<div style="height:300px;">
    <input type="hidden" id="nxttab" value="<?= $nxttab ?>"/>
    <?php

    if ($feed == "qbnews" || $_REQUEST['qb'] == "qbnews") {
        if ($count_news == 0) {
            $act_count_news = 1;
        } else {
            $act_count_news = $count_news;
        }
        ?>
        <input type="hidden" id="items" value="<?php echo $act_count_news; ?>"/>
        <?php
    } else if ($feed == "news") {
        $st_news_count = mysqli_num_rows(mysqli_query($con, "select * from news where status=1 AND country_id = '$country_id' order by news_id desc LIMIT 20"));
        //echo  $st_news_count;
        $act_news_items = $st_news_count + $itemCount;
        ?>
        <input type="hidden" id="items" value="<?= $act_news_items ?>"/>

        <?php
    } else if ($feed == "art") {

        $st_art_count = mysqli_num_rows(mysqli_query($con, "select * from news where category_id=10 AND status=1 AND country_id = '$country_id' order by news_id desc LIMIT 20"));
        //echo  $st_art_count;
        $act_art_items = $st_art_count + $itemCount;
        ?>
        <input type="hidden" id="items" value="<?= $act_art_items ?>"/>
        <?php
    } else if ($feed == "sport") {
        $st_sport_count = mysqli_num_rows(mysqli_query($con, "select * from news where category_id=1 AND status=1 AND country_id = '$country_id' order by news_id desc LIMIT 20"));
        //echo  $st_sport_count;
        $act_sport_items = $st_sport_count + $itemCount;

        ?>
        <input type="hidden" id="items" value="<?= $act_sport_items ?>"/>
        <?php
    } else if ($feed == "politics") {
        $st_politics_count = mysqli_num_rows(mysqli_query($con, "select * from news where category_id=3 AND status=1 AND country_id = '$country_id' order by news_id desc LIMIT 20"));
        //echo  $st_politics_count;
        $act_politics_items = $st_politics_count + $itemCount;

        ?>
        <input type="hidden" id="items" value="<?= $act_politics_items ?>"/>
        <?php
    } else if ($feed == "business") {
        $st_business_count = mysqli_num_rows(mysqli_query($con, "select * from news where category_id=6 AND status=1 AND country_id = '$country_id' order by news_id desc LIMIT 20"));
        //echo  $st_business_count;
        $act_business_items = $st_business_count + $itemCount;

        ?>
        <input type="hidden" id="items" value="<?= $act_business_items ?>"/>
        <?php
    } else if ($feed == "tech") {
        $st_tech_count = mysqli_num_rows(mysqli_query($con, "select * from news where category_id=7 AND status=1 AND country_id = '$country_id' order by news_id desc LIMIT 20"));
        //echo  $st_tech_count;
        $act_tech_items = $st_tech_count + $itemCount;

        ?>
        <input type="hidden" id="items" value="<?= $act_tech_items ?>"/>
        <?php
    } else
        if ($feed == "health") {
            $st_health_count = mysqli_num_rows(mysqli_query($con, "select * from news where category_id=8 AND status=1 AND country_id = '$country_id' order by news_id desc LIMIT 20"));
            //echo  $st_health_count;
            $act_health_items = $st_health_count + $itemCount;

            ?>
            <input type="hidden" id="items" value="<?= $act_health_items ?>"/>
            <?php
        } else
            if ($feed == "disaster") {
                $st_disaster_count = mysqli_num_rows(mysqli_query($con, "select * from news where category_id=5 AND status=1 AND country_id = '$country_id' order by news_id desc LIMIT 20"));
                //echo  $st_disaster_count;
                $act_disaster_items = $st_disaster_count + $itemCount;

                ?>
                <input type="hidden" id="items" value="<?= $act_disaster_items ?>"/>
                <?php
            } else
                if ($feed == "culture") {
                    $st_culture_count = mysqli_num_rows(mysqli_query($con, "select * from news where category_id=11 AND status=1 AND country_id = '$country_id' order by news_id desc LIMIT 20"));
                    //echo  $st_culture_count;
                    $act_culture_items = $st_culture_count + $itemCount;

                    ?>
                    <input type="hidden" id="items" value="<?= $act_culture_items ?>"/>
                    <?php
                } else
                    if ($feed == "travel") {
                        $st_travel_count = mysqli_num_rows(mysqli_query($con, "select * from news where category_id=4 AND status=1 AND country_id = '$country_id' order by news_id desc LIMIT 20"));
                        //echo  $st_travel_count;
                        $act_travel_items = $st_travel_count + $itemCount;

                        ?>
                        <input type="hidden" id="items" value="<?= $act_travel_items ?>"/>
                        <?php
                    }
    ?>
    <?php if ($url <> "") { ?>
        <ul class="bxslider">

            <!--news!-->
            <?php
            //echo $feed;
            if ($feed == "news") {
                $sql_news = "select * from news where status=1 AND country_id = '$country_id' order by news_id desc";
                $st_news = mysqli_query($con, $sql_news);
                while ($rownews = mysqli_fetch_array($st_news)) {
                    ?>
                    <li>
                        <div style="height:80px; overflow:hidden; font-size:20px; font-weight:400;"><a
                                href="../news_detail.php?url=<?php echo $rownews['url']; ?>"
                                target="_blank"><?php echo $rownews['title']; ?></a></div>
                        <?php if ($rownews['image_url'] != "") {
                            ?>
                            <img src="<?php echo $rownews['image_url']; ?>" width="140" height="140"
                                 alt="<?php echo $rownews['title']; ?>"/>
                            <center class="show-cmt"><font color="blue">Quakbox</font></center>
                            <?php
                        }
                        ?>

                    </li>
                    <?php
                }

            }
            ?>


            <!--news ends!-->

            <!--entertainment starts!-->

            <?php

            //echo $feed;
            if ($feed == "art") {
                $sql_art = "select * from news where category_id=1 && status=1 && country_id = '$country_id' order by news_id desc LIMIT 20";
                $st_art = mysqli_query($con, $sql_art);
                while ($rowart = mysqli_fetch_array($st_art)) {
                    ?>
                    <li>
                        <div style="height:80px; overflow:hidden; font-size:20px; font-weight:400;"><a
                                href="../news_detail.php?url=<?php echo $rowart['url']; ?>"
                                target="_blank"><?php echo $rowart['title']; ?></a></div>
                        <?php if ($rowart['image_url'] != "") {
                            ?>
                            <img src="<?php echo $rowart['image_url']; ?>" width="140" height="140"
                                 alt="<?php echo $rowart['title']; ?>"/>
                            <center class="show-cmt"><font color="blue">Quakbox</font></center>
                            <?php
                        }
                        ?>

                    </li>
                    <?php
                }

            }
            ?>

            <!--entertainment ends!-->

            <!--sport starts !-->

            <?php
            //echo $feed;
            if ($feed == "sport") {
                $sql_art = "select * from news where category_id=2 && status=1 && country_id = '$country_id' order by news_id desc LIMIT 20";
                $st_art = mysqli_query($con, $sql_art);
                while ($rowart = mysqli_fetch_array($st_art)) {
                    ?>
                    <li>
                        <div style="height:80px; overflow:hidden; font-size:20px; font-weight:400;"><a
                                href="../news_detail.php?url=<?php echo $rowart['url']; ?>"
                                target="_blank"><?php echo $rowart['title']; ?></a></div>
                        <?php if ($rowart['image_url'] != "") {
                            ?>
                            <img src="<?php echo $rowart['image_url']; ?>" width="140" height="140"
                                 alt="<?php echo $rowart['title']; ?>"/>
                            <center class="show-cmt"><font color="blue">Quakbox</font></center>
                            <?php
                        }
                        ?>

                    </li>
                    <?php
                }

            }
            ?>

            <!--sport ends!-->
            <!--politics starts!-->
            <?php
            //echo $feed;
            if ($feed == "politics") {
                $sql_art = "select * from news where category_id=3 && status=1 && country_id = '$country_id' order by news_id desc LIMIT 20";
                $st_art = mysqli_query($con, $sql_art);
                while ($rowart = mysqli_fetch_array($st_art)) {
                    ?>
                    <li>
                        <div style="height:80px; overflow:hidden; font-size:20px; font-weight:400;"><a
                                href="../news_detail.php?url=<?php echo $rowart['url']; ?>"
                                target="_blank"><?php echo $rowart['title']; ?></a></div>
                        <?php if ($rowart['image_url'] != "") {
                            ?>
                            <img src="<?php echo $rowart['image_url']; ?>" width="240" height="240"
                                 alt="<?php echo $rowart['title']; ?>"/>
                            <center class="show-cmt"><font color="blue">Quakbox</font></center>
                            <?php
                        }
                        ?>

                    </li>
                    <?php
                }

            }
            ?>

            <!--politics ends!-->
            <!--business starts!-->
            <?php
            //echo $feed;
            if ($feed == "business") {
                $sql_art = "select * from news where category_id=6 && status=1 && country_id = '$country_id' order by news_id desc LIMIT 20";
                $st_art = mysqli_query($con, $sql_art);
                while ($rowart = mysqli_fetch_array($st_art)) {
                    ?>
                    <li>
                        <div style="height:80px; overflow:hidden; font-size:20px; font-weight:400;"><a
                                href="../news_detail.php?url=<?php echo $rowart['url']; ?>"
                                target="_blank"><?php echo $rowart['title']; ?></a></div>
                        <?php if ($rowart['image_url'] != "") {
                            ?>
                            <img src="<?php echo $rowart['image_url']; ?>" width="240" height="240"
                                 alt="<?php echo $rowart['title']; ?>"/>
                            <center class="show-cmt"><font color="blue">Quakbox</font></center>
                            <?php
                        }
                        ?>

                    </li>
                    <?php
                }

            }
            ?>

            <!--business ends!-->

            <!--technology start!-->
            <?php
            //echo $feed;
            if ($feed == "tech") {
                $sql_art = "select * from news where category_id=7 && status=1 && country_id = '$country_id' order by news_id desc LIMIT 20";
                $st_art = mysqli_query($con, $sql_art);
                while ($rowart = mysqli_fetch_array($st_art)) {
                    ?>
                    <li>
                        <div style="height:80px; overflow:hidden; font-size:20px; font-weight:400;"><a
                                href="../news_detail.php?url=<?php echo $rowart['url']; ?>"
                                target="_blank"><?php echo $rowart['title']; ?></a></div>
                        <?php if ($rowart['image_url'] != "") {
                            ?>
                            <img src="<?php echo $rowart['image_url']; ?>" width="240" height="240"
                                 alt="<?php echo $rowart['title']; ?>"/>
                            <center class="show-cmt"><font color="blue">Quakbox</font></center>
                            <?php
                        }
                        ?>

                    </li>
                    <?php
                }

            }
            ?>
            <!--technology ends!-->

            <?php
            //echo $feed;
            if ($feed == "health") {
                $sql_art = "select * from news where category_id=8 && status=1 && country_id = '$country_id' order by news_id desc LIMIT 20";
                $st_art = mysqli_query($con, $sql_art);
                while ($rowart = mysqli_fetch_array($st_art)) {
                    ?>
                    <li>
                        <div style="height:80px; overflow:hidden; font-size:20px; font-weight:400;"><a
                                href="../news_detail.php?url=<?php echo $rowart['url']; ?>"
                                target="_blank"><?php echo $rowart['title']; ?></a></div>
                        <?php if ($rowart['image_url'] != "") {
                            ?>
                            <img src="<?php echo $rowart['image_url']; ?>" width="240" height="240"
                                 alt="<?php echo $rowart['title']; ?>"/>
                            <center class="show-cmt"><font color="blue">Quakbox</font></center>
                            <?php
                        }
                        ?>

                    </li>
                    <?php
                }

            }
            ?>
            <!--health ends!-->
            <!-- life style starts !-->
            <?php
            //echo $feed;
            if ($feed == "disaster") {
                $sql_art = "select * from news where category_id=5 && status=1 && country_id = '$country_id' order by news_id desc LIMIT 20";
                $st_art = mysqli_query($con, $sql_art);
                while ($rowart = mysqli_fetch_array($st_art)) {
                    ?>
                    <li>
                        <div style="height:80px; overflow:hidden; font-size:20px; font-weight:400;"><a
                                href="../news_detail.php?url=<?php echo $rowart['url']; ?>"
                                target="_blank"><?php echo $rowart['title']; ?></a></div>
                        <?php if ($rowart['image_url'] != "") {
                            ?>
                            <img src="<?php echo $rowart['image_url']; ?>" width="240" height="240"
                                 alt="<?php echo $rowart['title']; ?>"/>
                            <center class="show-cmt"><font color="blue">Quakbox</font></center>
                            <?php
                        }
                        ?>

                    </li>
                    <?php
                }

            }
            ?>

            <!--life style ends !-->
            <!--culture starts!-->
            <?php
            //echo $feed;
            if ($feed == "culture") {
                $sql_art = "select * from news where category_id=11 && status=1 && country_id = '$country_id' order by news_id desc LIMIT 20";
                $st_art = mysqli_query($con, $sql_art);
                while ($rowart = mysqli_fetch_array($st_art)) {
                    ?>
                    <li>
                        <div style="height:80px; overflow:hidden; font-size:20px; font-weight:400;"><a
                                href="../news_detail.php?url=<?php echo $rowart['url']; ?>"
                                target="_blank"><?php echo $rowart['title']; ?></a></div>
                        <?php if ($rowart['image_url'] != "") {
                            ?>
                            <img src="<?php echo $rowart['image_url']; ?>" width="240" height="240"
                                 alt="<?php echo $rowart['title']; ?>"/>
                            <center class="show-cmt"><font color="blue">Quakbox</font></center>
                            <?php
                        }
                        ?>

                    </li>
                    <?php
                }

            }
            ?>

            <!--culture ends !-->
            <!--travel starts !-->
            <?php
            //echo $feed;
            if ($feed == "travel") {
                $sql_art = "select * from news where category_id=4 && status=1 && country_id = '$country_id' order by news_id desc LIMIT 20";
                $st_art = mysqli_query($con, $sql_art);
                while ($rowart = mysqli_fetch_array($st_art)) {
                    ?>
                    <li>
                        <div style="height:80px; overflow:hidden; font-size:20px; font-weight:400;"><a
                                href="../news_detail.php?url=<?php echo $rowart['url']; ?>"
                                target="_blank"><?php echo $rowart['title']; ?></a></div>
                        <?php if ($rowart['image_url'] != "") {
                            ?>
                            <img src="<?php echo $rowart['image_url']; ?>" width="240" height="240"
                                 alt="<?php echo $rowart['title']; ?>"/>
                            <center class="show-cmt"><font color="blue">Quakbox</font></center>
                            <?php
                        }
                        ?>

                    </li>
                    <?php
                }

            }
            ?>

            <!-- travel ends !-->

            <?php

            foreach ($items as $node) {
                $image = image_from_description($node->get_content());
                //$image = str_replace("http", "https", $image1);
                //echo $image;
                if ($enclosure = $node->get_enclosure()) {
                    ?>
                    <li>
                        <div style="height:70px; overflow:hidden; font-size:16px;"><a
                                style="color:#00A5FF; text-decoration:none;"
                                href="<?php echo $node->get_permalink(); ?>"
                                target="_blank"><?= $node->get_title(); ?></a></div>
                        <?php //print_r( $node->get_content());?>


                        <?php if ($image <> "") {
                            echo $image;
                        } else {
                            echo '<img src="' . $base_url . 'images/default-news.png" width="240" height="240">';
                        }
                        echo '<center class="show-cmt"><font color="blue">Globalvoices </font><center>';
                        ?>
                    </li>
                <?php }
            } ?>
        </ul>
    <?php } else {
        ?>
        <ul class="bxslider">


            <?php

            foreach ($nodes as $node) {
                ?>
                <li>
                    <div style="height:70px; overflow:hidden; font-size:16px;"><a
                            style="color:#00A5FF; text-decoration:none;"
                            href="news_detail.php?url=<?php echo $node['link']; ?>"
                            target="_blank"><?= $node['title'] ?></a></div>
                    <?php
                    if ($count_news != 0) {
                        if ($node['img'] <> "") echo $node['img'];
                        if ($node['video'] <> "") echo $node['video'];
                        echo '<center class="show-cmt"><font color="blue">Quakbox </font><center>';
                    }
                    ?>
                </li>
            <?php } ?>


        </ul>
    <?php } ?>
</div>
</body>
</html>