<?php
session_start();

require_once 'constants.php';
require_once 'auto-load.php';

date_default_timezone_set($_SERVER['TIME_ZONE']);

$url_endpoint = $_SERVER['BASIC_URL'];
$site_title = $_SERVER['COM_TITLE'];

if(!isset($_SESSION['employee_id']) and !isset($_SESSION['user_ses_id'])) {
    $_SESSION['error'] = "Access denied! You must login properly";
    header("Location: ".$url_endpoint."login"); 
    exit;
}

$end_point = $url_endpoint . "admin/classes/actions/";

$remove_cache = rand(1234567, 9999999);

$images_ext = array('jpg','jpeg','png','gif');

$params = array(
    "transaction_id" => $remove_cache,
    "employee_id" => $_SESSION['employee_id'],
    "user_ses_id" => $_SESSION['user_ses_id']
);

if (isset($_SESSION["url"])) {
    $redirect_user = $_SESSION["url"];
    unset($_SESSION["url"]);
    header("Location: $redirect_user");
}

$redirectUserToThisUrl = after('/', $_SERVER['REQUEST_URI']);
$_SESSION["return_url"] = $redirectUserToThisUrl;

// $original_url = $redirectUserToThisUrl;
// $link = explode("/", $redirectUserToThisUrl);
// if (in_array("admin", $link)) {
//     $redirectUserToThisUrl = after('/', $redirectUserToThisUrl);
// }

$_SESSION['msg'] = 'Logged out successfully';
$_SESSION['l'] = 0;
$_SESSION['seconds'] = time() - $_SESSION['timestamp'];

if (isset($_SESSION['timestamp'])) {
    //subtract new timestamp from the old one
    if((time() - $_SESSION['timestamp']) > 1800) { 
        $_SESSION['msg'] = 'Your current session has expired after 30 minutes of inactivity!';
        $_SESSION['l'] = 1;
        $_SESSION["url"] = $url_endpoint.$redirectUserToThisUrl;     
    } else {
        $_SESSION['timestamp'] = time(); //set new timestamp
    }
}

$page_title = '';
$page_name = '';
$sql = '';
if (isset($_SESSION['success'])) {
    $sql = $_SESSION['success'];
} elseif (isset($_SESSION['error'])) {
    $sql = $_SESSION['error'];
} 
unset($_SESSION['success']);
unset($_SESSION['error']);

$reporting = null;

function after ($character, $url) {
    $url = ltrim($url, '/');
    if (!is_bool(strpos($url, $character)))
    return substr($url, strpos($url,$character)+strlen($character));
}

function formatDate ($date) {
    return date("l jS M, Y. g:iA", strtotime($date));
}

function formatDateOrTime ($date_or_time, $date = true) {
    if($date) return date("l jS M, Y", strtotime($date_or_time));

    return date("H:i", strtotime($date_or_time));
}

function dateConvertion($date) {
    $formatInput = 'Y-m-d'; //Give any format here, this would be converted into your format

    $formatOut = 'd/m/Y'; // Your format
    return DateTime::createFromFormat($formatInput, $date)->format($formatOut);
}

function getColor($no) {
    $value = '';
    if ($no >= 80) {
        $value = "success";
    } elseif ($no >= 70 && $no < 80) {
        $value = "purple";
    } elseif ($no >= 50 && $no < 70) {
        $value = "info";
    } elseif ($no >= 40 && $no < 50) {
        $value = "primary";
    } elseif ($no >= 30 && $no < 40) {
        $value = "warning";
    } elseif ($no >= 20 && $no < 30) {
        $value = "danger";
    } else {
        $value = "secondary";
    }

    return $value;
}

function getFileExt($file){
    $ext = pathinfo(
        parse_url($file, PHP_URL_PATH), 
        PATHINFO_EXTENSION
    );

    return $ext;
}