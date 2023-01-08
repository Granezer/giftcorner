<?php
require_once 'required-files.php';
$reg_activity = new LogActivity();

try {
       
    //assign value to variables
    $code = isset($_GET['code']) ? $reg_activity->formatInput($_GET['code']) : null;
    $token = isset($_GET['token']) ? $reg_activity->formatInput($_GET['token']) : null;
    $transaction_id = isset($_GET['transaction_id']) ? 
        $reg_activity->formatInput($_GET['transaction_id']) : null;

    // Get all GET data and assign to get_request variable
    $get_request = json_encode($_GET);

    // Initialize report variables
    $reg_activity->setReportType("Verified Email");
    $reg_activity->setTransactionId($transaction_id);
    $reg_activity->setEmployeeId(0);
    $reg_activity->setGetRequest($get_request);
    $reg_activity->setState('verify');
    $reg_activity->setUserSessionId(0);      

    // Register initial request
    $reg_activity->createInitialReport();

    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required");

    if (empty($transaction_id) || empty($code) || empty($token)){
        throw new Exception("No device configuration IDs. Please contact admin");
    }

    //Checks if this request has been registered before
    $reg_activity->validateRequest();

    $verification_code = new VerificationCode();
    $response = $verification_code->getCode($code);

    if (!$response) throw new Exception("Invalid link");

    if(!password_verify($code, $token)) 
            throw new Exception("Invalid token detected");

    $payer = new Payer();
    $response = $payer->getPayerByCompanyEmail($response->email);
    if (!$response) throw new Exception("Unknown user");

    $verification_code->verifyCode($response->company_email, $code);
        // throw new Exception("Something went wrong");

    $verification_code->updateCode($response->company_email);

    // create new tama
    $tama = new Tama();
    $tama->newTama($response->id);
        
    // set report type variable
    $description = $response->company_name." verified email";
    $reg_activity->setReportTypeId($response->id);
    $reg_activity->setEmployeeId(0);
    $reg_activity->setUserSessionId(0);
    $reg_activity->createSuccessReport($description); 

    $response = array("success" => true, "message" => "Email verification was successful");
    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}