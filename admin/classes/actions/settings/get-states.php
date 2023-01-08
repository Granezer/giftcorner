<?php
require_once '../required-files.php';

try {

    // Get all GET data and assign to get_request variable
    $get_request = json_encode($_GET);

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required");  

    $states = new Settings\States();

    $response = $states->getStates();

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}