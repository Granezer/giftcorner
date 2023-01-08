<?php
require_once 'required-files.php';
    
try {
    
    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Sent Email Verification Link");
    $reg_activity->setTransactionId($transaction_id);
    $reg_activity->setEmployeeId(0);
    $reg_activity->setGetRequest($get_request);
    $reg_activity->setState('reg');
    $reg_activity->setUserSessionId(0);     

    // Register initial request
    $reg_activity->createInitialReport();

    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");

    $tin = isset($_POST['tin']) ? $reg_activity->formatInput($_POST['tin']) : null;
    $email = isset($_POST['email']) ? $reg_activity->formatInput($_POST['email']) : null; 
    $transaction_id = isset($_POST['transaction_id']) ? $reg_activity->formatInput($_POST['transaction_id']) : null; 

    if(empty($tin))
        throw new Exception("Please enter your TIN");

    if(empty($email))
        throw new Exception("Please enter your company email");

    if (empty($transaction_id))
        throw new Exception("No device configuration IDs. Please contact admin");  

    // Checks if this request has been registered before
    $reg_activity->validateRequest();

    $payer = new Payer();
    $response = $payer->getPayerByTIN($tin);
    if (!$response) throw new Exception("Invalid TIN found");
    if ($response->payer_type == "individual") throw new Exception("You are not eligible");
    if ($response->company_email != $email) 
        throw new Exception("Please provide your company tax email");
    if ($response->consultant == 1) 
        throw new Exception("You're not eligible because you've already sign up as a consultant. Please contact admin for assistance");
    if ($response->tama == 1) 
        throw new Exception("You're already signed up. Kindly login");
    
    $consultant_id = $response->id;
    $company_name = $response->company_name;
    $name = $response->company_name;

    $verification_code = new VerificationCode();
    $response = $verification_code->getCodeByEmail($email);

    if ($response) {
        $expiring = strtotime($response->expiration_date_time);
        $date_time = strtotime(date("Y-m-d H:i:s"));
        $seconds = $date_time - $expiring;

        if ($seconds < 1800) {
            throw new Exception("A mail has been sent to you before. Kindly wait for 30 Minutes and try again."); 
        }
    }

    $code = $verification_code->newCode($email, 'admin');

    if ($code) {

        $emails = new Email();
        $emailDetails = $emails->getEmailTemplateByType("Verify email");
        if (!$emailDetails) throw new Exception("Something went wrong. Contact support");

        $title = $emailDetails->title;
        $content = $emailDetails->content;
        $from = $emailDetails->from_email;

        $token = password_hash($code, PASSWORD_DEFAULT);
        $link = "http://localhost/pure/admin/verify-email?code=$code&token=$token";
        // $link = '<a href="$link">$link</a>';

        $title = str_replace("{name}",$name,$title);
        $content = str_replace("{link}",$link,$content);

        $subject = "REQUEST TO BECOME A CONSULTANT";
        $result = $emails->sendHTMLEmail($from, $email, $subject, $content, $title, $name);

        if($result) {
            $description = "Email verification sent to ".$company_name;
            $reg_activity->setReportTypeId($consultant_id);
            $reg_activity->createSuccessReport($description);

            $response = array("success" => true, "message" => "Email sent");
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }
        throw new Exception("Error: Unable to send mail");
    }
    throw new Exception("Error: an error has occurred. Try again");
    
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}