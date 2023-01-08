<?php
require_once 'required-files.php';
// $reg_activity = new Engine\LogActivity();

try {       
    //assign value to variables
    $email = isset($_POST['email']) ? $reg_activity->formatInput($_POST['email']) : null;
    $transaction_id = isset($_POST['transaction_id']) ? 
        $reg_activity->formatInput($_POST['transaction_id']) : null;
    $password = isset($_POST['password']) ? $reg_activity->formatInput($_POST['password']) : null;
    $device_name = $_COOKIE['device_name'];
    $device_id = $_COOKIE['device_id'];

    $_POST['device_name'] = $device_name;
    $_POST['device_id'] = $device_id;

    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Login");
    $reg_activity->setTransactionId($transaction_id);
    $reg_activity->setEmployeeId(0);
    $reg_activity->setGetRequest($get_request);
    $reg_activity->setState('login');
    $reg_activity->setUserSessionId(0);      

    // Register initial request
    $reg_activity->createInitialReport();

    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");

    if (empty($email)) throw new Exception("Error: Email can not be empty");
    if (empty($password)) throw new Exception("Error: Password can not be empty");

    if (empty($transaction_id)){
        throw new Exception("No device configuration IDs. Please contact admin");
    }

    // Checks if this request has been registered before
    $reg_activity->validateRequest();

    $login = new Login();

    $phoneExist = $login->checkEmployeeLoginState($device_id, $device_name);

    if($phoneExist){
        $login_id = $phoneExist->id;
        $logout = new Logout();
        $logout->logoutDevice($login_id);
    }

    //go ahead and register user
    $response = $login->login($email, $password, $device_id, $device_name);

    // Register request as successful
    $description = $response->first_name." logged in";
    $reg_activity->setReportTypeId($response->login_id);
    $reg_activity->setEmployeeId($response->employee_id);
    $reg_activity->setUserSessionId($response->user_ses_id);
    $reg_activity->setState('login');
    $reg_activity->createSuccessReport($description); 
    
    setcookie("employee_type", $response->employee_type, time() + 120000, '/');

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}