<?php

define("DB_SERVER", "localhost");
define("DB_USER", "wwwquakb_main");
define("DB_PASS", "uB#{(J;6rQ-o");
define("DB_NAME", "wwwquakb_maindb");

class database
{
    var $con;
    var $db;
    var $query;

    function database()
    {

        $this->con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysqli_error($this->con));
        $this->db = mysqli_select_db($this->con, DB_NAME);

        if (!$this->con || !$this->db) {
            return 0;
        }

        return $this->con;
    }

    public function getLastInsertId()
    {
        $sql = 'SELECT LAST_INSERT_ID() AS id';
        $row = $this->fetch($sql);

        if(empty($row)){
            return 0;
        }

        return $row['id'];
    }

    public function fetch($sql)
    {
        if (empty($sql)) {
            return false;
        }

        $queryResource = mysqli_query($this->con, $sql);
        if ($queryResource) {
            $result = mysqli_fetch_array($queryResource);
            return $result;
        }

        return [];
    }

    // return one value result
    function getOne($query, $index = 0)
    {
        if (!$query)
            return false;
        $res = mysqli_query($this->con, $query);
        $arr_res = array();
        if ($res && mysqli_num_rows($res))
            $arr_res = mysqli_fetch_array($res);
        if (count($arr_res))
            return $arr_res[$index];
        else
            return false;
    }

// executing sql
    function res($query, $error_checking = true)
    {
        if (!$query)
            return false;
        $res = mysqli_query($this->con, $query);
        if (!$res)
            $this->error('Database query error', false, $query);
        return $res;
    }

// return table of records as result in pairs
    function getPairs($query, $sFieldKey, $sFieldValue, $arr_type = MYSQLI_ASSOC)
    {
        if (!$query)
            return array();

        $res = mysqli_query($this->con, $query);
        $arr_res = array();
        if ($res) {
            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                $arr_res[$row[$sFieldKey]] = $row[$sFieldValue];
            }
            mysqli_free_result($res);
        }
        return $arr_res;
    }

    // return table of records as result
    function getAll($query, $arr_type = MYSQLI_ASSOC)
    {
        if (!$query)
            return array();

        if ($arr_type != MYSQLI_ASSOC && $arr_type != MYSQLI_NUM && $arr_type != MYSQLI_BOTH)
            $arr_type = MYSQLI_ASSOC;

        $res = mysqli_query($this->con, $query);
        $arr_res = array();
        if ($res) {
            while ($row = mysqli_fetch_array($res, $arr_type))
                $arr_res[] = $row;
            mysqli_free_result($res);
        }
        return $arr_res;
    }

    // return one row result
    function getRow($query, $arr_type = MYSQLI_ASSOC)
    {
        if (!$query)
            return array();
        if ($arr_type != MYSQLI_ASSOC && $arr_type != MYSQLI_NUM && $arr_type != MYSQLI_BOTH)
            $arr_type = MYSQLI_ASSOC;
        $res = mysqli_query($this->con, $query);
        $arr_res = array();
        if ($res && mysqli_num_rows($res)) {
            $arr_res = mysqli_fetch_array($res, $arr_type);
            mysqli_free_result($res);
        }
        return $arr_res;
    }

    // escape
    function escape($s)
    {
        return mysqli_real_escape_string(strip_tags($s));
    }

    // get last id
    function lastId()
    {
        return mysqli_insert_id($this->con);
    }

    // display errors
    function error($text, $isForceErrorChecking = false, $sSqlQuery = '')
    {
        echo $text;
        exit;
    }

    function execQueryWithFetchAll($query)
    {
        $this->query = $query;
        $result = mysqli_query($this->con, $this->query);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);

        return $data;
    }

    function insertQueryReturnLastID($query)
    {
        $this->query = $query;
        $result = mysqli_query($this->con, $this->query) or die(mysqli_error($this->con));
        $id = mysqli_insert_id($this->con);
        return $id;
    }

    function execQuery($query)
    {
        $this->query = $query;
        $result = mysqli_query($this->con, $this->query);

        return $result;
    }

    function execQueryWithFetchObject($query)
    {
        $this->query = $query;
        $result = mysqli_query($this->con, $this->query);
        $data = mysqli_fetch_object($result);
        mysqli_free_result($result);
        return $data;
    }

    function cleanString($string)
    {
        $str = @trim($string);
        if (get_magic_quotes_gpc()) {
            $string = stripslashes($string);
        }
        return mysqli_real_escape_string($this->con, $string);
    }
}
