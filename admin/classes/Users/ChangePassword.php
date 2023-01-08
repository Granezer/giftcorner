<?php

namespace Users;

/**
 *
 * @author Redjic Solutions
 * @since January 27, 2020
*/

class ChangePassword
{

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->user = new \Users();
        $this->verification = new \VerificationCode();

        $tableNames = $this->tablesAndKeys->getTableNames();
    
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->users = $tableNames['users'];
        $this->reset_password_codes = $tableNames['reset_password_codes'];
    }
    
    /**
     * @param int $id
     * @param string $new_password
     * * @param string $old_password
     * @return boolean
     *
    */
    public function changeUserPassword($id, $new_password, $old_password){

        $userDetails = $this->user->getUser($id);
        $userDetails = $userDetails['data'];

        if($userDetails->password <> $old_password)
            throw new \Exception("current password not found");

        if($new_password == $old_password)
            throw new \Exception("current password must be different from new password");

        $query = "UPDATE $this->users SET password = ? WHERE id = ?";
        $values = array($new_password, $id);
        $result = $this->databaseInstance->updateRow($query, $values);

        return true;
    }

    /**
     * @param string $email
     * @param string $new_password
     * @param string $code
     * @return boolean
     *
    */
    public function resetPassword($email, $new_password, $code){

        $this->verification->verifyCode($email, $code);
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE $this->users SET password = ? WHERE email = ?";
        $values = array($new_password, $email);
        $result = $this->databaseInstance->updateRow($query, $values);

        $this->verification->updateCode($email);

        return true;
    }

    /**
     * @param int $user_id
     * @param string $email
     * @return int
     *
    */
    public function setResetPasswordCode($user_id, $email){

        $reset_code = ""; //our default reset_code is blank.
        while($i < 5){
            //generate a random number between 0 and 9.
            $reset_code .= mt_rand(0, 9);
            $i++;
        }

        $date_time = date("Y-m-d H:i:s");
        $expiration_time = date('Y-m-d H:i:s', strtotime('+30 minute'));

        $query = "UPDATE $this->reset_password_codes SET valid = ? WHERE user_id = ?";
        $result = $this->databaseInstance->updateRow($query, array('no', $user_id));

        $query = "INSERT into $this->reset_password_codes 
            SET user_id = ?, reset_code = ?, expiration_date_time = ?, date_time_created = ?";
        $values = array($user_id, $reset_code, $expiration_time, $date_time);

        $result = $this->databaseInstance->insertRow($query, $values);

        return $reset_code;
    }

    /**
     * @param int $user_id
     * @param string $reset_code
     * @return array
     *
    */
    public function validateCode($user_id, $reset_code){

        $now = date("Y-m-d H:i:s"); 

        $query = "SELECT reset_code from $this->reset_password_codes 
            WHERE user_id = ? and reset_code = ?";
        $values = array($user_id, $reset_code);
        $result = $this->databaseInstance->getRow($query, $values);

        if (!$result) {
            throw new \Exception("Error: Reset Password Code does not exist");  
        }

        $query = "SELECT * from $this->reset_password_codes 
            WHERE expiration_date_time >= ? and valid = ? and user_id = ?";
        $values = array($now, 'yes', $user_id);
        $result = $this->databaseInstance->getRow($query, $values);

        return $result;
    } 
}