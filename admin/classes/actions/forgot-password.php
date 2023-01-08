<?php
require_once 'required-files.php';
    
try {

    //assign value to variables
    $email = isset($_POST['email']) 
        ? $reg_activity->formatInput($_POST['email']):null;
    $transaction_id = isset($_POST['transaction_id']) 
        ? $reg_activity->formatInput($_POST['transaction_id']):null; 
    $user_id = $user_ses_id = 0;
    
    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Sent Reset Password Code");
    $reg_activity->setTransactionId($transaction_id);
    $reg_activity->setEmployeeId(0);
    $reg_activity->setGetRequest($get_request);
    $reg_activity->setState('forgot password');
    $reg_activity->setUserSessionId(0);      

    // Register initial request
    $reg_activity->createInitialReport();

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required 400");      

    if (empty($email))
        throw new Exception("Error: Email can not be empty 417");

    if (empty($transaction_id))
        throw new Exception("No device configuration IDs. Please contact support 417");
    
    //Checks if this request has been registered before
    $reg_activity->validateRequest();
    
    $checkEmail = new Employees\Employees();
    $response = $checkEmail->getEmployeeByEmail($email);
    if (!$response) 
        throw new Exception("$email does not exist in our database 404");
    
    $name = $response->first_name;

    $codes = new VerificationCode();
    $code = $codes->newCode($email,'admin');

    if (!$code) throw new Exception("Error: an error has occurred. Try again");

    $emailInstance = new Email();
    $emailDetails = $emailInstance->getEmailTemplateByType("forgot/reset password");
    if (!$emailDetails) 
        throw new Exception("Something went wrong. Contact support");

    $title = $emailDetails->title;
    $content = $emailDetails->content;
    $from = $emailDetails->from_email;

    $content = str_replace("{code}",$code,$content);
    $subject = "Request to Reset ". $comp_title ." Password";

    if(!$emailInstance->sendHTMLEmail($from, $email, $subject, $content, $title, $name)) 
        throw new Exception("Error: Unable to send mail");

    $_SESSION['email'] = $email;

    $msg = "A mail has been sent to you. Kindly check.";
    $description = $name ." requested for password reset code";
    $response = array('message'=>$msg, 'success'=>true); 

    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);
    
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}