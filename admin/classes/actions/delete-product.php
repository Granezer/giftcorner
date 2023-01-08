<?php
require_once 'required-files.php';

try {
    $ids = isset($_POST['ids']) 
        ? $reg_activity->formatInput($_POST['ids']): 0;

    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Deleted Product");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required"); 

    if (empty($ids)) throw new Exception("Product ID not found");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    $delete = new Products();

    $ids = explode(",", $ids);

    $no = 0;
    $response = $products = array();
    foreach ($ids as $id) {
        if (!empty($id)) {
            $response = $delete->deleteProduct($id);
            unset($response['success']);
            unset($response['message']);
            array_push($products, $response);
            $no++;
        }
    }

    if ($no <= 0) 
        throw new Exception("Operation failed");  
    
    $products = json_encode($products);
    $description = $employee_Details->first_name. " deleted ".$no." product(s) (".$products.")";
    $reg_activity->setReportTypeId(0);
    $reg_activity->createSuccessReport($description); 

    $response['message'] = $no." product(s) deleted successfully";
    $response['success'] = true;
    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}