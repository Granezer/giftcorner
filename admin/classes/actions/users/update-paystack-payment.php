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
    $order_no = isset($_POST['order_no']) 
        ? $reg_activity->formatInput($_POST['order_no']) : 0;
    $reference_no = isset($_POST['reference_no']) 
        ? $reg_activity->formatInput($_POST['reference_no']) : 0;
    
    $get_request = json_encode($_POST);
    
    // Initialize report variables
    $reg_activity->setReportType("Update Paystack Payment");
    // set report values and create initial report
    require_once 'set-report-values.php';   

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");  

    if (empty($reference_no)) 
        throw new Exception("reference no is empty");
    if (empty($order_no)) throw new Exception("Order no is empty"); 
    if (empty($transaction_id)) {
        throw new Exception("No device configuration IDs. Please contact admin");
    }
    if (empty($user_id) || empty($user_ses_id)) {
        throw new Exception("Some important values are empty. Please try and rectify");
    }
        
    //Checks if this request has been registered before
    $reg_activity->validateRequest();
    
    //Checks if the User exist as well as if the user is ban
    $reg_activity->validateUser();

    //Check if Session ID provided Matches with User ID
    $reg_activity->checkUser();

    $payment = new Payments();
    $result = $payment->updatePaystckPayment($order_no, $reference_no);

    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport();

    echo json_encode(array("message" => "operation was successful", "success" => true), JSON_PRETTY_PRINT); 

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}