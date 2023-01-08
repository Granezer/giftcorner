<?php

namespace Settings;

/**
 *
 * @author Redjic Solutions
 * @since September 05, 2022
*/

class Banks {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->banks = $tableNames['banks'];
        $this->payments = $tableNames['payments'];
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return array
     *
    */
    public function getBanks() {
        
        $query = "SELECT * FROM $this->banks ORDER BY bank ASC";
        $response = $this->databaseInstance->getRows($query, array());
        
        return $this->library->formatResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getBank($id) {
        
        $query = "SELECT * FROM $this->banks WHERE id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getBankByName($bank) {
        
        $query = "SELECT * FROM $this->banks WHERE bank = ?";
        $response = $this->databaseInstance->getRow($query, array($bank));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function newBank($acc_no, $acc_name, $bank) {
        
        $response = $this->getBankByName($bank);
        if ($response['data']) {
            throw new \Exception("Bank already exist");
        }

        $query = "INSERT INTO $this->banks SET acc_no = ?, acc_name = ?, bank = ?";
        $values = array($acc_no, $acc_name, $bank);
        $response = $this->databaseInstance->insertRow($query, $values);
        
        return array("success" => true, "message" => "Bank created successfully");
    }

    /**
     * @return array
     *
    */
    public function editBank($id, $acc_no, $acc_name, $bank) {
        
        $response = $this->getBankByName($bank);
        if ($response['data']) {
            if ($response['data']->id != $id)
                throw new \Exception("Bank already exist");
        }

        $query = "UPDATE $this->banks SET acc_no = ?, acc_name = ?, bank = ? WHERE id = ?";
        $values = array($acc_no, $acc_name, $bank, $id);
        $response = $this->databaseInstance->updateRow($query, $values);
        
        return array("success" => true, "message" => "Bank updated successfully");
    }

    /**
     * @return array
     *
    */
    public function deleteBank($id) {
        
        $response = $this->getBankByName($bank);
        if (!$response['data']) {
            throw new \Exception("Bank does not exist");
        }

        $query = "SELECT * FROM $this->payments WHERE bank = ?";
        $response = $this->databaseInstance->getRow($query, array($response['data']->bank));
        if ($response['data']) throw new Exception("Error Processing Request", 1);
        
        $query = "DELETE FROM $this->banks WHERE id = ?";
        $values = array($id);
        $this->databaseInstance->deleteRow($query, $values);
        
        return array("success" => true, "message" => "Bank deleted successfully");
    }

}