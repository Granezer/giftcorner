<?php
require_once '../required-files.php';
$reg_activity = new LogActivity();

try {
       
    //assign value to variables
    $name = isset($_POST['name']) 
        ? $reg_activity->formatInput($_POST['name']) : null;
    $id = isset($_POST['id']) 
        ? $reg_activity->formatInput($_POST['id']) : null;

    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Updated Designation");
    // set report values and create initial report
    require_once '../set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");    

    if (empty($name)) throw new Exception("Enter designation name");
    if (empty($id)) throw new Exception("ID not found");

    $module_name = "settings";
    $module_permission_name = "write";

    // Checks if this request has been registered before and validate employee
    require_once '../validate-employee.php';

    $edit_designation = new Settings\Designation();
    $response = $edit_designation->editDesignation($id, $name);

    // Register request as successful
    $reg_activity->setReportTypeId(0);

    $description = $employee_Details->first_name . " updated designation ".strtoupper($name);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}