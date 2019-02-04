<?php

function wallGetPopularPhotos()
{
    global $con, $country_code;

    $cacheKey = 'popular-photos-'.!empty($country_code) ? $country_code : 'world';

    if(class_exists('phpFastCache')) {
        $cache = new phpFastCache();

        $result = $cache->get($cacheKey);
        if (!is_null($result)) {
            unset($cache);
            return $result;
        }
    }

    $pquery = "SELECT post.album_id, post.upload_data_id, post.USER_CODE, post.FILE_NAME, post.message_id, post.country_flag, COALESCE(likes.likes_count,0) AS likes_count, COALESCE(shares.shares_count,0) AS shares_count, (COALESCE(likes_count,0) + COALESCE(shares_count,0)) AS Rank FROM (SELECT a.album_id, u.upload_data_id, u.USER_CODE, u.FILE_NAME,u.msg_id AS message_id, country_flag FROM user_album a LEFT JOIN (SELECT upload_data_id, USER_CODE, FILE_NAME, msg_id, album_id FROM upload_data INNER JOIN (SELECT DISTINCT min(upload_data_id) AS upload_id, FILE_NAME AS File FROM upload_data GROUP BY FILE_NAME) AS files ON files.upload_id = upload_data.upload_data_id) u ON a.album_id = u.album_id INNER JOIN message ON u.msg_id = message.messages_id) AS post LEFT OUTER JOIN (SELECT `remarks` AS message_id , count( `bleh_id` ) AS likes_count FROM `bleh` GROUP BY `remarks`) AS likes ON post.message_id = likes.message_id LEFT OUTER JOIN (SELECT `share_id` AS message_id, count(`messages_id`) AS shares_count  FROM `message` WHERE `share_id` <>0 GROUP BY `share_id`) AS shares ON post.message_id = shares.message_id " . (strpos($_SERVER['REQUEST_URI'], 'country') == true ? " WHERE country_flag = '$country_code'" : "") . " ORDER BY Rank DESC LIMIT 4";
    $psql = mysqli_query($con, $pquery);
    $result = [];

    while ($pres = mysqli_fetch_array($psql)) {
        $result[] = $pres;
    }

    if(class_exists('phpFastCache')) {
        $cache->set($cacheKey, $result);
    }
    return $result;
}