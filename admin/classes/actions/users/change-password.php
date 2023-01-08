<?php
require_once 'require_files.php';

try {
    //assign value to variables
    $current_password = isset($_POST['current_password']) ? $reg_activity->formatInput($_POST['current_password']) : 0;
    $new_password = isset($_POST['new_password'])? $reg_activity->formatInput($_POST['new_password']) : '';

    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Password Changed");
    // set report values and create initial report
    require_once 'set-report-values.php';   

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");   

    if(empty($new_password) || empty($current_password) ){
        throw new Exception("Some important values are empty. Please try and rectify");
    }

    if (empty($transaction_id)){
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
    $login_details = $reg_activity->checkUser();
    $login_id = $login_details->id;

    $hashed_old_password = md5($current_password);
    $hashed_new_password = md5($new_password);        

    $changePassword = new Users\ChangePassword();
    
    //send users password to Password Changed function in register.php for processing 
    $result = $changePassword->changeUserPassword($user_id, $hashed_new_password, $hashed_old_password);

    $reg_activity->setReportTypeId($user_id);
    $reg_activity->createSuccessReport();
    echo json_encode(array("message" => "Password change successfully", "success" => true), JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}