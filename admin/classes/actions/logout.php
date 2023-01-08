<?php

require_once 'required-files.php';

try {
 
    //Assign values to variables    
    $login_id = $_SESSION['login_id'];

    $_POST['login_id'] = $login_id;

    $msg = "Logged out successfully";
    if (isset($_GET['msg'])) {
        $_POST['msg'] = $_GET['msg'];
        $msg = $_GET['msg'];
    }

    $get_request = json_encode($_POST);

    $reg_activity->setReportType("Logged Out");
    require_once "set-report-values.php";
    $reg_activity->setState('logout');        

    //Checks if this request has been registered before
    $reg_activity->validateRequest();
  
    //send users details to loginUsers function in login.php for processing 
    $logout = new Logout();
    $response = $logout->logoutSession($employee_id, $user_ses_id);

    $reg_activity->setReportTypeId($login_id);
    $description = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : null;
    $description = isset($description) ? $description ." logged out" : null;
    $reg_activity->createSuccessReport($description);

    setcookie("employee_id", null, -1, '/');
    setcookie("user_ses_id", null, -1, '/');

    $url = 0;
    $auto_logout = false;
    // if ($msg != "Logged out successfully") {
    //     $url = isset($_SESSION["url"]) ? $_SESSION["url"] : null;
    //     $auto_logout = true;
    // }
    
    unset($_SESSION['profile_image']);
    unset($_SESSION['first_name']);
    unset($_SESSION['last_name']);
    unset($_SESSION['email']);
    unset($_SESSION['login_id']);
    unset($_SESSION['employee_type']);
    unset($_SESSION['employee_id']);
    unset($_SESSION['user_ses_id']);
    unset($_SESSION['timestamp']);

    $_SESSION["error"] = $msg; 
    // $_SESSION["url"] = $url; 
    
    echo json_encode(array("success" => true, "message" => $msg, "auto_logout" => $auto_logout));

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    $_SESSION["error"] = $error->getMessage();
    echo json_encode(array("success" => false, "message" => $error->getMessage()));
}