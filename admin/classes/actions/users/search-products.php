<?php
require_once 'require_files.php';
    
try {
    //assign value to variables
    $user_id = isset($_GET['user_id']) 
        ? $reg_activity->formatInput($_GET['user_id']) : '';
    $user_ses_id = isset($_GET['user_ses_id']) 
        ? $reg_activity->formatInput($_GET['user_ses_id']) : '';
    $transaction_id = isset($_GET['transaction_id']) 
        ? $reg_activity->formatInput($_GET['transaction_id']) : '';
    $device_id = isset($_GET['device_id']) 
        ? $reg_activity->formatInput($_GET['device_id']) : null;
    $keywords = isset($_GET['keywords']) 
        ? $reg_activity->formatInput($_GET['keywords']) : null;
    
    $get_request = json_encode($_GET);
    
    // Initialize report variables
    $reg_activity->setReportType("Searched Products");
    // set report values and create initial report
    require_once 'set-report-values.php';   

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required"); 
    
    if (empty($transaction_id)){
        throw new Exception("No device configuration IDs. Please contact admin");
    }
    if ($user_id) {
        if (empty($user_ses_id))
            throw new Exception("Some important values are empty. Please try and rectify");
    } else {
        if (empty($device_id))
            throw new Exception("No device ID found");
        $user_ses_id = $device_id;
        $reg_activity->setState($web);
    }
    
    //Checks if this request has been registered before
    $reg_activity->validateRequest();
    
    //check if request is from web version
    if ($user_id) { 
        //Checks if the User exist as well as if the user is ban
        $reg_activity->validateUser();

        //Check if Session ID provided Matches with User ID
        $reg_activity->checkUser();
    }

    $products = new Products();
    $response = $products->getProductsSearch($keywords);
    
    $reg_activity->setReportTypeId($user_id);
    $reg_activity->createSuccessReport();
    echo json_encode($response), JSON_PRETTY_PRINT);
    exit;

} catch (Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}