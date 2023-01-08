<?php
require_once 'require-files.php';

try {
    $user_id = isset($_GET['user_id']) 
        ? $reg_activity->formatInput($_GET['user_id']): 0;

    $get_request = json_encode($_GET);

    // Initialize report variables
    $reg_activity->setReportType("Retrieved Activities");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required");   

    // Checks if this request has been registered before and validate employee
    require_once 'validate-employee2.php';

    require_once 'pagination.php';
    
    $response = array();
    if ($user_id) {
        $response = $reg_activity->getUserActivities($pagination, $sort, $query, $_REQUEST, $user_id);
    } else {
        $response = $reg_activity->getActivities($pagination, $sort, $query, $_REQUEST);
    }

    $description = $employee_Details->first_name . " retrieved user activities";
    $reg_activity->setReportTypeId($employee_id);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}