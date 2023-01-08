<?php
$user_id  = isset($_GET["user_id"]) ? $_GET["user_id"] : 0;

if (empty($user_id)) {
	exit("Error processing...");
}

$page = 'get-users.php?';
$title = 'User';

$params = http_build_query($params);


$response = file_get_contents($end_point . $page . $params."&id=".$user_id);
$response = json_decode($response, true);

if (!$response['success']) {
	exit("Error processing...");
}
$response = $response['data'];
// echo json_encode($response); exit;