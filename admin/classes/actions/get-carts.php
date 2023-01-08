<?php
require_once 'required-files.php';

try {
    $order_id = isset($_GET['order_id']) 
        ? $reg_activity->formatInput($_GET['order_id']) : null;

    $get_request = json_encode($_GET);

    // Initialize report variables
    $reg_activity->setReportType("Retrieved Cart Items");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required"); 

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee2.php';

    require_once 'pagination.php';

    $carts = new Carts();
    $response = $carts->getCartItemsByOrderId($order_id);
    
    $description = $employee_Details->first_name . " retrieved cart items of order ID : ". $order_id;
    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}