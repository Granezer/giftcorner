<?php
require_once '../required-files.php';
$reg_activity = new LogActivity();

try {
    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'GET') 
        throw new Exception("Bad request. GET method required"); 

    $role_id = isset($_GET['role_id']) ? $reg_activity->formatInput($_GET['role_id']) : 0;
    $module_name = isset($_GET['module_name']) 
        ? $reg_activity->formatInput($_GET['module_name']) : 0; 
    $module_permission_name = isset($_GET['module_permission_name']) 
        ? $reg_activity->formatInput($_GET['module_permission_name']) : 0;

    if (empty($role_id))
        throw new Exception("Role ID not found");
    if (empty($module_name))
        throw new Exception("Module access not found");
    if (empty($module_permission_name))
        throw new Exception("Module permission not found");

    $roles = new Settings\Roles();
    $response = $roles->grantAccessToEmployee($role_id, $module_name, $module_permission_name);

    echo json_encode($response, JSON_PRETTY_PRINT);
        
} catch(Exception $error) {
    echo json_encode(array('message' => $error->getMessage(), 'success' => false));
}