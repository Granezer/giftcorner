<?php
require_once 'required-files.php';

try {
    $status = isset($_POST['status']) 
        ? $reg_activity->formatInput($_POST['status']) : 0;

    $id = isset($_GET['id']) 
        ? $reg_activity->formatInput($_GET['id']): 0;
    $user_id = isset($_GET['user_id']) 
        ? $reg_activity->formatInput($_GET['user_id']): 0;
    $order_no = isset($_GET['order_no']) 
        ? $reg_activity->formatInput($_GET['order_no']): 0;

    $get_request = json_encode($_GET);

    // Initialize report variables
    $reg_activity->setReportType("Retrieved User Payments");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required"); 

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee2.php';

    require_once 'pagination.php';
    
    $getPayments = new Payments();
    $response = array();
    if ($id) {
        $response = $getPayments->getPayment($id);
    } elseif ($order_no) {
        $response = $getPayments->getPaymentByReferenceNo($order_no);
    } else {
        $response = $getPayments->getPayments($pagination, $sort, $query, $_REQUEST, $user_id);
    }
    
    $description = $employee_Details->first_name . " retrieved user payments";
    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}