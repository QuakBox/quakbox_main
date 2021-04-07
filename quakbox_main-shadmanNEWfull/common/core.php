<?php

if(!defined('QB_CONFIG')) {
    require_once(__DIR__ . '/../config.php');
}
require_once('database.php');

/* Member functions */

class QB_Core
{
    public function startup($checkIfUserLoggedIn = true)
    {
        ob_start();
        session_start();

        if ($checkIfUserLoggedIn && !self::isLoggedIn()) {
            self::goToLoginPage();
        }
    }

    private static function goToLoginPage()
    {
        header("location: /index.php");
        exit();
    }

    public static function getLoggedMemberId()
    {
        return isset($_SESSION['SESS_MEMBER_ID']) ? $_SESSION['SESS_MEMBER_ID'] : 0;
    }

    public static function isLoggedIn()
    {
        if (!isset($_SESSION['SESS_MEMBER_ID'])) {
            return false;
        }

        return true;
    }
}

function strip_only($str, $tags, $stripContent = false)
{
    $content = '';
    if (!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if (end($tags) == '') array_pop($tags);
    }
    foreach ($tags as $tag) {
        if ($stripContent)
            $content = '(.+</' . $tag . '[^>]*>|)';
        $str = preg_replace('#</?' . $tag . '[^>]*>' . $content . '#is', '', $str);
    }
    return $str;
}

