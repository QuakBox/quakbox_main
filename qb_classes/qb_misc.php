<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/qb_classes/connection/qb_database.php");

class misc
{

    function getRandom3countries()
    {
        $sql = "select * from geo_country where country_id!=207 order by rand() LIMIT 3";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function getallcountries()
    {
        $sql = "select * from geo_country where country_id!=207 order by country_title asc ";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function getcountryByCode($country_code)
    {
        $sql = "select * from geo_country where code='" . $country_code . "'";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function getcountryByID($country_id)
    {
        $sql = "select * from geo_country where country_id='" . $country_id . "'";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function getcountryIdByName($country_title)
    {
        $sql = "select country_id from geo_country where country_title ='" . $country_title . "'";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            return $row['country_id'];
        } else {
            return null;
        }
    }

    function getRandom3Countryfans($country_code)
    {
        $sql = "SELECT * FROM favourite_country f LEFT JOIN member m ON m.member_id = f.member_id WHERE f.code = '" . $country_code . "' order by rand()  LIMIT 3";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;

    }

    function getRandom3CountryPeoples($country_code)
    {
        $sql = "SELECT m.member_id,m.username,m.displayname FROM member m JOIN member_meta mm on m.member_id = mm.member_id WHERE mm.meta_key='country' and mm.meta_value='" . $country_code . "' order by rand()  LIMIT 3";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function insertUserUploads($filename, $memeberID)
    {
        $itime = time();
        $sql = "INSERT INTO user_uploads(image_name,user_id_fk,created) VALUES('" . $filename . "','$memeberID','$itime')";
        $db_Obj = new database();
        $rs = $db_Obj->insertQueryReturnLastID($sql);
        return $rs;
    }

    function getUploadedImagenameByID($uploadID)
    {
        $sql = "SELECT image_name FROM user_uploads WHERE upload_id = '$uploadID'";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function getFavCountry($memeberID)
    {
        $sql = "select c.code,c.country_title from favourite_country f,geo_country c where f.code=c.code and f.favourite_country=1 and member_id = '" . $memeberID . "'";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function getFriendsRequest($memeberID, $limit)
    {
        if ($limit > 0) {
            $sql = "select * from friendlist f,member m where m.member_id=f.added_member_id and f.status = 0 and f.member_id = '" . $memeberID . "' Limit $limit";
        } else {
            $sql = "select * from friendlist f,member m where m.member_id=f.added_member_id and f.status = 0 and  f.member_id = '" . $memeberID . "'";
        }
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        $sql2 = "UPDATE friendlist SET  is_unread=1 WHERE member_id='" . $memeberID . "'";
        $db_Obj2 = new database();
        $rs = $db_Obj2->execQuery($sql2);
        return $results;
    }

    function getcountOfUnreadedFriendsRequest($memeberID)
    {

        $sql = "select count(f.member_id) AS count from friendlist f,member m where f.member_id = m.member_id AND f.member_id = '" . $memeberID . "' AND is_unread = 0";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function getCountOfFriendsRequestStatus($loggedInMemberID, $memberID)
    {
        $sql = "select count(friends_id) AS count from friendlist where (added_member_id IN ($memberID,$loggedInMemberID) AND member_id IN ($memberID,$loggedInMemberID) AND status = 1) or (added_member_id= '$memberID' and member_id ='$loggedInMemberID' and TIMESTAMPDIFF(HOUR,from_unixtime(sent),NOW()) <24)  ;";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function checkPrivacyOfMember($memberID)
    {
        $sql = "select * from privacy where privacy_member_id = '" . $memberID . "'";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function getFriendsListCount($memberID)
    {

        $sql = "select count(m.member_id) as count from friendlist f,member m,qb_lookup l where f.added_member_id=m.member_id and f.member_id='$memberID' AND f.status != 0 and m.status=l.lookup_key  AND l.lookup_value ='ACTIVE' ;";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

//Edited by Yasser and Mushira
    function getFriendsList($memberID)
    {

        $sql = "select m.member_id, m.username, m.displayname, m.email from friendlist f,member m,qb_lookup l where f.added_member_id=m.member_id and f.member_id='$memberID' AND f.status != 0 and m.status=l.lookup_key  AND l.lookup_value ='ACTIVE' ;";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }

    function getFriendsRequestStatus($loggedInMemberID, $memberID)
    {
        $sql = "select count(friends_id) as count from friendlist where  (  ( added_member_id = '$loggedInMemberID' and member_id='$memberID' ) or (added_member_id = '$memberID' and member_id='$loggedInMemberID')  ) AND status = 0 ";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;

    }

    function getFriendsRequestStatusCount1($loggedInMemberID, $memberID)
    {
        $sql = "select count(friends_id) as count from friendlist where added_member_id = '$loggedInMemberID' and member_id='$memberID' AND status = 0 ";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;

    }

    public function canIAccessMember($myId, $memberId)
    {
        $friends = $this->getFriendsList($myId);
        if(!empty($friends)){
            foreach($friends as $friend){
                if($friend['member_id'] == $memberId){
                    return true;
                }
            }
        }

        return false;
    }

    function getFriendsRequestStatusCount2($loggedInMemberID, $memberID)
    {
        $sql = "select count(friends_id) as count from friendlist where added_member_id = '$memberID' and member_id='$loggedInMemberID' AND status = 0 ";
        $db_Obj = new database();
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;

    }



// Get members favourite a specific country 
// Input : country code, Output : list of interested people emails
    function get_country_fans_emails($country_code)
    {
        $members_emails = "";
        $db_Obj = new database();
        $sql = "SELECT `member`.`email` FROM `favourite_country` INNER JOIN `member` ON `member`.`member_id` = `favourite_country`.`member_id` WHERE `favourite_country`.`code` = '$country_code'";
        $results = $db_Obj->execQueryWithFetchAll($sql);
        foreach ($results as $row) {
            $members_emails = $members_emails . "," . $row['email'];
        }
        return $members_emails;
    }


// Get members favourite a specific country 
// Input : country code, Output : list of interested people emails
    function get_country_fans_Ids($country_id, $member_id)
    {
        $db_Obj = new database();
        $sql = "SELECT `member`.`member_id` FROM `favourite_country` INNER JOIN `member` ON `member`.`member_id` = `favourite_country`.`member_id` WHERE `favourite_country`.`code` = (SELECT code FROM geo_country WHERE country_id =$country_id)
 AND member.member_id <> $member_id";
        echo $sql;
        $results = $db_Obj->execQueryWithFetchAll($sql);
        return $results;
    }


}

