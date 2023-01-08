<?php

namespace Users;

/**
 * This files handles the following 
 * registers new user request
 * creates new login session for users
 * creates logour session for users
 * checks if user's session id exist
 * 
 * @author DiamondScripts Limited
 * @since April 16, 2018
*/

class UserLogs {

    //Constructors allow you to initialise your object's properties
    public function __construct() {
        $this->databaseInstance = new \Database();//this creates  database instance
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->ipAddressInstance = new \IPAddress();
        $this->library = new \Library();
        $this->user = new \Users();

        $tableNames = $this->tablesAndKeys->getTableNames();
    
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->user_login = $tableNames['user_login'];
        $this->users = $tableNames['users'];
        $this->user_initial_report = $tableNames['user_initial_report'];
        $this->user_error_report = $tableNames['user_error_report'];
        $this->user_successful_report = $tableNames['user_successful_report'];
        $this->search = $tableNames['search'];
        $this->unknown_users = $tableNames['unknown_users'];
    }

    //hash user password
    public function secured_hash($password){    
        return password_hash($password, PASSWORD_DEFAULT);
    }

    //format user input
    public function formatInput($input) {
        return trim(stripcslashes(htmlspecialchars($input)));
    }

    //format seller input
    public function dateFormat($dateInput) {
        $formatInput = 'd/m/Y'; //Give any format here, this would be converted into your format

        $formatOut = 'Y-m-d'; // Your format
        return DateTime::createFromFormat($formatInput, $dateInput)->format($formatOut);
    }

