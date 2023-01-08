<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Pragma, Authorization, Accept, X-Auth-Token, x-xsrf-token');

header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/../../auto-load.php';

$version_no = null;
$web = "web";
$web_version = null;

$reg_activity = new LogActivity();
$reg_activity->setVersion(null);
$reg_activity->setOldVersion(null);

$transaction_id = isset($_SESSION['transaction_id'])?$_SESSION['transaction_id']:'';

$_POST['employee_id'] = isset($_SESSION['employee_id']) ? $_SESSION['employee_id'] : '';
$_POST['user_ses_id'] = isset($_SESSION['user_ses_id']) ? $_SESSION['user_ses_id'] : '';

if (isset($_GET['employee_id'])) {
	$transaction_id = isset($_GET['transaction_id'])?$_GET['transaction_id']:'';
	$_POST['employee_id'] = isset($_GET['employee_id']) ? $_GET['employee_id'] : '';
	$_POST['user_ses_id'] = isset($_GET['user_ses_id']) ? $_GET['user_ses_id'] : '';
}

unset($_SESSION["success"]);
unset($_SESSION["error"]);

$user_ses_id = $_POST['user_ses_id']; 
$employee_id = $_POST['employee_id'];
$transaction_id = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : $transaction_id;

if (isset($_GET['id'])) {
	$_POST['id'] = $_GET['id'];
	$_POST['type']= isset($_GET['pageName']) ? $_GET['pageName'] : null;
}
$type = isset($_POST['type']) ? $_POST['type'] : '';
$urlRedirect = '';
$comp_title = "Giftcorner NG";