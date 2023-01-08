<?php

namespace Settings;

class Zones {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->tbl_country_zones_kg_and_prices = $tableNames['tbl_country_zones_kg_and_prices'];

        $this->date_time = date("Y-m-d H:i:s");
    }

    /**
     * @return array
     *
    */
    public function getZoneQuery() {

        $query = "SELECT id, from_kg, to_kg, zone, date_time, amount 
            from $this->tbl_country_zones_kg_and_prices ";

        return $query;
    }

    /**
     * @return array
     *
    */
    public function getAllZones() {

        $query = $this->getZoneQuery()."ORDER BY zone asc";
        $results = $this->databaseInstance->getRows($query, array());

        return $results;
    }

    /**
     * @return array
     *
    */
    public function getZoneByWeightAndZone($weight, $zone) {

        $query = $this->getZoneQuery()."where ? >= from_kg and ? <= to_kg and zone = ?";
        $values = array($weight, $weight, $zone);
        $result = $this->databaseInstance->getRow($query, $values);

        return $result;
    }

    /**
     * @return array
     *
    */
    public function getZoneByWeight($weight) {

        $query = $this->getZoneQuery()."where ? >= from_kg and ? <= to_kg";
        $values = array($weight, $weight);
        $result = $this->databaseInstance->getRows($query);

        return $result;
    }

    /**
     * @return array
     *
    */
    public function getZonesByZone($zone) {

        $query = $this->getZoneQuery()."where zone = ?";
        $values = array($zone);
        $result = $this->databaseInstance->getRows($query, $values);

        return $result;
    }

}
