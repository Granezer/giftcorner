<?php
require_once 'require_files.php';

try {
    //assign value to variables
    $id = isset($_POST['id']) ? $reg_activity->formatInput($_POST['id']) : 0;

    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Set Default Address");
    // set report values and create initial report
    require_once 'set-report-values.php';   

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");   

    if(empty($id)) {
        throw new Exception("No ID found");
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
    $reg_activity->checkUser();      

    $shipping = new Users\Shipping();
    
    //send users password to Password Changed function in register.php for processing 
    $shipping->setShippingAddressAsDefault($user_id, $id);

    $reg_activity->setReportTypeId($id);
    $reg_activity->createSuccessReport(); 
    echo json_encode(array("message" => "Operation was successful", "success" => true), JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}