<?php

/**
 *
 * @author Redjic Solutions
 * @since April 30, 2020
*/

class ContactUs {

    public function __construct() {
        $this->databaseInstance = new Database();
        $this->tablesAndKeys = new TablesAndKeys();
        $this->library = new Library();

        $tableNames = $this->tablesAndKeys->getTableNames();
        
        if (!is_array($tableNames)){
            throw new Exception("Can't access the table names");
        }

        $this->contact_us = $tableNames['contact_us'];

        $this->pagination = array();
        $this->sort = array();
        $this->format_query = array();

        $this->date = $this->tablesAndKeys->getDateTime();
    }

    public function contactQuery() {

         $query = "SELECT id, name, phone, email, subject, message, 
            DATE_FORMAT(date_time, '%D %b %Y %l:%i %p') as date_time 
            FROM $this->contact_us ";

        return $query;
    }

    public function getContactUs($pagination, $sort, $format_query, $request) {

        $query = $this->contactQuery();
        $query .= "ORDER BY id DESC";
        $response = $this->databaseInstance->getRows($query, array());

        return $this->library->formatResponse($response, $pagination, $sort, $format_query, $request);
    }

    public function getContactUsById($id) {

        $query = $this->contactQuery();
        $query .= "WHERE id = ?";
        $response = $this->databaseInstance->getRow($query, array($id));

        return $this->library->formatSingleResponse($response);
    }

    public function getUserMessage($email, $message, $subject) {
        $query = "SELECT * FROM $this->contact_us 
            WHERE email = ? AND message = ? AND subject = ? 
            AND DATE(date_time) = ?";
        $values = array($email, $message, $subject, date("Y-m-d"));
        $response = $this->databaseInstance->getRow($query, $values);

        return $this->library->formatSingleResponse($response);
    }

    public function newMessage($name, $phone, $email, $message, $subject) {
        $response = $this->getUserMessage($email, $message, $subject);
        if ($response['data'])
            throw new Exception("Wait for your message to be processed");
            
        $query = "INSERT INTO $this->contact_us 
            SET name = ?, phone = ?, email = ?, message = ?, 
            subject = ?, date_time = ?";
        $values = array($name, $phone, $email, $message, $subject, $this->date);
        $response = $this->databaseInstance->insertRow($query, $values);

        return $response;
    }
}
