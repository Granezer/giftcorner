<?php
require_once 'required-files.php';
$reg_activity = new LogActivity();

try {

    // Get all GET data and assign to get_request variable
    $get_request = json_encode($_GET);

    // Initialize report variables
    $reg_activity->setReportType("Retrieved Logs");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required");    

    // Checks if this request has been registered before and validate payer
    require_once 'validate-payer.php';

    require_once 'pagination.php';
    $response = $reg_activity->getActivityLogs($payer_id, $_GET['payer_type'], $pagination, $sort, $query);

    // Register request as successful
    $description = $employee_Details->first_name;
    $description .= " retrieved logs";
    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}