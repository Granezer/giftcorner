<?php
require_once 'required-files.php';

try {
       
    //assign value to variables
    $title = isset($_POST['title']) 
        ? $reg_activity->formatInput(ucwords($_POST['title'])) : null;
    $first_name = isset($_POST['first_name']) 
        ? $reg_activity->formatInput(ucwords($_POST['first_name'])) : null;
    $last_name = isset($_POST['last_name']) 
        ? $reg_activity->formatInput(ucwords($_POST['last_name'])) : null;
    $gender = isset($_POST['gender']) 
        ? $reg_activity->formatInput($_POST['gender']) : null;
    $marital_status = isset($_POST['marital_status']) 
        ? $reg_activity->formatInput($_POST['marital_status']) : null;
    $dob = isset($_POST['dob']) 
        ? $reg_activity->formatInput($_POST['dob']) : null;
    $place_of_birth = isset($_POST['place_of_birth']) 
        ? $reg_activity->formatInput($_POST['place_of_birth']) : null;

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

    $department = isset($_POST['department']) 
        ? $reg_activity->formatInput($_POST['department']) : null;
    $joined_date = isset($_POST['joined_date']) 
        ? $reg_activity->formatInput($_POST['joined_date']) : null;
    $designation = isset($_POST['designation']) 
        ? $reg_activity->formatInput($_POST['designation']) : null;
    $bank_name = isset($_POST['bank_name']) 
        ? $reg_activity->formatInput($_POST['bank_name']) : null;
    $bank_sort_code = isset($_POST['bank_sort_code']) 
        ? $reg_activity->formatInput($_POST['bank_sort_code']) : null;
    $acc_name = isset($_POST['acc_name']) 
        ? $reg_activity->formatInput($_POST['acc_name']) : null;
    $acc_no = isset($_POST['acc_no']) 
        ? $reg_activity->formatInput($_POST['acc_no']) : null;
    $referee_name_1 = isset($_POST['referee_name_1']) 
        ? $reg_activity->formatInput($_POST['referee_name_1']) : null;
    $referee_address_1 = isset($_POST['referee_address_1']) 
        ? $reg_activity->formatInput($_POST['referee_address_1']) : null;
    $referee_phone_1 = isset($_POST['referee_phone_1']) 
        ? $reg_activity->formatInput($_POST['referee_phone_1']) : null;
    $referee_occupation_1 = isset($_POST['referee_occupation_1']) 
        ? $reg_activity->formatInput($_POST['referee_occupation_1']) : null;
    $referee_name_2 = isset($_POST['referee_name_2']) 
        ? $reg_activity->formatInput($_POST['referee_name_2']) : null;
    $referee_address_2 = isset($_POST['referee_address_2']) 
        ? $reg_activity->formatInput($_POST['referee_address_2']) : null;
    $referee_phone_2 = isset($_POST['referee_phone_2']) 
        ? $reg_activity->formatInput($_POST['referee_phone_2']) : null;
    $referee_occupation_2 = isset($_POST['referee_occupation_2']) 
        ? $reg_activity->formatInput($_POST['referee_occupation_2']) : null;

    $profile_image = isset($_FILES['profile_image']['name']) 
        ? $_FILES['profile_image']['name'] : null;
    $imageDestination = isset($_POST['imageDestination']) 
        ? $reg_activity->formatInput($_POST['imageDestination']) : null;

    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Added Employee");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required 400");    

    if (empty($title)) throw new Exception("Enter title 417");
    if (empty($first_name)) throw new Exception("Enter firstname 417");
    if (empty($last_name)) throw new Exception("Enter lastname 417");
    if (empty($profile_image)) throw new Exception("Profile Image not found 417");
    if (empty($joined_date)) throw new Exception("Please select joined date 417");

    if (empty($bank_name)) throw new Exception("Please select bank name 417");
    if (empty($acc_name)) throw new Exception("Please enter account name 417");
    if (empty($acc_no)) throw new Exception("Please enter account no. 417");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    // $dob = $reg_activity->dateFormat($dob);
    // $joined_date = $reg_activity->dateFormat($joined_date);
    $path = "../../assets/media/employees/";

    $employee = new Employees\Employees();
    $response = $employee->newEmployee($title, $first_name, $last_name, $gender, $marital_status, $dob, $place_of_birth, $email, $phone1, $phone2, $address1, $address2, $post_code, $city, $state1, $lga, $country, $contact_name, $contact_address, $contact_phone, $contact_email, $contact_relationship, $joined_date, $designation, $department, $acc_name, $acc_no, $bank_name, $bank_sort_code, $referee_name_1, $referee_address_1, $referee_phone_1, $referee_occupation_1, $referee_name_2, $referee_address_2, $referee_phone_2, $referee_occupation_2, $_FILES['profile_image'], $imageDestination, $path);

    $emailInstance = new Email();
    $emailDetails = $emailInstance->getEmailTemplateByType("registration");
    if ($emailDetails) {
        $title = $emailDetails->title;
        $content = $emailDetails->content;
        $from = $emailDetails->from_email;

        $content = str_replace("{email}", $email, $content);
        $content = str_replace("{password}", $response['password'], $content);
        $subject = $comp_title." Registration";
        $emailInstance->sendHTMLEmail($from, $email, $subject, $content, $title, $first_name);
    }

    // Register request as successful
    $report_type_id = $response['employee_id'];
    $description = $employee_Details->first_name . " added new employee of ID ".$response['employee_id'];

    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}