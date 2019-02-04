<?php
//Srinivas Tamada http://9lessons.info
//Loading Comments link with load_updates.php 

if (!isset($_SESSION)) {
    session_start();
}

function time_stamp($session_time)
{
    $time_difference = time() - $session_time;
    $seconds = $time_difference;
    $minutes = round($time_difference / 60);
    $hours = round($time_difference / 3600);
    $days = round($time_difference / 86400);
    $weeks = round($time_difference / 604800);
    $months = round($time_difference / 2419200);
    $years = round($time_difference / 29030400);
    error_reporting(-1);


    if (isset($_SESSION['lang'])) {
        include($_SERVER['DOCUMENT_ROOT'] . '/common.php');
    } else {
        include($_SERVER['DOCUMENT_ROOT'] . '/Languages/en.php');

    }
    if ($seconds <= 60) {
        echo "$seconds " . $lang['seconds ago'];
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            echo $lang['one minute ago'];
        } else {
            echo "$minutes " . $lang['minutes ago'];
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            echo $lang['one hour ago'];
        } else {
            echo "$hours " . $lang['hours ago'];
        }
    } else if ($days <= 7) {
        if ($days == 1) {
            echo $lang['one day ago'];
        } else {
            echo "$days " . $lang['days ago'];
        }


    } else if ($weeks <= 4) {
        if ($weeks == 1) {
            echo $lang['one week ago'];
        } else {
            echo "$weeks " . $lang['weeks ago'];
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            echo $lang['one month ago'];
        } else {
            echo "$months " . $lang['months ago'];
        }
    } else {
        if ($years == 1) {
            echo $lang['one year ago'];
        } else {
            echo "$years " . $lang['years ago'];
        }
    }
}


function time_stamp_vj($session_time)
{
    $time_difference = time() - $session_time;
    $seconds = $time_difference;
    $minutes = round($time_difference / 60);
    $hours = round($time_difference / 3600);
    $days = round($time_difference / 86400);
    $weeks = round($time_difference / 604800);
    $months = round($time_difference / 2419200);
    $years = round($time_difference / 29030400);

    if (isset($_SESSION['lang'])) {
        include($_SERVER['DOCUMENT_ROOT'] . '/common.php');
    } else {
        include($_SERVER['DOCUMENT_ROOT'] . '/Languages/en.php');

    }

    if ($seconds <= 60) {
        return "$seconds " . $lang['seconds ago'];
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return $lang['one minute ago'];
        } else {
            return "$minutes " . $lang['minutes ago'];
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return $lang['one hour ago'];
        } else {
            return "$hours " . $lang['hours ago'];
        }
    } else if ($days <= 7) {
        if ($days == 1) {
            return $lang['one day ago'];
        } else {
            return "$days " . $lang['days ago'];
        }


    } else if ($weeks <= 4) {
        if ($weeks == 1) {
            return $lang['one week ago'];
        } else {
            return "$weeks " . $lang['weeks ago'];
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return $lang['one month ago'];
        } else {
            return "$months " . $lang['months ago'];
        }


    } else {
        if ($years == 1) {
            return $lang['one year ago'];
        } else {
            return "$years " . $lang['years ago'];
        }


    }

}

function timedifferenceindays($session_time)
{
    $time_difference = time() - $session_time;
    $seconds = $time_difference;
    $minutes = round($time_difference / 60);
    $hours = round($time_difference / 3600);
    $days = round($time_difference / 86400);
    return $days;
}

