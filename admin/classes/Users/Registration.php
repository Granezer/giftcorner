<?php

namespace Users;

/**
 *
 * @author Redjic Solutions
 * @since January 27, 2020
*/

class Registration {

    //Constructors allow you to initialise your object's properties
    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();
        $this->login = new Login();
        $this->userLogs = new UserLogs();

        $tableNames = $this->tablesAndKeys->getTableNames();
    
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->users = $tableNames['users'];
        $this->confirmation_link = $tableNames['confirmation_link'];
    }

    /**
     * @param string $email
     * @return array
     *
     *function that checks if email provided exist in the database
    */
    public function isEmailExist($email){
        
        //saerch users table with the specified email
        $query = "SELECT * from $this->users where email = ?";
        
        return $this->databaseInstance->getRow($query, array($email));//return result of the query   
    }

    /**
     * @param string $phone
     * @return array
     *
     *function that checks if phone provided exist in the database
    */
    public function isPhoneExist($phone){
        
        //saerch users table with the specified phone
        $query = "SELECT * from $this->users where phone = ?";
        
        return $this->databaseInstance->getRow($query, array($phone));//return result of the query   
    }

    /**
     * @param string $email
     * @return array
     *
     *function that checks if email provided exist in the database
    */
    public function checkRefCode($ref_code) {
        
        //saerch users table with the specified email
        $query = "SELECT * from $this->users where ref_code = ?";
        
        return $this->databaseInstance->getRow($query, array($ref_code));//return result of the query   
    }
    
    /**
     * @param string $email
     * @return boolen
     *
     *check if email provided is valid
    */    
    public function isValidEmail($email){
        //e.g info@diamondscripts.ng
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * @param string $password
     * @param string $email
     * @param string $fullname
     * @param string $gender
     * @param string $device_id
     * @return string
     *
     *function that creates new user records
    */ 
    public function createNewUser($password, $email, $fullname, $phone, $gender, $device_id, $device_name, $registration_type, $profile_image_url = null) {
        
        $isEmailExist = $this->isEmailExist($email);                
        if($isEmailExist)
            throw new \Exception("Email address provided already exist");        
            
        $isValid = $this->isValidEmail($email);//call isValidEmail function
        if(!$isValid)
            throw new \Exception("Format of Email Address provided is invalid");
        
        $response = $this->isPhoneExist($phone);                
        if($response)
            throw new \Exception("Phone number provided already exist"); 

        $rtime = date("Y-m-d H:i:s");
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if (!$profile_image_url) 
            $profile_image_url = 'https://s3.us-east-2.amazonaws.com/katlogg-profile-images/katlogg-male-profile-image.png';

        $query = "INSERT INTO $this->users SET password = ?, 
            email = ?, phone = ?, fullname = ?, gender = ?, date_time = ?, 
            last_action = ?, profile_image_url = ?, confirmed = ?, 
            registration_type = ?";
        $values = array($hashed_password, $email, $phone, $fullname, $gender, $rtime, 
            $rtime, $profile_image_url, 'no', $registration_type);
        $user_id = $this->databaseInstance->insertRow($query, $values);

        $response = $this->login->loginUsers($email, $password, $device_id, $device_name);

        return $response;
    }
    //EOF for creating new user record

    /**
     * @param string $email
     * @param string $password
     * @return string
     *
    */ 
    public function createConfirmationLink($email) {

        $today = date("Y-m-d H:i:s");
        $code = md5($this->library->generateCode($email));
        $code .= $code;
        $code = str_shuffle($code);
        $code = substr($code, 0, 30);

        $query = "INSERT INTO $this->confirmation_link 
            SET link = ?, valid = ?, email = ?, date_created = ? ";
        $values = array($code, "yes", $email, $today);
        $this->databaseInstance->insertRow($query, $values);

        return $code;
    }
    //EOF for creating confirmation link

    /**
     * @param string $email
     * @param string $fullname
     * @param string $password
     * @return string
     *
     *function that creates new user records
    */ 
    public function resendConfirmationLink($user_id) {

        $query = "SELECT * from $this->users where user_id = ?";
        $response = $this->databaseInstance->getRow($query, array($user_id));
        if (!$response) throw new \Exception("email not found");
        $email = $response->email;
        
        if ($response->confirmed =="yes") return false;

        //SET the validity of previous link with this email to 'no'
        $query = "UPDATE $this->confirmation_link SET valid = ? where email = ?";
        $values = array("no", $email);
        $this->databaseInstance->updateRow($query, $values);

        $code = $this->createConfirmationLink($email);  
        $response->code = $code;

        return $response;
    }

    //function that creates new user records
    public function updateUser($id, $gender, $fullname, $phone) {
        
        //submit users details
        $query = "UPDATE $this->users 
            SET gender = ?, fullname = ?, phone = ? WHERE id = ?";
        $values = array($gender, $fullname, $phone, $id);
        $this->databaseInstance->updateRow($query, $values);

        return true;
    }
}