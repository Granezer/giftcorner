<?php
require_once 'required-files.php';

try {
       
    //assign value to variables
    $id = isset($_POST['id']) 
        ? $reg_activity->formatInput($_POST['id']) : null;
    $contact_name = isset($_POST['contact_name']) 
        ? $reg_activity->formatInput($_POST['contact_name']) : null;
    $contact_address = isset($_POST['contact_address']) 
        ? $reg_activity->formatInput($_POST['contact_address']) : null;
    $contact_phone = isset($_POST['contact_phone']) 
        ? $reg_activity->formatInput($_POST['contact_phone']) : null;
    $contact_email = isset($_POST['contact_email']) 
        ? $reg_activity->formatInput($_POST['contact_email']) : null;
    $contact_relationship = isset($_POST['contact_relationship']) 
        ? $reg_activity->formatInput($_POST['contact_relationship']) : null;

    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Updated Employee");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required 400");    

    if (empty($contact_name)) throw new Exception("Enter name 417");
    if (empty($contact_email)) throw new Exception("Enter email 417");
    if (empty($contact_phone)) throw new Exception("Please enter phone 417");
    if (empty($contact_address)) throw new Exception("Please enter address 417");
    if (empty($contact_relationship)) throw new Exception("Enter relationship 417");
    if (empty($id)) throw new Exception("Employee ID not found 417");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $employee = new Employees\Employees();
    $response = $employee->updateEmergencyInfo($contact_name, $contact_phone, $contact_email, $contact_address, $contact_relationship, $id);

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