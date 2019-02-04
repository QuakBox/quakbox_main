<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/qb_classes/connection/qb_database.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_lookup.php');

class member1
{
    var $member_id;
    var $member_displayname;
    var $member_email;
    var $member_current_profile_image;

    function select_member_byID($memberID)
    {
        $sql = "SELECT * FROM member WHERE member_id ='$memberID'";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        return $results;
    }

    function getMemberById($memberId)
    {
        $res = $this->select_member_byID($memberId);
        if (mysqli_num_rows($res) > 0) {
            $row = $res->fetch_assoc();
            return $row;
        }
    }

    function select_member_meta_value($memberID, $meta_key)
    {
        $meta_key = strtolower($meta_key);
        $sql = "SELECT meta_value FROM member_meta WHERE member_id = '$memberID' and LOWER(meta_key)='$meta_key' ORDER BY member_meta_id DESC LIMIT 1";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            return $row['meta_value'];
        } else {
            return null;
        }

    }

    function select_member_meta_value_for_GeoCountry($memberID, $meta_key = "country")
    {
        $meta_key = strtolower($meta_key);
        $sql = "SELECT meta_value FROM member_meta WHERE member_id = '$memberID' and LOWER(meta_key)='$meta_key'";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            $metaVal = $this->select_GeoCountry($row['meta_value']);
            return $metaVal;
        } else {
            return null;
        }

    }

    function select_member_meta_value_for_GeoState($memberID, $meta_key = "state")
    {
        $meta_key = strtolower($meta_key);
        $sql = "SELECT meta_value FROM member_meta WHERE member_id = '$memberID' and LOWER(meta_key)='$meta_key'";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            $metaVal = $this->select_GeoState($row['meta_value']);
            return $metaVal;
        } else {
            return null;
        }

    }

    function select_member_Education_history($memberID)
    {

        $sql = "SELECT * FROM member_education_history a, qb_country_education_record b WHERE a.member_id = '$memberID' and a.education_organization = b.qb_cer_id";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        return $results;

    }

    function select_member_Working_history($memberID)
    {

        $sql = "SELECT * FROM member_working_history a, qb_country_company_record b WHERE a.member_id = '$memberID' and
		a.education_organization = b.qb_ccr_id";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        return $results;

    }

    function select_member_meta_value_for_GeoCity($memberID, $meta_key = "city")
    {
        $meta_key = strtolower($meta_key);
        $sql = "SELECT meta_value FROM member_meta WHERE member_id = '$memberID' and LOWER(meta_key)='$meta_key'";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            $metaVal = $this->select_GeoCity($row['meta_value']);
            return $metaVal;
        } else {
            return null;
        }

    }

    function select_GeoCountry($CountryID)
    {

        $sql = "SELECT country_title FROM geo_country WHERE country_id = '$CountryID' ";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            return $row['country_title'];
        } else {
            return null;
        }

    }

	function select_GeoCountry_code($CountryID)
    {

        $sql = "SELECT code FROM geo_country WHERE country_title = '$CountryID' ";
        
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            return $row['code'];
        } else {
            return null;
        }

    }


	
    function select_GeoState($StateID)
    {

        $sql = "SELECT state_title FROM geo_state WHERE state_id = '$StateID' ";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            return $row['state_title'];
        } else {
            return null;
        }

    }

    function select_GeoCity($CityID)
    {

        $sql = "SELECT city_title,city_id FROM geo_city WHERE city_id = '$CityID' ";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            return $row['city_title'];
        } else {
            return null;
        }

    }

    function select_member_meta_value_for_lookupID($memberID, $meta_key)
    {
        $meta_key = strtolower($meta_key);
        $sql = "SELECT meta_value FROM member_meta WHERE member_id = '$memberID' and LOWER(meta_key)='$meta_key'";
        $db_Obj = new database();
        $lookpup_obj = new lookup();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            $metaVal = $lookpup_obj->getValueByKey($row['meta_value']);
            return $metaVal;
        } else {
            return null;
        }

    }

    function select_multiple_member_meta_value($memberID, $meta_key)
    {
        $meta_key = strtolower($meta_key);
        $sql = "SELECT meta_value FROM member_meta WHERE member_id = '$memberID' and LOWER(meta_key)='$meta_key'";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        return $results;

    }

    function select_checkPoints_FilePath($memberID)
    {
        //Five Checkpoints 1.General Information, 2.Importing Contacts, 3.Additional Information, 4.Contact Information, 5.Education Information
        $generalInfoKey = $this->getProfileRankingKey("General Information");
        $importContactKey = $this->getProfileRankingKey("Importing Contacts");
        $additionalInfoKey = $this->getProfileRankingKey("Additional Information");
        $contactInfoKey = $this->getProfileRankingKey("Contact Information");
        $eduInfoKey = $this->getProfileRankingKey("Education Information");
        $lookupObject = new lookup();
        $lookup_id = $lookupObject->getLookupKey("MEMBER STATUS", "ACTIVE");
        $presql = "SELECT member_id from member WHERE member_id='$memberID' AND status='$lookup_id'";
        $db_Obj = new database();
        $preresults = $db_Obj->execQuery($presql);
        if ($preresults) {
            $activationPath = "home";
        } else {
            $activationPath = "activation.php";
        }

        $importContactPath = "getting_started_import.php";
        $additionalInfoPath = "registerProfile.php";
        $contactInfoPath = "registerContact.php";
        $eduInfoPath = "registerEdu.php";
        $returnPath = null;
        $sql = "SELECT profile_preference_id FROM qb_member_profile_ranking WHERE member_id = '$memberID' ";
        $results = $db_Obj->execQuery($sql);
        if ($results) {
            while ($row = mysqli_fetch_assoc($results)) {

                if ($generalInfoKey == $row['profile_preference_id']) {
                    $returnPath = $importContactPath;
                } else if ($importContactKey == $row['profile_preference_id']) {
                    $returnPath = $additionalInfoPath;
                } else
                    if ($additionalInfoKey == $row['profile_preference_id']) {
                        $returnPath = $contactInfoPath;
                    } else
                        if ($contactInfoKey == $row['profile_preference_id']) {
                            $returnPath = $eduInfoPath;
                        } else
                            if ($eduInfoKey == $row['profile_preference_id']) {
                                $returnPath = $activationPath;
                            }


            }
            return $returnPath;
        } else {
            return null;
        }

    }

    function getProfileRankingKey($profilePreferencevalue)
    {
        $profilePreferencevalue = strtolower($profilePreferencevalue);
        $sql = "select profile_preference_key from qb_profile_preference where LOWER(profile_preference_value)='$profilePreferencevalue'";
        $db_Obj = new database();
        $rs = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($rs) == 1) {
            $row = $rs->fetch_assoc();
            return $row['profile_preference_key'];
        } else {
            return null;
        }

    }

    function insert_member_meta($memberID, $metaKey, $metaValue)
    {
        $metaKey = strtolower($metaKey);
        $sql = "INSERT INTO member_meta(member_id,meta_key,meta_value) VALUES('$memberID','$metaKey','$metaValue')";

        $db_Obj = new database();
        $rs = $db_Obj->execQuery($sql);
        return $rs;
    }

    function update_member_meta($memberID, $metaKey, $metaValue)
    {
        $metaKey = strtolower($metaKey);
        $sql = "UPDATE member_meta set meta_value='$metaValue' where member_id='$memberID' AND LOWER(meta_key)= '$metaKey'";

        $db_Obj = new database();
        $rs = $db_Obj->execQuery($sql);
        return $rs;
    }

    function update_member_columns($memberID, $column_name, $value)
    {
        $column_name = strtolower($column_name);
        $sql = "UPDATE member set $column_name='$value' where member_id='$memberID'";

        $db_Obj = new database();
        $rs = $db_Obj->execQuery($sql);
        return $rs;
    }


    function update_member_dob($memberID, $metaValue)
    {

        $sql = "UPDATE member set dob='$metaValue' where member_id='$memberID' ";

        $db_Obj = new database();
        $rs = $db_Obj->execQuery($sql);
        return $rs;
    }

    function get_member_blocked_status($currentMemberID, $memberID)
    { //
        $sql = "select * from blocklist where userid='$memberID' and blocked_userid='$currentMemberID'";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function searchUser($searchText, $memeberID)
    {
        $db_Obj = new database();
        $searchText = $db_Obj->cleanString($searchText);
        // $sql = "select username,member_id,displayname from member where displayname like '%$searchText%' AND member_id != '$memeberID' AND status=6 order by displayname LIMIT 5";
        $sql = "select username,member_id,displayname from member where username like '%$searchText%' AND member_id != '$memeberID' AND status=6 order by displayname LIMIT 5";

        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function getMemberByUsernameandStatus($username, $statusID)
    {
        $db_Obj = new database();
        $searchText = $db_Obj->cleanString($username);
        $sql = "SELECT * FROM member WHERE username='" . $username . "' AND status=" . $statusID;
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;

    }

    function get_memberFriends($member_id)
    {
        $db_Obj = new database();
        $sql = "SELECT m.member_id FROM friendlist f,member m WHERE f.member_id=m.member_id AND f.added_member_id ='" . $member_id . "' AND f.status != 0";
        $fsql = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($fsql) > 0) {
            while ($fres = mysqli_fetch_array($fsql)) {
                $ids[] = $fres['member_id'];

                $result_row1 = "'";
                $result_row1 .= implode("','", $ids);
                $result_row1 .= "'";
            }

        } else {
            $result_row1 = $member_id;
        }

        return $result_row1;

    }

    function accept_friend_request($Encrypted_login_memberID, $Encrpted_UserId)
    {
        $QbSecurityPost = new QB_SqlInjection();
        $memberID = $QbSecurityPost->QB_AlphaID($Encrypted_login_memberID, true);
        $UserId = $QbSecurityPost->QB_AlphaID($Encrpted_UserId, true);
        $sqlForUpdate = "UPDATE friendlist set status=1 where member_id = $memberID and added_member_id = '$UserId'";
        $db_Obj = new database();
        $time = time();
        $rsForUpdate = $db_Obj->execQuery($sqlForUpdate);

        $sql = "INSERT INTO friendlist (member_id, added_member_id, status, request_status,is_unread,sent)
		VALUES
		('$UserId','$memberID','1',1,1,'$time')";
        $rs = $db_Obj->execQuery($sql);
        return $rs;

        /*$member_sql = mysqli_query($con, "select * from members where member_id='$add_member_id'");
        $member_res = mysqli_fetch_array($member_sql);

        $url = $member_res['username'];
        $time = time();

        $nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)
                        VALUES('$add_member_id','$member_id',7,'$url',0,'$time')";
        mysqli_query($con, $nquery);
                */

    }

    function cancel_friend_request($Encrypted_login_memberID, $Encrpted_UserId)
    {
        $QbSecurityPost = new QB_SqlInjection();
        $db_Obj = new database();
        $memberID = $QbSecurityPost->QB_AlphaID($Encrypted_login_memberID, true);
        $UserId = $QbSecurityPost->QB_AlphaID($Encrpted_UserId, true);

        $sql = "DELETE from friendlist where added_member_id='$UserId' AND member_id = '$memberID'";
        $rs = $db_Obj->execQuery($sql);
        return $rs;


    }

}
