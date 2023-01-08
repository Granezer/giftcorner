<?php
session_start();
// session_destroy();
require_once 'constants.php';

require_once 'auto-load.php';
// echo $_SESSION['employee_id']; exit;
$libraryInstance = new Library();

if(isset($_SESSION['employee_id']) and isset($_SESSION['user_ses_id'])) {
	if (isset($_SESSION['employee_type'])) {
		header("Location: dashboard"); 
	} else {
		unset($_SESSION['employee_id']);
		unset($_SESSION['user_ses_id']);
	}
}

$site_title = $_SERVER['COM_TITLE'];

if (!isset($_COOKIE['device_id'])) { 
    $device = $libraryInstance->generateDeviceIdAndName();   
    setcookie("device_id", $device['device_id'], $device['current_time'] + 120000, '/');
    setcookie("device_name", $device['device_name'], $device['current_time'] + 120000, '/');
}
$_SESSION['transaction_id'] = $libraryInstance->generateTransactionId();
