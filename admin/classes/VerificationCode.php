<?php

/**
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class VerificationCode {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->library = new Library();
         
        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }
        $this->email_templates = $tableNames['email_templates'];
        $this->verification_codes = $tableNames['verification_codes'];
        
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @param int $payer_id
     * @param string $email
     * @return int
     *
    */
    public function newCode($email, $type = 'user') {

        $code = $this->library->generateCode(6);
        $expiration_time = date('Y-m-d H:i:s', strtotime('+1 days'));

        $this->updateCode($email, $type);

        $query = "INSERT INTO $this->verification_codes 
            SET email = ?, type = ?, code = ?, expiration_date_time = ?, 
            date_time = ?";
        $values = array($email, $type, $code, $expiration_time, $this->date_time);
        $this->databaseInstance->insertRow($query, $values);

        return $code;
    }

    /**
     * @param int $email
     * @param string $type
     * @return boolean
     *
    */
    public function updateCode($email, $type = 'user') {

        $query = "UPDATE $this->verification_codes 
            SET valid = ? WHERE type = ? AND email = ?";
        $values = array('no', $type, $email);
        $this->databaseInstance->updateRow($query, $values);

        return true;
    }

    /**
     * @return boolean
     *
    */
    public function verifyCode($email, $code, $type = 'user') {

        $query = "SELECT * FROM $this->verification_codes 
            WHERE email = ? AND code = ? AND type = ? AND valid = ?";
        $values = array($email, $code, $type, "yes");
        $response = $this->databaseInstance->getRow($query, $values);

        if (!$response) 
            throw new Exception("Invalid link");

        $expired = strtotime($response->expiration_date_time);
        $date_time = strtotime($this->date_time);

        if ($expired < $date_time) 
            throw new Exception("link has expired");

        return $response;
    }

    /**
     * @return boolean
     *
    */
    public function getCode($code) {

        $query = "SELECT * FROM $this->verification_codes 
            WHERE code = ? AND valid = ? ORDER BY id DESC";
        $values = array($code, "yes");
        $response = $this->databaseInstance->getRow($query, $values);

        return $response;
    }

    /**
     * @return boolean
     *
    */
    public function getCodeByEmail($email, $type = 'user') {

        $query = "SELECT * FROM $this->verification_codes 
            WHERE email = ? AND type = ? AND valid = ?";
        $values = array($email, $type, "yes");
        $response = $this->databaseInstance->getRow($query, $values);

        return $response;
    }
}