<?php
require_once 'required-files.php';

try {
    $get_request = json_encode($_GET);

    // Initialize report variables
    $reg_activity->setReportType("Retrieved Recent Products");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required"); 

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee2.php';
    
    $getProducts = new Products();
    $response = $getProducts->getRecentProducts();

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}