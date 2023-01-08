<?php

namespace Settings;

/**
 *
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class States {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();
        $this->state_zones = new StateZones();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->tbl_states = $tableNames['tbl_states'];
    }

    /**
     * @return array
     *
    */
    public function getStates() {
        
        $query = "SELECT * FROM $this->tbl_states ORDER BY name ASC";
        $response = $this->databaseInstance->getRows($query, array());
        
        return $this->library->formatResponse($response, $pagination = array(), $sort = array("sort"=>"asc"));
    }

    /**
     * @return array
     *
    */
    public function getState($id) {
        
        $query = "SELECT * FROM $this->tbl_states WHERE id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getStateByName($name) {

        $query = "SELECT * from $this->tbl_states where name = ?";
        $result = $this->databaseInstance->getRow($query, array($name));

        return $result;
    }

    /**
     * @return array
     *
    */
    public function getStatePriceByWeight($state, $weight) {

        $response = $this->getStateByName($state);
        if (!$response) throw new \Exception("State not found");
        
        $zone = $response->zone;

        $response = $this->state_zones->getStateZoneByWeightAndZone($weight, $zone);
        if (!$response) throw new \Exception("Nothing found");

        $response->state = $state;
        $response->country = "";
        $response->price = $response->amount;
        $response->amount = number_format($response->amount,2);
        $response->weight = $weight;

        return $response;
    }

}
