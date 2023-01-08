<?php

namespace Settings;

class StateZones {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->tbl_state_zones_kg_and_prices = $tableNames['tbl_state_zones_kg_and_prices'];

        $this->date_time = date("Y-m-d H:i:s");
    }

    /**
     * @return array
     *
    */
    public function getStateZoneQuery() {

        $query = "SELECT id, from_kg, to_kg, zone, date_time, amount   
            from $this->tbl_state_zones_kg_and_prices ";

        return $query;
    }

    /**
     * @return array
     *
    */
    public function getAllZones() {

        $query = $this->getStateZoneQuery()."ORDER BY zone asc";
        $results = $this->databaseInstance->getRows($query, array());

        return $results;
    }

    /**
     * @return array
     *
    */
    public function getStateZoneByWeightAndZone($weight, $zone) {

        $query = $this->getStateZoneQuery().
            "where ? >= from_kg and ? <= to_kg and zone = ?";
        $values = array($weight, $weight, $zone);
        $result = $this->databaseInstance->getRow($query, $values);

        return $result;
    }

    /**
     * @return array
     *
    */
    public function getStateZoneByWeight($weight) {

        $query = $this->getStateZoneQuery()."where ? >= from_kg and ? <= to_kg";
        $values = array($weight, $weight);
        $result = $this->databaseInstance->getRows($query);

        return $result;
    }

    /**
     * @return array
     *
    */
    public function getStateZonesByZone($zone) {

        $query = $this->getStateZoneQuery()."where zone = ?";
        $values = array($zone);
        $result = $this->databaseInstance->getRows($query, $values);

        return $result;
    }

}
