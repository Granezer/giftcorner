<?php
require_once 'require_files.php';
    
try {

    //assign value to variables
    $email = isset($_POST['email']) 
        ? $reg_activity->formatInput($_POST['email']):null;
    $transaction_id = isset($_POST['transaction_id']) 
        ? $reg_activity->formatInput($_POST['transaction_id']):null; 
    
    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Sent Password Code");
    $reg_activity->setTransactionId($transaction_id);
    $reg_activity->setUserId(0);
    $reg_activity->setGetRequest($get_request);
    $reg_activity->setState();
    $reg_activity->setUserSessionId(0);
    $reg_activity->createInitialReport(); 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");      

    if (empty($email))
        throw new Exception("Error: Email can not be empty");

    if (empty($transaction_id))
        throw new Exception("No device configuration IDs. Please contact support");
    
    //Checks if this request has been registered before
    $reg_activity->validateRequest();
    
    $checkEmail = new Users();
    $response = $checkEmail->getUserByEmail($email);
    if (!$response['data']) 
        throw new Exception("$email does not exist in our database");
    
    $response = $response['data'];
    $name = explode(' ', $response->fullname);
    $name = $name[0];

    $codes = new VerificationCode();
    $code = $codes->newCode($email);

    if (!$code) throw new Exception("Error: an error has occurred. Try again");

    $emailInstance = new Email();
    $emailDetails = $emailInstance->getEmailTemplateByType("forgot/reset password");
    if (!$emailDetails) 
        throw new Exception("Something went wrong. Contact support");

    $title = $emailDetails->title;
    $content = $emailDetails->content;
    $from = $emailDetails->from_email;

    $content = str_replace("{code}",$code,$content);
    $subject = "Request to Reset Password";

    if (!$emailInstance->sendHTMLEmail($from, $email, $subject, $content, $title, $name)) 
        throw new Exception("Error: Unable to send mail");

    $_SESSION['email'] = $email;

    $reg_activity->setState('forgot password');

    $msg = "A mail has been sent to you. Kindly check.";
    $description = $name ." requested for password reset code";

   echo json_encode(array("message"=>$msg, "success"=>true), JSON_PRETTY_PRINT);
    
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}