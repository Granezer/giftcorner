<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Pragma, Authorization, Accept, X-Auth-Token, x-xsrf-token');

header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/../../../auto-load.php';

$version_no = null;
$web = "web";
$web_version = null;

$reg_activity = new Users\UserLogs();

$transaction_id = isset($_SESSION['transaction_id'])?$_SESSION['transaction_id']:'';

$_POST['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$_POST['user_ses_id'] = isset($_SESSION['user_ses_id']) ? $_SESSION['user_ses_id'] : '';

if (isset($_GET['user_id'])) {
	$transaction_id = isset($_GET['transaction_id'])?$_GET['transaction_id']:'';
	$_POST['user_id'] = isset($_GET['user_id']) ? $_GET['user_id'] : '';
	$_POST['user_ses_id'] = isset($_GET['user_ses_id']) ? $_GET['user_ses_id'] : '';
}

unset($_SESSION["success"]);
unset($_SESSION["error"]);

$user_ses_id = $_POST['user_ses_id']; 
$user_id = $_POST['user_id'];
$transaction_id = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : $transaction_id;

if (isset($_GET['id'])) {
	$_POST['id'] = $_GET['id'];
	$_POST['type']= isset($_GET['pageName']) ? $_GET['pageName'] : null;
}
$type = isset($_POST['type']) ? $_POST['type'] : '';
$urlRedirect = '';

if (isset($_SESSION["device_id"])) { 
    $_COOKIE["device_id"] = $_SESSION['device_id'];
    $_COOKIE["device_name"] = $_SESSION['device_name'];  
}