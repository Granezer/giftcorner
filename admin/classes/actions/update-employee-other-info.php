<?php
require_once 'required-files.php';

try {
       
    //assign value to variables
    $id = isset($_POST['id']) 
        ? $reg_activity->formatInput($_POST['id']) : null;
    $department = isset($_POST['department']) 
        ? $reg_activity->formatInput($_POST['department']) : null;
    $joined_date = isset($_POST['joined_date']) 
        ? $reg_activity->formatInput($_POST['joined_date']) : null;
    $engagement_date = isset($_POST['engagement_date']) 
        ? $reg_activity->formatInput($_POST['engagement_date']) : null;

    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Updated Employee");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required 400");    

    if (empty($joined_date)) throw new Exception("Please select date registered");
    if (empty($id)) throw new Exception("Employee ID not found 417");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $employee = new Employees\Employees();
    $response = $employee->updateOtherInfo($department, $joined_date, $engagement_date, $id);

    $report_type_id = $id;
    $description = $employee_Details->first_name . " updated employee of ID ".$id;

    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description);

    echo json_encode($response, JSON_PRETTY_PRINT);
    
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}