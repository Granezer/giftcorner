<?php
require_once 'required-files.php';

try {
       
    //assign value to variables
    $id = isset($_POST['id']) 
        ? $reg_activity->formatInput($_POST['id']) : null;
    $email = isset($_POST['email']) 
        ? $reg_activity->formatInput($_POST['email']) : null;
    $phone1 = isset($_POST['phone1']) 
        ? $reg_activity->formatInput($_POST['phone1']) : null;
    $phone2 = isset($_POST['phone2']) 
        ? $reg_activity->formatInput($_POST['phone2']) : null;
    $address1 = isset($_POST['address1']) 
        ? $reg_activity->formatInput($_POST['address1']) : null;
    $address2 = isset($_POST['address2']) 
        ? $reg_activity->formatInput($_POST['address2']) : null;
    $post_code = isset($_POST['post_code']) 
        ? $reg_activity->formatInput($_POST['post_code']) : null;
    $city = isset($_POST['city']) 
        ? $reg_activity->formatInput($_POST['city']) : null;
    $state1 = isset($_POST['state1']) 
        ? $reg_activity->formatInput($_POST['state1']) : null;
    $lga = isset($_POST['lga']) 
        ? $reg_activity->formatInput($_POST['lga']) : null;
    $country = isset($_POST['country']) 
        ? $reg_activity->formatInput($_POST['country']) : null;

    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Updated Employee");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required 400");    

    if (empty($phone1)) throw new Exception("Enter phone number 417");
    if (empty($email)) throw new Exception("Enter email 417");
    if (empty($address1)) throw new Exception("Please enter address 417");
    if (empty($post_code)) throw new Exception("Please enter postcode 417");
    if (empty($city)) throw new Exception("Enter city 417");
    if (empty($lga)) throw new Exception("Please select LGA 417");
    if (empty($state1)) throw new Exception("Please select state 417");
    if (empty($country)) throw new Exception("Please select country 417");
    if (empty($id)) throw new Exception("Employee ID not found 417");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $employee = new Employees\Employees();
    $response = $employee->updateContactInfo($phone1, $phone2, $email, $address1, $address2, $post_code, $city, $lga, $state1, $country, $id);

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