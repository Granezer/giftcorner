<?php

namespace Settings;

/**
 *
 * @author Redjic Solutions
 * @since January 29, 2020
*/

class Country {

    public function __construct() {
        $this->databaseInstance = new \Database();
        $this->tablesAndKeys = new \TablesAndKeys();
        $this->library = new \Library();
        $this->zones = new Zones();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new \Exception("Can't access the table names");
        }

        $this->tbl_country = $tableNames['tbl_country'];
    }

    /**
     * @return array
     *
    */
    public function getCountries() {
        
        $query = "SELECT * FROM $this->tbl_country ORDER BY name ASC";
        $response = $this->databaseInstance->getRows($query, array());
        
        return $this->library->formatResponse($response, $pagination = array(), $sort = array("sort"=>"asc"));
    }

    /**
     * @return array
     *
    */
    public function getCountry($id) {
        
        $query = "SELECT * FROM $this->tbl_country WHERE id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));
        
        return $this->library->formatSingleResponse($response);
    }

    /**
     * @return array
     *
    */
    public function getCountryByName($name) {

        $query = "SELECT * from $this->tbl_country where name = ?";
        $result = $this->databaseInstance->getRow($query, array($name));

        return $result;
    }

    /**
     * @return array
     *
    */
    public function getCountryPriceByWeight($country, $weight) {

        $response = $this->getCountryByName($country);
        if (!$response) throw new \Exception("Country not found");
        
        $zone = $response->zone;

        $response = $this->zones->getZoneByWeightAndZone($weight, $zone);
        if (!$response) throw new \Exception("Nothing found");

        $response->country = $country;
        $response->state = "";
        $response->price = $response->amount;
        $response->amount = number_format($response->amount,2);
        $response->weight = $weight;

        return $response;
    }

}
