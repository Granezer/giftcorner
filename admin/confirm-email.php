<?php
session_start();

if (!isset($_GET['confirmation_id'])) {
	header("Location: index");
	exit();
}

$confirmation_id = $_GET['confirmation_id'];
$transaction_id = rand(123456789, 999999999);

$params = array(
	"confirmation_id": $confirmation_id,
	"transaction_id": $transaction_id
);

$params = http_build_query($params);

$endPoint= "https://dstesting.com.ng/engine/mobile/actions/confirm-email.php?".$page;
$endPoint2="http://localhost/test-aws/engine/mobile/actions/confirm-email.php?".$page;

$response = json_decode(file_get_contents($endPoint), true);

$page = "";
if ($response['success']) {
	$page = "../email-confirmed";
	$_SESSION['success'] = $response['message'];
} else {
	$page = "../email-confirmation-failed.php";
	$_SESSION['error'] = $response['message'];
}

header("Location: ".$page);
exit;