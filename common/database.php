<?php

function dbFetchArray($sql)
{
    global $con;

    if(!is_object($con)){
        die('Failed to connect to database server.');
    }

    $res = mysqli_query($con, $sql);
    $result = [];

    if(is_object($res)){
        while($ret = mysqli_fetch_array($res)){
            $result[] = $ret;
        }
    }

    return $result;
}

function dbFetch($sql)
{
    global $con;

    if(!is_object($con)){
        die('Failed to connect to database server.');
    }

    $res = mysqli_query($con, $sql);
    if(is_object($res)){
        $ret = mysqli_fetch_array($res);
        return $ret;
    }

    return [];
}