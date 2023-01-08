<?php  
require_once 'required-files.php';

try {
    //assign value to variables
    $description = isset($_POST['description']) ? 
        $reg_activity->formatInput($_POST['description']) : '';
    $ids = isset($_POST['ids']) ? 
        $reg_activity->formatInput($_POST['ids']) : '';
    $status = isset($_POST['status']) ? 
        $reg_activity->formatInput(ucwords($_POST['status'])) : null;

    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Updated Order Status");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required"); 

    if (empty($ids)) throw new Exception("No order selected");
    if (!in_array($status, array("Pending Pickup", "Pending Delivery", "Accepted", "Cancelled","Delivered"))) 
        throw new Exception("Invalid status");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $ids = explode(",", $ids);
    $id = $ids[0];

    $updateStatus = new Orders();
    $response = $updateStatus->updateOrderStatus($id, $status);
    $reference_no = $response['reference_no'];
    $description = $response['description'];

    $updateStatus->recordOrderOrPaymentStatusAction($reference_no, $description, $status, $employee_Details->first_name, 'order');
    if ($status == 'Cancelled') {
        $payment = new Payments();
        $response = $payment->getPaymentByReferenceNo($reference_no);
        if ($response['data']) 
            $payment->cancelPayment($response['data']->id);
    }

    // Register request as successful
    $description = $employee_Details->first_name. " updated order status of reference no (".$reference_no.")";
    $reg_activity->setReportTypeId($id);
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