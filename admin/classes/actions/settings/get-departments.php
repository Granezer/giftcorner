<?php
require_once '../required-files.php';

try {

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required");  

    $id = isset($_GET["id"]) ? $_GET["id"] : 0;

    $departments = new Settings\Department();

    $response = array();
    if ($id) {
    	$response = $departments->getDepartment($id);
    } else $response = $departments->getDepartments();

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}