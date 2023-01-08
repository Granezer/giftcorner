<?php
require_once 'required-files.php';

try {
    $id = isset($_GET['id']) ? $reg_activity->formatInput($_GET['id']): 0;
    $status = isset($_GET['status']) 
        ? $reg_activity->formatInput($_GET['status']): 100;

    $get_request = json_encode($_REQUEST);

    // Initialize report variables
    $reg_activity->setReportType("Retrieved Products");
    // set report values and create initial report
    require_once 'set-report-values.php'; 

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required"); 

    // Checks if this request has been registered before and validate admin
    require_once 'validate-employee2.php';

    $getProducts = new Products();

    require_once 'pagination.php';

    $description = $employee_Details->first_name;
    $response = array();

    if ($id) {
        $response = $getProducts->getProduct($id);
        if ($response['data']) 
            $description .= " retrieved product (".$response['data']->name.")";
        else $description .= " tried to retrieved unkwon product";
    } else {
        $description .= " retrieved products";
        $response = $getProducts->getProducts($pagination, $sort, $query, $_REQUEST, $status);
    }

    $reg_activity->setReportTypeId($id);
    $reg_activity->createSuccessReport($description); 

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    $reg_activity->setDescription($error->getMessage());
    $reg_activity->createErrorReport();
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}