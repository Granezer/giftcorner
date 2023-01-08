<?php

/**
 * @author Redjic Solutions
 * @since September 9, 2022
*/

class LoginAttempts {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->ipAddressInstance = new IPAddress();

        $tableNames = $this->tablesAndKeys->getTableNames();
    
        if (!is_array($tableNames))
            throw new Exception("Can't access the table names");

        $this->login_attempts = $tableNames['login_attempts'];
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return array
     *
    */
    public function checkLoginAttempt() {
        
        $time = strtotime('-15 minutes');
        $ip_address = $this->ipAddressInstance->getIPAddress();

        $query = "SELECT count(*) as total_count FROM $this->login_attempts WHERE try_time > ? and ip_address =  ?";
        $result = $this->databaseInstance->getRow($query, array($time, $ip_address));

        if ($result->total_count == 3)
            throw new Exception("Too many failed login attempts. Please try again after 15 mintus", 1);

        return $result->total_count;
    }
    
    /**
     * @param string $ip_address
     * @return boolean
     *
    */
    public function logAttempt() {

        $ip_address = $this->ipAddressInstance->getIPAddress();

        $query = "INSERT into $this->login_attempts set ip_address = ?, try_time = ?, date_time = ?";
        $values = array($ip_address, time(), $this->date_time);
        $this->databaseInstance->insertRow($query, $values);

        return true;
    }
    
    /**
     * @param string $ip_address
     * @return boolean
     *
    */
    public function deleteAttempts() {

        $ip_address = $this->ipAddressInstance->getIPAddress();

        $query = "DELETE FROM $this->login_attempts WHERE ip_address = ?";
        $this->databaseInstance->deleteRow($query, array($ip_address));

        return true;
    }
}