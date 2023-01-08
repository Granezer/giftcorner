<?php
require_once '../required-files.php';

try {

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required"); 

    $state = isset($_GET['state']) ? $_GET['state'] : 0; 

    $lgasInstance = new Settings\LGAs();
    
    //retrieve orders
    $response = $lgasInstance->getLGAsByStateId($state); 

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}