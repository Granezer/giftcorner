<?php

namespace Settings;

/**
 *
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class Department {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->departments = $tableNames['departments'];
        $this->date_time = $this->tablesAndKeys->getDateTime();
    }

    /**
     * @return array
     *
    */
    public function getDepartments() {
        
        $query = "SELECT * FROM $this->departments ORDER BY name ASC";
        $response = $this->databaseInstance->getRows($query, array());
        
        return $this->library->formatResponse($response, $pagination = array(), $sort = array("sort"=>"asc"));
    }

    /**
     * @return array
     *
    */
    public function getDepartment($id) {
        
        $query = "SELECT * FROM $this->departments WHERE id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getDepartmentByName($name) {
        
        $query = "SELECT * FROM $this->departments WHERE name = ?";
        $response = $this->databaseInstance->getRow($query, array($name));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function newDepartment($name) {
        
        $response = $this->getDepartmentByName($name);
        if ($response['data']) {
            throw new \Exception("Department already exist");
        }

        $query = "INSERT INTO $this->departments SET name = ?, date_time = ?";
        $values = array($name, $this->date_time);
        $response = $this->databaseInstance->insertRow($query, $values);
        
        return array("success" => true, "message" => "Department created successfully");
    }

    /**
     * @return array
     *
    */
    public function editDepartment($id, $name) {
        
        $response = $this->getDepartmentByName($name);
        if ($response['data']) {
            if ($response['data']->id != $id)
            throw new \Exception("Department already exist");
        }

        $query = "UPDATE $this->departments SET name = ? WHERE id = ?";
        $values = array($name, $id);
        $response = $this->databaseInstance->updateRow($query, $values);
        
        return array("success" => true, "message" => "Department updated successfully");
    }

}
