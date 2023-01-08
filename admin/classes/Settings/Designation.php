<?php

namespace Settings;

/**
 *
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class Designation {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->designations = $tableNames['designations'];
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return array
     *
    */
    public function getDesignations() {
        
        $query = "SELECT * FROM $this->designations ORDER BY name ASC";
        $response = $this->databaseInstance->getRows($query, array());
        
        return $this->library->formatResponse($response, $pagination = array(), $sort = array("sort"=>"asc"));
    }

    /**
     * @return array
     *
    */
    public function getDesignation($id) {
        
        $query = "SELECT * FROM $this->designations WHERE id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getDesignationByName($name) {
        
        $query = "SELECT * FROM $this->designations WHERE name = ?";
        $response = $this->databaseInstance->getRow($query, array($name));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function newDesignation($name) {
        
        $response = $this->getDesignationByName($name);
        if ($response['data']) {
            throw new \Exception("Designation already exist");
        }

        $query = "INSERT INTO $this->designations SET name = ?, date_time = ?";
        $values = array($name, $this->date_time);
        $response = $this->databaseInstance->insertRow($query, $values);
        
        return array("success" => true, "message" => "Designation created successfully");
    }

    /**
     * @return array
     *
    */
    public function editDesignation($id, $name) {
        
        $response = $this->getDesignationByName($name);
        if ($response['data']) {
            if ($response['data']->id != $id)
            throw new \Exception("Designation already exist");
        }

        $query = "UPDATE $this->designations SET name = ? WHERE id = ?";
        $values = array($name, $id);
        $response = $this->databaseInstance->updateRow($query, $values);
        
        return array("success" => true, "message" => "Designation updated successfully");
    }

}
