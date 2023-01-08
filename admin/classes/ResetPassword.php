<?php

/**
* @author Redjic Solutions
* @since October 31, 2019
*/

class ResetPassword {

    public function __construct() {
        $this->employeeInstance = new Employees\Employees();
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->verification = new VerificationCode();
         
        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames))
            throw new Exception("Can't access the table names");
        
        $this->email_templates = $tableNames['email_templates'];
        $this->reset_password_codes = $tableNames['reset_password_codes'];
        $this->employees = $tableNames['employees'];
        
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return boolean
     *
    */
    public function changePassword($employee_id, $current_password, $new_password) {

        $result = $this->employeeInstance->getEmployeeById($employee_id);
        if (!$result['data']) throw new Exception("ID not found.");

        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        if (!password_verify($current_password, $result['data']->password)) 
            throw new Exception("Invalid current password");

        if (password_verify($current_password, $new_password)) 
            throw new Exception("There is nothing to update");
        
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE $this->employees SET password = ? WHERE id = ?";
        $values = array($new_password, $employee_id);
        $this->databaseInstance->updateRow($query, $values);

        $response = array(
            "success" => true, 
            "message" => "Password has been changed successfully"
        );

        return true;
    }

    /**
     * @return boolean
     *
    */
    public function resetPassword($email, $password, $code) {

        $this->verification->verifyCode($email, $code, 'admin');

        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "UPDATE $this->employees SET password = ? WHERE email = ?";
        $values = array($password, $email);
        $this->databaseInstance->updateRow($query, $values);

        $this->verification->updateCode($email);

        return true;
    }
}