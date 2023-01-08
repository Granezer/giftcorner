<?php
require_once 'required-files.php';

try {
    $id = isset($_GET['id']) 
        ? $reg_activity->formatInput($_GET['id']): 0;

    $get_request = json_encode($_GET);

    // Initialize report variables
    $reg_activity->setReportType("Retrieved Users");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required"); 

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee2.php';

    require_once 'pagination.php';
    
    $users = new Users();

    $response = array();
    if ($id) {
        $response = $users->getUser($id);
    } else $response = $users->getUsers($pagination, $sort, $query, $_REQUEST);

    $description = $employee_Details->first_name . " retrieved users";
    $reg_activity->setReportTypeId($id);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}