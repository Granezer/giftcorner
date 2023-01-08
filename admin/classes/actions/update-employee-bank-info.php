<?php
require_once 'required-files.php';

try {
       
    //assign value to variables
    $id = isset($_POST['id']) 
        ? $reg_activity->formatInput($_POST['id']) : null;
    $acc_name = isset($_POST['acc_name']) 
        ? $reg_activity->formatInput($_POST['acc_name']) : null;
    $bank_sort_code = isset($_POST['bank_sort_code']) 
        ? $reg_activity->formatInput($_POST['bank_sort_code']) : null;
    $acc_no = isset($_POST['acc_no']) 
        ? $reg_activity->formatInput($_POST['acc_no']) : null;
    $bank_name = isset($_POST['bank_name']) 
        ? $reg_activity->formatInput($_POST['bank_name']) : null;

    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Updated Employee");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required 400");    

    if (empty($acc_name)) throw new Exception("Enter bank name 417");
    if (empty($bank_name)) throw new Exception("Enter select bank 417");
    if (empty($acc_no)) throw new Exception("Please enter account no 417");
    if (empty($bank_sort_code)) throw new Exception("Please enter bank sort code 417");
    if (empty($id)) throw new Exception("Employee ID not found 417");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $employee = new Engine\Employees\Employees();
    $response = $employee->updateBank($acc_name, $acc_no, $bank_name, $bank_sort_code, $id);

    $report_type_id = $id;
    $description = $employee_Details->first_name . " updated employee of ID ".$id;

    require_once 'response.php';
    
} catch(Exception $error) {
    require_once 'error-response.php';
}