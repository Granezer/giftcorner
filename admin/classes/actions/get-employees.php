<?php
require_once 'required-files.php';

try {
    // echo json_encode($_SERVER); exit;
    //     $datatable = array_merge(array('pagination' => array(), 'sort' => array(), 'query' => array()), $_REQUEST);
    // echo json_encode($datatable); exit;
    // Get all GET data and assign to get_request variable
    $get_request = json_encode($_GET);

    // Initialize report variables
    $reg_activity->setReportType("Retrieved Employees");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required");    

    // Checks if this request has been registered before and validate employee
    require_once 'validate-employee2.php';

    $employees = new Employees\Employees();
    
    require_once 'pagination.php';
    $response = $employees->getEmployees($pagination, $sort, $query, $_REQUEST);

    // Register request as successful
    $description = $employee_Details->first_name . " retrieved employees";
    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}