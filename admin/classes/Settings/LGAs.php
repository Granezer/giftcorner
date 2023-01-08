<?php

namespace Settings;

/**
 *
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class LGAs {

    public function __construct() {
        $this->statesInstance = new States();
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->tbl_states = $tableNames['tbl_states'];
        $this->tbl_lga = $tableNames['tbl_lga'];
    }

    /**
     * @return array
     *
    */
    public function getLGAsByStateId($stateId) {
        
        $query = "SELECT l.* FROM $this->tbl_lga l 
        	INNER JOIN $this->tbl_states s ON l.state_id=s.id
        	WHERE state_id = ?  
        	ORDER BY l.name ASC";
        $response = $this->databaseInstance->getRows($query, array($stateId));
        
        return $this->library->formatResponse($response, $pagination = array(), $sort = array("sort"=>"asc"));
    }

    /**
     * @return array
     *
    */
    public function getLGAById($id) {
        
        $query = "SELECT * FROM $this->tbl_lga WHERE id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));
        
        return $this->library->formatSingleResponse($response);;
    }

}
