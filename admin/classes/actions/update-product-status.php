<?php
require_once 'required-files.php';

try {
    $ids = isset($_POST['ids']) 
        ? $reg_activity->formatInput($_POST['ids']): 0;
    $status = isset($_POST['status']) 
        ? $reg_activity->formatInput($_POST['status']): 0;

    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Updated Product Status");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required"); 

    if (empty($ids)) throw new Exception("Product ID(s) not found");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $updateStatus = new Products();

    $ids = explode(",", $ids);

    $no = 0;
    $response = array();
    foreach ($ids as $id) {
        if (!empty($id)) {
            $response = $updateStatus->updateProductStatus($id, $status, $employee_Details->first_name);
            $no++;
        }
    }

    if ($no <= 0) 
        throw new Exception("Operation failed");  
    
    $description = $employee_Details->first_name. " updated ".$no." product status from ".$response['from_status']." to ". $response['to_status'];
    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}