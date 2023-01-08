<?php
require_once '../required-files.php';

try {

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required"); 

    $id = isset($_GET["id"]) ? $_GET["id"] : 0;

    $designations = new Settings\Designation();

    $response = array();
    if ($id) {
    	$response = $designations->getDesignation($id);
    } else $response = $designations->getDesignations();

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}