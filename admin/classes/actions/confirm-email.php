<?php

require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    try {

        //assign value to variables
        $code = isset($_POST['code']) ? $logs->formatInput($_POST['code']) : null;

        $get_request = implode(', ', array_map(
            function ($v, $k) { return sprintf("%s=>'%s'", $k, $v); },
            $_POST,
            array_keys($_POST)
        ));
        
        $logs->setReportType("Confirmed Email Address");
        require_once "set-report-values.php";

        if (empty($code)){
            throw new Exception("Error: Verification code is required");
        }

        $library = new Library();
        $response = $library->verifyCode($user_id, $code, $type = 'email');
        
        $member = new Members();
        $member->setUserId($user_id);
        $response = $member->confirmEmail(); 

        $library->updateCode($user_id, $type = 'email');      

        $logs->setReportTypeId($user_id);
        $logs->createSuccessReport();
        
        $_SESSION["email_status"] = 1;
        $_SESSION["success"] = "Email confirmed successfully";  //return error message
        header("Location: ../../dashboard");
         
    } catch(Exception $error) {
        $logs->setDescription($error->getMessage());
        $logs->createErrorReport();
        $_SESSION["error"] = $error->getMessage();
        header("Location: ../../confirm-email");
    }

}