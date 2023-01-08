<?php
 require_once 'required-files.php';
 
try {

    //Assign values to variables    
    $new_password = isset($_POST['new_password']) 
        ? $reg_activity->formatInput($_POST['new_password']) : null; 
    $current_password = isset($_POST['current_password']) 
        ? $reg_activity->formatInput($_POST['current_password']) : null; 

    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Reset Password");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required 400"); 
    
    // confirm username and password isn't empty
    if (empty($new_password)) throw new Exception("Please enter new password 417");
    if (empty($current_password)) throw new Exception("Please enter current password 417");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $name = $employee_Details->first_name;
    $email = $employee_Details->email;
    
    //reset user password
    $resetPassword = new ResetPassword();

    if (!$resetPassword->changePassword($employee_id, $current_password, $new_password)) 
        throw new Exception("Error: an error has occurred. Try again 503");

    $emailInstance = new Email();
    $emailDetails = $emailInstance->getEmailTemplateByType("change of password");
    if ($emailDetails) {
        $title = $emailDetails->title;
        $content = $emailDetails->content;
        $from = $emailDetails->from_email;

        $content = str_replace("{email}", $email, $content);
        $content = str_replace("{password}", $new_password, $content);
        $content = str_replace("{date}",date("l jS M, Y g:iA"),$content);
        $subject = $comp_title." Password Changed";
        $emailInstance->sendHTMLEmail($from, $email, $subject, $content, $title, $name);
    }

    $report_type_id = $employee_id;
    $msg = "Your password has been changed successfully.";
    $description = $employee_Details->first_name." changed password";
    $response = array('message'=>$msg, 'success'=>true);

    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}