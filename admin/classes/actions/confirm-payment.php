<?php
require_once 'required-files.php';

try {
    //assign value to variables
    $payment_id = isset($_POST['payment_id']) 
        ? $reg_activity->formatInput($_POST['payment_id']) : null;

    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Confirmed Payment");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    if(empty($payment_id)) {
        throw new Exception("No payment ID found"); 
    }

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $confirmPayment = new Payments();
    $response = $confirmPayment->confirmPayment($payment_id);
    $reference_no = $response['data']->reference_no;
    $order_id = $response['data']->order_id;
    $user_id = $response['data']->user_id;

    $description = $employee_Details->first_name . " confirmed payment for order with reference no (".$reference_no.")";
    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    $response['message'] = "Payment confirmed";

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}