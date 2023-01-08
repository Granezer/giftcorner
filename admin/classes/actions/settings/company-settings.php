<?php
require_once '../required-files.php';
$reg_activity = new LogActivity();

try {
       
    //assign value to variables
    $company_name = isset($_POST['company_name']) 
        ? $reg_activity->formatInput($_POST['company_name']) : null;
    $contact_person = isset($_POST['contact_person']) 
        ? $reg_activity->formatInput($_POST['contact_person']) : null;
    $mobile = isset($_POST['mobile']) 
        ? $reg_activity->formatInput($_POST['mobile']) : null;
    $fax = isset($_POST['fax']) 
        ? $reg_activity->formatInput($_POST['fax']) : null;

    $email = isset($_POST['email']) 
        ? $reg_activity->formatInput($_POST['email']) : null;
    $phone = isset($_POST['phone']) 
        ? $reg_activity->formatInput($_POST['phone']) : null;
    $address = isset($_POST['address']) 
        ? $reg_activity->formatInput($_POST['address']) : null;
    $post_code = isset($_POST['post_code']) 
        ? $reg_activity->formatInput($_POST['post_code']) : null;
    $city = isset($_POST['city']) 
        ? $reg_activity->formatInput($_POST['city']) : null;
    $state = isset($_POST['state']) 
        ? $reg_activity->formatInput($_POST['state']) : null;
    $country = isset($_POST['country']) 
        ? $reg_activity->formatInput($_POST['country']) : null;
    $website = isset($_POST['website']) 
        ? $reg_activity->formatInput($_POST['website']) : null;

    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Update Hospital Settings");
    // set report values and create initial report
    require_once '../set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");    

    if (empty($company_name)) throw new Exception("Enter hospital name");
    if (empty($contact_person)) throw new Exception("Enter hospital contact person");
    if (empty($phone)) throw new Exception("Enter hospital phone number");

    $module_name = "settings";
    $module_permission_name = "write";

    // Checks if this request has been registered before and validate employee
    require_once '../validate-employee.php';

    $hospital_settings = new Settings\HospitalSettings();
    $response = $hospital_settings->updateHospitalSettings(
        $company_name, $contact_person, $mobile, $fax, $email, $phone, $address, 
        $post_code, $city, $state, $country, $website
    );

    // Register request as successful
    $reg_activity->setReportTypeId(0);

    $description = $employee_Details->first_name . " updated hospital settings ";
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}