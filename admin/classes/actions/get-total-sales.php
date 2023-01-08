<?php
require_once 'required-files.php';

try {
    $from_date = isset($_GET['from_date']) 
        ? $reg_activity->formatInput($_GET['from_date']): null;
    $to_date = isset($_GET['to_date']) 
        ? $reg_activity->formatInput($_GET['to_date']): null;

    $get_request = json_encode($_GET);

    // Initialize report variables
    $reg_activity->setReportType("Retrieved Total Sales");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required"); 

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee2.php';

    $products = new Products();
    $response = $products->getTotalSales($from_date, $to_date);

    $description = $employee_Details->first_name ." retrieved total sales";

    $reg_activity->setReportTypeId($id);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}