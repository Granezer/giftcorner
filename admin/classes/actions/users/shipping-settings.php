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
    $id = isset($_POST['id']) 
        ? $reg_activity->formatInput($_POST['id']) : 0;
    $type = isset($_POST['type']) 
        ? ucfirst($reg_activity->formatInput($_POST['type'])) : 0;

    $first_name = isset($_POST['first_name']) 
        ? ucfirst($reg_activity->formatInput($_POST['first_name'])) : null;
    $last_name = isset($_POST['last_name']) 
        ? ucfirst($reg_activity->formatInput($_POST['last_name'])) : null;
    $company_name = isset($_POST['company_name']) 
        ? ucfirst($reg_activity->formatInput($_POST['company_name'])) : null;
    $country = isset($_POST['country']) 
        ? ucfirst($reg_activity->formatInput($_POST['country'])) : null;
    $state = isset($_POST['state']) 
        ? ucfirst($reg_activity->formatInput($_POST['state'])) : null;
    $city = isset($_POST['city']) 
        ? ucfirst($reg_activity->formatInput($_POST['city'])) : null;
    $address = isset($_POST['address']) 
        ? ucfirst($reg_activity->formatInput($_POST['address'])) : null;
    $postcode = isset($_POST['postcode']) 
        ? $reg_activity->formatInput($_POST['postcode']) : null;
    $email = isset($_POST['email']) 
        ? $reg_activity->formatInput($_POST['email']) : null;
    $phone = isset($_POST['phone']) 
        ? $reg_activity->formatInput($_POST['phone']) : null;
    
    $get_request = json_encode($_POST);
    
    // Initialize report variables
    $reg_activity->setReportType($type." Shipping Address");
    // set report values and create initial report
    require_once 'set-report-values.php';   

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");        

    if (!in_array($type, array('Created','Edited','Deleted'))){
        throw new Exception("Invalid type");
    }
    if ($type != 'Deleted') { 
        if (empty($first_name) || empty($last_name) || empty($address) 
            || empty($phone) || empty($state) || empty($city)) {
            throw new Exception("Some shipping info are empty. Please try and rectify");
        }
    }

    if (empty($transaction_id)){
        throw new Exception("No device configuration IDs. Please contact admin");
    }
    if (empty($user_id) || empty($user_ses_id)) {
        throw new Exception("Login details are missing. Please try and rectify");
    }
    
    //Checks if this request has been registered before
    $reg_activity->validateRequest();

    //Checks if the User exist as well as if the user is ban
    $reg_activity->validateUser();

    //Check if Session ID provided Matches with User ID
    $reg_activity->checkUser();
    
    $shipping = new Users\Shipping();

    $result = 0;
    switch ($type) {
        case 'Created':
            $id = $shipping->setShippingAddress($user_id, $first_name, $last_name, $company_name, $country, $state, $city, $address, $postcode, $email, $phone);
            break;
        case 'Edited':
            if ($id <= 0) throw new Exception("No Shipping ID found");
            $result = $shipping->editShippingAddress($user_id, $id, $first_name, $last_name, $company_name, 
                $country, $state, $city, $address, $postcode, $email, $phone);
            break;
        case 'Deleted':
            if ($id <= 0) throw new Exception("No Shipping ID found");
            $result = $shipping->deleteShippingAddress($user_id, $id);
            break;
        default:
            throw new Exception("Invalid type");
            break;
    }

    $reg_activity->setReportTypeId($id);
    $reg_activity->createSuccessReport();

    echo json_encode(array("id"=>$id,"message" => "operation was successful", "success" => true), JSON_PRETTY_PRINT);
    
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}