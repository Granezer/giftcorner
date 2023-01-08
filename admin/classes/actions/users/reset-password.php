<?php
 require_once 'require_files.php';
 
try {

    //Assign values to variables    
    $email = isset($_SESSION['email']) 
        ? $reg_activity->formatInput($_SESSION['email']) : null;
    $password = isset($_POST['password']) 
        ? $reg_activity->formatInput($_POST['password']) : null; 
    $code = isset($_POST['code']) 
        ? $reg_activity->formatInput($_POST['code']) : null; 
    $confirm_password = isset($_POST['confirm_password']) 
        ? $reg_activity->formatInput($_POST['confirm_password']) : null; 

    $_POST['email'] = $email;
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Reset Password");
    $reg_activity->setTransactionId($transaction_id);
    $reg_activity->setUserId(0);
    $reg_activity->setGetRequest($get_request);
    $reg_activity->setState();
    $reg_activity->setUserSessionId(0);
    $reg_activity->createInitialReport(); 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required 400"); 
    
    // confirm username and password isn't empty
    if (empty($email)) throw new Exception("Error: Email can not be empty 417");
    if (empty($code)) throw new Exception("Error: Reset code can not be empty 417");
    if (empty($password)) throw new Exception("Error: Password can not be empty 417");

    if ($password != $confirm_password)
        throw new Exception("Error: Password not match 417");

    if (empty($transaction_id)) 
        throw new Exception("Error: Transaction Id can not be empty 417");

    //Checks if this request has been registered before
    $reg_activity->validateRequest();
    
    $checkEmail = new Users();
    $response = $checkEmail->getUserByEmail($email);
    if (!$response['data']) 
        throw new Exception("$email does not exist in our database 417");

    $response = $response['data'];
    $name = explode(' ', $response->fullname);
    $name = $name[0];
    
    //reset user password
    $resetPassword = new Users\ChangePassword();

    if ($resetPassword->resetPassword($email, $password, $code)) {

        $emailInstance = new Email();
        $emailDetails = $emailInstance->getEmailTemplateByType("change of password");
        if ($emailDetails) {

            $title = $emailDetails->title;
            $content = $emailDetails->content;
            $from = $emailDetails->from_email;

            $content = str_replace("{email}", $email, $content);
            $content = str_replace("{password}", $password, $content);
            $content = str_replace("{date}",date("l jS M, Y g:iA"),$content);
            $subject = "Password Changed";
            $emailInstance->sendHTMLEmail($from, $email, $subject, $content, $title, $name);
        }

        $description = $name."just reset his/her password";
        $reg_activity->setState('forgot password');
        $reg_activity->setReportTypeId(0);
        $reg_activity->setDescription($description);
        $reg_activity->createSuccessReport();
        $msg = "Your password has been changed successfully.";
        unset($_SESSION['email']);
        echo json_encode(array('message'=>$msg, 'success'=>true), JSON_PRETTY_PRINT);
        exit;
    }

    throw new Exception("Error: an error has occurred. Try again");

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}