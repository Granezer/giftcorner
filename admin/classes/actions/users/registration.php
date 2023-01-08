<?php
require_once 'require_files.php';

try {
    //assign value to variables
    $transaction_id = isset($_POST['transaction_id']) 
        ? $reg_activity->formatInput($_POST['transaction_id']) : '';
    $password = isset($_POST['password']) 
        ? $reg_activity->formatInput($_POST['password']) : 0;
    $email = isset($_POST['email']) 
        ? $reg_activity->formatInput($_POST['email']) : 0;
    
    $fullname = isset($_POST['fullname']) 
        ? $reg_activity->formatInput($_POST['fullname']) : null;
    $phone = isset($_POST['phone']) 
        ? $reg_activity->formatInput($_POST['phone']) : null;
    $gender = isset($_POST['gender']) 
        ? $reg_activity->formatInput($_POST['gender']) : null;

    $device_name = isset($_POST['device_name']) 
        ? $reg_activity->formatInput($_POST['device_name']) : null;
    $device_id = isset($_POST['device_id']) 
        ? $reg_activity->formatInput($_POST['device_id']) : null;

    // $device_name = isset($_COOKIE['device_name']) 
    //     ? $_COOKIE['device_name'] : null;
    // $device_id = isset($_COOKIE['device_id']) 
    //     ? $_COOKIE['device_id'] : null;

    // $_POST['device_name'] = $device_name;
    // $_POST['device_id'] = $device_id;
    
    $get_request = json_encode($_POST);
    
    // Initialize report variables
    $reg_activity->setReportType("Registration");
    $reg_activity->setTransactionId($transaction_id);
    $reg_activity->setUserId(0);
    $reg_activity->setGetRequest($get_request);
    $reg_activity->setState();
    $reg_activity->setUserSessionId(0);
    $reg_activity->createInitialReport();  

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required"); 

    if (empty($fullname) || empty($password) || empty($email) || empty($phone)) {
        throw new Exception("Complete the form fisrt. Please try and rectify");
    }

    if ($gender) {
        if (!in_array($gender, array("male", "female"))){
            throw new Exception("Invalid gender");
        }
    }

    if (empty($transaction_id) || empty($device_id) || empty($device_name)) {
        throw new Exception("No device configuration IDs. Please contact admin");
    }
    
    //Checks if this request has been registered before
    $reg_activity->validateRequest();

    $registration_type = "Manual";

    $userReg = new Users\Registration();
    
    //send users details to createNewUser function in register.php for processing 
    //$instagram, $twitter, $facebook
    $response = $userReg->createNewUser($password, $email, $fullname, $phone, $gender, $device_id, $device_name, $registration_type);

    $code = $userReg->createConfirmationLink($email);

    $my_name = explode(" ", $fullname);

    $emailInstance = new Email();
    $contents = $emailInstance->getEmailTemplateByType("registration");

    $title = $contents->title;
    $content = $contents->content;
    $sfrom = $contents->from_email;

    $link = '<a href="https://giftcornerng.com/confirm-email.php?confirm-id=' . $code . '" style=" display:block; text-decoration:none; border:0; text-align:center; font-weight:bold;font-size:18px; font-family: Arial, sans-serif; color: #ffffff; background:#db4c3f" class="button_link">Confirm Email</a>';
    $content = str_replace("{link}",$link,$content);
    $subject = "Welcome to Pure Health Consult ". $my_name[0];
    $emailInstance->sendHTMLEmail($sfrom, $email, $subject, $content, $title, $my_name[0]);

    $reg_activity->setReportTypeId($response->login_id);
    $reg_activity->setUserId($response->user_id);
    $reg_activity->setUserSessionId($response->user_ses_id);
    $reg_activity->setState('reg');
    $reg_activity->createSuccessReport();
    
    echo json_encode(array("message" => "success", "success" => true, "data"=>$response), JSON_PRETTY_PRINT);
     
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}