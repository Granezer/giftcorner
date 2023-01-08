<?php
require_once 'headers.php';

if($_SERVER['REQUEST_METHOD']=='POST') {
   
    require_once 'require_files.php';
    $reg_activity = new UserLogs();
    
    try {

        require_once 'client-request.php';

        $_POST = array_merge($_POST, $client_request_json);

        //assign value to variables
        $user_id = isset($_POST['user_id']) 
            ? $reg_activity->formatInput($_POST['user_id']) : '';
        $user_ses_id = isset($_POST['user_ses_id']) 
            ? $reg_activity->formatInput($_POST['user_ses_id']) : '';
        $transaction_id = isset($_POST['transaction_id']) 
            ? $reg_activity->formatInput($_POST['transaction_id']) : null;
        $id = isset($_POST['id']) 
            ? $reg_activity->formatInput($_POST['id']) : 0;
        
        $get_request = implode(', ', array_map(
            function ($v, $k) { return sprintf("%s=>'%s'", $k, $v); },
            $_POST,
            array_keys($_POST)
        ));

        $reg_activity->setReportType("Shipping Address");
        $reg_activity->setTransactionId($transaction_id);
        $reg_activity->setUserId($user_id);
        $reg_activity->setGetRequest($get_request);
        $reg_activity->setState();
        $reg_activity->setUserSessionId($user_ses_id);

        $reg_activity->createInitialReport();        

        if (empty($transaction_id)){
            throw new Exception("No device configuration IDs. Please contact admin");
        }
        if ($user_id) {
            if (empty($user_ses_id))
                throw new Exception("Some important values are empty. Please try and rectify");
        } else {
            $reg_activity->setState($web);
        }
        
        //Checks if this request has been registered before
        $reg_activity->validateRequest();
        
        //check if request is from web version
        if ($user_id) { 
            //Checks if the User exist as well as if the user is ban
            $reg_activity->validateUser();

            //Check if Session ID provided Matches with User ID
            $reg_activity->checkUser();
        }

        $shipping = new Shipping();

        $response = array();
        if($id > 0) $response = $shipping->getShippingAddress($id);
        else $response = $shipping->getShippingAddresses($user_id);

        $reg_activity->setReportTypeId(0);
        $reg_activity->createSuccessReport();

        echo json_encode(array("message" => "success", "success" => true, "data"=>$response), JSON_PRETTY_PRINT);

    }
    catch(Exception $error) {
        $reg_activity->setDescription($error->getMessage());
        $reg_activity->createErrorReport();
        echo json_encode(array('message' => $error->getMessage(), 'success' => false));
    }
}