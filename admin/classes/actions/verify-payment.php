<?php
require_once 'required-files.php';

try {
    $reference = isset($_POST['reference']) 
        ? $reg_activity->formatInput($_POST['reference']) : null;

    // Valid request method
    if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        throw new Exception("Bad request. POST method required");

    $result = array();

    $paystack = new Users\Paystack();
    $result = $paystack->verifyTransaction($reference);

	if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
		echo json_encode(array("success"=>true, "data"=>$result['data']), JSON_PRETTY_PRINT);
		exit;
	}
	
	throw new Exception("Transaction was unsuccessful");

} catch(Exception $error) {
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}