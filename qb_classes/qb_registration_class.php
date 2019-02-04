<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/qb_classes/connection/qb_database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_lookup.php');

class registration
{

    var $profilePreferencevalue;
    var $memberID;
    var $profilePreferenceKey;

    const SocialNetworkGoogle = 'google';
    const SocialNetworkFacebook = 'facebook';

    public function loginUser($userId)
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');

        $_SESSION['SESS_MEMBER_ID'] = $userId;
        $_SESSION['userid'] = $userId;

        $ip = $_SERVER['REMOTE_ADDR'];
        $memberObject = new member1();

        $rs = $memberObject->update_member_meta($userId, "ip", $ip);
        $checkFirstTimeLastVisit = $memberObject->select_member_meta_value($userId, "last_visited_on");

        if ($checkFirstTimeLastVisit != null) {
            $rs = $memberObject->update_member_meta($userId, "last_visited_on", date('Y-m-d H:i:s'));
        } else {
            $rs = $memberObject->insert_member_meta($userId, "last_visited_on", date('Y-m-d H:i:s'));
        }
    }

    private function createUsername($displayName)
    {
        $username = trim(strtolower($displayName));
        if(($pos = strpos($username, ' ')) > 0){
            $username = substr($username, 0, $pos);
        }

        $databaseObject = new database();
        $i = 0;
        $newUsername = $username;

        while(true || $i < 1000) {
            $sql = 'SELECT member_id FROM member WHERE username LIKE \''.$newUsername.'\'';
            $row = $databaseObject->fetch($sql);

            if(empty($row)){
                break;
            }

            $i++;
            $newUsername = $username.$i;
        }

        unset($databaseObject);

        return $newUsername;
    }

    public function registerFromSocialNetwork($networkType, $profileId, $dispayName, $email, $avatarUrl)
    {
		/* echo $networkType;
		echo $profileId;
		echo $dispayName;
		echo $email;
		echo $avatarUrl; */
		
        $dbField = $this->getSocialNetworkDbField($networkType);
        if(empty($dbField)){
            return false;
        }

        // Check if user already exits
        $databaseObject = new database();
        $sql = 'SELECT member_id FROM member WHERE '.$dbField.'=\''.$profileId.'\' or email=\''.$email.'\'';
        $row = $databaseObject->fetch($sql);
		//print_r($row);
//echo $sql; exit();
        if(!empty($row) && $row['member_id'] > 0){
            // Record exists
            return $row['member_id'];
        }

        $username = $this->createUsername($dispayName);
        $lookupObject = new lookup();
        $statusId = $lookupObject->getLookupKey("MEMBER STATUS", "ACTIVE");

        $sql = 'INSERT INTO member (password, username, email, qbemail, activation_key, salt, status, dob, displayname, '.$dbField.')';
        $sql .= " VALUES ('SOCIAL_PASSWORD', '".$username."', '".$email."', '', '', 'SOCIAL_PASSWORD', '".$statusId."', '', '".$dispayName."', '".$profileId."')";

        $databaseObject->execQuery($sql);

       $userId = $databaseObject->getLastInsertId();
	 
        if($userId < 1){
            return false;
        }

        // Import image
        if(!empty($avatarUrl)){
            // Save it
            $destFileName = 'profile_photo/'.$userId.'.jpg';
            $destFileNameAbs = $_SERVER['DOCUMENT_ROOT'].'/'.$destFileName;
            if(false !== @file_put_contents($destFileNameAbs, @file_get_contents($avatarUrl))){
                $sql = 'INSERT INTO member_meta SET member_id='.$userId.', meta_key=\'current_profile_image\', meta_value=\''.$destFileName.'\'';
                $databaseObject->execQuery($sql);
            }
        }

        unset($databaseObject, $lookupObject);
        return $userId;
    }

    private function getSocialNetworkDbField($networkType)
    {
        switch ($networkType) {
            case self::SocialNetworkFacebook:
                return 'facebook_id';
            case self::SocialNetworkGoogle:
                return 'google_id';
        }

        return '';
    }

    function insert_registration($password, $username, $qbemail, $email, $activation_code, $salt, $dob)
    {
        //status is inactive at beginning
        $object = new lookup();
        $lookup_id = $object->getLookupKey("MEMBER STATUS", "INACTIVE");
        $sql = "INSERT INTO member(password,username,qbemail,email,activation_key,salt,status,dob) VALUES('$password','$username','$qbemail','$email','$activation_code','$salt','$lookup_id','$dob')";
        $db_Obj = new database();
        $lastID = $db_Obj->insertQueryReturnLastID($sql);
        $profilekeyresult = $this->getProfileRankingKey("General Information");
        $row = $profilekeyresult->fetch_assoc();
        $profilePreferenceKey = $row['profile_preference_key'];
        $this->insert_memberProfileRanking($lastID, $profilePreferenceKey);
        return $lastID;
    }

    function update_DisplayName($memberID, $displayName)
    {
        //status is inactive at beginning
        $sql = "Update member set displayname ='$displayName' where member_id ='$memberID'";
        $db_Obj = new database();
        $rs = $db_Obj->execQuery($sql);
        return $rs;
    }

    function getProfileRankingKey($profilePreferencevalue)
    {
        $profilePreferencevalue = strtolower($profilePreferencevalue);
        $sql = "select profile_preference_key from qb_profile_preference where LOWER(profile_preference_value)='$profilePreferencevalue'";
        $db_Obj = new database();
        $rs = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($rs) == 0) {
            return "Invalid Profile Preference Value";
        } else {
            return $rs;
        }
    }

    function insert_memberProfileRanking($memberID, $profilePreferenceKey)
    {
        $sql = "INSERT INTO qb_member_profile_ranking(member_id,profile_preference_id) VALUES('$memberID','$profilePreferenceKey')";
        $db_Obj = new database();
        $rs = $db_Obj->execQuery($sql);
        return $rs;
    }

    function insert_member_meta($memberID, $metaKey, $metaValue)
    {
        if ($metaKey == "member_registered_on") {
            $sql = "INSERT INTO member_meta(member_id,meta_key,meta_value) VALUES('$memberID','$metaKey',now())";
        } else {
            $sql = "INSERT INTO member_meta(member_id,meta_key,meta_value) VALUES('$memberID','$metaKey','$metaValue')";
        }

        $db_Obj = new database();
        $rs = $db_Obj->execQuery($sql);
        return $rs;
    }

    function skipChekPoints($memberID, $profilePreferencevalue)
    {

        $profilePreferencevalue = strtolower($profilePreferencevalue);
        $profilekeyresult = $this->getProfileRankingKey($profilePreferencevalue);
        $row = $profilekeyresult->fetch_assoc();
        $profilePreferenceKey = $row['profile_preference_key'];
        $rs = $this->insert_memberProfileRanking($memberID, $profilePreferenceKey);
    }


    function insert_country_education_record($country, $state, $city, $organization_name, $organization_type)
    {
        //status is inactive at beginning
        $sql = "INSERT INTO qb_country_education_record(country,state,city,organization_name,organization_type) VALUES('$country','$state','$city','$organization_name','$organization_type')";
        $db_Obj = new database();
        $lastID = $db_Obj->insertQueryReturnLastID($sql);
        return $lastID;
    }

    function insert_member_education_record($memberID, $education_organization, $education_grade, $education_year_from, $education_year_to)
    {
        //status is inactive at beginning
        $sql = "INSERT INTO member_education_history(member_id, education_organization,education_grade,education_year_from,education_year_to) VALUES('$memberID','$education_organization','$education_grade','$education_year_from','$education_year_to')";
        $db_Obj = new database();
        $lastID = $db_Obj->execQuery($sql);
        return $lastID;
    }
}
