<?php
require_once 'require_files.php';

try {
    //Assign values to variables  
    $login_id = isset($_SESSION['login_id']) 
        ? $_SESSION['login_id'] : 0;
    $_POST['login_id'] = $login_id;
    $transaction_id = isset($_POST['transaction_id']) 
        ? $reg_activity->formatInput($_POST['transaction_id']) : '';
    $device_id = $_COOKIE['device_id'];
    $get_request = json_encode($_POST);
    
    // Initialize report variables
    $reg_activity->setReportType("Logged Out");
    // set report values and create initial report
    require_once 'set-report-values.php'; 
    $reg_activity->setState('logout');   

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");         

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
    
    $response = $reg_activity->logoutSession($login_id);

    $carts = new Users\Carts();
    $carts->updateCartSession($user_id, $user_ses_id, $device_id);

    $reg_activity->setReportTypeId($login_id);
    $reg_activity->setState('logout');
    $reg_activity->createSuccessReport();

    $reg_activity->unsetSessions();
    
    echo json_encode(array("message" => "Logout successfully", "success" => true), JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->unsetSessions();
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    $_SESSION["error"] = $error->getMessage();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}