    //validate image url
    public function checkImageUrl($url) {
        if (empty($url)) {
            return false;
        }

        if (strpos($url, "http://") === 0 || strpos($url, "https://") === 0) {
            $array = get_headers($url);
            $string = $array[0];
            if (strpos($string, "200")) {
                return true;
            } else {
                return false;
            }
        } else return false;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setUserSessionId($user_ses_id) {
        $this->user_ses_id = $user_ses_id;
    }

    public function setTransactionId($transaction_id) {
        $this->transaction_id = $transaction_id;
    }

    public function setReportType($report_type) {
        $this->report_type = $report_type;
    }

    public function setReportTypeId($report_type_id) {
        $this->report_type_id = $report_type_id;
    }

    public function setGetRequest($get_request) {
        $this->get_request = $get_request;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setState($state = null) {
        $this->state = $state;
    }

    /**
     * @param string $transaction_id
     * @return boolen
     *
    */ 
    public function validateRequest(){

        //first make sure we are not repeating a process
        $query = "SELECT * from $this->user_successful_report where transaction_id = ?";
        $values = array($this->transaction_id);
        $result = $this->databaseInstance->getRows($query, $values);
        
        if (!empty($result))
            throw new \Exception("Request has been sent before");
        
        return true;
    }

    /**
     * @param string $report_type
     * @param string $transaction_id
     * @param int $user_id
     * @param array $get_request
     * @return array
     *
    */ 
    public function createInitialReport(){

        $query = "INSERT into $this->user_initial_report set report_type = ?, user_id = ?, transaction_id = ?, server_request = ?, date_time = ?";
        $values = array($this->report_type, $this->user_id, $this->transaction_id, $this->get_request, date("Y-m-d H:i:s"));
        
        $inserted = $this->databaseInstance->insertRow($query, $values);//send users details for processing    
        
        return $inserted; //return response
    }

    /**
     * @param string $report_type
     * @param string $transaction_id
     * @param string $description
     * @param array $get_request
     * @return array
     *
    */ 
    public function createErrorReport(){

        if (strtolower($this->description) == "request parameters contains invalid json!") return true;
        
        //submit details
        $query = "INSERT into $this->user_error_report set report_type = ?, description = ?, transaction_id = ?, server_request = ?, date_time = ?";
        $values = array($this->report_type, $this->description, $this->transaction_id, $this->get_request, date("Y-m-d H:i:s"));
        
        $inserted = $this->databaseInstance->insertRow($query, $values);//send users details for processing    
        
        return $inserted; //return response
    }

    /**
     * @param string $report_type
     * @param string $transaction_id
     * @param string $description
     * @param array $get_request
     * @return array
     *
    */ 
    public function createSuccessReport($description = null){

        $login_id  = 0;

        if($this->state == null){
            $result = $this->checkUser();
            $login_id = $result->id;
        }
        if($this->state == 'logout' || $this->state == 'loggeg in'){
          $login_id = $this->report_type_id;  
        }

        //submit details
        $query = "INSERT into $this->user_successful_report set login_id = ?, report_type = ?, report_type_id = ?, 
            transaction_id = ?, server_request = ?, user_id = ?, date_time = ?";
        $values = array($login_id, $this->report_type, $this->report_type_id, $this->transaction_id, $this->get_request, 
            $this->user_id, date("Y-m-d H:i:s"));
        
        $inserted = $this->databaseInstance->insertRow($query, $values);//send users details for processing    
        
        return $inserted; //return response
    }  

    /**
     * @param int $user_id
     * @param string $session_id
     * @param string $device_id
     * @return array
     *
    */ 
    public function loginSession($user_id, $user_ses_id, $device_id, $device_name){

        $ip_details = $this->ipAddressInstance->getIPAddressDetails();

        $mode = 'app';
        if ($GLOBALS['web'] == 'web') $mode = $GLOBALS['web'];   

        //submit details
        $query = "INSERT into $this->user_login set user_id = ?, user_ses_id = ?, device_id = ?, 
            status = ?, device_name = ?, login_date_time = ?, ip_address = ?, country = ?, 
            province = ?, city = ?, org = ?, latitude = ?, longitude = ?, time_zone = ?, login_mode = ?";
        $values = array($user_id, $user_ses_id, $device_id, "active", $device_name, date("Y-m-d H:i:s"), 
            $ip_details->ip_address, $ip_details->country, $ip_details->province, $ip_details->city, 
            $ip_details->org, $ip_details->latitude, $ip_details->longitude, $ip_details->time_zone, $mode);
        $login_id = $this->databaseInstance->insertRow($query, $values);

        return $login_id;
    
    }
    //EOF for session login

    //function that registers user logout
    public function logoutSession($login_id) {

        //update details
        $query2 = "UPDATE $this->user_login set status = ?, 
            logout_date_time = ? where id = ?";
        $values2 = array("inactive", date("Y-m-d H:i:s"), $login_id);
        $this->databaseInstance->updateRow($query2, $values2);

        $this->userLastAction();

        $response = array("message" => "Successfully logged out", "login_id" => $login_id);

        return $response;
        
    }

    //function that logout a user from other devices after changing password
    public function logoutFromDevices($login_id, $user_id) {

        //update details
        $query = "UPDATE $this->user_login SET status = ?, 
            logout_date_time = ? WHERE id != ? AND status = ? AND user_id = ?";
        $values = array("inactive", date("Y-m-d H:i:s"), $login_id, 'active', $user_id);
        $this->databaseInstance->updateRow($query, $values);

        $this->userLastAction();

        return true;
    }

    public function checkUser(){
        //get login details
       
        $query = "SELECT * from $this->user_login 
            where user_ses_id = ? and user_id = ? and status = ?";
        $values = array($this->user_ses_id, $this->user_id, "active");
        $results = $this->databaseInstance->getRow($query, $values);

        if(!empty($results)){
           return $results;
        } else{
            throw new \Exception("Session ID has no relationship with User ID. Unknown user");
        }  
        
    }

    public function getDeviceId(){
       
        $query = "SELECT * from $this->unknown_users where user_ses_id = ?";
        $values = array($this->user_ses_id);
        $results = $this->databaseInstance->getRow($query, $values);

        return $results; 
        
    }

    public function checkUserLoginState($device_id, $device_name) {
        //get login details
        $query = "SELECT * from $this->user_login 
            where device_id = ? and device_name = ? and status = ?";
        $values = array($device_id, $device_name, "active");
        $result = $this->databaseInstance->getRow($query, $values);
        
        return $result;
    }

    public function checkUserLoginDevice($device_id, $device_name, $login_id){
        
        $state = "no";
        $query = "SELECT id, device_id, device_name from $this->user_login 
            where user_id = ? and device_id = ? and device_name = ? and id != ?";
        $values = array($this->user_id, $device_id, $device_name, $login_id);
        $results = $this->databaseInstance->getRow($query, $values);

        if ($results) $state = "yes";

        return $state;
    }

    public function userLastAction() {

        $query3 = "UPDATE $this->users set last_action = ? where id = ?";
        $values3 = array(date("Y-m-d H:i:s"), $this->user_id);
        $response = $this->databaseInstance->updateRow($query3, $values3);//send users details for processing 

        return $response;
    }

    public function validateUser(){
        
        $userDetails = $this->user->getUser($this->user_id);

        if (!$userDetails['data']) 
            throw new \Exception("User not found.");

        $userDetails = $userDetails['data'];

        if (!$userDetails->id) 
            throw new \Exception("User ID not found.");

        if ($userDetails->banned == "yes") 
            throw new \Exception("You are currently banned.");

        return $userDetails;
    }    

    /**
     * @param string $word
     * @param string $results
     * @return int
     *
    */ 
    public function saveSearchResult($word, $results){

        $result = $this->checkUser();
        $login_id = $result->id;

        $ids = '';
        foreach ($results as $key => $value) {
            $ids .= $value->id.'|';
        }
        //submit details
        $query = "INSERT into $this->search set login_id = ?, searched_word = ?, result_sent = ?, date_created = ?";
        $values = array($login_id, $word, $ids, date("Y-m-d H:i:s"));
        
        $inserted = $this->databaseInstance->insertRow($query, $values);//send users details for processing    
        
        return $inserted; //return response
    }

    /**
     * @param int $id
     * @param int $response
     * @return boolen
     *
    */ 
    public function updateSearchResult($id, $response){

        //submit details
        $query = "UPDATE $this->search set item_user_click = ? where id = ?";
        $values = array($response, $id);
        
        $updated = $this->databaseInstance->updateRow($query, $values);//send users details for processing    
        
        return $updated; //return response
    }

    public function unsetSessions() {

        setcookie("user_id", null, -1, '/');
        setcookie("user_ses_id", null, -1, '/');

        unset($_SESSION['profile_image_url']);
        unset($_SESSION['fullname']);
        unset($_SESSION['email']);
        unset($_SESSION['phone']);
        unset($_SESSION['gender']);
        
        unset($_SESSION['login_id']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_ses_id']);
        session_write_close();

        return true;
    }
}