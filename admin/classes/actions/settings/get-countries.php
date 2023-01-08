<?php
require_once '../required-files.php';

try {

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required");  

    $countries = new Settings\Country();

    $response = $countries->getCountries();

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}