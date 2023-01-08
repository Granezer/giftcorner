<?php   
require_once 'require_files.php';

try {
    //assign value to variables
    $user_id = isset($_POST['user_id']) 
        ? $reg_activity->formatInput($_POST['user_id']) : 0;
    $user_ses_id = isset($_POST['user_ses_id']) 
        ? $reg_activity->formatInput($_POST['user_ses_id']) : null;
    $transaction_id = isset($_POST['transaction_id']) 
        ? $reg_activity->formatInput($_POST['transaction_id']) : null;

    $shipping_amount = isset($_POST['shipping_amount']) 
        ? $reg_activity->formatInput($_POST['shipping_amount']) : 0;
    $payment_mode = isset($_POST['payment_mode']) 
        ? $reg_activity->formatInput($_POST['payment_mode']) : "Card Payment";
    $shipping_id = isset($_POST['shipping_id']) 
        ? $reg_activity->formatInput($_POST['shipping_id']) : 0;
    $voucher_code = isset($_POST['voucher_code']) 
        ? $reg_activity->formatInput($_POST['voucher_code']) : null;

    $reference_no = isset($_POST['reference_no']) 
        ? $reg_activity->formatInput($_POST['reference_no']) : null;
    $transaction_reference_no = isset($_POST['transaction_reference_no']) 
        ? $reg_activity->formatInput($_POST['transaction_reference_no']) : null;
    $amount_paid = isset($_POST['amount_paid']) 
        ? $reg_activity->formatInput($_POST['amount_paid']) : null;
    
    $get_request = json_encode($_POST);
    
    // Initialize report variables
    $reg_activity->setReportType("Placed Order");
    // set report values and create initial report
    require_once 'set-report-values.php';   

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");         

    if ((empty($payment_mode) || empty($shipping_id))) {
        throw new Exception("Some important values are empty. Please try and rectify");
    }
    if (!is_numeric($shipping_id)) {
        throw new Exception("Something went wrong. Please try again");
    }
        
    if (empty($transaction_id)) {
        throw new Exception("No device configuration IDs. Please contact admin");
    }
    if (empty($user_id) || empty($user_ses_id)){
        throw new Exception("Some important values are empty. Please try and rectify");
    }
    // if ($payment_mode != "Direct Transfer" and empty($transaction_reference_no)) {
    //     throw new Exception("Transaction reference no is required");
    // }
    // if ($payment_mode != "Direct Transfer" and empty($amount_paid)) {
    //     throw new Exception("Amount paid is required");
    // }
    
    //Checks if this request has been registered before
    $reg_activity->validateRequest();
    
    //Checks if the User exist as well as if the user is ban
    $reg_activity->validateUser();

    //Check if Session ID provided Matches with User ID
    $reg_activity->checkUser();

    $order = new Users\Orders();

    $users = new Users();
    $user = $users->getUser($user_id);
    if (!$user['data']) 
        throw new Exception("Unknown user");

    $email = $user['data']->email;

    $response = $order->createOrder($user_id, $user_ses_id, $shipping_amount, $payment_mode, $shipping_id, $email, $voucher_code);
    $order_id = $response['order_id'];
    $reference_no = $response['reference_no'];
    $response["code"] = md5($response['reference_no']);

    $message = "Your order has been created successfully. Proceed now to make payment";

    $reg_activity->setReportTypeId($order_id);
    $reg_activity->createSuccessReport();

    echo json_encode(array("message" => $message, "success" => true, "data" => $response), JSON_PRETTY_PRINT); 
    exit;       

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}