<?php
require_once 'require_files.php';
    
try {
    //assign value to variables
    $user_id = isset($_POST['user_id']) 
        ? $reg_activity->formatInput($_POST['user_id']) : '';
    $user_ses_id = isset($_POST['user_ses_id']) 
        ? $reg_activity->formatInput($_POST['user_ses_id']) : '';
    $transaction_id = isset($_POST['transaction_id']) 
        ? $reg_activity->formatInput($_POST['transaction_id']) : '';
    $fullname = isset($_POST['fullname']) 
        ? $reg_activity->formatInput($_POST['fullname']) : null;
    $gender = isset($_POST['gender']) 
        ? $reg_activity->formatInput($_POST['gender']) : null;
    $phone = isset($_POST['phone']) 
        ? $reg_activity->formatInput($_POST['phone']) : null;
    
    $get_request = json_encode($_POST);
    
    // Initialize report variables
    $reg_activity->setReportType("Updated Profile");
    // set report values and create initial report
    require_once 'set-report-values.php';   

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");

    if (empty($gender) || empty($fullname)){
        throw new Exception("Some important values are empty. Please try and rectify");
    }
    if (empty($transaction_id)) {
        throw new Exception("No device configuration IDs. Please contact admin");
    }
    if (empty($user_id) || empty($user_ses_id)){
        throw new Exception("Some important values are empty. Please try and rectify");
    }
    
    //Checks if this request has been registered before
    $reg_activity->validateRequest();
    
    //Checks if the User exist as well as if the user is ban
    $reg_activity->validateUser();

    //Check if Session ID provided Matches with User ID
    $reg_activity->checkUser();         

    $updateUser = new Users\Registration();
    
    //send users details to updateUser function in user.php for processing 
    $response = $updateUser->updateUser($user_id, $gender, $fullname, $phone);
    
    $reg_activity->setReportTypeId($user_id);
    $reg_activity->createSuccessReport();

    $_SESSION['fullname'] = $fullname;
    $_SESSION['phone'] = $phone;  
    $_SESSION['gender'] = $gender;
    
    echo json_encode(array("message"=>"Updated successfully","success"=>true), JSON_PRETTY_PRINT);  //return feedback
    
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}