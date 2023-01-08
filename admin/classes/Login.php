<?php

/**
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class Login {

    public function __construct() {
        $this->employeeInstance = new Employees\Employees();
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->ipAddressInstance = new IPAddress();
        $this->logAttemptInstance = new LoginAttempts();

        $tableNames = $this->tablesAndKeys->getTableNames();
    
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }

        $this->login = $tableNames['login'];
        $this->devices = $tableNames['devices'];
        $this->date_time = $this->tablesAndKeys->getDateTime();

    }
    
    /**
     * @param int $email
     * @param string $password
     * @param string $transaction_id
     * @param string $device_id
     * @return boolean
     *
    */
    public function login($email, $password, $device_id, $device_name){
        
        $no = 2;
        $attempts = $this->logAttemptInstance->checkLoginAttempt();
        if ($attempts) $no = $no - $attempts;

        $canEmployeeLogin = $this->employeeInstance->getEmployeeByEmail($email); 
        
        if(!$canEmployeeLogin) {
            $this->logAttemptInstance->logAttempt();
            throw new \Exception("Invalid login details. Your email/password is not correct. You have ".$no." attempts left");
        }

        if(!password_verify($password, $canEmployeeLogin->password)) {
            $this->logAttemptInstance->logAttempt();
            throw new \Exception("Invalid login details. Your email/password is not correct. You have ".$no." attempts left");
        }

        if($canEmployeeLogin->status != 0) 
            throw new Exception("Oops! Your account has been deactivated");

        if(password_needs_rehash($canEmployeeLogin->password, PASSWORD_DEFAULT)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $this->employeeInstance->updatePassword($email, $password);
        }
            
        $employee_id = $canEmployeeLogin->id;//assign employee_id value of user to the variable

        $user_ses_id = $this->getGeneratedSessionId();//Assign employee_id of user to session
        $_SESSION['employee_id'] = $employee_id;
        $_SESSION['user_ses_id'] = $user_ses_id;
        $current_time = time();
        
        $login_id = $this->loginSession($employee_id, $_SESSION['user_ses_id'], $device_id, $device_name);
        $_SESSION['login_id'] = $login_id;
        $_SESSION['timestamp'] = $current_time;
        $_SESSION['profile_image'] = $canEmployeeLogin->profile_image;
        $_SESSION['first_name'] = $canEmployeeLogin->first_name;
        $_SESSION['last_name'] = $canEmployeeLogin->last_name;
        $_SESSION['email'] = $canEmployeeLogin->email; 
        $_SESSION['employee_type'] = $canEmployeeLogin->employee_type;

        $canEmployeeLogin->login_id = $login_id;
        $canEmployeeLogin->user_ses_id = $_SESSION['user_ses_id'];
        $canEmployeeLogin->employee_id = $employee_id;
        $canEmployeeLogin->success = true;
        unset($canEmployeeLogin->id);

        setcookie("employee_id", $employee_id, $current_time + 10800, '/');
        setcookie("user_ses_id", $user_ses_id, $current_time + 10800, '/');
        // setcookie("login_id", $login_id, $current_time + 10800, '/');
        // setcookie("profile_image", $canEmployeeLogin->profile_image, $current_time + 10800, '/');
        // setcookie("first_name", $canEmployeeLogin->first_name, $current_time + 10800, '/');
        // setcookie("last_name", $canEmployeeLogin->last_name, $current_time + 10800, '/');
        // setcookie("email", $canEmployeeLogin->email, $current_time + 10800, '/');

        $this->logAttemptInstance->deleteAttempts();

        return $canEmployeeLogin; 
        
    } 

    /**
     * @param int $employee_id
     * @param string $session_id
     * @param string $device_id
     * @return array
     *
    */ 
    public function loginSession($employee_id, $user_ses_id, $device_id, $device_name){

        $ip_details = $this->ipAddressInstance->getIPAddressDetails();

        $mode = 'app';
        if ($GLOBALS['web'] == 'web') $mode = $GLOBALS['web'];   

        //submit details
        $query = "INSERT into $this->login set employee_id = ?, user_ses_id = ?, device_id = ?, 
            status = ?, device_name = ?, login_date_time = ?, ip_address = ?, country = ?, 
            province = ?, city = ?, org = ?, latitude = ?, longitude = ?, time_zone = ?, login_mode = ?";
        $values = array($employee_id, $user_ses_id, $device_id, "active", $device_name, $this->date_time, 
            $ip_details->ip_address, $ip_details->country, $ip_details->province, $ip_details->city, 
            $ip_details->org, $ip_details->latitude, $ip_details->longitude, $ip_details->time_zone, $mode);
        $login_id = $this->databaseInstance->insertRow($query, $values);

        return $login_id;
    
    }

    /**
     * @return array
     *
    */
    public function checkEmployeeLoginState($device_id, $device_name) {
        //get login details
        $query = "SELECT * from $this->login 
            where device_id = ? and device_name = ? and status = ?";
        $values = array($device_id, $device_name, "active");
        $result = $this->databaseInstance->getRow($query, $values);

        return $result;
    }

    /**
     * 
     * @return string
     *
     *function that generate user session id
        */
    public function getGeneratedSessionId() {

        session_regenerate_id();

        return session_id();
    }

    /**
     * @param int $employee_id
     * @param string $device_id
     * @param string $token_id
     * @return array
    */
    public function tokenCheck ($device_id, $employee_id, $token_id) {
        
        $query = "SELECT * from $this->devices where device_id = ?";
        $values = array($device_id);
        $result = $this->databaseInstance->getRow($query, $values);

        if ($result) {
            $this->updateEmployeeToken($employee_id, $token_id, $device_id);
        } else {
            $this->saveToken($token_id, $employee_id, $device_id);
        }

        return true;
    }

    /**
     * @param string $token_id
     * @param int $employee_id
     * @param string $device_id
     * @return int
     *
    */
    public function saveToken ($token_id, $employee_id, $device_id) {

        $date = date("Y-m-d H:i:s");
        $query = "INSERT into $this->devices 
            set token = ?, employee_id = ?, device_id = ?, date_created = ?";
        $values = array($token_id, $employee_id, $device_id, $date);
        $result = $this->databaseInstance->insertRow($query, $values);

        return $result;
    }

    /**
     * @param int $employee_id
     * @param string $token_id
     * @param string $device_id
     * @return int
     *
    */
    public function updateEmployeeToken ($employee_id, $token_id, $device_id) {

        $query = "UPDATE $this->devices 
            set employee_id = ?, token = ? where device_id = ?";
        $values = array($employee_id, $token_id, $device_id);
        $result = $this->databaseInstance->updateRow($query, $values);

        $query = "DELETE from $this->devices 
            where NOT token = ? and employee_id = ?";
        $values = array($token_id, $employee_id);
        $this->databaseInstance->deleteRow($query, $values);

        return $result;
    } 
}