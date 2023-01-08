<?php
require_once 'require_files.php';
    
try {
    //assign value to variables
    $name = isset($_POST['name']) 
        ? $reg_activity->formatInput($_POST['name']) : '';
    $email = isset($_POST['email']) 
        ? $reg_activity->formatInput($_POST['email']) : '';
    $transaction_id = isset($_POST['transaction_id']) 
        ? $reg_activity->formatInput($_POST['transaction_id']) : '';
    $phone = isset($_POST['phone']) 
        ? $reg_activity->formatInput($_POST['phone']) : null;
    $subject = isset($_POST['subject']) 
        ? $reg_activity->formatInput($_POST['subject']) : null;
    $message = isset($_POST['message']) 
        ? $reg_activity->formatInput($_POST['message']) : null;
    
    $get_request = json_encode($_POST);
    
    // Initialize report variables
    $reg_activity->setReportType("Contact Us");
    // set report values and create initial report
    require_once 'set-report-values.php';   

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");

    if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)){
        throw new Exception("Some important values are empty. Please try and rectify");
    }
    if (empty($transaction_id)) {
        throw new Exception("No device configuration IDs. Please contact admin");
    }
    
    //Checks if this request has been registered before
    $reg_activity->validateRequest();       

    $contact_us = new ContactUs();
    
    //send users details to contact_us function in user.php for processing 
    $response = $contact_us->newMessage($name, $phone, $email, $message, $subject);
    
    $reg_activity->setReportTypeId($user_id);
    $reg_activity->setState("contact");
    $reg_activity->createSuccessReport();
    
    echo json_encode(array("message"=>"We have received your message. You will hear from us soon. Thank you!","success"=>true), JSON_PRETTY_PRINT);  //return feedback
    
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}