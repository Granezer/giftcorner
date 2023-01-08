<?php
require_once 'required-files.php';

try {
    //assign value to variables
    $description = isset($_POST['description']) ? 
        $reg_activity->formatInput($_POST['description']) : '';
    $reference_no = isset($_POST['reference_no']) ? 
        $reg_activity->formatInput($_POST['reference_no']) : '';
    $status = isset($_POST['status']) ? 
        $reg_activity->formatInput($_POST['status']) : null;

    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Updated Payment Status");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required"); 

    if (empty($reference_no)) throw new Exception("Reference no is empty");
    if (empty($status)) throw new Exception("No status found");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $updateStatus = new Payments();
    $response = $updateStatus->updatePaymentStatus($reference_no, $status);

    $order = new Orders();
    $order->recordOrderOrPaymentStatusAction($reference_no, $description, $status, $name, 'payment');

    // Register request as successful
    $description = $employee_Details->first_name. " updated payment status for an order with reference no (".$reference_no.")";
    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    echo json_encode(
        array(
            'message' => 'operation was successfull',
            'success'=>true
        ), JSON_PRETTY_PRINT
    );

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}