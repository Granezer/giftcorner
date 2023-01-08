<?php
require_once 'required-files.php';

try {
       
    //assign value to variables
    $id = isset($_POST['id']) 
        ? $reg_activity->formatInput($_POST['id']) : null;
    $name = isset($_POST['name']) 
        ? $reg_activity->formatInput($_POST['name']) : null;
    $price = isset($_POST['price']) 
        ? $reg_activity->formatInput($_POST['price']) : 0;
    $cost_price = isset($_POST['cost_price']) 
        ? $reg_activity->formatInput($_POST['cost_price']) : 0;
    $qty = isset($_POST['qty']) 
        ? $reg_activity->formatInput($_POST['qty']) : 0;
    $short_desc = isset($_POST['short_desc']) 
        ? $reg_activity->formatInput($_POST['short_desc']) : null;
    $description = isset($_POST['description']) 
        ? $reg_activity->formatInput($_POST['description']) : null;

    $product_off = isset($_POST['product_off']) 
        ? $reg_activity->formatInput($_POST['product_off']) : 0;
    $discount_start_date = isset($_POST['discount_start_date']) 
        ? $reg_activity->formatInput($_POST['discount_start_date']) : null;
    $discount_end_date = isset($_POST['discount_end_date']) 
        ? $reg_activity->formatInput($_POST['discount_end_date']) : null;
    $weight = isset($_POST['weight']) 
        ? $reg_activity->formatInput($_POST['weight']) : 1;
    $breadth = isset($_POST['breadth']) 
        ? $reg_activity->formatInput($_POST['breadth']) : 1;
    $length = isset($_POST['length']) 
        ? $reg_activity->formatInput($_POST['length']) : 1;
    $depth = isset($_POST['depth']) 
        ? $reg_activity->formatInput($_POST['depth']) : 1;

    // Get all POST data and assign to get_request variable
    $get_request = json_encode($_POST);

    // Initialize report variables
    $reg_activity->setReportType("Updated Product");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");    

    if (empty($name)) throw new Exception("Enter product name");
    if (empty($price)) throw new Exception("Enter price");
    if (empty($short_desc)) throw new Exception("Please enter short description");
    if (empty($description)) throw new Exception("Please enter description");
    if (empty($id)) throw new Exception("Product ID not found");

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee.php';

    if ($discount_start_date) $discount_start_date = date('Y-m-d H:i:s', strtotime($discount_start_date));
    if ($discount_end_date) $discount_end_date = date('Y-m-d H:i:s', strtotime($discount_end_date));
    // $path = "../../assets/media/products/";

    $employee = new Products();
    $response = $employee->editProduct($id, $name, $price, $description, $short_desc, $product_off, $discount_start_date, $discount_end_date, $weight, $breadth, $length, $depth, $user_ses_id);

    // Register request as successful
    $reg_activity->setReportTypeId($response['product_id']);

    $description = $employee_Details->first_name . " updated product of ID ".$response['product_id'];
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}