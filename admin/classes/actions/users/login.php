<?php
require_once 'require_files.php';
    
try {
    //Assign values to variables
    $email = isset($_POST['email']) 
        ? $reg_activity->formatInput($_POST['email']) : '';
    $password = isset($_POST['password']) 
        ? $reg_activity->formatInput($_POST['password']) : '';
    $transaction_id = isset($_POST['transaction_id']) 
        ? $reg_activity->formatInput($_POST['transaction_id']) : '';

    // $device_name = $_COOKIE['device_name'];
    // $device_id = $_COOKIE['device_id'];

    // $_POST['device_name'] = $device_name;
    // $_POST['device_id'] = $device_id;
    $device_name = isset($_POST['device_name']) 
        ? $reg_activity->formatInput($_POST['device_name']) : null;
    $device_id = isset($_POST['device_id']) 
        ? $reg_activity->formatInput($_POST['device_id']) : null;

    $get_request = json_encode($_POST);
    
    $reg_activity->setReportType("Logins");
    $reg_activity->setTransactionId($transaction_id);
    $reg_activity->setUserId(0);
    $reg_activity->setGetRequest($get_request);
    $reg_activity->setState();
    $reg_activity->setUserSessionId(0);
    $reg_activity->createInitialReport(); 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");  

    if (empty($email)){
        throw new Exception("Email values is empty.");
    }
    if (empty($password)){
        throw new Exception("Password values is empty.");
    }

    if (empty($transaction_id) || empty($device_id) || empty($device_name)){
        throw new Exception("No device configuration IDs. Please contact admin");
    }

    //Checks if this request has been registered before
    $reg_activity->validateRequest();

    $userLogin = new Users\Login();
    
    //send users details to loginUsers function in login.php for processing 
    $response = $userLogin->loginUsers($email, $password, $device_id, $device_name);

    $reg_activity->setReportTypeId($response->login_id);
    $reg_activity->setUserId($response->user_id);
    $reg_activity->setUserSessionId($response->user_ses_id);
    $reg_activity->setState('login');
    $reg_activity->createSuccessReport();

    $state = $reg_activity->checkUserLoginDevice($response->user_id, $device_id, $device_name, $response->login_id);
    
    echo json_encode(array("message"=>"success", "success"=>true, "data"=>$response), JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}