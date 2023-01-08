<?php
require_once 'required-files.php';

try {

    $getStats = new Orders();
    $response = $getStats->getOrderStatistics();

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $error) {
    echo json_encode(array('message' => $error->getMessage(), 'success'=>false));
}