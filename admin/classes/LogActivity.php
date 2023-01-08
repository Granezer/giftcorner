<?php

/**
 *
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class LogActivity {

    //Constructors allow you to initialise your object's properties
    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->library = new Library();
        $this->employee = new Employees\Employees();

        $tableNames = $this->tablesAndKeys->getTableNames();
    
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }

        $this->initial_report = $tableNames['initial_report'];
        $this->error_report = $tableNames['error_report'];
        $this->successful_report = $tableNames['successful_report'];
        $this->login = $tableNames['login'];
        $this->employees = $tableNames['employees'];
    }

    public function setVersion($version_no) {
        $GLOBALS['version_no'] = $version_no;
    }

    public function setOldVersion($old_version_no) {
        $GLOBALS['old_version_no'] = $old_version_no;
    }

    public function setWebVersion($web_version) {
        $GLOBALS['web_version'] = $web_version;
    }

    public function setWeb($web) {
        $GLOBALS['web'] = $web;
    }

    public function setEmployeeId($employee_id) {
        $this->employee_id = $employee_id;
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

    //format seller input
    public function formatInput($input) {
        return trim(stripcslashes(htmlspecialchars($input)));
    }

    //format seller input
    public function dateFormat($dateInput) {
        $formatInput = 'd/m/Y'; //Give any format here, this would be converted into your format

        $formatOut = 'Y-m-d'; // Your format
        return DateTime::createFromFormat($formatInput, $dateInput)->format($formatOut);
    }

    /**
     * @param string $transaction_id
     * @return boolen
     *
    */ 
    public function validateRequest(){

        //first make sure we are not repeating a process
        $query = "SELECT * from $this->successful_report where transaction_id = ?";
        $values = array($this->transaction_id);
        
        $result = $this->databaseInstance->getRows($query, $values);
        
        if (!empty($result)){
            throw new Exception("Request has been sent before");
        }
        return true;
    }

    /**
     * @param string $report_type
     * @param string $transaction_id
     * @param int $employee_id
     * @param array $get_request
     * @return array
     *
    */ 
    public function createInitialReport(){

        //submit details
        $query = "INSERT into $this->initial_report set report_type = ?, employee_id = ?, 
            transaction_id = ?, server_request = ?, date_time = ?";
        $values = array($this->report_type, $this->employee_id, $this->transaction_id, 
            $this->get_request, date("Y-m-d H:i:s"));
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

        //submit details
        $query = "INSERT into $this->error_report set report_type = ?, description = ?, 
            transaction_id = ?, server_request = ?, date_time = ?";
        $values = array($this->report_type, $this->description, $this->transaction_id, 
            $this->get_request, date("Y-m-d H:i:s"));
        
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
            $result = $this->checkEmployee();
            $login_id = $result->id;
        }
        if($this->state == 'logout' || $this->state == 'loggeg in'){
          $login_id = $this->report_type_id;  
        }

        //submit details
        $query = "INSERT into $this->successful_report 
            set login_id = ?, report_type = ?, report_type_id = ?, description = ?, 
            transaction_id = ?, server_request = ?, employee_id = ?, date_time = ?";
        $values = array($login_id, $this->report_type, $this->report_type_id, $description, 
            $this->transaction_id, $this->get_request, $this->employee_id, date("Y-m-d H:i:s"));
        
        $inserted = $this->databaseInstance->insertRow($query, $values);//send users details for processing  

        // $query = "UPDATE $this->employees set last_activity = ? where id = ?";
        // $values = array(date("Y-m-d H:i:s"), $this->employee_id);
        // $this->databaseInstance->updateRow($query, $values);  
        
        return $inserted; //return response
    }   

    //function that registers user logout
    public function logoutSession() {

        //update details
        $date = date("Y-m-d H:i:s");
        $query2 = "UPDATE $this->login set status = ?, logout_date_time = ? 
            where employee_id = ? and user_ses_id = ?";
        $values2 = array("inactive", $date, $this->employee_id, $this->user_ses_id);
        $this->databaseInstance->updateRow($query2, $values2);//send users details for processing 

        return true;
        
    }

    public function checkEmployee(){
        //get login details
       
        $query = "SELECT * from $this->login 
            where user_ses_id = ? and employee_id = ? and status = ?";
        $values = array($this->user_ses_id, $this->employee_id, "active");

        $results = $this->databaseInstance->getRow($query, $values);

        if(!empty($results)){
           return $results;
        } else{
            throw new Exception("Session expired");
        }  
        
    }

    public function checkEmployeeExist($device_id, $device_name, $employee_id){
        //get login details
        $query = "SELECT * from $this->login 
            where device_id = ? and device_name = ? and employee_id = ? and status = ?";
        $values = array($device_id, $device_name, $employee_id, "active");
        $result = $this->databaseInstance->getRow($query, $values);
        return $result;
    }


    public function validateEmployee(){
        
        $employeeDetails = $this->employee->getEmployeeById($this->employee_id);
        $response = $employeeDetails['data'];

        if (!$response) {
            throw new Exception("Employee ID $this->employee_id not found.");
        }

        if ($response->status == 1) {
            throw new Exception("You are currently suspended.");
        }

        return $response;

    }

    /**
     * @param date $startDate
     * @param date $endDate
     * @return array
     *
    */ 
    public function getActivities($pagination, $sort, $query, $startDate = null, $endDate = null){

        if ($startDate == null) 
            $startDate = date('Y-m-d', strtotime("-3 day"));
        
        if ($endDate == null) 
            $endDate = date("Y-m-d");
        
        $query = "SELECT description, report_type, transaction_id, server_request, date_time 
            from $this->successful_report 
            where report_type != ? and DATE(date_time) BETWEEN ? and ? 
            ORDER BY id desc";
        $values = array('', $startDate, $endDate);
        $response = $this->databaseInstance->getRows($query, $values); 

        return $this->library->formatResponse($response, $pagination, $sort, $query);

    } 

    /**
     * @param date $startDate
     * @param date $endDate
     * @return array
     *
    */ 
    public function getMyActivities($pagination, $sort, $query, $employee_id, $startDate = null, $endDate = null){

        if ($startDate == null) 
            $startDate = date('Y-m-d', strtotime("-3 day"));
        
        if ($endDate == null) 
            $endDate = date("Y-m-d");
        
        $query = "SELECT description, report_type, transaction_id, server_request, date_time 
            FROM $this->successful_report 
            WHERE report_type != ? AND employee_id = ? AND DATE(date_time) BETWEEN ? AND ? 
            ORDER BY id DESC";
        $values = array('', $employee_id, $startDate, $endDate);
        $response = $this->databaseInstance->getRows($query, $values); 

        return $this->library->formatResponse($response, $pagination, $sort, $query);

    } 
    
}