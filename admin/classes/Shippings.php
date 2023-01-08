<?php

/**
 *
 * @author Redjic Solutions
 * @since February 7, 2020
*/

class Shippings {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->library = new Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }

        $this->shipping_addresses = $tableNames['shipping_addresses'];
        $this->users = $tableNames['users'];
    }

    /**
     * @return array
     *
    */
    public function getShippings($user_id, $status, $pagination, $sort, $format_query, $request) {

        if ($status) {
            return $this->getDefaultShippings($pagination, $sort, $format_query, $request);
        }

        $query = "SELECT p.*, fullname, 
            DATE_FORMAT(p.date_time, '%D %b %Y %l:%i %p') as date_added 
            FROM $this->shipping_addresses p
            INNER JOIN $this->users s ON p.user_id=s.id ";
        $values = array();
        if ($user_id) {
            $query .= "WHERE p.user_id = ? ";
            $values = array($user_id);
        }
        $query .= "ORDER BY p.id DESC";
        $response = $this->databaseInstance->getRows($query, $values);

        return $this->library->formatResponse($response, $pagination, $sort, $format_query, $request);
    }

    /**
     * @return array
     *
    */
    public function getDefaultShippings($pagination, $sort, $format_query, $request) {

        $query = "SELECT p.*, fullname, 
            DATE_FORMAT(p.date_time, '%D %b %Y %l:%i %p') as date_added 
            FROM $this->shipping_addresses p
            INNER JOIN $this->users s ON p.user_id=s.user_id 
            WHERE p.status = ? ORDER BY p.id DESC";
        $values = array(1);
        $response = $this->databaseInstance->getRows($query, $values);

        return $this->library->formatResponse($response, $pagination, $sort, $format_query, $request);
    }

    /**
     * @param int $id
     * @return array
     *
    */
    public function getShipping($id) {

        $query = "SELECT p.*, fullname, 
            DATE_FORMAT(p.date_time, '%D %b %Y %l:%i %p') as date_added 
            FROM $this->shipping_addresses p
            INNER JOIN $this->users s ON p.user_id=s.user_id WHERE id = ?";
        $values = array($id);
        $response = $this->databaseInstance->getRow($query, $values);

        return $this->library->formatSingleResponse($response);
    }
}