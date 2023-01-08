<?php

/**
 *
 * @author Redjic Solutions
 * @since January 27, 2020
*/

class Users {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->library = new Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }

        $this->users = $tableNames['users'];

        $this->pagination = array();
        $this->sort = array();
        $this->format_query = array();
    }

    public function userQuery() {

         $query = "SELECT id, ref_code, downliners, gender, fullname, email, 
            profile_image_url, banned, confirmed, last_action, date_time, phone, 
            DATE_FORMAT(date_time, '%D %b %Y %l:%i %p') as date_time, password 
            FROM $this->users ";

        return $query;
    }

    public function getUsers($pagination, $sort, $format_query, $request) {

        $query = $this->userQuery();
        $query .= "ORDER BY id DESC";
        $response = $this->databaseInstance->getRows($query, array());

        return $this->library->formatResponse($response, $pagination, $sort, $format_query, $request);
    }

    public function getUser($id) {

        $query = $this->userQuery();
        $query .= "WHERE id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));

        return $this->library->formatSingleResponse($response);
    }

    public function getRecentUsers() {

        $query = $this->userQuery();
        $query .= "ORDER BY id DESC LIMIT 5";
        $response = $this->databaseInstance->getRows($query, array());

        return $this->library->formatResponse($response);
    }

    public function getUserByPhone() {
        $query = "SELECT * FROM $this->users WHERE phone = ?";
        $response = $this->databaseInstance->getRow($query, array($phone));

        return $this->library->formatSingleResponse($response);
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM $this->users WHERE email = ?";
        $response = $this->databaseInstance->getRow($query, array($email));

        return $this->library->formatSingleResponse($response);
    }

    public function updatePassword($email, $password) {
        $query = "UPDATE $this->users SET password = ? WHERE email = ?";
        $this->databaseInstance->updateRow($query, array($password, $email));

        return true;
    }
}