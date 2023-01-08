<?php

/**
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class Logout {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }

        $this->login = $tableNames['login'];
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    //function that registers user logout
    public function logoutSession($employee_id, $user_ses_id) {

        //update details
        $query = "UPDATE $this->login set status = ?, logout_date_time = ? 
            where employee_id = ? and user_ses_id = ?";
        $values = array("inactive", $this->date_time, $employee_id, $user_ses_id);
        $this->databaseInstance->updateRow($query, $values);//send users details for processing 

        return true;
        
    }

    //function that registers user logout
    public function logoutDevice($id) {

        //update details
        $query = "UPDATE $this->login 
            set status = ?, logout_date_time = ? 
            where id = ?";
        $values = array("inactive", $this->date_time, $id);
        $this->databaseInstance->updateRow($query, $values);//send users details for processing 

        return true;
        
    }

}