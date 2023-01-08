<?php
require_once 'required-files.php';

try {
       
    //assign value to variables
    $id = isset($_POST['id']) 
        ? $reg_activity->formatInput($_POST['id']) : null;
    $first_name = isset($_POST['first_name']) 
        ? $reg_activity->formatInput(ucwords($_POST['first_name'])) : null;
    $last_name = isset($_POST['last_name']) 
        ? $reg_activity->formatInput(ucwords($_POST['last_name'])) : null;
    $title = isset($_POST['title']) 
        ? $reg_activity->formatInput(ucwords($_POST['title'])) : null;
    $gender = isset($_POST['gender']) 
        ? $reg_activity->formatInput($_POST['gender']) : null;
    $marital_status = isset($_POST['marital_status']) 
        ? $reg_activity->formatInput($_POST['marital_status']) : null;
    $place_of_birth = isset($_POST['place_of_birth']) 
        ? $reg_activity->formatInput($_POST['place_of_birth']) : null;
    $dob = isset($_POST['dob']) 
        ? $reg_activity->formatInput($_POST['dob']) : null;

    $profile_image = isset($_FILES['profile_image']) 
        ? $_FILES['profile_image'] : null;
    $imageDestination = isset($_POST['imageDestination']) 
        ? $reg_activity->formatInput($_POST['imageDestination']) : null;

    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Updated Employee");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required 400");    

    if (empty($first_name)) throw new Exception("Enter first name 417");
    if (empty($last_name)) throw new Exception("Enter last name 417");
    if (empty($title)) throw new Exception("Enter title 417");
    if (empty($gender)) throw new Exception("Please select gender 417");
    if (empty($marital_status)) throw new Exception("Please select marital status 417");
    if (empty($place_of_birth)) throw new Exception("Enter place of birth 417");
    if (empty($dob)) throw new Exception("Enter date of birth 417");
    if (empty($id)) throw new Exception("Employee ID not found 417");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $path = "../../assets/media/employees/";

    $employee = new Employees\Employees();
    $response = $employee->updateBasicInfo($title, $first_name, $last_name, $gender, $marital_status, $place_of_birth, $dob, $profile_image, $imageDestination, $path, $id);

    if ($employee_id == $id) {
        $_SESSION['profile_image'] = $response['data']->profile_image;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
    }

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